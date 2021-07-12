<?php

class M_kbm_evaluasi_soal extends MY_Model {

	var $filetypes = array('mp3','wma','ogg','m4a','mpeg','wav','webma');
	var $filetypes2 = array('pdf','doc','docx,','xls','xlsx');
	
	public function __construct() {
		parent::__construct(array(
				'fields' => array(
						'nomor', 
						'pertanyaan', 
						'poin_max', 
						'posisi_kd', 
						'materi', 
						'level_kognitif', 
						'indikator'
					),
				'sql' => array(
						'update-soal_jml' => "update kbm_evaluasi evaluasi inner join (select evaluasi_id, count(*) as jml from kbm_evaluasi_soal where evaluasi_id = ? group by evaluasi_id) soal on evaluasi.id = soal.evaluasi_id set evaluasi.soal_total = soal.jml where evaluasi.id = ?",
					),
		));
	}
	function query_1()
	{
		$d = & $this->ci->d;
		$r = $this->ci->d['request'];
		$query = array(
				'select'	 => array(
					'soal.*',
					'type_kd'		=> 'komp_dasar.type_nomor',
					'ket_type_kd'	=> 'komp_dasar.nama',
				),
				'from' => 'kbm_evaluasi_soal soal',
				'join'		 => array(
					array('dakd_kompetensi_dasar komp_dasar', 'soal.komp_dasar_id = komp_dasar.id', 'left'),
				),
				'order_by' => 'soal.nomor,  soal.posisi_kd, soal.id ',
		);
		if(isset($r['posisi_kd'])){
			$query['where']['posisi_kd'] = $r['posisi_kd'];
		}
		if(isset($r['evaluasi_id'])){
			if($r['evaluasi_id']>0){
				$query['where']['soal.evaluasi_id'] = $r['evaluasi_id'];
			}
		}
		if(isset($r['term'])){
			$query['like'] = array($r['term'], array('soal.cuplikan'));
		}
		
		return $query;
	}
	// operasi data

	function browse($index = 0, $limit = 20) {
		
		$query = $this->query_1();

		return $this->md->query($query)->resultset($index, $limit);
	}

	function delete() {
		$d = & $this->ci->d;
		$kriteria['id'] = $d['row']['id'];

		$this->db->trans_start();
		$this->db->delete('kbm_evaluasi_soal', $kriteria);
		$this->update_soal_total($d['row']['evaluasi_id']);

		return $this->trans_done("Soal telah terhapus.", 'Database error, coba beberapa saat lagi.');
	}

	function rowset($id) {
		//$row = $this->md->rowset($id, 'kbm_evaluasi_soal');
		$d = & $this->ci->d;
		
		$query = $this->query_1();
		$query['where']['soal.id'] = $id;
		$row = $this->md->query($query)->row();
		
		if ($row)
			soal_prepare($row);

		return $row;
	}

	function upload($upload_path, $input)
	{
		// var
		//$input = 'upload';

		$upload = array(
			'upload_path' => $upload_path,
			//'file_name' => $file_name,
			'allowed_types' => '*',
			//'max_size' => 8192,
			'overwrite' => TRUE,
		);

		// cek adanya upload
		if (!isset($_FILES[$input]) OR $_FILES[$input]['size'] <= 0)
		{
			return NULL;
		}

		// init library
		$this->load->library('upload');
		$this->upload->initialize($upload);

		// upload
		$do_upload = $this->upload->do_upload($input);

		// bila gagal
		if ($do_upload == FALSE)
		{
			return alert_error($this->upload->display_errors());
		}

		// data file yg diupload
		$file = $this->upload->data();

		// menganti absolute path menjadi relative
		$file['file_path'] = path_relative($file['file_path']);
		$file['full_path'] = path_relative($file['full_path']);

		// ekstensi yg diupload
		$upload_ext = trim($file['file_ext'], ' .');

		// bila file bukan excel
		if ((!in_array($upload_ext, $this->filetypes))&&(!in_array($upload_ext, $this->filetypes2)))
		{
			@unlink($file['full_path']);
			if($input != "sound"){
				return alert_error('Tipe file tidak sesuai. Seharusnya berekstensi: ' . implode(', ', $this->filetypes2));
			}else{
				return alert_error('Tipe file tidak sesuai. Seharusnya berekstensi: ' . implode(', ', $this->filetypes));
			}
			
		}

		// mengembalikan data upload
		return $file;

	}
	
