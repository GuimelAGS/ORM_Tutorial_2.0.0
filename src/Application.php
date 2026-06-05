<?php
declare(strict_types=1);

namespace App;

use App\Middleware\HostHeaderMiddleware;
use Cake\Core\Configure;
use Cake\Core\ContainerInterface;
use Cake\Datasource\FactoryLocator;
use Cake\Error\Middleware\ErrorHandlerMiddleware;
use Cake\Event\EventManagerInterface;
use Cake\Http\BaseApplication;
use Cake\Http\Middleware\BodyParserMiddleware;
use Cake\Http\Middleware\CsrfProtectionMiddleware;
use Cake\Http\MiddlewareQueue;
use Cake\ORM\Locator\TableLocator;
use Cake\Routing\Middleware\AssetMiddleware;
use Cake\Routing\Middleware\RoutingMiddleware;
use Authentication\AuthenticationService;
use Authentication\AuthenticationServiceInterface;
use Authentication\AuthenticationServiceProviderInterface;
use Authentication\Identifier\PasswordIdentifier;
use Authentication\Middleware\AuthenticationMiddleware;
use Psr\Http\Message\ServerRequestInterface;
use Authorization\AuthorizationService;
use Authorization\AuthorizationServiceInterface;
use Authorization\AuthorizationServiceProviderInterface;
use Authorization\Middleware\AuthorizationMiddleware;
use Authorization\Policy\OrmResolver;

/**
 * Application setup class.
 *
 * @extends \Cake\Http\BaseApplication<\App\Application>
 */
class Application extends BaseApplication
    implements AuthenticationServiceProviderInterface,
     AuthorizationServiceProviderInterface
{
    public function bootstrap(): void
    {
        parent::bootstrap();
        $this->addPlugin('Authorization');

        FactoryLocator::add('Table', (new TableLocator())->allowFallbackClass(false));
    }

    public function middleware(MiddlewareQueue $middlewareQueue): MiddlewareQueue
    {
        $middlewareQueue
            ->add(new ErrorHandlerMiddleware(Configure::read('Error'), $this))
            ->add(new HostHeaderMiddleware())
            ->add(new AssetMiddleware([
                'cacheTime' => Configure::read('Asset.cacheTime'),
            ]))
            ->add(new RoutingMiddleware($this))
            ->add(new AuthenticationMiddleware($this))
            ->add(new BodyParserMiddleware())
            ->add(new CsrfProtectionMiddleware([
                'httponly' => true,
            ]))
            ->add(new AuthorizationMiddleware($this, [
                'skipAuthorization' => [
                    fn($request) => str_starts_with($request->getPath(), '/debug-kit'),
                ],
            ]));

        return $middlewareQueue;
    }

    public function services(ContainerInterface $container): void
    {
    }

    public function events(EventManagerInterface $eventManager): EventManagerInterface
    {
        return $eventManager;
    }

    public function getAuthenticationService(ServerRequestInterface $request): AuthenticationServiceInterface
    {
        $service = new AuthenticationService();

        $service->setConfig([
            'unauthenticatedRedirect' => [
                'prefix' => false,
                'plugin' => null,
                'controller' => 'Users',
                'action' => 'login',
            ],
            'queryParam' => 'redirect',
        ]);

        $fields = [
            PasswordIdentifier::CREDENTIAL_USERNAME => 'email',
            PasswordIdentifier::CREDENTIAL_PASSWORD => 'password',
        ];

        $service->loadAuthenticator('Authentication.Session');
        $service->loadAuthenticator('Authentication.Form', [
            'fields' => $fields,
            'loginUrl' => [
                'prefix' => false,
                'plugin' => null,
                'controller' => 'Users',
                'action' => 'login',
            ],
            'identifier' => [
                'className' => 'Authentication.Password',
                'fields' => $fields,
            ],
        ]);

        return $service;
    }

    public function getAuthorizationService(ServerRequestInterface $request): AuthorizationServiceInterface
    {
        $resolver = new OrmResolver();
        return new AuthorizationService($resolver);
    }
}
