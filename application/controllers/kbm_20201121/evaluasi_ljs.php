<?php

class Evaluasi_ljs extends MY_Controller {

	public function __construct() {
		parent::__construct(array(
				'controller' => array(
						'user' => array('#login'),
						'model' => 'm_kbm_evaluasi_ljs',
						'helper' => 'soal',
				),
				'kbm/evaluasi_ljs/form' => array(
						'user' 	=> array('sdm', 'siswa', 'admin'),
						'model'	=> array('m_app_config','m_token'),
						'library' => 'form',
						'helper' => 'form',
						'data' => array(
								'evaluasi' => array(
										'id' => 0,
								),
						),
				),
				'kbm/evaluasi_ljs/form2' => array(
						'user' => array('sdm', 'siswa', 'admin'),
						'library' => 'form',
						'helper' => 'form',
						'data' => array(
								'evaluasi' => array(
										'id' => 0,
								),
						),
				),
				'kbm/evaluasi_ljs/form_penilaian' => array(
						'user' => array('sdm', 'admin'),
						'library' => 'form',
						'helper' => 'form',
						'data' => array(
								'evaluasi' => array(
										'id' => 0, 
								),
						),
						'request'	 => array(
							'siswa_id'			=> 'trim|as_int',
						),
				),
				'kbm/evaluasi_ljs/browse' => array(
						'user' => array('sdm', 'admin'),
						'helper' => 'form',
						'request' => array(
								'term' => 'clean',
								'evaluasi_id' => 'as_int',
								'user_id' => 'as_int',
						),
				),
				'kbm/evaluasi_ljs/id' => array(
						'library' => 'form',
						'helper' => 'form',
						'data' => array(
								'row' => array(
										'id' => 0,
										'evaluasi_id' => 0,
								),
								'evaluasi' => array(
										'id' => 0,
								),
						),
				),
				'kbm/evaluasi_ljs/koreksi' => array(
						'user' => array('sdm', 'admin'),
						'library' => 'form',
						'helper' => 'form',
						'data' => array(
								'row' => array(
										'id' => 0,
										'evaluasi_id' => 0,
								),
								'evaluasi' => array(
										'id' => 0,
								),
						),
				),
				'kbm/evaluasi_ljs/roleback' => array(
						'user' => array('sdm', 'admin'),
						'library' => 'form',
						'helper' => 'form',
						'data' => array(
								'row' => array(
										'id' => 0,
										'evaluasi_id' => 0,
								),
								'evaluasi' => array(
										'id' => 0,
								),
						),
				),
				'kbm/evaluasi_ljs/surveillance' => array(
						'user' => array('sdm', 'admin'),
						'library' => 'pagination',
						'model' => 'm_option',
						'helper' => 'form',
						'request' => array(
								'evaluasi_id' => 'as_int',
								'kelas_id' => 'as_int',
						),
				),
		));
		$this->d['admin'] = cfguc_admin('akses', 'kbm', 'evaluasi');
		$this->d['view'] = cfguc_view('akses', 'kbm', 'evaluasi');
	}

	public function _rowset_evaluasi() {
		$d = & $this->d;

		if (!$d['request']['evaluasi_id'])
			return alert_info('Pilih nama soal evaluasi yang hendak ditampilkan.', 'kbm/evaluasi');

		$this->_rowset('m_kbm_evaluasi', $d['request']['evaluasi_id'], 'kbm/evaluasi', 'evaluasi');

		$d['evaluasi']['#available'] = $this->m_kbm_evaluasi->availability($d['evaluasi']);
		$d['author_ybs'] = ($d['user']['id'] == $d['evaluasi']['author_id']);
		$d['pengajar_ybs'] = mengajar($d['evaluasi']['pelajaran_id']);

		if (!$d['author_ybs'] && !$d['pengajar_ybs'] && !$d['view'] && $d['user']['role'] != 'siswa')
			return alert_error("Anda tak diperbolehkan mengakses ljs evaluasi.", 'kbm/evaluasi');
	}

