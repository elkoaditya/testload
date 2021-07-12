<?php

class M_kbm_bank_soal extends MY_Model
{
	var $filetypes = array('mp3','wma','ogg','m4a','mpeg','wav','webma');
	var $filetypes2 = array('pdf','doc','docx,','xls','xlsx');
	
	public function __construct()
	{
		parent::__construct(array(
				'fields' => array('komp_dasar_id', 'pertanyaan','kesukaran'),
				
		));
		$this->dm['admin'] = cfguc_admin('akses', 'kbm', 'evaluasi');
		$this->dm['view'] = cfguc_view('akses', 'kbm', 'evaluasi');
		$this->dm['mengajar_list'] = (array) cfgu('mengajar_list');
		$this->dm['pelajaran_list'] = (array) cfgu('pelajaran_list');

	}
	


	function query_1()
	{
		$d = & $this->ci->d;
		$dm = & $this->dm;
		$query = array(
			'from'		 => 'kbm_bank_soal bank_soal',
			'join'		 => array(
				array('dakd_kompetensi_dasar kompetensi_dasar', 'bank_soal.komp_dasar_id = kompetensi_dasar.id', 'left'),
				array('dprofil_sdm author', 'bank_soal.author_id = author.id', 'left'),
				array('dprofil_sdm editor', 'bank_soal.editor_id = editor.id', 'left'),
				array('dmst_kurikulum kurikulum', 'kompetensi_dasar.kurikulum_id = kurikulum.id', 'inner'),
				array('dakd_kategori_mapel kategori', 'kompetensi_dasar.kategori_id = kategori.id', 'inner'),
				array('dakd_mapel mapel', 'kompetensi_dasar.mapel_id = mapel.id', 'inner'),
				array('dmst_grade grade', 'kompetensi_dasar.grade = grade.id', 'left'),
				//array('dakd_pelajaran pelajaran', 'mapel.id = pelajaran.mapel_id', 'left'),
			),
			'order_by'	 => 'mapel.nama ASC, kompetensi_dasar.kode ASC, bank_soal.registered desc',
			'select'	 => array(
				'bank_soal.*',
				'kompetensi_dasar.kurikulum_id',
				'kompetensi_dasar.kategori_id',
				'kompetensi_dasar.mapel_id',
				'kompetensi_dasar.grade',
				
				'author_nama'		=> "trim(concat_ws(' ', author.prefix, author.nama, author.suffix))",
				'editor_nama'		=> "trim(concat_ws(' ', editor.prefix, editor.nama, editor.suffix))",
				
				'mapel_nama'	 	=> 'mapel.nama',
				'kategori_nama'	 	=> 'kategori.nama',
				'kurikulum_nama' 	=> 'kurikulum.nama',
				'grade_nama' 		=> 'grade.nama',
				'kd_kode' 			=> 'kompetensi_dasar.kode',
				'kd_nama'			=> 'kompetensi_dasar.nama',
				
				'kompetensi_nama' => "trim(concat_ws(' ', mapel.nama, grade.nama, kompetensi_dasar.kode, kompetensi_dasar.nama))",
			),
		);

		if (!$dm['view']):
			//$query['where']['bank_soal.author_id'] = $d['user']['id'];
			//$query['or_where']['bank_soal.editor_id'] = $d['user']['id'];
			
			$query['join'][] =  array('dakd_pelajaran pelajaran', 'mapel.id = pelajaran.mapel_id', 'left');
			$query['where_in']['pelajaran.id'] = $this->dm['mengajar_list'];
			$query['group_by'] = "bank_soal.id";
			//$this->db->where_in('id', $list);
		endif;

		
		return $query;

	}
	
	// dasar database

