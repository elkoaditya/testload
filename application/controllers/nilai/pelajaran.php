<?php

class Pelajaran extends MY_Controller
{

	// utama

	public function __construct()
	{
		parent::__construct(array(
			'controller'						 => array(
				'user'	 => '#login',
				'model'	 => 'm_nilai_pelajaran',
			),
			'nilai/pelajaran/browse'			 => array(
				'user'		 => array('admin', 'sdm'),
				'model'		 => 'm_option',
				'helper'	 => 'form',
				'request'	 => array(
					'term'		 => 'clean',
					'kelas_id'	 => 'as_int',
					'semester_id',
				),
			),
			'nilai/pelajaran/id'				 => array(
				'user'		 => array('admin', 'sdm'),
				'model'		 => array('m_nilai_siswa_pelajaran', 'm_option'),
				'request'	 => array(
					'term'		 => 'clean',
					'kelas_id'	 => 'as_int',
				),
			),
			'nilai/pelajaran/expor'				 => array(
				'user'		 => array('admin', 'sdm'),
				'model'		 => array(
					'm_nilai_siswa_pelajaran',
					'cm_nilai_pelajaran' => 'costumized/' . strtolower(APP_SCOPE) . '/cm_nilai_pelajaran',
				),
				'helper'	 => 'excel',
				'request'	 => array(
					'term'		 => 'clean',
					'kelas_id'	 => 'as_int',
				),
			),
			'nilai/pelajaran/impor'				 => array(
				'user'		 => array('admin', 'sdm'),
				'model'		 => array(
					'm_nilai_siswa_pelajaran', 'm_nilai_siswa', 'm_nilai_pelajaran_kelas', 'm_nilai_kelas',
					'm_app_config',
					'cm_nilai_pelajaran' => 'costumized/' . strtolower(APP_SCOPE) . '/cm_nilai_pelajaran',
				),
				'library'	 => 'form',
				'helper'	 => array('form'),
			),
			
			'nilai/pelajaran/expor_usbn'				 => array(
				'user'		 => array('admin', 'sdm'),
				'model'		 => array(
					'm_nilai_siswa_pelajaran',
					'cm_nilai_pelajaran_usbn' => 'costumized/' . strtolower(APP_SCOPE) . '/cm_nilai_pelajaran_usbn',
				),
				'helper'	 => 'excel',
				'request'	 => array(
					'term'		 => 'clean',
					'kelas_id'	 => 'as_int',
				),
			),
			'nilai/pelajaran/impor_usbn'				 => array(
				'user'		 => array('admin', 'sdm'),
				'model'		 => array(
					'm_nilai_siswa_pelajaran', 'm_nilai_siswa', 'm_nilai_pelajaran_kelas', 'm_nilai_kelas',
					'm_app_config',
					'cm_nilai_pelajaran_usbn' => 'costumized/' . strtolower(APP_SCOPE) . '/cm_nilai_pelajaran_usbn',
				),
				'library'	 => 'form',
				'helper'	 => array('form'),
			),
			
			'nilai/pelajaran/template'			 => array(
				'user'		 => array('admin', 'sdm'),
				'model'		 => array(
					'cm_nilai_pelajaran' => 'costumized/' . strtolower(APP_SCOPE) . '/cm_nilai_pelajaran',
				),
				'library'	 => 'form',
				'helper'	 => array('form'),
			),
			'nilai/pelajaran/template_sekolah'	 => array(
				'user'		 => array('admin', 'sdm'),
				'model'		 => array(
					'cm_nilai_pelajaran' => 'costumized/' . strtolower(APP_SCOPE) . '/cm_nilai_pelajaran',
				),
				'library'	 => 'form',
				'helper'	 => array('form'),
			),
			'nilai/pelajaran/upload_deskripsi'	 => array(
				'user'		 => array('admin', 'sdm'),
				'library'	 => 'form',
				'helper'	 => array('form'),
				
			),
		));
		
		$dua_kurikulum = array(
			'demo','sman3smg',
			'sman8smg','sman9smg','sman11smg',
			'sman14smg','sma_michael',
			'smaissa1smg',
			'sma_setiabudhi','sma_setiabudhi_rev16_17',
			'smk_nusaputera','smk_penerbangan',
			'smakristen1_wsb','smkpltarcisius',
			'sma_terbang','smp_terbang', 'smkn6smg');
		
		foreach($dua_kurikulum as $dk)
		{
			if(strtolower(APP_SCOPE)==$dk)
			{
				$this->load->model('costumized/' . strtolower(APP_SCOPE) . '/cm_nilai_pelajaran_ktsp','cm_nilai_pelajaran_ktsp');
				$this->load->model('costumized/' . strtolower(APP_SCOPE) . '/cm_nilai_pelajaran_k13','cm_nilai_pelajaran_k13');
			}
		}
		$d = & $this->d;
		$d['admin'] = cfguc_admin('akses', 'nilai', 'pelajaran');
		$d['view'] = cfguc_view('akses', 'nilai', 'pelajaran');
		$d['mengajar_list'] = (array) cfgu('mengajar_list');
		$d['pelajaran_list'] = (array) cfgu('pelajaran_list');

		if (!$d['view'] && !$d['mengajar_list'] && !$d['pelajaran_list'])
			return alert_info('Anda tidak terkait dengan pelajaran apapun.', '');

	}

