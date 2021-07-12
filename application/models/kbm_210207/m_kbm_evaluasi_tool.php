<?php

class M_kbm_evaluasi_tool extends MY_Model {

	public function __construct() {
		parent::__construct();
		
		$this->dm['view'] = cfguc_view('akses', 'kbm', 'evaluasi');
	}

	function query_update_jawaban($_raw,$_jwb=''){
		if($_jwb!='')
		{
			$data = array(
			   'pilihan' => $_jwb,
			   'modified' => date('Y-m-d H:i:s'),
			);
		}
			
		if(isset($_raw['jawaban']))
		{
			if(isset($_raw['poin'])){
				$data['poin'] = $_raw['poin'];
			}
			$data['jawaban']	= $_raw['jawaban'];

			$this->db->where('ljs_id', $_raw['ljs_id']);
			$this->db->where('soal_id', $_raw['soal_id']);
			$this->db->update('kbm_evaluasi_jawaban', $data); 
			
		}else{

			if(isset($_raw['poin']))
				$data['poin'] = $_raw['poin'];
		
			$this->db->where('ljs_id', $_raw['ljs_id']);
			$this->db->where('soal_id', $_raw['soal_id']);
			$this->db->update('kbm_evaluasi_jawaban', $data); 
		}
	}
	
	function recalculation($index = 0, $limit = 50){

		$d = & $this->ci->d;
		$r = & $this->ci->d['request'];

		$query = array(
				'select' => array(
						//'evanil.*',
						'kelas_nama'	=> 'kelas.nama',
						'siswa_id' 		=> 'siswa.id',
						'siswa_nis' 	=> 'siswa.nis',
						'siswa_nisn' 	=> 'siswa.nisn',
						'siswa_nama' 	=> 'siswa.nama',
						'siswa_gender' 	=> 'siswa.gender',
						'ljs_id'		=>	'ljs.id',
						//'ljs_waktu'		=>	'ljs.waktu',
						//'ljs_dikoreksi'	=>	'ljs.dikoreksi',

				),
				'from' => 'kbm_evaluasi_nilai evanil',
				'join' => array(
						array('dprofil_siswa siswa', 'evanil.user_id = siswa.id', 'inner'),
						array('dakd_kelas kelas', 'evanil.kelas_id = kelas.id', 'inner'),
						array('kbm_evaluasi_ljs ljs', 'evanil.ljs_id = ljs.id', 'left'),
				),

		);
		$query['where']['evanil.evaluasi_id'] = $r['evaluasi_id'];
		$query['where']['evanil.kelas_id'] = $r['kelas_id'];

		$resulset = $this->md->query($query)->resultset($index, $limit);

		//print_r($resulset);

		$jml_soal=0;
		$jml_siswa=0;
		$this->db->trans_start();
		foreach($resulset['data'] as &$siswa){

			//echo "<br>".$siswa['siswa_id'];
			$jml_siswa++;
			$query = array(

				'select' => array(
						'jawaban.*',
						
						'soal_id'			=>	'soal.id',
						'soal_poin_max'		=>	'soal.poin_max',
						'soal_posisi_kd'	=>	'soal.posisi_kd',
						'soal_nilai_bonus'	=>	'soal.nilai_bonus',
						'soal_pertanyaan'	=> 	'soal.pertanyaan',
						'soal_pilihan'		=>	'soal.pilihan',
						
						'ljs_id'		=>	'ljs.id',
						'ljs_nilai'		=>	'ljs.nilai',
						'ljs_awal_waktu'=>	'ljs.awal_waktu',
						'ljs_waktu'		=>	'ljs.waktu',
						'ljs_dikoreksi'	=>	'ljs.dikoreksi',
						'ljs_selesai'	=> 	'ljs.selesai',

				),
				'from' => 'kbm_evaluasi_ljs ljs',
				'join' => array(
						array('kbm_evaluasi_jawaban jawaban', 'jawaban.ljs_id = ljs.id', 'left'),
						array('kbm_evaluasi_soal soal', 'soal.id = jawaban.soal_id', 'left'),
				),
				'order_by' => 'ljs.id ASC, jawaban.no_urut ASC',

			);

			$query['where']['ljs.evaluasi_id'] = $r['evaluasi_id'];
			$query['where']['ljs.user_id'] = $siswa['siswa_id'];

			$_jawaban = $this->md->query($query)->resultset($index, 200);


			// ljs
			//$update_jawaban['ljs_id']		= '';
			//$update_jawaban['soal_id']		= '';

			$Uljs['poin']=0;
			$Uljs['poin_max']=0;
			foreach($_jawaban['data'] as $jwb){
				// ljs
				//$update_jawaban['ljs_id']		= $jwb['ljs_id'];
				//$update_jawaban['soal_id']		= $jwb['soal_id'];


				// Encode
				$jwb['soal_pilihan'] = json_decode($jwb['soal_pilihan'], TRUE);
				
				if (isset($jwb['soal_pilihan']['kunci'])){
					/// PILGAN
					if (isset($jwb['soal_pilihan']['kunci']['label'])){
						$jwb['soal_pilihan']['kunci']['label'] = base64_decode($jwb['soal_pilihan']['kunci']['label']);
					}else{
						$jwb['soal_pilihan']['kunci']['label'] = NULL;
					}
					
					if (!isset($jwb['soal_pilihan']['pengecoh']) OR ! is_array($jwb['soal_pilihan']['pengecoh'])):
						$jwb['soal_pilihan']['pengecoh'] = array();
					else:
						foreach (array_keys($jwb['soal_pilihan']['pengecoh']) as $index):
							$jwb['soal_pilihan']['pengecoh'][$index] = base64_decode($jwb['soal_pilihan']['pengecoh'][$index]);
						endforeach;

					endif;


					// POINT
					$jwb['pilihan'] = trim($jwb['pilihan']);
					$pilihan_valid = (strlen($jwb['pilihan']) == 1);

					$kunci = trim($jwb['soal_pilihan']['kunci']['index']);
					$_raw['pilihan'] = ($pilihan_valid) ? $jwb['pilihan'] : '';
					$_raw['poin'] = ($_raw['pilihan'] == $kunci) ? $jwb['soal_poin_max'] : 0;
					
					
					// NILAI BONUS
					if($jwb['soal_nilai_bonus'] == 1){
						$_raw['poin'] = $jwb['soal_poin_max'];
					}
					$Uljs['poin'] += $_raw['poin'];
					$Uljs['poin_max'] += $jwb['soal_poin_max'];
					
					$update_jawaban['poin'] = $_raw['poin'];
					
					/// NILAI PER KD
					if(isset($nilai_posisi_kd[$jml_siswa][$jwb['soal_posisi_kd']]['poin'])){
						/// EMPTY
					}else{
						$nilai_posisi_kd[$jml_siswa][$jwb['soal_posisi_kd']]['poin'] = 0;
						$nilai_posisi_kd[$jml_siswa][$jwb['soal_posisi_kd']]['poin_max'] = 0;
					}

					$nilai_posisi_kd[$jml_siswa][$jwb['soal_posisi_kd']]['poin'] 	+=  $_raw['poin'];
					$nilai_posisi_kd[$jml_siswa][$jwb['soal_posisi_kd']]['poin_max'] +=  $jwb['soal_poin_max'];
					//////

					/// CHECKER ////////////////////////////////////////////////
					$siswa['soal_pertanyaan'.$jwb['no_urut']] = base64_decode($jwb['soal_pertanyaan']);
					$siswa['soal_point'.$jwb['no_urut']] = $_raw['poin'];
					$status_jawab_benar='<font color="red">SALAH</font>';
					if($_raw['poin']>0){
						$status_jawab_benar='<font color="green">BENAR</font>';
					}

					$siswa['soal_status'.$jwb['no_urut']] = $status_jawab_benar;
					$siswa['soal_kunci_index'.$jwb['no_urut']] = $kunci;
					$siswa['soal_kunci'.$jwb['no_urut']] = $jwb['soal_pilihan']['kunci']['label'];
					
					
					$siswa['soal_jawaban_index'.$jwb['no_urut']] = $jwb['pilihan'];
					if(isset($jwb['soal_pilihan']['pengecoh'][$jwb['pilihan']])){
						$siswa['soal_jawaban'.$jwb['no_urut']] = $jwb['soal_pilihan']['pengecoh'][$jwb['pilihan']];
					}else{
						$siswa['soal_jawaban'.$jwb['no_urut']] = $jwb['soal_pilihan']['kunci']['label'];
					}
					///////////////////////////////////////////////////////////////
					
				}else{

					// URAIAN
					$siswa['soal_pilihan'.$jwb['no_urut']] = json_decode($jwb['pilihan']);

				}
				//$siswa['soal_poin'.$jwb['no_urut']] = $jwb['poin'];
				$siswa['soal_update'.$jwb['no_urut']] = $jwb['modified'];

						
						
				if($jwb['no_urut']>$jml_soal){
					$jml_soal = $jwb['no_urut'];
				}
				
				
				//print_r($update_jawaban);
				//echo"<br>";
				//print_r($siswa);
				//echo"<br>///////////////////////////////////////////////////////////////<br>";
				
				/// UPDATE POIN JAWABAN SOAL
				$this->db->where('ljs_id', $jwb['ljs_id']);
				$this->db->where('soal_id', $jwb['soal_id']);
				$this->db->update('kbm_evaluasi_jawaban', $update_jawaban); 
				
			}
			
			// BELUM MENGERJAKAN
			if($Uljs['poin_max']>0){
				$update_ljs['recalculation'] = date('Y-m-d h:i:s');
				$update_ljs['poin']		= $Uljs['poin'];
				$update_ljs['poin_max']	= $Uljs['poin_max'];
				$update_ljs['nilai'] = $Uljs['poin'] / $Uljs['poin_max'] * 100;
				
				
				$update_nilai['evaluasi_poin']		= $update_ljs['poin'];
				$update_nilai['evaluasi_poin_max']	= $update_ljs['poin_max'];
				$update_nilai['evaluasi_nilai'] = $update_ljs['nilai'];
				
				$tampil_kd=1;
				$jumlah_posisi_kd=30;
				while($tampil_kd<=$jumlah_posisi_kd){

					if(isset($nilai_posisi_kd[$jml_siswa][$tampil_kd])){
						$update_ljs['nilai_posisi_kd'.$tampil_kd] = 100 * $nilai_posisi_kd[$jml_siswa][$tampil_kd]['poin'] / $nilai_posisi_kd[$jml_siswa][$tampil_kd]['poin_max'];
					}else{
						$update_ljs['nilai_posisi_kd'.$tampil_kd] = 0;
					}
					
					
					$update_nilai['evaluasi_nilai_posisi_kd'.$tampil_kd] = $update_ljs['nilai_posisi_kd'.$tampil_kd];
					$tampil_kd++;
				}
				
				
				
				/// UPDATE LJS DAN NILAI
				$this->db->where('id', $siswa['ljs_id']);
				$this->db->update('kbm_evaluasi_ljs', $update_ljs); 
				
				$this->db->where('user_id', $siswa['siswa_id']);
				$this->db->where('evaluasi_id', $r['evaluasi_id']);
				$this->db->update('kbm_evaluasi_nilai', $update_nilai); 
				//echo"<br>///////////////////////////////////////////////////////////////<br>";
			}
			
			unset($update_ljs);
			unset($update_nilai);

		}

		$trx_status = $this->db->trans_status();
		if (!$trx_status)
			return $this->trans_rollback('Database error, coba beberapa saat lagi.');
			
		$trx = $this->trans_done('Re-kalkulasi Nilai berhasil disimpan.', 'Database error, coba beberapa saat lagi.');

		return $trx;

		
	}
	
