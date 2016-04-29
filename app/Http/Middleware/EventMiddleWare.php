<?php namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\RedirectResponse;


class EventMiddleWare {
	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */

    public function detectLocale(\Illuminate\Routing\Route $route)
    {
        // gets the locale from parameter
        $param = $route->getParameter('id');
        return  $param;
    }


	public function handle($request, Closure $next)
	{

        $v = $this->detectLocale(app()->router->getCurrentRoute());

        $event  = \DB::table('VIT_EVENT')->where('EVENTID', $v)->where('USERID',\Auth::id())->get();
        if($event){
            return $next($request);
        }else{
            return new RedirectResponse(url('/events'));
        }


	}

}
