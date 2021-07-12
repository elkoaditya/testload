<?php

class Evaluasi_soal extends MY_Controller {

	public function __construct() {
		parent::__construct(array(
				'controller' => array(
						'user' => array('admin', 'sdm'),
						'model' => array('m_kbm_evaluasi', 'm_kbm_evaluasi_soal'),
						'helper' => 'soal',
				),
				'kbm/evaluasi_soal/browse' => array(
						'library' => 'pagination',
						'helper' => 'form',
						'model'	=> 'm_kbm_evaluasi_pembagian_kd',
						'request' => array(
								'term' => 'clean',
								'evaluasi_id' => 'as_int',
								'posisi_kd' => 'as_int',
						),
				),
				'kbm/evaluasi_soal/form' => array(
						'library' => 'form',
						'helper' => 'form',
						'request' => array(
								'evaluasi_id' => 'as_int',
						),
						'data' => array(
								'row' => array(
										'id' => 0,
										'evaluasi_id'	=> NULL,
										'posisi_kd'		=> NULL,
										'pertanyaan'	=> NULL,
										'gambar'		=> NULL,
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
												'label' => 'nama evaluasi_soal',
												//'rules' => 'required|clean_html|max_length[100000]',
												'rules' => 'required|clean_html',
										),
										array(
												'field' => 'poin_max',
												'label' => 'grade evaluasi_soal',
												'rules' => 'required|in_range[1-100]|as_int',
										),
								),
						),
				),
				
				'kbm/evaluasi_soal/form_abc' => array(
						'library' => 'form',
						'helper' => 'form',
						'request' => array(
								'evaluasi_id' => 'as_int',
						),
						'data' => array(
								'row' => array(
										'id' => 0,
										'evaluasi_id'	=> NULL,
										'posisi_kd'		=> NULL,
										'pertanyaan'	=> NULL,
										'gambar'		=> NULL,
										'poin_min' => NULL,
										'poin_max' => 10,
										'pilihan' => array(
												'kunci' => array(),
												'pengecoh' => array(),
										),
										'kunci_abc' => 0,
								),
								'pilihan' => array(
										'pengecoh-a' => NULL,
										'pengecoh-b' => NULL,
										'pengecoh-c' => NULL,
										'pengecoh-d' => NULL,
										'pengecoh-e' => NULL,
								),
						),
						'validasi' => array(
								array(
										array(
												'field' => 'pertanyaan',
												'label' => 'nama evaluasi_soal',
												//'rules' => 'required|clean_html|max_length[100000]',
												'rules' => 'required|clean_html',
										),
										array(
												'field' => 'poin_max',
												'label' => 'grade evaluasi_soal',
												'rules' => 'required|in_range[1-100]|as_int',
										),
										array(
												'field' => 'kunci_abc',
												'label' => 'kunci evaluasi_soal',
												'rules' => 'required',
										),
								),
						),
				),
				'kbm/evaluasi_soal/form2' => array(
						'library' => 'form',
						'helper' => 'form',
						'request' => array(
								'evaluasi_id' => 'as_int',
						),
						'data' => array(
								'row' => array(
										'id' => 0,
										'evaluasi_id' => NULL,
										'posisi_kd'	=> NULL,
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
												'label' => 'nama evaluasi_soal',
												//'rules' => 'required|clean_html|max_length[32000]',
										),
										array(
												'field' => 'poin_max',
												'label' => 'grade evaluasi_soal',
											//	'rules' => 'required|in_range[1-100]|as_int',
										),
								),
						),
				),
				'kbm/evaluasi_soal/ganti_kunci' => array(
						'library' => 'form',
						'helper' => 'form',
						'request' => array(
								'evaluasi_id' => 'as_int',
						),
						'data' => array(
								'row' => array(
										'id' => 0,
										'evaluasi_id'	=> NULL,
										'nilai_bonus'	=> NULL,
										'ganti_kunci'	=> NULL,
								),
						),
				),
				'kbm/evaluasi_soal/delete' => array(
						'library' => 'form',
						'helper' => 'form',
						'request' => array(
								'evaluasi_id' => 'as_int',
						),
				),
				'kbm/evaluasi_soal/form3' => array(
						'user' => array('sdm','admin'),
						'model'		 => 'm_option',
						'library' => 'form',
						'helper' => 'form',
						'data' => array(
								'row' => array(
										'id' => 0,
										'evaluasi_id' => NULL,
										'posisi_kd'		=> NULL,
										'pertanyaan' => NULL,
										'poin_min' => NULL,
										'poin_max' => 10,
										'pilihan' => array(
												'kunci' => array(),
												'pengecoh' => array(),
										),
								),
						),
						'validasi' => array(
						array(
								array(
										'field' => 'jml_soal',
										'label' => 'jumlah soal',
										'rules'	=> 'trim|numeric',
								),
						),
					),
				),
				'kbm/evaluasi_soal/skor_soal' => array(
						'user' => array('sdm','admin'),
						'model'		 => 'm_option',
						'library' => 'form',
						'helper' => 'form',
						'data' => array(
								'row' => array(
										'id' => 0,
										'pertanyaan' => NULL,
										'poin_min' => NULL,
										'poin_max' => 10,
								),
						),
						'validasi' => array(
						array(
								array(
										'field' => 'poin_max',
										'label' => 'Bobot Skor Soal',
										'rules'	=> 'trim|numeric',
								),
						),
					),
				),
		));
		$this->d['admin'] = cfguc_admin('akses', 'kbm', 'evaluasi');
		$this->d['view'] = cfguc_view('akses', 'kbm', 'evaluasi');
	}

	public function _rowset_evaluasi($evaluasi_id) {

		if ($evaluasi_id <= 0)
			return alert_info('Pilih nama soal evaluasi yang hendak ditampilkan.', 'kbm/evaluasi');

		$d = & $this->d;
		$d['evaluasi'] = $this->_rowset('m_kbm_evaluasi', $evaluasi_id, 'kbm/evaluasi', FALSE);
		//$d['author_ybs'] = ($d['user']['id'] == $d['evaluasi']['author_id']);
		$d['author_ybs'] = ($d['user']['role'] == 'sdm');

		if (!$d['author_ybs'] && !$d['view'])
			return alert_error("Anda tak diperbolehkan mengakses soal evaluasi.", 'kbm/evaluasi');
	}

	public function index() {
		$this->browse();
	}

	public function browse($index = 0) {
		$d = & $this->d;
		$this->_set('kbm/evaluasi_soal/browse');
		$this->_rowset_evaluasi($d['request']['evaluasi_id']);
		$d['resultset'] = $this->m_kbm_evaluasi_soal->browse($index, 60);
		$this->_view();
	}

	public function id($id = 0) {
		$d = & $this->d;
		$this->_set('kbm/evaluasi_soal/id');
		$this->_rowset('m_kbm_evaluasi_soal', $id, 'kbm/evaluasi');
		$this->_rowset_evaluasi($d['row']['evaluasi_id']);
		$this->_view();
	}

	public function form() {
		$d = & $this->d;
		$tambah = (bool) $this->input->post('tambah');

		$this->_set('kbm/evaluasi_soal/form');
		$this->form->init('m_kbm_evaluasi_soal', 'kbm/evaluasi');

		$d['form']['redir'] = $this->input->get_post('redir');

		if ($d['row']['id'] > 0){
			$d['form']['evaluasi_id'] = $d['row']['evaluasi_id'];
			$d['form']['posisi_kd'] = $d['row']['posisi_kd'];
		}else if (!$d['post_request'] OR !isset($d['form']['evaluasi_id'])){
			$d['form']['evaluasi_id'] = $this->input->get_post('evaluasi_id');
			$d['form']['posisi_kd'] = $this->input->get_post('posisi_kd');
		}
		
		$this->_rowset_evaluasi($d['form']['evaluasi_id']);

		if (!$d['author_ybs'] && !$d['admin'])
			return alert_error("Anda tak diperbolehkan mengubah soal evaluasi.", 'kbm/evaluasi');

		if ($d['evaluasi']['closed'])
			return alert_error("Tak dapat mengubah pertanyaan karena telah ditutup.", "kbm/evaluasi/id/{$d['evaluasi']['id']}");

		if ($d['row'] == 0 && $d['evaluasi']['published'])
			return alert_error("Tak dapat menambah pertanyaan karena telah dipublikasikan.", "kbm/evaluasi/id/{$d['evaluasi']['id']}");

		if ($d['semaktif']['id'] == 0)
			return alert_error("Tidak dapat pertanyaan mengubah evaluasi pada masa jeda semester.", 'kbm/evaluasi');

		else if ($d['evaluasi']['id'] > 0 && $d['evaluasi']['semester_id'] != $d['semaktif']['id'])
			return alert_error("Evaluasi tersebut telah berlalu.", "kbm/evaluasi/id/{$d['row']['id']}");

		if ($d['post_request'] && !$d['error']):
			if ($this->m_kbm_evaluasi_soal->save()):

				if ($tambah):
					$redir = "kbm/evaluasi_soal/form?evaluasi_id={$d['form']['evaluasi_id']}&posisi_kd={$d['form']['posisi_kd']}&redir={$d['form']['redir']}";

				elseif ($d['form']['redir']):
					$redir = $d['form']['redir'];

				else:
					$redir = "kbm/evaluasi_soal/browse?evaluasi_id={$d['form']['evaluasi_id']}";

				endif;

				return redir($redir);

			endif;
		endif;


		$this->form->set();
		$this->_view();
	}

	public function form2() {
		$d = & $this->d;
		$tambah = (bool) $this->input->post('tambah');

		$this->_set('kbm/evaluasi_soal/form2');
		$this->form->init('m_kbm_evaluasi_soal', 'kbm/evaluasi');

		$d['form']['redir'] = $this->input->get_post('redir');

		if ($d['row']['id'] > 0)
			$d['form']['evaluasi_id'] = $d['row']['evaluasi_id'];

		else if (!$d['post_request'] OR !isset($d['form']['evaluasi_id']))
			$d['form']['evaluasi_id'] = $this->input->get_post('evaluasi_id');

		$this->_rowset_evaluasi($d['form']['evaluasi_id']);

		if (!$d['author_ybs'] && !$d['admin'])
			return alert_error("Anda tak diperbolehkan mengubah soal evaluasi.", 'kbm/evaluasi');

		if ($d['evaluasi']['closed'])
			return alert_error("Tak dapat mengubah pertanyaan karena telah ditutup.", "kbm/evaluasi/id/{$d['evaluasi']['id']}");

		if ($d['row'] == 0 && $d['evaluasi']['published'])
			return alert_error("Tak dapat menambah pertanyaan karena telah dipublikasikan.", "kbm/evaluasi/id/{$d['evaluasi']['id']}");

		if ($d['semaktif']['id'] == 0)
			return alert_error("Tidak dapat pertanyaan mengubah evaluasi pada masa jeda semester.", 'kbm/evaluasi');

		else if ($d['evaluasi']['id'] > 0 && $d['evaluasi']['semester_id'] != $d['semaktif']['id'])
			return alert_error("Evaluasi tersebut telah berlalu.", "kbm/evaluasi/id/{$d['row']['id']}");

		if ($d['post_request'] && !$d['error']):
			if ($this->m_kbm_evaluasi_soal->save2()):
				//if ($tambah):
				///	$redir = "kbm/evaluasi_soal/form?evaluasi_id={$d['form']['evaluasi_id']}&redir={$d['form']['redir']}";

				//elseif ($d['form']['redir']):
				//	$redir = $d['form']['redir'];

				//else:
					$redir = "kbm/evaluasi/id/{$d['form']['evaluasi_id']}";

				//endif;

				return redir($redir);
			endif;
				
		endif;

		$this->form->set();
		$this->_view();
	}
	public function form3()
	{
		$d = & $this->d;
 
		$this->_set('kbm/evaluasi_soal/form3');
		$d['form']['evaluasi_id'] 	= $this->input->get_post('evaluasi_id');
		// $this->form->init('m_kbm_evaluasi_soal', 'kbm/evaluasi');
		
		
		$this->_rowset_evaluasi($d['form']['evaluasi_id']);
		
		// $this->_dump();
		if ($d['user']['id'] != $d['evaluasi']['author_id'])
			return alert_error("Anda tak diperbolehkan mengubah soal evaluasi.", 'kbm/evaluasi');

		if ($d['evaluasi']['closed'])
			return alert_error("Tak dapat mengubah pertanyaan karena telah ditutup.", "kbm/evaluasi/id/{$d['evaluasi']['id']}");

		if ($d['row'] == 0 && $d['evaluasi']['published'])
			return alert_error("Tak dapat menambah pertanyaan karena telah dipublikasikan.", "kbm/evaluasi/id/{$d['evaluasi']['id']}");

		if ($d['semaktif']['id'] == 0)
			return alert_error("Tidak dapat pertanyaan mengubah evaluasi pada masa jeda semester.", 'kbm/evaluasi');

		else if ($d['evaluasi']['id'] > 0 && $d['evaluasi']['semester_id'] != $d['semaktif']['id'])
			return alert_error("Evaluasi tersebut telah berlalu.", "kbm/evaluasi/id/{$d['row']['id']}");

		// $d['resultset'] = $this->m_kbm_evaluasi_soal->browse($index, $limit);
		
		//alert_error("BBBB");
		// if($this->input->post('tambah') == 'bank_soal'){
			//alert_error("BBBB");
			if ($d['post_request'] && !$d['error'])
			{
				 
				// $d['aaaaaaaaaaaaaaa'] =  $this->input->post('jml_soal');
				if ($this->m_kbm_evaluasi_soal->save_penilaian_siswa1())
				{
					$redir = "/kbm/evaluasi/id/{$d['form']['evaluasi_id']}" ;

					return redir($redir);
				}
		// $this->_dump();
			}
		// }
		
		// $this->_dump();
		$this->_view();

	}
	public function form_abc() {
		$d = & $this->d;
		$tambah = (bool) $this->input->post('tambah');

		$this->_set('kbm/evaluasi_soal/form_abc');
		$this->form->init('m_kbm_evaluasi_soal', 'kbm/evaluasi');

		$d['form']['redir'] = $this->input->get_post('redir');

		if ($d['row']['id'] > 0){
			$d['form']['evaluasi_id'] = $d['row']['evaluasi_id'];
			$d['form']['posisi_kd'] = $d['row']['posisi_kd'];
		}else if (!$d['post_request'] OR !isset($d['form']['evaluasi_id'])){
			$d['form']['evaluasi_id'] = $this->input->get_post('evaluasi_id');
			$d['form']['posisi_kd'] = $this->input->get_post('posisi_kd');
		}
		
		$this->_rowset_evaluasi($d['form']['evaluasi_id']);

		if (!$d['author_ybs'] && !$d['admin'])
			return alert_error("Anda tak diperbolehkan mengubah soal evaluasi.", 'kbm/evaluasi');

		if ($d['evaluasi']['closed'])
			return alert_error("Tak dapat mengubah pertanyaan karena telah ditutup.", "kbm/evaluasi/id/{$d['evaluasi']['id']}");

		if ($d['row'] == 0 && $d['evaluasi']['published'])
			return alert_error("Tak dapat menambah pertanyaan karena telah dipublikasikan.", "kbm/evaluasi/id/{$d['evaluasi']['id']}");

		if ($d['semaktif']['id'] == 0)
			return alert_error("Tidak dapat pertanyaan mengubah evaluasi pada masa jeda semester.", 'kbm/evaluasi');

		else if ($d['evaluasi']['id'] > 0 && $d['evaluasi']['semester_id'] != $d['semaktif']['id'])
			return alert_error("Evaluasi tersebut telah berlalu.", "kbm/evaluasi/id/{$d['row']['id']}");

		if ($d['post_request'] && !$d['error']):
			if ($this->m_kbm_evaluasi_soal->save_abc()):

				if ($tambah):
					$redir = "kbm/evaluasi_soal/form_abc?evaluasi_id={$d['form']['evaluasi_id']}&posisi_kd={$d['form']['posisi_kd']}&redir={$d['form']['redir']}";

				elseif ($d['form']['redir']):
					$redir = $d['form']['redir'];

				else:
					$redir = "kbm/evaluasi_soal/browse?evaluasi_id={$d['form']['evaluasi_id']}";

				endif;

				return redir($redir);

			endif;
		endif;


		$this->form->set();
		$this->_view();
	}
	public function skor_soal()
	{
		$d = & $this->d;
		$this->_set('kbm/evaluasi_soal/skor_soal');
		$d['form']['evaluasi_id'] 	= $this->input->get_post('evaluasi_id'); 
		 
		$this->_rowset_evaluasi($d['form']['evaluasi_id']);
		// $this->_dump();
		
		if ($d['user']['id'] != $d['evaluasi']['author_id'])
			return alert_error("Anda tak diperbolehkan mengubah soal evaluasi.", 'kbm/evaluasi');

		if ($d['evaluasi']['closed'])
			return alert_error("Tak dapat mengubah pertanyaan karena telah ditutup.", "kbm/evaluasi/id/{$d['evaluasi']['id']}");

		if ($d['row'] == 0 && $d['evaluasi']['published'])
			return alert_error("Tak dapat menambah pertanyaan karena telah dipublikasikan.", "kbm/evaluasi/id/{$d['evaluasi']['id']}");

		if ($d['semaktif']['id'] == 0)
			return alert_error("Tidak dapat pertanyaan mengubah evaluasi pada masa jeda semester.", 'kbm/evaluasi');

		else if ($d['evaluasi']['id'] > 0 && $d['evaluasi']['semester_id'] != $d['semaktif']['id'])
			return alert_error("Evaluasi tersebut telah berlalu.", "kbm/evaluasi/id/{$d['row']['id']}");

			if ($d['post_request'] && !$d['error'])
			{
				 
				// $d['aaaaaaaaaaaaaaa'] =  $this->input->post('jml_soal');
				if ($this->m_kbm_evaluasi_soal->save3_edit_skor1())
				{
					$redir = "/kbm/evaluasi/id/{$d['form']['evaluasi_id']}" ;

					return redir($redir);
				}
			}
		$this->_view();

	}
	
	public function ganti_kunci() {
		$d = & $this->d;
		$this->_set('kbm/evaluasi_soal/ganti_kunci');
		$this->form->init('m_kbm_evaluasi_soal', 'kbm/evaluasi');
		
		$d['form']['evaluasi_id'] = $d['row']['evaluasi_id'];
		
		if (!$d['form']['id'])
			return redir('kbm/evaluasi');

		$this->_rowset_evaluasi($d['row']['evaluasi_id']);

		if (!$d['author_ybs'] && !$d['admin'])
			return alert_error("Anda tak diperbolehkan ganti kunci soal evaluasi.", 'kbm/evaluasi');

		if ($d['semaktif']['id'] == 0)
			return alert_error("Tidak dapat ganti kunci pertanyaan evaluasi pada masa jeda semester.", 'kbm/evaluasi');

		else if ($d['evaluasi']['id'] > 0 && $d['evaluasi']['semester_id'] != $d['semaktif']['id'])
			return alert_error("Evaluasi tersebut telah berlalu.", "kbm/evaluasi/id/{$d['row']['id']}");

		if ($d['post_request'] && !$d['error']){
			//$this->m_kbm_evaluasi_soal->ganti_kunci();
			if ($this->m_kbm_evaluasi_soal->ganti_kunci())
				return redir("kbm/evaluasi_soal/browse?evaluasi_id={$d['evaluasi']['id']}");
		}

		$this->form->set();
		$this->_view();
	}
	
	public function delete() {
		$d = & $this->d;
		$this->_set('kbm/evaluasi_soal/delete');
		$this->form->init('m_kbm_evaluasi_soal', 'kbm/evaluasi');

		if (!$d['form']['id'])
			return redir('kbm/evaluasi');

		$this->_rowset_evaluasi($d['row']['evaluasi_id']);

		if (!$d['author_ybs'] && !$d['admin'])
			return alert_error("Anda tak diperbolehkan mengubah soal evaluasi.", 'kbm/evaluasi');

		if ($d['evaluasi']['published'])
			return alert_error("Tak dapat menghapus pertanyaan karena telah dipublikasikan.", "kbm/evaluasi/id/{$d['evaluasi']['id']}");

		if ($d['semaktif']['id'] == 0)
			return alert_error("Tidak dapat pertanyaan mengubah evaluasi pada masa jeda semester.", 'kbm/evaluasi');

		else if ($d['evaluasi']['id'] > 0 && $d['evaluasi']['semester_id'] != $d['semaktif']['id'])
			return alert_error("Evaluasi tersebut telah berlalu.", "kbm/evaluasi/id/{$d['row']['id']}");

		if ($d['post_request'] && !$d['error'])
			if ($this->m_kbm_evaluasi_soal->delete())
				return redir("kbm/evaluasi/id/{$d['evaluasi']['id']}");

		$this->form->set();
		$this->_view();
	}

}
