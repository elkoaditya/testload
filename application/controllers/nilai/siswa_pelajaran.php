<?php

class Siswa_pelajaran extends MY_Controller
{

	public function __construct()
	{
		$rule_nilai_angka = 'trim|numeric|max_length[6]|less_than[100]';
		$rule_nilai_predikat = 'trim|clean|max_length[6]|strtoupper';

		parent::__construct(array(
			'controller'				 => array(
				'user'	 => array('admin', 'sdm'),
				'model'	 => 'm_nilai_siswa_pelajaran',
			),
			'nilai/siswa_pelajaran/form' => array(
				'user'		 => array('admin', 'sdm'),
				'library'	 => 'form',
				'helper'	 => 'form',
				'validasi'	 => array(
					array(
						array(
							'field'	 => 'nas_teori',
							'label'	 => 'Nilai Akhir Semester Kognitif',
							'rules'	 => $rule_nilai_angka,
						),
						array(
							'field'	 => 'nas_praktek',
							'label'	 => 'Nilai Akhir Semester Psikomotor',
							'rules'	 => $rule_nilai_angka,
						),
						array(
							'field'	 => 'nas_sikap',
							'label'	 => 'Nilai Akhir Semester Afektif',
							'rules'	 => $rule_nilai_angka,
						),
						array(
							'field'	 => 'pred_teori',
							'label'	 => 'Predikat Akhir Semester Kognitif',
							'rules'	 => $rule_nilai_predikat,
						),
						array(
							'field'	 => 'pred_praktek',
							'label'	 => 'Predikat Akhir Semester Psikomotor',
							'rules'	 => $rule_nilai_predikat,
						),
						array(
							'field'	 => 'pred_sikap',
							'label'	 => 'Predikat Akhir Semester Afektif',
							'rules'	 => $rule_nilai_predikat,
						),
						array(
							'field'	 => 'mid_teori',
							'label'	 => 'Nilai Mid Semester Kognitif',
							'rules'	 => $rule_nilai_angka,
						),
						array(
							'field'	 => 'mid_praktek',
							'label'	 => 'Nilai Mid Semester Psikomotor',
							'rules'	 => $rule_nilai_angka,
						),
						array(
							'field'	 => 'mid_sikap',
							'label'	 => 'Nilai Mid Semester Afektif',
							'rules'	 => $rule_nilai_angka,
						),
						array(
							'field'	 => 'mid_pred_teori',
							'label'	 => 'Predikat Mid Semester Kognitif',
							'rules'	 => $rule_nilai_predikat,
						),
						array(
							'field'	 => 'mid_pred_praktek',
							'label'	 => 'Predikat Mid Semester Psikomotor',
							'rules'	 => $rule_nilai_predikat,
						),
						array(
							'field'	 => 'mid_pred_sikap',
							'label'	 => 'Predikat Mid Semester Afektif',
							'rules'	 => $rule_nilai_predikat,
						),
						array(
							'field'	 => 'uas',
							'label'	 => 'Nilai Ulangan Akhir Semester',
							'rules'	 => $rule_nilai_angka,
						),
						array(
							'field'	 => 'uts',
							'label'	 => 'Nilai Ulangan Mid Semester',
							'rules'	 => $rule_nilai_angka,
						),
					),
				),
				array(
					'field'	 => '___',
					'label'	 => '___',
					'rules'	 => $rule_nilai_predikat,
				),
			),
			'nilai/siswa_pelajaran/form_catatan' => array(
				'user'		 => array('admin', 'sdm'),
				'library'	 => 'form',
				'helper'	 => 'form',
				'validasi'	 => array(
					array(
						array(
							'field'	 => 'kompetensi',
							'label'	 => 'Kompetensi Siswa (KTSP)',
							'rules'	 => 'clean|max_length[3000]',
						),
						array(
							'field'	 => 'cat_teori',
							'label'	 => 'Catatan Teori Siswa (K13)',
							'rules'	 => 'clean|max_length[3000]',
						),
						array(
							'field'	 => 'cat_prakteki',
							'label'	 => 'Catatan Praktek Siswa  Siswa (K13)',
							'rules'	 => 'clean|max_length[3000]',
						),
					),
				),
			),
		));

		$d = & $this->d;
		$d['admin'] = cfguc_admin('akses', 'nilai', 'siswa') OR cfguc_admin('akses', 'nilai', 'pelajaran');
		$d['view'] = cfguc_view('akses', 'nilai', 'siswa') OR cfguc_view('akses', 'nilai', 'pelajaran');
		$d['walikelas'] = (array) cfgu('walikelas');
		$d['user_siswa'] = user_role('siswa');

		if (!$d['view'] && !$d['walikelas'] && !$d['user_siswa'])
		{
			return alert_info('Anda tidak terkait dengan siswa apapun.', '');
		}

	}

	public function form()
	{
		$d = & $this->d;

		if (!$d['admin'])
		{
			return alert_error("Anda tidak dapat mengubah nilai pelajaran siswa.", TRUE);
		}


		$this->_set('nilai/siswa_pelajaran/form');
		$this->form->init('m_nilai_siswa_pelajaran', 'nilai/siswa');

		if ($d['post_request'] && !$d['error'])
		{
			if ($this->m_nilai_siswa_pelajaran->save())
			{
				$redir = ($this->input->post('redir') == 'nilai_pelajaran') ?
					"nilai/pelajaran/id/{$d['row']['pelajaran_nilai_id']}" :
					"nilai/siswa/id/{$d['row']['siswa_nilai_id']}";

				return redir($redir);
			}
		}

		$this->form->set();
		$this->_view();

	}
	
	public function form_catatan()
	{
		$d = & $this->d;

		if (!$d['admin'])
		{
			return alert_error("Anda tidak dapat mengubah nilai pelajaran siswa.", TRUE);
		}


		$this->_set('nilai/siswa_pelajaran/form_catatan');
		$this->form->init('m_nilai_siswa_pelajaran', 'nilai/siswa');

		if ($d['post_request'] && !$d['error'])
		{
			if ($this->m_nilai_siswa_pelajaran->save_catatan())
			{
				$redir = "nilai/siswa/id/{$d['row']['siswa_nilai_id']}";

				return redir($redir);
			}
		}

		$this->form->set();
		$this->_view();

	}

}
