<?php

namespace App\Http\Middleware;

use Auth;
use Closure;
use Illuminate\Contracts\Auth\Guard;
use ReflectionClass;
use ReflectionException;

use Illuminate\Http\Exceptions\HttpResponseException;
use App\Responder\ResponderFacade as Responder;

class Authorize
{

    private $abilityMap = [
        'index' => 'index',
        'create' => 'create',
        'store' => 'create',
        'edit' => 'update',
        'update' => 'update',
        'delete' => 'delete',
    ];

    /**
     * The Guard implementation.
     *
     * @var Guard
     */
    protected $auth;

    /**
     * Create a new filter instance.
     *
     * @param  Guard  $auth
     * @return void
     */
    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }


    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        $routeArray = $request->route()->getAction();

        list($controller, $action) = explode('@', $routeArray['controller']);

        $reflect = new ReflectionClass(new $controller);
        $abilities = $this->getAbility($reflect, $controller);

        $property = null;
        try {
            $property = $reflect->getProperty('resource');
            $property->setAccessible(true);
            $property = $property->getValue(new $controller);
        } catch (ReflectionException $e) {
            $filtred = array_filter(explode('/', $routeArray['prefix']), 'strlen');
            $property = reset($filtred);
        }

        $realAction = isset($abilities[$action]) ? $abilities[$action] : $action ;
        $permission = $realAction . '-' . $property;

        $authorized = Auth::can($permission);
        // $authorized = true;
        if (!$authorized) {
            throw new HttpResponseException(
                Responder::respondForbiddenError()
            );
        }

        return $next($request);
    }

    private function getAbility($reflect, $controller)
    {
        $abilities = null;
        try {

            $property = $reflect->getProperty('abilityMap');
            $property->setAccessible(true);

            $abilities = $property->getValue(new $controller);

            $abilities = array_merge($this->abilityMap, $abilities);

        } catch (ReflectionException $e) {

            $abilities = $this->abilityMap;
        }

        return $abilities;
    }

}
