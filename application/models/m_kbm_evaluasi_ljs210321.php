<?php

class M_kbm_evaluasi_ljs extends MY_Model {

	public function __construct() {
		parent::__construct();
	}

	function filter_1($query) {
		$d = & $this->ci->d;
		$r = & $this->ci->d['request'];
		$def = array(
				'evaluasi_id' => 0,
				'user_id' => 0,
				'term' => '',
		);
		$query['where']['ljs.evaluasi_id'] = (int) $r['evaluasi_id'];
		$query['like'] = array($r['term'], 'siswa.nama');

		array_default($r, $def);

		if ($r['user_id'] > 0 && $d['user']['role'] != 'siswa')
			$query['where']['ljs.user_id'] = (int) $r['user_id'];

		return $query;
	}

	function query_1() {
		$d = & $this->ci->d;
		$query = array(
				'from' => 'kbm_evaluasi_ljs ljs',
				'join' => array(
						array('dprofil_siswa siswa', 'ljs.user_id = siswa.id', 'inner'),
						array('dakd_kelas kelas', 'ljs.kelas_id = kelas.id', 'inner'),
				),
				'select' => array(
						'ljs.*',
						'siswa_nama' => 'siswa.nama',
						'siswa_nis' => 'siswa.nis',
						'siswa_nisn' => 'siswa.nisn',
						'siswa_gender' => 'siswa.gender',
						'kelas_nama' => 'kelas.nama',
				),
		);

		if ($d['user']['role'] == 'siswa')
			$query['where']['ljs.user_id'] = $d['user']['id'];

		
		return $query;
	}
	
	function query_ljs(){
		$d = & $this->ci->d;
		$query = array(
				'from' => 'kbm_evaluasi_ljs ljs',	
				'join' => array(
						array('dprofil_siswa siswa', 'ljs.user_id = siswa.id', 'inner'),
						array('dakd_kelas kelas', 'ljs.kelas_id = kelas.id', 'inner'),
				),			
				'select' => array(
						'ljs.*',
						
				),
		);
		if ($d['user']['role'] == 'siswa')
			$query['where']['ljs.user_id'] = $d['user']['id'];
		return $query;
	}
	
	function query_jawaban($ljs_id=0,$soal_id=0) {
	
		$query = array(
				'from' => 'kbm_evaluasi_jawaban jawab',
				'select' => array(
						'jawab.*',
				),
		);
		
		$query['where']['jawab.ljs_id'] = $ljs_id;
		
		if($soal_id!=0)
			$query['where']['jawab.soal_id'] = $soal_id;
		
		return $query;
	}

	function browse($index, $limit) {
		$query = $this->query_1();
		$query = $this->filter_1($query);

		return $this->md->query($query)->resultset($index, $limit);
	}

	function rowset($id) {
		$query = $this->query_1();
		$query['where']['ljs.id'] = $id;

		return $this->md->query($query)->row();
	}

	function check_evaluasi_ljs($id){
		$d = & $this->ci->d;
		$query = $this->query_1();
		$query['where']['ljs.selesai'] = 0;
		$query['where']['ljs.evaluasi_id'] = $id;
		
		return $this->md->query($query)->row();
		
	}
	function check_ljs(){
		$d = & $this->ci->d;
		$query = $this->query_1();
		$query['where']['ljs.selesai'] = 0;
		$query['where']['ljs.evaluasi_id'] = $d['evaluasi']['id'];
		
		return $this->md->query($query)->row();
		
	}
	
	function check_ljs_penilaian(){
		$d = & $this->ci->d; 
		$query = $this->query_1();
		$query['where']['ljs.selesai'] = 0;
		$query['where']['ljs.evaluasi_id'] = $d['evaluasi']['id'];
		
		$query['where']['ljs.user_id'] = $this->input->get_post('siswa_id');
			
		// return $query;
		return $this->md->query($query)->row();
		
	}
	
	function check_jawaban_ljs($ljs_id,$index=0, $limit=1000){
		
		$query = $this->query_jawaban($ljs_id);
		
		return $this->md->query($query)->resultset($index, $limit);
		
	}
	
	function save_first() {
		$d = & $this->ci->d;
		
		$start_dtm = $d['datetime'];
		$kelas_id = (int) cfgu('kelas_id');
		$evaluasi_mulai = strtotime($d['evaluasi']['kelas_result']['data'][$kelas_id]['evaluasi_mulai']);
		$evaluasi_ditutup = strtotime($d['evaluasi']['kelas_result']['data'][$kelas_id]['evaluasi_ditutup']);
		//$evaluasi_ditutup = strtotime('2015-09-16 10:30:00');
		//$durasi = (isset($evaluasi_ditutup)) ? ($evaluasi_ditutup-$evaluasi_mulai) : 7200 ;
		$durations = explode(":",$d['evaluasi']['kelas_result']['data'][$kelas_id]['evaluasi_durasi']);
		$durasi = (int)$durations[0]*3600;
		$durasi = $durasi + (int)$durations[1]*60;
		$durasi = $durasi + (int)$durations[2];
		//$durasi = strtotime('0000-00-00 '.$d['evaluasi']['kelas_result']['data'][$kelas_id]['evaluasi_durasi']).'a';
	
		//$durasi = $durasi.'a';
		$ljs = array(
				'evaluasi_id' => $d['evaluasi']['id'],
				'user_id' => $d['user']['id'],
				'kelas_id' => (int) cfgu('kelas_id'),
				'trial' => $d['evaluasi']['trial'],
				'awal_waktu' => $start_dtm,
				'waktu' => $start_dtm,
				'nilai' => 0,
				'poin' => 0,
				'poin_max' => 0,
				'durasi' => $durasi,
				'ip' => $this->input->ip_address(),
				'client' => client_agent(),
				'selesai'=>0,
				'modified'=>date('Y-m-d H:i:s'),
				'recalculation'=>'0000-00-00 00:00:00',
				
		);
		if($this->input->get('ket_pakta_integritas')){
			$ljs['pakta_integritas'] = 1;
			$ljs['ket_pakta_integritas'] = $this->input->get('ket_pakta_integritas');
		}
		$this->db->trans_start();
		$ljs_jadi = $this->db->insert('kbm_evaluasi_ljs', $ljs);
		$insert_id = $this->db->insert_id();
		$urut_soal = 0;
		$jml_array = 0;
		
		if($d['evaluasi']['pilihan_jml']>0)
		{	$opsi = array("a","b","c","d","e");	}
	
		foreach ($d['soal_result']['data'] as $soal):
			$urut_soal++;
			
			$opsi_baru='';
			
			if($d['evaluasi']['pilihan_jml']>0){
				shuffle($opsi);
				$opsi_baru='';
				foreach($opsi as $pilihan)
				{
					$opsi_baru .= $pilihan.',';
				}
			}
			
			$jawab[$jml_array]['ljs_id']	= $insert_id;
			$jawab[$jml_array]['soal_id']	= $soal['id'];
			$jawab[$jml_array]['no_urut']	= $urut_soal;
			$jawab[$jml_array]['opsi']		= $opsi_baru;
			$jawab[$jml_array]['pilihan']	='';
			$jawab[$jml_array]['jawaban']	='';
			$jml_array++;
		endforeach;
		$this->db->insert_batch('kbm_evaluasi_jawaban', $jawab); 
		if ($this->db->trans_status() === FALSE)
		{
			$this->db->trans_rollback();
		}
		$msg_sukses = ($ljs_jadi['id']) ? 'Silahkan dimulai' : '';

		return $this->trans_done($msg_sukses, 'Database error, coba beberapa saat lagi.');
	}
	
	function save_first_penilaian() {
		$d = & $this->ci->d;
		
		$start_dtm = $d['datetime'];
		$siswa_id = $this->input->get_post('siswa_id');
		$kelas_id = $this->input->get_post('kelas_id');
		$evaluasi_mulai = strtotime($d['evaluasi']['kelas_result']['data'][$kelas_id]['evaluasi_mulai']);
		$evaluasi_ditutup = strtotime($d['evaluasi']['kelas_result']['data'][$kelas_id]['evaluasi_ditutup']);
		// $evaluasi_mulai = strtotime('2015-09-16 10:30:00');
		// $evaluasi_ditutup = strtotime('2025-09-16 10:30:00');
		//$durasi = (isset($evaluasi_ditutup)) ? ($evaluasi_ditutup-$evaluasi_mulai) : 7200 ;
		$durasi = strtotime($d['evaluasi']['kelas_result']['data'][$kelas_id]['evaluasi_durasi']);
		
		$ljs = array(
				'evaluasi_id' => $d['evaluasi']['id'],
				'user_id' => $siswa_id,
				'kelas_id' => $kelas_id,
				// 'trial' => $d['evaluasi']['trial'],
				'waktu' => $start_dtm,
				'nilai' => 0,
				'poin' => 0,
				'poin_max' => 0,
				'durasi' => $durasi,
				'ip' => $this->input->ip_address(),
				'client' => client_agent(),
				'selesai'=>0,
				'modified'=>date('Y-m-d H:i:s'),
		);
		$this->db->trans_start();
		$ljs_jadi = $this->db->insert('kbm_evaluasi_ljs', $ljs);
		$insert_id = $this->db->insert_id();
		$urut_soal = 0;
		$jml_array = 0;
		
		if($d['evaluasi']['pilihan_jml']>0)
		{	$opsi = array("a","b","c","d","e");	}
	
		foreach ($d['soal_result']['data'] as $soal):
			$urut_soal++;
			
			if($d['evaluasi']['pilihan_jml']>0)
			{
				// shuffle($opsi);
				$opsi_baru='';
				foreach($opsi as $pilihan)
				{
					$opsi_baru .= $pilihan.',';
				}
				$jawab[$jml_array]['opsi']		= $opsi_baru;
			}
			
			$jawab[$jml_array]['ljs_id']	= $insert_id;
			$jawab[$jml_array]['soal_id']	= $soal['id'];
			$jawab[$jml_array]['no_urut']	= $urut_soal;
			$jml_array++;
		endforeach;
		$this->db->insert_batch('kbm_evaluasi_jawaban', $jawab); 
		if ($this->db->trans_status() === FALSE)
		{
			$this->db->trans_rollback();
		}
		$msg_sukses = ($ljs_jadi['id']) ? 'Silahkan dimulai' : '';

		return $this->trans_done($msg_sukses, 'Database error, coba beberapa saat lagi.');
	}
	
