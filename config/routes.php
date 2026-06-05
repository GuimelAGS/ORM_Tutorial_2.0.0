<?php
use Cake\Routing\Route\DashedRoute;
use Cake\Routing\RouteBuilder;

$routes->setRouteClass(DashedRoute::class);

$routes->scope('/', function (RouteBuilder $builder) {
    // Ruta raíz → redirige a Articles
    $builder->connect('/', ['controller' => 'Articles', 'action' => 'index']);
    $builder->connect('/pages/*', ['controller' => 'Pages', 'action' => 'display']);

    // Ruta para artículos por tag
    $builder->scope('/articles', function (RouteBuilder $builder) {
        $builder->connect('/tagged/*', ['controller' => 'Articles', 'action' => 'tags']);
    });

    $builder->fallbacks();
});