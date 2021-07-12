<?php

class Semester extends MY_Controller {

	public function __construct() {
		parent::__construct(array(
				'controller' => array(
						'user' => '#login',
						'model' => 'm_prd_semester',
				),
				'periode/semester/form' => array(
						'user' => array('sdm', 'admin'),
						'model' => array('m_dakd_pelajaran', 'm_option'),
						'library' => 'form',
						'helper' => 'form',
						'data' => array(
								'row' => array(
										'id' => 0,
										'nama' => 'gasal',
										'ta_id' => NULL,
										'term' => 'semester',
										'kenaikan_kelas' => 0,
										'akhir' => '2013-12-13',
										'kepsek_id' => NULL,
								),
						),
						'validasi' => array(
								array(
										array(
												'field' => 'term',
												'label' => 'periode akademik',
												'rules' => 'required|trim|select[semester;trimester;quarter;minimester]',
										),
										array(
												'field' => 'nama',
												'label' => 'nama semester',
												'rules' => 'trim|alpha_dot_space|required|min_length[2]|max_length[20]',
										),
										array(
												'field' => 'akhir',
												'label' => 'perkiraan akhir semester',
												'rules' => 'trim|tgl2date|required',
										),
										array(
												'field' => 'kenaikan_kelas',
												'label' => 'semester kenaikan kelas',
												'rules' => 'as_bool',
										),
								),
						),
				),
				'periode/semester/tutup' => array(
						'user' => array('sdm', 'admin'),
						'library' => 'form',
						'helper' => 'form',
				),
		));
		$this->d['view'] = cfguc_view('akses', 'periode');
		$this->d['admin'] = cfguc_admin('akses', 'periode');
	}

	public function index() {
		$this->aktif();
	}

	public function aktif() {
		$this->_set('periode/semester/aktif');
		$this->d['semester_terakhir'] = $this->m_prd_semester->terakhir();
		//exit('ok');
		$this->_view();
	}

	public function form() {
		$d = & $this->d;
		$d['ta'] = $this->md->rowset($d['semaktif']['ta_id'], 'prd_ta');

		if (!$d['ta'])
			return alert_error('Tahun ajaran masih kosong.', 'periode/semester');

		$this->_set('periode/semester/form');

		if (!$d['admin'])
			return alert_error('Anda tak dapat melakukan perubahan semester.', 'periode/semester');

		if ($d['semaktif']['id'] > 0):
			$d['row'] = $this->m_prd_semester->rowset($d['semaktif']['id']);

		else:

			if (!$this->m_dakd_pelajaran->cek())
				return redir('periode/semester');

			$d['row']['ta_nama'] = $d['ta']['nama'];

		endif;

		if ($d['post_request'] && !$d['error'])
			if ($this->m_prd_semester->save())
				return redir('periode/semester');

		$this->form->sesi['id'] = $d['semaktif']['id'];
		$this->form->set();
		$this->_view();
	}

	public function tutup() {
		$d = & $this->d;
		$this->_set('periode/semester/tutup');

		if (!$d['admin'])
			return alert_error('Anda tak dapat melakukan perubahan semester.', 'periode/semester');

		if ($d['semaktif']['id'] == 0)
			return alert_error('Semester belum berjalan.', 'periode/semester');

		$d['row'] = $this->m_prd_semester->rowset($d['semaktif']['id']);

		if ($d['post_request'] && !$d['error'])
			if ($this->m_prd_semester->tutup())
				return redir('periode/semester');

		$this->form->sesi['id'] = $d['semaktif']['id'];
		$this->form->set();
		$this->_view();
	}

}
