<?php

class Prestasi extends MY_Controller
{

	public function __construct()
	{
		parent::__construct(array(
			'controller'								 => array(
				'model' => 'm_dnakd_prestasi',
			),
			'data/non_akademik/prestasi/browse'	 => array(
				'library'	 => 'pagination',
				'request'	 => array(
					'term'		 => 'clean',
					//'pembina_id' => 'as_int',
				),
			),
			'data/non_akademik/prestasi/form'	 => array(
				'model'			 => 'm_option',
				'library'		 => 'form',
				'helper'		 => array('form', 'text'),
				'data'			 => array(
					'row' => array(
						'id'		 => 0,
						'nama'		 => NULL,
						//'cuplikan'	 => NULL,
						'tentang'	 => NULL,
						'kegiatan_prestasi_id' => NULL,
						'aktif'		 => 1,
					),
				),
				'validasi-umum'	 => array(
					array(
						array(
							'field'	 => 'nama',
							'label'	 => 'nama prestasi',
							'rules'	 => 'required|trim|min_length[2]|max_length[200]',
						),
						array(
							'field'	 => 'tentang',
							'label'	 => 'deskripsi prestasi',
							'rules'	 => 'max_length[2048]',
						),
						array(
							'field'	 => 'aktif',
							'label'	 => 'keaktifan',
							'rules'	 => 'as_bool',
						),
					),
					'nama' => array(
						array(
							'field'	 => 'nama',
							'label'	 => 'nama prestasi',
							'rules'	 => 'required|trim|min_length[2]|max_length[200]|is_unique[dnakd_prestasi.nama]'
						),
					),
				),/*
				'validasi-aktif' => array(
					array(
						array(
							'field'	 => 'kegiatan_prestasi_id',
							'label'	 => 'kegiatan prestasi',
							'rules'	 => 'required|sdm_aktif'
						),
					),
				),*/
			),
		));

	}

	public function index()
	{
		$this->browse();

	}

	public function browse($index = 0)
	{
		$this->_set('data/non_akademik/prestasi/browse');
		$this->d['resultset'] = $this->m_dnakd_prestasi->browse($index, 50);
		$this->_view();

	}

	public function form()
	{
		$this->d['row_id'] = (int) $this->input->get_post('id');
		$admin = cfguc_admin('akses', 'data', 'non_akademik', 'ekskul');

		if (!$admin)
			return alert_error("Anda tidak dapat mengubah data prestasi.", 'data/non_akademik/prestasi');

		$this->_set('data/non_akademik/prestasi/form');
		$this->form->init('m_dnakd_prestasi', 'data/non_akademik/prestasi');

		if ($this->d['post_request'] && !$this->d['error']){
			if ($this->m_dnakd_prestasi->save())
			{
				$redir = ($this->input->post('redir') == 'nilai_prestasi') ?
					"nilai/prestasi" :
					"data/non_akademik/prestasi";

				return redir($redir);
				//return redir("data/non_akademik/prestasi");
			}
		}		

		//$this->d['opsi_pembina'] = $this->m_option->guru();
		$this->d['opsi_kegiatan_prestasi'] = $this->m_option->kegiatan_prestasi();
		$this->form->set();
		$this->_view();

	}

	public function id($id = 0)
	{
		$this->_set('data/non_akademik/prestasi/id');
		$this->_rowset('m_dnakd_prestasi', $id, 'data/non_akademik/prestasi');
		$this->_view();

	}

}
