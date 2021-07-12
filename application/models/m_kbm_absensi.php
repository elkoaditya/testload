<?php

class M_kbm_absensi extends MY_Model
{

	public function __construct()
	{
		parent::__construct(array(
			'fields'			 => array('nama', 'tanggal_publish', 'tanggal_tutup'),
			'fields-pelajaran'	 => array('pelajaran_id'),
		));
		$this->dm['admin'] = cfguc_admin('akses', 'kbm', 'materi');
		$this->dm['view'] = cfguc_view('akses', 'kbm', 'materi');
		$this->dm['mengajar_list'] = (array) cfgu('mengajar_list');
		$this->dm['pelajaran_list'] = (array) cfgu('pelajaran_list');

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
			$query['like'] = array($r['term'], array('absensi.nama'));

		if (isset($r['semester_id']) && $r['semester_id'] > 0)
			$query['where']['absensi.semester_id'] = $r['semester_id'];

		if (isset($r['mapel_id']) && $r['mapel_id'] > 0)
			$query['where']['pelajaran.mapel_id'] = $r['mapel_id'];

		if (isset($r['pelajaran_id']) && $r['pelajaran_id'] > 0)
			$query['where']['absensi.pelajaran_id'] = $r['pelajaran_id'];

		if (isset($r['author_id']) && $r['author_id'] > 0)
			$query['where']['absensi.author_id'] = $r['author_id'];

		if (isset($r['tanggal_publish']))
			$this->md->like($r['tanggal_publish'], 'absensi.tanggal_publish');
		
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
			$this->md->like($r['term'], 'absensi.nama');

		if (isset($r['semester_id']) && $r['semester_id'] > 0)
			$this->db->where('absensi.semester_id', $r['semester_id']);

		if (isset($r['mapel_id']) && $r['mapel_id'] > 0)
			$this->db->where('pelajaran.mapel_id', $r['mapel_id']);

		if (isset($r['pelajaran_id']) && $r['pelajaran_id'] > 0)
			$this->db->where('absensi.pelajaran_id', $r['pelajaran_id']);

		if (isset($r['author_id']) && $r['author_id'] > 0)
			$this->db->where('absensi.author_id', $r['author_id']);

		if (isset($r['tanggal_publish']))
			$this->md->like($r['tanggal_publish'], 'absensi.tanggal_publish');
	}

	function query_2()
	{
		$d = & $this->ci->d;
		$dm = & $this->dm;
		$query = array(
			'select'	 => array(
				'semester_nama'	 => 'semester.nama',
				'ta_nama'		 => 'ta.nama',
				'author_nama'	 => "trim(concat_ws(' ', author.prefix, author.nama, author.suffix))",
				'pelajaran_kode' => 'pelajaran.kode',
				'pelajaran_nama' => 'pelajaran.nama',
				'mapel_nama'	 => 'mapel.nama',
				'tanggal_publish'	 => 'absensi.tanggal_publish',
				'tanggal_tutup'		 => 'absensi.tanggal_tutup',
				'semester.ta_id',
			),
			'from'		 => 'kbm_absensi_set absensi',
			'join'		 => array(
				array('prd_semester semester', 'absensi.semester_id = semester.id', 'inner'),
				array('prd_ta ta', 'semester.ta_id = ta.id', 'inner'),
				array('dprofil_sdm author', 'absensi.author_id = author.id', 'inner'),
				array('dakd_pelajaran pelajaran', 'absensi.pelajaran_id = pelajaran.id', 'inner'),
				array('dakd_mapel mapel', 'pelajaran.mapel_id = mapel.id', 'inner'),
			),
			'order_by'	 => 'absensi.semester_id desc, pelajaran.nama, absensi.id',
			'where'	 	 => array('absensi.aktif' => 1),
		);

		if ($d['user']['role'] == 'siswa'):
			
			
			$now = date("Y-m-d H:i:s");
			$query['where_strings'] = "( ( absensi.tanggal_publish <= '".$now."' && (absensi.tanggal_tutup = '0000-00-00 00:00:00' || absensi.tanggal_tutup is NULL ) ) || " ;
			$query['where_strings'] .= "( absensi.tanggal_publish <= '".$now."' && absensi.tanggal_tutup >= '".$now."' ) || " ;
			$query['where_strings'] .= "( absensi.tanggal_publish = '0000-00-00 00:00:00' || absensi.tanggal_publish is NULL ) )" ;

		elseif (!$dm['view'] && $dm['mengajar_list']):
			$query['where_in']['pelajaran_id'] = $dm['mengajar_list'];

		elseif (!$dm['view']):
			$query['where']['author_id'] = $d['user']['id'];

		endif;

		return $query;

	}