	public function index()
	{
		$this->browse();

	}

	// akses data umum

	public function browse($index = 0)
	{
		$this->_set('nilai/pelajaran/browse');

		$d = & $this->d;

		if (!$d['request']['semester_id'] && $d['semaktif']['id'] > 0)
		{
			$d['request']['semester_id'] = $d['semaktif']['id'];
		}

		$d['resultset'] = $this->m_nilai_pelajaran->browse($index, 50);

		$this->_view();

	}

	public function id($id = 0, $index = 0, $dump = '')
	{
		$this->_set('nilai/pelajaran/id');
		$this->_rowset('m_nilai_pelajaran', $id, 'nilai/pelajaran');

		$this->d['pengajar'] = ($this->d['user']['id'] == $this->d['row']['guru_id']);
		$this->d['resultset'] = $this->m_nilai_siswa_pelajaran->pelajaran($id, $index, 50);
		$this->d['kelas'] = $this->m_nilai_siswa_pelajaran->pelajaran_kelas($id);

		if ($dump === 'dump')
		{
			return $this->_dump();
		}
//return alert_info(print_r($this->d));
		$this->_view(APP_SCOPE);

	}

	public function expor($id = 0, $kurikulum='')
	{
		set_time_limit(130);
		$d = & $this->d;

		if ($d['user']['role'] == 'siswa')
			return redir("nilai/siswa/id/{$d['user']['id']}");

		$this->_set('nilai/pelajaran/expor');
		$this->_rowset('m_nilai_pelajaran', $id, 'nilai/pelajaran');

		$d['pengajar'] = ($this->d['user']['id'] == $this->d['row']['guru_id']);

		if (!$d['admin'] && !$d['pengajar'])
			return alert_error('Anda tidak dapat mengakses nilai pelajaran.', '');

		$d['resultset'] = $this->m_nilai_siswa_pelajaran->pelajaran($id, 0, 4096);

		$d['resultset2'] = $this->m_nilai_siswa_pelajaran->catatan_guru($id, 0, 1000);

		if ($d['resultset']['selected_rows'] == 0)
			return alert_info('Daftar nilai siswa tidak ditemukan. Periksa peserta pelajaran dan filter pencarian.', "nilai/pelajaran/id/{$id}");

		
		
		//$this->_dump();
		if($kurikulum == 'ktsp')
			$this->cm_nilai_pelajaran_ktsp->expor();
		elseif($kurikulum == 'k13')
			$this->cm_nilai_pelajaran_k13->expor();
			//$this->_dump();
		else
			$this->cm_nilai_pelajaran->expor();

	}
	
