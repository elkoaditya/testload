<?php

class Siswa_ekskul extends MY_Controller
{

	public function __construct()
	{
		$rule_nilai_predikat = 'trim|clean|max_length[6]|strtoupper';

		parent::__construct(array(
			'controller'									 => array(
				'user'	 => array('admin', 'sdm'),
				'model'	 => array('m_nilai_siswa_ekskul', 'm_nilai_ekskul'),
			),
			'nilai/siswa_ekskul/form_siswa'					 => array(
				'user'		 => array('admin', 'sdm'),
				'model'		 => 'm_option',
				'library'	 => 'form',
				'helper'	 => 'form',
				'validasi'	 => array(
					array(
						array(
							'field'	 => 'nilai',
							'label'	 => 'Nilai Ekstrakurikuler',
							'rules'	 => $rule_nilai_predikat,
						),
						array(
							'field'	 => 'keterangan',
							'label'	 => 'Keterangan Ekstrakurikuler',
							'rules'	 => 'clean|max_length[400]',
						),
					),
				),
			),
			'nilai/siswa_ekskul/form_tambah_ekskul_ke_siswa' => array(
				'user'		 => array('admin', 'sdm'),
				'model'		 => 'm_option',
				'library'	 => 'form',
				'helper'	 => 'form',
			),
		));

		$d = & $this->d;
		$d['admin'] = cfguc_admin('akses', 'nilai', 'siswa') OR cfguc_admin('akses', 'nilai', 'ekskul');
		$d['view'] = cfguc_view('akses', 'nilai', 'siswa') OR cfguc_view('akses', 'nilai', 'ekskul');
		$d['walikelas'] = (array) cfgu('walikelas');
		$d['user_siswa'] = user_role('siswa');
		$d['ekskul_terkait'] = $this->m_nilai_ekskul->dm['ekskul_terkait'];

		if (!$d['view'] && !$d['walikelas'] && !$d['user_siswa'])
		{
			return alert_info('Anda tidak terkait dengan siswa apapun.', '');
		}

	}

	public function form_siswa()
	{
		$d = & $this->d;

		if (!$d['admin'])
		{
			return alert_error("Anda tidak dapat mengubah nilai ekskul siswa.", TRUE);
		}


		$this->_set('nilai/siswa_ekskul/form_siswa');
		$this->form->init('m_nilai_siswa_ekskul', 'nilai/siswa');

		if ($d['post_request'] && !$d['error'])
		{
			if ($this->m_nilai_siswa_ekskul->save())
			{
				$redir = ($this->input->post('redir') == 'nilai_ekskul') ?
					"nilai/ekstrakurikuler/id/{$d['row']['ekskul_nilai_id']}" :
					"nilai/siswa/id/{$d['row']['siswa_nilai_id']}";

				return redir($redir);
			}
		}

		$this->form->set();
		$this->_view();

	}

	public function form_tambah_ekskul_ke_siswa()
	{
		$d = & $this->d;
		$d['siswa_nilai_id'] = $this->input->get_post('siswa_nilai_id');

		if (!$d['admin'] && empty($d['ekskul_terkait']))
		{
			return alert_error("Anda tidak dapat menambah nilai ekskul siswa.", TRUE);
		}

		$this->_set('nilai/siswa_ekskul/form_tambah_ekskul_ke_siswa');

		if ($d['post_request'] && !$d['error'])
		{
			if ($this->m_nilai_siswa_ekskul->tambah_ekskul_ke_siswa($d['siswa_nilai_id']))
			{
				return redir("nilai/siswa/id/{$d['siswa_nilai_id']}");
			}
		}

		$this->_view();

	}

	public function hapus_ekskul_dr_siswa($nilai_siswa_ekskul_id = 0, $siswa_nilai_id = 0)
	{
		$this->db->delete('nilai_siswa_ekskul', array('id' => $nilai_siswa_ekskul_id));

		return redir("nilai/siswa/id/{$siswa_nilai_id}");

	}

}
