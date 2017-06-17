<?php
namespace App\Http\Middleware;
use Closure;
class SiteModeMiddleware
{
  /**
    * Handle an incoming request.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  \Closure  $next
    * @return mixed
    */
  public function handle($request, Closure $next)
  {
	 
	$is_maintenance_mode = \DB::table('appsettings')->where('id', 5)->count();
	if($is_maintenance_mode == "1"){
		return view("500_mode");
	}
    /*$country=file_get_contents('http://api.hostip.info/get_html.php?ip=' . $request->ip());
    echo $country;
    if(strpos($country, "UNITED STATES")){
        throw new \Exception("NOT FOR YOUR EYES, NSA");   
    } else {
        return redirect("maintenance/mode");   
    }*/
    
    return $next($request);
  }
}
