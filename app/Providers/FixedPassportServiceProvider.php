<?php

namespace App\Providers;

use Illuminate\Support\Facades\Auth;
use App\Services\Auth\Identify;

use Laravel\Passport\PassportServiceProvider;
use Laravel\Passport\Guards\TokenGuard;
use Laravel\Passport\TokenRepository;
use Laravel\Passport\ClientRepository;
use League\OAuth2\Server\ResourceServer;

class FixedPassportServiceProvider extends PassportServiceProvider
{
    protected function makeGuard(array $config)
    {
        return new Identify(function ($request) use ($config) {
            return (new TokenGuard(
                $this->app->make(ResourceServer::class),
                Auth::createUserProvider($config['provider']),
                $this->app->make(TokenRepository::class),
                $this->app->make(ClientRepository::class),
                $this->app->make('encrypter')
            ))->user($request);
        }, $this->app['request']);
    }
}