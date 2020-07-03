<?php

namespace App\Responder;

use Illuminate\Support\Facades\Facade;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;

class ResponderFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return Responder::class;
    }
}