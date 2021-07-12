<?php

class Siswa extends MY_Controller
{

	// utama

	public function __construct()
	{
		parent::__construct(array(
			'controller'							 => array(
				//'user'	 => array('admin', 'sdm'),
				//'user' => '#login',
				'model'	 => 'm_nilai_siswa',
			),
			'nilai/siswa/browse'					 => array(
				'user'		 => array('admin', 'sdm'),
				'model'		 => 'm_option',
				'helper'	 => 'form',
				'request'	 => array(
					'term'			 => 'clean',
					'kelas_id'		 => 'as_int',
					'siswa_id'		 => 'as_int',
					'semester_id'	 => 'as_int',
				),
			),
			'nilai/siswa/id'						 => array(
				'user'		 => array('admin', 'sdm'),
				'model' => array('m_nilai_siswa_pelajaran'),
			),
			'nilai/siswa/expor'						 => array(
				'model' => array('m_nilai_siswa_pelajaran'),
			),
			'nilai/siswa/mutasi'					 => array(
				'user'		 => array('admin', 'sdm'),
				'model' => array('m_nilai_kelas'),
			),
			'nilai/siswa/skhun'					 => array(
				//'user'		 => array('admin', 'sdm'),
				'model' => array('m_nilai_siswa_pelajaran','m_nilai_kelas'),
			),
			'nilai/siswa/rapor_mid'					 => array(
				'user'		 => array('admin', 'sdm','siswa'),
				'model' => array('m_nilai_siswa_pelajaran','m_nilai_kelas'),
			),
			'nilai/siswa/kelulusan'						 => array(
				'user'		 => array('admin', 'sdm'),
				'model' => array('m_nilai_siswa_pelajaran','m_nilai_kelas'),
			),
			'nilai/siswa/rapor'						 => array(
				'user'		 => array('admin', 'sdm','siswa'),
				'library'	 => 'konversi_nilai',
				'model'		 => array('m_nilai_siswa_pelajaran','m_nilai_kelas'),
			//	'helper' 	 => array('set_pdf/cetak_pdf2'),
			),
			'nilai/siswa/buku_induk'				 => array(
				'user'		 => array('admin', 'sdm'),
				'model' => array('m_nilai_siswa_pelajaran'),
			),
			'nilai/siswa/impor_absen_kepribadian'	 => array(
				'user'		 => array('admin', 'sdm'),
				'library'	 => 'form',
				'helper'	 => 'form',
				'request'	 => array(
					'term'			 => 'clean',
					'kelas_id'		 => 'as_int',
					'siswa_id'		 => 'as_int',
					'semester_id'	 => 'as_int',
				),
			),
			'nilai/siswa/impor_absen_kenaikan'	 => array(
				'user'		 => array('admin', 'sdm'),
				'library'	 => 'form',
				'helper'	 => 'form',
				'request'	 => array(
					'term'			 => 'clean',
					'kelas_id'		 => 'as_int',
					'siswa_id'		 => 'as_int',
					'semester_id'	 => 'as_int',
				),
			),
			'nilai/siswa/impor_kepribadian'	 => array(
				'user'		 => array('admin', 'sdm'),
				'library'	 => 'form',
				'helper'	 => 'form',
				'request'	 => array(
					'term'			 => 'clean',
					'kelas_id'		 => 'as_int',
					'siswa_id'		 => 'as_int',
					'semester_id'	 => 'as_int',
				),
			),
			'nilai/siswa/impor_kerja_lapangan'	 => array(
				'user'		 => array('admin', 'sdm'),
				'library'	 => 'form',
				'helper'	 => 'form',
				'request'	 => array(
					'term'			 => 'clean',
					'kelas_id'		 => 'as_int',
					'siswa_id'		 => 'as_int',
					'semester_id'	 => 'as_int',
				),
			),
			'nilai/siswa/impor_keterangan_walikelas' => array(
				'user'		 => array('admin', 'sdm'),
				'library'	 => 'form',
				'helper'	 => 'form',
			),
			'nilai/siswa/pengumuman_rapor' => array(
				'model' => array('m_nilai_siswa','m_app_config'),
			),
			'nilai/siswa/pengumuman_kelulusan' => array(
				'model' => array('m_nilai_siswa','m_app_config'),
			),
			
			'nilai/siswa/rapor_tik'					 => array(
				'user'		 => array('admin', 'sdm','siswa'),
				'model' => array('m_nilai_siswa_pelajaran','m_nilai_kelas'),
			),
		));

		$d = & $this->d;
		$d['admin'] = cfguc_admin('akses', 'nilai', 'siswa');
		$d['view'] = cfguc_view('akses', 'nilai', 'siswa');
		$d['walikelas'] = (array) cfgu('walikelas');
		$d['user_siswa'] = user_role('siswa');

		$this->rapor_separate = array('sman9smg','sma_terbang','demo','smkpltarcisius');
		
		$this->rapor_separate_2017 = array('sman14smg','sman8smg','smaissa1smg',
		'sma_setiabudhi','sma_terbang',
		'smk_penerbangan','smk_nusaputera','sma_michael','smp_terbang');
		
		if (!$d['view'] && !$d['walikelas'] && !$d['user_siswa'])
			return alert_info('Anda tidak terkait dengan siswa apapun.', '');

	}

	public function index()
	{
		$this->browse();

	}

	// akses data umum

	public function browse($index = 0)
	{
		$this->_set('nilai/siswa/browse');

		$d = & $this->d;

		if (!$d['request']['semester_id'] && $d['semaktif']['id'] > 0)
		{
			$d['request']['semester_id'] = $d['semaktif']['id'];
		}

		$d['resultset'] = $this->m_nilai_siswa->browse($index, 50);

		$this->_view();

	}

	public function id($id = 0, $index = 0)
	{
		$this->_set('nilai/siswa/id');
		$this->_rowset('m_nilai_siswa', $id, 'nilai/siswa');

		$d = & $this->d;
		$d['pelajar'] = ($d['user']['id'] == $d['row']['siswa_id']);
		$d['walikelasybs'] = ($d['row']['kelas_wali_id'] == $d['user']['id']);
		$d['gurubkybs'] = ($d['row']['kelas_gurubk_id'] == $d['user']['id']);

		if (!$d['admin'] && !$d['pelajar'] && !$d['walikelasybs'])
			return alert_error('Anda tidak dapat mengakses nilai siswa.', '');

		$d['resultset'] = $this->m_nilai_siswa_pelajaran->siswa($id, $index, 100);
		$d['ekskul_result'] = $this->m_nilai_siswa->subrow_ekskul($id);
		$d['org_result'] = $this->m_nilai_siswa->subrow_org($id);

		$this->_view();

	}

	public function expor($id = 0)
	{
		$this->_set('nilai/siswa/expor');
		$this->_rowset('m_nilai_siswa', $id, 'nilai/siswa');

		$d = & $this->d;
		$d['pelajar'] = ($this->d['user']['id'] == $this->d['row']['siswa_id']);
		$d['walikelasybs'] = in_array($d['row']['kelas_id'], $d['walikelas']);

		if (!$d['admin'] && !$d['pelajar'] && !$d['walikelasybs'])
			return alert_error('Anda tidak dapat mengakses nilai siswa.', '');

		$d['resultset'] = $this->m_nilai_siswa_pelajaran->siswa($id, 0, 100);

		if ($d['resultset']['selected_rows'] == 0)
			return alert_info('Daftar nilai siswa tidak ditemukan. Periksa pelajaran siswa dan filter pencarian.', "nilai/siswa/id/{$d['row']['id']}");

		$this->load->library('PHPExcel');
		$this->m_nilai_siswa->expor();

	}
	
