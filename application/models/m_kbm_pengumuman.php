<?php

class M_kbm_pengumuman extends MY_Model
{

	public function __construct()
	{
		parent::__construct(array(
			'fields'			 => array('nama', 'prioritas', 'konten', 'tanggal_publish', 'tanggal_tutup', 'tampil_guru', 'tampil_siswa'),
		));
		$this->dm['admin'] = cfguc_admin('akses', 'kbm', 'materi');
		$this->dm['view'] = cfguc_view('akses', 'kbm', 'materi');

	}
	
	// dasar database

	function filter_1($query)
	{
		$d = & $this->ci->d;
		$r = & $this->ci->d['request'];

		// normalisasi

		if (!isset($r['semester_id']) OR ! $r['semester_id'])
			$r['semester_id'] = $d['semaktif']['id'];

		// filtering

		if (isset($r['term']))
			$query['like'] = array($r['term'], array('pengumuman.nama'));

		if (isset($r['author_id']) && $r['author_id'] > 0)
			$query['where']['pengumuman.author_id'] = $r['author_id'];

		if (isset($r['tanggal_publish']))
			$this->md->like($r['tanggal_publish'], 'pengumuman.tanggal_publish');
		
		return $query;

	}

	function filtering()
	{
		$d = & $this->ci->d;
		$r = & $this->ci->d['request'];

		// normalisasi

		if (!isset($r['semester_id']) OR ! $r['semester_id'])
			$r['semester_id'] = $d['semaktif']['id'];

		// filtering

		if (isset($r['term']))
			$this->md->like($r['term'], 'pengumuman.nama');
		
		if (isset($r['author_id']) && $r['author_id'] > 0)
			$this->db->where('pengumuman.author_id', $r['author_id']);

		if (isset($r['tanggal_publish']))
			$this->md->like($r['tanggal_publish'], 'pengumuman.tanggal_publish');
	}

	function query_2()
	{
		$d = & $this->ci->d;
		$dm = & $this->dm;
		$query = array(
			'select'	 => array(
				'pengumuman.*',
				'author_nama'	=> 'author.nama',
				'kelas_nama' 	=> 'GROUP_CONCAT(kelas.nama)',
				'waktu_baca'	=> 'baca.modified',
				'baca_user_id'	=> 'baca.user_id',
				'COALESCE(pengumuman_baca.cnt, 0) as jml_pembaca'
			),
			'from'		 => 'kbm_pengumuman pengumuman',
			'join'		 => array(
				
				array('data_user author', 'pengumuman.author_id = author.id', 'inner'),
				array('kbm_pengumuman_kelas pengkelas', 'pengkelas.pengumuman_id = pengumuman.id', 'left'),
				array('dakd_kelas kelas', 'pengkelas.kelas_id = kelas.id', 'left'),
				array('kbm_pengumuman_baca baca', 'baca.pengumuman_id = pengumuman.id AND baca.user_id = '.$d['user']['id'].' ', 'left'),
				array('( 
						SELECT pengumuman_id, COUNT(*) AS cnt 
						FROM kbm_pengumuman_baca 
						
						GROUP BY pengumuman_id 
					) pengumuman_baca  ', 'pengumuman_baca.pengumuman_id = pengumuman.id', 'left'),
			),
			
			'where'	 	 => array('pengumuman.aktif' => 1),
			'group_by' 	 => 'pengumuman.id'
		);

		return $query;

	}

	function query_sendiri($query = array())
	{
		$d = & $this->ci->d;
		
		$query['order_by'] = 'pengumuman.prioritas DESC, pengumuman.tanggal_publish DESC';
					
		if ($d['user']['role'] != 'admin'){
			$query['where']['author_id'] = $d['user']['id'];
		}

		return $query;

	}
	
	function query_baca_pengumuman($query = array())
	{
		$d = & $this->ci->d;
		
		$query['order_by'] = 'baca_user_id ASC, pengumuman.prioritas DESC, pengumuman.tanggal_publish DESC';
		
		$now = date("Y-m-d H:i:s");
		$query['where_strings'] = "( ( pengumuman.tanggal_publish <= '".$now."' && (pengumuman.tanggal_tutup = '0000-00-00 00:00:00' || pengumuman.tanggal_tutup is NULL ) ) || " ;
		$query['where_strings'] .= "( pengumuman.tanggal_publish <= '".$now."' && pengumuman.tanggal_tutup >= '".$now."' ) || " ;
		$query['where_strings'] .= "( pengumuman.tanggal_publish = '0000-00-00 00:00:00' || pengumuman.tanggal_publish is NULL ) )" ;
			
		if ($d['user']['role'] == 'sdm'){	
			$query['where']['pengumuman.tampil_guru'] = '1';
			
		}elseif ($d['user']['role'] == 'siswa'){	
			$query['where']['pengumuman.tampil_siswa'] = '1';
			$query['join'][] = array('kbm_pengumuman_kelas pengkel2', 'pengkel2.pengumuman_id = pengumuman.id AND pengkel2.kelas_id = '.$d['user']['kelas_id'], 'inner');
		}
		
		return $query;
	}
	
