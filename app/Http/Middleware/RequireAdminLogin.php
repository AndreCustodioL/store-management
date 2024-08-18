<?php

namespace App\Http\Middleware;

use \App\Session\Admin\Login as SessionAdminLogin;
use \App\Utils\Auth;

class RequireAdminLogin{
        
    /**
     * Método responsável por executar o middleware
     *
     * @param  Request $request
     * @param  Closure $next
     * @return Response
     */
    public function handle($request,$next){
        //VERIFICA SE O USUÁRIO ESTÁ LOGADO
        if(!SessionAdminLogin::isLogged()){
            $request->getRouter()->redirect('/admin/login');
        }

        $request->user = Auth::getUser();
        
        //EXECUTA O PRÓXIMO NÍVEL DO MIDDLEWARE
        return $next($request);
    }
}