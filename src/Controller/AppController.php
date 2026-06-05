<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Controller\Controller;

class AppController extends Controller
{
    public function initialize(): void
    {
        parent::initialize();

        $this->loadComponent('Flash');
        $this->loadComponent('Authentication.Authentication');
        $this->loadComponent('Authorization.Authorization');
    }

    public function beforeFilter(\Cake\Event\EventInterface $event): void
    {
        parent::beforeFilter($event);
        // index y view son públicos en todos los controllers
        $this->Authentication->allowUnauthenticated(['index', 'view']);
    }
}