	function force_finish($evaluasi_id, $ljs_id, $siswa_id){

		$d = & $this->ci->d;
		
		///////////// EVALUASI ///////////////
		$query = array(
				'from' => 'kbm_evaluasi evaluasi',			
				'select' => array(
						'evaluasi.*', 'nilai.id as nilai_id'
				),
				'join' => array(
						array('kbm_evaluasi_nilai nilai', "  nilai.evaluasi_id = evaluasi.id AND nilai.user_id = '".$siswa_id."' ", 'inner'),
				),	
				
		);
		$query['where']['evaluasi.id'] = $evaluasi_id;
		
		$evaluasi = $this->md->query($query)->row();
		
		
		///////////// LJS ///////////////
		$query = array(
				'from' => 'kbm_evaluasi_ljs ljs',			
				'select' => array(
						'ljs.*'
				),
		);
		$query['where']['ljs.id'] = $ljs_id;
		
		$ljs = $this->md->query($query)->row();
		
		$ljs['dikoreksi'] = (($evaluasi['pilihan_jml'] > 1) ? date("Y-m-d h:i:s") : NULL);
		
		unset($ljs['pilihan_jml']);
		$ljs['selesai'] = 1;
		
		///////////// JAWABAN ///////////////
		$query = array(
				'from' => 'kbm_evaluasi_jawaban jawab',
				'select' => array(
						'jawab.*',
				),
		);
		
		$query['where']['jawab.ljs_id'] = $ljs_id;
		$ljs_jawaban = $this->md->query($query)->resultset(0, 10000);
		
		foreach ($ljs_jawaban['data'] as $plj):
			$jawaban[$plj['soal_id']] = $plj['pilihan']; 
		endforeach;
		
		///////////// SOAL ///////////////
		$query = array(
				'from' => 'kbm_evaluasi_soal soal',
				'select' => array(
						'soal.*',
				),
		);
		
		$query['where']['soal.evaluasi_id'] = $ljs['evaluasi_id'];
		$evaluasi_soal = $this->md->query($query)->resultset(0, 10000);
		
		//print_r($evaluasi_soal);
		$nilai_posisi_kd='';
		foreach ($evaluasi_soal['data'] as $soal):
			soal_prepare($soal);

			$name = "butir-{$soal['id']}";
			$ljs['poin_max'] += $soal['poin_max'];
			$_raw = array('soal_id' => $soal['id']);
			
			$_raw['ljs_id'] = $ljs['id'];
			
			/// CHECK ESSAY
			if ($ljs['dikoreksi']=== NULL):
				$_jwb = (string) $this->input->post($name);
				
				////// CLEAN FROALA ////////////////////////				
				$_jwb = str_replace('<p data-f-id="pbf" style="text-align: center; font-size: 14px; margin-top: 30px; opacity: 0.65; font-family: sans-serif;">	
				Powered by <a href="https://www.froala.com/wysiwyg-editor?pb=1" title="Froala Editor">Froala Editor</a></p>','',$_jwb);				
				$_jwb = str_replace('Powered by <a href="https://www.froala.com/wysiwyg-editor?pb=1" title="Froala Editor">Froala Editor</a>','',$_jwb);	
				$_jwb = str_replace('Froala Editor','',$_jwb);				$_jwb = str_replace('Powered by','',$_jwb);				
				////////////////////////////////////////////////
				
				$_jwb = (string) clean_html($_jwb);
				$_raw['jawaban'] = base64_encode($_jwb);
				
				if(isset($_raw['poin'])){
					$data['poin'] = $_raw['poin'];
				}
				if(isset($_raw['jawaban'])){
					$data['jawaban']	= $_raw['jawaban'];
				}
				
				$this->db->where('ljs_id', $_raw['ljs_id']);
				$this->db->where('soal_id', $_raw['soal_id']);
				$this->db->update('kbm_evaluasi_jawaban', $data); 
			endif;
			
			/// CHECK PILIHAN
			if(isset($jawaban[$soal['id']]))
			{				
				$_jwb = $jawaban[$soal['id']];
	
				if ($ljs['dikoreksi']):
					$_jwb = trim($_jwb);
					$pilihan_valid = (strlen($_jwb) == 1);
					$kunci = array_node($soal, 'pilihan', 'kunci', 'index');
					$_raw['pilihan'] = ($pilihan_valid) ? $_jwb : '';
					$_raw['poin'] = ($_raw['pilihan'] == $kunci) ? $soal['poin_max'] : 0;
					$ljs['poin'] += $_raw['poin'];
					
					if(isset($nilai_posisi_kd[$soal['posisi_kd']]['poin'])){
					}else{
						$nilai_posisi_kd[$soal['posisi_kd']]['poin'] = 0;
						$nilai_posisi_kd[$soal['posisi_kd']]['poin_max'] = 0;
					}
					$nilai_posisi_kd[$soal['posisi_kd']]['poin'] += $_raw['poin'];
					$nilai_posisi_kd[$soal['posisi_kd']]['poin_max'] +=  $soal['poin_max'];
					//$cetak .= "<br/> ".$kunci." ".$_raw['pilihan']." ".$soal['id'];
					//$cetak .= "<br/> ".$soal['posisi_kd']." ".$nilai_posisi_kd[$soal['posisi_kd']]['poin']." ".$nilai_posisi_kd[$soal['posisi_kd']]['poin_max']." ".$soal['id'];
				endif;
				
				if(isset($_raw['poin'])){
					$data['poin'] = $_raw['poin'];
				}
				if(isset($_raw['jawaban'])){
					$data['jawaban']	= $_raw['jawaban'];
				}
				
				$this->db->where('ljs_id', $_raw['ljs_id']);
				$this->db->where('soal_id', $_raw['soal_id']);
				$this->db->update('kbm_evaluasi_jawaban', $data); 
			}
		endforeach;
		//cetak coba 
		//echo $cetak;
		//return !alert_info($cetak);

		$jumlah_posisi_kd=0;
		if ($ljs['dikoreksi']):
			$ljs['nilai'] = 100 * $ljs['poin'] / $ljs['poin_max'];
			
			/// KD =20
			$tampil_kd=1;
			$jumlah_posisi_kd=30;
			while($tampil_kd<=$jumlah_posisi_kd){
				if(isset($nilai_posisi_kd[$tampil_kd])){
					$ljs['nilai_posisi_kd'.$tampil_kd] = 100 * $nilai_posisi_kd[$tampil_kd]['poin'] / $nilai_posisi_kd[$tampil_kd]['poin_max'];
				}else{
					$ljs['nilai_posisi_kd'.$tampil_kd] = 0;
				}
				$tampil_kd++;
			}
		endif;

		
		
		$nilai = array(
				'evaluasi_terkoreksi' => (bool) $ljs['dikoreksi'],
				'evaluasi_nilai' => $ljs['nilai'],
				'evaluasi_poin' => $ljs['poin'],
				'evaluasi_poin_max' => $ljs['poin_max'],
				'ljs_last' => date("Y-m-d h:i:s"),
				'ljs_count' => 1,
		);
		
		
		$tampil_kd=1;
		while($tampil_kd<=$jumlah_posisi_kd){
			$nilai['evaluasi_nilai_posisi_kd'.$tampil_kd] = $ljs['nilai_posisi_kd'.$tampil_kd];
			
			$tampil_kd++;
		}
			
		$this->db->trans_start();
		$this->db->update('kbm_evaluasi_ljs', $ljs,array('id' => $ljs['id']));

		$nilai['ljs_id'] = $ljs['id'];

		$this->db->update('kbm_evaluasi_nilai', $nilai, array('id' => $evaluasi['nilai_id']));


		$msg_sukses = ($ljs['dikoreksi']) ? 'Jawaban dan nilai berhasil disimpan.' : 'Jawaban telah disimpan, menunggu koreksi guru.';

		return $this->trans_done($msg_sukses, 'Database error, coba beberapa saat lagi.');
		
	}
	
	function jadwal($index = 0, $limit = 50){
		$query = $this->query_1();
		$query = $this->filter_1($query);

		return $this->md->query($query)->resultset($index, $limit);
	}

	function query_1()
	{
		$d = & $this->ci->d;
		$dm = & $this->dm;
		$query = array(
			'from'		 => 'kbm_evaluasi evaluasi',
			'join'		 => array(
				array('kbm_evaluasi_kelas evaluasi_kelas', 'evaluasi_kelas.evaluasi_id = evaluasi.id', 'inner'),
				array('dakd_kelas kelas', 'evaluasi_kelas.kelas_id = kelas.id', 'inner'),
				array('prd_semester semester', 'evaluasi.semester_id = semester.id', 'inner'),
				array('prd_ta ta', 'semester.ta_id = ta.id', 'inner'),
				array('dprofil_sdm author', 'evaluasi.author_id = author.id', 'left'),
				array('dakd_pelajaran pelajaran', 'evaluasi.pelajaran_id = pelajaran.id', 'inner'),
				array('dakd_mapel mapel', 'pelajaran.mapel_id = mapel.id', 'inner'),
				array('dakd_kategori_mapel kategori', 'pelajaran.kategori_id = kategori.id', 'inner'),
				array('dmst_kurikulum kurikulum', 'pelajaran.kurikulum_id = kurikulum.id', 'inner'),
				array('dmst_agama agama', 'pelajaran.agama_id = agama.id', 'left'),
				array('dmst_kolom_nilai nilai_kolom', 'evaluasi.nilai_kolom_id = nilai_kolom.id', 'left')
			),
			'order_by'	 => 'evaluasi.semester_id desc, pelajaran.nama, evaluasi.tipe desc, evaluasi_kelas.evaluasi_mulai asc',
			'select'	 => array(
				'evaluasi.*',
				'kelas_nama'		 => 'kelas.nama',
				'evaluasi_kelas.kelas_id',
				'evaluasi_kelas.evaluasi_mulai',
				'evaluasi_kelas.evaluasi_ditutup',
				'evaluasi_kelas.evaluasi_durasi',
				'semester_nama'		 => 'semester.nama',
				'ta_nama'			 => 'ta.nama',
				'author_nama'		 => "trim(concat_ws(' ', author.prefix, author.nama, author.suffix))",
				'pelajaran_nama'	 => 'pelajaran.nama',
				'pelajaran_kode'	 => 'pelajaran.kode',
				'kurikulum_id'		 => 'kurikulum.id',
				'kurikulum_nama'	 => 'kurikulum.nama',
				'mapel_id'		 	 => 'mapel.id',
				'mapel_nama'		 => 'mapel.nama',
				'kategori_id'		 => 'kategori.id',
				'kategori_nama'		 => 'kategori.nama',
				'agama_nama'		 => 'agama.nama',
				'pelajaran.mapel_id',
				'pelajaran.kategori_id',
				'pelajaran.agama_id',
				'nilai_kolom_kode'	 => 'nilai_kolom.kode',
			),
		);
		// delete di hapus dari view
		$query['where']['evaluasi.status !='] = 'deleted';
		
		// filter akses

		if (!$dm['view'] && $dm['mengajar_list']):
			$query['where_in']['evaluasi.pelajaran_id'] = $dm['mengajar_list'];

		elseif (!$dm['view']):
			$query['where']['evaluasi.author_id'] = $d['user']['id'];

		endif;

		//if (!$dm['admin'])
			//$query['where']['evaluasi.status !='] = 'deleted';

		return $query;

	}
	
	function filter_1($query)
	{
		$d = & $this->ci->d;
		$r = & $this->ci->d['request'];
		$def = array(
			'term'			 => '',
			'semester_id'	 => $d['semaktif']['id'],
			'pelajaran_id'	 => 0,
			'mapel_id'		 => 0,
			'author_id'		 => 0,
		);

		// normalisasi

		array_default($r, $def);

		if ($r['semester_id'] == 0)
			$r['semester_id'] = $d['semaktif']['id'];

		// filtering

		if (!empty($r['term']))
			$query['like'] = array($r['term'], array('author.nama', 'evaluasi.nama'));

		if ($r['tanggal_awal'] > 0)
		{
			$exptglwaktu = explode("-",$r['tanggal_awal']);
			$tanggal_awal = $exptglwaktu[2]."-".$exptglwaktu[1]."-".$exptglwaktu[0];
			
			$exptglwaktu = explode("-",$r['tanggal_akhir']);
			$tanggal_akhir = $exptglwaktu[2]."-".$exptglwaktu[1]."-".$exptglwaktu[0];
			
			$query['where_strings'] = 'evaluasi_kelas.evaluasi_mulai >= "'.$tanggal_awal.' 00:00" '.
			'AND evaluasi_kelas.evaluasi_mulai <= "'.$tanggal_akhir.' 23:59"';
		}
		
		if ($r['semester_id'] > 0)
			$query['where']['evaluasi.semester_id'] = $r['semester_id'];

		if ($r['pelajaran_id'] > 0)
			$query['where']['evaluasi.pelajaran_id'] = $r['pelajaran_id'];

		if ($r['mapel_id'] > 0)
			$query['where']['evaluasi.mapel_id'] = $r['mapel_id'];
		
		if ($r['kelas_id'] > 0)
			$query['where']['evaluasi_kelas.kelas_id'] = $r['kelas_id'];

		if ($r['author_id'] > 0 && $d['user']['role'] == 'admin')
			$query['where']['evaluasi.author_id'] = $r['author_id'];
		
		if (!empty($r['status']))
			$query['where']['evaluasi.status'] = $r['status'];
		
		return $query;

	}
}