	public function sent_answer(){
		
		$response = $this->m_kbm_evaluasi_ljs->save_answer();
		
		echo json_encode($response);      
    	exit;
		
	}
	
	public function sent_answer_essay(){
		
		$response = $this->m_kbm_evaluasi_ljs->save_answer_essay();
		
		echo json_encode($response);      
    	exit;
		
	}
	
	public function evaluasi_token(){
		$d = & $this->d;
		
		if(isset($d['evaluasi_token'])){
			echo $d['evaluasi_token'];
		}
		
	}
	
	public function form() {
		
		if (session_status() == PHP_SESSION_NONE) {
			session_start();
		}

		$uri_evaluasi = 'kbm/evaluasi';
		$d = & $this->d;

		$this->_set('kbm/evaluasi_ljs/form');
			
		// check token enable
		$go_evaluasi = 1;
		$token = $this->m_app_config->get('token');
		
		if( $this->input->get('simulasi')){
			if( $this->input->get('simulasi') == 'ok'){
				$token = 'disable';
			}
		}
		
		if ($token == 'enable')
		{
			$go_evaluasi = 0;
			if(isset($_SESSION['token_log'])){
				if( $_SESSION['token_log'] == $this->input->get('time') ) {
					$go_evaluasi = 1;
					//echo $_SESSION['token_log']."AAAAAAAAAAAAAA";
				}
			} 
			if(($this->input->get('token'))&&($go_evaluasi == 0)){
				$check_token = $this->m_token->check_token();
				if( $check_token["token"] == strtoupper($this->input->get('token')) ){
					
					//echo $_SESSION['token_log']."BBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBB";
					$go_evaluasi = 1;
					$_SESSION['token_log'] = $this->input->get('time'); 
					
				}
				//return alert_error('Token -'.$check_token["token"].'- -'.$this->input->get('token').'- tidak Valid, silahkan ulangi.', $uri_evaluasi);
			}
		} 
		
		// jika SELESAI LJS token di buat nonaktif
		if (!$d['error'] && $d['post_request']){
			$go_evaluasi = 1;
		}
		
		if($go_evaluasi == 1){
			
			$this->form->init('m_kbm_evaluasi', $uri_evaluasi, 'evaluasi');

			if (!$d['evaluasi']['id'])
				return alert_error('Pilih evaluasi yang hendak dikerjakan.', $uri_evaluasi);
			
			//cek LJS
			$d['pengerjaan_ljs'] = $this->m_kbm_evaluasi_ljs->check_ljs();	
			// mulai ambil data soal
			if (($d['user']['role'] == 'admin')||($d['user']['role'] == 'sdm'))
			{
				$d['soal_result'] = $this->m_kbm_evaluasi_ljs->soal($d['evaluasi']);
			}else{
				$d['soal_result'] = $this->m_kbm_evaluasi_ljs->soal($d['evaluasi'] , $d['pengerjaan_ljs']['id']);
			}
			
			$d['evaluasi']['#available'] = $this->m_kbm_evaluasi->availability($d['evaluasi'], TRUE);
			
			if ($d['user']['role'] == 'siswa')
			{	
					
				if((!$d['pengerjaan_ljs']['id'])&&($d['evaluasi']['#available']))
				{	
					$this->m_kbm_evaluasi_ljs->save_first();	
					$d['pengerjaan_ljs'] = $this->m_kbm_evaluasi_ljs->check_ljs();		
				}
				elseif((!$d['pengerjaan_ljs']['id'])&&(!$d['evaluasi']['#available']))
				{
					return redir($uri_evaluasi);
				}
			}else
			{
				$d['pengerjaan_ljs']['id']='';
			}
			
			$d['pengerjaan_ljs_jawaban'] = $this->m_kbm_evaluasi_ljs->check_jawaban_ljs($d['pengerjaan_ljs']['id']);
			
			///// cek waktu evaluasi //////////////////
			if (!$d['evaluasi']['#available'])
			{
				$this->m_kbm_evaluasi_ljs->save_last();
				return redir($uri_evaluasi);
			}
			
			if ($d['soal_result']['selected_rows'] == 0)
				return alert_error('Data error, butir soal tidak ditemukan.', $uri_evaluasi);

			// prosesi jawaban
			if (!$d['error'] && $d['post_request'])
				//if ($this->m_kbm_evaluasi_ljs->save())
				if ($this->m_kbm_evaluasi_ljs->save_last())
					return redir("kbm/evaluasi");

			// output ljs pengerjaan

			$d['form']['time_start'] = $d['time'];
			$d['form']['dtm_start'] = $d['datetime'];
			$d['form']['ljs_id'] = 0;

			$this->form->set();
			$this->_view();
			
		}else{
			
			return alert_error('Token tidak Valid, silahkan ulangi.', $uri_evaluasi);
		
		}
	}