	function query_update_jawaban($_raw,$_jwb=''){
		if($_jwb!='')
		{
			$data = array(
			   'pilihan' => $_jwb,
			   'modified' => date('Y-m-d H:i:s'),
			);
			//if(strlen($_jwb)>=32){
			if(strlen($_jwb)>=3){
				$data['pilihan'] = '';
			}
		}
				
		if(isset($_raw['jawaban']))
		{
			if(isset($_raw['poin'])){
				$data['poin'] = $_raw['poin'];
			}
			
			$data['jawaban']	= $_raw['jawaban'];
			//$data['ljs_id']		= $_raw['ljs_id'];
			//$data['soal_id']	= $_raw['soal_id'];
			
			//$this->db->insert('kbm_evaluasi_jawaban', $data); 
			$this->db->where('ljs_id', $_raw['ljs_id']);
			$this->db->where('soal_id', $_raw['soal_id']);
			$this->db->update('kbm_evaluasi_jawaban', $data); 
		}else{
			
			if(isset($_raw['poin']))
				$data['poin'] = $_raw['poin'];
		
			$this->db->where('ljs_id', $_raw['ljs_id']);
			$this->db->where('soal_id', $_raw['soal_id']);
			$this->db->update('kbm_evaluasi_jawaban', $data); 
		}
	}
	
	function save_answer(){
		
		$_evaluasi_ditutup = $this->input->post('ltz');
		$now = strtotime(date('Y-m-d H:i:s'));
		
		if($this->input->post('ltz')){
			
			if($now > $_evaluasi_ditutup){
				$response['warna'] = '#FF4444';	
				$response['message'] = 'Waktu Habis, Silahkan Klik SELESAI PENGERJAAN';	
				
				return $response;
				
			}else{
				
				// LANJUT
				$_jwb = (string) $this->input->post('pilihan');
				$_jwb = trim($_jwb);
				$soal_id = $this->input->post('soal_id');
				$ljs_id	= $this->input->post('ljs_id');
				
				if(($soal_id=='' || $ljs_id=='' || $_jwb=='')&&($this->input->post('simulasi')=='')){
					$response['warna'] = '#FF4444';	
					$response['message'] = 'Jawaban gagal disimpan, silahkan refresh.';	
				}else{
				
					$_raw = array(
						'soal_id'	=> $soal_id,
						'ljs_id'	=> $ljs_id,
						'pilihan'	=> $_jwb,
						'modified' => date('Y-m-d H:i:s'),
						);
					
					$query = $this->query_jawaban($ljs_id,$soal_id);
					
					$hasil = $this->md->query($query)->row();
					
					$this->db->trans_start();
					if($hasil['ljs_id']):
						
						$this->query_update_jawaban($_raw,$_jwb);
						 
					else:
						if($_raw['ljs_id']!=0):
							$this->db->insert('kbm_evaluasi_jawaban',$_raw);
						endif;
					endif;
					$this->db->trans_complete();
					
					if ($this->db->trans_status() === FALSE){
						$response['warna'] = '#FF4444';	
						$response['message'] = 'Jawaban gagal di simpan, coba beberapa saat lagi.';	
					}else{	
						$response['warna'] = '#00AAFF';	
						$response['message'] = 'Jawaban tersimpan';	
					}
					$this->trans_done();
				}
			}
			
		}else{
			$response['warna'] = '#FF4444';	
			$response['message'] = 'Maaf Harap di Refresh.';	
			
			return $response;
		}
		
		return $response;
	}
	
	function save_answer_essay(){
		$_evaluasi_ditutup = $this->input->post('ltz');
		$now = strtotime(date('Y-m-d H:i:s'));
		
		if($this->input->post('ltz')){
			
			if($now > $_evaluasi_ditutup){
				$response['warna'] = '#FF4444';	
				$response['message'] = 'Maaf Waktu Habis, Silahkan Klik SELESAI PENGERJAAN ';	
				
				return $response;
				
			}else{
				
				// LANJUT
				
				$_jwb = (string) $this->input->post('jawaban');		
				// clean FROALA ////		
				$_jwb = str_replace('<p data-f-id="pbf" style="text-align: center; font-size: 14px; margin-top: 30px; opacity: 0.65; font-family: sans-serif;">		Powered by <a href="https://www.froala.com/wysiwyg-editor?pb=1" title="Froala Editor">Froala Editor</a></p>','',$_jwb);		
				$_jwb = str_replace('Powered by <a href="https://www.froala.com/wysiwyg-editor?pb=1" title="Froala Editor">Froala Editor</a>','',$_jwb);				
				$_jwb = str_replace('Froala Editor','',$_jwb);		
				$_jwb = str_replace('Powered by','',$_jwb);				
				/////////////////		
				
				$_jwb = (string) clean_html($_jwb);
				$_detail_jwb = $_jwb;
				$_jwb = base64_encode($_jwb);
				
				$soal_id = $this->input->post('soal_id');
				$ljs_id	= $this->input->post('ljs_id');
				
				if(($soal_id=='' || $ljs_id=='' || $_jwb=='')&&($this->input->post('simulasi')=='')){
					$response['warna'] = '#FF4444';	
					$response['message'] = 'Jawaban gagal disimpan, silahkan refresh.';	
				}else{
					
					$_raw = array(
						'soal_id'		=> $soal_id,
						'ljs_id'		=> $ljs_id,
						'jawaban'		=> $_jwb,
						'modified' 		=> date('Y-m-d H:i:s'),
						);
					
					$query = $this->query_jawaban($ljs_id,$soal_id);
					
					$hasil = $this->md->query($query)->row();
					
					$this->db->trans_start();
					if($hasil['ljs_id']):
						
						$this->query_update_jawaban($_raw,$_jwb,'essay');
						 
					else:
						if($_raw['ljs_id']!=0):
							$this->db->insert('kbm_evaluasi_jawaban',$_raw);
						endif;
					endif;
					$this->db->trans_complete();
					
					if ($this->db->trans_status() === FALSE){
						$response['warna'] = '#FF4444';	
						$response['message'] = 'Jawaban gagal disimpan, coba beberapa saat lagi.';	
					}else{	
						$response['warna'] = '#00AAFF';	
						$response['message'] = 'Jawaban tersimpan';	
					}
					$this->trans_done();
				}
			}
			
		}else{
			$response['warna'] = '#FF4444';	
			$response['message'] = 'Maaf Harap di Refresh.';	
			
			return $response;
		}
		return $response;
	}
	
