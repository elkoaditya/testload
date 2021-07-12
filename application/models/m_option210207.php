<?php

// project  :
// filename : app/models/m_option

class M_option extends CI_Model {

	var $ci;

	public function __construct() {
		parent::__construct();
		$this->ci = & get_instance();
	}

	// internal

	function _get($config = array()) {
		$config = (array) $config;
		$result = array();
		$default = array(
				'value' => $config['label'],
				'term' => $config['label'],
				'query' => array(
						'order_by' => $config['label'],
				),
				'prefill' => FALSE,
		);

		array_default($config, $default);
		$this->md->query($config['query']);

		$query = $this->db->get();

		if (is_array($config['prefill']))
			$result = $config['prefill'];

		else if ($config['prefill'] === TRUE)
			$result[''] = '';

		else if ($config['prefill'])
			$result[''] = $config['prefill'];

		if ($query->num_rows() > 0):
			foreach ($query->result_array() as $row)
				$result[$row[$config['value']]] = $row[$config['label']];
		endif;

		$query->free_result();

		return $result;
	}

	// basic

	function agama($prefill = FALSE) {
		$config = array(
				'value' => 'id',
				'label' => 'nama',
				'prefill' => $prefill,
				'query' => array(
						'from' => 'dmst_agama',
				),
		);
		return $this->_get($config);
	}

	function ajaran_user($prefill = FALSE) {
		$admin = cfguc_admin('akses', 'kbm', 'materi');
		$ajaran = (array) cfgu('mengajar_list');

		if (!$ajaran && !$admin)
			return array();

		$config = array(
				'value' => 'id',
				'label' => 'nama',
				'prefill' => $prefill,
				'query' => array(
						'select' => array('id', 'nama'),
						'from' => 'dakd_pelajaran',
						'where' => array(
								'aktif' => 1,
						),
				),
		);

		if (!$admin)
			$this->db->where_in('id', $ajaran);

		return $this->_get($config);
	}

	function guru($prefill = FALSE) {
		$config = array(
				'value' => 'id',
				'label' => 'nama_title',
				'prefill' => $prefill,
				'query' => array(
						'select' => array(
								'id',
								'nama_title' => "concat(nama, if(prefix!='',', ',''), prefix, if(suffix!='',', ',''), suffix)",
						),
						'from' => 'dprofil_sdm',
						'where' => array(
								'aktif' => 1,
								'mengajar' => 1,
						),
						'order_by' => 'nama',
				),
		);
		return $this->_get($config);
	}

	function grade($prefill = FALSE) {
		$config = array(
				'value' => 'id',
				'label' => 'id',
				'prefill' => $prefill,
				'query' => array(
						'select' => array('id', 'nama'),
						'from' => 'dmst_grade',
						'order_by' => 'id',
						'where' => array(
								'aktif' => 1,
						),
				),
		);
		return $this->_get($config);
	}

	function jabatan($prefill = FALSE) {
		$config = array(
				'value' => 'id',
				'label' => 'nama',
				'prefill' => $prefill,
				'query' => array(
						'select' => array('id', 'nama'),
						'from' => 'dmst_jabatan',
				),
		);
		return $this->_get($config);
	}

	function jurusan($prefill = FALSE) {
		$config = array(
				'value' => 'id',
				'label' => 'nama',
				'prefill' => $prefill,
				'query' => array(
						'select' => array('id', 'nama'),
						'from' => 'dakd_jurusan',
						'where' => array('aktif' => 1),
				),
		);
		return $this->_get($config);
	}

	function kelas($prefill = FALSE) {
		$config = array(
				'value' => 'id',
				'label' => 'nama',
				'prefill' => $prefill,
				'query' => array(
						'select' => array('id', 'nama'),
						'from' => 'dakd_kelas',
						//'where' => array('aktif' => 1),
						'order_by' => 'grade, nama',
				),
		);
		$this->db->where('nama NOT LIKE "ZZ%"');
		return $this->_get($config);
	}