	function filter_1($query)
	{
		$d = & $this->ci->d;
		$r = & $this->ci->d['request'];
		$def = array(
			'term'			 => '',
			'semester_id'	 => $d['semaktif']['id'],
			'grade'	 		 => 0,
			'mapel_id'		 => 0,
			'kategori_id'	 => 0,
			'kurikulum_id'	 => 0,
			
		);

		// normalisasi

		array_default($r, $def);

		//if ($r['semester_id'] == 0)
			//$r['semester_id'] = $d['semaktif']['id'];

		// filtering

		if (!empty($r['term']))
			$query['like'] = 
				array(
					$r['term'], 
					array(
						'author.nama', 
						'editor.nama',
						'bank_soal.pertanyaan', 
						'kompetensi_dasar.kode',
						'kompetensi_dasar.nama',
						'mapel.nama',
						'kategori.nama',
						'kurikulum.nama',
						'grade.nama'
					)
				);

		if ($r['grade'] > 0)
			$query['where']['kompetensi_dasar.grade'] = $r['grade'];

		if ($r['mapel_id'] > 0)
			$query['where']['kompetensi_dasar.mapel_id'] = $r['mapel_id'];

		if ($r['kategori_id'] > 0)
			$query['where']['kompetensi_dasar.kategori_id'] = $r['kategori_id'];

		if ($r['kurikulum_id'] > 0)
		{
			if($r['kurikulum_id']==4){
				$r['kurikulum_id']=2;
			}
			$query['where']['kompetensi_dasar.kurikulum_id'] = $r['kurikulum_id'];
		}
		
		//if ($r['author_id'] > 0 && $d['user']['role'] == 'admin')
			//$query['where']['bank_soal.author_id'] = $r['author_id'];

		return $query;

	}
	
	function rowset($id) {
		
		$query = $this->query_1();
		$query['where']['bank_soal.id'] = $id;

		$row = $this->md->query($query)->row();
		
		//$row = $this->md->rowset($id, 'kbm_bank_soal');

		if ($row)
			soal_prepare($row);

		return $row;
	}
	
	function browse($index = 0, $limit = 20)
	{
		$query = $this->query_1();
		$query = $this->filter_1($query);

		return $this->md->query($query)->resultset($index, $limit);

	}
	
	function delete() {
		$d = & $this->ci->d;
		$kriteria['id'] = $d['row']['id'];

		$this->db->trans_start();
		$this->db->delete('kbm_bank_soal', $kriteria);
		//$this->update_soal_total($d['row']['evaluasi_id']);

		return $this->trans_done("Soal telah terhapus.", 'Database error, coba beberapa saat lagi.');
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
		//$evaluasi_id = (int) $d['form']['evaluasi_id'];
		
		$upload_path = APP_ROOT."content/".strtolower(APP_SCOPE)."/sound/";
		$input = "audio";
		$upload_sound = $this->upload($upload_path,$input);
		// atasi upl

		$this->form->ruleset($d['row'], 'validasi');
		$this->form->validate();

		if ($d['error'])
			return FALSE;

		$data = $this->input('fields');
		
		//set
		$data['poin_max'] = 10;
		$data['cuplikan'] = (string) clean($data['pertanyaan']);
		$data['pertanyaan'] = base64_encode($data['pertanyaan']);

		// baca pilihan

		//if ($d['evaluasi']['pilihan_jml'] > 1):

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

			$jml_pilihan=5;
			for ($i = 1; $i < $jml_pilihan; $i++):
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

		//endif;

		if ($d['error'])
			return FALSE;

		// mulai simpan data

		if ($edit):
			$data['updated']	 = $d['datetime'];
			$data['editor_id']	 = $d['user']['id'];
			
			$this->db->trans_start();
			if($upload_sound)
			{
				$data['audio'] = $upload_sound['full_path'];
			}
			$this->db->update('kbm_bank_soal', $data, array('id' => $d['form']['id']));

			return $this->trans_done('Butir soal berhasil disimpan.', 'Database error, coba beberapa saat lagi.');

		endif;

		$data['author_id'] = $d['user']['id'];
		$data['registered'] = $d['datetime'];

		$this->db->trans_start();
		
		$this->db->insert('kbm_bank_soal', $data);

		$soal_id = $this->db->insert_id();
		$trx_status = $this->db->trans_status();

		if (!$trx_status OR !$soal_id)
			return $this->trans_rollback('Database error, coba beberapa saat lagi.');

		//$this->update_soal_total($evaluasi_id);

		$trx = $this->trans_done('Butir soal berhasil disimpan.', 'Database error, coba beberapa saat lagi.');

		if ($trx)
			$d['form']['id'] = $soal_id;

		return $trx;
	}
	