	public function kelulusan($id = 0,$index = 0, $mode_range = 100, $more = '')
	{
		
		$mode = (strpos($id, '.pdf') === FALSE) ? 'I' : 'D';
		$id = str_replace(".pdf", "", $id);

		$this->_set('nilai/siswa/kelulusan');
		$this->_rowset('m_nilai_siswa', $id, 'nilai/siswa');

		$d = & $this->d;
		$d['pelajar'] = ($d['user']['id'] == $d['row']['siswa_id']);
		$d['walikelasybs'] = ($d['row']['kelas_wali_id'] == $d['user']['id']);
		$d['gurubkybs'] = ($d['row']['kelas_gurubk_id'] == $d['user']['id']);

		if (!$d['admin'] && !$d['pelajar'] && !$d['walikelasybs'])
			return alert_error('Anda tidak dapat mengakses nilai siswa.', '');

		$nama_file = url_title("rapor_{$d['row']['kelas_nama']}_{$d['row']['siswa_nis']}_{$d['row']['ta_nama']}-{$d['row']['semester_nama']}");

		if ($more === 'html')
		{
			return $this->_view(APP_SCOPE );
		}


		$this->_pdf("rapor_kelulusan-nis-{$d['row']['siswa_nis']}-{$d['row']['ta_nama']}-{$d['row']['semester_nama']}", APP_SCOPE );
		// generator pdf sendiri
/*
		$body = $this->_view("body", TRUE);
		$footer = $this->_view("footer", TRUE);

		$this->load->library('mpdf');
		$this->mpdf->WriteHTML($body);
		$this->mpdf->SetHTMLFooter($footer);
		$this->mpdf->Output("rapor-nis-{$d['row']['siswa_nis']}-{$d['row']['ta_nama']}-{$d['row']['semester_nama']}.pdf", $mode);
*/
	}
	
	public function kelulusan_generator($id = 0,$index = 0, $mode_range = 100, $more = '')
	{
		
		$mode = (strpos($id, '.pdf') === FALSE) ? 'I' : 'D';
		$id = str_replace(".pdf", "", $id);
		
		$this->_set('nilai/siswa/kelulusan');
		
		$this->load->library('mpdf');
		$d['id_nilai_siswa'] = $this->m_nilai_kelas->rowsub_siswa($id, 0, 50);
		
		$jml=0;
		foreach($d['id_nilai_siswa']['data'] as $nilai_siswa )
		{
			//if($jml<=1)
			//{
				//$jml++;
			
			$this->_rowset('m_nilai_siswa', $nilai_siswa['id'], 'nilai/siswa');

			$d = & $this->d;
			$d['pelajar'] = ($d['user']['id'] == $d['row']['siswa_id']);
			$d['walikelasybs'] = ($d['row']['kelas_wali_id'] == $d['user']['id']);
			$d['gurubkybs'] = ($d['row']['kelas_gurubk_id'] == $d['user']['id']);

			if (!$d['admin'] && !$d['pelajar'] && !$d['walikelasybs'])
				return alert_error('Anda tidak dapat mengakses nilai siswa.', '');

			$body = $this->_view(APP_SCOPE, TRUE);
			
			  $mpdf = new mPDF();
			$mpdf->setAutoTopMargin = TRUE;
			$mpdf->setAutoBottomMargin = TRUE;
			$mpdf->WriteHTML($body);
			$mpdf->Output(APP_ROOT."content/generate_kelulusan/".APP_SCOPE
			."/".$d['row']['siswa_nis'].".pdf", 'F');
			unset($mpdf);
			unset($body);
			// }
		}
		redirect(base_url().'nilai/kelas/id/'.$id, 'refresh');
	}
	
	
	public function rapor($id = 0, $mode_range = 100, $tipe_rapor = 'original')
	{
		$mode = (strpos($id, '.pdf') === FALSE) ? 'I' : 'D';
		$id = str_replace(".pdf", "", $id);

		$this->_set('nilai/siswa/rapor');
		$this->_rowset('m_nilai_siswa', $id, 'nilai/siswa');

		$d = & $this->d;
		
		
		$set_kurikulum_nama =  strtolower($d['row']['kurikulum_nama']);
		$set_pdf_helper =  "set_pdf/uas_";
		
		//$dua_kurikulum = array('sman8smg','sman9smg','sma_michael','sma_setiabudhi','smk_nusaputera','smk_penerbangan','smakristen1_wsb');
		//$dua_kurikulum = array('sman9smg','sma_terbang');
		$dua_kurikulum = $this->rapor_separate;
		
		$jml_chek=0;
		//// KTSP
		foreach($dua_kurikulum as $dk){
			if((strtolower(APP_SCOPE)==$dk)&&($set_kurikulum_nama=='ktsp'))
			{	
				$jml_chek++;			
				$this->load->helper($set_pdf_helper.$set_kurikulum_nama.'_view_'.strtolower(APP_SCOPE));
				$this->load->helper($set_pdf_helper.$set_kurikulum_nama.'_load_'.strtolower(APP_SCOPE));
			}
		}
		/// 2017
		foreach($this->rapor_separate_2017 as $dk){
			if((strtolower(APP_SCOPE)==$dk)&&($set_kurikulum_nama=='2017'))
			{	
				$jml_chek++;			
				$this->load->helper($set_pdf_helper.$set_kurikulum_nama.'_view_'.strtolower(APP_SCOPE));
				$this->load->helper($set_pdf_helper.$set_kurikulum_nama.'_load_'.strtolower(APP_SCOPE));
				//echo $set_pdf_helper.$set_kurikulum_nama.'_view_'.strtolower(APP_SCOPE);
			}
		}
		
		if($jml_chek==0){
			$this->load->helper($set_pdf_helper.$set_kurikulum_nama.'_view');
        	$this->load->helper($set_pdf_helper.$set_kurikulum_nama.'_load');
		}
		
		$d['pelajar'] = ($this->d['user']['id'] == $this->d['row']['siswa_id']);
		$d['walikelasybs'] = in_array($d['row']['kelas_id'], $d['walikelas']);

		if (!$d['admin'] && !$d['pelajar'] && !$d['walikelasybs'])
		{
			return alert_error('Anda tidak dapat mengakses nilai siswa.', '');
		}

		/*$d['resultset'] = $this->m_nilai_siswa_pelajaran->siswarapor($id);
		$d['ekskul_result'] = $this->m_nilai_siswa->subrow_ekskul($id);
		$d['prestasi_result'] = $this->m_nilai_siswa->subrow_prestasi($id);
		$d['org_result'] = $this->m_nilai_siswa->subrow_org($id);*/
		$d['id_nilai_siswa']['data'][0]		= $this->m_nilai_siswa->rowset($id);
		$d['resultset_array'][$id]		 	= $this->m_nilai_siswa_pelajaran->siswarapor($id,$set_kurikulum_nama);
		$d['ekskul_result_array'][$id] 		= $this->m_nilai_siswa->subrow_ekskul($id);
		$d['prestasi_result_array'][$id] 	= $this->m_nilai_siswa->subrow_prestasi($id);
		$d['org_result_array'][$id] 		= $this->m_nilai_siswa->subrow_org($id);
		$d['aspek_result_array'][$id] 		= $this->m_nilai_siswa->aspek_penilaian($id);
		
		$d['deskripsi_nilai'] = $this->m_nilai_siswa->deskripsi_nilai($d['row']['semester_id']);
		$d['deskripsi_pelajaran'] = $this->m_nilai_siswa->deskripsi_pelajaran($d['row']['semester_id']);
		$d['konversi_nilai'] = $this->m_nilai_siswa->konversi_nilai();
		$d['mode_range'] = $mode_range;
		$kolom_rerata='';
		
		//if(APP_SCOPE=='sman8smg')
		//{	$kolom_rerata = 'uts';	}
		if(APP_SCOPE=='smk_penerbangan')
		{	$kolom_rerata = 'nas_teori';	}
		if($kolom_rerata!='')
		{
			$d['rerata']	= $this->m_nilai_siswa_pelajaran->rerata_pelajaran_perkelas($kolom_rerata, $d['row']['kelas_id'], $d['row']['semester_id']);
			//$d['rerata']	= $this->m_nilai_siswa_pelajaran->rerata_pelajaran_perkelas('uts', $d['row']['kelas_id']);
		}
		
		//$d['rerata']	= $this->m_nilai_siswa_pelajaran->rerata_pelajaran_perkelas($kolom_rerata, $d['row']['kelas_id']);
		$d['jumlah_rapor'] = 1;
		
		//return alert_info($d['row']['semester_id'], "nilai/siswa/id/{$d['row']['id']}");
		if ($d['resultset_array'][$id]['selected_rows'] == 0)
		{
			return alert_info('Daftar nilai siswa tidak ditemukan. Periksa pelajaran siswa dan filter pencarian.', "nilai/siswa/id/{$d['row']['id']}");
		}
		
		$semester_nama = strtolower($d['row']['semester_nama']);
		$nama_file = url_title("rapor_{$d['row']['kelas_nama']}_{$d['row']['siswa_nis']}_{$d['row']['ta_nama']}-{$semester_nama}");

		$abre_ta_nama = str_replace("/","-",$d['row']['ta_nama']);
		$abre_filename = APP_SCOPE."_".$abre_ta_nama."__".$set_kurikulum_nama."_".$semester_nama;
		// if ($more === 'html')
		// {
			// return $this->_view( $abre_filename );
		// }
		// return $this->_dump();
		//$d['vddd'] = $abre_filename;
		//$d['aaaaaaaaaaaa'] = $nama_file. APP_SCOPE;
		if($tipe_rapor == "kkm"){
			return $this->_pdf($nama_file, $abre_filename."_kkm" );
		}elseif($tipe_rapor == "ttd"){
			return $this->_pdf($nama_file, $abre_filename."_ttd" );
		}else{
			return $this->_pdf($nama_file, $abre_filename );
		}

		
	//	$this->_pdf("rapor_mid-nis-{$d['row']['siswa_nis']}-{$d['row']['ta_nama']}-{$d['row']['semester_nama']}", $abre_filename);


		// generator pdf sendiri

		$body = $this->_view("body", TRUE);
		$footer = $this->_view("footer", TRUE);

		$this->load->library('mpdf');
		$this->mpdf->WriteHTML($body);
		$this->mpdf->SetHTMLFooter($footer);
		$this->mpdf->Output("rapor-nis-{$d['row']['siswa_nis']}-{$d['row']['ta_nama']}-{$d['row']['semester_nama']}.pdf", $mode);

	}
	