	function save_last() {
		$d = & $this->ci->d;

		if ($d['user']['role'] != 'siswa')
			return !alert_info('Simulasi berhasil, nilai tidak disimpan.');
			
		$query_ljs = $this->query_ljs();
		$query_ljs['where']['ljs.selesai'] = 0;
		$query_ljs['where']['ljs.evaluasi_id'] = $d['evaluasi']['id'];
		$ljs = $this->md->query($query_ljs)->row();
		
		$ljs['dikoreksi'] = (($d['evaluasi']['pilihan_jml'] > 1) ? $d['datetime'] : NULL);
		$ljs['selesai'] = 1;
		
		$query_jawab = $this->query_jawaban($ljs['id']);
		$ljs_jawaban = $this->md->query($query_jawab)->resultset(0, 10000);
		
		foreach ($ljs_jawaban['data'] as $plj):
			$jawaban[$plj['soal_id']] = $plj['pilihan']; 
			$jawaban_essay[$plj['soal_id']] = $plj['jawaban']; 
		endforeach;
		
		//$cetak='';
		$nilai_posisi_kd='';
		foreach ($d['soal_result']['data'] as $soal):
			soal_prepare($soal);

			$name = "butir-{$soal['id']}";
			
			$_raw = array('soal_id' => $soal['id']);
			
			$_raw['ljs_id'] = $ljs['id'];
			
			/// CHECK ESSAY
			/*
			if ($ljs['dikoreksi']=== NULL):
				$_jwb = (string) $this->input->post($name);
				////// CLEAN FROALA ////////////////////////				$_jwb = str_replace('<p data-f-id="pbf" style="text-align: center; font-size: 14px; margin-top: 30px; opacity: 0.65; font-family: sans-serif;">				Powered by <a href="https://www.froala.com/wysiwyg-editor?pb=1" title="Froala Editor">Froala Editor</a></p>','',$_jwb);				$_jwb = str_replace('Powered by <a href="https://www.froala.com/wysiwyg-editor?pb=1" title="Froala Editor">Froala Editor</a>','',$_jwb);								$_jwb = str_replace('Froala Editor','',$_jwb);				$_jwb = str_replace('Powered by','',$_jwb);				////////////////////////////////////////////////
				$_jwb = (string) clean_html($_jwb);
				$_raw['jawaban'] = base64_encode($_jwb);
				
				$this->query_update_jawaban($_raw);
				//echo"aa<br>";
				//print_r($_raw);
			endif;
			*/
			
			/// CHECK URAIAN
			if ($soal['type']== 3){
				/*
				$_jwb = (string) $this->input->post($name);
				////// CLEAN FROALA ////////////////////////				$_jwb = str_replace('<p data-f-id="pbf" style="text-align: center; font-size: 14px; margin-top: 30px; opacity: 0.65; font-family: sans-serif;">				Powered by <a href="https://www.froala.com/wysiwyg-editor?pb=1" title="Froala Editor">Froala Editor</a></p>','',$_jwb);				$_jwb = str_replace('Powered by <a href="https://www.froala.com/wysiwyg-editor?pb=1" title="Froala Editor">Froala Editor</a>','',$_jwb);								$_jwb = str_replace('Froala Editor','',$_jwb);				$_jwb = str_replace('Powered by','',$_jwb);				////////////////////////////////////////////////
				$_jwb = (string) clean_html($_jwb);
				$_raw['jawaban'] = base64_encode($_jwb);
				
				$this->query_update_jawaban($_raw);
				*/
			/// CHECK ISIAN
			}else if ($soal['type']== 2){
				$_jwb = $jawaban_essay[$soal['id']];
				$_raw['jawaban'] = $_jwb;
				
				$_raw['poin'] = 0;
				$kunsian = 1;
				while($kunsian<=9){
					if(($soal['kunci_isian'.$kunsian] != '')||($soal['kunci_isian'.$kunsian] != NULL)){
						
						/// CEK JAWABAN
						$jawaban_isian					= base64_decode($_raw['jawaban']);
						if($soal['toleran_huruf_kapital']==1){
							$soal['kunci_isian'.$kunsian] 	= strtolower($soal['kunci_isian'.$kunsian]);
							$jawaban_isian					= strtolower($jawaban_isian);
						}
						
						if($soal['kunci_isian'.$kunsian]==$jawaban_isian){
							$_raw['poin'] = $soal['poin_max'];
						}
					}
					$kunsian++;
				}
				
				/*
				$posisi_kd = 99;
				if(isset($nilai_posisi_kd[$posisi_kd]['poin'])){
				}else{
					$nilai_posisi_kd[$posisi_kd]['poin'] = 0;
					$nilai_posisi_kd[$posisi_kd]['poin_max'] = 0;
				}
				$nilai_posisi_kd[$posisi_kd]['poin'] += $_raw['poin'];
				$nilai_posisi_kd[$posisi_kd]['poin_max'] +=  $soal['poin_max'];*/
				
				$ljs['poin_max_isian'] += $soal['poin_max'];
				$ljs['poin_isian'] += $_raw['poin'];
				
				$this->query_update_jawaban($_raw);
				
				//echo"bbbbbbbbbbbbb<br>";
				//print_r($_raw);
			}
			/// CHECK PILIHAN
			else if(isset($jawaban[$soal['id']]))
			{				
				
				
				if ($ljs['dikoreksi']):
					$_jwb = $jawaban[$soal['id']];
					$_jwb = trim($_jwb);
					$pilihan_valid = (strlen($_jwb) == 1);
					$kunci = array_node($soal, 'pilihan', 'kunci', 'index');
					$_raw['pilihan'] = ($pilihan_valid) ? $_jwb : '';
					$_raw['poin'] = ($_raw['pilihan'] == $kunci) ? $soal['poin_max'] : 0;
					$ljs['poin_max'] += $soal['poin_max'];
					$ljs['poin'] += $_raw['poin'];
					
					if(isset($nilai_posisi_kd[$soal['posisi_kd']]['poin'])){
					}else{
						$nilai_posisi_kd[$soal['posisi_kd']]['poin'] = 0;
						$nilai_posisi_kd[$soal['posisi_kd']]['poin_max'] = 0;
					}
					$nilai_posisi_kd[$soal['posisi_kd']]['poin'] += $_raw['poin'];
					$nilai_posisi_kd[$soal['posisi_kd']]['poin_max'] +=  $soal['poin_max'];
					//$cetak .= "<br/> ".$kunci." ".$_raw['pilihan']." ".$soal['id'];
					//$cetak .= "<br/> ".$soal['posisi_kd']." ".$nilai_posisi_kd[$soal['posisi_kd']]['poin']." ".$nilai_posisi_kd[$soal['posisi_kd']]['poin_max']." ".$soal['id'];
					$this->query_update_jawaban($_raw);
				endif;
				
				
				//echo"cccccccc<br>";
				//print_r($_raw);
				//$jawaban_array[] = $_raw;
			}
		endforeach;
		//cetak coba 
		//echo $cetak;
		//return !alert_info($cetak);

		$jumlah_posisi_kd=0;
		if ($ljs['dikoreksi']):
			$total_nilai = 0;
			$pembagi_nilai = 0;
			
			$ljs['nilai_utama'] = 100 * $ljs['poin'] / $ljs['poin_max'];
			$total_nilai 		= $ljs['nilai_utama'] * $d['evaluasi']['bobot_pilgan'];
			$pembagi_nilai 		= $d['evaluasi']['bobot_pilgan'];
			
			if($d['evaluasi']['plus_isian']==1){
				$ljs['nilai_isian'] = 100 * $ljs['poin_isian'] / $ljs['poin_max_isian'];
				$total_nilai 		= $total_nilai + ($ljs['nilai_isian'] * $d['evaluasi']['bobot_isian']);
				$pembagi_nilai 		= $pembagi_nilai + $d['evaluasi']['bobot_isian'];
			}
			
			if($d['evaluasi']['plus_uraian']==1){
				$pembagi_nilai 		= $pembagi_nilai + $d['evaluasi']['bobot_uraian'];
			}
			
			$ljs['nilai'] = $total_nilai/$pembagi_nilai;
			
			/// KD =20
			$tampil_kd=1;
			$jumlah_posisi_kd=30;
			while($tampil_kd<=$jumlah_posisi_kd){
				if(isset($nilai_posisi_kd[$tampil_kd])){
					$ljs['nilai_posisi_kd'.$tampil_kd] = 100 * $nilai_posisi_kd[$tampil_kd]['poin'] / $nilai_posisi_kd[$tampil_kd]['poin_max'];
				}else{
					$ljs['nilai_posisi_kd'.$tampil_kd] = 0;
				}
				$tampil_kd++;
			}
		endif;

		
		/// CHECK JIKA JARINGAN PUTUS DARI AWAL (NILAI 0)
		/*
		if(($ljs['nilai']==0)||($ljs['nilai']==""))
		{
			$ljs['poin_max']=0;
			
			
			foreach ($d['soal_result']['data'] as $soal):
			
				/// CHECK ISIAN
				if ($soal['type']== 3){
					$_jwb = (string) $this->input->post($name);
					////// CLEAN FROALA ////////////////////////				$_jwb = str_replace('<p data-f-id="pbf" style="text-align: center; font-size: 14px; margin-top: 30px; opacity: 0.65; font-family: sans-serif;">				Powered by <a href="https://www.froala.com/wysiwyg-editor?pb=1" title="Froala Editor">Froala Editor</a></p>','',$_jwb);				$_jwb = str_replace('Powered by <a href="https://www.froala.com/wysiwyg-editor?pb=1" title="Froala Editor">Froala Editor</a>','',$_jwb);								$_jwb = str_replace('Froala Editor','',$_jwb);				$_jwb = str_replace('Powered by','',$_jwb);				////////////////////////////////////////////////
					$_jwb = (string) clean_html($_jwb);
					$_raw['jawaban'] = base64_encode($_jwb);
					
					$this->query_update_jawaban($_raw);
					
				/// CHECK ISIAN
				}elseif ($soal['type']== 2){
					soal_prepare($soal);

					$name = "butir-{$soal['id']}";
					
					
					$_raw = array('soal_id' => $soal['id']);
					$_raw['ljs_id'] = $ljs['id'];
					
					$_jwb = (string) $this->input->post($name);
					$_jwb = (string) clean_html($_jwb);
					$_raw['jawaban'] = base64_encode($_jwb);
					
					$_raw['poin'] = 0;
					$kunsian = 1;
					while($kunsian<=9){
						if(($soal['kunci_isian'.$kunsian] != '')||($soal['kunci_isian'.$kunsian] != NULL)){
							
							/// CEK JAWABAN
							$jawaban_isian					= base64_decode($_raw['jawaban']);
							if($soal['toleran_huruf_kapital']==1){
								$soal['kunci_isian'.$kunsian] 	= strtolower($soal['kunci_isian'.$kunsian]);
								$jawaban_isian					= strtolower($jawaban_isian);
							}
							
							if($soal['kunci_isian'.$kunsian]==$jawaban_isian){
								$_raw['poin'] = $soal['poin_max'];
							}
						}
						$kunsian++;
					}
					
					
					$posisi_kd = 99;
					if(isset($nilai_posisi_kd[$posisi_kd]['poin'])){
					}else{
						$nilai_posisi_kd[$posisi_kd]['poin'] = 0;
						$nilai_posisi_kd[$posisi_kd]['poin_max'] = 0;
					}
					$nilai_posisi_kd[$posisi_kd]['poin'] += $_raw['poin'];
					$nilai_posisi_kd[$posisi_kd]['poin_max'] +=  $soal['poin_max'];
					
					$ljs['poin_max_isian'] += $soal['poin_max'];
					$ljs['poin_isian'] += $_raw['poin'];
					
					$this->query_update_jawaban($_raw);
					
					//echo"dddddddddddddddddddddddddddd<br>";
					//print_r($_raw);
				}else{
					soal_prepare($soal);

					$name = "butir-{$soal['id']}";
					$ljs['poin_max'] += $soal['poin_max'];
					
					$_raw = array('soal_id' => $soal['id']);
					$_raw['ljs_id'] = $ljs['id'];
				
					$_jwb = (string) $this->input->post($name);

					$_jwb = trim($_jwb);
					$pilihan_valid = (strlen($_jwb) == 1);
					$kunci = array_node($soal, 'pilihan', 'kunci', 'index');
					$_raw['pilihan'] = ($pilihan_valid) ? $_jwb : '';
					$_raw['poin'] = ($_raw['pilihan'] == $kunci) ? $soal['poin_max'] : 0;
					
					$ljs['poin_max'] += $soal['poin_max'];
					$ljs['poin'] += $_raw['poin'];
					
					$this->query_update_jawaban($_raw,$_raw['pilihan']);
					//echo"eeeee<br>";
					//print_r($_raw);
					//return !alert_info(print_r($_raw));
				}
			endforeach;
			
			if ($ljs['dikoreksi']):
				//$ljs['nilai'] = 100 * $ljs['poin'] / $ljs['poin_max'];
				$total_nilai = 0;
				$pembagi_nilai = 0;
				
				$ljs['nilai_utama'] = 100 * $ljs['poin'] / $ljs['poin_max'];
				$total_nilai 		= $ljs['nilai_utama'] * $d['evaluasi']['bobot_pilgan'];
				$pembagi_nilai 		= $d['evaluasi']['bobot_pilgan'];
				
				if($d['evaluasi']['plus_isian']==1){
					$ljs['nilai_isian'] = 100 * $ljs['poin_isian'] / $ljs['poin_max_isian'];
					$total_nilai 		= $total_nilai + ($ljs['nilai_isian'] * $d['evaluasi']['bobot_isian']);
					$pembagi_nilai 		= $pembagi_nilai + $d['evaluasi']['bobot_isian'];
				}
				
				if($d['evaluasi']['plus_uraian']==1){
					$pembagi_nilai 		= $pembagi_nilai + $d['evaluasi']['bobot_uraian'];
				}
			
				$ljs['nilai'] = $total_nilai/$pembagi_nilai;
			endif;
			//return !alert_info($ljs['poin']);
		}
		*/
		/// SELESAI CHECK JIKA JARINGAN PUTUS DARI AWAL (NILAI 0)
		
		//$durasi = strtotime($d['evaluasi']['kelas_result']['data'][$kelas_id]['evaluasi_durasi']);
		$nilai = array(
				'evaluasi_terkoreksi' => (bool) $ljs['dikoreksi'],
				'evaluasi_nilai' 		=> $ljs['nilai'],
				
				'evaluasi_nilai_utama' 	=> $ljs['nilai_utama'],
				'evaluasi_poin' 		=> $ljs['poin'],
				'evaluasi_poin_max' 	=> $ljs['poin_max'],
				
				'evaluasi_nilai_isian' 		=> $ljs['nilai_isian'],
				'evaluasi_poin_isian' 		=> $ljs['poin_isian'],
				'evaluasi_poin_max_isian' 	=> $ljs['poin_max_isian'],
				
				/*'evaluasi_nilai_uraian' 	=> $ljs['nilai_uraian'],
				'evaluasi_poin_uraian' 		=> $ljs['poin_uraian'],
				'evaluasi_poin_max_uraian' 	=> $ljs['poin_max_uraian'],*/
				//'evaluasi_durasi' => $durasi,
				'ljs_last' => $d['datetime'],
				'ljs_count' => ++$d['evaluasi']['ljs_count'],
		);
		
		
		$tampil_kd=1;
		while($tampil_kd<=$jumlah_posisi_kd){
			$nilai['evaluasi_nilai_posisi_kd'.$tampil_kd] = $ljs['nilai_posisi_kd'.$tampil_kd];
			
			$tampil_kd++;
		}
			
		$this->db->trans_start();
		$this->db->update('kbm_evaluasi_ljs', $ljs,array('id' => $ljs['id']));

		//$ljs['id'] = $this->db->insert_id();
		$nilai['ljs_id'] = $ljs['id'];

		/*foreach (array_keys($jawaban_array) as $i)
			$jawaban_array[$i]['ljs_id'] = $ljs['id'];
		*/
		//$this->db->insert_batch('kbm_evaluasi_jawaban', $jawaban_array);
		
		$this->db->update('kbm_evaluasi_nilai', $nilai, array('id' => $d['evaluasi']['nilai_id']));

		//if ($ljs['dikoreksi']):
			//$this->update_nilai($d['evaluasi']['id']);
		//else:
			//$this->update_pengerjaan($d['evaluasi']['id']);
		//endif;

		$msg_sukses = ($ljs['dikoreksi']) ? 'Jawaban dan nilai berhasil disimpan.' : 'Jawaban telah disimpan, menunggu koreksi guru.';

		return $this->trans_done($msg_sukses, 'Database error, coba beberapa saat lagi.');
	}
	
