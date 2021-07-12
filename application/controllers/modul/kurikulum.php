<?php

class Kurikulum extends MY_Controller
{

	public function __construct()
	{
		parent::__construct(array(
			'controller'		 => array(
				'user'		 => array('admin','sdm','siswa'),
				'model'		 => 'm_modul_kurikulum',
				'library' => 'form',
				'helper' => 'form',
			),
			'modul/kurikulum/index'	 => array(
				'library'	 => 'pagination',
				'model'		 => 'm_option',
				'request'	 => array(
					
					'semester_id'	 => 'as_int',
				),
			),
			'modul/kurikulum/browse'	 => array(
				'library'	 => 'pagination',
				'model'		 => 'm_option',
				'request'	 => array(
					'term'			 => 'clean',
					'updater_id'	 => 'as_int',
					'semester_id'	 => 'as_int',
				),
			),
			'modul/kurikulum/id' => array(
						'library' => 'form',
						'helper' => 'form',
						
			),
			'modul/kurikulum/form' => array(
						'user' => array('sdm', 'admin'),
						'model' => 'm_option',
						'library' => 'form',
						'helper' => 'form',
						'data' => array(
								'row' => array(
										'id' => 0,
										'nama' => NULL,
										'kurikulum_id' => NULL,
										'lampiran' => array(),
										'keterangan' => NULL,
								),
						),
						'validasi' => array(
								array(
										array(
												'field' => 'nama',
												'label' => 'nama kurikulum',
												'rules' => 'required|strip_tags|clean|min_length[2]|max_length[100]',
										),
										array(
												'field' => 'kurikulum_id',
												'label' => 'kurikulum',
												'rules' => 'required',
										),
								),
						),
				),
				'modul/kurikulum/hapus_kurikulum_isi' => array(
						'library' => 'form',
						'helper' => 'form',
						
				),
		));
		$d = & $this->d;
		$d['admin'] = cfguc_admin('akses', 'kbm', 'materi');
		$d['view'] = cfguc_view('akses', 'kbm', 'materi');

	}

	public function form() {
		$this->_set('modul/kurikulum/form');
		$this->form->init('m_modul_kurikulum', 'modul/kurikulum');

		$d = & $this->d;
		
		/*if (!$d['admin'])
			return alert_error("Anda tidak dapat mengubah kurikulum.", 'kbm/materi');
		*/
		if ($d['semaktif']['id'] == 0)
			return alert_error("Tidak dapat mengubah data Kurikulum pada masa jeda semester.", '');
		
		if ($d['post_request'] && !$d['error'])
			if ($this->m_modul_kurikulum->save())
				return redir("modul/kurikulum/id/{$d['form']['id']}");

		$this->form->set();
		
		$this->_view();
	}
	
	public function id($id = 0) {
		$d = & $this->d;

		$this->_set('modul/kurikulum/id');
		$this->_rowset('m_modul_kurikulum', $id, 'modul/kurikulum');

		$this->form->set();
		$this->_view();
	}
	/*
	public function index($index = 0)
	{
		$this->_set('modul/kurikulum/index');
		
		$d = & $this->d;

		if (!$d['request']['semester_id'] && $d['semaktif']['id'] > 0)
		{
			$d['request']['semester_id'] = $d['semaktif']['id'];
		}
		
		$kurikulum = $this->m_modul_kurikulum->modul_kurikulum();
		
		foreach($kurikulum['data'] as $data_kurikulum)
		{
			$this->d['isi_kurikulum'][$data_kurikulum['id']] = $this->m_modul_kurikulum->browse($index, 100,$data_kurikulum['id']);
		}
		
		$this->d['kurikulum'] = $kurikulum;
		$this->d['resultset'] = $this->m_modul_kurikulum->browse($index, 100);
		$this->_view();

	}*/
	
	public function browse($kode = '')
	{
		$this->_set('modul/kurikulum/browse');
		
		$d = & $this->d;

		if (!$d['request']['semester_id'] && $d['semaktif']['id'] > 0)
		{
			$d['request']['semester_id'] = $d['semaktif']['id'];
		}
		
		$kurikulum = $this->m_modul_kurikulum->modul_kurikulum(0, 50, $kode);
		
		$this->d['kurikulum'] = $kurikulum;
		$this->d['resultset'] = $this->m_modul_kurikulum->browse(0, 200, $kode);
		$this->_view();

	}
	
	public function hapus_kurikulum_isi($kurikulum_isi_id = 0)
	{
		$this->m_modul_kurikulum->hapus($kurikulum_isi_id);
		return redir("modul/kurikulum");

	}
	
	
}

?>