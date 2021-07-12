<?php

class M_modul_kurikulum extends MY_Model
{

	public function __construct()
	{
		parent::__construct(array(
				'fields' => array('nama', 'kurikulum_id', 'keterangan'),
				'fields-kurikulum' => array('kurikulum_id'),
		));
		$this->dm['admin'] = cfguc_admin('akses', 'nilai', 'siswa');
		$this->dm['view'] = cfguc_view('akses', 'nilai', 'siswa');
	}

	function filter_1($query)
	{
		$d = & $this->ci->d;
		$r = & $this->ci->d['request'];

		// normalisasi

		if (!isset($r['semester_id']) OR ! $r['semester_id'])
			$r['semester_id'] = $d['semaktif']['id'];

		// filtering

		if (isset($r['term']))
			$query['like'] = array($r['term'], array('isi.nama'));

		if (isset($r['semester_id']) && $r['semester_id'] > 0)
			$query['where']['isi.semester_id'] = $r['semester_id'];

		if (isset($r['updater_id']) && $r['updater_id'] > 0)
			$query['where']['isi.updater_id'] = $r['updater_id'];

		
		return $query;

	}
	
	function query_2() {
		$d = $this->ci->d;
		
		$query = array(
			'select'	 => array(
				'isi.*',
				'kurikulum_id'				=> 'kurikulum.id',
				'kurikulum_nama'			=> 'kurikulum.nama',
				'kurikulum_kode'			=> 'kurikulum.kode',
				
				'kurikulum_lihat'			=> 'kurikulum.lihat',
				'kurikulum_tambah'			=> 'kurikulum.tambah',
				'kurikulum_ubah'			=> 'kurikulum.ubah',
				'kurikulum_hapus'			=> 'kurikulum.hapus',
				
				'semester_nama'				=> 'semester.nama',
				'ta_nama'					=> 'ta.nama',
				'guru_id'					=> 'sdm.id',
				'guru_nama'					=> 'sdm.nama',
			),
			'from'		 => 'modul_kurikulum kurikulum',
			'join'		 => array(
				array('modul_kurikulum_isi isi', 'kurikulum.id = isi.kurikulum_id', 'left'),
				array('prd_semester semester', 'semester.id = isi.semester_id', 'left'),
				array('prd_ta ta', 'ta.id = semester.ta_id', 'left'),
				array('dprofil_sdm sdm', 'sdm.id = isi.updater_id', 'left'),
			),
			'order_by'	 => 'semester.id desc, kurikulum.nama asc, isi.nama asc',
		);
		
		$query['where']['isi.aktif'] = 1;
		$query['where']['kurikulum.aktif'] = 1;
		
		return $query;
	}
	
	function browse($index = 0, $limit = 50, $kode = "")
	{
		$d = $this->ci->d;
		
		$r = & $this->ci->d['request'];
		$dm = & $this->dm;
		
		$query = $this->query_2();
		$query = $this->filter_1($query);
		
		
		
		if (isset($r['semester_id']) == FALSE OR ! $r['semester_id'])
		{
			$r['semester_id'] = $this->md->row_col('id', 'select id from prd_semester order by id desc limit 1');
		}
		
		$query['where']['isi.semester_id'] = $r['semester_id'];
		
		if($kode != '')
		{
			$query['where']['kurikulum.kode'] = $kode;
		}
		
		/*if(($d['user']['role']=='sdm')&&($id_kurikulum=='4'))
		{
			$query['where']['isi.updater_id'] = $d['user']['id'];
		}*/
		
		return $this->md->query($query)->resultset($index, $limit);

	}
	
	function modul_kurikulum($index=0, $limit=50 , $kode='', $action='', $user='')
	{
		$query = array(
			'select'	 => array(
				'kurikulum.*',
			),
			'from'		 => 'modul_kurikulum kurikulum',
			'order_by'	 => 'kurikulum.urut asc',
		);
		$query['where']['kurikulum.aktif'] = 1;
		
		if ($kode != ''){
			$query['where']['kurikulum.kode'] = $kode;
		}
		
		if ($action != ''){
			$query['where_strings'] = 'kurikulum.'.$action.' like "%'.$user.'%"';
		}
		
		return $this->md->query($query)->resultset($index, $limit);
	}
	
	
	
