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
		$durasi = strtotime($d['evaluasi']['kelas_result']['data'][$kelas_id]['evaluasi_durasi']);
		
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
			
			shuffle($opsi);
			$opsi_baru='';
			foreach($opsi as $pilihan)
			{
				$opsi_baru .= $pilihan.',';
			}
			
			$jawab[$jml_array]['ljs_id']	= $insert_id;
			$jawab[$jml_array]['soal_id']	= $soal['id'];
			$jawab[$jml_array]['no_urut']	= $urut_soal;
			$jawab[$jml_array]['opsi']		= $opsi_baru;
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
		
		return $response;
	}
	
	function save_answer_essay(){
		$_jwb = (string) $this->input->post('jawaban');
		$_jwb = (string) clean_html($_jwb);
		$_jwb = base64_encode($_jwb);
		
		$soal_id = $this->input->post('soal_id');
		$ljs_id	= $this->input->post('ljs_id');
		
		if(($soal_id=='' || $ljs_id=='' || $_jwb=='')&&($this->input->post('simulasi')=='')){
			$response['warna'] = '#FF4444';	
			$response['message'] = 'Jawaban gagal disimpan, silahkan refresh.';	
		}else{
			
			$_raw = array(
				'soal_id'	=> $soal_id,
				'ljs_id'	=> $ljs_id,
				'jawaban'	=> $_jwb,
				'modified' => date('Y-m-d H:i:s'),
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
		endforeach;
		
		//$cetak='';
		$nilai_posisi_kd='';
		foreach ($d['soal_result']['data'] as $soal):
			soal_prepare($soal);

			$name = "butir-{$soal['id']}";
			$ljs['poin_max'] += $soal['poin_max'];
			$_raw = array('soal_id' => $soal['id']);
			
			$_raw['ljs_id'] = $ljs['id'];
			
			/// CHECK ESSAY
			if ($ljs['dikoreksi']=== NULL):
				$_jwb = (string) $this->input->post($name);
			
				$_jwb = (string) clean_html($_jwb);
				$_raw['jawaban'] = base64_encode($_jwb);
				
				$this->query_update_jawaban($_raw);
			endif;
			
			/// CHECK PILIHAN
			if(isset($jawaban[$soal['id']]))
			{				
				$_jwb = $jawaban[$soal['id']];
	
				if ($ljs['dikoreksi']):
					$_jwb = trim($_jwb);
					$pilihan_valid = (strlen($_jwb) == 1);
					$kunci = array_node($soal, 'pilihan', 'kunci', 'index');
					$_raw['pilihan'] = ($pilihan_valid) ? $_jwb : '';
					$_raw['poin'] = ($_raw['pilihan'] == $kunci) ? $soal['poin_max'] : 0;
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
				endif;
				
				$this->query_update_jawaban($_raw);
				//$jawaban_array[] = $_raw;
			}
		endforeach;
		//cetak coba 
		//echo $cetak;
		//return !alert_info($cetak);

		if ($ljs['dikoreksi']):
			$ljs['nilai'] = 100 * $ljs['poin'] / $ljs['poin_max'];
			
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
		if(($ljs['nilai']==0)||($ljs['nilai']==""))
		{
			$ljs['poin_max']=0;
			
			
			foreach ($d['soal_result']['data'] as $soal):
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
				$ljs['poin'] += $_raw['poin'];

				$this->query_update_jawaban($_raw,$_raw['pilihan']);
				//return !alert_info(print_r($_raw));
			endforeach;
			
			if ($ljs['dikoreksi']):
				$ljs['nilai'] = 100 * $ljs['poin'] / $ljs['poin_max'];
			endif;
			//return !alert_info($ljs['poin']);
		}
		/// SELESAI CHECK JIKA JARINGAN PUTUS DARI AWAL (NILAI 0)
		
		//$durasi = strtotime($d['evaluasi']['kelas_result']['data'][$kelas_id]['evaluasi_durasi']);
		$nilai = array(
				'evaluasi_terkoreksi' => (bool) $ljs['dikoreksi'],
				'evaluasi_nilai' => $ljs['nilai'],
				'evaluasi_poin' => $ljs['poin'],
				'evaluasi_poin_max' => $ljs['poin_max'],
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

		if ($ljs['dikoreksi']):
			//$this->update_nilai($d['evaluasi']['id']);
		else:
			$this->update_pengerjaan($d['evaluasi']['id']);
		endif;

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
				$_jwb = (string) $this->input->post($name);
			
				$_jwbs = (string) clean_html($_jwb);
				$_raw['jawaban'] = base64_encode($_jwbs);
				
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

		if ($Uljs['dikoreksi']):
			//$this->update_nilai($d['evaluasi']['id']);
		else:
			$this->update_pengerjaan($d['evaluasi']['id']);
		endif;

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
		$poin = 0;
		$poin_max = 0;
		$no = 0;
		$jwb_dat = array();

		foreach ($d['butir_result']['data'] as $butir):
			soal_prepare($butir);

			$no++;
			$_input = "poin-{$butir['id']}";
			$_poin = (int) ($this->input->post($_input));
			$poin_max += $butir['poin_max'];
			$poin += $_poin;

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
							'poin' => $_poin,
					),
			);

		endforeach;

		if ($d['error'])
			return FALSE;

		// mulai simpan poin

		$ljs = array(
				'dikoreksi' => $d['datetime'],
				'poin' => $poin,
				'poin_max' => $poin_max,
				'nilai' => (100 * $poin / $poin_max),
		);

		$nilai = array(
				'evaluasi_terkoreksi' => TRUE,
				'evaluasi_nilai' => $ljs['nilai'],
				'evaluasi_poin' => $poin,
				'evaluasi_poin_max' => $poin_max,
		);

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
		
		if($time[1]>60){
			alert_error("Format penambahan waktu salah","kbm/evaluasi/id/{$d['row']['evaluasi_id']}");
		}
		$waktu_tambahan 		= (int)$time[0] * 3600 + (int)$time[1] * 60;
		
		$waktu					= $waktu_pengerjaan + $waktu_tambahan;
		$waktu_pengerjaan_baru 	= date("Y-m-d H:i:s", $waktu);
		
		//echo $row['waktu']." a ".$waktu_tambahan." a ".$waktu_pengerjaan." a ".$waktu_tambahan." a ".$waktu." a ".$waktu_pengerjaan_baru ;
		
		$ljs = array(
				'waktu' => $waktu_pengerjaan_baru,
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
				),
				'from' => 'kbm_evaluasi_nilai evanil',
				'join' => array(
						array('dprofil_siswa siswa', 'evanil.user_id = siswa.id', 'inner'),
						array('dakd_kelas kelas', 'evanil.kelas_id = kelas.id', 'inner'),
						//array('kbm_evaluasi_ljs ljs', 'evanil.ljs_id = ljs.id', 'left'),
				),
				
		);
		$query['where']['evanil.evaluasi_id'] = $r['evaluasi_id'];
		$query['where']['evanil.kelas_id'] = $r['kelas_id'];
		
		$resulset = $this->md->query($query)->resultset($index, $limit);
		
		//print_r($resulset);
		$jml_soal=0;
		foreach($resulset['data'] as &$siswa){
			//echo "<br>".$siswa['siswa_id'];
			
			$query = array(
				'select' => array(
						'jawaban.*',
						'soal_pertanyaan'	=>	'soal.pertanyaan',
						'soal_pilihan'	=>	'soal.pilihan',
						'ljs_id'		=>	'ljs.id',
						'ljs_nilai'		=>	'ljs.nilai',
						'ljs_awal_waktu'=>	'ljs.awal_waktu',
						'ljs_waktu'		=>	'ljs.waktu',
						'ljs_dikoreksi'	=>	'ljs.dikoreksi',
						'ljs_selesai'	=> 	'ljs.selesai',
				),
				'from' => 'kbm_evaluasi_ljs ljs',
				'join' => array(
						array('kbm_evaluasi_jawaban jawaban', 'jawaban.ljs_id = ljs.id', 'left'),
						array('kbm_evaluasi_soal soal', 'soal.id = jawaban.soal_id', 'left'),
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
					
					$siswa['soal_pertanyaan'.$jwb['no_urut']] = base64_decode($jwb['soal_pertanyaan']);
					$siswa['soal_point'.$jwb['no_urut']] = $jwb['poin'];
					$status_jawab_benar='<font color="red">SALAH</font>';
					if($jwb['poin']>0){
						$status_jawab_benar='<font color="green">BENAR</font>';
					}
					$siswa['soal_status'.$jwb['no_urut']] = $status_jawab_benar;
					if($jwb['soal_pilihan']['kunci']['index'] == $jwb['pilihan']){
						$siswa['soal_label'.$jwb['no_urut']] = $jwb['soal_pilihan']['kunci']['label'];
					}elseif($jwb['pilihan']!=''){
						$siswa['soal_label'.$jwb['no_urut']] = $jwb['soal_pilihan']['pengecoh'][$jwb['pilihan']];
					}else{
						$siswa['soal_label'.$jwb['no_urut']] = '';
					}
				}else{
					// URAIAN
					
					$siswa['soal_pilihan'.$jwb['no_urut']] = json_decode($jwb['pilihan']);
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
	
}