	function save_to_evaluasi() {
		
		$d = & $this->ci->d;
		
		$evaluasi_id = (int) $this->input->post('evaluasi_id');
		$posisi_kd = $this->input->post('posisi_kd');
		$array_bank_soal = $this->input->post('input_soal');
		
		
		$this->db->trans_begin();
		
		$jml=0;
		$sql_bank_soal_id="";
		foreach($array_bank_soal as $bank_soal_id){
			$jml++;
			if($jml>1){
				$sql_bank_soal_id .= " OR ";
			}
			$sql_bank_soal_id .= "
				id = {$bank_soal_id}
			";
			
			$query_update_bank_soal = "
				UPDATE kbm_bank_soal
				SET jml_pakai = (jml_pakai + 1)
				WHERE id = {$bank_soal_id}
			";
			$this->db->query($query_update_bank_soal);
		}
		
		//alert_error("BBBB");
		//print_r($sql_bank_soal_id);
		
		$sql_butir_soal = <<<SQL

INSERT INTO
	kbm_evaluasi_soal
	(
		bank_soal_id, kesukaran, evaluasi_id,
		posisi_kd, audio, pertanyaan, pilihan_ganda, poin_min, poin_max, pilihan, registered
	)

SELECT
	id, kesukaran, {$evaluasi_id},
	{$posisi_kd}, audio, pertanyaan, pilihan_ganda, poin_min, poin_max, pilihan, registered

FROM
	kbm_bank_soal

WHERE
	{$sql_bank_soal_id}
;

SQL;

	
		//echo $sql_butir_soal;
		
		$this->db->query($sql_butir_soal);

		$this->update_soal_total($evaluasi_id);
		
		if ($this->db->trans_status() === FALSE)
		{
			$this->db->trans_rollback();

			return alert_error("error saat menjalankan: <br/> {$sql_butir_soal}");
		}
		
		
		$trx = $this->trans_done('Butir soal dari Bank Soal berhasil disimpan.', 'Database error, coba beberapa saat lagi.');
		return $trx;
	}
	
	function list_data() {
		
		$kurikulum_id 	= $this->input->post('kurikulum_id');
		$kategori_id 	= $this->input->post('kategori_id');
		$mapel_id 		= $this->input->post('mapel_id');
		$grade 			= $this->input->post('grade');
		
		$query = array(
			'select' => array(
					'id',
					'nama' =>"trim(concat_ws(' ', kd.kode,kd.nama))",
			),
			'from' => 'dakd_kompetensi_dasar kd',
			'order_by' => 'kd.kode',
		);
		
		if($kurikulum_id>0)
		{	$query['where']['kurikulum_id'] = $kurikulum_id;	}
		if($kategori_id>0)
		{	$query['where']['kategori_id'] = $kategori_id;	}
		if($mapel_id>0)
		{	$query['where']['mapel_id'] = $mapel_id;	}
		if($grade>0)
		{	$query['where']['grade'] = $grade;	}
		
		$this->md->query($query);
		$result = $this->db->get();
		
		if ($result->num_rows() > 0):
			foreach ($result->result_array() as $row){
				$return['id'][] = $row['id'];
				$return['nama'][] = $row['nama'];
			}
		endif;
		//print_r($return);
		
		return $return;
	}
	
	function update_soal_total($evaluasi_id) {
		$sql = "update kbm_evaluasi evaluasi inner join (select evaluasi_id, count(*) as jml from kbm_evaluasi_soal where evaluasi_id = ? group by evaluasi_id) soal on evaluasi.id = soal.evaluasi_id set evaluasi.soal_total = soal.jml where evaluasi.id = ?";

		$this->db->query($sql, array($evaluasi_id, $evaluasi_id));
	}
}