	function save_last_penilaian() {
		$d = & $this->ci->d;

		if ($d['user']['role'] != 'sdm'){
			return !alert_info('Simulasi berhasil, nilai tidak disimpan.');
		}
			
		$ljs = $this->check_ljs_penilaian();
		// $query_ljs['where']['ljs.selesai'] = 0;
		// $query_ljs['where']['ljs.evaluasi_id'] = $d['evaluasi']['id'];
		// $ljs = $this->md->query($query_ljs)->row();
		
		$Uljs['dikoreksi'] = (($d['evaluasi']['pilihan_jml'] > 1) ? $d['datetime'] : NULL);
		$Uljs['selesai'] = 1;
		$Uljs['poin_max'] = 0;
		$Uljs['poin'] = 0;
		
		$query_jawab = $this->query_jawaban($ljs['id']);
		$ljs_jawaban = $this->md->query($query_jawab)->resultset(0, 10000);
		
		foreach ($ljs_jawaban['data'] as $plj):
			$jawaban[$plj['soal_id']] = $plj['pilihan']; 
		endforeach;
		
		//$cetak='';
		foreach ($d['soal_result']['data'] as $soal):
			soal_prepare($soal);

			$name = "butir-{$soal['id']}";
			$Uljs['poin_max'] += $soal['poin_max'];
			$_raw = array('soal_id' => $soal['id']);
			
			$_raw['ljs_id'] = $ljs['id'];
			
			/// CHECK ESSAY
			if ($Uljs['dikoreksi']=== NULL):
				//$_jwb = (string) $this->input->post($name);
				//////////// CLEAN FROALA //////////////////////				$_jwb = str_replace('<p data-f-id="pbf" style="text-align: center; font-size: 14px; margin-top: 30px; opacity: 0.65; font-family: sans-serif;">				Powered by <a href="https://www.froala.com/wysiwyg-editor?pb=1" title="Froala Editor">Froala Editor</a></p>','',$_jwb);				$_jwb = str_replace('Powered by <a href="https://www.froala.com/wysiwyg-editor?pb=1" title="Froala Editor">Froala Editor</a>','',$_jwb);								$_jwb = str_replace('Froala Editor','',$_jwb);				$_jwb = str_replace('Powered by','',$_jwb);				////////////////////////////////////////////////
				//$_jwbs = (string) clean_html($_jwb);
				//$_raw['jawaban'] = base64_encode($_jwbs);
				
				// $_raw['poin'] = ($_jwbs >= 10) ? 10 : $_jwbs;
				$_raw['poin'] = $_jwb;
				$Uljs['poin'] += $_raw['poin'];
				
				$this->query_update_jawaban($_raw);
			endif;
			
			/// CHECK PILIHAN
			if(isset($jawaban[$soal['id']]))
			{				
				$_jwb = $jawaban[$soal['id']];
	
				if ($Uljs['dikoreksi']):
					$_jwb = trim($_jwb);
					$pilihan_valid = (strlen($_jwb) == 1);
					$kunci = array_node($soal, 'pilihan', 'kunci', 'index');
					$_raw['pilihan'] = ($pilihan_valid) ? $_jwb : '';
					$_raw['poin'] = ($_raw['pilihan'] == $kunci) ? $soal['poin_max'] : 0;
					$Uljs['poin'] += $_raw['poin'];
					//$cetak .= "<br/> ".$kunci." ".$_raw['pilihan']." ".$soal['id'];
				endif;
				
				$this->query_update_jawaban($_raw);
				//$jawaban_array[] = $_raw;
			}
		endforeach;
		//cetak coba 
		//return !alert_info($cetak);

		/*
		/// CHECK JIKA JARINGAN PUTUS DARI AWAL (NILAI 0)
		if(($ljs['nilai']==0)||($ljs['nilai']==""))
		{
			$Uljs['poin_max']=0;
			
			
			foreach ($d['soal_result']['data'] as $soal):
				soal_prepare($soal);

				$name = "butir-{$soal['id']}";
				$Uljs['poin_max'] += $soal['poin_max'];
				
				$_raw = array('soal_id' => $soal['id']);
				$_raw['ljs_id'] = $ljs['id'];
			
				$_jwb = (string) $this->input->post($name);

				$_jwb = trim($_jwb);
				$pilihan_valid = (strlen($_jwb) == 1);
				$kunci = array_node($soal, 'pilihan', 'kunci', 'index');
				$_raw['pilihan'] = ($pilihan_valid) ? $_jwb : '';
				$_raw['poin'] = ($_raw['pilihan'] == $kunci) ? $soal['poin_max'] : 0;
				$Uljs['poin'] += $_raw['poin'];

				$this->query_update_jawaban($_raw,$_raw['pilihan']);
				//return !alert_info(print_r($_raw));
			endforeach;
			
			// if ($Uljs['dikoreksi']):
				// $Uljs['nilai'] = 100 * $Uljs['poin'] / $Uljs['poin_max'];
			// endif;
			//return !alert_info($ljs['poin']);
		}*/
		/// SELESAI CHECK JIKA JARINGAN PUTUS DARI AWAL (NILAI 0)
		
		// if ($Uljs['dikoreksi']):
			$Uljs['nilai'] = 100 * $Uljs['poin'] / $Uljs['poin_max'];
		// endif;

		
		$nilai = array(
				'evaluasi_terkoreksi' => (bool) $d['datetime'],
				'evaluasi_nilai' => $Uljs['nilai'],
				'evaluasi_poin' => $Uljs['poin'],
				'evaluasi_poin_max' => $Uljs['poin_max'],
				// 'evaluasi_durasi' => $durasi,
				'ljs_last' => $d['datetime'],
				// 'ljs_count' => ++$d['evaluasi']['ljs_count'],
		);
		// echo "<pre>";
		// print_r($Uljs);
		// print_r($d);
		// $this->_dump();
		$this->db->trans_start();
		$this->db->update('kbm_evaluasi_ljs', $Uljs,array('id' => $ljs['id']));

		//$ljs['id'] = $this->db->insert_id();
		$nilai['ljs_id'] = $ljs['id'];

		/*foreach (array_keys($jawaban_array) as $i)
			$jawaban_array[$i]['ljs_id'] = $ljs['id'];
		*/
		//$this->db->insert_batch('kbm_evaluasi_jawaban', $jawaban_array);
		$this->db->update('kbm_evaluasi_nilai', $nilai, array('user_id' => $this->input->get_post('siswa_id'),'kelas_id' => $this->input->get_post('kelas_id'),'evaluasi_id' => $this->input->get_post('id'),'evaluasi_terkoreksi' => 0));

		//if ($Uljs['dikoreksi']):
			//$this->update_nilai($d['evaluasi']['id']);
		//else:
			//$this->update_pengerjaan($d['evaluasi']['id']);
		//endif;

		$msg_sukses = ($Uljs['dikoreksi']) ? 'Jawaban dan nilai berhasil disimpan.' : 'Jawaban telah disimpan, menunggu koreksi guru.';

		return $this->trans_done($msg_sukses, 'Database error, coba beberapa saat lagi.');
	}
	/*
	function save() {
		$d = & $this->ci->d;

		if ($d['user']['role'] != 'siswa')
			return !alert_info('Simulasi berhasil, nilai tidak disimpan.');

		$start_dtm = (isset($d['form']['dtm_start'])) ? $d['form']['dtm_start'] : $d['date'];
		$durasi = (isset($d['form']['time_start'])) ? ($d['form']['time_start'] - $d['time']) : 7200;
		$ljs = array(
				'evaluasi_id' => $d['evaluasi']['id'],
				'user_id' => $d['user']['id'],
				'kelas_id' => (int) cfgu('kelas_id'),
				'trial' => $d['evaluasi']['trial'],
				'waktu' => $start_dtm,
				'dikoreksi' => (($d['evaluasi']['pilihan_jml'] > 1) ? $d['datetime'] : NULL),
				'nilai' => 0,
				'poin' => 0,
				'poin_max' => 0,
				'durasi' => $durasi,
				'ip' => $this->input->ip_address(),
				'client' => client_agent(),
				'selesai' =>1,
		);
		$jawaban_array = array();

		foreach ($d['soal_result']['data'] as $soal):
			soal_prepare($soal);

			$name = "butir-{$soal['id']}";
			$ljs['poin_max'] += $soal['poin_max'];
			$_raw = array('soal_id' => $soal['id']);
			$_jwb = (string) $this->input->post($name);

			if ($ljs['dikoreksi']):
				$_jwb = trim($_jwb);
				$pilihan_valid = (strlen($_jwb) == 1);
				$kunci = array_node($soal, 'pilihan', 'kunci', 'index');
				$_raw['pilihan'] = ($pilihan_valid) ? $_jwb : '';
				$_raw['poin'] = ($_raw['pilihan'] == $kunci) ? $soal['poin_max'] : 0;
				$ljs['poin'] += $_raw['poin'];

			else:
				$_jwb = (string) clean_html($_jwb);
				$_raw['jawaban'] = base64_encode($_jwb);

			endif;

			$jawaban_array[] = $_raw;

		endforeach;

		if ($ljs['dikoreksi']):
			$ljs['nilai'] = 100 * $ljs['poin'] / $ljs['poin_max'];
		endif;

		$nilai = array(
				'evaluasi_terkoreksi' => (bool) $ljs['dikoreksi'],
				'evaluasi_nilai' => $ljs['nilai'],
				'evaluasi_poin' => $ljs['poin'],
				'evaluasi_poin_max' => $ljs['poin_max'],
				'evaluasi_durasi' => $durasi,
				'ljs_last' => $d['datetime'],
				'ljs_count' => ++$d['evaluasi']['ljs_count'],
		);

		$this->db->trans_start();
		$this->db->insert('kbm_evaluasi_ljs', $ljs);

		$ljs['id'] = $this->db->insert_id();
		$nilai['ljs_id'] = $ljs['id'];

		foreach (array_keys($jawaban_array) as $i)
			$jawaban_array[$i]['ljs_id'] = $ljs['id'];

		$this->db->insert_batch('kbm_evaluasi_jawaban', $jawaban_array);
		$this->db->update('kbm_evaluasi_nilai', $nilai, array('id' => $d['evaluasi']['nilai_id']));

		if ($ljs['dikoreksi']):
			$this->update_nilai($d['evaluasi']['id']);
		else:
			$this->update_pengerjaan($d['evaluasi']['id']);
		endif;

		$msg_sukses = ($ljs['dikoreksi']) ? 'Jawaban dan nilai berhasil disimpan.' : 'Jawaban telah disimpan, menunggu koreksi guru.';

		return $this->trans_done($msg_sukses, 'Database error, coba beberapa saat lagi.');
	}
   */
	function save_koreksi() {
		$d = & $this->ci->d;
		$nilai_utama= 0;
		$poin 		= 0;
		$poin_max 	= 0;
		
		$nilai_isian	= 0;
		$poin_isian 	= 0;
		$poin_max_isian = 0;
		
		$nilai_uraian		= 0;
		$poin_uraian 		= 0;
		$poin_max_uraian 	= 0;
		$no = 0;
		$jwb_dat = array();

		foreach ($d['butir_result']['data'] as $butir):
			soal_prepare($butir);

			$no++;
			$_input_koreksi = "koreksi-{$butir['id']}";
			$_koreksi = $this->input->post($_input_koreksi);
			
			$_input = "poin-{$butir['id']}";
			$_poin = (int) ($this->input->post($_input));
			
			if($butir['type']==3){
				$poin_max_uraian += $butir['poin_max'];
				$poin_uraian += $_poin;
			}elseif($butir['type']==2){
				$poin_max_isian += $butir['poin_max'];
				$poin_isian += $_poin;
			}else{
				$poin_max += $butir['poin_max'];
				$poin += $_poin;
			}

			if ($_poin < $butir['poin_min'] OR $_poin > $butir['poin_max']):
				alert_error("Poin jawaban pertanyaan {$no} harus antara {$butir['poin_min']} sampai {$butir['poin_max']}");
				continue;
			endif;

			$jwb_dat[] = array(
					'where' => array(
							'ljs_id' => $d['row']['id'],
							'soal_id' => $butir['id'],
					),
					'data' => array(
							'poin' 		=> $_poin,
							'koreksi' 	=> $_koreksi,
					),
			);

		endforeach;

		if ($d['error'])
			return FALSE;

		// mulai simpan poin
		$total_nilai=0;
		$pembagi_nilai=0;
		
		//utama
		$nilai_utama	= $poin / $poin_max * 100;
		$total_nilai 	= ($d['evaluasi']['bobot_pilgan'] * $nilai_utama);
		$pembagi_nilai 	= $d['evaluasi']['bobot_pilgan'];
		
		// isian
		if($d['evaluasi']['plus_isian']==1){
			$nilai_isian	= $poin_isian / $poin_max_isian * 100;
			$total_nilai 	= $total_nilai + ($d['evaluasi']['bobot_isian'] * $nilai_isian);
			$pembagi_nilai 	= $pembagi_nilai + $d['evaluasi']['bobot_isian'];
		}
		
		// uraian
		if($d['evaluasi']['plus_uraian']==1){
			$nilai_uraian	= $poin_uraian / $poin_max_uraian * 100;
			$total_nilai 	= $total_nilai + ($d['evaluasi']['bobot_uraian'] * $nilai_uraian);
			$pembagi_nilai 	= $pembagi_nilai + $d['evaluasi']['bobot_uraian'];
		}
		
		$ljs = array(
				'dikoreksi' 		=> $d['datetime'],
				'poin' 				=> $poin,
				'poin_max' 			=> $poin_max,
				'poin_isian' 		=> $poin_isian,
				'poin_max_isian' 	=> $poin_max_isian,
				'poin_uraian' 		=> $poin_uraian,
				'poin_max_uraian' 	=> $poin_max_uraian,
				'nilai' 			=> ( $total_nilai / $pembagi_nilai),
				'nilai_utama' 		=> $nilai_utama,
				'nilai_isian' 		=> $nilai_isian,
				'nilai_uraian' 		=> $nilai_uraian,
		);

		$nilai = array(
				'evaluasi_terkoreksi' 		=> TRUE,
				'evaluasi_nilai' 			=> $ljs['nilai'],
				'evaluasi_nilai_utama' 		=> $nilai_utama,
				'evaluasi_nilai_isian' 		=> $nilai_isian,
				'evaluasi_nilai_uraian' 	=> $nilai_uraian,
				'evaluasi_poin' 			=> $poin,
				'evaluasi_poin_max' 		=> $poin_max,
				'evaluasi_poin_isian' 		=> $poin_isian,
				'evaluasi_poin_max_isian' 	=> $poin_max_isian,
				'evaluasi_poin_uraian' 		=> $poin_uraian,
				'evaluasi_poin_max_uraian' 	=> $poin_max_uraian,
		);
		//print_r($d['evaluasi']);
		//print_r($ljs);
		$this->db->trans_start();
		$this->db->update('kbm_evaluasi_ljs', $ljs, array('id' => $d['row']['id']));
		$this->db->update('kbm_evaluasi_nilai', $nilai, array('ljs_id' => $d['row']['id']));

		foreach ($jwb_dat as $dat):
			$this->db->update('kbm_evaluasi_jawaban', $dat['data'], $dat['where']);
		endforeach;

		$trx = $this->trans_done('Nilai berhasil disimpan.', 'Database error, coba beberapa saat lagi.');

		if ($trx):
			$this->db->trans_start();
			$this->update_nilai($d['evaluasi']['id']);
			$this->trans_done();
		endif;

		return $trx;
	}