	function query_sekolah($query = array())
	{
		
		$query = $this->query_baca_pengumuman($query);
		$query['where']['author.role'] = 'admin';
		
		return $query;

	}
	
	function query_guru($query = array())
	{
		
		$query['where']['author.role'] = 'sdm';
		$query = $this->query_baca_pengumuman($query);
		
		return $query;

	}

	// operasi data
	function browse_sendiri($index = 0, $limit = 20)
	{
		$query = $this->query_2();
		$query = $this->query_sendiri($query);
		$query = $this->filter_1($query);

		return $this->md->query($query)->resultset($index, $limit);

	}
	
	function browse_sekolah($index = 0, $limit = 20)
	{
		$query = $this->query_2();
		$query = $this->query_sekolah($query);
		$query = $this->filter_1($query);

		return $this->md->query($query)->resultset($index, $limit);

	}
	
	function browse_guru($index = 0, $limit = 20)
	{
		$query = $this->query_2();
		$query = $this->query_guru($query);
		$query = $this->filter_1($query);

		return $this->md->query($query)->resultset($index, $limit);

	}
	/*
	function browse($index = 0, $limit = 20)
	{
		$query = $this->query_2();
		$query = $this->query_3($query);
		$query = $this->filter_1($query);

		return $this->md->query($query)->resultset($index, $limit);

	}
	*/
	function rowset($id)
	{
		$d = & $this->ci->d;
		$query = $this->query_2();
		$query['select'][] = 'pengumuman.*';
		$query['where']['pengumuman.id'] = $id;


		$row = $this->md->query($query)->row();

		if (!$row)
			return FALSE;

		$row['konten'] = base64_decode($row['konten']);
		
		$row['lampiran'] = (array) json_decode($row['lampiran'], TRUE);

		// output

		return $row;

	}

