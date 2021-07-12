<?php

class Siswa extends MY_Controller
{

	public function __construct()
	{
		parent::__construct(array(
			'controller'					 => array(
				'user'	 => array('#login'),
				'model'	 => 'm_dprofil_siswa',
			),
			'data/profil/siswa/browse'		 => array(
				'model'		 => 'm_option',
				'library'	 => 'pagination',
				'helper'	 => 'form',
				'request'	 => array(
					'term' => 'clean',
					'kelas_id',
					'aktif',
				),
			),
			//'data/profil/siswa/id' => array(				),
			'data/profil/siswa/form'		 => array(
				'user'					 => array('admin', 'sdm', 'siswa'),
				'model'					 => array('m_option', 'm_data_user'),
				'library'				 => array('form', 'PhpThumbFactory'),
				'helper'				 => 'form',
				'data'					 => array(
					'row' => array(
						'id'					 => 0,
						// profil
						'nama'					 => NULL,
						'gender'				 => NULL,
						'lahir_tempat'			 => NULL,
						'lahir_tgl'				 => NULL,
						'agama_id'				 => NULL,
						'alamat'				 => NULL,
						'kota'					 => NULL,
						'telepon'				 => NULL,
						// kesiswaan
						'aktif'					 => 1,
						'nis'					 => NULL,
						'nisn'					 => NULL,
						'no_un' 				 => NULL,
						'kelas_id'				 => NULL,
						// masuk
						'masuk_jalur'			 => NULL,
						'masuk_semester_id'		 => NULL,
						'masuk_tgl'				 => NULL,
						'masuk_kelas_id'		 => NULL,
						// keluar
						'keluar_sebab'			 => NULL,
						'keluar_semester_id'	 => NULL,
						'keluar_tgl'			 => NULL,
						'keluar_kelas_id'		 => NULL,
						//keterangan
						'kelas_trahir_id'		 => NULL,
						// asal sekolah
						'asal_sekolah_nama'		 => NULL,
						'asal_sekolah_alamat'	 => NULL,
						'asal_sekolah_jenjang'	 => 'smp',
						'asal_ijazah_tahun'		 => NULL,
						'asal_ijazah_no'		 => NULL,
						'asal_skhu_no'			 => NULL,
						// keluarga
						'anak_ke'				 => 1,
						'status_keluarga'		 => NULL,
						'ayah_nama'				 => NULL,
						'ayah_pekerjaan'		 => NULL,
						'ibu_nama'				 => NULL,
						'ibu_pekerjaan'			 => NULL,
						'ortu_alamat'			 => NULL,
						'ortu_telepon'			 => NULL,
						'wali_nama'				 => NULL,
						'wali_alamat'			 => NULL,
						'wali_telepon'			 => NULL,
						'wali_pekerjaan'		 => NULL,
						'xdat'					 => array(),
						'modified'				 => NULL,
						'modifier_id'			 => NULL,
						// data user
						'username'				 => NULL,
						'login_last'			 => NULL,
					),
				),
				'validasi-umum'			 => array(
					// kesiswaan
					array(
						array(
							'field'	 => 'nis',
							'label'	 => 'NIS',
							'rules'	 => 'trim|required|clean|min_length[2]|max_length[20]',
						),
						array(
							'field'	 => 'nisn',
							'label'	 => 'NISN',
							'rules'	 => 'trim|alpha_dot_space|min_length[2]|max_length[32]',
						),
						array(
							'field'	 => 'no_un',
							'label'  => 'Nomer U N',
							'rules'  => 'trim|alpha_dot_space|min_length[2]|max_length[32]',
						),
						array(
							'field'	 => 'aktif',
							'label'	 => 'aktif login',
							'rules'	 => 'as_bool',
						),
					),
					// profil pribadi
					array(
						array(
							'field'	 => 'nama',
							'label'	 => 'nama',
							'rules'	 => 'required|trim|clean|min_length[2]|max_length[160]',
						),
						array(
							'field'	 => 'gender',
							'label'	 => 'gender',
							'rules'	 => 'required|trim|select[l;p]',
						),
						array(
							'field'	 => 'lahir_tempat',
							'label'	 => 'tempat lahir',
							'rules'	 => 'trim|clean|max_length[40]',
						),
						array(
							'field'	 => 'lahir_tgl',
							'label'	 => 'tanggal lahir',
							'rules'	 => 'trim|tgl2date[-]',
						),
						array(
							'field'	 => 'alamat',
							'label'	 => 'alamat',
							'rules'	 => 'clean|max_length[1024]',
						),
						array(
							'field'	 => 'kota',
							'label'	 => 'kota',
							'rules'	 => 'trim|clean|max_length[40]',
						),
						array(
							'field'	 => 'telepon',
							'label'	 => 'telepon',
							'rules'	 => 'trim|clean|max_length[20]',
						),
						//// MASUK TGL ///
						array(
							'field'	 => 'masuk_tgl',
							'label'	 => 'tanggal pendaftaran',
							'rules'	 => 'trim|tgl2date[-]',
						),
					),
					// asal sekolah
					array(
						array(
							'field'	 => 'asal_sekolah_nama',
							'label'	 => 'nama asal sekolah',
							'rules'	 => 'trim|clean|max_length[320]',
						),
						array(
							'field'	 => 'asal_sekolah_alamat',
							'label'	 => 'alamat asal sekolah',
							'rules'	 => 'clean|max_length[512]',
						),
						array(
							'field'	 => 'asal_sekolah_jenjang',
							'label'	 => 'Jenjang sekolah asal',
							'rules'	 => 'trim|max_length[10]',
						),
						array(
							'field'	 => 'asal_ijazah_tahun',
							'label'	 => 'tahun ijazah asal',
							'rules'	 => 'trim|in_range[2000-2100]',
						),
						array(
							'field'	 => 'asal_ijazah_no',
							'label'	 => 'nomor ijazah asal',
							'rules'	 => 'trim|clean|max_length[32]',
						),
						array(
							'field'	 => 'asal_skhu_no',
							'label'	 => 'nomor skhu asal',
							'rules'	 => 'trim|clean|max_length[32]',
						),
					),
					// profil keluarga
					array(
						array(
							'field'	 => 'status_keluarga',
							'label'	 => 'status keluarga',
							'rules'	 => 'trim|clean|max_length[20]',
						),
						array(
							'field'	 => 'anak_ke',
							'label'	 => 'nomor urut anak',
							'rules'	 => 'trim|numeric',
						),
						array(
							'field'	 => 'ayah_nama',
							'label'	 => 'nama ayah',
							'rules'	 => 'trim|clean|max_length[160]',
						),
						array(
							'field'	 => 'ayah_pekerjaan',
							'label'	 => 'pekerjaan ayah',
							'rules'	 => 'trim|clean|max_length[32]',
						),
						array(
							'field'	 => 'ibu_nama',
							'label'	 => 'nama ibu',
							'rules'	 => 'trim|clean|max_length[160]',
						),
						array(
							'field'	 => 'ibu_pekerjaan',
							'label'	 => 'pekerjaan ibu',
							'rules'	 => 'trim|clean|max_length[32]',
						),
						array(
							'field'	 => 'ortu_alamat',
							'label'	 => 'alamat orangtua',
							'rules'	 => 'clean|max_length[512]',
						),
						array(
							'field'	 => 'ortu_telepon',
							'label'	 => 'telepon orangtua',
							'rules'	 => 'trim|clean|max_length[40]',
						),
						array(
							'field'	 => 'wali_nama',
							'label'	 => 'nama wali',
							'rules'	 => 'trim|clean|max_length[40]',
						),
						array(
							'field'	 => 'wali_alamat',
							'label'	 => 'alamat wali',
							'rules'	 => 'clean|max_length[512]',
						),
						array(
							'field'	 => 'wali_telepon',
							'label'	 => 'telepon wali',
							'rules'	 => 'trim|clean|max_length[40]',
						),
						array(
							'field'	 => 'wali_pekerjaan',
							'label'	 => 'pekerjaan wali',
							'rules'	 => 'trim|clean|max_length[32]',
						),
					),
					'nis'	 => array(
						array(
							'field'	 => 'nis',
							'label'	 => 'NIS',
							'rules'	 => 'trim|required|clean|min_length[2]|max_length[20]|is_unique[dprofil_siswa.nis]'
						),
					),
					'nisn'	 => array(
						array(
							'field'	 => 'nisn',
							'label'	 => 'NISN',
							'rules'	 => 'trim|alpha_dot_space|max_length[32]|is_unique[dprofil_siswa.nis]',
						),
					),
					'no_un' => array(
						array(
							'field' => 'no_un',
							'label' => 'Nomer U N',
							'rules' => 'trim|alpha_dot_space|max_length[32]|is_unique[dprofil_siswa.no_un]',
						),
					),
				),
				'validasi-kelas-agama'	 => array(
					array(
						'field'	 => 'kelas_id',
						'label'	 => 'kelas',
						'rules'	 => 'trim|required|kelas_aktif',
					),
					array(
						'field'	 => 'agama_id',
						'label'	 => 'agama',
						'rules'	 => 'trim|is_exist[dmst_agama.id]',
					),
				),
				'validasi-masuk'		 => array(
					array(
						'field'	 => 'masuk_jalur',
						'label'	 => 'jalur pendaftaran',
						'rules'	 => 'required|trim|select[psb;pindah;lainnya]',
					),
					array(
						'field'	 => 'masuk_tgl',
						'label'	 => 'tanggal pendaftaran',
						'rules'	 => 'trim|tgl2date[-]',
					),
				),
			),
			'data/profil/siswa/impor_psb'	 => array(
				'library'	 => array('PHPExcel', 'form'),
				'helper'	 => 'form',
			),
			'data/profil/siswa/edit_excel_siswa'	 => array(
				'user'		 => array('admin'),
				'library'	 => 'form',
				'helper'	 => array('form'),
			),
			'data/profil/siswa/tambah_excel_siswa'	 => array(
				'user'		 => array('admin'),
				'model'		 => array('m_option', 'm_data_user'),
				'library'	 => array('form', 'PhpThumbFactory'),
				'helper'	 => array('form'),
			),
			'data/profil/siswa/pindah_kelas'	 => array(
				'user'		 => array('admin'),
				'library'	 => 'form',
				'helper'	 => array('form'),
			),
			'data/profil/siswa/delete_permanent'	 => array(
				'user'		 => array('admin'),
				'library'	 => 'form',
				'helper'	 => array('form'),
			),
		));
		$this->d['admin'] = cfguc_admin('akses', 'data', 'profil', 'siswa');
		$this->d['view'] = cfguc_view('akses', 'data', 'profil', 'siswa');

	}

