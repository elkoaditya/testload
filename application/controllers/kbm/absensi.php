<?php

class Absensi extends MY_Controller
{

	public function __construct()
	{
		$rule_nilai_angka = 'trim|numeric|max_length[4]|less_than[101]';
		
		parent::__construct(array(
			'controller'		 => array(
				'user'	 => '#login',
				'model'	 => 'm_kbm_absensi',
			),
			'kbm/absensi/browse'	 => array(
				'model'		 => 'm_option',
				'library'	 => 'pagination',
				'helper'	 => 'form',
				'request'	 => array(
					'term'			 => 'clean',
					'pelajaran_id'	 => 'as_int',
					'semester_id'	 => 'as_int',
					'author_id'		 => 'as_int',
					'mapel_id'		 => 'as_int',
					'tanggal_publish'=> 'clean',
					'tanggal_tutup'	 => 'clean',
				),
			),
			'kbm/absensi/id'		 => array(
				'library'	 => 'form',
				'helper'	 => 'form',
				
			),
			'kbm/absensi/form'	 => array(
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
						'pelajaran_id'	 => NULL,
						'siswa_total'	 => 0,
						'siswa_baca'	 => 0,
						'siswa_respon'	 => 0,
					),
				),
				'validasi'	 => array(
					array(
						array(
							'field'	 => 'nama',
							'label'	 => 'nama absensi',
							'rules'	 => 'required|strip_tags|clean|min_length[2]|max_length[100]',
						),
						
						array(
							'field'	 => 'pelajaran_id',
							'label'	 => 'pelajaran',
							'rules'	 => 'required',
						),
						
					),
				),
			),
			'kbm/absensi/reuse'	 => array(
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
			'kbm/absensi/surveillance' => array(
					'user' => array('sdm', 'admin'),
					'library' => 'pagination',
					'model' => 'm_option',
					'helper' => 'form',
					'request' => array(
						'id' => 'as_int',
						'kelas_id' => 'as_int',
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
		if(THEME=='absensial_admin'){	
			$this->browse(0,3000);	
		}else{
			$this->browse();
		}

	}

	public function browse($index = 0,$limit = 20)
	{
		$d = & $this->d;

		// if ($d['user']['role'] != 'siswa' && !$d['view'] && !$d['mengajar_list']):
			// alert_info('Anda tidak terkait dengan pelajaran apapun.');
			// return $this->_redir();
		// endif;

		$this->_set('kbm/absensi/browse');
		$d['resultset'] = $this->m_kbm_absensi->browse($index, $limit);
		$this->_view();

	}

	public function form()
	{
		$this->_set('kbm/absensi/form');
		$this->form->init('m_kbm_absensi', 'kbm/absensi');

		$d = & $this->d;
		$d['author_ybs'] = ($d['user']['id'] == $d['row']['author_id']);

		if (!$d['admin'] && !$d['author_ybs'] && !$d['mengajar_list'])
			return alert_error("Anda tidak dapat mengubah Video Call.", 'kbm/absensi');

		if ($d['semaktif']['id'] == 0)
			return alert_error("Tidak dapat mengubah Video Call pada masa jeda semester.", 'kbm/absensi');

		if ($d['row']['id'] <= 0 && !$d['mengajar_list'])
			return alert_error("Anda bukan pengampu pelajaran, tak dapat membuat Video Call baru.", 'kbm/absensi');

		if ($d['row']['id'] > 0 && !$d['author_ybs'] && !$d['admin'])
			return alert_error("Anda tak dapat mengubah isi Video Call.", 'kbm/absensi');

		if ($d['row']['id'] > 0 && $d['row']['semester_id'] != $d['semaktif']['id'])
			return alert_error("Video Call tersebut tidak berlaku lagi.", 'kbm/absensi');

		if ($d['post_request'] && !$d['error'])
			if ($this->m_kbm_absensi->save())
				return redir("kbm/absensi/id/{$d['form']['id']}");

		$this->form->set();
		$this->_view();

	}

	public function form_set()
	{
		$this->_set('kbm/absensi/form');
		$this->form->init('m_kbm_absensi', 'kbm/absensi');

		$d = & $this->d;
		$d['author_ybs'] = ($d['user']['id'] == $d['row']['author_id']);

		// if (!$d['admin'] && !$d['author_ybs'] && !$d['mengajar_list'])
			// return alert_error("Anda tidak dapat mengubah Video Call.", 'kbm/absensi');

		// if ($d['semaktif']['id'] == 0)
			// return alert_error("Tidak dapat mengubah Video Call pada masa jeda semester.", 'kbm/absensi');

		// if ($d['row']['id'] <= 0 && !$d['mengajar_list'])
			// return alert_error("Anda bukan pengampu pelajaran, tak dapat membuat Video Call baru.", 'kbm/absensi');

		// if ($d['row']['id'] > 0 && !$d['author_ybs'] && !$d['admin'])
			// return alert_error("Anda tak dapat mengubah isi Video Call.", 'kbm/absensi');

		// if ($d['row']['id'] > 0 && $d['row']['semester_id'] != $d['semaktif']['id'])
			// return alert_error("Video Call tersebut tidak berlaku lagi.", 'kbm/absensi');

		if ($d['post_request'] && !$d['error'])
			if ($this->m_kbm_absensi->save())
				return redir("kbm/absensi/id/{$d['form']['id']}");

		$this->form->set();
		$this->_view();

	}
	public function id($id = 0)
	{
		$d = & $this->d;

		$this->_set('kbm/absensi/id');
		$this->_rowset('m_kbm_absensi', $id, 'kbm/absensi');

		$d['kelas_video'] = $this->m_kbm_absensi->kelas_video($id);
		$d['id_record_absensi'] = $this->m_kbm_absensi->save_first_record_absensi($id);
		
		$this->form->set();
		$this->_view();

	}
	
	public function reuse($id = 0)
	{
		$this->_set('kbm/absensi/reuse');
		$this->_rowset('m_kbm_absensi', $id, 'kbm/absensi');

		$d = & $this->d;
		$d['opsi_pelajaran'] = $this->m_option->pelajaran_user(FALSE, 'materi');

		if (!$d['error'] && $d['post_request'])
		{
			$newEvaluasi_id = $this->m_kbm_absensi->reuse($id);

			if ($newEvaluasi_id)
			{
				return redir("kbm/absensi/id/" . $newEvaluasi_id);
			}
		}

		$this->form->set();
		$this->_view();

	}
	
	public function record_absensi()
	{
		$this->_set('kbm/absensi/record_absensi');
		
		$response = $this->m_kbm_absensi->save_record_absensi();
		
		echo json_encode($response);      
		exit;

	}
	
	public function surveillance($index = 0) {
		$d = & $this->d;

		$this->_set('kbm/absensi/surveillance');
		$this->_rowset('m_kbm_absensi', $d['request']['id'], 'kbm/absensi');
		
		$this->d['resultset'] = $this->m_kbm_absensi->surveillance($index, 1000);
		
		$this->_view();
	}
}