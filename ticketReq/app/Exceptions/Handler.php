<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        \Illuminate\Auth\AuthenticationException::class,
        \Illuminate\Auth\Access\AuthorizationException::class,
        \Symfony\Component\HttpKernel\Exception\HttpException::class,
        \Illuminate\Database\Eloquent\ModelNotFoundException::class,
        \Illuminate\Session\TokenMismatchException::class,
        \Illuminate\Validation\ValidationException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
		$page_url = url()->current();
		$url = explode("/", $page_url);
		if(stristr($exception, 'NotFoundHttpException')!=false){
			//echo "Route Not found !!!";exit;
			$err_desc = "Route Not found";
			
			if (strpos($page_url, 'public') == false) {
				$user_id = 0;			
				if(in_array("adminpanel", $url)){				
					$user_id = \Session::get('ecomps_admin_id');
				}else{
					$user_id = \Session::get('ecomps_user_id');
				}			
				$timestamp =strtotime("now");
				$dt = new \DateTime("@$timestamp");
				$destinationTimezone = new \DateTimeZone(\Config::get('app.timezone'));
				$dt->setTimeZone($destinationTimezone);
				$CreateDate = $dt->format('Y-m-d H:i:s');
				\DB::table('error_logs')->insert(array('user_id'=>0,'page_url'=>$page_url,'err_desc'=>$err_desc,'created_date'=>$CreateDate));
			}
			if(in_array("adminpanel", $url)){
				//return response()->view("admin.err", compact('page_url', 'err_desc'));
				return redirect('/adminpanel/error');
			}else{
				return response()->view("err", compact('page_url', 'err_desc'));
			}
			
		}
		if(stristr($exception, 'ErrorException')!=false){
			if(stristr($exception, 'ErrorException')!=false && stristr($exception, 'SQLSTATE')!=false){
				$err_desc = $exception->getMessage();
				//echo $exception->getMessage()."SQL Error in the page";exit;
				
				if (strpos($page_url, 'public') == false) {
					$user_id = 0;			
					if(in_array("adminpanel", $url)){				
						$user_id = \Session::get('ecomps_admin_id');
					}else{
						$user_id = \Session::get('ecomps_user_id');
					}			
					$timestamp =strtotime("now");
					$dt = new \DateTime("@$timestamp");
					$destinationTimezone = new \DateTimeZone(\Config::get('app.timezone'));
					$dt->setTimeZone($destinationTimezone);
					$CreateDate = $dt->format('Y-m-d H:i:s');
					\DB::table('error_logs')->insert(array('user_id'=>0,'page_url'=>$page_url,'err_desc'=>$err_desc,'created_date'=>$CreateDate));
				}
				if(in_array("adminpanel", $url)){
					return redirect('/adminpanel/error');
				}else{
					return response()->view("err", compact('page_url', 'err_desc'));
				}
			}
			if(stristr($exception, 'ErrorException')!=false && stristr($exception, 'Undefined property')!=false){
				$err_desc = $exception->getMessage();
				
				if (strpos($page_url, 'public') == false) {
					$user_id = 0;
					if(in_array("adminpanel", $url)){				
						$user_id = \Session::get('ecomps_admin_id');
					}else{
						$user_id = \Session::get('ecomps_user_id');
					}			
					$timestamp =strtotime("now");
					$dt = new \DateTime("@$timestamp");
					$destinationTimezone = new \DateTimeZone(\Config::get('app.timezone'));
					$dt->setTimeZone($destinationTimezone);
					$CreateDate = $dt->format('Y-m-d H:i:s');
					\DB::table('error_logs')->insert(array('user_id'=>0,'page_url'=>$page_url,'err_desc'=>$err_desc,'created_date'=>$CreateDate));
				}
				if(in_array("adminpanel", $url)){
					return redirect('/adminpanel/error');
				}else{
					return response()->view("err", compact('page_url', 'err_desc'));
				}
			}else if(stristr($exception, 'ErrorException')!=false && stristr($exception, 'fsockopen')!=false){
				$err_desc = $exception->getMessage();
				
				if (strpos($page_url, 'public') == false) {
					$user_id = 0;
					if(in_array("adminpanel", $url)){				
						$user_id = \Session::get('ecomps_admin_id');
					}else{
						$user_id = \Session::get('ecomps_user_id');
					}			
					$timestamp =strtotime("now");
					$dt = new \DateTime("@$timestamp");
					$destinationTimezone = new \DateTimeZone(\Config::get('app.timezone'));
					$dt->setTimeZone($destinationTimezone);
					$CreateDate = $dt->format('Y-m-d H:i:s');
					\DB::table('error_logs')->insert(array('user_id'=>0,'page_url'=>$page_url,'err_desc'=>$err_desc,'created_date'=>$CreateDate));
				}
				if(in_array("adminpanel", $url)){
					return redirect('/adminpanel/error');
				}else{
					return response()->view("err", compact('page_url', 'err_desc'));
				}
			} else{
				$err_desc = "Post Method is not found in route";
				
				if (strpos($page_url, 'public') == false) {
					$user_id = 0;
					if(in_array("adminpanel", $url)){				
						$user_id = \Session::get('ecomps_admin_id');
					}else{
						$user_id = \Session::get('ecomps_user_id');
					}			
					$timestamp =strtotime("now");
					$dt = new \DateTime("@$timestamp");
					$destinationTimezone = new \DateTimeZone(\Config::get('app.timezone'));
					$dt->setTimeZone($destinationTimezone);
					$CreateDate = $dt->format('Y-m-d H:i:s');
					\DB::table('error_logs')->insert(array('user_id'=>0,'page_url'=>$page_url,'err_desc'=>$err_desc,'created_date'=>$CreateDate));
				}
				if(in_array("adminpanel", $url)){
					return redirect('/adminpanel/error');
				}else{
					return response()->view("err", compact('page_url', 'err_desc'));
				}
			}
		}
		if(stristr($exception, 'FatalErrorException')!=false){
			//echo "Syntax error on page";exit;
			$err_desc = "Syntax error on page";
			
			if (strpos($page_url, 'public') == false) {
				$user_id = 0;
				if(in_array("adminpanel", $url)){				
					$user_id = \Session::get('ecomps_admin_id');
				}else{
					$user_id = \Session::get('ecomps_user_id');
				}			
				$timestamp =strtotime("now");
				$dt = new \DateTime("@$timestamp");
				$destinationTimezone = new \DateTimeZone(\Config::get('app.timezone'));
				$dt->setTimeZone($destinationTimezone);
				$CreateDate = $dt->format('Y-m-d H:i:s');
				\DB::table('error_logs')->insert(array('user_id'=>0,'page_url'=>$page_url,'err_desc'=>$err_desc,'created_date'=>$CreateDate));
			}
			if(in_array("adminpanel", $url)){
				//return response()->view("admin.err", compact('page_url', 'err_desc'));
				return redirect('/adminpanel/error');
			}else{
				return response()->view("err", compact('page_url', 'err_desc'));
			}
		}
		if(stristr($exception, 'TokenMismatchException')!=false){
			
			$err_desc = "TokenMismatchException error on page";
			
			if (strpos($page_url, 'public') == false) {
				$user_id = 0;
				if(in_array("adminpanel", $url)){				
					$user_id = \Session::get('ecomps_admin_id');
				}else{
					$user_id = \Session::get('ecomps_user_id');
				}			
				$timestamp =strtotime("now");
				$dt = new \DateTime("@$timestamp");
				$destinationTimezone = new \DateTimeZone(\Config::get('app.timezone'));
				$dt->setTimeZone($destinationTimezone);
				$CreateDate = $dt->format('Y-m-d H:i:s');
				\DB::table('error_logs')->insert(array('user_id'=>0,'page_url'=>$page_url,'err_desc'=>$err_desc,'created_date'=>$CreateDate));
			}
			if(in_array("adminpanel", $url)){
				return redirect('/adminpanel');
			}else{
				return redirect('/');
			}
		}
		
		//echo '<pre>';
		//print_r($exception->getTrace());
		//exit;
		//return response()->view("err");
        return parent::render($request, $exception);
    }

    /**
     * Convert an authentication exception into an unauthenticated response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Auth\AuthenticationException  $exception
     * @return \Illuminate\Http\Response
     */
    protected function unauthenticated($request, AuthenticationException $exception)
    {
        if ($request->expectsJson()) {
            return response()->json(['error' => 'Unauthenticated.'], 401);
        }

        return redirect()->guest('login');
    }
}
