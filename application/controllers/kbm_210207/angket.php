<?php

class Angket extends MY_Controller {

	public function __construct() {
		parent::__construct(array(
				'controller' => array(
						'user' => array('#login'),
						'model' => 'm_kbm_angket',
				),
				'kbm/angket/browse' => array(
						'model' => 'm_option',
						'library' => 'pagination',
						'helper' => 'form',
						'request' => array(
								'term' => 'clean',
								'pelajaran_id' => 'as_int',
								'semester_id' => 'as_int',
								'author_id' => 'as_int',
								'mapel_id' => 'as_int',
						),
				),
				'kbm/angket/id' => array(
						'model' => array('m_kbm_angket_soal', 'm_kbm_angket_nilai', 'm_option'),
						'helper' => 'form',
				),
				'kbm/angket/publish' => array(
						'user' => array('sdm', 'admin'),
						'model' => 'm_kbm_angket_ljs',
						'library' => 'form',
						'helper' => 'form',
				),
				'kbm/angket/form' => array(
						'user' => array('sdm', 'admin'),
						'model' => 'm_option',
						'library' => 'form',
						'helper' => 'form',
						'data' => array(
								'row' => array(
										'id' => 0,
										'semester_id' => NULL,
										'author_id' => 0,
										'author_nama' => NULL,
										'editor_id' => NULL,
										'editor_nama' => NULL,
										'nama' => NULL,
										'jenis_penilaian' => NULL,
										'jml_menilai_siswa' => NULL,
										'jarak_absen' => NULL,
										'cuplikan' => NULL,
										'konten' => NULL,
										'pelajaran_id' => 0,
										'pelajaran_nilai_id' => NULL,
										'pelajaran_nama' => NULL,
										'pelajaran_kode' => NULL,
										'mapel_nama' => NULL,
										'tipe' => NULL,
										'kkm' => 70,
										'pilihan_jml' => 0,
										'soal_jml' => NULL,
										'soal_total' => 0,
										'soal_acak' => 1,
										'soal_bank' => 0,
										'ljs_max' => NULL,
										'poin_min' => 0,
										'poin_max' => 0,
										'rata2_poin' => 0,
										'rata2_nilai' => 0,
										'siswa_total' => 0,
										'siswa_menjawab' => 0,
										'published' => NULL,
										'closed' => NULL,
										'status' => 'draft',
								),
						),
						'validasi-umum' => array(
								array(
										array(
												'field' => 'nama',
												'label' => 'nama angket',
												'rules' => 'clean|required|min_length[2]|max_length[100]',
										),
										/*array(
												'field' => 'kkm',
												'label' => 'KKM',
												'rules' => 'required|in_range[0-100]|as_int',
										),*/
										
								),
						),
						'validasi-pelajaran' => array(
								array(
										// pelajaran_id dicek manual, sesuai penugasan guru
										array(
												'field' => 'pelajaran_id',
												'label' => 'pelajaran',
												'rules' => 'as_int|required',
										),
								),
						),
						'validasi-bentuk' => array(
								array(
										/*array(
												'field' => 'pilihan_jml',
												'label' => 'bentuk dan jumlah pilihan',
												'rules' => 'required|select[0;4;5]|as_int',
										),*/
								),
						),
						'validasi-aturan' => array(
								array(/*
										array(
												'field' => 'tipe',
												'label' => 'tipe angket',
												'rules' => 'trim|required|select[latihan;ulangan;remidi;tugas;praktek]',
										),*/
										array(
												'field' => 'jenis_penilaian',
												'label' => 'Jenis Penilaian',
												'rules' => 'clean|required|min_length[2]|max_length[100]',
										),
										array(
												'field' => 'soal_jml',
												'label' => 'jumlah soal',
												'rules' => 'as_int|in_range[0-1000]',
										),
										array(
												'field' => 'soal_acak',
												'label' => 'acak soal',
												'rules' => 'as_bool',
										),
										array(
												'field' => 'ljs_max',
												'label' => 'jumlah maksimal mencoba',
												'rules' => 'as_int|in_range[0-100]',
										),
										array(
												'field' => 'jml_menilai_siswa',
												'label' => 'Jumlah Menilai Siswa',
												'rules' => 'required|in_range[0-100]|as_int',
										),
										array(
												'field' => 'jarak_absen',
												'label' => 'Jarak Acak',
												'rules' => 'required|in_range[0-100]|as_int',
										),
								),
						),
						'validasi-tutupan' => array(
								array(
										array(
												'field' => 'show_rank',
												'label' => 'munculkan peringkat',
												'rules' => 'as_bool',
										),
										array(
												'field' => 'show_kunci',
												'label' => 'munculkan kunci',
												'rules' => 'as_bool',
										),
								),
						),
				),
				'kbm/angket/tutup' => array(
						'user' => array('sdm', 'admin'),
						'library' => 'form',
						'helper' => 'form',
				),
				'kbm/angket/delete' => array(
						'user' => array('sdm', 'admin'),
						'library' => 'form',
						'helper' => 'form',
				),
				'kbm/angket/rekap' => array(
						'user' => array('sdm', 'admin'),
						'model' => 'm_option',
						'library' => 'form',
						'helper' => 'form',
						'data' => array(
								'row' => array(
										'id' => 0,
										'author_id' => 0,
								),
						),
				),
				'kbm/angket/reuse'	 => array(
				'user'				 => array('sdm', 'admin'),
				'model'				 => 'm_option',
				'library'			 => 'form',
				'helper'			 => 'form',
				'validasi-pelajaran' => array(
					array(
						// pelajaran_id dicek manual, sesuai penugasan guru
						array(
							'field'	 => 'pelajaran_id',
							'label'	 => 'pelajaran',
							'rules'	 => 'as_int|required',
						),
					),
				),
			),
			));
		$this->d['admin'] = cfguc_admin('akses', 'kbm', 'evaluasi');
		$this->d['view'] = cfguc_view('akses', 'kbm', 'evaluasi');
		$this->d['mengajar_list'] = (array) cfgu('mengajar_list');
		$this->d['pelajaran_list'] = (array) cfgu('pelajaran_list');
	
	}