	function save()
	{
		$d = & $this->ci->d;
		$edit = (bool) $d['form']['id'];
		$pengumuman_id = (int) $d['form']['id'];
		$kelas_jadwal = NULL;
		$file = $this->upload('upload', 'pdf,doc,docx,xls,xlsx,ppt,pptx,odt,ods,odp,jpg,jpeg,png,gif,zip,rar');
		//$content_path = APP_ROOT . 'content';
		$peserta = array();
		$msg_sukses = "pengumuman berhasil disimpan.";
		//$modit_pelajaran = ($d['author_ybs'] OR ! $edit);
		$cek_peserta = FALSE;

		if ($file):
			$old_path = array_node($d, array('form', 'upload', 'full_path'));
			$old_path = APP_ROOT.$old_path;
			//$old_path = APP_ROOT.$d['form']['upload']['full_path'];

			delete($old_path);

			$d['form']['upload'] = $file;
			$d['form']['upload']['full_path'] = APP_ROOT.$d['form']['upload']['full_path'];
//alert_error("A ".$d['form']['upload']['full_path']);
		endif;

		$this->form->ruleset($d['row'], 'validasi');
		$this->form->validate();

		if ($d['error'])
			return FALSE;

		$data = $this->input('fields');
		// clean FROALA ////
		$data['konten'] = str_replace('<p data-f-id="pbf" style="text-align: center; font-size: 14px; margin-top: 30px; opacity: 0.65; font-family: sans-serif;">
		Powered by <a href="https://www.froala.com/wysiwyg-editor?pb=1" title="Froala Editor">Froala Editor</a></p>','',$data['konten']);
		$data['konten']= str_replace('Powered by <a href="https://www.froala.com/wysiwyg-editor?pb=1" title="Froala Editor">Froala Editor</a>','',$data['konten']);
		
		$data['konten'] = str_replace('Froala Editor','',$data['konten']);
		$data['konten'] = str_replace('Powered by','',$data['konten']);
		
		
		$data['konten'] = base64_encode($data['konten']);
		

		$file_ofis = file_ofis($d, array('form', 'upload', 'file_ext'));
		$file_lama = file_ofis($d, array('row', 'lampiran', 'file_ext'));

		if (empty($data['konten']) && !$file_ofis && !$file_lama)
			alert_error('konten harus berupa tulisan artikel atau upload file office.');

		
		if ($d['error'])
			return FALSE;

		// olah data baru

		if (!$edit):

			// prep vars

			if($data['tanggal_tutup']==''){
				unset($data['tanggal_tutup']);
			}
			$data['author_id'] = $d['user']['id'];
			
			$data['registered'] = $d['datetime'];

			// insert siswa

			$this->db->trans_start();
			$this->db->insert('kbm_pengumuman', $data);

			$pengumuman_id = (int) $this->db->insert_id();

			$trx = $this->trans_done();
			$msg_sukses = "Pengumuman berhasil ditambahkan.";

			if (!$trx)
				return alert_error('Database error saat menyimpan pengumuman baru, coba beberapa saat lagi.');

			// insert berhasil, id baru masukan ke var data utama. reset input data u/ proses berikutnya.

			$d['form']['id'] = $pengumuman_id;
			$data = array();

			// bila takada upload, operasi selesai

			//if (!$d['form']['upload'])
				//return alert_info($msg_sukses);

		endif;

		// olah upload file

		if ($d['form']['upload']):

			$folder = strtolower(APP_SCOPE) ."/kbm/pengumuman/{$pengumuman_id}/";

			$data['lampiran'] = $this->file_store($d['form']['upload'], $folder, $d['row']['lampiran']);
			$data['lampiran'] = (string) json_encode($data['lampiran']);

		endif;

		// perubahan data

		if (!empty($data)):

			$this->db->trans_start();
			
			$data['modified'] = $d['datetime'];
			$updfilter['id'] = $pengumuman_id;

			$this->db->update('kbm_pengumuman', $data, $updfilter);

			if ($edit)
				$msg_sukses = 'Data pengumuman berhasil disimpan.';

			$trx = $this->trans_done();

			if (!$trx)
				return alert_error('Database error saat menyimpan pengumuman, coba beberapa saat lagi.');

		endif;


		// hapus data kelas sebelumnya

		if ($edit)
			$this->db->delete('kbm_pengumuman_kelas', array('pengumuman_id' => $pengumuman_id));

		// entri jadwal baru

		$klsjadwal_array = array();
		$kelas_jadwal = $this->input->post('kelas');
		foreach ($kelas_jadwal as $kelas):
			$jadwal['kelas_id'] = $kelas;
			$jadwal['pengumuman_id'] = $pengumuman_id;
			$klsjadwal_array[] = $jadwal;

		endforeach;

		//alert_dump($klsjadwal_array);

		if ($klsjadwal_array):
			// chek tampil siswa
			if($data['tampil_siswa']==1){
				$this->db->insert_batch('kbm_pengumuman_kelas', $klsjadwal_array);
			}
		endif;
			
		return alert_success($msg_sukses);
		

	}
	
	function baca($pengumuman_id=0 ){
		
		$d = & $this->ci->d;
		$query = array(
			'select'	 => array(
				'*',
			),
			'from'		 => 'kbm_pengumuman_baca',
			'where'	 	 => 
				array('pengumuman_id' => $pengumuman_id , 'user_id' => $d['user']['id']),
		);
		
		$result = $this->md->query($query)->resultset(0, 1000);
		
		if($result['total_rows']==0 ){
			$data['pengumuman_id'] 	= $pengumuman_id;
			$data['user_id'] 		= $d['user']['id'];
			$data['modified'] 		= $d['datetime'];
			
			$this->db->insert('kbm_pengumuman_baca', $data);
		}
		
	}
	
	function pembaca($id){
		
		$d = & $this->ci->d;
		$r = & $this->ci->d['request'];
		
		$query = array(
			'select'	 => array(
				'waktu_baca' => 'baca.modified',
				'user.*',
				'kelas_nama' => 'kelas.nama',
			),
			'from'		 => 'kbm_pengumuman_baca baca',
			'join'		 => array(
				array('data_user user', 'baca.user_id = user.id', 'inner'),
				array('dprofil_siswa siswa', 'user.id = siswa.id', 'left'),
				array('dakd_kelas kelas', 'siswa.kelas_id = kelas.id', 'left'),
			),
			'where'	 	 => 
				array('baca.pengumuman_id' => $id),
		);
		
		$query['order_by'] = 'user.role ASC, kelas.grade ASC, kelas.nama ASC, user.nama ASC';
		
		if (isset($r['term']) && strlen($r['term']) > 0)
			$query['like'] = array($r['term'], array('user.nama'));

		if (isset($r['kelas_id']) && $r['kelas_id'] > 0)
			$query['where']['siswa.kelas_id'] = $r['kelas_id'];
		
		$result = $this->md->query($query)->resultset(0, 1000);
		
		return $result;
	}
	
}