	public function expor_usbn($id = 0, $kurikulum='')
	{
		set_time_limit(130);
		$d = & $this->d;

		if ($d['user']['role'] == 'siswa')
			return redir("nilai/siswa/id/{$d['user']['id']}");

		$this->_set('nilai/pelajaran/expor_usbn');
		$this->_rowset('m_nilai_pelajaran', $id, 'nilai/pelajaran');

		$d['pengajar'] = ($this->d['user']['id'] == $this->d['row']['guru_id']);

		if (!$d['admin'] && !$d['pengajar'])
			return alert_error('Anda tidak dapat mengakses nilai pelajaran.', '');

		$d['resultset'] = $this->m_nilai_siswa_pelajaran->pelajaran($id, 0, 4096);

		if ($d['resultset']['selected_rows'] == 0)
			return alert_info('Daftar nilai siswa tidak ditemukan. Periksa peserta pelajaran dan filter pencarian.', "nilai/pelajaran/id/{$id}");

		$this->cm_nilai_pelajaran_usbn->expor();
		

	}

	public function impor($id = 0, $kurikulum='')
	{
		$this->_set('nilai/pelajaran/impor');
		
		set_time_limit(130);
		$d = & $this->d;
		$d['kurikulum'] = $kurikulum;
		
		$upload_nilai_pelajaran = $this->m_app_config->get('upload_nilai_pelajaran');

		if ($d['user']['role'] != 'admin' && $upload_nilai_pelajaran != 'enable')
		{
			return alert_error('Upload nilai sementara dinonaktifkan.', 'nilai/pelajaran');
		}

		//if ($d['semaktif']['id'] < 1)
		//	return alert_error('Tak dapat mengimpor nilai pada masa jeda semester.', 'nilai/siswa');

		if ($d['user']['role'] == 'siswa')
			return redir("nilai/siswa");

		$this->_rowset('m_nilai_pelajaran', $id, 'nilai/pelajaran');

		$d['pengajar'] = ($d['user']['id'] == $d['row']['guru_id']);

		if (!$d['admin'] && !$d['pengajar'])
			return alert_error('Anda tidak dapat mengakses nilai pelajaran.', '');

		if ($d['semaktif']['id'] != $d['row']['semester_id'] && $d['pengajar'])
			return alert_error('Impor hanya berlaku pada nilai semester aktif saja.', "nilai/pelajaran/id/{$d['row']['id']}");

		if ($d['post_request'] && !$d['error']){
			
			if($kurikulum == 'ktsp'){
				if ($this->cm_nilai_pelajaran_ktsp->impor()){
					return redir("nilai/pelajaran/id/{$id}");
				}
			}elseif($kurikulum == 'k13'){
				if ($this->cm_nilai_pelajaran_k13->impor()){
					return redir("nilai/pelajaran/id/{$id}"); 
				}
			}else{
				if ($this->cm_nilai_pelajaran->impor()){
					return redir("nilai/pelajaran/id/{$id}");
				}
			} 
		}
			
		$this->form->set();
		$this->_view();

	}
	
	public function impor_usbn($id = 0, $kurikulum='')
	{
		$this->_set('nilai/pelajaran/impor_usbn');
		
		set_time_limit(130);
		$d = & $this->d;
		$d['kurikulum'] = $kurikulum;
		
		$upload_nilai_pelajaran = $this->m_app_config->get('upload_nilai_pelajaran');

		if ($d['user']['role'] != 'admin' && $upload_nilai_pelajaran != 'enable')
		{
			return alert_error('Upload nilai sementara dinonaktifkan.', 'nilai/pelajaran');
		}

		//if ($d['semaktif']['id'] < 1)
		//	return alert_error('Tak dapat mengimpor nilai pada masa jeda semester.', 'nilai/siswa');

		if ($d['user']['role'] == 'siswa')
			return redir("nilai/siswa");

		$this->_rowset('m_nilai_pelajaran', $id, 'nilai/pelajaran');

		$d['pengajar'] = ($d['user']['id'] == $d['row']['guru_id']);

		if (!$d['admin'] && !$d['pengajar'])
			return alert_error('Anda tidak dapat mengakses nilai pelajaran.', '');

		if ($d['semaktif']['id'] != $d['row']['semester_id'] && $d['pengajar'])
			return alert_error('Impor hanya berlaku pada nilai semester aktif saja.', "nilai/pelajaran/id/{$d['row']['id']}");

		if ($d['post_request'] && !$d['error']){
			
			if ($this->cm_nilai_pelajaran_usbn->impor()){
				return redir("nilai/pelajaran/id/{$id}"); 
			}
		}
			
		$this->form->set();
		$this->_view();

	}

