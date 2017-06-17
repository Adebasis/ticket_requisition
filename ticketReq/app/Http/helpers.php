<?php
	
	#
	function getDataFromTable($table,$return_column,$pk,$value=0){
		
		$result=DB::table($table)->where($pk,'=',$value)->get();
		if(count($result) > 0){
			return $result[0]->$return_column;
		}else{
			return "";
		}
	}
	
	function getDataFromTableMultiColumns($table,$multi_column,$pk,$value=0){
		$multi_column = explode(",", $multi_column);
		$result=DB::table($table)->select($multi_column)->where($pk,'=',$value)->get();
		return $result[0];
	}
?>