	public function rapor_kelas($id = 0, $mode_range = 100, $more = '')
	{
		
		$mode = (strpos($id, '.pdf') === FALSE) ? 'I' : 'D';
		$id = str_replace(".pdf", "", $id);

		$this->_set('nilai/siswa/rapor');
		
		$d = & $this->d;
		
		$d['id_nilai_siswa'] = $this->m_nilai_kelas->rowsub_siswa($id, 0, 50);
		
		$jml_chek=0;
		//$dua_kurikulum = array('sman9smg','sma_terbang');
		$dua_kurikulum = $this->rapor_separate;	
		
		$jumlah_rapor=0;
		foreach($d['id_nilai_siswa']['data'] as $nilai_siswa )
		{
			$jumlah_rapor++;
			
			$this->_rowset('m_nilai_siswa', $nilai_siswa['id'], 'nilai/siswa');
			
			
			if($jml_chek<=0)
			{
				$set_kurikulum_nama =  strtolower($d['row']['kurikulum_nama']);
				$set_pdf_helper =  "set_pdf/uas_";
				
				//KTSP
				foreach($dua_kurikulum as $dk)
				{	
					if((strtolower(APP_SCOPE)==$dk)&&($set_kurikulum_nama=='ktsp'))
					{	
						$jml_chek++;	
						$this->load->helper($set_pdf_helper.$set_kurikulum_nama.'_view_'.strtolower(APP_SCOPE));
						$this->load->helper($set_pdf_helper.$set_kurikulum_nama.'_load_'.strtolower(APP_SCOPE));
					}
				}
				
				/// 2017
				foreach($this->rapor_separate_2017 as $dk){
					if((strtolower(APP_SCOPE)==$dk)&&($set_kurikulum_nama=='2017'))
					{	
						$jml_chek++;			
						$this->load->helper($set_pdf_helper.$set_kurikulum_nama.'_view_'.strtolower(APP_SCOPE));
						$this->load->helper($set_pdf_helper.$set_kurikulum_nama.'_load_'.strtolower(APP_SCOPE));
						//echo $set_pdf_helper.$set_kurikulum_nama.'_view_'.strtolower(APP_SCOPE);
					}
				}
			}
			
			$d['pelajar'] = ($this->d['user']['id'] == $this->d['row']['siswa_id']);
			$d['walikelasybs'] = in_array($d['row']['kelas_id'], $d['walikelas']);
	
			if (!$d['admin'] && !$d['pelajar'] && !$d['walikelasybs'])
			{
				return alert_error('Anda tidak dapat mengakses nilai siswa.', '');
			}
			$d['resultset_array'][$nilai_siswa['id']]		 	= $this->m_nilai_siswa_pelajaran->siswarapor($nilai_siswa['id'],$set_kurikulum_nama);
			$d['ekskul_result_array'][$nilai_siswa['id']] 		= $this->m_nilai_siswa->subrow_ekskul($nilai_siswa['id']);
			$d['prestasi_result_array'][$nilai_siswa['id']] 	= $this->m_nilai_siswa->subrow_prestasi($nilai_siswa['id']);
			$d['org_result_array'][$nilai_siswa['id']] 			= $this->m_nilai_siswa->subrow_org($nilai_siswa['id']);
			$d['aspek_result_array'][$nilai_siswa['id']] 						= $this->m_nilai_siswa->aspek_penilaian($nilai_siswa['id']);
			$d['deskripsi_nilai'] = $this->m_nilai_siswa->deskripsi_nilai($d['row']['semester_id']);
			$d['deskripsi_pelajaran'] = $this->m_nilai_siswa->deskripsi_pelajaran($d['row']['semester_id']);
			$d['konversi_nilai'] = $this->m_nilai_siswa->konversi_nilai();
			$d['mode_range'] = $mode_range;
			
			//return alert_info($d['row']['semester_id'], "nilai/siswa/id/{$d['row']['id']}");
			if ($d['resultset_array'][$nilai_siswa['id']]['selected_rows'] == 0)
			{
				return alert_info('Daftar nilai siswa tidak ditemukan. Periksa pelajaran siswa dan filter pencarian.', "nilai/siswa/id/{$d['row']['id']}");
			}
	
			$nama_file = url_title("rapor_{$d['row']['kelas_nama']}_{$d['row']['ta_nama']}-{$d['row']['semester_nama']}");
	
			if ($more === 'html')
			{
				return $this->_view(APP_SCOPE );
			}
		}
		
		$kolom_rerata='';
		if(APP_SCOPE=='smk_penerbangan')
		{	$kolom_rerata = 'nas_teori';	}
		if($kolom_rerata!='')
		{
			$d['rerata']	= $this->m_nilai_siswa_pelajaran->rerata_pelajaran_perkelas($kolom_rerata, $d['row']['kelas_id']);
			//$d['rerata']	= $this->m_nilai_siswa_pelajaran->rerata_pelajaran_perkelas('uts', $d['row']['kelas_id']);
		}
		
		$d['jumlah_rapor'] = $jumlah_rapor;
		
		//return $this->_dump();
		$set_kurikulum_nama =  strtolower($d['row']['kurikulum_nama']);
		$set_pdf_helper =  "set_pdf/uas_";
        
		if($jml_chek==0){
			$this->load->helper($set_pdf_helper.$set_kurikulum_nama.'_view');
        	$this->load->helper($set_pdf_helper.$set_kurikulum_nama.'_load');
		}
		
		//return $this->_dump();
		$abre_ta_nama = str_replace("/","-",$d['row']['ta_nama']);
		$abre_filename = APP_SCOPE."_".$abre_ta_nama."__".strtolower($d['row']['kurikulum_nama'])."_".strtolower($d['row']['semester_nama']);
		return $this->_pdf($nama_file, $abre_filename );
		
		//return $this->_pdf($nama_file, APP_SCOPE );
		// generator pdf sendiri

		$body = $this->_view("body", TRUE);
		$footer = $this->_view("footer", TRUE);

		$this->load->library('mpdf');
		$this->mpdf->WriteHTML($body);
		$this->mpdf->SetHTMLFooter($footer);
		$this->mpdf->Output("rapor-nis-{$d['row']['siswa_nis']}-{$d['row']['ta_nama']}-{$d['row']['semester_nama']}.pdf", $mode);

	}