	function kelas_evaluasi($evaluasi_id, $prefill = FALSE) {
		$config = array(
				'value' => 'id',
				'label' => 'nama',
				'prefill' => $prefill,
				'query' => array(
						'select' => array('kelas.id', 'kelas.nama'),
						'from' => 'dakd_kelas kelas',
						'join' => array(
								array('kbm_evaluasi_kelas evakls', 'kelas.id = evakls.kelas_id', 'inner'),
						),
						'where' => array(
								'evakls.evaluasi_id' => $evaluasi_id,
						),
						'order_by' => 'kelas.grade, kelas.nama',
				),
		);
		return $this->_get($config);
	}

	function kategori_mapel($prefill = FALSE) {
		$config = array(
				'value' => 'id',
				'label' => 'nama',
				'prefill' => $prefill,
				'query' => array(
						'from' => 'dakd_kategori_mapel',
				),
		);
		return $this->_get($config);
	}

	function kategori_mapel_user($prefill = FALSE, $bidang = 'materi') {
		$view = cfguc_view('akses', 'kbm', $bidang);

		if (user_role('siswa'))
			$list = (array) cfgu('pelajaran_list');
		else
			$list = (array) cfgu('mengajar_list');

		if (!$view && !$list)
			return array();

		$config = array(
				'value' => 'id',
				'label' => 'nama',
				'prefill' => $prefill,
				'query' => array(
						'select' => array('kategori.id', 'kategori.nama'),
						'from' => 'dakd_pelajaran pelajaran',
						'join' => array(
								array('dakd_kategori_mapel kategori', 'pelajaran.kategori_id = kategori.id', 'inner')
						),
						'where' => array(
								'aktif' => 1,
						),
						'grup_by' => array(
								'kategori.id',
						),
				),
		);

		if (!$view)
			$this->db->where_in('pelajaran.id', $list);

		return $this->_get($config);
	}
	
	function kurikulum($prefill = FALSE) {
		$config = array(
				'value' => 'id',
				'label' => 'nama',
				'prefill' => $prefill,
				'query' => array(
						'from' => 'dmst_kurikulum',
						'where' => array(
								'aktif' => 1,
						),
				),
		);
		return $this->_get($config);
	}

	function mapel($prefill = FALSE) {
		$config = array(
				'value' => 'id',
				'label' => 'nama',
				'prefill' => $prefill,
				'query' => array(
						'select' => array('id', 'nama'),
						'from' => 'dakd_mapel',
				),
		);
		return $this->_get($config);
	}

	function mapel_user($prefill = FALSE, $bidang = 'materi') {
		$view = cfguc_view('akses', 'kbm', $bidang);

		if (user_role('siswa'))
			$list = (array) cfgu('pelajaran_list');
		else
			$list = (array) cfgu('mengajar_list');

		if (!$view && !$list)
			return array();

		$config = array(
				'value' => 'id',
				'label' => 'nama',
				'prefill' => $prefill,
				'query' => array(
						'select' => array('mapel.id', 'mapel.nama'),
						'from' => 'dakd_pelajaran pelajaran',
						'join' => array(
								array('dakd_mapel mapel', 'pelajaran.mapel_id = mapel.id', 'inner')
						),
						'where' => array(
								'aktif' => 1,
						),
						'grup_by' => array(
								'mapel.id',
						),
				),
		);

		if (!$view)
			$this->db->where_in('pelajaran.id', $list);

		return $this->_get($config);
	}
	
	function pelajaran($prefill = FALSE) {
		$config = array(
				'value' => 'id',
				'label' => 'nama',
				'prefill' => $prefill,
				'query' => array(
						'select' => array('id', 'nama'),
						'from' => 'dakd_pelajaran',
				),
		);

		return $this->_get($config);
	}

	function pelajaran_user($prefill = FALSE, $bidang = 'materi') {
		$view = cfguc_view('akses', 'kbm', $bidang);

		if (user_role('siswa'))
			$list = (array) cfgu('pelajaran_list');
		else
			$list = (array) cfgu('mengajar_list');

		if (!$view && !$list)
			return array();

		$config = array(
				'value' => 'id',
				'label' => 'nama',
				'prefill' => $prefill,
				'query' => array(
						'select' => array('id', 'nama'),
						'from' => 'dakd_pelajaran',
						'where' => array(
								'aktif' => 1,
						),
				),
		);

		if (!$view)
			$this->db->where_in('id', $list);

		return $this->_get($config);
	}