	function save() {
		$d = & $this->ci->d;
		$edit = (bool) $d['form']['id'];
		$soal_id = (int) $d['form']['id'];
		$evaluasi_id = (int) $d['form']['evaluasi_id'];
		
		$upload_path = APP_ROOT."content/".strtolower(APP_SCOPE)."/sound/";
		$input = "audio";
		$upload_sound = $this->upload($upload_path,$input);
		// atasi upl

		$this->form->ruleset($d['row'], 'validasi');
		$this->form->validate();

		if ($d['error'])
			return FALSE;

		$data = $this->input('fields');
		$data['posisi_kd'] = clean($data['posisi_kd']);
		if($data['posisi_kd']>0){
			// clean
		}else{
			$data['posisi_kd']=1;
		}
		$data['cuplikan'] = (string) clean($data['pertanyaan']);
		$data['pertanyaan'] = base64_encode($data['pertanyaan']);
			
		$data['nilai_bonus'] = 0;
		$data['audio'] = '';
		
		
		// baca pilihan
		if($this->input->post('uraian')==1){
			//
		}else if($this->input->post('isian')==1){
			$kunsian = 1;
			while($kunsian<=9){
				$data['kunci_isian'.$kunsian] 		   = (string) clean($this->input->post('kunci_isian'.$kunsian));
			}
			$data['toleran_huruf_kapital'] = $this->input->post('toleran_huruf_kapital');
		}
		else{
			if ($d['evaluasi']['pilihan_jml'] > 1):

				//vars

				$opsi_maxlen = 32000;
				$opsi = array('a', 'b', 'c', 'd', 'e');

				// index kunci

				$kunci_index = array_node($d['row'], 'pilihan', 'kunci', 'index');

				if (!$kunci_index OR !$edit):
					$registered = array_nodex($d['row'], array('registered'), $d['time']);
					$kunci_index = opsi_rand($registered);
					$data['pilihan']['kunci']['index'] = $kunci_index;
				else:
					$data['pilihan']['kunci']['index'] = $kunci_index;
				endif;

				opsi_del($opsi, $kunci_index);
				shuffle($opsi);

				// pilihan kunci

				$d['pilihan']['kunci'] = clean_html($this->input->post('kunci'));

				if (empty($d['pilihan']['kunci'])):
					alert_error('Kunci pilihan harus diisi.');

				elseif (strlen($d['pilihan']['kunci']) > $opsi_maxlen):
					alert_error('Kunci pilihan terlalu panjang.');

				else:
					$data['pilihan']['kunci']['label'] = base64_encode($d['pilihan']['kunci']);

				endif;


				for ($i = 1; $i < $d['evaluasi']['pilihan_jml']; $i++):
					$_nama = "pengecoh-{$i}";
					$d['pilihan'][$_nama] = clean_html($this->input->post($_nama));

					if (empty($d['pilihan'][$_nama])):
						alert_error("Pengecoh {$i} harus diisi.");

					elseif (strlen($d['pilihan'][$_nama]) > $opsi_maxlen):
						alert_error("Pengecoh {$i} terlalu panjang.");

					else:
						$index = array_shift($opsi);
						$data['pilihan']['pengecoh'][$index] = base64_encode($d['pilihan'][$_nama]);

					endif;

				endfor;

				if ($d['error'])
					return FALSE;

				$data['pilihan'] = json_encode($data['pilihan']);

			endif;
		}

		if ($d['error'])
			return FALSE;

		// mulai simpan data

		if ($edit):
			$this->db->trans_start();
			if($upload_sound)
			{
				$data['audio'] = $upload_sound['full_path'];
			}
			$this->db->update('kbm_evaluasi_soal', $data, array('id' => $d['form']['id']));

			return $this->trans_done('Butir soal berhasil disimpan.', 'Database error, coba beberapa saat lagi.');

		endif;

		if($data['nomor']>0){
			
		}else{
			$data['nomor'] = 0;
		}
		$data['evaluasi_id'] = $evaluasi_id;
		$data['registered'] = $d['datetime'];

		$this->db->trans_start();
		$this->db->insert('kbm_evaluasi_soal', $data);

		$soal_id = $this->db->insert_id();
		$trx_status = $this->db->trans_status();

		if (!$trx_status OR !$soal_id)
			return $this->trans_rollback('Database error, coba beberapa saat lagi.');

		$this->update_soal_total($evaluasi_id);

		$trx = $this->trans_done('Butir soal berhasil disimpan.', 'Database error, coba beberapa saat lagi.');

		if ($trx)
			$d['form']['id'] = $soal_id;

		return $trx;
	}
	