	public function form2() {
		$uri_evaluasi = 'kbm/evaluasi';
		$d = & $this->d;

		$this->_set('kbm/evaluasi_ljs/form2');
		$this->form->init('m_kbm_evaluasi', $uri_evaluasi, 'evaluasi');

		if (!$d['evaluasi']['id'])
			return alert_error('Pilih evaluasi yang hendak dikerjakan.', $uri_evaluasi);
		
		//cek LJS
		$d['pengerjaan_ljs'] = $this->m_kbm_evaluasi_ljs->check_ljs();	
		
		// mulai ambil data soal
		
		if (($d['user']['role'] == 'admin')||($d['user']['role'] == 'sdm'))
		{
			$d['soal_result'] = $this->m_kbm_evaluasi_ljs->soal($d['evaluasi']);
		}else{
			$d['soal_result'] = $this->m_kbm_evaluasi_ljs->soal($d['evaluasi'] , $d['pengerjaan_ljs']['id']);
		}
		
		$d['evaluasi']['#available'] = $this->m_kbm_evaluasi->availability($d['evaluasi'], TRUE);
		
		if ($d['user']['role'] == 'siswa')
		{	
				
			if((!$d['pengerjaan_ljs']['id'])&&($d['evaluasi']['#available']))
			{	
				$this->m_kbm_evaluasi_ljs->save_first();	
				$d['pengerjaan_ljs'] = $this->m_kbm_evaluasi_ljs->check_ljs();		
			}
			elseif((!$d['pengerjaan_ljs']['id'])&&(!$d['evaluasi']['#available']))
			{
				return redir($uri_evaluasi);
			}
		}else
		{
			$d['pengerjaan_ljs']['id']='';
		}
		
		$d['pengerjaan_ljs_jawaban'] = $this->m_kbm_evaluasi_ljs->check_jawaban_ljs($d['pengerjaan_ljs']['id']);
		
		///// cek waktu evaluasi //////////////////
		

		if (!$d['evaluasi']['#available'])
		{
			$this->m_kbm_evaluasi_ljs->save_last();
			return redir($uri_evaluasi);
		}
		
		if ($d['soal_result']['selected_rows'] == 0)
			return alert_error('Data error, butir soal tidak ditemukan.', $uri_evaluasi);

		// prosesi jawaban
		if (!$d['error'] && $d['post_request']){
			//if ($this->m_kbm_evaluasi_ljs->save())
			if ($this->m_kbm_evaluasi_ljs->save_last()){
				return redir("kbm/evaluasi");
				
				//$this->_dump();
			}
		}
		// output ljs pengerjaan

		$d['form']['time_start'] = $d['time'];
		$d['form']['dtm_start'] = $d['datetime'];
		$d['form']['ljs_id'] = 0;

		$this->form->set();
		//$this->_dump();
		$this->_view();
	}
	public function form_penilaian() {
		$uri_evaluasi = 'kbm/evaluasi';
		$d = & $this->d;

		$this->_set('kbm/evaluasi_ljs/form_penilaian');
		$this->form->init('m_kbm_evaluasi', $uri_evaluasi, 'evaluasi');

		
		// $d['form']['siswa_id'] 	= $this->input->get_post('siswa_id');
		
		// $this->_dump();
		if (!$d['evaluasi']['id'])
			return alert_error('Pilih evaluasi yang hendak dikerjakan.', $uri_evaluasi);
		
		if (!$this->input->get_post('siswa_id'))
			return alert_error('Pilih LJS siswa yang hendak dinilai.', $uri_evaluasi);
		
		//cek LJS
		$d['pengerjaan_ljs'] = $this->m_kbm_evaluasi_ljs->check_ljs_penilaian();	
		// mulai ambil data soal
		// if (($d['user']['role'] == 'admin')||($d['user']['role'] == 'sdm'))
		// {
			// $d['soal_result'] = $this->m_kbm_evaluasi_ljs->soal($d['evaluasi']);
		// }else{
			$d['soal_result'] = $this->m_kbm_evaluasi_ljs->soal($d['evaluasi'] , $d['pengerjaan_ljs']['id']);
		// }
		
		$d['evaluasi']['#available'] = $this->m_kbm_evaluasi->availability($d['evaluasi'], TRUE);
		
		// if ($d['user']['role'] == 'siswa')
		// {	
				
			if((!$d['pengerjaan_ljs']['id'])&&($d['evaluasi']['#available']))
			{	
				$this->m_kbm_evaluasi_ljs->save_first_penilaian();	
				$d['pengerjaan_ljs'] = $this->m_kbm_evaluasi_ljs->check_ljs_penilaian();		
			}
			elseif((!$d['pengerjaan_ljs']['id'])&&(!$d['evaluasi']['#available']))
			{
				return redir($uri_evaluasi);
			}
		// }else
		// {
			// $d['pengerjaan_ljs']['id']='';
		// }
		
		// $this->_dump();
		$d['pengerjaan_ljs_jawaban'] = $this->m_kbm_evaluasi_ljs->check_jawaban_ljs($d['pengerjaan_ljs']['id']);
		
		///// cek waktu evaluasi //////////////////
		

		if (!$d['evaluasi']['#available'])
		{
			$this->m_kbm_evaluasi_ljs->save_last_penilaian();
			return redir($uri_evaluasi);
		}
		
		if ($d['soal_result']['selected_rows'] == 0)
			return alert_error('Data error, butir soal tidak ditemukan.', $uri_evaluasi);

		// prosesi jawaban
		if (!$d['error'] && $d['post_request']){
			//if ($this->m_kbm_evaluasi_ljs->save())
			if ($this->m_kbm_evaluasi_ljs->save_last_penilaian()){
				return redir("kbm/evaluasi/id/{$d['evaluasi']['id']}");
			}
			// print_r($this->m_kbm_evaluasi_ljs->save_last_penilaian);
		// $this->_dump();
		}
		// output ljs pengerjaan

		$d['form']['time_start'] = $d['time'];
		$d['form']['dtm_start'] = $d['datetime'];
		$d['form']['ljs_id'] = 0;

		$this->form->set();
		// $this->_dump();
		$this->_view();
	}
	public function browse($index = 0) {
		$this->_set('kbm/evaluasi_ljs/browse');
		$this->_rowset_evaluasi();
		$this->d['resultset'] = $this->m_kbm_evaluasi_ljs->browse($index, 50);
		$this->d['pengerjaan_ljs'] = $this->m_kbm_evaluasi_ljs->check_ljs();		
		
		$this->_view();
	}

