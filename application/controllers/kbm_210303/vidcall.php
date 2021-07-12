<?php

class vidcall extends MY_Controller
{

	public function __construct()
	{
		
		parent::__construct(array(
			'controller'		 => array(
				'user'	 => '#login',
				'model'	 => 'm_kbm_vidcall',
			),
			'kbm/vidcall/browse'	 => array(
				'model'		 => 'm_option',
				'library'	 => 'pagination',
				'helper'	 => 'form',
				'request'	 => array(
					'term'			 => 'clean',
					'author_id'		 => 'as_int',
					'tanggal_publish'=> 'clean',
					'tanggal_tutup'	 => 'clean',
				),
			),
			'kbm/vidcall/id'		 => array(
				//'model'		 => 'm_kbm_vidcall_baca',
			),
			'kbm/vidcall/pembaca' => array(
				'user'		 => array('sdm', 'admin'),
				'model'		 => array( 'm_option'),
				'library'	 => 'form',
				'helper'	 => 'form',
				'request'	 => array(
					'term'			 => 'clean',
					'kelas_id'		 => 'as_int',
				),
			),
			'kbm/vidcall/form'	 => array(
				'user'		 => array('sdm', 'admin'),
				'model'		 => 'm_option',
				'library'	 => 'form',
				'helper'	 => 'form',
				'data'		 => array(
					'row' => array(
						'id'			 => 0,
						
						'author_id'		 => 0,
						'nama'			 => NULL,
						'jenis_brand'	 => 1,
						
						'tanggal_publish'=> '',
						'tanggal_tutup'	 => '',
						
						'tampil_guru'	 => 0,
						'tampil_siswa'	 => 0,
					),
				),
				'validasi'	 => array(
					array(
						array(
							'field'	 => 'nama',
							'label'	 => 'judul vidcall',
							'rules'	 => 'required|strip_tags|clean|min_length[2]|max_length[100]',
						),
						array(
							'field'	 => 'konten',
							'label'	 => 'konten',
							'rules'	 => 'min_length[2]',
						),
						array(
							'field'	 => 'tanggal_publish',
							'label'	 => 'tanggal_publish',
							'rules'	 => 'required',
						),
						array(
							'field'	 => 'tanggal_tutup',
							'label'	 => 'tanggal_tutup',
							'rules'	 => 'required',
						),
					),
				),
			),
			'kbm/vidcall/surveillance' => array(
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
		if(THEME=='material_admin'){	
			$this->browse(0,3000);	
		}else{
			$this->browse();
		}

	}

	public function browse($index = 0,$limit = 1000)
	{
		$d = & $this->d;

		$this->_set('kbm/vidcall/browse');
		
		$d['resultset_sendiri'] = $this->m_kbm_vidcall->browse_sendiri($index, $limit);
		$d['resultset_sekolah'] = $this->m_kbm_vidcall->browse_sekolah($index, $limit);
		$d['resultset_guru'] 	= $this->m_kbm_vidcall->browse_guru($index, $limit);
		
		$this->_view();

	}

	public function form()
	{
		$this->_set('kbm/vidcall/form');
		$this->form->init('m_kbm_vidcall', 'kbm/vidcall');

		$d = & $this->d;
		$d['author_ybs'] = ($d['user']['id'] == $d['row']['author_id']);

		$sql_opsi_kelas = "select id, nama from dakd_kelas where aktif = 1 order by grade ASC, nama ASC";
		$d['opsi_kelas'] = $this->md->result_series('id', 'nama', $sql_opsi_kelas);
		
		if($d['row']['id']>0){
			$sql_kelas_tampil = "select kelas_id, vidcall_id from kbm_vidcall_kelas where vidcall_id = ".$d['row']['id']." ";
			$d['kelas'] = $this->md->result_series('kelas_id', 'vidcall_id', $sql_kelas_tampil);
		}
		
		if (!$d['admin'] && !$d['author_ybs'] && !$d['mengajar_list'])
			return alert_error("Anda tidak dapat mengubah vidcall.", 'kbm/vidcall');

		if ($d['row']['id'] > 0 && !$d['author_ybs'] && !$d['admin'])
			return alert_error("Anda tak dapat mengubah isi vidcall.", 'kbm/vidcall');

		if ($d['post_request'] && !$d['error']){
			if ($this->m_kbm_vidcall->save()){
				//echo "eeee".$d['form']['jenis_brand'];
				//if($d['form']['jenis_brand']!=1){
					return redir("kbm/vidcall/id/{$d['form']['id']}");
				//}
			}
		}
		
		$this->form->set();
		$this->_view();

	}

	public function id($id = 0)
	{
		$d = & $this->d;

		$this->_set('kbm/vidcall/id');
		$this->_rowset('m_kbm_vidcall', $id, 'kbm/vidcall');

		//$d['kelas_video'] = $this->m_kbm_vidcall->kelas_video($id);
		$d['id_record_vidcall'] = $this->m_kbm_vidcall->save_first_record_vidcall($id);
		
		$this->_view();

	}

	public function pembaca($id = 0, $index = 0)
	{
		$d = & $this->d;

		if ($d['user']['role'] == 'siswa')
			return redir("kbm/vidcall/id/{$id}");

		$this->_set('kbm/vidcall/pembaca');
		$this->_rowset('m_kbm_vidcall', $id, 'kbm/vidcall');
		$d['resultset'] = $this->m_kbm_vidcall->pembaca($d['row']['id'], $index, 100);
		$this->_view();

	}
	
	public function record_vidcall()
	{
		$this->_set('kbm/vidcall/record_vidcall');
		
		$response = $this->m_kbm_vidcall->save_record_vidcall();
		
		echo json_encode($response);      
		exit;

	}
	
	public function surveillance($index = 0) {
		$d = & $this->d;

		$this->_set('kbm/vidcall/surveillance');
		$this->_rowset('m_kbm_vidcall', $d['request']['id'], 'kbm/vidcall');
		
		$this->d['resultset'] = $this->m_kbm_vidcall->surveillance($index, 1000);
		
		$this->_view();
	}
	
	public function hapus($id = 0)
	{
		$this->db->update('kbm_vidcall',array('aktif' => '0') ,array('id' => $id));
		
			return alert_success("Data vidcall berhasil dihapus.",'kbm/vidcall');
		
	}
	
}
		