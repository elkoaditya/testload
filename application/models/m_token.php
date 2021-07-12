<?php

class M_token extends CI_Model
{
	
	public function __construct()
	{
		parent::__construct();

	}
	
	function generate($generate, $int_date){
		
		$token = strtoupper( substr( MD5(MD5($generate).APP_SCOPE.$int_date), 0 ,6) );
		
		return $token;
		
	}
	
	function check_token(){
		$int_date	= strtotime(date("Y-m-d"));
		$jam		= date("H:i:s");
		
		$query =  $this->db->query('
			SELECT
				*
			FROM 
				key_token
			WHERE
				awal <= "'.$jam.'"
				AND
				akhir >= "'.$jam.'"
			');
		
		$row = $query->result_array();
		/*print_r($row);
		echo"a".$int_date;
		echo"<br>".$jam;
		*/
		$resultset['tanggal'] 	= date("Y-m-d");
		$resultset['waktu'] 	= $jam;
		$resultset['awal'] 		= $row[0]['awal'];
		$resultset['akhir'] 	= $row[0]['akhir'];
		$resultset['token'] 	= $this->generate($row[0]['generate'], $int_date);
		
		//echo "<br>token = ".$token ;
		return $resultset;
	}
	
}