	function butir_ljs($ljs_id) {
		$query = array(
				'from' => 'kbm_evaluasi_soal soal',
				'join' => array(
						array('kbm_evaluasi_jawaban jwb', 'soal.id = jwb.soal_id', 'inner'),
				),
				'where' => array(
						'jwb.ljs_id' => $ljs_id,
				),
				'select' => array(
						'soal.*',
						'jwb_poin' => 'jwb.poin',
						'jwb_pilihan' => 'jwb.pilihan',
						'jwb_jawaban' => 'jwb.jawaban',
						'jwb_koreksi' => 'jwb.koreksi',
				),
				'order_by' => 'soal.id',
		);

		return $this->md->query($query)->result();
	}

	function soal($evaluasi, $pengerjaan_ljs_id = 0) {
		
		$randomize_indexed = ($evaluasi['soal_acak'] && $evaluasi['soal_jml'] > 0 && $evaluasi['soal_total'] > $evaluasi['soal_jml']);
		
		if(($pengerjaan_ljs_id == 0) or ($pengerjaan_ljs_id == '')){
			/*
			$query = array(
					'from' => 'kbm_evaluasi_soal',
					'where' => array(
							'evaluasi_id' => $evaluasi['id'],
					),
			);
	
			if ($evaluasi['soal_jml'] > 0)
				$query['limit'] = $evaluasi['soal_jml'];
			//return alert_error("a ".$pengerjaan_ljs_id);
			
			if ($randomize_indexed)
				$query['order_by'] = 'hit_count, rand()';
	
			else if ($evaluasi['soal_acak'])
				$query['order_by'] = 'rand()';
			*/
			$tampil_kd = 1;
			$query = "";
			
			$random="";
			if ($evaluasi['soal_acak']){
				$random = 'ORDER BY rand()';
			}
			
			/// ISIAN URAIAN 
			if(($evaluasi['plus_isian']==1)||($evaluasi['plus_uraian']==1)){
				$query = " ( ";
			}
			
			while($tampil_kd <= $evaluasi['jml_kd']){
				// chek pembagian kd
				
				if($tampil_kd>1){
					$query .= " UNION ";
				}
				$this->load->model('m_kbm_evaluasi_pembagian_kd');
				$row_pembagian_kd = $this->m_kbm_evaluasi_pembagian_kd->rowset($evaluasi['id'], $tampil_kd);
				
				$limit ='';
				if(isset($row_pembagian_kd['soal_jml'])){
					if($row_pembagian_kd['soal_jml']){
						$limit = " LIMIT ".$row_pembagian_kd['soal_jml']." ";
					}
				}
				
				$query .= " ( 	SELECT * 
								FROM kbm_evaluasi_soal
								WHERE 
									evaluasi_id = '".$evaluasi['id']."' 
									AND
									posisi_kd = '".$tampil_kd."' 
									".$random." 
									".$limit." 
									
							) ";
				$tampil_kd++;
			}
			
			if ($evaluasi['soal_acak']){
				$query .=" ORDER BY rand() ";
			}else{
				$query .=" ORDER BY nomor , id ASC";
			}
			
			$add_on_soal =2;
			while($add_on_soal>0){
				$add_soal=0;
				/// ISIAN 
				if($add_on_soal==2){
					if($evaluasi['plus_isian']==1){
						$tampil_kd = 99;
						$add_soal=1;
					}
				}
				/// URAIAN
				if($add_on_soal==1){
					if($evaluasi['plus_uraian']==1){
						$tampil_kd = 999;
						$add_soal=1;
					}
				}
				
				if($add_soal==1){
					$this->load->model('m_kbm_evaluasi_pembagian_kd');
					$row_pembagian_kd = $this->m_kbm_evaluasi_pembagian_kd->rowset($evaluasi['id'], $tampil_kd);
					
					$limit ='';
					if(isset($row_pembagian_kd['soal_jml'])){
						if($row_pembagian_kd['soal_jml']){
							$limit = " LIMIT ".$row_pembagian_kd['soal_jml']." ";
						}
					}
					
					$query .= " ) UNION (( 	SELECT * 
									FROM kbm_evaluasi_soal 
									WHERE 
										evaluasi_id = '".$evaluasi['id']."' 
										AND
										posisi_kd = '".$tampil_kd."' 
										".$random." 
										".$limit." 
										
								) ";
								
					if ($evaluasi['soal_acak']){
						$query .=" ORDER BY rand() ";
					}else{
						$query .=" ORDER BY nomor , id ASC";
					}
				}
				
				$add_on_soal--;
			}
			
			
			/// ISIAN URAIAN 
			if(($evaluasi['plus_isian']==1)||($evaluasi['plus_uraian']==1)){
				$query .= " ) ";
			}
			
