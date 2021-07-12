<?php

class Bank_soal extends MY_Controller
{

	public function __construct()
	{
		parent::__construct(array(
			'controller'			 => array(
				//'user'	 => array('#login'),
				'user'		 => array('admin', 'sdm'),
				'model'	 => 'm_kbm_bank_soal',
				'helper' => 'soal',
			),
			'kbm/bank_soal/browse'	 => array(
				'model'		 => 'm_option',
				'library'	 => 'pagination',
				'helper'	 => 'form',
				'request'	 => array(
					'term'			 => 'clean',
					'kurikulum_id'	 => 'trim|as_int',
					'kategori_id'	 => 'trim|as_int',
					'mapel_id'	 	=> 'trim|as_int',
					'grade'			=> 'trim|as_int',
				),
			),
			'kbm/bank_soal/evaluasi_add'	 => array(
				'model'		 => 'm_option',
				'library'	 => 'pagination',
				'helper'	 => 'form',
				'request'	 => array(
					'term'			 => 'clean',
					'evaluasi_id'	 => 'trim|as_int',
					'kurikulum_id'	 => 'trim|as_int',
					'kategori_id'	 => 'trim|as_int',
					'mapel_id'	 	=> 'trim|as_int',
					'grade'			=> 'trim|as_int',
				),
			),
			'kbm/bank_soal/form' => array(
				'model'		=> array('m_option','m_kbm_evaluasi_soal'),
				'library' 	=> 'form',
				'helper' 	=> 'form',
				
				'data' => array(
						'row' => array(
								'id' => 0,
								'evaluasi_id' => NULL,
								'pertanyaan' => NULL,
								'gambar' => NULL,
								'poin_min' => NULL,
								'poin_max' => 10,
								'pilihan' => array(
										'kunci' => array(),
										'pengecoh' => array(),
								),
						),
						'pilihan' => array(
								'kunci' => NULL,
								'pengecoh-1' => NULL,
								'pengecoh-2' => NULL,
								'pengecoh-3' => NULL,
								'pengecoh-4' => NULL,
						),
				),
				'validasi' => array(
						array(
								array(
										'field' => 'pertanyaan',
										'label' => 'nama bank soal',
										'rules' => 'required|clean_html|max_length[32000]',
								),
								array(
										'field' => 'komp_dasar_id',
										'label' => 'Kompetensi Dasar bank soal',
										'rules' => 'required',
								),
								array(
										'field' => 'kesukaran',
										'label' => 'Tingkat kesukaran bank soal',
										'rules' => 'required',
								),
						),
				),
			),
			'kbm/bank_soal/delete' => array(
						'library' => 'form',
						'helper' => 'form',
						
				),
			
		));
		$this->d['admin'] = cfguc_admin('akses', 'kbm', 'evaluasi');
		$this->d['view'] = cfguc_view('akses', 'kbm', 'evaluasi');
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

	public function _rowset_evaluasi($evaluasi_id) {

		if ($evaluasi_id <= 0)
			return alert_info('Pilih nama soal evaluasi yang hendak ditampilkan.', 'kbm/evaluasi');

		$d = & $this->d;
		$d['evaluasi'] = $this->_rowset('m_kbm_evaluasi', $evaluasi_id, 'kbm/evaluasi', FALSE);
		$d['author_ybs'] = ($d['user']['id'] == $d['evaluasi']['author_id']);

		if (!$d['author_ybs'] && !$d['view'])
			return alert_error("Anda tak diperbolehkan mengakses soal evaluasi.", 'kbm/evaluasi');
	}
	
	public function evaluasi_add($index = 0,$limit = 20)
	{
		$d = & $this->d;

		if ($d['user']['role'] == 'sdm' && !$d['mengajar_list'])
			return alert_info('Anda tidak terkait dengan pelajaran apapun.', '');

		$this->_set('kbm/bank_soal/evaluasi_add');
		
		$d['form']['kurikulum_id'] 	= $this->input->get_post('kurikulum_id');
		$d['form']['kategori_id'] 	= $this->input->get_post('kategori_id');
		$d['form']['mapel_id'] 		= $this->input->get_post('mapel_id');
		$d['form']['evaluasi_id'] 	= $this->input->get_post('evaluasi_id');
		
		$this->_rowset_evaluasi($d['form']['evaluasi_id']);
		
		$d['resultset'] = $this->m_kbm_bank_soal->browse($index, $limit);
		//alert_error("BBBB");
		if($this->input->post('tambah') == 'bank_soal'){
			//alert_error("BBBB");
			if ($d['post_request'] && !$d['error'])
			{
				if ($this->m_kbm_bank_soal->save_to_evaluasi())
				{
					$redir = "/kbm/evaluasi/id/{$d['form']['evaluasi_id']}" ;

					return redir($redir);
				}
			}
		}
		
		// $this->_dump();
		$this->_view();

	}
	
	public function browse($index = 0,$limit = 20)
	{
		$d = & $this->d;

		if ($d['user']['role'] == 'sdm' && !$d['mengajar_list'])
			return alert_info('Anda tidak terkait dengan pelajaran apapun.', '');

		$this->_set('kbm/bank_soal/browse');
		$d['resultset'] = $this->m_kbm_bank_soal->browse($index, $limit);

		$this->_view();

	}

	public function form() {
		$d = & $this->d;
		$tambah = (bool) $this->input->post('tambah');

		$this->_set('kbm/bank_soal/form');
		
		if($this->input->get_post('evaluasi_id')){
			$this->form->init('m_kbm_evaluasi_soal', 'kbm/evaluasi');
		}else{
			$this->form->init('m_kbm_bank_soal', 'kbm/bank_soal');
		}
		
		$d['form']['redir'] = $this->input->get_post('redir');
		
		if($this->input->get_post('evaluasi_id')){
			$d['form']['id']='';
		}
		
		$kurikulum_id 	= $this->input->get_post('kurikulum_id');
		$kategori_id 	= $this->input->get_post('kategori_id');
		$mapel_id 		= $this->input->get_post('mapel_id');
		$grade 			= $this->input->get_post('grade');
		$komp_dasar_id	= $this->input->get_post('komp_dasar_id');
/*
		$d['form']['kurikulum_id'] = $this->input->get_post('kurikulum_id');
		$d['form']['kategori_id'] = $this->input->get_post('kategori_id');
		$d['form']['mapel_id'] = $this->input->get_post('mapel_id');
		$d['form']['grade'] = $this->input->get_post('grade');
*/
		//$this->_rowset_evaluasi($d['form']['evaluasi_id']);

		//if (!$d['author_ybs'] && !$d['admin'])
			//return alert_error("Anda tak diperbolehkan mengubah soal evaluasi.", 'kbm/evaluasi');

		if ($d['post_request'] && !$d['error']):
			if ($this->m_kbm_bank_soal->save()):
			
				if ($tambah):/*
					$d['row']['kurikulum_id'] 	= $kurikulum_id ;
					$d['row']['kategori_id'] 	= $kategori_id ;
					$d['row']['mapel_id'] 		= $mapel_id ;
					$d['row']['grade'] 			= $grade ;
					*/
					$redir = "kbm/bank_soal/form?kurikulum_id={$kurikulum_id}&kategori_id={$kategori_id}&".
							"mapel_id={$mapel_id}&grade={$grade}&komp_dasar_id={$komp_dasar_id}&redir={$d['form']['redir']}";
				
				elseif ($d['form']['redir']):
					$redir = $d['form']['redir'];
				
				else:
					$redir = "kbm/bank_soal/browse";
				
				endif;

				return redir($redir);

			endif;
		endif;


		$this->form->set();
		$this->_view();
	}

	public function delete() {
		$d = & $this->d;
		$this->_set('kbm/bank_soal/delete');
		$this->form->init('m_kbm_bank_soal', 'kbm/bank_soal');

		$d['author_ybs'] = ($d['user']['id'] == $d['row']['author_id']);
		
		if (!$d['form']['id'])
			return redir('kbm/bank_soal');

		if (!$d['author_ybs'] && !$d['admin'])
			return alert_error("Anda tak diperbolehkan mengubah bank soal.", 'kbm/bank_soal');

		if ($d['post_request'] && !$d['error'])
			if ($this->m_kbm_bank_soal->delete())
				return redir("kbm/bank_soal");

		$this->form->set();
		$this->_view();
	}
	
	public function list_data(){
		
		$response = $this->m_kbm_bank_soal->list_data();
		
		echo json_encode($response);      
    	exit;
		
	}
}