	public function index()
	{
		if(THEME=='material_admin'){	
			$this->browse(0,3000);	
		}else{
			$this->browse();
		}
	}

	public function browse($index = 0,$limit = 50)
	{
		$this->_set('data/profil/siswa/browse');
		$this->d['resultset'] = $this->m_dprofil_siswa->browse($index, $limit);
		$this->_view();

	}

	public function form()
	{
		$d = & $this->d;

		$this->_set('data/profil/siswa/form');
		$this->form->init('m_dprofil_siswa', 'data/profil/siswa');
		$this->_form_prep();

		$d['siswa_ybs'] = ($d['user']['id'] == $d['row']['id']); ////

		//$sma_terbang = (($d['user']['role']=='sdm') && (APP_SCOPE == 'sma_terbang'));
		
		if(THEME=='material_admin'){
			if ($d['post_request'] && !$d['error'] && ($d['admin']||$d['siswa_ybs']) ):
				if ($this->m_dprofil_siswa->save()):
					$redir = "data/profil/siswa/" . (($this->input->post('ulang')) ? "form" : "id/{$d['form']['id']}");
					return redir($redir);
				endif;
			endif;
		}
		else{
			if (!$d['admin'] && !$d['siswa_ybs'] )
				return alert_error("Anda tidak dapat mengubah data profil siswa. {$d['user']['id']} == {$d['row']['id']}", '');
		
			if ($d['row']['keluar_semester_id'])
				return alert_error("Siswa tersebut telah lulus/keluar.", 'data/profil/siswa');
			
			if ($d['post_request'] && !$d['error']):
				if ($this->m_dprofil_siswa->save()):
					$redir = "data/profil/siswa/" . (($this->input->post('ulang')) ? "form" : "id/{$d['form']['id']}");
					return redir($redir);
				endif;
			endif;
		}
		
		$this->form->set();
		$this->_view();

	}

