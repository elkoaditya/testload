<?php

class M_kbm_evaluasi_soal extends MY_Model {

	var $filetypes = array('mp3','wma','ogg','m4a','mpeg','wav','webma');
	var $filetypes2 = array('pdf','doc','docx,','xls','xlsx');
	
	public function __construct() {
		parent::__construct(array(
				'fields' => array('pertanyaan', 'poin_max'),
				'sql' => array(
						'update-soal_jml' => "update kbm_evaluasi evaluasi inner join (select evaluasi_id, count(*) as jml from kbm_evaluasi_soal where evaluasi_id = ? group by evaluasi_id) soal on evaluasi.id = soal.evaluasi_id set evaluasi.soal_total = soal.jml where evaluasi.id = ?",
				),
		));
	}

	// operasi data

	function browse($index = 0, $limit = 20) {
		$r = $this->ci->d['request'];
		$query = array(
				'from' => 'kbm_evaluasi_soal',
				'where' => array(
						'evaluasi_id' => $r['evaluasi_id'],
				),
				'like' => array($r['term'], array('cuplikan')),
				'order_by' => 'id',
		);
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
		$row = $this->md->rowset($id, 'kbm_evaluasi_soal');

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
		$data['cuplikan'] = (string) clean($data['pertanyaan']);
		$data['pertanyaan'] = base64_encode($data['pertanyaan']);

		// baca pilihan

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
					alert_error("Pengecoh {$i}  harus diisi.");

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

}

