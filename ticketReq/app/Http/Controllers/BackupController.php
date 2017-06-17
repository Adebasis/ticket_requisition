<?php
// This is Controller of Database functionality.

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Session;
use Mail;

class BackupController extends Controller
{
	
	public function __construct()
    {
        $this->middleware(function ($request, $next) {
            //$this->projects = Auth::user()->projects;

            return $next($request);
        });
    }
	
	// admin_backuppage
	public function admin_backuppage(){
		
		$ecomps_admin_id = Session::get('ecomps_admin_id');
		
		if($ecomps_admin_id == ""){
			return redirect('/adminpanel');
		}
		return view('admin.backup');
	}
		
	public function admin_post_backuppage() {
		
		// local
		$host = "localhost";
		$user = 'root';
		$pass = '';
		$dbname = 'ecomps';
		
		// 56
		$host = "10.128.4.42";
		$user = 'ecdbadmin';
		$pass = 'Ecomp$db2017';
		$dbname = 'ecomps';
		
		
		$tables = '*';
		
		$link = mysqli_connect($host,$user,$pass, $dbname);
		
		
		
		//$result = mysqli_query($link, 'select * from admin');
		//$row = mysqli_fetch_row($result);
		//print_r($row);exit;
		
		
		// Check connection
		if (mysqli_connect_errno()){
			echo "Failed to connect to MySQL: " . mysqli_connect_error();
			exit;
		}
		mysqli_query($link, "SET NAMES 'utf8'");
		//get all of the tables
		if($tables == '*'){
			$tables = array();
			$result = mysqli_query($link, 'SHOW TABLES');
			while($row = mysqli_fetch_row($result)){
				$tables[] = $row[0];
			}
		}else{
			$tables = is_array($tables) ? $tables : explode(',',$tables);
		}
	
		$return = '';
		//cycle through
		foreach($tables as $table){
			$result = mysqli_query($link, 'SELECT * FROM '.$table);
			$num_fields = mysqli_num_fields($result);
			$num_rows = mysqli_num_rows($result);
	
			$return.= 'DROP TABLE IF EXISTS '.$table.';';
			$row2 = mysqli_fetch_row(mysqli_query($link, 'SHOW CREATE TABLE '.$table));
			$return.= "\n\n".$row2[1].";\n\n";
			$counter = 1;
	
			//Over tables
			for ($i = 0; $i < $num_fields; $i++){ 
				//Over rows
				while($row = mysqli_fetch_row($result)){   
					if($counter == 1){
						$return.= 'INSERT INTO '.$table.' VALUES(';
					} else{
						$return.= '(';
					}
	
					//Over fields
					for($j=0; $j<$num_fields; $j++){
						$row[$j] = addslashes($row[$j]);
						$row[$j] = str_replace("\n","\\n",$row[$j]);
						if (isset($row[$j])) { $return.= '"'.$row[$j].'"' ; } else { $return.= '""'; }
						if ($j<($num_fields-1)) { $return.= ','; }
					}
	
					if($num_rows == $counter){
						$return.= ");\n";
					} else{
						$return.= "),\n";
					}
					++$counter;
				}
			}
			$return.="\n\n\n";
		}
		
		//save file
		$fileName = 'db-backup-'.date('d_m_Y').time().'.sql';
		$path = storage_path().'/'.$fileName;
		$handle = fopen(storage_path().'/'.$fileName,'w+');
		fwrite($handle,$return);
		
		if(fclose($handle)){
			
			// Download code
			header('Content-Transfer-Encoding: binary');  // For Gecko browsers mainly
			header('Last-Modified: ' . gmdate('D, d M Y H:i:s', filemtime(utf8_decode($path))) . ' GMT');
			header('Accept-Ranges: bytes');  // For download resume
			header('Content-Length: ' . filesize($path));  // File size
			header('Content-Encoding: none');
			header('Content-Type: application/pdf');  // Change this mime type if the file is not PDF
			header('Content-Disposition: attachment; filename=' . $fileName);  // Make the browser display the Save As dialog
			readfile($path);
			exit;
		}else{
			return redirect('/adminpanel/database/backup')->with('msg','Connection error.');
		}
		exit;
	}

}