	function query_3($query = array())
	{
		$query['select'][] = 'absensi.id';
		$query['select'][] = 'absensi.semester_id';
		$query['select'][] = 'absensi.author_id';
		$query['select'][] = 'absensi.editor_id';
		$query['select'][] = 'absensi.nama';
		$query['select'][] = 'absensi.publish';
		$query['select'][] = 'absensi.tanggal_publish';
		$query['select'][] = 'absensi.pelajaran_id';
		$query['select'][] = 'absensi.siswa_total';
		$query['select'][] = 'absensi.registered';

		return $query;

	}

	// operasi data

	function browse($index = 0, $limit = 20)
	{
		$query = $this->query_2();
		$query = $this->query_3($query);
		$query = $this->filter_1($query);

		return $this->md->query($query)->resultset($index, $limit);

	}

	
	function rowset($id)
	{
		$d = & $this->ci->d;
		$query = $this->query_2();
		$query['select'][] = 'absensi.*';
		$query['where']['absensi.id'] = $id;

		$row = $this->md->query($query)->row();

		if (!$row)
			return FALSE;

		// output

		return $row;

	}

	function save()
	{
		$d = & $this->ci->d;
		$edit = (bool) $d['form']['id'];
		$absensi_id = (int) $d['form']['id'];
		
		$peserta = array();
		$msg_sukses = "absensi berhasil disimpan.";
		$modit_pelajaran = ($d['author_ybs'] OR ! $edit);
		$pelajaran_id = (int) $d['row']['pelajaran_id'];
		$cek_peserta = FALSE;

		$this->form->ruleset($d['row'], 'validasi');
		$this->form->validate();

		if ($d['error'])
			return FALSE;

		$data = $this->input('fields');
		// clean FROALA ////
		
		if ($modit_pelajaran):
			$data = $this->input('fields-pelajaran', $data);
			$pelajaran_id = (int) $data['pelajaran_id'];
			$mengajar = mengajar($data['pelajaran_id']);
			$cek_peserta = (!$edit OR ( $d['row']['pelajaran_id'] != $data['pelajaran_id']));

			if (!$mengajar)
				alert_error("Anda tidak sedang mengampu pelajaran tersebut.");

		endif;
		
		if ($cek_peserta):
			$peserta = $this->peserta($data['pelajaran_id']);

			if (empty($peserta)):
				alert_error('Peserta pelajaran yang Anda pilih tidak ditemukan.');

			else:
				$data['siswa_total'] = count($peserta);
				$data['siswa_baca'] = 0;
				$data['siswa_respon'] = 0;

			endif;

		endif;

		if ($d['error'])
			return FALSE;

		// olah data baru

		if (!$edit):

			// prep vars

			$data['semester_id'] = $d['semaktif']['id'];
			$data['author_id'] = $d['user']['id'];
			
			$data['registered'] = $d['datetime'];
			
			if(empty($d['tanggal_tutup'])){
				$data['tanggal_tutup'] = '0000-00-00 00:00:00';
			}
			// insert siswa

			$this->db->trans_start();
			$this->db->insert('kbm_absensi_set', $data);

			$absensi_id = (int) $this->db->insert_id();

			//$this->save_peserta($absensi_id, $peserta);

			$trx = $this->trans_done();
			$msg_sukses = "absensi berhasil ditambahkan.";

			if (!$trx)
				return alert_error('Database error saat menyimpan absensi baru, coba beberapa saat lagi.');

			// insert berhasil, id baru masukan ke var data utama. reset input data u/ proses berikutnya.

			$d['form']['id'] = $absensi_id;
			$data = array();

			// bila takada upload, operasi selesai

			if (!$d['form']['upload'])
				return alert_info($msg_sukses);

		endif;


		// perubahan data

		if (!empty($data)):

			$this->db->trans_start();

			if ($edit && $d['row']['author_id'] != $d['user']['id'])
				$data['editor_id'] = $d['user']['id'];

			$updfilter['id'] = $absensi_id;

			if($data['tanggal_tutup']==""){
				$data['tanggal_tutup'] = '0000-00-00 00:00:00';
			}
			
			$this->db->update('kbm_absensi_set', $data, $updfilter);

			if ($edit && $cek_peserta && $this->db->trans_status()):
				//$this->db->delete('kbm_absensi_set_baca', array('absensi_id' => $absensi_id));
				//$this->save_peserta($absensi_id, $peserta);
			endif;

			if ($edit)
				$msg_sukses = 'Data absensi berhasil disimpan.';

			$trx = $this->trans_done();

			if (!$trx)
				return alert_error('Database error saat menyimpan absensi, coba beberapa saat lagi.');

		endif;

		return alert_success($msg_sukses);

	}
	