	function save_abc() {
		$d = & $this->ci->d;
		$edit = (bool) $d['form']['id'];
		$soal_id = (int) $d['form']['id'];
		$evaluasi_id = (int) $d['form']['evaluasi_id'];
		
		$upload_path = APP_ROOT."content/".strtolower(APP_SCOPE)."/sound/";
		$input = "audio";
		$upload_sound = $this->upload($upload_path,$input);
		// atasi upl

		$this->form->ruleset($d['row'], 'validasi');
		$this->form->validate();

		if ($d['error'])
			return FALSE;

		$data 					= $this->input('fields'); 
		$data['posisi_kd'] 		= clean($data['posisi_kd']);
		$data['nilai_bonus'] 	= $this->input->post('nilai_bonus');  
		$quer['kunci_abc'] 		= clean($this->input->post('kunci_abc'));   
		if($quer['kunci_abc'] === 0){
			$quer['kunci_abc'] = 'a';
		}
		if($data['posisi_kd']>0){
			// clean
		}else{
			$data['posisi_kd']=1;
		}
		$data['cuplikan'] = (string) clean($data['pertanyaan']);
		$data['pertanyaan'] = base64_encode($data['pertanyaan']);
		
		$data['audio'] = '';
		
		/// CEK INPUT KETERANGAN TAMBAHAN
		if($this->input->post('type_kd')!=""){
			$query_kd = array(
				'select'	 => array(
					'komp_dasar.*'
				),
				'from' => 'dakd_kompetensi_dasar komp_dasar',
				'where'		 => array(
					'komp_dasar.kurikulum_id' 	=> $d['evaluasi']['kurikulum_id'],
					'komp_dasar.kategori_id' 	=> $d['evaluasi']['kategori_id'],
					'komp_dasar.mapel_id' 		=> $d['evaluasi']['mapel_id'],
					'komp_dasar.grade' 			=> $d['evaluasi']['kelas_grade'],
					'komp_dasar.type_nomor'		=> $this->input->post('type_kd'),
				),
			);
			
			$row_kd = $this->md->query($query_kd)->row();
			
			if($row_kd['id']){
				$data['komp_dasar_id']	= $row_kd['id'];
				
				if(trim($this->input->post('ket_type_kd'))!=''){
					$data_kd['nama'] 			= $this->input->post('ket_type_kd');
					
					//// UPDATE KD
					$this->db->trans_start();
					$this->db->update('dakd_kompetensi_dasar', $data_kd, array('id' => $row_kd['id']));
					$this->trans_done();
					////////////////////
				}
				
			}else{
				$data_kd['kurikulum_id'] 	= $d['evaluasi']['kurikulum_id'];
				$data_kd['kategori_id'] 	= $d['evaluasi']['kategori_id'];
				$data_kd['mapel_id'] 		= $d['evaluasi']['mapel_id'];
				$data_kd['grade'] 			= $d['evaluasi']['kelas_grade'];
				$data_kd['type_nomor'] 		= $this->input->post('type_kd');
				$kd_type_nomor 				= explode(".",$data_kd['type_nomor']);
				$data_kd['nama'] 			= $this->input->post('ket_type_kd');
				$data_kd['kode']			= "KD".$kd_type_nomor[1];
				$data_kd['kode_erapor_teori']	= '';
				$data_kd['kode_erapor_praktek']	= '';
				$data_kd['modified'] 				= $this->d['datetime'];
				$data_kd['modifier_id'] 			= $this->d['user']['id'];
				
				//// INSERT KD
				$this->db->trans_start();
				$this->db->insert('dakd_kompetensi_dasar', $data_kd);
				$data['komp_dasar_id'] = $this->db->insert_id();
				$this->trans_done();
				//////////////////////
			}
		}
		
		// baca pilihan
		if($this->input->post('uraian')==1){
			$data['type'] 		   			= 3;
		}else if($this->input->post('isian')==1){
			$kunsian = 1;
			while($kunsian<=9){
				$data['kunci_isian'.$kunsian] 		   	= (string) clean($this->input->post('kunci_isian'.$kunsian));
				$data['kunci_isian'.$kunsian] 			= base64_encode($data['kunci_isian'.$kunsian]);
				$kunsian++;
			}
			$data['toleran_huruf_kapital'] 	= $this->input->post('toleran_huruf_kapital');
			$data['type'] 		   			= 2;
		}
		else{
			if ($d['evaluasi']['pilihan_jml'] >= 1):

				//vars

				$opsi_maxlen = 32000;
				$opsi = array(1 => 'a', 'b', 'c', 'd', 'e');

				// index kunci

				for ($i = 1; $i <= $d['evaluasi']['pilihan_jml']; $i++):
					$_nama = "pengecoh-{$opsi[$i]}";
					$d['pilihan'][$_nama] = clean_html($this->input->post($_nama));

					if (empty($d['pilihan'][$_nama])):
						alert_error("Pengecoh {$opsi[$i]}  harus diisi.");

					elseif (strlen($d['pilihan'][$_nama]) > $opsi_maxlen):
						alert_error("Pengecoh {$opsi[$i]} terlalu panjang.");

					else: 
						if($quer['kunci_abc']!= $opsi[$i]):  
							$data['pilihan']['pengecoh'][$opsi[$i]] = base64_encode($d['pilihan'][$_nama]);
						else:
							$data['pilihan']['kunci']['index'] = $opsi[$i];
							$data['pilihan']['kunci']['label'] = base64_encode($d['pilihan'][$_nama]);
						endif; 

					endif;

				endfor;
	 
				if ($d['error'])
					return FALSE;

				$data['pilihan'] = json_encode($data['pilihan']);

			endif;
		}

		if ($d['error'])
			return FALSE;

		// mulai simpan data

		if ($edit):
			$this->db->trans_start();
			if($upload_sound)
			{
				$data['audio'] = $upload_sound['full_path'];
			}
			$this->db->update('kbm_evaluasi_soal', $data, array('id' => $d['form']['id']));

			return $this->trans_done('Butir soal berhasil disimpan.', 'Database error, coba beberapa saat lagi.');

		endif;

		if($data['nomor']>0){
			
		}else{
			$data['nomor'] = 0;
		}
		
		$data['evaluasi_id'] = $evaluasi_id;
		$data['registered'] = $d['datetime'];

		$this->db->trans_start();
		$this->db->insert('kbm_evaluasi_soal', $data);

		$soal_id = $this->db->insert_id();
		$trx_status = $this->db->trans_status();

		if (!$trx_status OR !$soal_id)
			return $this->trans_rollback('Database error, coba beberapa saat lagi.');

		$this->update_soal_total($evaluasi_id);

		$trx = $this->trans_done('Butir soal berhasil disimpan.', 'Database error, coba beberapa saat lagi.');

		if ($trx)
			$d['form']['id'] = $soal_id;

		return $trx;
	}
	function save_kunci() {
		
		$d = & $this->ci->d;
		$edit = (bool) $d['form']['id'];
		$soal_id = (int) $d['form']['id'];
		$evaluasi_id = (int) $d['form']['evaluasi_id'];
		
		$upload_path = APP_ROOT."content/".strtolower(APP_SCOPE)."/sound/";
		$input = "audio";
		$upload_sound = $this->upload($upload_path,$input);
		// atasi upl

		$this->form->ruleset($d['row'], 'validasi');
		$this->form->validate();

		if ($d['error'])
			return FALSE;

		$data = $this->input('fields'); 
		$data['posisi_kd'] = clean($data['posisi_kd']);
		$quer['kunci_abc'] = clean($this->input->post('kunci_abc'));   
		if($quer['kunci_abc'] === 0){
			$quer['kunci_abc'] = 'a';
		}
		if($data['posisi_kd']>0){
			// clean
		}else{
			$data['posisi_kd']=1;
		}
		$data['cuplikan'] = (string) clean($data['pertanyaan']);
		$data['pertanyaan'] = base64_encode($data['pertanyaan']);
		//if(isset($data['nilai_bonus'])){
			$data['nilai_bonus'] = 0;
		//}
		//if(isset($data['audio'])){
			$data['audio'] = '';
		//}
		
		// baca pilihan

		if ($d['evaluasi']['pilihan_jml'] >= 1):

			//vars

			$opsi_maxlen = 32000;
			$opsi = array(1 => 'a', 'b', 'c', 'd', 'e');

			// index kunci

			for ($i = 1; $i <= $d['evaluasi']['pilihan_jml']; $i++):
				$_nama = "pengecoh-{$opsi[$i]}";
				$d['pilihan'][$_nama] = clean_html($this->input->post($_nama));

				if (empty($d['pilihan'][$_nama])):
					alert_error("Pengecoh {$opsi[$i]}  harus diisi.");

				elseif (strlen($d['pilihan'][$_nama]) > $opsi_maxlen):
					alert_error("Pengecoh {$opsi[$i]} terlalu panjang.");

				else: 
					if($quer['kunci_abc']!= $opsi[$i]):  
						$data['pilihan']['pengecoh'][$opsi[$i]] = base64_encode($d['pilihan'][$_nama]);
					else:
						$data['pilihan']['kunci']['index'] = $opsi[$i];
						$data['pilihan']['kunci']['label'] = base64_encode($d['pilihan'][$_nama]);
					endif; 

				endif;

			endfor;
 
			if ($d['error'])
				return FALSE;

			$data['pilihan'] = json_encode($data['pilihan']);

		endif;

		if ($d['error'])
			return FALSE;

		// mulai simpan data

		if ($edit):
			$this->db->trans_start();
			if($upload_sound)
			{
				$data['audio'] = $upload_sound['full_path'];
			}
			$this->db->update('kbm_evaluasi_soal', $data, array('id' => $d['form']['id']));

			return $this->trans_done('Butir soal berhasil disimpan.', 'Database error, coba beberapa saat lagi.');

		endif;

		if($data['nomor']>0){
			
		}else{
			$data['nomor'] = 0;
		}
		
		$data['evaluasi_id'] = $evaluasi_id;
		$data['registered'] = $d['datetime'];

		$this->db->trans_start();
		// for($asd = 1;$asd <=30;$asd++){
			
			// $data['nomor'] = $asd;
			$this->db->insert('kbm_evaluasi_soal', $data);
		// }

		$soal_id = $this->db->insert_id();
		$trx_status = $this->db->trans_status();

		if (!$trx_status OR !$soal_id)
			return $this->trans_rollback('Database error, coba beberapa saat lagi.');

		$this->update_soal_total($evaluasi_id);

		$trx = $this->trans_done('Butir soal berhasil disimpan.', 'Database error, coba beberapa saat lagi.');

		if ($trx)
			$d['form']['id'] = $soal_id;

		return $trx;
	}
	function save2()
	 {
		$d = & $this->ci->d;
		$edit = (bool) $d['form']['id'];
		$soal_id = (int) $d['form']['id'];
		$evaluasi_id = (int) $d['form']['evaluasi_id'];
		
		$upload_path1 = APP_ROOT."content/".strtolower(APP_SCOPE)."/soal/".$evaluasi_id."/soal/";
		if (!file_exists($upload_path1)) {
			mkdir($upload_path1, 0755, true);
		}	
		$input1 = "upload_soal";
		$file1 = $this->upload($upload_path1,$input1);
		// atasi upl

		$this->form->ruleset($d['row'], 'validasi');
		///$this->form->validate();
		
		//$input = 'pdf,doc,docx,xls,xlsx,ppt,pptx,odt,ods,odp,jpg,jpeg,png,gif,zip,rar';
		//$file = $this->upload($upload_path,$input);
		
		if ($d['error'])
			return FALSE;
		
		//////def all post///////
		$post = array();
		foreach ( $_POST as $key => $value )
		{
			$post[$key] = $this->input->post($key);
		}
		
		
		////varrs////
		$data = $this->input('fields');
		$data1['upload_kunci'] =  json_encode($post);
		$data1['soal_total'] =   $post['jumlah_soal'];
		$save_file = explode("/",$file1['full_path']);
		$data1['upload_soal'] = $save_file[5];
		
		///////set kunci dan pengecoh////////
		$data['pecah_jawaban'] = explode(",",$post['jawaban']);
		for ($h = 0; $h < $post['jumlah_soal']; $h++):
			$set_kunci = "a";
			if(isset($data['pecah_jawaban'][$h])){
				$set_kunci = $data['pecah_jawaban'][$h];
			}
			
			/////vars

			$opsi_maxlen = 32000;
			$opsi = array('a', 'b', 'c', 'd', 'e');

			// index kunci

			$kunci_index = array_node($d['row'], 'pilihan', 'kunci', 'index');

			if (!$kunci_index OR !$edit):
				$registered = array_nodex($d['row'], array('registered'), $d['time']);
				$kunci_index = opsi_rand($registered);
				$data['pilihan']['kunci']['index'] = $kunci_index;
			else:
				$data['pilihan']['kunci']['index'] = $kunci_index;
			endif;

			opsi_del($opsi, $kunci_index);
			shuffle($opsi);

			// pilihan kunci

			$d['pilihan']['kunci'] = $set_kunci;

			if (empty($d['pilihan']['kunci'])):
				alert_error('Kunci pilihan harus diisi.');

			elseif (strlen($d['pilihan']['kunci']) > $opsi_maxlen):
				alert_error('Kunci pilihan terlalu panjang.');

			else:
				$data['pilihan']['kunci']['label'] = base64_encode($d['pilihan']['kunci']);

			endif;

			$k = 1;
			for ($i = 1; $i < $d['evaluasi']['pilihan_jml']; $i++):
				//if()
				//$j = $i -$k;
				
				//if($opsi[$j] == $set_kunci){
				//	$k = 0;
				//}
				//$l = $i -$k;
				////$_nama = "pengecoh-{$i}";
				//$d['pilihan'][$_nama] = clean_html($this->input->post($_nama));

				///if (empty($d['pilihan'][$_nama])):
				///	alert_error("Pengecoh {$i}  harus diisi.");

				///elseif (strlen($d['pilihan'][$_nama]) > $opsi_maxlen):
				///	alert_error("Pengecoh {$i} terlalu panjang.");

				//else:
					$index = array_shift($opsi);
					$data['pilihan']['pengecoh'][$index] = base64_encode("x");

				///endif;

			endfor;

			if ($d['error'])
				return FALSE;

			$data2[$h]['pilihan'] = json_encode($data['pilihan']);
			
		endfor;
		
		//$data['pilihan']['kunci']['label']
		//$data['pilihan']['pengecoh'][$index]
		///$data['pilihan'] = json_encode($data['pilihan']);
		
		
		$this->db->trans_start();
		///// masukkan pilihan jawaban
		for ($i = 0; $i < $post['jumlah_soal']; $i++):
		
		////vars
			$data2[$i]['evaluasi_id'] = $evaluasi_id;
			$data2[$i]['registered'] = $d['datetime'];
			$data2[$i]['poin_max'] = 10;
		
			$this->db->insert('kbm_evaluasi_soal', $data2[$i]);
		endfor;
		

		//$this->db->update('kbm_evaluasi', $data, array('id' => $d['form']['id']));
		
		$this->db->update('kbm_evaluasi', $data1, array('id' => $evaluasi_id));
		
		//$soal_id = $this->db->insert_id();
		$trx_status = $this->db->trans_status();

		if (!$trx_status)
			return $this->trans_rollback('Database error, coba beberapa saat lagi.');

		//$this->update_soal_total($evaluasi_id);

		$trx = $this->trans_done('Butir soal berhasil disimpan.', 'Database error, coba beberapa saat lagi.');

		if ($trx)
			$d['form']['id'] = $soal_id;

		return $trx;
	}
	