	public function skhun($id = 0, $mode_range = 100, $type = '', $dump = '')
	{
		$this->_set('nilai/siswa/skhun');
		
		$this->_rowset('m_nilai_siswa', $id, 'nilai/siswa');

		$d = & $this->d;
		$d['pelajar'] = ($this->d['user']['id'] == $this->d['row']['siswa_id']);
		$d['walikelasybs'] = in_array($d['row']['kelas_id'], $d['walikelas']);

		$set_kurikulum_nama =  strtolower($d['row']['kurikulum_nama']);
		
		if (!$d['admin'] && !$d['pelajar'] && !$d['walikelasybs'])
			return alert_error('Anda tidak dapat mengakses nilai siswa.', '');

		
		$d['id_nilai_siswa']['data'][0]		= $this->m_nilai_siswa->rowset($id);
		$d['resultset_array'][$id]		 	= $this->m_nilai_siswa_pelajaran->siswarapor($id,$set_kurikulum_nama);
	
		$d['jumlah_rapor'] = 1;
		
		if ($d['resultset_array'][$id]['selected_rows'] == 0)
			return alert_info('Daftar nilai siswa tidak ditemukan. Periksa pelajaran siswa dan filter pencarian.', "nilai/siswa/id/{$d['row']['id']}");

		if ($dump === 'dump')
		{
			return $this->_dump();
		}
		
		$file = APP_SCOPE.$type;
		$this->_pdf("skhun-nis-{$d['row']['siswa_nis']}-{$d['row']['ta_nama']}-{$d['row']['semester_nama']}", $file);
		
	}
	
	public function skhun_kelas($id = 0, $mode_range = 100, $type = '', $more = '')
	{
		
		$mode = (strpos($id, '.pdf') === FALSE) ? 'I' : 'D';
		$id = str_replace(".pdf", "", $id);

		$this->_set('nilai/siswa/skhun');
		
		$d = & $this->d;
		
		//return $this->_dump();
		$d['id_nilai_siswa'] = $this->m_nilai_kelas->rowsub_siswa($id, 0, 50);
		
		
		$jumlah_rapor=0;
		foreach($d['id_nilai_siswa']['data'] as $nilai_siswa )
		{
			$jumlah_rapor++;
			
			$this->_rowset('m_nilai_siswa', $nilai_siswa['id'], 'nilai/siswa');
			
			$d['pelajar'] = ($this->d['user']['id'] == $this->d['row']['siswa_id']);
			$d['walikelasybs'] = in_array($d['row']['kelas_id'], $d['walikelas']);
	
			if (!$d['admin'] && !$d['pelajar'] && !$d['walikelasybs'])
			{
				return alert_error('Anda tidak dapat mengakses nilai siswa.', '');
			}
			$set_kurikulum_nama =  strtolower($d['row']['kurikulum_nama']);
			$d['resultset_array'][$nilai_siswa['id']]		 	= $this->m_nilai_siswa_pelajaran->siswarapor($nilai_siswa['id'],$set_kurikulum_nama);
			
			if ($d['resultset_array'][$nilai_siswa['id']]['selected_rows'] == 0)
			{
				return alert_info('Daftar nilai siswa tidak ditemukan. Periksa pelajaran siswa dan filter pencarian.', "nilai/siswa/id/{$d['row']['id']}");
			}
	
			$nama_file = url_title("skhun_{$d['row']['kelas_nama']}_{$d['row']['ta_nama']}-{$d['row']['semester_nama']}");
	
			if ($more === 'html')
			{
				return $this->_view(APP_SCOPE );
			}
		}
		
		$d['jumlah_rapor'] = $jumlah_rapor;
		
		$file = APP_SCOPE.$type;
		$this->_pdf($nama_file, $file);
		
	}
	
