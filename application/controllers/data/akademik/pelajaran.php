<?php

class Pelajaran extends MY_Controller
{

	public function __construct()
	{
		parent::__construct(array(
			'controller'					 => array(
				'user'	 => '#login',
				'model'	 => 'm_dakd_pelajaran',
			),
			'data/akademik/pelajaran/browse' => array(
				'model'		 => 'm_option',
				'library'	 => 'pagination',
				'helper'	 => 'form',
				'request'	 => array(
					'term'			 => 'clean',
					'kategori_id'	 => 'trim|as_int',
					'mapel_id'	 	 => 'trim|as_int',
					'agama_id'		 => 'trim',
					'guru_id'		 => 'trim|as_int',
					'aktif' 		 => 'clean',
				),
			),
			'data/akademik/pelajaran/form'	 => array(
				'model'			 => 'm_option',
				'library'		 => 'form',
				'helper'		 => 'form',
				'data'			 => array(
					'row' => array(
						'id'			 => 0,
						'aktif'			 => 1,
						'kode'			 => NULL,
						'nama'			 => NULL,
						'kategori_id'	 => NULL,
						'kurikulum_id'	 => 1,
						'agama_id'		 => NULL,
						'guru_id'		 => NULL,
						'kelas_list'	 => array(),
						'teori'			 => 1,
						'praktek'		 => 1,
					),
				),
				'validasi-umum'	 => array(
					array(
						array(
							'field'	 => 'kode',
							'label'	 => 'kode pelajaran',
							'rules'	 => 'required|trim|alpha_dot_space|max_length[100]',
						),
						array(
							'field'	 => 'nama',
							'label'	 => 'nama pelajaran',
							'rules'	 => 'required|trim|alpha_dot_space|min_length[2]|max_length[250]',
						),
						array(
							'field'	 => 'kategori_id',
							'label'	 => 'kategori mapel',
							'rules'	 => 'required|trim|is_exist[dakd_kategori_mapel.id]'
						),
						array(
							'field'	 => 'guru_id',
							'label'	 => 'guru pengajar',
							'rules'	 => 'required|trim|guru_aktif'
						),
						array(
							'field'	 => 'agama_id',
							'label'	 => 'agama',
							'rules'	 => 'trim|is_exist[dmst_agama.id]'
						),
						array(
							'field'	 => 'aktif',
							'label'	 => 'keaktifan',
							'rules'	 => 'trim|as_bool'
						),
						array(
							'field'	 => 'kelas_list[]',
							'label'	 => 'daftar',
							'rules'	 => 'required|kelas_aktif'
						),
					),
					'kode'	 => array(
						array(
							'field'	 => 'kode',
							'label'	 => 'kode pelajaran',
							'rules'	 => 'required|trim|max_length[64]|is_unique[dakd_pelajaran.kode]'
						),
					),
					'nama'	 => array(
						array(
							'field'	 => 'nama',
							'label'	 => 'nama pelajaran',
							'rules'	 => 'required|trim|min_length[2]|max_length[128]|is_unique[dakd_pelajaran.nama]'
						),
					),
				),
				'validasi-baru'	 => array(
					array(
						
						array(
							'field'	 => 'mapel_id',
							'label'	 => 'mapel',
							'rules'	 => 'required|trim|is_exist[dakd_mapel.id]'
						),
					),
				),
			),
		));
		$this->d['view'] = cfguc_view('akses', 'data', 'akademik', 'pelajaran');
		$this->d['admin'] = cfguc_admin('akses', 'data', 'akademik', 'pelajaran');

	}

	public function index()
	{
		$this->browse();

	}

	public function browse($index = 0)
	{
		$this->_set('data/akademik/pelajaran/browse');

		if ($this->d['admin'])
			$this->m_dakd_pelajaran->cek();

		$this->d['resultset'] = $this->m_dakd_pelajaran->browse($index, 20);
		$this->_view();

	}

	public function form()
	{
		$d = & $this->d;

		if (!$d['admin'])
			return alert_error("Anda tidak dapat mengubah data pelajaran.", 'data/akademik/pelajaran');

		if ($d['semaktif']['id'] > 0)
			return alert_error("Anda tidak dapat mengubah data pelajaran saat semester telah berjalan.", 'data/akademik/pelajaran');

		$this->_set('data/akademik/pelajaran/form');
		$this->form->init('m_dakd_pelajaran', 'data/akademik/pelajaran');

		if ($d['post_request'] && !$d['error']):
			if ($this->m_dakd_pelajaran->save()):
				$redir = ($this->input->post('ulang')) ? "data/akademik/pelajaran/form" : "data/akademik/pelajaran/id/{$d['form']['id']}";
				redir($redir);
			endif;
		endif;

		$this->form->set();
		$this->_view();

	}

	public function id($id = 0)
	{
		$this->_set('data/akademik/pelajaran/id');
		$this->_rowset('m_dakd_pelajaran', $id, 'data/akademik/pelajaran');
		$this->_view();

	}

}
