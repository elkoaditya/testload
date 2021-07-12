<?php

class Siswa extends MY_Controller {

	// utama

	public function __construct() {
		parent::__construct(array(
				'controller' => array(
						'user' => '#login',
						'model' => 'm_nilai_siswa',
				),
				'nilai/siswa/browse' => array(
						'model' => 'm_option',
						'helper' => 'form',
						'request' => array(
								'term' => 'clean',
								'kelas_id' => 'as_int',
								'siswa_id' => 'as_int',
						),
				),
				'nilai/siswa/id' => array(
						'model' => array('m_nilai_siswa_pelajaran'),
				),
				'nilai/siswa/expor' => array(
						'model' => array('m_nilai_siswa_pelajaran'),
				),
				'nilai/siswa/rapor' => array(
						'model' => array('m_nilai_siswa_pelajaran'),
				),
				'nilai/siswa/impor_absen_kepribadian' => array(
						'user' => array('admin', 'sdm'),
						'library' => 'form',
						'helper' => 'form',
				),
		));

		$d = & $this->d;
		$d['admin'] = cfguc_admin('akses', 'nilai', 'siswa');
		$d['view'] = cfguc_view('akses', 'nilai', 'siswa');
		$d['walikelas'] = (array) cfgu('walikelas');
		$d['user_siswa'] = user_role('siswa');

		if (!$d['view'] && !$d['walikelas'] && !$d['user_siswa'])
			return alert_info('Anda tidak terkait dengan siswa apapun.', '');
	}

	public function index() {
		$this->browse();
	}

	// akses data umum

	public function browse($index = 0) {
		$this->_set('nilai/siswa/browse');
		$this->d['resultset'] = $this->m_nilai_siswa->browse($index, 20);
		$this->_view();
	}

	public function id($id = 0, $index = 0) {
		$this->_set('nilai/siswa/id');
		$this->_rowset('m_nilai_siswa', $id, 'nilai/siswa');

		$d = & $this->d;
		$d['pelajar'] = ($d['user']['id'] == $d['row']['siswa_id']);
		$d['walikelasybs'] = ($d['row']['kelas_wali_id'] == $d['user']['id']);
		$d['gurubkybs'] = ($d['row']['kelas_gurubk_id'] == $d['user']['id']);

		if (!$d['admin'] && !$d['pelajar'] && !$d['walikelasybs'])
			return alert_error('Anda tidak dapat mengakses nilai siswa.', '');

		$d['resultset'] = $this->m_nilai_siswa_pelajaran->siswa($id, $index, 100);
		$d['ekskul_result'] = $this->m_nilai_siswa->subrow_ekskul($id);
		$d['org_result'] = $this->m_nilai_siswa->subrow_org($id);

		$this->_view();
	}

	public function expor($id = 0) {
		$this->_set('nilai/siswa/expor');
		$this->_rowset('m_nilai_siswa', $id, 'nilai/siswa');

		$d = & $this->d;
		$d['pelajar'] = ($this->d['user']['id'] == $this->d['row']['siswa_id']);
		$d['walikelasybs'] = in_array($d['row']['kelas_id'], $d['walikelas']);

		if (!$d['admin'] && !$d['pelajar'] && !$d['walikelasybs'])
			return alert_error('Anda tidak dapat mengakses nilai siswa.', '');

		$d['resultset'] = $this->m_nilai_siswa_pelajaran->siswa($id, 0, 100);

		if ($d['resultset']['selected_rows'] == 0)
			return alert_info('Daftar nilai siswa tidak ditemukan. Periksa pelajaran siswa dan filter pencarian.', "nilai/siswa/id/{$d['row']['id']}");

		$this->load->library('PHPExcel');
		$this->m_nilai_siswa->expor();
	}



public function rapor($id = 0, $index = 0) {
		$this->_set('nilai/siswa/rapor');
		$this->_rowset('m_nilai_siswa', $id, 'nilai/siswa');

		$d = & $this->d;
		$d['pelajar'] = ($d['user']['id'] == $d['row']['siswa_id']);
		$d['walikelasybs'] = ($d['row']['kelas_wali_id'] == $d['user']['id']);
		$d['gurubkybs'] = ($d['row']['kelas_gurubk_id'] == $d['user']['id']);

		if (!$d['admin'] && !$d['pelajar'] && !$d['walikelasybs'])
			return alert_error('Anda tidak dapat mengakses nilai siswa.', '');

		$d['resultset1'] = $this->m_nilai_siswa_pelajaran->nilai_pelajaran($id, $index, 100);
		$d['resultset2'] = $this->m_nilai_siswa_pelajaran->nilai_mulok($id, $index, 100);
		$d['ta'] = $this->m_nilai_siswa_pelajaran->get_ta();
		
		$d['ekskul_result'] = $this->m_nilai_siswa->subrow_ekskul($id);
		$d['org_result'] = $this->m_nilai_siswa->subrow_org($id);

		$this->_pdf();
	}



	public function impor_absen_kepribadian($aksi = '') {
		$this->_set('nilai/siswa/impor_absen_kepribadian');

		$d = & $this->d;
		$sql_opsi_kelas = "select id, nama from dakd_kelas where aktif = 1 ";
		$format = ($aksi === 'format');

		if ($d['semaktif']['id'] < 1)
			return alert_error('Tak dapat mengimpor nilai pada masa jeda semester.', 'nilai/siswa');

		if (!$d['admin'])
			$sql_opsi_kelas .= " and (wali_id = {$d['user']['id']} or gurubk_id = {$d['user']['id']})";

		$d['opsi_kelas'] = $this->md->result_series('id', 'nama', $sql_opsi_kelas);

		if (empty($d['opsi_kelas']))
			return alert_error('Anda tidak terkait dengan kelas manapun untuk mengisi absensi dan kepribadian.', '');

		if ($format && $d['post_request'])
			return $this->m_nilai_siswa->impor_absen_kepribadian_format();

		if (!$format && $d['post_request'] && !$d['error'])
			if ($this->m_nilai_siswa->impor_absen_kepribadian())
				return redir("nilai/siswa");

		$this->form->set();
		$this->_view();
	}

}