	public function rapor_mid($id = 0, $mode_range = 100, $dump = '')
	{
		
		///if(APP_SCOPE=='sma_terbang'){
		//	$this->_set('nilai/siswa/rapor_mid/smaterbang/sd');
		//}else{
		$this->_set('nilai/siswa/rapor_mid');
		//}
		$this->_rowset('m_nilai_siswa', $id, 'nilai/siswa');

		$d = & $this->d;
		$d['pelajar'] = ($this->d['user']['id'] == $this->d['row']['siswa_id']);
		$d['walikelasybs'] = in_array($d['row']['kelas_id'], $d['walikelas']);

		$set_kurikulum_nama =  strtolower($d['row']['kurikulum_nama']);
		
		if (!$d['admin'] && !$d['pelajar'] && !$d['walikelasybs'])
			return alert_error('Anda tidak dapat mengakses nilai siswa.', '');

		/*$d['resultset'] = $this->m_nilai_siswa_pelajaran->siswarapor($id);
		$d['ekskul_result'] = $this->m_nilai_siswa->subrow_ekskul($id);
		$d['org_result'] = $this->m_nilai_siswa->subrow_org($id);
		$d['konversi_nilai'] = $this->m_nilai_siswa->konversi_nilai();
		*/
		$d['id_nilai_siswa']['data'][0]		= $this->m_nilai_siswa->rowset($id);
		$d['resultset_array'][$id]		 	= $this->m_nilai_siswa_pelajaran->siswarapor($id,$set_kurikulum_nama);
		$d['ekskul_result_array'][$id] 		= $this->m_nilai_siswa->subrow_ekskul($id);
		
		$kolom_rerata='';
		if(APP_SCOPE=='sman8smg')
		{	$kolom_rerata = 'uts';	}
		elseif(APP_SCOPE=='smk_penerbangan')
		{	$kolom_rerata = 'mid_teori';	}
		if($kolom_rerata!='')
		{
			$d['rerata']	= $this->m_nilai_siswa_pelajaran->rerata_pelajaran_perkelas($kolom_rerata, $d['row']['kelas_id'],$d['row']['semester_id']);
			//$d['rerata']	= $this->m_nilai_siswa_pelajaran->rerata_pelajaran_perkelas('uts', $d['row']['kelas_id']);
		}
		
		$d['konversi_nilai'] = $this->m_nilai_siswa->konversi_nilai();
		$d['mode_range'] = $mode_range;
		
		$d['jumlah_rapor'] = 1;
		
		if ($d['resultset_array'][$id]['selected_rows'] == 0)
			return alert_info('Daftar nilai siswa tidak ditemukan. Periksa pelajaran siswa dan filter pencarian.', "nilai/siswa/id/{$d['row']['id']}");

		//return $this->_view(APP_SCOPE);

		if ($dump === 'dump')
		{
			return $this->_dump();
		}
		
		
		$semester_nama = strtolower($d['row']['semester_nama']);
		$abre_ta_nama = str_replace("/","-",$d['row']['ta_nama']);
		$abre_filename = APP_SCOPE."/".$abre_ta_nama."_".$set_kurikulum_nama."_".$semester_nama;
		//if ($more === 'html')
		//{
		//	return $this->_view( $abre_filename );
		//}
		if(APP_SCOPE=='sma_terbang'){
		$this->_pdf("rapor_mid-nis-{$d['row']['siswa_nis']}-{$d['row']['ta_nama']}-{$d['row']['semester_nama']}", $abre_filename);
		}else{
			//return $this->_view(APP_SCOPE);
			$this->_pdf("rapor_mid-nis-{$d['row']['siswa_nis']}-{$d['row']['ta_nama']}-{$d['row']['semester_nama']}", APP_SCOPE);
		}
	}

	public function rapor_mid_kelas($id = 0, $mode_range = 100, $more = '')
	{
		
		$mode = (strpos($id, '.pdf') === FALSE) ? 'I' : 'D';
		$id = str_replace(".pdf", "", $id);

		$this->_set('nilai/siswa/rapor_mid');
		
		$d = & $this->d;
		
		//return $this->_dump();
		$d['id_nilai_siswa'] = $this->m_nilai_kelas->rowsub_siswa($id, 0, 50);
		
		
		$jumlah_rapor=0;
		foreach($d['id_nilai_siswa']['data'] as $nilai_siswa )
		{
			$jumlah_rapor++;
			
			$this->_rowset('m_nilai_siswa', $nilai_siswa['id'], 'nilai/siswa');
			
			$d['pelajar'] = ($this->d['user']['id'] == $this->d['row']['siswa_id']);
			$d['walikelasybs'] = in_array($d['row']['kelas_id'], $d['walikelas']);
	
			if (!$d['admin'] && !$d['pelajar'] && !$d['walikelasybs'])
			{
				return alert_error('Anda tidak dapat mengakses nilai siswa.', '');
			}
			$set_kurikulum_nama =  strtolower($d['row']['kurikulum_nama']);
			$d['resultset_array'][$nilai_siswa['id']]		 	= $this->m_nilai_siswa_pelajaran->siswarapor($nilai_siswa['id'],$set_kurikulum_nama);
			$d['ekskul_result_array'][$nilai_siswa['id']] 		= $this->m_nilai_siswa->subrow_ekskul($nilai_siswa['id']);
			
			$d['konversi_nilai'] = $this->m_nilai_siswa->konversi_nilai();
			$d['mode_range'] = $mode_range;
			
			//return alert_info($d['row']['semester_id'], "nilai/siswa/id/{$d['row']['id']}");
			if ($d['resultset_array'][$nilai_siswa['id']]['selected_rows'] == 0)
			{
				return alert_info('Daftar nilai siswa tidak ditemukan. Periksa pelajaran siswa dan filter pencarian.', "nilai/siswa/id/{$d['row']['id']}");
			}
	
			$nama_file = url_title("rapor_{$d['row']['kelas_nama']}_{$d['row']['ta_nama']}-{$d['row']['semester_nama']}");
	
			if ($more === 'html')
			{
				return $this->_view(APP_SCOPE );
			}
		}
		
		$kolom_rerata='';
		if(APP_SCOPE=='sman8smg')
		{	$kolom_rerata = 'uts';	}
		elseif(APP_SCOPE=='smk_penerbangan')
		{	$kolom_rerata = 'mid_teori';	}
		if($kolom_rerata!='')
		{
			$d['rerata']	= $this->m_nilai_siswa_pelajaran->rerata_pelajaran_perkelas($kolom_rerata, $d['row']['kelas_id'],$d['row']['semester_id']);
			//$d['rerata']	= $this->m_nilai_siswa_pelajaran->rerata_pelajaran_perkelas('uts', $d['row']['kelas_id']);
		}
		
		$d['jumlah_rapor'] = $jumlah_rapor;
		//return $this->_pdf($nama_file, APP_SCOPE );
		
		$semester_nama = strtolower($d['row']['semester_nama']);
		$abre_ta_nama = str_replace("/","-",$d['row']['ta_nama']);
		$abre_filename = APP_SCOPE."/".$abre_ta_nama."_".$set_kurikulum_nama."_".$semester_nama;
		if(APP_SCOPE=='sma_terbang'){
		$this->_pdf($nama_file, $abre_filename);
		}else{
			//return $this->_view(APP_SCOPE);
			$this->_pdf($nama_file, APP_SCOPE);
		}

		// generator pdf sendiri

		
		$this->load->library('mpdf');
		
		$this->mpdf->Output("rapor-nis-{$d['row']['siswa_nis']}-{$d['row']['ta_nama']}-{$d['row']['semester_nama']}.pdf", $mode);

		
	}
	