	public function _form_prep()
	{
		$d = & $this->d;

		if ($d['row']['id'] == 0 && $d['semaktif']['id'] == 0):
			$d['edit_mode'] = 'baru-psb';

		elseif ($d['row']['id'] == 0):
			$d['edit_mode'] = 'baru-pindah';

		elseif (!$d['row']['masuk_semester_id']):
			$d['edit_mode'] = 'edit-baru';

		elseif ($d['semaktif']['id'] == 0):
			$d['edit_mode'] = 'edit-masa_jeda';

		else:
			$d['edit_mode'] = 'edit-on_semester';

		endif;

		// prefill

		if ($d['row']['id'] == 0 && !$d['post_request'] && in_array($d['edit_mode'], array('baru-psb', 'baru-pindah'))):
			$d['row']['masuk_tgl'] = $this->d['dto']->format('Y-m-d');
		endif;

	}

	public function id($id = 0)
	{
		if(THEME=='material_admin'){
			$redir = "data/profil/siswa/form?id={$id}";
			return redir($redir);
		}else{
			$this->_set('data/profil/siswa/id');
			$this->_rowset('m_dprofil_siswa', $id, 'data/profil/siswa');
			$this->m_dprofil_siswa->rowsub($id);
			$this->_view();
		}
	}

	public function cover($id = 0, $output = 'pdf', $kurikulum = 'k13')
	{
		$id = str_replace(".pdf", "", $id);

		$this->_set('data/profil/siswa/cover');
		$this->_rowset('m_dprofil_siswa', $id, 'data/profil/siswa');
		$this->m_dprofil_siswa->rowsub($id);

		if ($output === 'html')
		{
			return $this->_view();
		}

		//return $this->_pdf($this->d["row"]["nis"]);
		return $this->_pdf($this->d["row"]["nis"], $kurikulum);
		// generator pdf sendiri

		$body = $this->_view("", TRUE);

		$this->load->library('mpdf');
		$this->mpdf->WriteHTML($body);
		$this->mpdf->Output($this->d["row"]["nis"] . ".pdf", "D");

	}
	