	function save3()
	{
		$d = & $this->ci->d;
		$edit = (bool) $d['form']['id'];
		$soal_id = (int) $d['form']['id'];
		$evaluasi_id = (int) $d['form']['evaluasi_id'];
		
		//////def all post///////
		$d['post'] = array();
		foreach ( $_POST as $key => $value )
		{
			$d['post'] = $this->input->post($key);
		}
		
		return $d;
	}
	function save3_penilaian_siswa1() {
		
		$d = & $this->ci->d;
		$edit = (bool) $d['form']['id'];
		$soal_id = (int) $d['form']['id'];
		$evaluasi_id = (int) $d['form']['evaluasi_id'];
		
		$data = array();
		// atasi upl

		$this->form->ruleset($d['row'], 'validasi');
		$this->form->validate();

		if ($d['error'])
			return FALSE;

		// $data2['hit_count'] = $this->input->post('jml_soal');
		$jml_soal = $this->input->post('jml_soal');
		
		$query = array(
				'from' => 'kbm_evaluasi',
				'where' => array(
						'id' => $evaluasi_id,
				),
		);
		// $eval =  $this->md->query($query)->resultset();
		
		$eval = $this->md->query($query)->result();
		// $nides_data = $nides_result['data'];
		
		// $data2['pertanyaan'] = $eval['data']['tipe'];
		// $data2['pertanyaan'] = json_encode($eval['data']);
		if($eval['data'][0]['pilihan_jml'] > 0){
			$pil_soal = json_encode(array("benar","salah"));
			$data2['cuplikan'] = (string) clean($pil_soal);
			
			// baca pilihan
			$opsi = array('b', 'e');
				
			$data['pilihan']['kunci']['index'] 		= $opsi[0];
			$data['pilihan']['kunci']['label'] 		= base64_encode("benar");

			opsi_del($opsi,0);
			shuffle($opsi);
	  
			$index = array_shift($opsi);
			$data['pilihan']['pengecoh'][$index] =  base64_encode("salah");
	 
			$data2['pilihan'] = json_encode($data['pilihan']);
		}
		// mulai simpan data 

		$data2['evaluasi_id'] = $evaluasi_id;
		$data2['registered'] = $d['datetime'];
		$data2['poin_max'] = 10; 

		// return "rx";
		$this->db->trans_start();

		for ($h = 0; $h < $jml_soal; $h++):
			$this->db->insert('kbm_evaluasi_soal', $data2);
			
			$soal_id = $this->db->insert_id();
			$trx_status = $this->db->trans_status();

			if (!$trx_status OR !$soal_id)
				return $this->trans_rollback('Database error, coba beberapa saat lagi.');

			$this->update_soal_total($evaluasi_id);

		endfor;
		$trx = $this->trans_done('Butir soal berhasil disimpan.', 'Database error, coba beberapa saat lagi.');

		if ($trx)
			$d['form']['id'] = $soal_id;
		return $trx;
	}
	function save3_edit_skor1() {
		
		$d = & $this->ci->d;
		$edit = (bool) $d['form']['id'];
		$soal_id = (int) $d['form']['id'];
		// $evaluasi_id = (int) $d['form']['evaluasi_id'];
		
		// atasi upl

		$this->form->ruleset($d['row'], 'validasi');
		$this->form->validate();

		if ($d['error'])
			return FALSE;

		// $data2['hit_count'] = $this->input->post('jml_soal');
		// $jml_soal = $this->input->post('jml_soal');
		
		
		// $data['evaluasi_id'] = $evaluasi_id;
		$data['registered'] = $d['datetime'];
		$data['poin_max'] = $this->input->post('poin_max');; 

		// return "rx";
		$this->db->trans_start();

		$this->db->update('kbm_evaluasi_soal', $data, array('id' => $d['form']['id']));
		$trx_status = $this->db->trans_status();

		if (!$trx_status)
			return $this->trans_rollback('Database error, coba beberapa saat lagi.');

		// $this->update_soal_total($evaluasi_id);

		$trx = $this->trans_done('Skor soal berhasil disimpan.', 'Database error, coba beberapa saat lagi.');

		if ($trx)
			$d['form']['id'] = $soal_id;
		return $trx;
	}
	function update_soal_total($evaluasi_id) {
		$sql = "update kbm_evaluasi evaluasi inner join (select evaluasi_id, count(*) as jml from kbm_evaluasi_soal where evaluasi_id = ? group by evaluasi_id) soal on evaluasi.id = soal.evaluasi_id set evaluasi.soal_total = soal.jml where evaluasi.id = ?";

		$this->db->query($sql, array($evaluasi_id, $evaluasi_id));
	}