	public function template($id = 0)
	{
		return redir('nilai/pelajaran');

		$d = & $this->d;

		if ($d['semaktif']['id'] < 1)
		{
			return alert_error('Tak dapat upload template nilai pada masa jeda semester.', 'nilai/siswa');
		}

		$this->_set('nilai/pelajaran/template');
		$this->_rowset('m_nilai_pelajaran', $id, 'nilai/pelajaran');

		$d['pengajar'] = ($d['user']['id'] == $d['row']['guru_id']);

		if (!$d['admin'] && !$d['pengajar'])
		{
			return alert_error('Anda tidak dapat mengakses nilai pelajaran.', '');
		}

		if ($d['semaktif']['id'] != $d['row']['semester_id'])
		{
			return alert_error('Upload Template hanya berlaku pada nilai semester aktif saja.', "nilai/pelajaran/id/{$id}");
		}

		if ($d['post_request'] && !$d['error'])
		{
			if ($this->cm_nilai_pelajaran->template_pelajaran())
			{
				return redir("nilai/pelajaran/id/{$id}");
			}
		}

		$this->form->set();
		$this->_view();

	}

	public function template_sekolah($kurikulum='')
	{
		//return redir('nilai/pelajaran');
		$d = & $this->d;

		if ($d['semaktif']['id'] < 1)
		{
			return alert_error('Tak dapat upload template nilai pada masa jeda semester.', 'nilai/siswa');
		}

		$this->_set('nilai/pelajaran/template_sekolah');
		
		$d['kurikulum'] = $kurikulum;
		
		if (!$d['admin'])
		{
			return alert_error('Anda tidak dapat mengakses nilai pelajaran.', '');
		}

		if ($d['post_request'] && !$d['error'])
		{
			if($kurikulum == 'ktsp'){
				if ($this->cm_nilai_pelajaran_ktsp->template_sekolah())
					return redir("nilai/pelajaran");
			}elseif($kurikulum == 'k13'){
				if ($this->cm_nilai_pelajaran_k13->template_sekolah())
					return redir("nilai/pelajaran");
			}else{
				if ($this->cm_nilai_pelajaran->template_sekolah())
					return redir("nilai/pelajaran");
			}
		}

		$this->form->set();
		$this->_view();

	}
	
	public function upload_deskripsi($aksi = '', $semester='')
	{
		$this->_set('nilai/pelajaran/upload_deskripsi');

		$d = & $this->d;
		$format = ($aksi === 'expor');

		if ($d['user']['role'] != 'admin')
		{
			return alert_error('Impor hanya dapat dilakukan melalui admin kurikulum.', 'nilai/pelajaran');
		}
		if ($d['semaktif']['id'] < 1)
			return alert_error('Tak dapat mengimpor deskripsi pada masa jeda semester.', 'nilai/pelajaran');

		if ($format)
			return $this->m_nilai_pelajaran->upload_deskripsi_expor($semester);

		if (!$format && $d['post_request'] && !$d['error'])
			if ($this->m_nilai_pelajaran->upload_deskripsi_impor())
				return redir("nilai/pelajaran");
		
		$this->form->set();
		$this->_view();
	}

}