	function sdm($prefill = FALSE) {
		$config = array(
				'value' => 'id',
				'label' => 'nama_title',
				'prefill' => $prefill,
				'query' => array(
						'select' => array(
								'id',
								'nama_title' => "concat(nama, if(prefix!='',', ',''), prefix, if(suffix!='',', ',''), suffix)",
						),
						'from' => 'dprofil_sdm',
				),
		);

		if ($this->ci->d['user']['role'] != 'admin')
			$this->db->where('aktif', 1);

		return $this->_get($config);
	}

	function semester($prefill = FALSE) {
		$config = array(
				'value' => 'id',
				'label' => 'nama',
				'prefill' => $prefill,
				'query' => array(
						'select' => array(
								'semester.id',
								'nama' => "concat_ws(' ', upper(semester.nama), ta.nama)",
						),
						'from' => 'prd_semester semester',
						'join' => array(
								array('prd_ta ta', 'semester.ta_id = ta.id', 'inner')
						),
						'order_by' => 'semester.id desc',
				),
		);
		return $this->_get($config);
	}

	function ta($prefill = FALSE) {
		$config = array(
				'value' => 'id',
				'label' => 'nama',
				'prefill' => $prefill,
				'query' => array(
						'from' => 'prd_ta',
						'order_by' => 'id desc'
				),
		);
		return $this->_get($config);
	}

	// extended

	function pelajaran_kelas($row) {
		// filter yg sudah punya pelajaran sama

		$subsql_1 = "select kls.id "
					. "from dakd_kelas kls "
					. "inner join dakd_pelajaran_kelas pkls on kls.id = pkls.kelas_id "
					. "inner join dakd_pelajaran pel on pkls.pelajaran_id = pel.id "
					. "where pel.mapel_id = {$row['mapel_id']}";

		//$this->db->where("kelas.id not in ({$subsql_1})");
		// mulai ambil data

		$result = array();
		$query = $this->db
					->select('kelas.*')
					->from('dakd_kelas kelas')
					->where('kelas.aktif', 1)
					->order_by('kelas.grade, kelas.nama')
					->get();

		alert_info($this->db->last_query());

		if ($query->num_rows() > 0):
			foreach ($query->result_array() as $kls):
				$idx = (int) $kls['id'];
				$result[$idx] = $row['nama'];
			endforeach;
		endif;

		$query->free_result();

		return $result;
	}
	
	function kegiatan_prestasi($prefill = FALSE) {
		$config = array(
				'value' => 'id',
				'label' => 'nama_title',
				'prefill' => $prefill,
				'query' => array(
						'select' => array(
								'id',
								'nama_title' => "nama",
						),
						'from' => 'dnakd_kegiatan_prestasi',
						'where' => array(
								'aktif' => 1,
						),
						'order_by' => 'nama',
				),
		);
		return $this->_get($config);
	}
	
	function modul_kurikulum($prefill = FALSE, $kurikulum_id=0) {
		$config = array(
				'value' => 'id',
				'label' => 'nama',
				'prefill' => $prefill,
				'query' => array(
						'select' => array(
								'id',
								'nama',
						),
						'from' => 'modul_kurikulum',
						'where' => array(
								'aktif' => 1,
						),
						'order_by' => 'nama asc',
				),
		);
		
		if($kurikulum_id>0)
		{	$config['query']['where']['id'] = $kurikulum_id;	}
		
		return $this->_get($config);
	}
	
	function kompetensi_dasar($prefill = FALSE, $kurikulum_id=0, $kategori_id=0, $mapel_id=0 , $grade=0 ) {
		$config = array(
				'value' => 'id',
				'label' => 'nama',
				'prefill' => $prefill,
				'query' => array(
						'select' => array(
								'id',
								'nama' =>"trim(concat_ws(' ', kd.kode,kd.nama))",
						),
						'from' => 'dakd_kompetensi_dasar kd',
				),
		);
		if($kurikulum_id>0)
		{	$config['query']['where']['kurikulum_id'] = $kurikulum_id;	}
		if($kategori_id>0)
		{	$config['query']['where']['kategori_id'] = $kategori_id;	}
		if($mapel_id>0)
		{	$config['query']['where']['mapel_id'] = $mapel_id;	}
		if($grade>0)
		{	$config['query']['where']['grade'] = $grade;	}
		
		return $this->_get($config);
	}
}

