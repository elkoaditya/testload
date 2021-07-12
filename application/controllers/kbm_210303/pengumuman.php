<?php

class Pengumuman extends MY_Controller
{

	public function __construct()
	{
		
		parent::__construct(array(
			'controller'		 => array(
				'user'	 => '#login',
				'model'	 => 'm_kbm_pengumuman',
			),
			'kbm/pengumuman/browse'	 => array(
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
			'kbm/pengumuman/id'		 => array(
				//'model'		 => 'm_kbm_pengumuman_baca',
			),
			'kbm/pengumuman/pembaca' => array(
				'user'		 => array('sdm', 'admin'),
				'model'		 => array( 'm_option'),
				'library'	 => 'form',
				'helper'	 => 'form',
				'request'	 => array(
					'term'			 => 'clean',
					'kelas_id'		 => 'as_int',
				),
			),
			'kbm/pengumuman/form'	 => array(
				'user'		 => array('sdm', 'admin'),
				'model'		 => 'm_option',
				'library'	 => 'form',
				'helper'	 => 'form',
				'data'		 => array(
					'row' => array(
						'id'			 => 0,
						
						'author_id'		 => 0,
						'nama'			 => NULL,
						'prioritas'		 => 1,
						
						'konten'		 => NULL,
						'lampiran'		 => array(),
						
						'tanggal_tutup'	 => '',
						
						'tampil_guru'	 => 0,
						'tampil_siswa'	 => 0,
					),
				),
				'validasi'	 => array(
					array(
						array(
							'field'	 => 'nama',
							'label'	 => 'judul pengumuman',
							'rules'	 => 'required|strip_tags|clean|min_length[2]|max_length[100]',
						),
						array(
							'field'	 => 'konten',
							'label'	 => 'konten',
							'rules'	 => 'min_length[2]',
						),
					),
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

		if ($d['user']['role'] != 'siswa' && !$d['view'] && !$d['mengajar_list']):
			alert_info('Anda tidak terkait dengan pelajaran apapun.');
			return $this->_redir();
		endif;

		$this->_set('kbm/pengumuman/browse');
		
		$d['resultset_sendiri'] = $this->m_kbm_pengumuman->browse_sendiri($index, $limit);
		$d['resultset_sekolah'] = $this->m_kbm_pengumuman->browse_sekolah($index, $limit);
		$d['resultset_guru'] 	= $this->m_kbm_pengumuman->browse_guru($index, $limit);
		
		$this->_view();

	}

	public function form()
	{
		$this->_set('kbm/pengumuman/form');
		$this->form->init('m_kbm_pengumuman', 'kbm/pengumuman');

		$d = & $this->d;
		$d['author_ybs'] = ($d['user']['id'] == $d['row']['author_id']);

		$sql_opsi_kelas = "select id, nama from dakd_kelas where aktif = 1 order by grade ASC, nama ASC";
		$d['opsi_kelas'] = $this->md->result_series('id', 'nama', $sql_opsi_kelas);
		
		if($d['row']['id']>0){
			$sql_kelas_tampil = "select kelas_id, pengumuman_id from kbm_pengumuman_kelas where pengumuman_id = ".$d['row']['id']." ";
			$d['kelas'] = $this->md->result_series('kelas_id', 'pengumuman_id', $sql_kelas_tampil);
		}
		
		if (!$d['admin'] && !$d['author_ybs'] && !$d['mengajar_list'])
			return alert_error("Anda tidak dapat mengubah pengumuman.", 'kbm/pengumuman');

		if ($d['row']['id'] > 0 && !$d['author_ybs'] && !$d['admin'])
			return alert_error("Anda tak dapat mengubah isi pengumuman.", 'kbm/pengumuman');

		if ($d['post_request'] && !$d['error'])
			if ($this->m_kbm_pengumuman->save())
				return redir("kbm/pengumuman/id/{$d['form']['id']}");

		$this->form->set();
		$this->_view();

	}

	public function id($id = 0)
	{
		$d = & $this->d;

		$this->_set('kbm/pengumuman/id');
		$this->_rowset('m_kbm_pengumuman', $id, 'kbm/pengumuman');

		$this->m_kbm_pengumuman->baca($id);
		//if ($d['user']['role'] == 'siswa' && $d['post_request'])
			//$this->m_kbm_pengumuman_baca->jawab();

		//$this->m_kbm_pengumuman->hit();
		//$this->form->set();
		$this->_view();

	}

	public function pembaca($id = 0, $index = 0)
	{
		$d = & $this->d;

		if ($d['user']['role'] == 'siswa')
			return redir("kbm/pengumuman/id/{$id}");

		$this->_set('kbm/pengumuman/pembaca');
		$this->_rowset('m_kbm_pengumuman', $id, 'kbm/pengumuman');
		$d['resultset'] = $this->m_kbm_pengumuman->pembaca($d['row']['id'], $index, 100);
		$this->_view();

	}
	
	public function hapus($id = 0)
	{
		//$this->db->trans_start();
		$this->db->update('kbm_pengumuman',array('aktif' => '0') ,array('id' => $id));
		//$trx = $this->trans_done();

		//if (!$trx)
			//return alert_error("Database error saat menghapus materi, coba beberapa saat lagi.", 'kbm/materi');
		//else
			return alert_success("Data pengumuman berhasil dihapus.",'kbm/pengumuman');
		
	}
	
}
		