			$result = $this->md->result($query);
		}else{
			
			$query = array(
					'select' => array('soal.*',),
					'from' => 'kbm_evaluasi_soal soal',
					'join' => array(
							array('kbm_evaluasi_jawaban jwb', 'soal.id = jwb.soal_id', 'inner'),
					),
					'where' => array(
							'soal.evaluasi_id' => $evaluasi['id'],
							'jwb.ljs_id' => $pengerjaan_ljs_id,
					),
					'order_by' => 'jwb.no_urut',
			);
			
			$result = $this->md->query($query)->result();
			//return alert_error("b");
		}
		
		

			
		

		if (!$randomize_indexed OR $result['selected_rows'] == 0)
			return $result;

		$soal_list = array();

		foreach ($result['data'] as $soal)
			$soal_list[] = $soal['id'];

		$list_string = implode(',', $soal_list);

		$sql = "update kbm_evaluasi_soal set hit_count = hit_count + 1 where id in ({$list_string})";

		$this->db->query($sql);

		return $result;
	}

	function update_nilai($evaluasi_id) {
		$sql_evaluasi = "
update kbm_evaluasi evaluasi
inner join
(
	select
		evaluasi_id,
		min(evaluasi_poin) poin_min,
		max(evaluasi_poin) poin_max,
		avg(evaluasi_poin) rata2_poin,
		avg(evaluasi_nilai) rata2_nilai,
		count(id) siswa_total,
		count(ljs_id) siswa_menjawab
	from kbm_evaluasi_nilai
	where trial = 0
		and evaluasi_id = ?
	group by evaluasi_id
)	nilai
	on evaluasi.id = nilai.evaluasi_id
set
	evaluasi.poin_min = nilai.poin_min,
	evaluasi.poin_max = nilai.poin_max,
	evaluasi.rata2_poin = nilai.rata2_poin,
	evaluasi.rata2_nilai = nilai.rata2_nilai,
	evaluasi.siswa_total = nilai.siswa_total,
	evaluasi.siswa_menjawab = nilai.siswa_menjawab,
	evaluasi.analisa_valid = 0
where
	evaluasi.id = ?";
		$sql_evakls = "
update kbm_evaluasi_kelas evakls
inner join
(
	select
		evaluasi_id,
		kelas_id,
		avg(evaluasi_nilai) rata2_nilai,
		count(id) siswa_total,
		count(ljs_id) siswa_menjawab
	from kbm_evaluasi_nilai
	where trial = 0
		and kelas_id is not null
		and evaluasi_id = ?
	group by evaluasi_id, kelas_id
) nilai
	on evakls.evaluasi_id = nilai.evaluasi_id and evakls.kelas_id = nilai.kelas_id
set
	evakls.rata2_nilai = nilai.rata2_nilai,
	evakls.siswa_total = nilai.siswa_total,
	evakls.siswa_menjawab = nilai.siswa_menjawab
where evakls.evaluasi_id = ?";

		$this->db->query($sql_evakls, array($evaluasi_id, $evaluasi_id));
		$this->db->query($sql_evaluasi, array($evaluasi_id, $evaluasi_id));
	}

	function update_pengerjaan($evaluasi_id) {
		$sql_evaluasi = "
update kbm_evaluasi evaluasi
inner join
(
	select
		evaluasi_id,
		count(id) siswa_total,
		count(ljs_id) siswa_menjawab
	from kbm_evaluasi_nilai
	where trial = 0
		and evaluasi_id = ?
	group by evaluasi_id
)	nilai
	on evaluasi.id = nilai.evaluasi_id
set
	evaluasi.siswa_total = nilai.siswa_total,
	evaluasi.siswa_menjawab = nilai.siswa_menjawab
where
	evaluasi.id = ?";
		$sql_evakls = "
update kbm_evaluasi_kelas evakls
inner join
(
	select
		evaluasi_id,
		kelas_id,
		count(id) siswa_total,
		count(ljs_id) siswa_menjawab
	from kbm_evaluasi_nilai
	where trial = 0
		and kelas_id is not null
		and evaluasi_id = ?
	group by evaluasi_id, kelas_id
) nilai
	on evakls.evaluasi_id = nilai.evaluasi_id and evakls.kelas_id = nilai.kelas_id
set
	evakls.siswa_total = nilai.siswa_total,
	evakls.siswa_menjawab = nilai.siswa_menjawab
where evakls.evaluasi_id = ?";

		$this->db->query($sql_evakls, array($evaluasi_id, $evaluasi_id));
		$this->db->query($sql_evaluasi, array($evaluasi_id, $evaluasi_id));
	}

	function roleback() {
		
		$d = & $this->ci->d;
		
		/// additional time
		$query = array(
				'select' => array(
						'*',	
				),
				'from' => 'kbm_evaluasi_ljs',
				
		);
		$query['where']['id'] = $d['row']['id'];
		
		$row = $this->md->query($query)->row();
		
		//print_r($row);
		$waktu_pengerjaan 		= strtotime($row['waktu']); 
		$time					= explode(':',$this->input->get('time'));
		
		if($time[1]){
			if($time[1]>60){
				alert_error("Format penambahan waktu salah","kbm/evaluasi/id/{$d['row']['evaluasi_id']}");
			}
		}else{
			alert_error("Format penambahan waktu salah","kbm/evaluasi/id/{$d['row']['evaluasi_id']}");
		}
		
		$waktu_tambahan 		= (int)$time[0] * 3600 + (int)$time[1] * 60;
		
		$waktu					= $waktu_pengerjaan + $waktu_tambahan;
		$waktu_pengerjaan_baru 	= date("Y-m-d H:i:s", $waktu);
		
		//echo $row['waktu']." a ".$waktu_tambahan." a ".$waktu_pengerjaan." a ".$waktu_tambahan." a ".$waktu." a ".$waktu_pengerjaan_baru ;
		
		$ljs = array(
				'waktu' => $waktu_pengerjaan_baru,
				'roleback_by' => $d['user']['id'] ,
				'dikoreksi' => NULL,
				'poin' => 0,
				'poin_max' => 0,
				'nilai' => 0,
				'durasi' => 0,
				'selesai' => 0,
		);

		$nilai = array(
				'evaluasi_terkoreksi' => FALSE,
				'evaluasi_nilai' => 0,
				'evaluasi_poin' => 0,
				'evaluasi_poin_max' => 0,
				'ljs_id' => NULL,
				'ljs_last' => NULL,
				'ljs_count' => 0,
		);
		
		$this->db->trans_start();
		$this->db->update('kbm_evaluasi_ljs', $ljs, array('id' => $d['row']['id']));
		$this->db->update('kbm_evaluasi_nilai', $nilai, array('ljs_id' => $d['row']['id']));
		
		$this->trans_done('LJS berhasil di role back pengerjaan.', 'Database error, coba beberapa saat lagi.');
		
	}
	
	function surveillance($index = 0, $limit = 50){
		
		$d = & $this->ci->d;
		$r = & $this->ci->d['request'];
		
		$query = array(
				'select' => array(
						//'evanil.*',
						'kelas_nama'	=> 'kelas.nama',
						'siswa_id' 		=> 'siswa.id',
						'siswa_nis' 	=> 'siswa.nis',
						'siswa_nisn' 	=> 'siswa.nisn',
						'siswa_nama' 	=> 'siswa.nama',
						'siswa_gender' 	=> 'siswa.gender',
						//'ljs_id'		=>	'ljs.id',
						//'ljs_waktu'		=>	'ljs.waktu',
						//'ljs_dikoreksi'	=>	'ljs.dikoreksi',
						'waktu_absensi'		=> 'absensi.time',
						'kode_image_absensi'=> 'absensi.kode',
						'image_absensi'		=> 'absensi.image',
				),
				'from' => 'kbm_evaluasi_nilai evanil',
				'join' => array(
						array('dprofil_siswa siswa', 'evanil.user_id = siswa.id', 'inner'),
						array('dakd_kelas kelas', 'evanil.kelas_id = kelas.id', 'inner'),
						//array('kbm_evaluasi_ljs ljs', 'evanil.ljs_id = ljs.id', 'left'),
						array(
							'kbm_evaluasi_absensi absensi', 
							'absensi.evaluasi_id = evanil.evaluasi_id AND absensi.user_id = siswa.id ', 
							'left'
						),
				),
				
		);
		$query['where']['evanil.evaluasi_id'] = $r['evaluasi_id'];
		if($r['kelas_id'] >0){
			$query['where']['evanil.kelas_id'] = $r['kelas_id'];	
		}
		$query['order_by'] = 'kelas_nama ASC, siswa.nama ASC';
		
		$resulset = $this->md->query($query)->resultset($index, $limit);
		
		//print_r($resulset);
		$jml_soal=0;
		foreach($resulset['data'] as &$siswa){
			//echo "<br>".$siswa['siswa_id'];
			
			$query = array(
				'select' => array(
						'jawaban.*',
						'soal_pertanyaan'	=>	'soal.pertanyaan',
						'soal_type'		=>	'soal.type',
						'soal_pilihan'	=>	'soal.pilihan',
						'ljs_id'		=>	'ljs.id',
						'ljs_nilai'		=>	'ljs.nilai',
						'ljs_awal_waktu'=>	'ljs.awal_waktu',
						'ljs_waktu'		=>	'ljs.waktu',
						'ljs_dikoreksi'	=>	'ljs.dikoreksi',
						'ljs_selesai'	=> 	'ljs.selesai',
						'ljs_roleback_nama'	=> 'user.nama',
				),
				'from' => 'kbm_evaluasi_ljs ljs',
				'join' => array(
						array('kbm_evaluasi_jawaban jawaban', 'jawaban.ljs_id = ljs.id', 'left'),
						array('kbm_evaluasi_soal soal', 'soal.id = jawaban.soal_id', 'left'),
						array('data_user user', 'user.id = ljs.roleback_by', 'left'),
				),
				'order_by' => 'ljs.id ASC, jawaban.no_urut ASC',
			);
			$query['where']['ljs.evaluasi_id'] = $r['evaluasi_id'];
			$query['where']['ljs.user_id'] = $siswa['siswa_id'];
			
			$_jawaban = $this->md->query($query)->resultset($index, 200);
			
			// ljs
			$siswa['ljs_id']		= '';
			$siswa['ljs_waktu']		= '';
			$siswa['ljs_dikoreksi']	= '';
			$siswa['ljs_selesai']	= '';
			
			foreach($_jawaban['data'] as $jwb){
				// ljs
				$siswa['ljs_id']		= $jwb['ljs_id'];
				$siswa['ljs_nilai']		= $jwb['ljs_nilai'];
				$siswa['ljs_awal_waktu']= $jwb['ljs_awal_waktu'];
				$siswa['ljs_waktu']		= $jwb['ljs_waktu'];
				
				$siswa['ljs_dikoreksi']	= $jwb['ljs_dikoreksi'];
				$siswa['ljs_selesai']		= $jwb['ljs_selesai'];
				
				// Encode
				$jwb['soal_pilihan'] = json_decode($jwb['soal_pilihan'], TRUE);
				$siswa['soal_pilihan'.$jwb['no_urut']] = $jwb['pilihan'];
				
				$siswa['soal_pertanyaan'.$jwb['no_urut']] = base64_decode($jwb['soal_pertanyaan']);
				$siswa['soal_point'.$jwb['no_urut']] = $jwb['poin'];
				$status_jawab_benar='<font color="red">SALAH</font>';
				if($jwb['poin']>0){
					$status_jawab_benar='<font color="green">BENAR</font>';
				}
				$siswa['soal_status'.$jwb['no_urut']] = $status_jawab_benar;
				
				if (isset($jwb['soal_pilihan']['kunci'])){
					/// PILGAN
				
					if (isset($jwb['soal_pilihan']['kunci']['label']))
						$jwb['soal_pilihan']['kunci']['label'] = base64_decode($jwb['soal_pilihan']['kunci']['label']);
					else
						$jwb['soal_pilihan']['kunci']['label'] = NULL;
					
					if (!isset($jwb['soal_pilihan']['pengecoh']) OR ! is_array($jwb['soal_pilihan']['pengecoh'])):
						$jwb['soal_pilihan']['pengecoh'] = array();

					else:
						foreach (array_keys($jwb['soal_pilihan']['pengecoh']) as $index):
							$jwb['soal_pilihan']['pengecoh'][$index] = base64_decode($jwb['soal_pilihan']['pengecoh'][$index]);
						endforeach;
					endif;
					// -end
					//print_r($jwb['soal_pilihan']);
					//echo"<br>";
					
					
					
						// pilgan
						if($jwb['soal_pilihan']['kunci']['index'] == $jwb['pilihan']){
							$siswa['soal_label'.$jwb['no_urut']] = $jwb['soal_pilihan']['kunci']['label'];
						}elseif($jwb['pilihan']!=''){
								if(isset($jwb['soal_pilihan']['pengecoh'][$jwb['pilihan']])){
									$siswa['soal_label'.$jwb['no_urut']] = $jwb['soal_pilihan']['pengecoh'][$jwb['pilihan']];
								}
							
						}else{
							$siswa['soal_label'.$jwb['no_urut']] = '';
						}
					
				}else{
					// ISIAN URAIAN
					$siswa['soal_pilihan'.$jwb['no_urut']] = base64_decode($jwb['jawaban']);
					$siswa['soal_label'.$jwb['no_urut']] = base64_decode($jwb['jawaban']);
				}
				//$siswa['soal_poin'.$jwb['no_urut']] = $jwb['poin'];
				$siswa['soal_update'.$jwb['no_urut']] = $jwb['modified'];
				
				if($jwb['no_urut']>$jml_soal){
					$jml_soal = $jwb['no_urut'];
				}
			}
			
			
		}
		
		foreach($resulset['data'] as &$siswa){
			$no_cek=1;
			while($jml_soal>=$no_cek){
				if(!isset($siswa['soal_pilihan'.$no_cek])){
					$siswa['soal_pilihan'.$no_cek] 	= '-';
					$siswa['soal_label'.$no_cek]	= '-';
					
					$siswa['soal_update'.$no_cek] 	= '';
				}
				$no_cek++;
			}
		}
		
		$resulset['jml_soal'] = $jml_soal;
		
		//print_r($resulset);
		
		return $resulset;
		
	}
	
	function nama_file(){
		$r = & $this->ci->d['request'];
		$query = array(
				'select' => array(
						'eva.*',
						'pengajar'		=> 'sdm.nama',
						'semester_nama'	=> 'semester.nama',
						'ta_nama'		=> 'ta.nama',
						
				),
				'from' => 'kbm_evaluasi eva',
				'join' => array(
						array('dakd_pelajaran pelajaran', 'eva.pelajaran_id = pelajaran.id', 'inner'),
						array('dprofil_sdm sdm', 'pelajaran.guru_id = sdm.id', 'inner'),
						array('prd_semester semester', 'eva.semester_id = semester.id', 'inner'),
						array('prd_ta ta', 'semester.ta_id = ta.id', 'inner'),
				),
		);
		
		$query['where']['eva.id'] = $r['evaluasi_id'];
		
		return $this->md->query($query)->resultset(0, 1);
	}
	
	function download_surveillance($index = 0, $limit = 50){
		$d = & $this->ci->d;
		$nama_file = $this->nama_file();
		$this->load->helper('excel');
		
		/// SHOW LIMIT
		//print_r($d['resultset']);
		$data_selesai		='';
		$data_sedang_kerja	='';
		$data_belum_kerja	='';
		$total_rows['selesai']=0;
		$total_rows['sedang_kerja']=0;
		$total_rows['belum_kerja']=0;
		foreach($d['resultset']['data'] as $data){
			if(!$data['ljs_id']){
				$data_belum_kerja[] = $data;
				$total_rows['belum_kerja']++;
			}elseif($data['ljs_selesai']==0){
				$data_sedang_kerja[] = $data;
				$total_rows['sedang_kerja']++;
			}else{
				$data_selesai[]		 = $data;
				$total_rows['selesai']++;
			}
		}	
		$title='';
		if($this->input->get('selesai')){
			$title = " <font color='green'>Semua Peserta Selesai Mengerjakan</font>";
			$d['resultset']['data'] = $data_selesai;
			$d['resultset']['total_rows'] 	= $total_rows['selesai'];
			$d['resultset']['selected_rows'] = $d['resultset']['total_rows'];
			$d['resultset']['end']		 	= $d['resultset']['total_rows'];
		}
		if($this->input->get('sedang_kerja')){
			$title = " <font color='orange'>Semua Peserta Sedang Mengerjakan</font>";
			$d['resultset']['data'] = $data_sedang_kerja;
			$d['resultset']['total_rows'] 	= $total_rows['sedang_kerja'];
			$d['resultset']['selected_rows'] = $d['resultset']['total_rows'];
			$d['resultset']['end']		 	= $d['resultset']['total_rows'];
		}
		if($this->input->get('belum_kerja')){
			$title = " <font color='red'>Semua Belum Peserta Mengerjakan</font>";
			$d['resultset']['data'] 			= $data_belum_kerja;
			$d['resultset']['total_rows'] 	= $total_rows['belum_kerja'];
			$d['resultset']['selected_rows'] = $d['resultset']['total_rows'];
			$d['resultset']['end']		 	= $d['resultset']['total_rows'];
		}
		////
		
		$fallback = 'kbm/evaluasi_nilai' . array2qs();
		$no = 0;
		$awal_rowexcel = 6;
		$rowexcel = $awal_rowexcel;
		
		$array_opsi = array(
			'-' => '0',
			'a' => '1',
			'b' => '2',
			'c' => '3',
			'd' => '4',
			'e' => '5',
		);
		
		$file_path = APP_ROOT."content/".strtolower(APP_SCOPE)."/template/kbm-evaluasi-nilai.xls";
		
		$map = array(
				'B' => 'kelas_nama',
				'C' => 'siswa_nama',
				'D' => 'siswa_gender',
				//'E' => 'evaluasi_nilai',
				'H' => 'ljs_awal_waktu',
				'I' => 'ljs_dikoreksi',
		);
		
		if ($d['resultset']['selected_rows'] == 0)
			return alert_error('Data nilai kosong, periksa filter pencarian Anda.', $fallback);

		$this->load->library('PHPExcel');

		$objPHPExcel = PHPExcel_IOFactory::load($file_path);
		$style_border = array(
				'borders' => array(
						'allborders' => array(
								'style' => PHPExcel_Style_Border::BORDER_THIN
						)
				)
		);
		$style_nilai = array(
				'alignment' => array(
						'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
				),
		);
		$styleGreen = array(
			'fill' => array(
				'type'	 => PHPExcel_Style_Fill::FILL_SOLID,
				'color'	 => array('rgb' => '66FF99'),
			)
		);
		
		$styleYellow = array(
			'fill' => array(
				'type'	 => PHPExcel_Style_Fill::FILL_SOLID,
				'color'	 => array('rgb' => 'FFFF66'),
			)
		);
		
		$styleRed = array(
			'fill' => array(
				'type'	 => PHPExcel_Style_Fill::FILL_SOLID,
				'color'	 => array('rgb' => 'DD9898'),
			)
		);
		
		$styleGrey = array(
			'fill' => array(
				'type'	 => PHPExcel_Style_Fill::FILL_SOLID,
				'color'	 => array('rgb' => '808080'),
			)
		);
		
		if (!$objPHPExcel)
			return alert_error('Excel error.', $fallback);

		$sheet = $objPHPExcel->setActiveSheetIndex(0);
		
		$judul_kelas_nama='';
		
		if ($d['resultset']['selected_rows'] == 0)
			return alert_error('Data nilai kosong, periksa filter pencarian Anda.', $fallback);

		$this->load->library('PHPExcel');

		$objPHPExcel = PHPExcel_IOFactory::load($file_path);
		$style_border = array(
				'borders' => array(
						'allborders' => array(
								'style' => PHPExcel_Style_Border::BORDER_THIN
						)
				)
		);
		$style_nilai = array(
				'alignment' => array(
						'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
				),
		);
		$styleGreen = array(
			'fill' => array(
				'type'	 => PHPExcel_Style_Fill::FILL_SOLID,
				'color'	 => array('rgb' => '66FF99'),
			)
		);
		
		$styleYellow = array(
			'fill' => array(
				'type'	 => PHPExcel_Style_Fill::FILL_SOLID,
				'color'	 => array('rgb' => 'FFFF66'),
			)
		);
		
		$styleRed = array(
			'fill' => array(
				'type'	 => PHPExcel_Style_Fill::FILL_SOLID,
				'color'	 => array('rgb' => 'DD9898'),
			)
		);
		
		$styleGrey = array(
			'fill' => array(
				'type'	 => PHPExcel_Style_Fill::FILL_SOLID,
				'color'	 => array('rgb' => '808080'),
			)
		);
		
		if (!$objPHPExcel)
			return alert_error('Excel error.', $fallback);

		$sheet = $objPHPExcel->setActiveSheetIndex(0);
	
		//$sheet->getColumnDimension('D')->setVisible(FALSE);
		$sheet->getColumnDimension('E')->setVisible(FALSE);
		$sheet->getColumnDimension('F')->setVisible(FALSE);
		$sheet->getColumnDimension('G')->setVisible(FALSE);
		// $sheet->getColumnDimension('H')->setVisible(FALSE);
		// $sheet->getColumnDimension('I')->setVisible(FALSE);
		
		$sheet->getColumnDimension('AP')->setWidth(2);
		//$sheet->getColumnDimension('J')->setVisible(FALSE);
		//$sheet->getColumnDimension('K')->setVisible(FALSE);
		
		$excel_col_offset = ord('K') - 65;
		$col_no = $excel_col_offset;
		
		$cfg = array(
				'row.nikls'		 => array(
					// top header
					'A1' => array(
						'nama',
						'strtoupper',
						'prefix' => 'NAMA EVALUASI : ',
					),
					'A2' => array(
						'pengajar',
						'strtoupper',
						'prefix' => 'GURU : ',
					),
					'A3' => array(
						'kkm',
						'prefix' => 'KKM : ',
					),
					'A4' => array(
						'semester_nama',
						'strtoupper',
						'prefix' => 'SEMESTER  ',
						'suffix' => array(
							' TAHUN ',
							'ta_nama',
						),
					),
					'H5' => array(
						'',
						'prefix' => 'Awal Mengerjakan',
					),
					'I5' => array(
						'',
						'prefix' => 'Akhir Mengerjakan',
					),
				),
			);
		
		excel_row_write($sheet, $nama_file['data'][0], $cfg['row.nikls']);
		
			
		$jml_soal=0;
		
		$awal_coloumn = "AQ";
		$awal_merge = $awal_coloumn.'4';
		
		
		//print_r($d['soal_array']);
		$tampil_soal = 1;
		while($tampil_soal <= $d['resultset']['jml_soal']){
			
			$s0al['excol']['pilihan'][$tampil_soal] = excel_colnumber(++$col_no);
			$cell_soal_pilihan = $s0al['excol']['pilihan'][$tampil_soal].'5';
			
			$sheet->setCellValue($cell_soal_pilihan, 'No.'.$tampil_soal);
			
			$sheet->getColumnDimension($s0al['excol']['pilihan'][$tampil_soal])->setWidth(6);
			
			$tampil_soal++;
		}
		
		// mulai isi nilai
		$jml_sis_tidak_ikut=0;
		$judul_kelas_nama='kosong';
		//print_r($d);
		$col_soal_pertama ='';
		foreach ($d['resultset']['data'] as $row):
			$no++;
			$rowexcel++;
			/// posisi soal pertama
			if($col_soal_pertama == ''){
				$col_soal_pertama = $rowexcel;
			}
			
			$judul_kelas_nama = $row['kelas_nama'];
			foreach ($map as $colex => $coldb):
				if(isset($row[$coldb])){
					$sheet->setCellValue($colex . $rowexcel, $row[$coldb]);
				}
			endforeach;

			$sheet->setCellValue("A" . $rowexcel, $no);
			
			$jml_soal=0;
			$tampil_soal = 1;
			while($tampil_soal <= $d['resultset']['jml_soal']){
			
				if(isset($row['soal_pilihan'.$tampil_soal])){
					$cell_soal_pilihan	= $s0al['excol']['pilihan'][$tampil_soal] . $rowexcel;
					
					$sheet->setCellValue($cell_soal_pilihan, strtoupper($row['soal_pilihan'.$tampil_soal]));
					
				}
				$tampil_soal++;	
			}
		endforeach;
		
		$set_font = 8;
		
		if(!isset($s0al)){
			$s0al['excol']['pilihan'][$tampil_soal-1] = "I";
		}
		// format font size
		$sheet->getStyle("A1:G4")->getFont()->setBold(true);
		$sheet->getStyle("A1:".$s0al['excol']['pilihan'][$tampil_soal-1].$rowexcel)->getFont()->setSize($set_font);
		
		// format garis & align
		$sheet->getStyle("A1:G4")->getFont()->setBold(true);
		$sheet->getStyle("A5:".$s0al['excol']['pilihan'][$tampil_soal-1]."5")->getFont()->setBold(true);
		$sheet->getStyle("A5:".$s0al['excol']['pilihan'][$tampil_soal-1].$rowexcel)->applyFromArray($style_border);
		
		
		
		// output file 
		header("Content-Type: application/vnd.ms-excel");
		
		if($d['request']['kelas_id']){
			$sheet->setCellValue('E2','Kelas : '.$judul_kelas_nama);
			$sheet->getColumnDimension('B')->setVisible(FALSE);
			header("Content-Disposition: attachment; filename=\"surveillance_evaluasi_{$nama_file['data'][0]['nama']}_{$nama_file['data'][0]['pengajar']}_({$judul_kelas_nama})_({$d['request']['evaluasi_id']}).xls\"");
		}else{
			header("Content-Disposition: attachment; filename=\"surveillance_evaluasi_{$nama_file['data'][0]['nama']}_{$nama_file['data'][0]['pengajar']}_({$d['request']['evaluasi_id']}).xls\"");
		}
		header("Cache-Control: max-age=0");
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, "Excel5");
		$objWriter->save("php://output");
		exit();
	}
	
}