	public function id($id = 0) {
		$uri_evaluasi = 'kbm/evaluasi';
		$d = & $this->d;

		$this->_set('kbm/evaluasi_ljs/id');
		$this->_rowset('m_kbm_evaluasi_ljs', $id, $uri_evaluasi);
		$this->_rowset('m_kbm_evaluasi', $d['row']['evaluasi_id'], $uri_evaluasi, 'evaluasi');

		$d['evaluasi']['#available'] = $this->m_kbm_evaluasi->availability($d['evaluasi']);
		$d['author_ybs'] = ($d['user']['id'] == $d['evaluasi']['author_id']);
		$d['siswa_ybs'] = ($d['user']['id'] == $d['row']['user_id']);
		$d['pengerjaan_ljs'] = $this->m_kbm_evaluasi_ljs->check_ljs();		
		
		if (!$d['author_ybs'] && !$d['siswa_ybs'] && !$d['view'])
			return alert_error('Anda tidak dapat melihat lembar jawab dimaksud.', '');

		$d['butir_result'] = $this->m_kbm_evaluasi_ljs->butir_ljs($id);

		if ($d['butir_result']['selected_rows'] == 0)
			return alert_error('Kesalahan! Butir jawaban tidak ditemukan.', "kbm/evaluasi_nilai/browse?evaluasi_id={$d['row']['evaluasi_id']}");

		if ($this->input->get('pdf'))
			return $this->_pdf("ljs_{$d['row']['id']}_{$d['user']['role']}", 'pdf');

		$this->_view();
	}

