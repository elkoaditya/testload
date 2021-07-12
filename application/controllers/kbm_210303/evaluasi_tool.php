<?php

class Evaluasi_tool extends MY_Controller {
	public function __construct() {
		parent::__construct(array(
				'controller' => array(
						'user' => array('#login'),
						'model' => 'm_kbm_evaluasi_tool',
						'helper' => 'soal',
				),
				
				'kbm/evaluasi_tool/recalculation' => array(
						'user' => array('sdm', 'admin'),
						'library' => 'pagination',
						'model' => 'm_option',
						'helper' => 'form',
						'request' => array(
								'evaluasi_id' => 'as_int',
								'kelas_id' => 'as_int',
						),
				),
				
				'kbm/evaluasi_tool/recal_dl_nilai' => array(
						'user' => array('sdm', 'admin'),
						'library' => 'pagination',
						'model' => 'm_option',
						'helper' => 'form',
						'request' => array(
								'evaluasi_id' => 'as_int',
								'kelas_id' => 'as_int',
						),
				),
				
				'kbm/evaluasi_tool/jadwal' => array(
						'user' 		=> array('sdm', 'admin'),
						'library' 	=> 'pagination',
						'model' 	=> array('m_dakd_kelas', 'm_option'),
						'helper' 	=> 'form',
						'request' 	=> array(
								'term'			 => 'clean',
								'pelajaran_id'	 => 'as_int',
								'semester_id'	 => 'as_int',
								'author_id'		 => 'as_int',
								'mapel_id'		 => 'as_int',
								'kelas_id'		 => 'as_int',
								'tanggal_awal'   => 'clean',
								'tanggal_akhir'	 => 'clean',
								'status'		 => 'clean',
						),
				),
				
				'kbm/evaluasi_tool/force_finish' => array(
						'user' 		=> array('sdm', 'admin'),
						'library' 	=> 'pagination',
						'model' 	=> array('m_app_config', 'm_option'),
						'helper'	=> 'form',
						'request' 	=> array(
								'evaluasi_id' => 'as_int',
								'kelas_id' => 'as_int',
						),
				),
				
				'kbm/evaluasi_tool/pakta_integritas' => array(
						'user' 		=> array('sdm', 'admin', 'siswa'),
						'model' 	=> array('m_app_config'),
						'library' 	=> 'form',
						'helper' 	=> 'form',
						
				),
			));
		$this->d['admin'] = cfguc_admin('akses', 'kbm', 'evaluasi');
		$this->d['view'] = cfguc_view('akses', 'kbm', 'evaluasi');
		
		$this->d['mengajar_list'] = (array) cfgu('mengajar_list');
		$this->d['pelajaran_list'] = (array) cfgu('pelajaran_list');
	}

	public function _rowset_evaluasi() {
		$d = & $this->d;

		if (!$d['request']['evaluasi_id'])
			return alert_info('Pilih nama soal evaluasi yang hendak ditampilkan.', 'kbm/evaluasi');

		$this->_rowset('m_kbm_evaluasi', $d['request']['evaluasi_id'], 'kbm/evaluasi', 'evaluasi');

		$d['evaluasi']['#available'] = $this->m_kbm_evaluasi->availability($d['evaluasi']);
		$d['author_ybs'] = ($d['user']['id'] == $d['evaluasi']['author_id']);
		$d['pengajar_ybs'] = mengajar($d['evaluasi']['pelajaran_id']);

		if (!$d['author_ybs'] && !$d['pengajar_ybs'] && !$d['view'] && $d['user']['role'] != 'siswa')
			return alert_error("Anda tak diperbolehkan mengakses ljs evaluasi.", 'kbm/evaluasi');
	}

	public function recalculation($index = 0) {
		$d = & $this->d;
		
		$this->_set('kbm/evaluasi_tool/recalculation');
		$this->_rowset_evaluasi();
		
		//$this->d['resultset'] = $this->m_kbm_evaluasi_tool->recalculation($index, 50);
		if($this->m_kbm_evaluasi_tool->recalculation()){
			return redir("kbm/evaluasi/id/{$d['evaluasi']['id']}");
		}
		//print_r($this->d['resultset']);
		//$this->_view();
	}
	
	public function recal_dl_nilai($index = 0) {
		$d = & $this->d;
		
		$this->_set('kbm/evaluasi_tool/recalculation');
		$this->_rowset_evaluasi();
		
		if($this->m_kbm_evaluasi_tool->recalculation()){
			if($d['request']['kelas_id']>0){
				return redir("kbm/evaluasi_nilai/download?evaluasi_id=".$d['request']['evaluasi_id']."&kelas_id=".$d['request']['kelas_id']);
			}else{
				return redir("kbm/evaluasi_nilai/download?evaluasi_id=".$d['request']['evaluasi_id']);
			}
		}
		
	}
	
	public function force_finish($evaluasi_id, $ljs_id, $siswa_id) {
		$this->_set('kbm/evaluasi_tool/force_finish');
		
		if($this->m_kbm_evaluasi_tool->force_finish($evaluasi_id, $ljs_id, $siswa_id)){
			return redir("kbm/evaluasi/id/".$evaluasi_id);
		}
		
	}
	
	public function jadwal($index = 0) {
		$this->_set('kbm/evaluasi_tool/jadwal');
		
		$this->d['resultset'] 	= $this->m_kbm_evaluasi_tool->jadwal($index, 1000);
		$this->d['kelas'] 		= $this->m_dakd_kelas->browse($index, 1000);
		
		// $this->_dump();
		$this->_view();
	}

	public function pakta_integritas(){
		$d = & $this->d;
		
		$this->_set('kbm/evaluasi_tool/pakta_integritas');
		
		$keterangan_pakta_integritas = $this->m_app_config->get('keterangan_pakta_integritas');
		
		$keterangan_pakta_integritas2 = strtolower($keterangan_pakta_integritas);
		$keterangan_pakta_integritas2 = trim($keterangan_pakta_integritas2);
		$keterangan_pakta_integritas2 = str_replace(" ","_",$keterangan_pakta_integritas2);
		
		$value_pakta_integritas = strtolower($this->input->post('pakta_integritas'));
		$value_pakta_integritas = trim($value_pakta_integritas);
		$value_pakta_integritas = str_replace(" ","_",$value_pakta_integritas);
		
		$d['keterangan_pakta_integritas'] = $keterangan_pakta_integritas;
		//echo "aaaa".$d['keterangan_pakta_integritas'];
		if ($this->d['post_request'] && !$this->d['error'])
		{
			$id = $this->input->post('id');
			if ($keterangan_pakta_integritas2==$value_pakta_integritas)
			{
				$md5_id = MD5($id);
				/*
				?>
				<form id="myForm" action="<?=base_url()."kbm/evaluasi_ljs/form?id=".$id ?>" method="post">
				<?php
					echo '<input type="hidden" name="kode_id" value="'.$md5_id.'">';
					echo '<input type="hidden" name="ket_pakta_integritas" value="'.$this->input->post('pakta_integritas').'">';
					
				?>
				</form>
				<script type="text/javascript">
					document.getElementById('myForm').submit();
				</script>
				<?php
				*/
				return redir("kbm/evaluasi_ljs/form?id=".$id."&kode_id=".$md5_id."&ket_pakta_integritas=".$this->input->post('pakta_integritas'));
			}else{
				
				//echo ".".$keterangan_pakta_integritas2.".  a .".$value_pakta_integritas.".";
				return alert_error('Isian Pakta Salah, coba tulis kembali', 'kbm/evaluasi_tool/pakta_integritas?id='.$id);
			}
		}
		
		$this->_view();
	}
}