	// fungsi impor

	public function impor_psb()
	{
		$d = & $this->d;

		if (!$d['admin'])
			return alert_error("Anda tidak dapat menambah data siswa.");

		$this->_set('data/profil/siswa/impor_psb');

		if ($d['post_request'] && !$d['error'])
			if ($this->m_dprofil_siswa->impor_psb())
				return redir("data/profil/siswa");

		$this->form->set();
		$this->_view();

	}

	public function impor_psb_format()
	{
		$d = & $this->d;

		if (!$d['admin'])
			return alert_error("Anda tidak dapat menambah data siswa.");

		$this->load->library('PHPExcel');
		$this->m_dprofil_siswa->impor_psb_format();

	}
	
	public function edit_excel_siswa($aksi = '')
	{
		$this->_set('data/profil/siswa/edit_excel_siswa');

		$d = & $this->d;
		$format = ($aksi === 'expor');

		if ($d['user']['role'] != 'admin')
		{
			return alert_error('Edit Excel Siswa hanya dapat dilakukan melalui admin kurikulum.', 'data/profil/siswa');
		}
		
		if ($format)
			return $this->m_dprofil_siswa->edit_excel_siswa_expor();

		if (!$format && $d['post_request'] && !$d['error'])
			if ($this->m_dprofil_siswa->edit_excel_siswa_impor())
				return redir("data/profil/siswa");
		
		$this->form->set();
		$this->_view();
	}
	
	public function pindah_kelas($aksi = '')
	{
		$this->_set('data/profil/siswa/pindah_kelas');

		$d = & $this->d;
		$format = ($aksi === 'expor');

		if ($d['user']['role'] != 'admin')
		{
			return alert_error('Edit Excel Siswa hanya dapat dilakukan melalui admin kurikulum.', 'data/profil/siswa');
		}
		
		if ($format)
			return $this->m_dprofil_siswa->edit_excel_siswa_expor();

		if (!$format && $d['post_request'] && !$d['error'])
			if ($this->m_dprofil_siswa->edit_excel_siswa_impor())
				return redir("data/profil/siswa");
		
		$this->form->set();
		$this->_view();
	}
	public function tambah_excel_siswa($aksi = '')
	{
		$this->_set('data/profil/siswa/tambah_excel_siswa');

		$d = & $this->d;
		$format = ($aksi === 'expor');

		if ($d['user']['role'] != 'admin')
		{
			return alert_error('Tambah Excel Siswa hanya dapat dilakukan melalui admin kurikulum.', 'data/profil/siswa');
		}
		
		if ($format)
			return $this->m_dprofil_siswa->tambah_excel_siswa_expor();

		if (!$format && $d['post_request'] && !$d['error'])
			if ($this->m_dprofil_siswa->tambah_excel_siswa_impor())
				return redir("data/profil/siswa");
		
		$this->form->set();
		$this->_view();
	}
	
	public function delete_permanent($id = 0)
	{
		$d = & $this->d;
		$this->m_dprofil_siswa->delete_permanent($id);
		
		return redir("data/profil/siswa");
		
	}

}
