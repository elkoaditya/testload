<?php

class M_kbm_evaluasi_tool extends MY_Model {

	public function __construct() {
		parent::__construct();
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

		$this->db->trans_start();
		foreach($resulset['data'] as &$siswa){

			//echo "<br>".$siswa['siswa_id'];

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
					if(isset($nilai_posisi_kd[$jwb['soal_posisi_kd']]['poin'])){
						/// EMPTY
					}else{
						$nilai_posisi_kd[$jwb['soal_posisi_kd']]['poin'] = 0;
						$nilai_posisi_kd[$jwb['soal_posisi_kd']]['poin_max'] = 0;
					}

					$nilai_posisi_kd[$jwb['soal_posisi_kd']]['poin'] 	+=  $_raw['poin'];
					$nilai_posisi_kd[$jwb['soal_posisi_kd']]['poin_max'] +=  $jwb['soal_poin_max'];
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
				$update_ljs['recalculation'] = date('Y-m-d h:i:sa');
				$update_ljs['poin']		= $Uljs['poin'];
				$update_ljs['poin_max']	= $Uljs['poin_max'];
				$update_ljs['nilai'] = $Uljs['poin'] / $Uljs['poin_max'] * 100;
				
				
				$update_nilai['evaluasi_poin']		= $update_ljs['poin'];
				$update_nilai['evaluasi_poin_max']	= $update_ljs['poin_max'];
				$update_nilai['evaluasi_nilai'] = $update_ljs['nilai'];
				
				$tampil_kd=1;
				$jumlah_posisi_kd=30;
				while($tampil_kd<=$jumlah_posisi_kd){

					if(isset($nilai_posisi_kd[$tampil_kd])){
						$update_ljs['nilai_posisi_kd'.$tampil_kd] = 100 * $nilai_posisi_kd[$tampil_kd]['poin'] / $nilai_posisi_kd[$tampil_kd]['poin_max'];
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
}