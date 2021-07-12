<?php
require_once 'config.php';
 
function create_meeting($sekolah, $param1, $param2 ) {
    $client = new GuzzleHttp\Client(['base_uri' => 'https://api.zoom.us']);
 
    $db = new DB();
    $arr_token = $db->get_access_token();
    $accessToken = $arr_token->access_token;
 
	//$durasi = date_diff($param1['materi_ditutup'], $param1['tanggal_publish']);
	//$param1['tanggal_publish'] = str_replace(" ", "T", $param1['tanggal_publish']);
	
	echo $param1['tanggal_publish']." ".$param2['durasi'];
    try {
        $response = $client->request('POST', '/v2/users/me/meetings', [
            "headers" => [
                "Authorization" => "Bearer $accessToken"
            ],
            'json' => [
                "topic" => $sekolah." ".$param1['nama'],
                "type" => 2,
                "start_time" => $param1['tanggal_publish'],
                "duration" => $param2['durasi'], //  mins
                "password" => "123456",
				"settings" => [
					"host_video" => true,
					"participant_video" => true,
					"cn_meeting" => false,
					"in_meeting" => false,
					"join_before_host" => true,
					"mute_upon_entry" => false,
					"watermark" => false,
					"use_pmi" => false,
					//"approval_type" => 0,
					//"registration_type" => 0,
					"audio" => "both",
					"auto_recording" => "none",
					"alternative_hosts" => "",
					//"close_registration" => true,
					"waiting_room" => false,
					//"contact_name" => "coba",
					//"contact_email" => "abc@gmail.com",
					//"registrants_email_notification" => "false",
					//"meeting_authentication" => false,
					//"authentication_option" => "",
					//"authentication_domains" => ""
				]
            ],
        ]);
 
        $data = json_decode($response->getBody());
        echo "Join URL: ". $data->join_url;
        echo "<br>";
        echo "Meeting Password: ". $data->password;
		
		return $data;
 
    } catch(Exception $e) {
        if( 401 == $e->getCode() ) {
            $refresh_token = $db->get_refersh_token();
 
            $client = new GuzzleHttp\Client(['base_uri' => 'https://zoom.us']);
            $response = $client->request('POST', '/oauth/token', [
                "headers" => [
                    "Authorization" => "Basic ". base64_encode(CLIENT_ID.':'.CLIENT_SECRET)
                ],
                'form_params' => [
                    "grant_type" => "refresh_token",
                    "refresh_token" => $refresh_token
                ],
            ]);
            $db->update_access_token($response->getBody());
 
            create_meeting();
        } else {
            echo $e->getMessage();
        }
    }
}
 
//create_meeting();