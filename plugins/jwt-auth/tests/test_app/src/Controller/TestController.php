<?php

namespace MixerApi\JwtAuth\Test\App\Controller;

use Authentication\Authenticator\UnauthenticatedException;
use Authentication\Controller\Component\AuthenticationComponent;
use Cake\Controller\Controller;
use Cake\Event\EventInterface;
use MixerApi\JwtAuth\Jwk\JwkSetInterface;
use MixerApi\JwtAuth\JwtAuthenticatorInterface;

/**
 * @property AuthenticationComponent $Authentication
 */
class TestController extends Controller
{
    public function beforeFilter(EventInterface $event)
    {
        parent::beforeFilter($event);
        $this->loadComponent('Authentication.Authentication');
        $this->loadComponent('RequestHandler');
        $this->Authentication->allowUnauthenticated(['login','jwks']);
    }

    /**
     * @param JwtAuthenticatorInterface $jwtAuth
     * @return \Cake\Http\Response
     * @throws \MixerApi\JwtAuth\Exception\JwtAuthException
     */
    public function login(JwtAuthenticatorInterface $jwtAuth)
    {
        try {
            return $this->response->withStringBody($jwtAuth->authenticate($this->Authentication));
        } catch (UnauthenticatedException $e) {
            return $this->response->withStringBody($e->getMessage())->withStatus(401);
        }
    }

    /**
     * @param JwkSetInterface $jwkSet
     * @return void
     */
    public function jwks(JwkSetInterface $jwkSet)
    {
        $this->set('data', $jwkSet->getKeySet());
        $this->viewBuilder()->setOption('serialize', 'data');
    }

    /**
     * @return void
     */
    public function index()
    {
        $this->set('data', ['hello' => 'world']);
        $this->viewBuilder()->setOption('serialize', 'data');
    }
}