	function ganti_kunci() {
		$d = & $this->ci->d;
		$id = $d['form']['id'];
		
		$evaluasi_id = (int) $d['form']['evaluasi_id'];
		
		$nilai_bonus = $this->input->post('nilai_bonus');
		$ganti_kunci = $this->input->post('ganti_kunci');
		//print_r($d['form']);
		//print_r($d['row']['pilihan']['pengecoh']);
		//echo $d['row']['pilihan']['kunci']['index']." label ".$d['row']['pilihan']['kunci']['label']." = ".$ganti_kunci." n ".$id." n ".$evaluasi_id;
		
		
		if($ganti_kunci>0){
			$no_pengecoh=0;
			$index_kunci = $d['row']['pilihan']['kunci']['index'];
			$label_kunci = $d['row']['pilihan']['kunci']['label'];
			
			$data['pilihan']['kunci']['index'] = '';
			foreach($d['row']['pilihan']['pengecoh'] as $index => $label){
				$no_pengecoh++;
				//echo $no_pengecoh." ".$index." ".$label." x ";
				if($ganti_kunci == $no_pengecoh){
					$data['pilihan']['kunci']['index'] = $index;
					$data['pilihan']['kunci']['label'] = base64_encode($label);
					
					//$data['pilihan']['pengecoh'][$index_kunci] = $label_kunci;
					$data['pilihan']['pengecoh'][$index_kunci] = base64_encode($label_kunci);
				}else{
					//$data['pilihan']['pengecoh'][$index] = $label;
					$data['pilihan']['pengecoh'][$index] = base64_encode($label);
				}
			}
			
			$data['pilihan'] 		= json_encode($data['pilihan']);
		}
		$data['nilai_bonus'] 	= $nilai_bonus;
		
		
		//echo $nilai_bonus." = ".$ganti_kunci." n ".$id." n ".$evaluasi_id;
		//print_r($data);
		
		$this->db->trans_start();

		$this->db->update('kbm_evaluasi_soal', $data, array('id' => $d['form']['id']));
		$trx_status = $this->db->trans_status();
		if (!$trx_status)
			return $this->trans_rollback('Database error, coba beberapa saat lagi.');

		$trx = $this->trans_done('Butir soal berhasil disimpan.', 'Database error, coba beberapa saat lagi.');

		
		return $trx;
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
	
	function download_kunci($index = 0, $limit = 50){
		$d = & $this->ci->d;
		$nama_file = $this->nama_file();
		$this->load->helper('excel');
		//print_r($d['resultset']);
		
		$fallback = 'kbm/evaluasi_soal' . array2qs();
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
	
		//$sheet->getColumnDimension('A')->setVisible(FALSE);
		$sheet->getColumnDimension('B')->setVisible(FALSE);
		$sheet->getColumnDimension('C')->setVisible(FALSE);
		$sheet->getColumnDimension('D')->setVisible(FALSE);
		$sheet->getColumnDimension('E')->setVisible(FALSE);
		$sheet->getColumnDimension('F')->setVisible(FALSE);
		$sheet->getColumnDimension('G')->setVisible(FALSE);
		$sheet->getColumnDimension('H')->setVisible(FALSE);
		$sheet->getColumnDimension('I')->setVisible(FALSE);
		$sheet->getColumnDimension('J')->setVisible(FALSE);
		$sheet->getColumnDimension('K')->setVisible(FALSE);
		
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
		
		$sheet->getColumnDimension('A')->setWidth(12);
		$sheet->setCellValue('A5', 'SOAL');
		$sheet->setCellValue('A6', 'KUNCI');
		
		foreach ($d['resultset']['data'] as &$s0al):
			
			soal_prepljs_print($s0al);
			//print_r($s0al['pilihan']['kunci']);
			$jml_soal++;
			$siswa_ikut_soal[$jml_soal]		= 0;
			
			$s0al['excol']['pilihan'] = excel_colnumber(++$col_no);
			
			$cell_soal_pilihan = $s0al['excol']['pilihan'].'5';
			$sheet->setCellValue($cell_soal_pilihan, $jml_soal);
			$sheet->getColumnDimension($s0al['excol']['pilihan'])->setWidth(5);
			
			$cell_soal_kunci = $s0al['excol']['pilihan'].'6';
			$sheet->setCellValue($cell_soal_kunci, $s0al['pilihan']['kunci']['label']);
			
			
			
			$last_excol = $s0al['excol']['pilihan'];
			
		endforeach;
	
		
		$set_font = 8;
		
		// format font size
		$sheet->getStyle("A1:G4")->getFont()->setBold(true);
		$sheet->getStyle("A1:".$last_excol.$rowexcel)->getFont()->setSize($set_font);
		//$sheet->getStyle("A1:".$max_coloumn.$rowexcel)->getFont()->setSize($set_font);
		
		// format garis & align
		$sheet->getStyle("A1:G4")->getFont()->setBold(true);
		$sheet->getStyle("A5:".$last_excol."5")->getFont()->setBold(true);
		$sheet->getStyle("A5:".$last_excol.$rowexcel)->applyFromArray($style_border);
	
		// output file 
		header("Content-Type: application/vnd.ms-excel");
		header("Content-Disposition: attachment; filename=\"kunci_evaluasi_{$nama_file['data'][0]['nama']}_{$nama_file['data'][0]['pengajar']}_({$d['request']['evaluasi_id']}).xls\"");
		
		header("Cache-Control: max-age=0");
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, "Excel5");
		$objWriter->save("php://output");
		exit();
	}
}