	function kelas_video($id, $index = 0, $limit = 100)
	{
		$d = & $this->ci->d;
		$query['select'] = array(
				'kelas_id' 	 => 'kelas.id',
				'kelas_nama' => 'kelas.nama',
			);
		$query['from'] = 'kbm_absensi_set absensi';
		$query['join'][] = array('dakd_pelajaran_kelas pelkel', 'absensi.pelajaran_id = pelkel.pelajaran_id', 'inner');
		$query['join'][] = array('dakd_kelas kelas', 'kelas.id = pelkel.kelas_id', 'inner');
		
		$query['where']['absensi.id'] = $id;


		return $this->md->query($query)->resultset($index, $limit);
	}

	function save_peserta($absensi_id, $peserta)
	{
		if ($absensi_id <= 0)
			return;

		$baca_bat = array();

		foreach ($peserta as $sid)
			$baca_bat[] = array(
				'absensi_id'	 => $absensi_id,
				'user_id'	 => $sid,
				'respon_cuplikan'	=> '',
			);

		if (!empty($baca_bat))
			$this->db->insert_batch('kbm_absensi_set_baca', $baca_bat);

	}

	function peserta($pelajaran_id)
	{
		$d = & $this->ci->d;
		$query = array(
			'select' => array('nilsis.siswa_id'),
			'from'	 => 'nilai_siswa nilsis',
			'join'	 => array(
				array('nilai_siswa_pelajaran nisispel', 'nilsis.id = nisispel.siswa_nilai_id', 'inner'),
				array('nilai_pelajaran nipel', 'nisispel.pelajaran_nilai_id = nipel.id', 'inner'),
			),
			'where'	 => array(
				'nilsis.semester_id' => $d['semaktif']['id'],
				'nipel.semester_id'	 => $d['semaktif']['id'],
				'nipel.pelajaran_id' => $pelajaran_id,
			),
		);

		return $this->md->query($query)->result_values('siswa_id');

	}
	
	function query_record_absensi($id){
		
		$query = array(
				'from' => 'kbm_absensi_set_record',
				'select' => array(
						'*',
				),
		);
		
		$query['where']['id'] = $id;
		
		return $query;
	}
	
	function save_first_record_absensi($kbm_absensi_set_id ){
		
		$d = & $this->ci->d;
		
		$_raw = array(
			'kbm_absensi_set_id'	=> $kbm_absensi_set_id,
			'role'			=> $d['user']['role'],
			'user_id'		=> $d['user']['id'],
			'modified'		=> date('Y-m-d H:i:s'),
			'registered'	=> date('Y-m-d H:i:s'),
			'total_waktu'	=> 0,
			'aktif'			=> 1,
			);
			
		$this->db->trans_start();
		
		$this->db->insert('kbm_absensi_set_record' ,$_raw );
		$insert_id = $this->db->insert_id();
		
		$this->db->trans_complete();
		
		return $insert_id;
	}
	
