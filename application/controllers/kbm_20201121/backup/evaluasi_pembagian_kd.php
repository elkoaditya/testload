<?php

class Evaluasi_pembagian_kd extends MY_Controller
{

	public function __construct()
	{
		parent::__construct(array(
			'controller'			 => array(
				//'user'	 => array('#login'),
				'user'		 => array('admin', 'sdm'),
				'model'	 => 'm_kbm_evaluasi_pembagian_kd',
			),
			'kbm/evaluasi_pembagian_kd/form'	 => array(
				'model'		=> array('m_option','m_kbm_evaluasi'),
				'library' 	=> 'form',
				'helper' 	=> 'form',
				
				'data' => array(
						'row' => array(
								'id' => 0,
								'nama' => NULL,
								'soal_jml' => 0,
								
						),
				),
				'validasi' => array(
						array(
								array(
										'field' => 'nama KD',
										'label' => 'nama',
										'rules' => 'required|clean_html|max_length[32000]',
								),
						),
				),
			),
		));
		$this->d['admin'] = cfguc_admin('akses', 'kbm', 'evaluasi');
	}
	
	public function _rowset_evaluasi($evaluasi_id) {

		if ($evaluasi_id <= 0)
			return alert_info('Pilih nama soal evaluasi yang hendak ditampilkan.', 'kbm/evaluasi');

		$d = & $this->d;
		$d['evaluasi'] = $this->_rowset('m_kbm_evaluasi', $evaluasi_id, 'kbm/evaluasi', FALSE);
		$d['author_ybs'] = ($d['user']['id'] == $d['evaluasi']['author_id']);

		//if (!$d['author_ybs'] && !$d['view'])
			//return alert_error("Anda tak diperbolehkan mengakses soal evaluasi.", 'kbm/evaluasi');
	}
	
	public function form()
	{
		$d = & $this->d;
		$this->_set('kbm/evaluasi_pembagian_kd/form');
		$this->_rowset_evaluasi($this->input->get_post('evaluasi_id'));
		
		$d['row'] = $this->m_kbm_evaluasi_pembagian_kd->rowset($this->input->get_post('evaluasi_id'), $this->input->get_post('posisi_kd'));
		
		if ($this->d['post_request'])
			if ($this->m_kbm_evaluasi_pembagian_kd->save())
				return redir("kbm/evaluasi/id/{$this->input->get_post('evaluasi_id')}");

		$this->_view();

	}
}