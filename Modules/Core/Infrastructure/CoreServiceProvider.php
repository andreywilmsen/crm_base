<?php

namespace Modules\Core\Infrastructure;

use Illuminate\Support\ServiceProvider;
use Modules\Core\Infrastructure\User\Providers\UserServiceProvider;
use Modules\Core\Infrastructure\Account\Providers\AccountServiceProvider;

class CoreServiceProvider extends ServiceProvider
{
    /**
     * Registra os Service Providers dos submódulos.
     */
    public function register()
    {
        // O Core apenas registra os provedores especializados
        $this->app->register(AccountServiceProvider::class);
        $this->app->register(UserServiceProvider::class);
    }

    /**
     * Lógica global de inicialização (se houver).
     */
    public function boot()
    {
        // Atualmente vazio, pois cada submódulo cuida de suas próprias 
        // rotas, views e menus através de seus respectivos Providers.
    }
}