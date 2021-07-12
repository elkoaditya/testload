<?php

class Evaluasi extends MY_Controller
{

	public function __construct()
	{
		parent::__construct(array(
			'controller'			 => array(
				'user'	 => array('#login'),
				'model'	 => 'm_kbm_evaluasi',
			),
			'kbm/evaluasi/browse'	 => array(
				'model'		 => 'm_option',
				'library'	 => 'pagination',
				'helper'	 => 'form',
				'request'	 => array(
					'term'			 => 'clean',
					'pelajaran_id'	 => 'as_int',
					'semester_id'	 => 'as_int',
					'author_id'		 => 'as_int',
					'mapel_id'		 => 'as_int',
					'tglwaktu'		 => 'clean',
					'status'		 => 'clean',
				),
			),
			'kbm/evaluasi/id'		 => array(
				'model'	 => array('m_kbm_evaluasi_pembagian_kd','m_kbm_evaluasi_soal', 'm_kbm_evaluasi_nilai', 'm_option'),
				'helper' => 'form',
			),
			'kbm/evaluasi/publish'	 => array(
				'user'		 => array('sdm', 'admin'),
				'model'		 => 'm_kbm_evaluasi_ljs',
				'library'	 => 'form',
				'helper'	 => 'form',
			),
			'kbm/evaluasi/form'		 => array(
				'user'				 => array('sdm', 'admin'),
				'model'				 => 'm_option',
				'library'			 => 'form',
				'helper'			 => 'form',
				'data'				 => array(
					'row' => array(
						'id'				 => 0,
						'semester_id'		 => NULL,
						'author_id'			 => 0,
						'author_nama'		 => NULL,
						'editor_id'			 => NULL,
						'editor_nama'		 => NULL,
						'nama'				 => NULL,
						'cuplikan'			 => NULL,
						'konten'			 => NULL,
						'pelajaran_id'		 => 0,
						'pelajaran_nilai_id' => NULL,
						'pelajaran_nama'	 => NULL,
						'pelajaran_kode'	 => NULL,
						'mapel_nama'		 => NULL,
						'metode'			 => NULL,
						'tipe'				 => NULL,
						'kkm'				 => 75,
						'jml_kd'			 => 1,
						'pilihan_jml'		 => 0,
						'soal_jml'			 => NULL,
						'soal_total'		 => 0,
						'soal_acak'			 => 1,
						'soal_bank'			 => 0,
						'ljs_max'			 => 1,
						'poin_min'			 => 0,
						'poin_max'			 => 0,
						'rata2_poin'		 => 0,
						'rata2_nilai'		 => 0,
						'siswa_total'		 => 0,
						'siswa_menjawab'	 => 0,
						'published'			 => NULL,
						'closed'			 => NULL,
						'status'			 => 'draft',
					),
				),
				'validasi-umum'		 => array(
					array(
						array(
							'field'	 => 'nama',
							'label'	 => 'nama evaluasi',
							'rules'	 => 'clean|required|min_length[2]|max_length[100]',
						),
						array(
							'field'	 => 'kkm',
							'label'	 => 'KKM',
							'rules'	 => 'required|in_range[0-100]|as_int',
						),
					),
				),
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
				'validasi-bentuk'	 => array(
					array(
						array(
							'field'	 => 'pilihan_jml',
							'label'	 => 'bentuk dan jumlah pilihan',
							'rules'	 => 'required|select[0;1;2;4;5]|as_int',
						),
					),
				),
				'validasi-aturan'	 => array(
					array(
						/*array(
							'field'	 => 'metode',
							'label'	 => 'metode evaluasi',
							'rules'	 => 'trim|required|select[input;upload]',
						),*/
						array(
							'field'	 => 'tipe',
							'label'	 => 'tipe evaluasi',
							'rules'	 => 'trim|required|select[latihan;ulangan;ulangan_tengah_semester;ulangan_akhir_semester;tryout;remidi;tugas;praktek;penilaian_siswa1]',
						),
						array(
							'field'	 => 'soal_jml',
							'label'	 => 'jumlah soal',
							'rules'	 => 'as_int|in_range[0-1000]',
						),
						array(
							'field'	 => 'soal_acak',
							'label'	 => 'acak soal',
							'rules'	 => 'as_bool',
						),
						array(
							'field'	 => 'ljs_max',
							'label'	 => 'jumlah maksimal mencoba',
							'rules'	 => 'as_int|in_range[0-100]',
						),
					),
				),
				'validasi-tutupan'	 => array(
					array(
						array(
							'field'	 => 'show_rank',
							'label'	 => 'munculkan peringkat',
							'rules'	 => 'as_bool',
						),
						array(
							'field'	 => 'show_kunci',
							'label'	 => 'munculkan kunci',
							'rules'	 => 'as_bool',
						),
					),
				),
			),
			
			'kbm/evaluasi/form_upload'		 => array(
				'user'				 => array('sdm', 'admin'),
				'model'				 => 'm_option',
				'library'			 => 'form',
				'helper'			 => 'form',
				'data'				 => array(
					'row' => array(
						'id'				 => 0,
						'semester_id'		 => NULL,
						'author_id'			 => 0,
						'author_nama'		 => NULL,
						'editor_id'			 => NULL,
						'editor_nama'		 => NULL,
						'nama'				 => NULL,
						'cuplikan'			 => NULL,
						'konten'			 => NULL,
						'pelajaran_id'		 => 0,
						'pelajaran_nilai_id' => NULL,
						'pelajaran_nama'	 => NULL,
						'pelajaran_kode'	 => NULL,
						'mapel_nama'		 => NULL,
						'metode'			 => 'upload',
						'tipe'				 => NULL,
						'kkm'				 => 70,
						'pilihan_jml'		 => 0,
						'soal_jml'			 => NULL,
						'soal_total'		 => 5,
						'soal_acak'			 => 1,
						'soal_bank'			 => 0,
						'ljs_max'			 => 1,
						'poin_min'			 => 0,
						'poin_max'			 => 0,
						'rata2_poin'		 => 0,
						'rata2_nilai'		 => 0,
						'siswa_total'		 => 0,
						'siswa_menjawab'	 => 0,
						'published'			 => NULL,
						'closed'			 => NULL,
						'status'			 => 'draft',
					),
				),
				'validasi-umum'		 => array(
					array(
						array(
							'field'	 => 'nama',
							'label'	 => 'nama evaluasi',
							'rules'	 => 'clean|required|min_length[2]|max_length[100]',
						),
						array(
							'field'	 => 'kkm',
							'label'	 => 'KKM',
							'rules'	 => 'required|in_range[0-100]|as_int',
						),
					),
				),
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
				'validasi-bentuk'	 => array(
					array(
						array(
							'field'	 => 'pilihan_jml',
							'label'	 => 'bentuk dan jumlah pilihan',
							'rules'	 => 'required|select[0;1;4;5]|as_int',
						),
					),
				),
				'validasi-aturan'	 => array(
					array(
						/*array(
							'field'	 => 'metode',
							'label'	 => 'metode evaluasi',
							'rules'	 => 'trim|required|select[input;upload]',
						),*/
						array(
							'field'	 => 'tipe',
							'label'	 => 'tipe evaluasi',
							'rules'	 => 'trim|required|select[latihan;ulangan;ulangan_tengah_semester;ulangan_akhir_semester;tryout;remidi;tugas;praktek;penilaian_siswa1]',
						),
						array(
							'field'	 => 'soal_jml',
							'label'	 => 'jumlah soal',
							'rules'	 => 'as_int|in_range[0-1000]',
						),
						array(
							'field'	 => 'ljs_max',
							'label'	 => 'jumlah maksimal mencoba',
							'rules'	 => 'as_int|in_range[0-100]',
						),
					),
				),
				'validasi-tutupan'	 => array(
					array(
						array(
							'field'	 => 'show_rank',
							'label'	 => 'munculkan peringkat',
							'rules'	 => 'as_bool',
						),
						array(
							'field'	 => 'show_kunci',
							'label'	 => 'munculkan kunci',
							'rules'	 => 'as_bool',
						),
					),
				),
			),
			
			'kbm/evaluasi/tutup'	 => array(
				'user'		 => array('sdm', 'admin'),
				'library'	 => 'form',
				'helper'	 => 'form',
			),
			'kbm/evaluasi/delete'	 => array(
				'user'		 => array('sdm', 'admin'),
				'library'	 => 'form',
				'helper'	 => 'form',
			),
			'kbm/evaluasi/rekap'	 => array(
				'user'		 => array('sdm', 'admin'),
				'model'		 => 'm_option',
				'library'	 => 'form',
				'helper'	 => 'form',
				'data'		 => array(
					'row' => array(
						'id'		 => 0,
						'author_id'	 => 0, 
					),
				),
				'validasi-umum'		 => array(
					array( 
						array(
							'field'	 => 'jml_soal',
							'label'	 => 'Tambah Soal',
							'rules'	 => 'required|in_range[0-100]|as_int',
						),
						array(
							'field'	 => 'kelas_id',
							'label'	 => 'Kelas',
							'rules'	 => 'required|as_int',
						),
					),
				),
			),
			
			'kbm/evaluasi/reuse'	 => array(
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
			
			'kbm/evaluasi/pdf' => array(
					'user'		 => array('sdm', 'admin'),
					'model'	 => array('m_kbm_evaluasi_soal', 'm_kbm_evaluasi_nilai', 'm_option'),
					'library' => 'form',
					'helper' => array('form', 'soal'),
					'data' => array(
							'row' => array(
									'id' => 0,
									'evaluasi_id' => 0,
							),
							'evaluasi' => array(
									'id' => 0,
							),
					),
					'request' => array(
							'term' => 'clean',
							'evaluasi_id' => 'as_int',
							'kelas_id' => 'as_int',
							'kunci' => 'as_int',
					),
			),
			
		));
		$this->d['admin'] = cfguc_admin('akses', 'kbm', 'evaluasi');
		$this->d['view'] = cfguc_view('akses', 'kbm', 'evaluasi');
		$this->d['mengajar_list'] = (array) cfgu('mengajar_list');
		$this->d['pelajaran_list'] = (array) cfgu('pelajaran_list');

	}

	public function index()
	{
		if(THEME=='material_admin'){	
			$this->browse(0,3000);	
		}else{
			$this->browse();
		}

	}

	public function browse($index = 0,$limit = 20)
	{
		$d = & $this->d;

		if ($d['user']['role'] == 'sdm' && !$d['mengajar_list'])
			return alert_info('Anda tidak terkait dengan pelajaran apapun.', '');

		$this->_set('kbm/evaluasi/browse');
		$d['resultset'] = $this->m_kbm_evaluasi->browse($index, $limit);

		$this->_view();

	}

	public function form()
	{
		$this->_set('kbm/evaluasi/form');
		$this->_form_prepare();

		$d = & $this->d;

		if (!$d['error'] && $d['post_request'])
			if ($this->m_kbm_evaluasi->save())
				return redir("kbm/evaluasi/id/{$d['form']['id']}");

		$this->form->set();
		$this->_view();

	}
	
	public function form_upload()
	{
		$this->_set('kbm/evaluasi/form_upload');
		$this->_form_prepare();

		$d = & $this->d;

		if (!$d['error'] && $d['post_request'])
			if ($this->m_kbm_evaluasi->save())
				return redir("kbm/evaluasi/id/{$d['form']['id']}");

		$this->form->set();
		$this->_view();

	}

	public function _form_prepare()
	{
		$this->form->init('m_kbm_evaluasi', 'kbm/evaluasi');

		// tentukan lingkup edit: full atau parsial

		$d = & $this->d;
		$d['author_ybs'] = ($d['user']['id'] == $d['row']['author_id'] OR $d['row']['id'] == 0);
		$d['modit']['aturan'] = empty($d['row']['published']);
		$d['modit']['pelajaran'] = ($d['modit']['aturan'] && $d['author_ybs']);
		$d['modit']['bentuk'] = ($d['modit']['aturan'] && $d['row']['soal_total'] == 0);
		$d['modit']['tutupan'] = (bool) $d['row']['closed'];

		// tentukan hak akses untuk ngedit

		if (!$d['admin'] && !$d['author_ybs'] && !$d['mengajar_list'])
			return alert_error("Anda tidak dapat mengubah evaluasi.", 'kbm/evaluasi');

		if ($d['row']['id'] <= 0 && !$d['mengajar_list'])
			return alert_error("Anda bukan pengampu pelajaran, tak dapat membuat evaluasi baru.", 'kbm/evaluasi');

		if ($d['row']['id'] > 0 && !$d['author_ybs'] && !$d['admin'])
			return alert_error("Anda tak dapat mengubah evaluasi.", 'kbm/evaluasi');

		if ($d['semaktif']['id'] == 0)
			return alert_error("Tidak dapat mengubah evaluasi pada masa jeda semester.", 'kbm/evaluasi');

		else if ($d['row']['id'] > 0 && $d['row']['semester_id'] != $d['semaktif']['id'])
			return alert_error("Evaluasi tersebut telah berlalu.", "kbm/evaluasi/id/{$d['row']['id']}");

		// ambil opsi pelajaran & kelas

		if ($d['modit']['pelajaran']):
			$d['opsi_pelajaran'] = $this->m_option->pelajaran_user(FALSE, 'evaluasi');
			$d['kelas_jadwal'] = $this->m_kbm_evaluasi->opsi_jadwal_kelas(TRUE);

		else:
			$d['opsi_pelajaran'][$d['row']['pelajaran_id']] = $d['row']['pelajaran_nama'];
			$d['kelas_jadwal'] = $this->m_kbm_evaluasi->opsi_jadwal_kelas();

		endif;

		// fail!!

		if (!$d['opsi_pelajaran'])
			return alert_error('Error, daftar pelajaran tidak ditemukan.');

		if (!$d['kelas_jadwal'])
			return alert_error('Error, daftar kelas tidak ditemukan.');

		// ok done

	}

	public function id($id = 0)
	{
		//$this->_set('kbm/evaluasi/id');
		$this->_rowset('m_kbm_evaluasi', $id, 'kbm/evaluasi');

		$d = & $this->d;

		if ($d['user']['role'] == 'sdm' && !in_array($d['row']['pelajaran_id'], $d['mengajar_list']))
			return alert_info('Anda tidak terkait dengan evaluasi yang dimaksud.', '');

		if($d['row']['pilihan_jml'] == 1){
		//	$this->_set('kbm/evaluasi/id2');
			$this->_dump();
		}else{
			$this->_set('kbm/evaluasi/id');
		}
		$d['row']['#available'] = $this->m_kbm_evaluasi->availability($d['row']);
		$d['author_ybs'] = ($d['user']['id'] == $d['row']['author_id'] );
		$d['modit']['aturan'] = empty($d['row']['published']);
		$d['modit']['pelajaran'] = ($d['modit']['aturan'] && $d['author_ybs']);
		$d['modit']['bentuk'] = ($d['modit']['aturan'] && $d['row']['soal_total'] == 0);
		$d['modit']['tutupan'] = (bool) $d['row']['closed'];

		$this->m_kbm_evaluasi->analisa_cek();
		$this->_view();
		//$this->_dump();

	}

	public function id2($id = 0)
	{
		$this->_set('kbm/evaluasi/id2');
		$this->_rowset('m_kbm_evaluasi', $id, 'kbm/evaluasi');

		$d = & $this->d;

		if ($d['user']['role'] == 'sdm' && !in_array($d['row']['pelajaran_id'], $d['mengajar_list']))
			return alert_info('Anda tidak terkait dengan evaluasi yang dimaksud.', '');

		$d['row']['#available'] = $this->m_kbm_evaluasi->availability($d['row']);
		$d['author_ybs'] = ($d['user']['id'] == $d['row']['author_id'] );
		$d['modit']['aturan'] = empty($d['row']['published']);
		$d['modit']['pelajaran'] = ($d['modit']['aturan'] && $d['author_ybs']);
		$d['modit']['bentuk'] = ($d['modit']['aturan'] && $d['row']['soal_total'] == 0);
		$d['modit']['tutupan'] = (bool) $d['row']['closed'];

		$this->m_kbm_evaluasi->analisa_cek();
		$this->_dump();

	}
	public function publish()
	{
		$this->_set('kbm/evaluasi/publish');
		$this->_publish_prepare();

		$d = & $this->d;

		if (!$d['error'] && $d['post_request'])
			if ($this->m_kbm_evaluasi->publish())
				return redir("kbm/evaluasi/id/{$d['form']['id']}");

		$this->form->set();
		$this->_view();

	}

	public function _publish_prepare()
	{
		$d = & $this->d;

		$this->form->init('m_kbm_evaluasi', 'kbm/evaluasi');

		if ($d['form']['id'] == 0)
			return redir('kbm/evaluasi');

		$d['author_ybs'] = ($d['user']['id'] == $d['row']['author_id']);

		// tentukan hak akses untuk ngedit

		if (!$d['admin'] && !$d['author_ybs'])
			return alert_error("Anda tidak dapat mempublikasikan evaluasi.", 'kbm/evaluasi');

		if ($d['row']['soal_total'] == 0)
			return alert_error("Butir soal belum ada.", "kbm/evaluasi_soal/browse?evaluasi_id={$d['row']['id']}");

		if ($d['row']['published'])
			return alert_error("Evaluasi tersebut telah dipublikasikan.", "kbm/evaluasi/id/{$d['row']['id']}");

		if ($d['semaktif']['id'] == 0)
			return alert_error("Tidak dapat mempublikasikan evaluasi pada masa jeda semester.", 'kbm/evaluasi');

		else if ($d['row']['semester_id'] != $d['semaktif']['id'])
			return alert_error("Evaluasi tersebut telah berlalu.", "kbm/evaluasi/id/{$d['row']['id']}");

		// ok done

	}

	public function tutup()
	{
		$this->_set('kbm/evaluasi/tutup');
		$this->_tutup_prepare();

		$d = & $this->d;

		if (!$d['error'] && $d['post_request'])
			if ($this->m_kbm_evaluasi->tutup())
				return redir("kbm/evaluasi/id/{$d['form']['id']}");

		$this->form->set();
		$this->_view();

	}

	public function _tutup_prepare()
	{
		$d = & $this->d;

		$this->form->init('m_kbm_evaluasi', 'kbm/evaluasi');

		if ($d['form']['id'] == 0)
			return redir('kbm/evaluasi');

		$d['author_ybs'] = ($d['user']['id'] == $d['row']['author_id']);

		// tentukan hak akses untuk ngedit

		if (!$d['admin'] && !$d['author_ybs'])
			return alert_error("Anda tidak dapat menutup evaluasi.", 'kbm/evaluasi');

		if (!$d['row']['published'])
			return alert_error("Evaluasi tersebut belum dipublikasikan.", "kbm/evaluasi/id/{$d['row']['id']}");

		if ($d['row']['closed'])
			return alert_error("Evaluasi tersebut telah ditutup.", "kbm/evaluasi/id/{$d['row']['id']}");

		if ($d['semaktif']['id'] == 0)
			return alert_error("Tidak dapat menutup evaluasi pada masa jeda semester.", 'kbm/evaluasi');

		else if ($d['row']['semester_id'] != $d['semaktif']['id'])
			return alert_error("Evaluasi tersebut telah berlalu.", "kbm/evaluasi/id/{$d['row']['id']}");

		// ok done

	}

	public function delete()
	{
		$this->_set('kbm/evaluasi/delete');
		$this->_delete_prepare();

		$d = & $this->d;

		if (!$d['error'] && $d['post_request'])
			if ($this->m_kbm_evaluasi->delete())
				return redir("kbm/evaluasi?pelajaran_id={$d['row']['pelajaran_id']}");

		$this->form->set();
		$this->_view();

	}

	public function _delete_prepare()
	{
		$d = & $this->d;

		$this->form->init('m_kbm_evaluasi', 'kbm/evaluasi');

		if ($d['form']['id'] == 0)
			return redir('kbm/evaluasi');

		$d['author_ybs'] = ($d['user']['id'] == $d['row']['author_id']);

		// tentukan hak akses untuk ngedit

		if (!$d['admin'] && !$d['author_ybs'])
			return alert_error("Anda tidak dapat menutup evaluasi.", 'kbm/evaluasi');

		if ($d['row']['status'] == 'published')
			return alert_error("Evaluasi tersebut dipublikasikan dan sedang mungkin masih dikerjakan.", "kbm/evaluasi/id/{$d['row']['id']}");

		if ($d['row']['nilai_kolom_id'])
			return alert_error("Evaluasi tersebut merupakan bagian dari nilai rapor.", "kbm/evaluasi/id/{$d['row']['id']}");

		if ($d['semaktif']['id'] == 0)
			return alert_error("Tidak dapat menutup evaluasi pada masa jeda semester.", 'kbm/evaluasi');

		else if ($d['row']['semester_id'] != $d['semaktif']['id'])
			return alert_error("Evaluasi tersebut telah berlalu.", "kbm/evaluasi/id/{$d['row']['id']}");

		// ok done

	}

	public function rekap()
	{
		$this->_set('kbm/evaluasi/rekap');
		$this->form->init('m_kbm_evaluasi', 'kbm/evaluasi');

		$d = & $this->d;
		$d['author_ybs'] = ($d['user']['id'] == $d['row']['author_id']);
		$d['kolom_list'] = $this->m_kbm_evaluasi->kolom_nilai_list();

		// tentukan hak akses untuk ngedit

		// $this->_dump();
		// if ($d['row']['id'] <= 0)
			// return alert_error("Pilih evaluasi yang hendak direkap.", 'kbm/evaluasi');

		if (!$d['admin'] && !$d['author_ybs'] && !$d['mengajar_list'])
			return alert_error("Anda tidak dapat mengubah evaluasi.", 'kbm/evaluasi');

		if ($d['row']['id'] > 0 && !$d['author_ybs'] && !$d['admin'])
			return alert_error("Anda tak dapat merekap evaluasi.", 'kbm/evaluasi');

		// if ($d['row']['status'] != 'closed')
			// return alert_error("Evaluasi belum ditutup.", "kbm/evaluasi/id/{$d['row']['id']}");

		if ($d['semaktif']['id'] == 0)
			return alert_error("Tidak dapat mengubah evaluasi pada masa jeda semester.", 'kbm/evaluasi');

		else if ($d['row']['id'] > 0 && $d['row']['semester_id'] != $d['semaktif']['id'])
			return alert_error("Evaluasi tersebut telah berlalu.", "kbm/evaluasi/id/{$d['row']['id']}");

		// eksekusi
		// if (!$d['error']){
			// echo "a<br>";
			// $this->_dump();
		// }

		// if ($d['post_request']){
			// echo "b<br>";
			// $this->_dump();
		// }

		if (!$d['error'] && $d['post_request']){
			// $this->_dump();
			if ($this->m_kbm_evaluasi->rekap()){
				return redir("nilai/pelajaran/id/{$d['row']['pelajaran_nilai_id']}");
			// }else{
				// $this->_dump();
			}
		}
		
		$this->form->set();
			// $this->_dump();
		$this->_view();

	}

	public function reuse($id = 0)
	{
		$this->_set('kbm/evaluasi/reuse');
		$this->_rowset('m_kbm_evaluasi', $id, 'kbm/evaluasi');

		$d = & $this->d;
		$d['opsi_pelajaran'] = $this->m_option->pelajaran_user(FALSE, 'evaluasi');

		if (!$d['error'] && $d['post_request'])
		{
			$newEvaluasi_id = $this->m_kbm_evaluasi->reuse($id);

			alert_dump("kbm/evaluasi/id/" . $newEvaluasi_id);

			if ($newEvaluasi_id)
			{
				return redir("kbm/evaluasi/id/" . $newEvaluasi_id);
			}
		}

		$this->form->set();
		$this->_view();

	}

	public function testing()
	{
		//$result = $this->db->query("select * from dakd_kelas limit 0, 1;select * from dakd_kelas limit 1,1;");

		$procedure = "CALL `abc` (
);";
		$result = $this->db->conn_id->query($procedure);

		//* /
		while ($this->db->conn_id->next_result())
		{
			//free each result.
			$not_used_result = $this->db->conn_id->use_result();

			if ($not_used_result instanceof mysqli_result)
			{
				$not_used_result->free();
			}
		}
		// */
		exit('<pre>' . print_r($result, TRUE));

	}

	public function pdf() {
		$uri_evaluasi = 'kbm/evaluasi';
		$d = & $this->d;

		$this->_set('kbm/evaluasi/pdf');
		//$this->_rowset('m_kbm_evaluasi_ljs', $id, $uri_evaluasi);
		$this->_rowset('m_kbm_evaluasi', $d['request']['evaluasi_id'], $uri_evaluasi, 'evaluasi');
		$d['resultset'] = $this->m_kbm_evaluasi_soal->browse(0, 50);
		//$this->_rowset_evaluasi($id);

		//$d['evaluasi']['#available'] = $this->m_kbm_evaluasi->availability($d['evaluasi']);
		//$d['author_ybs'] = ($d['user']['id'] == $d['evaluasi']['author_id']);
		
		
		//$d['butir_result'] = $this->m_kbm_evaluasi_ljs->butir_ljs($id);

		
		//return $this->_pdf("ljs_{$d['row']['id']}_{$d['user']['role']}", 'pdf');
		
		return $this->_pdf("SOAL_{$d['evaluasi']['nama']}_{$d['evaluasi']['id']}_{$d['evaluasi']['mapel_nama']}_{$d['evaluasi']['kategori_nama']}");
		
		$this->_view();
	}
	
}