	public function index() {
		$this->d['user']['menilai_id']=0;
		$this->browse();
	}

	public function browse($index = 0) {
		$d = & $this->d;

		if ($d['user']['role'] == 'sdm' && !$d['mengajar_list'])
			return alert_info('Anda tidak terkait dengan pelajaran apapun.', '');

		$this->_set('kbm/angket/browse');
		$d['resultset'] = $this->m_kbm_angket->browse($index, 20);

		$this->_view();
	}
	
	public function form() {
		$this->_set('kbm/angket/form');
		$this->_form_prepare();

		$d = & $this->d;

		if (!$d['error'] && $d['post_request'])
			if ($this->m_kbm_angket->save())
				return redir("kbm/angket/id/{$d['form']['id']}");

		$this->form->set();
		$this->_view();
	}

	public function _form_prepare() {
		$this->form->init('m_kbm_angket', 'kbm/angket');

		// tentukan lingkup edit: full atau parsial

		$d = & $this->d;
		$d['author_ybs'] = ($d['user']['id'] == $d['row']['author_id'] OR $d['row']['id'] == 0);
		$d['modit']['aturan'] = empty($d['row']['published']);
		$d['modit']['pelajaran'] = ($d['modit']['aturan'] && $d['author_ybs']);
		$d['modit']['bentuk'] = ($d['modit']['aturan'] && $d['row']['soal_total'] == 0);
		$d['modit']['tutupan'] = (bool) $d['row']['closed'];

		// tentukan hak akses untuk ngedit

		if (!$d['admin'] && !$d['author_ybs'] && !$d['mengajar_list'])
			return alert_error("Anda tidak dapat mengubah angket.", 'kbm/angket');

		if ($d['row']['id'] <= 0 && !$d['mengajar_list'])
			return alert_error("Anda bukan pengampu pelajaran, tak dapat membuat angket baru.", 'kbm/angket');

		if ($d['row']['id'] > 0 && !$d['author_ybs'] && !$d['admin'])
			return alert_error("Anda tak dapat mengubah angket.", 'kbm/angket');

		if ($d['semaktif']['id'] == 0)
			return alert_error("Tidak dapat mengubah angket pada masa jeda semester.", 'kbm/angket');

		else if ($d['row']['id'] > 0 && $d['row']['semester_id'] != $d['semaktif']['id'])
			return alert_error("angket tersebut telah berlalu.", "kbm/angket/id/{$d['row']['id']}");

		// ambil opsi pelajaran & kelas

		if ($d['modit']['pelajaran']):
			$d['opsi_pelajaran'] = $this->m_option->pelajaran_user(FALSE, 'evaluasi');
			$d['kelas_jadwal'] = $this->m_kbm_angket->opsi_jadwal_kelas(TRUE);

		else:
			$d['opsi_pelajaran'][$d['row']['pelajaran_id']] = $d['row']['pelajaran_nama'];
			$d['kelas_jadwal'] = $this->m_kbm_angket->opsi_jadwal_kelas();

		endif;

		// fail!!

		if (!$d['opsi_pelajaran'])
			return alert_error('Error, daftar pelajaran tidak ditemukan.');

		if (!$d['kelas_jadwal'])
			return alert_error('Error, daftar kelas tidak ditemukan.');

		// ok done
	}
	