	public function rapor_tik($id = 0, $mode_range = 100, $dump = '')
	{
		
		$this->_set('nilai/siswa/rapor_tik');
		
		$this->_rowset('m_nilai_siswa', $id, 'nilai/siswa');

		$d = & $this->d;
		$d['pelajar'] = ($this->d['user']['id'] == $this->d['row']['siswa_id']);
		$d['walikelasybs'] = in_array($d['row']['kelas_id'], $d['walikelas']);

		$set_kurikulum_nama =  strtolower($d['row']['kurikulum_nama']);
		
		if (!$d['admin'] && !$d['pelajar'] && !$d['walikelasybs'])
			return alert_error('Anda tidak dapat mengakses nilai siswa.', '');

		$d['id_nilai_siswa']['data'][0]		= $this->m_nilai_siswa->rowset($id);
		$d['resultset_array'][$id]		 	= $this->m_nilai_siswa_pelajaran->siswarapor($id,$set_kurikulum_nama,'tik');
		$d['ekskul_result_array'][$id] 		= $this->m_nilai_siswa->subrow_ekskul($id);
		
		
		$d['konversi_nilai'] = $this->m_nilai_siswa->konversi_nilai();
		$d['mode_range'] = $mode_range;
		
		$d['jumlah_rapor'] = 1;
		
		if ($d['resultset_array'][$id]['selected_rows'] == 0)
			return alert_info('Daftar nilai siswa tidak ditemukan. Periksa pelajaran siswa dan filter pencarian.', "nilai/siswa/id/{$d['row']['id']}");

		//return $this->_view(APP_SCOPE);

		if ($dump === 'dump')
		{
			return $this->_dump();
		}
		
		
		$semester_nama = strtolower($d['row']['semester_nama']);
		$abre_ta_nama = str_replace("/","-",$d['row']['ta_nama']);
		$abre_filename = APP_SCOPE."/".$abre_ta_nama."_".$set_kurikulum_nama."_".$semester_nama;
		//if ($more === 'html')
		//{
		//	return $this->_view( $abre_filename );
		//}
		if(APP_SCOPE=='sma_terbang'){
		$this->_pdf("rapor_tik-nis-{$d['row']['siswa_nis']}-{$d['row']['ta_nama']}-{$d['row']['semester_nama']}", $abre_filename);
		}else{
			//return $this->_view(APP_SCOPE);
			$this->_pdf("rapor_tik-nis-{$d['row']['siswa_nis']}-{$d['row']['ta_nama']}-{$d['row']['semester_nama']}", APP_SCOPE);
		}
	}
	
	public function rapor_tik_kelas($id = 0, $mode_range = 100, $more = '')
	{
		
		$mode = (strpos($id, '.pdf') === FALSE) ? 'I' : 'D';
		$id = str_replace(".pdf", "", $id);

		$this->_set('nilai/siswa/rapor_tik');
		
		$d = & $this->d;
		
		//return $this->_dump();
		$d['id_nilai_siswa'] = $this->m_nilai_kelas->rowsub_siswa($id, 0, 50);
		
		
		$jumlah_rapor=0;
		foreach($d['id_nilai_siswa']['data'] as $nilai_siswa )
		{
			$jumlah_rapor++;
			
			$this->_rowset('m_nilai_siswa', $nilai_siswa['id'], 'nilai/siswa');
			
			$d['pelajar'] = ($this->d['user']['id'] == $this->d['row']['siswa_id']);
			$d['walikelasybs'] = in_array($d['row']['kelas_id'], $d['walikelas']);
	
			if (!$d['admin'] && !$d['pelajar'] && !$d['walikelasybs'])
			{
				return alert_error('Anda tidak dapat mengakses nilai siswa.', '');
			}
			$set_kurikulum_nama =  strtolower($d['row']['kurikulum_nama']);
			$d['resultset_array'][$nilai_siswa['id']]		 	= $this->m_nilai_siswa_pelajaran->siswarapor($nilai_siswa['id'],$set_kurikulum_nama,'tik');
			$d['ekskul_result_array'][$nilai_siswa['id']] 		= $this->m_nilai_siswa->subrow_ekskul($nilai_siswa['id']);
			
			$d['konversi_nilai'] = $this->m_nilai_siswa->konversi_nilai();
			$d['mode_range'] = $mode_range;
			
			//return alert_info($d['row']['semester_id'], "nilai/siswa/id/{$d['row']['id']}");
			if ($d['resultset_array'][$nilai_siswa['id']]['selected_rows'] == 0)
			{
				return alert_info('Daftar nilai siswa tidak ditemukan. Periksa pelajaran siswa dan filter pencarian.', "nilai/siswa/id/{$d['row']['id']}");
			}
	
			$nama_file = url_title("rapor_{$d['row']['kelas_nama']}_{$d['row']['ta_nama']}-{$d['row']['semester_nama']}");
	
			if ($more === 'html')
			{
				return $this->_view(APP_SCOPE );
			}
		}
		
		
		$d['jumlah_rapor'] = $jumlah_rapor;
		//return $this->_pdf($nama_file, APP_SCOPE );
		
		$semester_nama = strtolower($d['row']['semester_nama']);
		$abre_ta_nama = str_replace("/","-",$d['row']['ta_nama']);
		$abre_filename = APP_SCOPE."/".$abre_ta_nama."_".$set_kurikulum_nama."_".$semester_nama;
		if(APP_SCOPE=='sma_terbang'){
		$this->_pdf($nama_file, $abre_filename);
		}else{
			//return $this->_view(APP_SCOPE);
			$this->_pdf($nama_file, APP_SCOPE);
		}

		// generator pdf sendiri

		
		$this->load->library('mpdf');
		
		$this->mpdf->Output("rapor-nis-{$d['row']['siswa_nis']}-{$d['row']['ta_nama']}-{$d['row']['semester_nama']}.pdf", $mode);

		
	}
	
