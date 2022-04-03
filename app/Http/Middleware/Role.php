<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Role
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @param $role
     * @return \Illuminate\Http\Response|mixed
     */

    public function handle(Request $request, Closure $next, $role)
    {
        //Separa i ruoli con questo |
        $roles = is_array($role)
            ? $role
            : explode('|', $role);

        if(Auth::user()->role !== 'admin' and array_search('guest', $roles) === false and Auth::user()->hasRoles($roles) === false){
            //se l'utente loggato non è tra i ruoli selezionati gli restituisco un 401 non autorizzato
//            abort(401);
            $pageConfigs = ['pageHeader' => false];
            return response()->view('content.miscellaneous.page-not-authorized', ['pageConfigs' => $pageConfigs]);
        }

        return $next($request);
    }

}