	function rowset($id) {
		$d = & $this->ci->d;
		$query = $this->query_2();
		
		
		$query['where']['isi.id'] = $id;
		$row = $this->md->query($query)->row();
		
		$row['keterangan'] = base64_decode($row['keterangan']);
		$row['lampiran'] = (array) json_decode($row['lampiran'], TRUE);
		
		if (!$row)
			return FALSE;

		return $row;
	}
	
	function save() {
		$d = & $this->ci->d;
		$edit = (bool) $d['form']['id'];
		$kurikulum_isi_id = (int) $d['form']['id'];
		$file = $this->upload('upload', 'pdf,doc,docx,xls,xlsx,ppt,pptx,odt,ods,odp,jpg,jpeg,png,gif,zip,rar');
		
		$msg_sukses = "Kurikulum berhasil disimpan.";
		//$kurikulum_id = (int) $d['form']['kurikulum_id'];
			
		/*if ($file):
			$old_path = array_node($d, array('form', 'upload', 'full_path'));

			delete($old_path);

			$d['form']['upload'] = $file;

		endif;*/
		
		if ($file):
			$old_path = array_node($d, array('form', 'upload', 'full_path'));
			$old_path = APP_ROOT.$old_path;

			delete($old_path);

			$d['form']['upload'] = $file;
			$d['form']['upload']['full_path'] = APP_ROOT.$d['form']['upload']['full_path'];

		endif;

		$this->form->ruleset($d['row'], 'validasi');
		$this->form->validate();

		if ($d['error'])
			return FALSE;

		$data = $this->input('fields');

		$data['keterangan'] = base64_encode($data['keterangan']);
		$kurikulum_id = (int) $data['kurikulum_id'];
		
		$file_ofis = file_ofis($d, array('form', 'upload', 'file_ext'));
		$file_lama = file_ofis($d, array('row', 'lampiran', 'file_ext'));
		if (!$edit):
			$data['semester_id'] = $d['semaktif']['id'];
			$data['registered'] = $d['datetime'];
			$data['aktif'] = 1;
			// insert siswa

			$this->db->trans_start();
			$this->db->insert('modul_kurikulum_isi', $data);

			$kurikulum_isi_id = (int) $this->db->insert_id();
			$d['form']['id'] = $kurikulum_isi_id;
			
			// bila takada upload, operasi selesai

			//if (!$d['form']['upload'])
				//return alert_success($msg_sukses);

		endif;
		
		
		if ($d['form']['upload']):

			$folder = strtolower(APP_SCOPE) . "/modul/kurikulum/{$kurikulum_isi_id}/";

			$data['lampiran'] = $this->file_store($d['form']['upload'], $folder, $d['row']['lampiran']);
			$data['lampiran'] = (string) json_encode($data['lampiran']);

		endif;
		
		// perubahan data

		if (!empty($data)):

			$this->db->trans_start();
			$data['updated'] = $d['datetime'];
			$data['updater_id'] = $d['user']['id'];
			$updfilter['id'] = $kurikulum_isi_id;

			$this->db->update('modul_kurikulum_isi', $data, $updfilter);

			if ($edit)
				$msg_sukses = 'Data kurikulum berhasil disimpan.';

			$trx = $this->trans_done();

			if (!$trx)
				return alert_error('Database error saat menyimpan kurikulum, coba beberapa saat lagi.');

		endif;

		return alert_success($msg_sukses);
		
	}

	function hapus($id)
	{
		$data = array(
               'aktif' => 0,
            );

		$this->db->where('id', $id);
		$this->db->update('modul_kurikulum_isi', $data); 
		
	}
	
}
?>