<?php
declare(strict_types=1);

namespace MixerApi\JwtAuth\Test\App;

use Authentication\AuthenticationService;
use Authentication\AuthenticationServiceInterface;
use Authentication\AuthenticationServiceProviderInterface;
use Authentication\Identifier\PasswordIdentifier;
use Authentication\Identifier\IdentifierFactory;
use Authentication\Middleware\AuthenticationMiddleware;
use Cake\Core\Configure;
use Cake\Core\ContainerInterface;
use Cake\Error\Middleware\ErrorHandlerMiddleware;
use Cake\Http\BaseApplication;
use Cake\Http\Middleware\BodyParserMiddleware;
use Cake\Http\MiddlewareQueue;
use Cake\Routing\Middleware\RoutingMiddleware;
use Cake\Routing\RouteBuilder;
use MixerApi\JwtAuth\Configuration\Configuration;
use MixerApi\JwtAuth\Jwk\JwkSet;
use MixerApi\JwtAuth\JwtAuthServiceProvider;
use Psr\Http\Message\ServerRequestInterface;

class Application extends BaseApplication implements AuthenticationServiceProviderInterface
{
    /**
     * @inheritDoc
     */
    public function bootstrap(): void
    {
        $this->addPlugin('Authentication');
        $this->addPlugin('MixerApi/JwtAuth');
    }

    /**
     * @inheritDoc
     */
    public function middleware(MiddlewareQueue $middlewareQueue): MiddlewareQueue
    {
        return $middlewareQueue->add(new ErrorHandlerMiddleware(Configure::read('Error')))
            // Other middleware that CakePHP provides.
            ->add(new RoutingMiddleware($this))
            ->add(new BodyParserMiddleware())
            ->add(new AuthenticationMiddleware($this));
    }

    /**
     * @inheritDoc
     */
    public function routes(RouteBuilder $routes): void
    {
        $routes->scope('/', function (RouteBuilder $builder) {
            $builder->fallbacks();
            $builder->setExtensions(['json']);
            $builder->resources('Test', [
                'map' => [
                    'login' => [
                        'action' => 'login',
                        'method' => 'POST'
                    ],
                    'jwks' => [
                        'action' => 'jwks',
                        'method' => 'GET'
                    ],
                    'index' => [
                        'action' => 'index',
                        'method' => 'GET'
                    ]
                ]
            ]);
        });
        parent::routes($routes);
    }

    /**
     * @inheritDoc
     */
    public function services(ContainerInterface $container): void
    {
        /** @var \League\Container\Container $container */
        $container->addServiceProvider(new JwtAuthServiceProvider());
    }

    /**
     * @inheritDoc
     */
    public function getAuthenticationService(ServerRequestInterface $request): AuthenticationServiceInterface
    {
        $config = new Configuration;
        $service = new AuthenticationService();
        $service->loadAuthenticator('Authentication.Form', [
            'fields' => [
                PasswordIdentifier::CREDENTIAL_USERNAME => 'email',
                PasswordIdentifier::CREDENTIAL_PASSWORD => 'password',
            ],
            'loginUrl' => '/test/login.json',
            'identifier' => $this->identifierConfig('Authentication.Password', [
                'fields' => [
                    PasswordIdentifier::CREDENTIAL_USERNAME => 'email',
                    PasswordIdentifier::CREDENTIAL_PASSWORD => 'password',
                ],
                'resolver' => [
                    'className' => 'Authentication.Orm',
                    'userModel' => 'Users',
                ],
                'passwordHasher' => [
                    'className' => 'Authentication.Fallback',
                    'hashers' => [
                        'Authentication.Default',
                        [
                            'className' => 'Authentication.Legacy',
                            'hashType' => 'md5',
                        ],
                    ],
                ],
            ]),
        ]);

        if (str_starts_with(haystack: $config->getAlg(), needle: 'HS')) {
            $service->loadAuthenticator('Authentication.Jwt', [
                'secretKey' => $config->getSecret(),
                'algorithm' => $config->getAlg(),
                'identifier' => 'Authentication.JwtSubject',
            ]);
        } else if (str_starts_with(haystack: $config->getAlg(), needle: 'RS')) {
            $service->loadAuthenticator('Authentication.Jwt', [
                'jwks' => (new JwkSet)->getKeySet(),
                'algorithm' => $config->getAlg(),
                'identifier' => 'Authentication.JwtSubject',
            ]);
        }

        return $service;
    }

    /**
     * Builds identifier config compatible with both cakephp/authentication 3.x (nested) and 4.x (flat).
     *
     * @param string $className Identifier class name
     * @param array $config Identifier config
     * @return array
     */
    private function identifierConfig(string $className, array $config): array
    {
        if (class_exists(IdentifierFactory::class)) {
            return ['className' => $className] + $config;
        }

        return [$className => $config];
    }
}
