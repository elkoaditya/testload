<?php

class Materi extends MY_Controller
{

	public function __construct()
	{
		parent::__construct(array(
			'controller'		 => array(
				'user'	 => '#login',
				'model'	 => 'm_kbm_materi',
			),
			'kbm/materi/browse'	 => array(
				'model'		 => 'm_option',
				'library'	 => 'pagination',
				'helper'	 => 'form',
				'request'	 => array(
					'term'			 => 'clean',
					'pelajaran_id'	 => 'as_int',
					'semester_id'	 => 'as_int',
					'author_id'		 => 'as_int',
					'mapel_id'		 => 'as_int',
				),
			),
			'kbm/materi/id'		 => array(
				'model'		 => 'm_kbm_materi_baca',
				'library'	 => 'form',
				'helper'	 => 'form',
				'validasi'	 => array(
					array(
						array(
							'field'	 => 'respon_jawaban',
							'label'	 => 'jawaban',
							'rules'	 => 'required|max_length[64000]',
						),
					),
				),
			),
			'kbm/materi/pembaca' => array(
				'user'		 => array('sdm', 'admin'),
				'model'		 => array('m_kbm_materi_baca', 'm_option'),
				'library'	 => 'form',
				'helper'	 => 'form',
				'request'	 => array(
					'term'			 => 'clean',
					'kelas_id'		 => 'as_int',
					'status_baca'	 => 'trim',
				),
			),
			'kbm/materi/form'	 => array(
				'user'		 => array('sdm', 'admin'),
				'model'		 => 'm_option',
				'library'	 => 'form',
				'helper'	 => 'form',
				'data'		 => array(
					'row' => array(
						'id'			 => 0,
						'semester_id'	 => NULL,
						'author_id'		 => 0,
						'editor_id'		 => NULL,
						'nama'			 => NULL,
						'cuplikan'		 => NULL,
						'pelajaran_id'	 => NULL,
						'konten_tipe'	 => 'file',
						'konten'		 => NULL,
						'lampiran'		 => array(),
						'pertanyaan'	 => NULL,
						'siswa_total'	 => 0,
						'siswa_baca'	 => 0,
						'siswa_respon'	 => 0,
					),
				),
				'validasi'	 => array(
					array(
						array(
							'field'	 => 'nama',
							'label'	 => 'nama materi',
							'rules'	 => 'required|strip_tags|clean|min_length[2]|max_length[100]',
						),
						/*
						  array(
						  'field' => 'konten_tipe',
						  'label' => 'tipe konten',
						  'rules' => 'trim|required|select[artikel;file]',
						  ),
						 *
						 */
						array(
							'field'	 => 'konten',
							'label'	 => 'konten',
							'rules'	 => 'max_length[65000]',
						),
						array(
							'field'	 => 'pelajaran_id',
							'label'	 => 'pelajaran',
							'rules'	 => 'required',
						),
						array(
							'field'	 => 'pertanyaan',
							'label'	 => 'pertanyaan',
							'rules'	 => 'required|max_length[2048]',
						),
					),
				),
			),
			'kbm/materi/reuse'	 => array(
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
		$this->d['admin'] = cfguc_admin('akses', 'kbm', 'materi');
		$this->d['view'] = cfguc_view('akses', 'kbm', 'materi');
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

		if ($d['user']['role'] != 'siswa' && !$d['view'] && !$d['mengajar_list']):
			alert_info('Anda tidak terkait dengan pelajaran apapun.');
			return $this->_redir();
		endif;

		$this->_set('kbm/materi/browse');
		$d['resultset'] = $this->m_kbm_materi->browse($index, $limit);
		$this->_view();

	}

	public function form()
	{
		$this->_set('kbm/materi/form');
		$this->form->init('m_kbm_materi', 'kbm/materi');

		$d = & $this->d;
		$d['author_ybs'] = ($d['user']['id'] == $d['row']['author_id']);

		if (!$d['admin'] && !$d['author_ybs'] && !$d['mengajar_list'])
			return alert_error("Anda tidak dapat mengubah materi.", 'kbm/materi');

		if ($d['semaktif']['id'] == 0)
			return alert_error("Tidak dapat mengubah materi pada masa jeda semester.", 'kbm/materi');

		if ($d['row']['id'] <= 0 && !$d['mengajar_list'])
			return alert_error("Anda bukan pengampu pelajaran, tak dapat membuat materi baru.", 'kbm/materi');

		if ($d['row']['id'] > 0 && !$d['author_ybs'] && !$d['admin'])
			return alert_error("Anda tak dapat mengubah isi materi.", 'kbm/materi');

		if ($d['row']['id'] > 0 && $d['row']['semester_id'] != $d['semaktif']['id'])
			return alert_error("Materi tersebut tidak berlaku lagi.", 'kbm/materi');

		if ($d['post_request'] && !$d['error'])
			if ($this->m_kbm_materi->save())
				return redir("kbm/materi/id/{$d['form']['id']}");

		$this->form->set();
		$this->_view();

	}

	public function id($id = 0)
	{
		$d = & $this->d;

		$this->_set('kbm/materi/id');
		$this->_rowset('m_kbm_materi', $id, 'kbm/materi');

		if ($d['user']['role'] == 'siswa' && $d['post_request'])
			$this->m_kbm_materi_baca->jawab();

		$this->m_kbm_materi->hit();
		$this->form->set();
		$this->_view();

	}

	public function pembaca($id = 0, $index = 0)
	{
		$d = & $this->d;

		if ($d['user']['role'] == 'siswa')
			return redir("kbm/materi/id/{$id}");

		$this->_set('kbm/materi/pembaca');
		$this->_rowset('m_kbm_materi', $id, 'kbm/materi');
		$d['resultset'] = $this->m_kbm_materi_baca->browse($d['row']['id'], $index, 50);
		$this->_view();

	}

	public function reuse($id = 0)
	{
		$this->_set('kbm/materi/reuse');
		$this->_rowset('m_kbm_materi', $id, 'kbm/materi');

		$d = & $this->d;
		$d['opsi_pelajaran'] = $this->m_option->pelajaran_user(FALSE, 'materi');

		if (!$d['error'] && $d['post_request'])
		{
			$newEvaluasi_id = $this->m_kbm_materi->reuse($id);

			if ($newEvaluasi_id)
			{
				return redir("kbm/materi/id/" . $newEvaluasi_id);
			}
		}

		$this->form->set();
		$this->_view();

	}

	public function hapus($id = 0)
	{
		//$this->db->trans_start();
		$this->db->update('kbm_materi',array('aktif' => '0') ,array('id' => $id));
		//$trx = $this->trans_done();

		//if (!$trx)
			//return alert_error("Database error saat menghapus materi, coba beberapa saat lagi.", 'kbm/materi');
		//else
			return alert_success("Data materi berhasil dihapus.",'kbm/materi');
		
	}
}