	public function id($id = 0,$menilai_id=0) {
		$this->_set('kbm/angket/id');
		$this->d['user']['menilai_id'] = $menilai_id;
		$this->_rowset('m_kbm_angket', $id, 'kbm/angket');

		$d = & $this->d;

		if ($d['user']['role'] == 'sdm' && !in_array($d['row']['pelajaran_id'], $d['mengajar_list']))
			return alert_info('Anda tidak terkait dengan angket yang dimaksud.', '');

		$d['row']['#available'] = $this->m_kbm_angket->availability($d['row']);
		$d['author_ybs'] = ($d['user']['id'] == $d['row']['author_id'] );
		$d['modit']['aturan'] = empty($d['row']['published']);
		$d['modit']['pelajaran'] = ($d['modit']['aturan'] && $d['author_ybs']);
		$d['modit']['bentuk'] = ($d['modit']['aturan'] && $d['row']['soal_total'] == 0);
		$d['modit']['tutupan'] = (bool) $d['row']['closed'];

		$this->m_kbm_angket->analisa_cek();
		$this->_view();
	}
	
	public function publish() {
		$this->_set('kbm/angket/publish');
		$this->_publish_prepare();

		$d = & $this->d;

		if (!$d['error'] && $d['post_request'])
			if ($this->m_kbm_angket->publish())
				return redir("kbm/angket/id/{$d['form']['id']}");

		$this->form->set();
		$this->_view();
	}

	public function _publish_prepare() {
		$d = & $this->d;

		$this->form->init('m_kbm_angket', 'kbm/angket');

		if ($d['form']['id'] == 0)
			return redir('kbm/angket');

		$d['author_ybs'] = ($d['user']['id'] == $d['row']['author_id']);

		// tentukan hak akses untuk ngedit

		if (!$d['admin'] && !$d['author_ybs'])
			return alert_error("Anda tidak dapat mempublikasikan angket.", 'kbm/angket');

		if ($d['row']['soal_total'] == 0)
			return alert_error("Butir soal belum ada.", "kbm/angket_soal/browse?angket_id={$d['row']['id']}");

		if ($d['row']['published'])
			return alert_error("Angket tersebut telah dipublikasikan.", "kbm/angket/id/{$d['row']['id']}");

		if ($d['semaktif']['id'] == 0)
			return alert_error("Tidak dapat mempublikasikan angket pada masa jeda semester.", 'kbm/angket');

		else if ($d['row']['semester_id'] != $d['semaktif']['id'])
			return alert_error("Angket tersebut telah berlalu.", "kbm/angket/id/{$d['row']['id']}");

		// ok done
	}

	public function tutup() {
		$this->_set('kbm/angket/tutup');
		$this->_tutup_prepare();

		$d = & $this->d;

		if (!$d['error'] && $d['post_request'])
			if ($this->m_kbm_angket->tutup())
				return redir("kbm/angket/id/{$d['form']['id']}");

		$this->form->set();
		$this->_view();
	}

	public function _tutup_prepare() {
		$d = & $this->d;

		$this->form->init('m_kbm_angket', 'kbm/angket');

		if ($d['form']['id'] == 0)
			return redir('kbm/angket');

		$d['author_ybs'] = ($d['user']['id'] == $d['row']['author_id']);

		// tentukan hak akses untuk ngedit

		if (!$d['admin'] && !$d['author_ybs'])
			return alert_error("Anda tidak dapat menutup angket.", 'kbm/angket');

		if (!$d['row']['published'])
			return alert_error("Angket tersebut belum dipublikasikan.", "kbm/angket/id/{$d['row']['id']}");

		if ($d['row']['closed'])
			return alert_error("Angket tersebut telah ditutup.", "kbm/angket/id/{$d['row']['id']}");

		if ($d['semaktif']['id'] == 0)
			return alert_error("Tidak dapat menutup angket pada masa jeda semester.", 'kbm/angket');

		else if ($d['row']['semester_id'] != $d['semaktif']['id'])
			return alert_error("Angket tersebut telah berlalu.", "kbm/angket/id/{$d['row']['id']}");

		// ok done
	}
	
