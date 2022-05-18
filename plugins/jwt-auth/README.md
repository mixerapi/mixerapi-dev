# MixerApi JwtAuth

[![Latest Version on Packagist](https://img.shields.io/packagist/v/mixerapi/jwt-auth.svg?style=flat-square)](https://packagist.org/packages/mixerapi/jwt-auth)
[![Build](https://github.com/mixerapi/mixerapi-dev/workflows/Build/badge.svg?branch=master)](https://github.com/mixerapi/mixerapi-dev/actions?query=workflow%3ABuild)
[![Coverage Status](https://coveralls.io/repos/github/mixerapi/mixerapi-dev/badge.svg?branch=master)](https://coveralls.io/github/mixerapi/mixerapi-dev?branch=master)
[![MixerApi](https://mixerapi.com/assets/img/mixer-api-red.svg)](https://mixerapi.com)
[![CakePHP](https://img.shields.io/badge/cakephp-^4.2-red?logo=cakephp)](https://book.cakephp.org/4/en/index.html)
[![Minimum PHP Version](https://img.shields.io/badge/php-^8.0-8892BF.svg?logo=php)](https://php.net/)

A [JWT](https://datatracker.ietf.org/doc/html/rfc7519) authentication library for CakePHP supporting both HMAC
(HS256 or HS512) and RSA (RS256 or RS512) with JSON Web Keys. Before starting, you should determine which
[signing algorithm](https://stackoverflow.com/questions/39239051/rs256-vs-hs256-whats-the-difference) best fits your
needs. It is the goal of this library to make both easy.

- [Installation](#installation)
- [Defining Your JWT](#defining-your-jwt)
- [JSON Web Keys](#json-web-keys)
- [Login Controller](#login-controller)
- [Security](#Security)

For an alternative approach see [admad/cakephp-jwt-auth](https://github.com/ADmad/cakephp-jwt-auth).

## Installation

You can install this plugin into your CakePHP application using [composer](https://getcomposer.org).

```console
composer require mixerapi/jwt-auth
```

And then load the plugin

```console
bin/cake plugin load MixerApi/JwtAuth
```

### Configuration

Next [create a config file](assets/mixerapi_jwtauth.php) (e.g. `config/mixerapi_jwtauth.php`) and load it into your
application.

```php
# in config/bootstrap.php
Configure::load('mixerapi_jwtauth');
```

- `alg` string is required and must be either HS256, HS512, RS256, or RS512.
- `secret` is required when using HMAC. The secret should not be committed to your VCS and be at least 32 characters.
- `keys` array is required when using RSA. The keys should not be committed to your VCS and be at least 2048 bits long.

Read the [example configuration file](assets/mixerapi_jwtauth.php) for more detailed explanations.

### Service Provider

Using the `JwtAuthServiceProvider` is recommended to inject dependencies automatically.

```php
# in src/Application.php

public function services(ContainerInterface $container): void
{
    /** @var \League\Container\Container $container */
    $container->addServiceProvider(new \MixerApi\JwtAuth\JwtAuthServiceProvider());
}
```

### Authentication

You will need to configure [CakePHP Authentication](https://book.cakephp.org/authentication/2/en/index.html) to
use this library. There are several ways to do this documented in the quick start. See the
[mixerapi demo](https://github.com/mixerapi/demo) for an exampe.

Be sure to load the
[CakePHP Authentication.Component](https://book.cakephp.org/authentication/2/en/authentication-component.html)
(generally in your AppController).

## Defining your JWT

On your User entity implement `JwtEntityInterface`. This will be used to generate the JWT, example:

```php
namespace App\Model\Entity;

use Cake\ORM\Entity;
use MixerApi\JwtAuth\Jwt\Jwt;
use MixerApi\JwtAuth\Jwt\JwtEntityInterface;
use MixerApi\JwtAuth\Jwt\JwtInterface;

class User extends Entity implements JwtEntityInterface
{
    /**
     * @inheritDoc
     */
    public function getJwt(): JwtInterface
    {
        return new Jwt(
            exp: time() + 60 * 60 * 24,
            sub: $this->get('id'),
            iss: 'mixerapi',
            aud: 'mixerapi-client',
            nbf: null,
            iat: time(),
            jti: \Cake\Utility\Text::uuid(),
            claims: [
                'user' => [
                    'email' => $this->get('email')
                ]
            ]
        );
    }
}
```

## JSON Web Keys

Signing your tokens with RSA uses a public/private key pair. You can skip this section if you are using HMAC.

### Building Keys

We'll store the keys in `config/keys/1/` but you can store these anywhere. Keys should not be stored in version
control, example:

```console
openssl genrsa -out config/keys/1/private.pem 2048
openssl rsa -in config/keys/1/private.pem -out config/keys/1/public.pem -pubout
```

Add the generated keys to your config:

```php
# in config/mixerapi_jwtauth.php

return [
    'MixerApi.JwtAuth' => [
        'alg' => 'RS256',
        'keys' => [
            [
                'kid' => '1',
                'public' => file_get_contents(CONFIG . 'keys' . DS . '1' . DS . 'public.pem'),
                'private' => file_get_contents(CONFIG . 'keys' . DS . '1' . DS . 'private.pem'),
            ]
        ]
    ]
];
```

### JWK Set Controller

Read more about [JSON Web Keys here](https://datatracker.ietf.org/doc/html/rfc7517). Let's create an endpoint to
expose your JWK Set.

```php
use Cake\Controller\Controller;
use Cake\Event\EventInterface;
use MixerApi\JwtAuth\Jwk\JwkSetInterface;

class JwksController extends Controller
{
    public function beforeFilter(EventInterface $event)
    {
        parent::beforeFilter($event);
        $this->Authentication->allowUnauthenticated(['index']);
    }

    public function index(JwkSetInterface $jwkSet)
    {
        $this->set('data', $jwkSet->getKeySet());
        $this->viewBuilder()->setOption('serialize', 'data');
    }
}
```

Add a route to your controller in your `config/routes.php` file.

Example response:

```json
{
  "keys": [
    {
      "kty": "RSA",
      "use": "sig",
      "alg": "RS256",
      "kid": "1",
      "n": "wk865HbUKadJU-Mh-Iv2Z_30ZOMclkK1cbuiTVkINy_R9oHoAht2DS788q_Sll38dtTB4bzptd0u6k4cJd6Lj6nVQTe1uRyuAU47tqitiJmEXX_2SHIRv6aj4vygIfqr1FtQMHPlBW7r4q840H5mh_Z-E_a7d27QbtJ3eYNEiFow6LLvl17_7bdaenlwccY0j-PY1GzL7UwG8uHBZ78ZOcvu_GgaYC5suRrJrV_6_Qu6lySXObDaajr6Foz0m-z4Aj7KA8KmAiM_Rw_Yqm_KqPT3YBGj83TxeEiMPkrMYry123hFQYm09EO2Az9lGjr-PQc6SR08SDqZ3zbwe9iam55dzVZ-vQF3ASnZpBHyIDhCI7PFShceFI1Sv0RW7-Tl0uM2jQa1RyEpFle1xc0RxSFZium0aGMnFuE2W9JDERPw47wFZx2kSk1nB6PDK6XPLJLi_db0VrP5m5z2HDWeYVmsuAVFm6-l1PjiGH4G1TpuYfPKP2P8K-kveo1Ddm14IJSWfcACeAF_gx644Ua_IJ8wS98dQqE-R-jzfEv7aLBacP5_thCUbHfCRrAgtM5lBAM_1tfQ4XsOLnFWkl4arm3TzN2wCjjuqxipgwpUtY_SN6SXhJW4MW2qHVKtHtXl9haF5gEDBL7twDsFozYZCc5k0d85EgfJ5Jn7ZSAgwXk",
      "e": "AQAB"
    }
  ]
}
```

You may add/remove keys to your `MixerApi.JwtAuth.keys` config as part of your key rotation strategy.

Note, if you are not using dependency injection:

```php
    public function index()
    {
        $this->set('data', (new JwkSet)->getKeySet());
        $this->viewBuilder()->setOption('serialize', 'data');
    }
```

## Login Controller

In the example below we'll authenticate, create the JWT we defined earlier and return it to the requester.

```php
use Cake\Controller\Controller;
use MixerApi\JwtAuth\JwtAuthenticatorInterface;

public function LoginController extends Controller
{
    public function beforeFilter(EventInterface $event)
    {
        parent::beforeFilter($event);
        $this->Authentication->allowUnauthenticated(['login']);
    }

    public function login(JwtAuthenticatorInterface $jwtAuth)
    {
        try {
            return $this->response->withStringBody($jwtAuth->authenticate($this->Authentication));
        } catch (UnauthenticatedException $e) {
            return $this->response->withStringBody($e->getMessage())->withStatus(401);
        }
    }
}
```

Add a route to the controller in your `config/routes.php` file.

This will build the JWT we defined earlier in the User Entity.

```json
{
  "iss": "mixerapi",
  "sub": "5e28e9ed-f3e1-4eb2-aa88-8d618f4021ee",
  "aud": "api-client",
  "exp": 1651972707,
  "jti": "a1f6f5ec-748d-4a1c-9d0e-f8e19ec7f9b2",
  "user": {
    "email": "test@example.com"
  }
}
```

Note, if you're not using dependency injection:

```php
    public function login()
    {
        try {
            return $this->response->withStringBody(
                (new \MixerApi\JwtAuth\JwtAuthenticator)->authenticate($this->Authentication)
            );
        } catch (UnauthenticatedException $e) {
            return $this->response->withStringBody($e->getMessage())->withStatus(401);
        }
    }
```

Or, if you prefer to handle the authentication yourself you may pass an instance of `JwtInterface` instead, example:

```php
    public function login(JwtAuthenticatorInterface $jwtAuth)
    {
        try {
            $result = $this->Authentication->getResult();
            if (!$result->isValid()) {
                throw new UnauthenticatedException();
            }
            return $this->response->withStringBody($jwtAuth->authenticate($result->getData()->getJwt()));
        } catch (UnauthenticatedException $e) {
            return $this->response->withStringBody($e->getMessage())->withStatus(401);
        }
    }
```

## Security

Some security measures are baked into this library:

#### Weak HMAC secrets

JWT signed with HMAC can be brute forced with a tool like [JWT Tool](https://github.com/ticarpi/jwt_tool). Once cracked
the JWT can be altered. This library mitigates this by requiring a minimum secret length of 32 characters though you
may want to consider using 64 characters if security is more important than speed and token size. Generating a strong
random secret and securing it is up to you.

You can generate a strong secret using a tool like `openssl`:

```console
openssl rand -base64 32
```

Or `gpg`:

```console
gpg --gen-random 1 32 | base64
```

#### Weak RSA Keys

Weak keys can be cracked as well. This library requires a minimum key length of 2048 bits. You may want to consider
a key length of 4096 bits depending on your security requirements. Securing your keys is up to you.

#### Alg None Bypass

The alg=none signature-bypass vulnerability is mitigated by requiring a single valid algorithm. Additional protection
exists within the [firebase/php-jwt](https://github.com/firebase/php-jwt) library which should be kept up to date.

#### RS/HS256 public key mismatch vulnerability

Mitigated by requiring a single valid algorithm. Additional protection exists within the
[firebase/php-jwt](https://github.com/firebase/php-jwt) library which should be kept up to date.