	public function koreksi() {
		$uri_evaluasi = 'kbm/evaluasi';
		$d = & $this->d;

		$this->_set('kbm/evaluasi_ljs/koreksi');
		$this->form->init('m_kbm_evaluasi_ljs', $uri_evaluasi);

		if (!$d['row']['id'])
			return alert_error('Pilih evaluasi dan lembar jawab yang hendak dikoreksi.', $uri_evaluasi);

		$this->_rowset('m_kbm_evaluasi', $d['row']['evaluasi_id'], $uri_evaluasi, 'evaluasi');

		$d['author_ybs'] = ($d['user']['id'] == $d['evaluasi']['author_id']);

		// pegecekan dr sisi data evaluasinya itu sendiri

		if (!$d['author_ybs'] && !$d['admin'])
			return alert_error('Anda tidak dapat mengoreksi hasil evaluasi.', $uri_evaluasi);

		// butir jawaban-soal

		$d['butir_result'] = $this->m_kbm_evaluasi_ljs->butir_ljs($d['row']['id']);

		if ($d['butir_result']['selected_rows'] == 0)
			return alert_error('Kesalahan! Butir jawaban tidak ditemukan.', $uri_evaluasi);

		// prosesi jawaban

		if (!$d['error'] && $d['post_request'])
			if ($this->m_kbm_evaluasi_ljs->save_koreksi())
				return redir("kbm/evaluasi/id/{$d['evaluasi']['id']}");

		$this->form->set();
		$this->_view();
	}
	
	public function roleback() {
		$uri_evaluasi = 'kbm/evaluasi';
		$d = & $this->d;

		$this->_set('kbm/evaluasi_ljs/roleback');
		
		$this->form->init('m_kbm_evaluasi_ljs', $uri_evaluasi);

		if (!$d['row']['id'])
			return alert_error('Pilih evaluasi dan lembar jawab yang hendak diroleback pengerjaan.', $uri_evaluasi);
			
		$this->m_kbm_evaluasi_ljs->roleback();
		
		return redir("kbm/evaluasi/id/{$d['row']['evaluasi_id']}");

	}
	
	public function surveillance($index = 0) {
		$this->_set('kbm/evaluasi_ljs/surveillance');
		$this->_rowset_evaluasi();
		
		$this->d['resultset'] = $this->m_kbm_evaluasi_ljs->surveillance($index, 1000);
		
		$this->_view();
	}
	
}