	public function delete() {
		$this->_set('kbm/angket/delete');
		$this->_delete_prepare();

		$d = & $this->d;

		if (!$d['error'] && $d['post_request'])
			if ($this->m_kbm_angket->delete())
				return redir("kbm/angket?pelajaran_id={$d['row']['pelajaran_id']}");

		$this->form->set();
		$this->_view();
	}

	public function _delete_prepare() {
		$d = & $this->d;

		$this->form->init('m_kbm_angket', 'kbm/angket');

		if ($d['form']['id'] == 0)
			return redir('kbm/angket');

		$d['author_ybs'] = ($d['user']['id'] == $d['row']['author_id']);

		// tentukan hak akses untuk ngedit

		if (!$d['admin'] && !$d['author_ybs'])
			return alert_error("Anda tidak dapat menutup angket.", 'kbm/angket');

		if ($d['row']['status'] == 'published')
			return alert_error("Angket tersebut dipublikasikan dan sedang mungkin masih dikerjakan.", "kbm/angket/id/{$d['row']['id']}");

		if ($d['row']['nilai_kolom_id'])
			return alert_error("Angket tersebut merupakan bagian dari nilai rapor.", "kbm/angket/id/{$d['row']['id']}");

		if ($d['semaktif']['id'] == 0)
			return alert_error("Tidak dapat menutup angket pada masa jeda semester.", 'kbm/angket');

		else if ($d['row']['semester_id'] != $d['semaktif']['id'])
			return alert_error("Angket tersebut telah berlalu.", "kbm/angket/id/{$d['row']['id']}");

		// ok done
	}
	
	public function rekap() {
		$this->_set('kbm/angket/rekap');
		$this->form->init('m_kbm_angket', 'kbm/angket');

		$d = & $this->d;
		$d['author_ybs'] = ($d['user']['id'] == $d['row']['author_id']);
		$d['row']['kolom'] = $this->m_kbm_angket->kolom_nilai_list($d['row']);
		// tentukan hak akses untuk ngedit

		if ($d['row']['id'] <= 0)
			return alert_error("Pilih angket yang hendak direkap.", 'kbm/angket');

		if (!$d['admin'] && !$d['author_ybs'] && !$d['mengajar_list'])
			return alert_error("Anda tidak dapat mengubah angket.", 'kbm/angket');

		if ($d['row']['id'] > 0 && !$d['author_ybs'] && !$d['admin'])
			return alert_error("Anda tak dapat merekap angket.", 'kbm/angket');

		if ($d['row']['status'] != 'closed')
			return alert_error("Angket belum ditutup.", "kbm/angket/id/{$d['row']['id']}");

		if ($d['semaktif']['id'] == 0)
			return alert_error("Tidak dapat mengubah angket pada masa jeda semester.", 'kbm/angket');

		else if ($d['row']['id'] > 0 && $d['row']['semester_id'] != $d['semaktif']['id'])
			return alert_error("Angket tersebut telah berlalu.", "kbm/angket/id/{$d['row']['id']}");

		// eksekusi

		if (!$d['error'] && $d['post_request'])
			if ($this->m_kbm_angket->rekap())
				return redir("nilai/pelajaran/id/{$d['row']['pelajaran_nilai_id']}");

		$this->form->set();
		$this->_view();
	}
	
	public function reuse($id = 0)
	{
		$this->_set('kbm/angket/reuse');
		$this->_rowset('m_kbm_angket', $id, 'kbm/angket');

		$d = & $this->d;
		$d['opsi_pelajaran'] = $this->m_option->pelajaran_user(FALSE, 'evaluasi');

		if (!$d['error'] && $d['post_request'])
		{
			$newangket_id = $this->m_kbm_angket->reuse($id);

			alert_dump("kbm/angket/id/" . $newangket_id);

			if ($newangket_id)
			{
				return redir("kbm/angket/id/" . $newangket_id);
			}
		}

		$this->form->set();
		$this->_view();

	}
}