	public function buku_induk($id_siswa = 0,$id_profil = 0, $ta_id = 0, $mode_range = 100, $more = '')
	{
		$mode = (strpos($id_siswa, '.pdf') === FALSE) ? 'I' : 'D';
		$id_siswa = str_replace(".pdf", "", $id_siswa);

		$this->_set('nilai/siswa/buku_induk');
		$this->_rowset('m_nilai_siswa', $id_siswa, 'nilai/siswa');

		$d = & $this->d;
		
		
		$set_kurikulum_nama =  strtolower($d['row']['kurikulum_nama']);
		
		$set_pdf_helper =  "set_pdf/induk_";
		if($set_kurikulum_nama=='ktsp'){
			$this->load->helper($set_pdf_helper.'call');
			$this->load->helper($set_pdf_helper.'view');
			$this->load->helper($set_pdf_helper.'load');
		}else{
			$this->load->helper($set_pdf_helper.'2013_call');
			$this->load->helper($set_pdf_helper.'2013_view');
			$this->load->helper($set_pdf_helper.'2013_load');
		}
		
		$d['pelajar'] = ($this->d['user']['id'] == $this->d['row']['siswa_id']);
		$d['walikelasybs'] = in_array($d['row']['kelas_id'], $d['walikelas']);

		if (!$d['admin'] && !$d['pelajar'] && !$d['walikelasybs'])
		{
			return alert_error('Anda tidak dapat mengakses nilai siswa.', '');
		}
		
		$d['dset']		= $this->m_nilai_siswa->rowset3($id_profil, $ta_id);
		//foreach ($dset as $key => $value){ 
		foreach ($d['dset']['data'] as $data_semester) {
			if(strtolower($data_semester['semester_nama'])=='gasal')
			{	
				$i = 1;
				$semester_id[1] = $data_semester['semester_id'];
			}
			else
			{	
				$i = 2;
				$semester_id[2] = $data_semester['semester_id'];
			}
		
			$Nid = $data_semester['nilai_id'];
			$d['data']['id_siswa'][0]								= $id_profil;
			$d['data']['id_nilai_siswa'][$id_profil][$i]			= $this->m_nilai_siswa->rowset($Nid);
			$d['data']['resultset_array'][$id_profil][$i]			= $this->m_nilai_siswa_pelajaran->siswarapor($Nid,$set_kurikulum_nama);
			$d['data']['ekskul_result_array'][$id_profil][$i] 		= $this->m_nilai_siswa->subrow_ekskul($Nid);
			$d['data']['prestasi_result_array'][$id_profil][$i] 	= $this->m_nilai_siswa->subrow_prestasi($Nid);
			$d['data']['org_result_array'][$id_profil][$i] 			= $this->m_nilai_siswa->subrow_org($Nid);
			$d['data']['aspek_result_array'][$id_profil][$i] 		= $this->m_nilai_siswa->aspek_penilaian($Nid);
			
		}
		if(isset($semester_id[1])){
			$d['data']['deskripsi_pelajaran'][1] = $this->m_nilai_siswa->deskripsi_pelajaran($semester_id[1]);
		}
		if(isset($semester_id[2])){
			$d['data']['deskripsi_pelajaran'][2] = $this->m_nilai_siswa->deskripsi_pelajaran($semester_id[2]);
		}
		/*
		$d['deskripsi_nilai'] = $this->m_nilai_siswa->deskripsi_nilai($d['row']['semester_id']);
		$d['deskripsi_pelajaran'] = $this->m_nilai_siswa->deskripsi_pelajaran($d['row']['semester_id']);
		$d['konversi_nilai'] = $this->m_nilai_siswa->konversi_nilai();
		*/
		$d['mode_range'] = $mode_range;
		
		$d['jumlah_rapor'] = 1;
		
		//return $this->_dump();
		//return alert_info($d['row']['semester_id'], "nilai/siswa/id/{$d['row']['id']}");
		/*
		if ($d['resultset_array'][$id]['selected_rows'] == 0)
		{
			return alert_info('Daftar nilai siswa tidak ditemukan. Periksa pelajaran siswa dan filter pencarian.', "nilai/siswa/id/{$d['row']['id']}");
		}
*/
		$nama_file = url_title("Buku_Induk_{$d['row']['kelas_nama']}_{$d['row']['siswa_nis']}_{$d['row']['ta_nama']}");

		$abre_ta_nama = str_replace("/","-",$d['row']['ta_nama']);
		
		$set_kurikulum_nama =  strtolower($d['row']['kurikulum_nama']);
		
		if($set_kurikulum_nama=='ktsp'){
			$abre_filename = APP_SCOPE."/default_1";
		}else{
			//$abre_filename = APP_SCOPE."/rapor_thn_k13.php";
			$abre_filename = APP_SCOPE."/default_2013.php";
		}
		
		if ($more === 'html')
		{
			return $this->_view( $abre_filename );
		}
		
		return $this->_pdf($nama_file, $abre_filename );

		// generator pdf sendiri

		$body = $this->_view("body", TRUE);
		$footer = $this->_view("footer", TRUE);

		$this->load->library('mpdf');
		$this->mpdf->WriteHTML($body);
		$this->mpdf->SetHTMLFooter($footer);
		//$this->mpdf->mPDF('utf-8', 'L');
		$this->mpdf->Output("rapor-nis-{$d['row']['siswa_nis']}-{$d['row']['ta_nama']}-{$d['row']['semester_nama']}.pdf", $mode);

	}
	
	public function mutasi($id = 0, $output = 'pdf')
	{
		$id = str_replace(".pdf", "", $id);

		$this->_set('nilai/siswa/mutasi');
		$this->_rowset('m_nilai_siswa', $id, 'nilai/siswa');
		

		$d = & $this->d;
		$d['pelajar'] = ($this->d['user']['id'] == $this->d['row']['siswa_id']);
		$d['walikelasybs'] = in_array($d['row']['kelas_id'], $d['walikelas']);

		if (!$d['admin'] && !$d['pelajar'] && !$d['walikelasybs'])
			return alert_error('Anda tidak dapat mengakses nilai siswa.', '');
		
		$d['id_nilai_siswa']['data'][0]		= $this->m_nilai_siswa->rowset($id);
		$d['jumlah_rapor'] = 1;
			
		$nama_file = url_title("mutasi_{$d['row']['siswa_nis']}_{$d['row']['ta_nama']}-{$d['row']['semester_nama']}");
		
		if ($output === 'html')
		{
			return $this->_view(APP_SCOPE);
		}

		return $this->_pdf( $nama_file , APP_SCOPE );

	}
	
	public function mutasi_kelas($id = 0, $output = 'pdf', $more = '')
	{
		$id = str_replace(".pdf", "", $id);

		$this->_set('nilai/siswa/mutasi');
		
		$d = & $this->d;
		
		//return $this->_dump();
		$d['id_nilai_siswa'] = $this->m_nilai_kelas->rowsub_siswa($id, 0, 50);
		
		$jumlah_rapor=0;
		foreach($d['id_nilai_siswa']['data'] as $nilai_siswa )
		{
			$jumlah_rapor++;
			
			$this->_rowset('m_nilai_siswa', $nilai_siswa['id'], 'nilai/siswa');
			
			$d['pelajar'] = ($this->d['user']['id'] == $this->d['row']['siswa_id']);
			$d['walikelasybs'] = in_array($d['row']['kelas_id'], $d['walikelas']);
	
			if (!$d['admin'] && !$d['pelajar'] && !$d['walikelasybs'])
			{
				return alert_error('Anda tidak dapat mengakses nilai siswa.', '');
			}
			
	
		}
		$d['jumlah_rapor'] = $jumlah_rapor;
		
		$nama_file = url_title("rapor_{$d['row']['kelas_nama']}_{$d['row']['ta_nama']}-{$d['row']['semester_nama']}");
		
		if ($more === 'html')
		{
			return $this->_view(APP_SCOPE );
		}
		return $this->_pdf( $nama_file , APP_SCOPE );
		
	}
	
	public function impor_absen_kepribadian($aksi = '')
	{
		$this->_set('nilai/siswa/impor_absen_kepribadian');

		$d = & $this->d;
		$sql_opsi_kelas = "select id, nama from dakd_kelas where aktif = 1 ";
		$format = ($aksi === 'format');

		if ($d['user']['role'] != 'admin')
		{
			return alert_error('Impor hanya dapat dilakukan melalui admin kurikulum.', 'nilai/pelajaran');
		}
		if ($d['semaktif']['id'] < 1)
			return alert_error('Tak dapat mengimpor nilai pada masa jeda semester.', 'nilai/siswa');

		if (!$d['admin'])
			$sql_opsi_kelas .= " and (wali_id = {$d['user']['id']})";

		$d['opsi_kelas'] = $this->md->result_series('id', 'nama', $sql_opsi_kelas);

		if (empty($d['opsi_kelas']))
			return alert_error('Anda tidak terkait dengan kelas manapun untuk mengisi absensi dan kepribadian.', '');

		if ($format && $d['request']['semester_id'])
			return $this->m_nilai_siswa->impor_absen_kepribadian_format();
		
		if ($format && $d['post_request'])
			return $this->m_nilai_siswa->impor_absen_kepribadian_format();

		if (!$format && $d['post_request'] && !$d['error'])
			if ($this->m_nilai_siswa->impor_absen_kepribadian())
				return redir("nilai/siswa");

		$this->form->set();
		$this->_view();

	}