	function save_record_absensi(){
		
		$id_record_absensi 	= $this->input->post('id_record_absensi');
		
		if($id_record_absensi==''){
			$response['warna'] = '#FF4444';	
			$response['message'] = 'Waktu video call GAGAL di simpan, coba "REFRESH" halaman ini dan cek "INTERNET".';	
		}else{
			
			$query = $this->query_record_absensi($id_record_absensi);
			$hasil = $this->md->query($query)->row();
			
			$_raw = array(
				'id'			=> $id_record_absensi,
				'total_waktu'	=> ($hasil['total_waktu']+1),
				'modified' 		=> date('Y-m-d H:i:s'),
				);
			
			
			$this->db->trans_start();
			
			$this->db->where('id', $id_record_absensi);
			$this->db->update('kbm_absensi_set_record', $_raw); 
					
			$this->db->trans_complete();
			
			if ($this->db->trans_status() === FALSE){
				$response['warna'] = '#FF4444';	
				$response['message'] = 'Waktu video call GAGAL di simpan, coba "REFRESH" halaman ini dan cek "INTERNET".';	
			}else{	
				$response['warna'] = '#00AAFF';	
				$response['message'] = 'Waktu baca berhasil di simpan.';	
			}
			
			$this->trans_done();
		}
		
		return $response;

	}

	function reuse($fromabsensi_id)
	{
		$d = & $this->ci->d;
		$semester_id = $d['semaktif']['id'];
		$newPelajaran_id = (int) $this->input->post('pelajaran_id');

		$this->db->trans_begin();

		/**
		 * mencari id nilai_pelajaran
		 */
		$sql_nilpel = <<<SQL

SELECT
	id,
	guru_id

FROM
	nilai_pelajaran

WHERE
	pelajaran_id = {$newPelajaran_id}
AND
	semester_id = {$semester_id}

ORDER BY
	id DESC

LIMIT
	1
;
SQL;

		$nilpel = $this->md->row($sql_nilpel);

		if ($this->db->trans_status() === FALSE)
		{
			$this->db->trans_rollback();

			return alert_error("error saat menjalankan: <br/> {$sql_nilpel}");
		}

		$now = date("Y-m-d H:i:s");
		$pelajaran_nilai_id = $nilpel['id'];
		$author_id = $nilpel['guru_id'];
		$editor_id = $d['user']['id'];

		$sql_copy_absensi = <<<SQL

INSERT INTO
	kbm_absensi_set
	(
		semester_id, author_id, editor_id,
		nama, pelajaran_id, tanggal_publish,
		registered, updated
	)

SELECT
	{$semester_id}, {$author_id}, {$editor_id},
	nama, {$newPelajaran_id}, '{$now}',
	registered, updated

FROM
	kbm_absensi_set

WHERE
	id = {$fromabsensi_id}
;

SQL;
		$this->db->query($sql_copy_absensi);

		$newabsensi_id = $this->db->insert_id();
		
		if ($this->db->trans_status() === FALSE)
		{
			$this->db->trans_rollback();

			return alert_error("error saat menjalankan: <br/> {$sql_copy_absensi}");
		}else
		{
			$this->db->trans_commit();
		}

		



		return $newabsensi_id;

	}
	
	function surveillance($index = 0, $limit = 50){
		
		$d = & $this->ci->d;
		$r = & $this->ci->d['request'];
		
		$query = array(
				'select' => array(
						'absensi.*',
						'kelas_nama'	=> 'kelas.nama',
						'siswa_id' 		=> 'siswa.id',
						'siswa_nis' 	=> 'siswa.nis',
						'siswa_nisn' 	=> 'siswa.nisn',
						'siswa_nama' 	=> 'siswa.nama',
						'siswa_gender' 	=> 'siswa.gender',
						'total_waktu'	=> 'SUM(record.total_waktu)',
						'waktu_awal' 	=> 'MIN(record.modified)',
				),
				'from' => 'kbm_absensi_set absensi',
				'join' => array(
						array('dakd_pelajaran_kelas pelkel', 'absensi.pelajaran_id = pelkel.pelajaran_id', 'inner'),
						array('dakd_kelas kelas', 'kelas.id = pelkel.kelas_id', 'inner'),
						array('dprofil_siswa siswa', 'kelas.id = siswa.kelas_id', 'inner'),
						array('kbm_absensi_set_record record', 'record.user_id = siswa.id AND record.kbm_absensi_set_id = absensi.id', 'left'),
						
				),
				'group_by' => 'siswa.id',
				
		);
		$query['where']['absensi.id'] = $r['id'];
		if($r['kelas_id'] >0){
			$query['where']['kelas.id'] = $r['kelas_id'];	
		}
		
		$resulset = $this->md->query($query)->resultset($index, $limit);
		
		return $resulset;
		
	}
}
