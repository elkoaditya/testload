<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class announcement extends CI_Controller {

	function __construct(){
		
		parent::__construct();
		$this->load->library('session');
		$this->load->model('utama_model','utama');
	
	}
	
	public function show_periode_by_where($where_coloumn, $where, $limit=0, $offset=1000) {
			
			$table			= 'prd_semester'; 
			$order_coloumn	= 'nama';
			$order			= 'asc';
			
			$data[$table] = $this->utama->get_data_by_where_one_table($table, $limit, $offset, $where_coloumn, $where, $order_coloumn, $order);
			return $data[$table];
	}
	
	public function show_user_by_where($where_coloumn, $where, $limit=0, $offset=1000) {
			
		$where_id = '';
		if(($where_coloumn!='')&&($where!='admin'))
		{
			$where_id = ' AND '.$where_coloumn.' = "'.$where.'"';
		}
	
		$query = 
		"
			SELECT  
				*
			FROM  
				data_user
			WHERE 
				deviceid != ''
				".$where_id."
			
		";
		
		$result	= $this->utama->master_query_result($query);
		return $result;
	}
	
	public function show_get($id=''){
		
		$where_id = '';
		if($id!='')
		{
			$where_id = ' AND kp.id = '.$id.'';
		}
	
		$query = 
		"
			SELECT  
				kp.* ,
				count(kpr.id) as jml_baca
			FROM  
				kbm_pengumuman kp
			
			LEFT JOIN
				kbm_pengumuman_read kpr
				ON
				kpr.pengumuman_id = kp.id
			WHERE 
				kp.aktif = 1
				".$where_id."
			GROUP BY
				kp.id
		";
		
		$result	= $this->utama->master_query_result($query);
		
		return $result;
		
	}
	
	function do_upload($file)
	{
		$upload_path = '/var/www/'.$_SERVER['HTTP_HOST'].'/absensi/content/kaldik/';
		
		$config['upload_path'] = $upload_path;
		//echo $config['upload_path'].'aa';
		$config['allowed_types'] = 'gif|jpg|png';
		//$config['max_size']	= '100';
		//$config['max_width']  = '1024';
		//$config['max_height']  = '768';

		$this->load->library('upload', $config);

		if ( ! $this->upload->do_upload($file))
		{
			$error = array('error' => $this->upload->display_errors());
			return $error ;
			//print_r($error);
			//$this->load->view('upload_form', $error);
		}
		else
		{
			$data = array('upload_data' => $this->upload->data());

			return $data;
			//$this->load->view('upload_success', $data);
		}
	}
	
	////////////////////////////// announcement /////////////////////////////////////////////////////////
	public function save_announcement($action,$id=0) {
		
		$table = 'kbm_pengumuman';
		
		if($action=='delete')
		{
			$data	= '';
			$data['aktif']			= 0;
			
			$this->utama->master_crud_one_table('update',$data,$table,'id',$id);
		
		}else{
			
			if($id==0)
			{	$id = $this->input->post('id');	}
			
			$data['urut']			= $this->input->post('urut');
			$data['judul']			= $this->input->post('judul');
			$data['deskripsi']		= $this->input->post('deskripsi');
			$data['untuk_guru']		= $this->input->post('untuk_guru');
			$data['untuk_siswa']	= $this->input->post('untuk_siswa');
			
			if($action == 'insert'){
				$data['registered']		= date('Y-m-d H:i:s');
			}
			$data['modified']		= date('Y-m-d H:i:s');
			$data['author_id']		= 11;
			
			$where_coloumn = 'id';
			
			$this->utama->master_crud_one_table($action,$data,$table,$where_coloumn,$id);
			
			if(($data['untuk_guru']==1)&&($data['untuk_siswa']==1)){
				$role = 'admin';
			}elseif($data['untuk_guru']==1){
				$role = 'sdm';
			}elseif($data['untuk_siswa']==1){
				$role = 'siswa';
			}
			
			$user	= $this->show_user_by_where('role', $role);
			//$devicetoken = 'cMLpvKwJUNs:APA91bFk4UpMUxgGny1VpREqRPYqFlYczvwVSh4OyV8qgG9kojg71BR6nJaLIMLCCQJoa5pEmN0EjuA9uK6cm-Wk';
			//$devicetoken = '148361017308';
			//$message = 'coba';
			//$this->sendmessage_android2($devicetoken,$message);
			//$devicetoken = 'cMLpvKwJUNs:APA91bFk4UpMUxgGny1VpREqRPYqFlYczvwVSh4OyV8qgG9kojg71BR6nJaLIMLCCQJoa5pEmN0EjuA9uK6cm-Wke1-FOZbffOOGyzy6Cpvo6t78bq5igWqHcXlh2NDn4Qil6njxZwxR';
			
			
			$devicetoken1 = array(
				"cqd-lP0k5Ak:APA91bEUHLb1lO4_0kNI91yJD5S1csKqGLKrbSqKxp8fTJeyxwsqdfO0KS2sMtlflkqniIAoB3brhPqvRDmmCbZIuRYLBVjoB4DkqYl7fkkQdpMiE0bQBfPRxmb9cbRxHY16PhOO8_fJ",
				"cFIJNlM57mc:APA91bF8ygRehDxQPAIyPkLsERCUJDXeGkm2_slQaCn8nRMsO3JJoNQUHECxHhpsCgsM9JFwYdn8CB6UalOL87igVloUFLX3zzmwW5_copWcEP7J7BBujRjB6gHrAT3Rp_UFLCf_b5F68iPJILwHjcyVnGp3e-rT1w"
			);
			
			$devicetoken = array();
			$no=0;
			foreach($user as $u)
			{
				if($u->deviceid != ''){
					$devicetoken[] = $u->deviceid;
					$no++;
				}				
			}
			
			$message = array(
				'body' => $data['deskripsi'],
				'title' => $data['judul'],
				'sound' => "default",
				'color' => "#203E78" ,
				'badge' => '1'
			);
			
			$this->sendmessage_android_final($devicetoken,$message);
		
			
		}
	}
		
	
	public function home($action='', $id=0){
		
		if($action!='')
		{	
			$this->save_announcement($action, $id);
			redirect($this->uri->segment(1).'/'.$this->uri->segment(2));	
		}
		
		require('core.php');
		$core = new core();
		
		$data['announcement'] = $this->show_get();
		
		$core->top(); 
		
		$this->load->view('announcement/list_announcement',$data);
		
		$core->bottom();
	
	}
	
	public function form($action, $id=0, $url='home'){
			
		require('core.php');
		$core = new core();
		
		$data['action']	= $action;
		
		$data['announcement'] = $this->show_get($id);
		
		$data['url'] = $url;
		
		$core->top(); 
			
		$this->load->view('announcement/form_announcement',$data);
		
		$core->bottom();
	
	}
	/*
	 function sendmessage_android($devicetoken,$message){ 
        //$api_key     =   'AIzaSyCtDch9K3ZqGF_SSLYCz4JjMS4-fkJuW';//get the api key from FCM backend
		$api_key     =   'AAAAIosBd9w:APA91bGgb0lKy7-4bg5dszXxUCK5Ci21fNShC7YnccVmqsrZG53NV2kKH8VO_zRyeZJXo8kCefPNCkvnHZLREFxnbTqMaQMO-XXSmusYrIVDw9nqVZorRDkQHUNyteD4LSUeCkdnxLo0';
        //$api_key     =   'AIzaSyD0zHPEjF2O5RmOSCL3_HY4Y78Cg8m3sWU';
		$url = 'https://fcm.googleapis.com/fcm/send';
        $fields = array(
			//'registration_ids'  => array($devicetoken),
			'registration_ids'  => array(
				'cMLpvKwJUNs:APA91bFk4UpMUxgGny1VpREqRPYqFlYczvwVSh4OyV8qgG9kojg71BR6nJaLIMLCCQJoa5pEmN0EjuA9uK6cm-Wke1-FOZbffOOGyzy6Cpvo6t78bq5igWqHcXlh2NDn4Qil6njxZwxR',
				'cMLpvKwJUNs:APA91bFk4UpMUxgGny1VpREqRPYqFlYczvwVSh4OyV8qgG9kojg71BR6nJaLIMLCCQJoa5pEmN0EjuA9uK6cm-Wke1-FOZbffOOGyzy6Cpvo6t78bq5igWqHcXlh2NDn4Qil6njxZwxR'
			),
			'data'            => $message
		);//get the device token from Android 
        $headers = array( 'Authorization: key=' . $api_key,'Content-Type: application/json');
        $ch = curl_init();
        curl_setopt( $ch, CURLOPT_URL, $url );
        curl_setopt( $ch, CURLOPT_POST, true );
        curl_setopt( $ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
        curl_setopt ($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt( $ch, CURLOPT_POSTFIELDS, json_encode($fields) );
        $result = curl_exec($ch);
        if(curl_errno($ch)){
            return 'Curl error: ' . curl_error($ch);
        }
        curl_close($ch);
        $cur_message=json_decode($result);
		echo"aaaaaaaaaaaaaaaaaaaa";
		print_r($ch);
        if($cur_message->success==1)
            return true;
        else
            return false;
	}
	
	 function sendmessage_android2($devicetoken,$message){ 
		//$key     =   'AAAAIosBd9w:APA91bGgb0lKy7-4bg5dszXxUCK5Ci21fNShC7YnccVmqsrZG53NV2kKH8VO_zRyeZJXo8kCefPNCkvnHZLREFxnbTqMaQMO-XXSmusYrIVDw9nqVZorRDkQHUNyteD4LSUeCkdnxLo0';
        $key     =   'AIzaSyD0zHPEjF2O5RmOSCL3_HY4Y78Cg8m3sWU';
		//$key     =   'AIzaSyAz_EEYErr828fehSFdxGYzEgDxv_qe-ms';
		
		$url = 'https://fcm.googleapis.com/fcm/send';
		$fields = array(
			 'to' => 'cMLpvKwJUNs:APA91bFk4UpMUxgGny1VpREqRPYqFlYczvwVSh4OyV8qgG9kojg71BR6nJaLIMLCCQJoa5pEmN0EjuA9uK6cm-Wke1-FOZbffOOGyzy6Cpvo6t78bq5igWqHcXlh2NDn4Qil6njxZwxR',
			 'priority' => 'high',
			'notification' => $message
			 //'data' => $message
			);
		$headers = array(
			'Authorization:key = '. $key,
			'Content-Type: application/json'
			);
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);  
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
		$result = curl_exec($ch);  
		//print_r($result);
		if ($result === FALSE) {
		   die('Curl failed: ' . curl_error($ch));
		}
		curl_close($ch);
	 }
	 
	 function sendGCM($message, $id) {

		$url = 'https://fcm.googleapis.com/fcm/send';

		$fields = array (
				'registration_ids' => array (
						$id
				),
				'data' => array (
						"message" => $message
				)
		);
		$fields = json_encode ( $fields );

		$headers = array (
				'Authorization: key=' . "YOUR_KEY_HERE",
				'Content-Type: application/json'
		);

		$ch = curl_init ();
		curl_setopt ( $ch, CURLOPT_URL, $url );
		curl_setopt ( $ch, CURLOPT_POST, true );
		curl_setopt ( $ch, CURLOPT_HTTPHEADER, $headers );
		curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
		curl_setopt ( $ch, CURLOPT_POSTFIELDS, $fields );

		$result = curl_exec ( $ch );
		echo $result;
		curl_close ( $ch );
	}*/
	
	function sendmessage_android3($devicetoken,$message){ 
		$url = "https://fcm.googleapis.com/fcm/send";
		$serverKey = 'AAAAIosBd9w:APA91bGgb0lKy7-4bg5dszXxUCK5Ci21fNShC7YnccVmqsrZG53NV2kKH8VO_zRyeZJXo8kCefPNCkvnHZLREFxnbTqMaQMO-XXSmusYrIVDw9nqVZorRDkQHUNyteD4LSUeCkdnxLo0';
		
		//$token = "cqd-lP0k5Ak:APA91bEUHLb1lO4_0kNI91yJD5S1csKqGLKrbSqKxp8fTJeyxwsqdfO0KS2sMtlflkqniIAoB3brhPqvRDmmCbZIuRYLBVjoB4DkqYl7fkkQdpMiE0bQBfPRxmb9cbRxHY16PhOO8_fJ";
		//$title = "Test local xxx";
		//$body = "Hello I am from Your php server";
		//$notification = array('title' =>$title , 'body' => $body, 'sound' => 'default', 'badge' => '1');
		
		$notification = $message;
		$arrayToSend = array('to' => $devicetoken, 'notification' => $notification,'priority'=>'high');
		$json = json_encode($arrayToSend);
		$headers = array();
		$headers[] = 'Content-Type: application/json';
		$headers[] = 'Authorization: key='. $serverKey;
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST,"POST");
		curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
		curl_setopt($ch, CURLOPT_HTTPHEADER,$headers);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		//Send the request
		$response = curl_exec($ch);
		//Close request
		if ($response === FALSE) {
		die('FCM Send Error: ' . curl_error($ch));
		}
		curl_close($ch);
	}
	
	function sendmessage_android_final($devicetoken,$message){ 
		$url = "https://fcm.googleapis.com/fcm/send";
		$serverKey = 'AAAAIosBd9w:APA91bGgb0lKy7-4bg5dszXxUCK5Ci21fNShC7YnccVmqsrZG53NV2kKH8VO_zRyeZJXo8kCefPNCkvnHZLREFxnbTqMaQMO-XXSmusYrIVDw9nqVZorRDkQHUNyteD4LSUeCkdnxLo0';
		
		//$token = "cqd-lP0k5Ak:APA91bEUHLb1lO4_0kNI91yJD5S1csKqGLKrbSqKxp8fTJeyxwsqdfO0KS2sMtlflkqniIAoB3brhPqvRDmmCbZIuRYLBVjoB4DkqYl7fkkQdpMiE0bQBfPRxmb9cbRxHY16PhOO8_fJ";
		//$title = "Test local xxx";
		//$body = "Hello I am from Your php server";
		//$notification = array('title' =>$title , 'body' => $body, 'sound' => 'default', 'badge' => '1');
		
		$notification = $message;
		//$arrayToSend = array('to' => $devicetoken, 'notification' => $notification,'priority'=>'high');
		$arrayToSend = array('registration_ids' => $devicetoken, 'notification' => $notification,'priority'=>'high');
		$json = json_encode($arrayToSend);
		$headers = array();
		$headers[] = 'Content-Type: application/json';
		$headers[] = 'Authorization: key='. $serverKey;
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST,"POST");
		curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
		curl_setopt($ch, CURLOPT_HTTPHEADER,$headers);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		//Send the request
		$response = curl_exec($ch);
		//Close request
		if ($response === FALSE) {
		die('FCM Send Error: ' . curl_error($ch));
		}
		curl_close($ch);
	}
}