	public function impor_absen($aksi = '')
	{
		$this->_set('nilai/siswa/impor_absen');

		$d = & $this->d;
		$sql_opsi_kelas = "select id, nama from dakd_kelas where aktif = 1 ";
		$format = ($aksi === 'format');

		/*if ($d['user']['role'] != 'admin')
		{
			return alert_error('Impor hanya dapat dilakukan melalui admin kurikulum.', 'nilai/pelajaran');
		}*/
		if ($d['semaktif']['id'] < 1)
			return alert_error('Tak dapat mengimpor nilai pada masa jeda semester.', 'nilai/siswa');

		if (!$d['admin'])
			$sql_opsi_kelas .= " and (wali_id = {$d['user']['id']})";

		$d['opsi_kelas'] = $this->md->result_series('id', 'nama', $sql_opsi_kelas);

		if (empty($d['opsi_kelas']))
			return alert_error('Anda tidak terkait dengan kelas manapun untuk mengisi absensi.', '');

		if ($format && $d['request']['semester_id'])
			return $this->m_nilai_siswa->impor_absen_format();
		
		if ($format && $d['post_request'])
			return $this->m_nilai_siswa->impor_absen_format();

		if (!$format && $d['post_request'] && !$d['error'])
			if ($this->m_nilai_siswa->impor_absen())
				return redir("nilai/siswa");

		$this->form->set();
		$this->_view();

	}
	public function impor_absen_kenaikan($aksi = '')
	{
		$this->_set('nilai/siswa/impor_absen_kenaikan');

		$d = & $this->d;
		$sql_opsi_kelas = "select id, nama from dakd_kelas where aktif = 1 ";
		$format = ($aksi === 'format');

		/*if ($d['user']['role'] != 'admin')
		{
			return alert_error('Impor hanya dapat dilakukan melalui admin kurikulum.', 'nilai/pelajaran');
		}*/
		if ($d['semaktif']['id'] < 1)
			return alert_error('Tak dapat mengimpor nilai pada masa jeda semester.', 'nilai/siswa');

		if (!$d['admin'])
			$sql_opsi_kelas .= " and (wali_id = {$d['user']['id']})";

		$d['opsi_kelas'] = $this->md->result_series('id', 'nama', $sql_opsi_kelas);

		if (empty($d['opsi_kelas']))
			return alert_error('Anda tidak terkait dengan kelas manapun untuk mengisi absensi dan kenaikan kelas.', '');

		if ($format && $d['request']['semester_id'])
			return $this->m_nilai_siswa->impor_absen_kenaikan_format();
		
		if ($format && $d['post_request'])
			return $this->m_nilai_siswa->impor_absen_kenaikan_format();

		if (!$format && $d['post_request'] && !$d['error'])
			if ($this->m_nilai_siswa->impor_absen_kenaikan())
				return redir("nilai/siswa");

		$this->form->set();
		$this->_view();

	}
	public function impor_kepribadian($aksi = '')
	{
		$this->_set('nilai/siswa/impor_kepribadian');

		$d = & $this->d;
		$sql_opsi_kelas = "select id, nama from dakd_kelas where aktif = 1 ";
		$format = ($aksi === 'format');

		/*if ($d['user']['role'] != 'admin')
		{
			return alert_error('Impor hanya dapat dilakukan melalui admin kurikulum.', 'nilai/pelajaran');
		}*/
		if ($d['semaktif']['id'] < 1)
			return alert_error('Tak dapat mengimpor nilai pada masa jeda semester.', 'nilai/siswa');

		if (!$d['admin'])
			$sql_opsi_kelas .= " and (wali_id = {$d['user']['id']})";

		$d['opsi_kelas'] = $this->md->result_series('id', 'nama', $sql_opsi_kelas);

		if (empty($d['opsi_kelas']))
			return alert_error('Anda tidak terkait dengan kelas manapun untuk mengisi kepribadian.', '');

		if ($format && $d['request']['semester_id'])
			return $this->m_nilai_siswa->impor_kepribadian_format();
		
		if ($format && $d['post_request'])
			return $this->m_nilai_siswa->impor_kepribadian_format();

		if (!$format && $d['post_request'] && !$d['error'])
			if ($this->m_nilai_siswa->impor_kepribadian())
				return redir("nilai/siswa");
		//$this->_dump();
		$this->form->set();
		$this->_view();

	}
	public function impor_kerja_lapangan($aksi = '')
	{
		$this->_set('nilai/siswa/impor_kerja_lapangan');

		$d = & $this->d;
		$sql_opsi_kelas = "select id, nama from dakd_kelas where aktif = 1 ";
		$format = ($aksi === 'format');

		//if ($d['user']['role'] != 'admin')
		//{
			//return alert_error('Impor hanya dapat dilakukan melalui admin kurikulum.', 'nilai/pelajaran');
		//}
		if ($d['semaktif']['id'] < 1)
			return alert_error('Tak dapat mengimpor nilai pada masa jeda semester.', 'nilai/siswa');

		if (!$d['admin'])
			$sql_opsi_kelas .= " and (wali_id = {$d['user']['id']})";

		$d['opsi_kelas'] = $this->md->result_series('id', 'nama', $sql_opsi_kelas);

		if (empty($d['opsi_kelas']))
			return alert_error('Anda tidak terkait dengan kelas manapun untuk mengisi laporan kerja lapangan.', '');

		if ($format && $d['post_request'])
			return $this->m_nilai_siswa->impor_kerja_lapangan_format();

		if (!$format && $d['post_request'] && !$d['error'])
			if ($this->m_nilai_siswa->impor_kerja_lapangan())
				return redir("nilai/siswa");

		$this->form->set();
		$this->_view();
	}
	
	public function impor_keterangan_walikelas($aksi = '')
	{
		$this->_set('nilai/siswa/impor_keterangan_walikelas');

		$d = & $this->d;
		$sql_opsi_kelas = "select id, nama from dakd_kelas where aktif = 1 ";
		$format = ($aksi === 'format');

		//if ($d['user']['role'] != 'admin')
		//{
			//return alert_error('Impor hanya dapat dilakukan melalui admin kurikulum.', 'nilai/pelajaran');
		//}
		if ($d['semaktif']['id'] < 1)
			return alert_error('Tak dapat mengimpor nilai pada masa jeda semester.', 'nilai/siswa');

		if (!$d['admin'])
			$sql_opsi_kelas .= " and (wali_id = {$d['user']['id']})";

		$d['opsi_kelas'] = $this->md->result_series('id', 'nama', $sql_opsi_kelas);

		if (empty($d['opsi_kelas']))
			return alert_error('Anda tidak terkait dengan kelas manapun untuk mengisi absensi dan kepribadian.', '');

		if ($format && $d['post_request'])
			return $this->m_nilai_siswa->impor_keterangan_walikelas_format();

		if (!$format && $d['post_request'] && !$d['error'])
			if ($this->m_nilai_siswa->impor_keterangan_walikelas())
				return redir("nilai/siswa");

		$this->form->set();
		$this->_view();

	}
	
	public function pengumuman_rapor()
	{
		$d = & $this->d;
		
		$this->_set('nilai/siswa/pengumuman_rapor');
		$this->_rowset('m_nilai_siswa', $d['user']['nilai_id'], 'nilai/siswa');
		
		$d['resultset'] = $this->m_app_config->browse(0, 100);
		
		$this->_view();
	}
	
	public function pengumuman_kelulusan()
	{
		$this->_set('nilai/siswa/pengumuman_kelulusan');
		
		$d = & $this->d;
		
		$d['resultset'] = $this->m_app_config->browse(0, 100);
		
		$this->_view();
	}

}
