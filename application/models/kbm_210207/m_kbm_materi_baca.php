<?php

class M_kbm_materi_baca extends MY_Model {

	public function __construct() {
		parent::__construct(array(
			'fields_nilai_pembaca' => array(
				'nilai',
			),
		));
	}

	//

	function insert($materi_id) {
		$data = array(
				'materi_id' => $materi_id,
				'user_id' => $this->ci->d['user']['id'],
				'baca_waktu' => $this->ci->d['datetime'],
				'baca_count' => 1,
		);
		$sqlupdate = "update kbm_materi set siswa_total = siswa_total + 1, siswa_baca = siswa_baca + 1 where id = {$materi_id}";

		$this->db->trans_start();
		$this->db->insert('kbm_materi_baca', $data);

		$data['id'] = $this->db->insert_id();
		$data['respon_waktu'] = NULL;
		$data['respon_jawaban'] = NULL;

		$this->db->query($sqlupdate);
		$this->db->trans_commit();

		return $data;
	}

	//

	function browse($materi_id, $index = 0, $limit = 50) {
		$r = $this->ci->d['request'];
		$select = array(
				'komentar_registered' 	=> 'MAX(komentar.registered)',
				'komentar_konten' 	  	=> 'komentar.konten',
				'komentar_author_nama' 	=> 'user.nama',
				'baca.*',
				'siswa_id' 				=> 'siswa.id',
				'siswa_nis' 			=> 'siswa.nis',
				'siswa_nisn'	 		=> 'siswa.nisn',
				'siswa_nama' 			=> 'siswa.nama',
				'siswa_gender' 			=> 'siswa.gender',
				'siswa_aktif' 			=> 'siswa.aktif',
				'siswa.kelas_id',
				'kelas_nama' 			=> 'kelas.nama',
		);
		$this->md
					->select($select)
					->from('kbm_materi_baca baca')
					->join('dprofil_siswa siswa', 'baca.user_id = siswa.id', 'inner')
					->join('dakd_kelas kelas', 'siswa.kelas_id = kelas.id', 'inner')
					->join('kbm_materi_komentar komentar', 'komentar.kbm_materi_id = baca.materi_id AND komentar.pembaca_id = baca.id', 'left')
					->join('data_user user', 'user.id = komentar.author_id', 'left')
					->where('baca.materi_id', $materi_id)
					->group_by('baca.id')
					->order_by('kelas.nama, siswa.nama');

		// filter

		if (isset($r['term']) && strlen($r['term']) > 0)
			$this->md->like($r['term'], 'siswa.nama');

		if (isset($r['kelas_id']) && $r['kelas_id'] > 0)
			$this->db->where('siswa.kelas_id', $r['kelas_id']);

		if (isset($r['status_baca'])):
			if ($r['status_baca'] == 'sudah')
				$this->db->where('respon_waktu is not null');

			else if ($r['status_baca'] == 'belum')
				$this->db->where('respon_waktu is null');

		endif;

		// hasil

		return $this->md->resultset($index, $limit);
	}

	function query_1()
	{
		return array(
			'select' => array(
				'baca.*',
				'siswa_id' 		=> 'siswa.id',
				'siswa_nis' 	=> 'siswa.nis',
				'siswa_nisn' 	=> 'siswa.nisn',
				'siswa_nama' 	=> 'siswa.nama',
				'siswa_gender' 	=> 'siswa.gender',
				'siswa_aktif' 	=> 'siswa.aktif',
				'siswa.kelas_id',
				'kelas_nama' 	=> 'kelas.nama',
				'materi_id'		=> 'materi.id',
				'materi_nama'	=> 'materi.nama',
				'pertanyaan'	=> 'materi.pertanyaan',
			),
			'from'	 => 'kbm_materi_baca baca',
			'join'	 => array(
				array('dprofil_siswa siswa', 'baca.user_id = siswa.id', 'inner'),
				array('dakd_kelas kelas', 'siswa.kelas_id = kelas.id', 'inner'),
				array('kbm_materi materi', 'materi.id = baca.materi_id', 'inner'),
			),
			
			
		);

	}
	
	function query_2()
	{
		return array(
			'select' => array(
				'komentar_registered' 	=> 'komentar.registered',
				'komentar_konten' 	  	=> 'komentar.konten',
				'komentar_author_nama' 	=> 'user.nama',
				
				'siswa_id' 				=> 'siswa.id',
				'siswa_nis' 			=> 'siswa.nis',
				'siswa_nisn'	 		=> 'siswa.nisn',
				'siswa_nama' 			=> 'siswa.nama',
				'siswa_gender' 			=> 'siswa.gender',
				'siswa_aktif' 			=> 'siswa.aktif',
				'siswa.kelas_id',
				'kelas_nama' 			=> 'kelas.nama',
			),
			'from'	=> 'kbm_materi materi',
			'join'	=> array(
						array('kbm_materi_komentar komentar', 'komentar.kbm_materi_id = materi.id', 'inner'),
						array('data_user user', 'user.id = komentar.author_id', 'inner'),
						array('dprofil_siswa siswa', 'komentar.author_id = siswa.id', 'left'),
						array('dakd_kelas kelas', 'siswa.kelas_id = kelas.id', 'left'),
						
						
					),
			
			'order_by'=> 'komentar_registered DESC'
		);
		
	}
	
	function rowset($id)
	{
		$query = $this->query_1();
		$query['where']['baca.id'] = $id;

		return $this->md->query($query)->row();

	}
	
	function komentar($id, $pembaca_id=0)
	{
		$query = $this->query_2();
		
		if($pembaca_id>0){
			$query['join'][] = array('kbm_materi_baca baca','komentar.pembaca_id = baca.id', 'inner');
		}
		$query['where']['komentar.pembaca_id'] = $pembaca_id;
		$query['where']['materi.id'] = $id;

		return $this->md->query($query)->resultset();

	}
	
	function save_komentar($id, $pembaca_id=""){
		$d = & $this->ci->d;

		if (!$d['row'])
			return;

		//if ($d['row']['respon_jawaban'])
			//return alert_info('Jawaban telah disimpan sebelumnya.');

		$this->form->get();

		if ($d['error'])
			return;

		$this->form->ruleset($d['row'], 'validasi');
		$this->form->validate();

		if ($d['error'])
			return;

		$respon = (string) $this->input->post('komentar');
		// clean FROALA ////
		$respon = str_replace('<p data-f-id="pbf" style="text-align: center; font-size: 14px; margin-top: 30px; opacity: 0.65; font-family: sans-serif;">
		Powered by <a href="https://www.froala.com/wysiwyg-editor?pb=1" title="Froala Editor">Froala Editor</a></p>','',$respon);
		$respon = str_replace('Powered by <a href="https://www.froala.com/wysiwyg-editor?pb=1" title="Froala Editor">Froala Editor</a>','',$respon);
		
		$respon = str_replace('Froala Editor','',$respon);
		$respon = str_replace('Powered by','',$respon);
		
		/////////////////
		
		$data['kbm_materi_id'] = $id;
		$data['author_id'] 	= $d['user']['id'];
		if($pembaca_id==''){
			$pembaca_id=0;
		}
		$data['pembaca_id'] = $pembaca_id;
		$data['konten'] 	= base64_encode($respon);
		$data['registered'] = $d['datetime'];
		
		$this->db->trans_start();
		$this->db->insert('kbm_materi_komentar', $data);

		$success = $this->trans_done('Jawaban berhasil disimpan.', 'Database error, jawaban belum tersimpan.');

		if (!$success)
			return;

	}
	
	function query_record_vidcall($id){
		
		$query = array(
				'from' => 'kbm_materi_record_vidcall',
				'select' => array(
						'*',
				),
		);
		
		$query['where']['id'] = $id;
		
		return $query;
	}
	
	function save_first_record_vidcall($kbm_materi_id ){
		
		$d = & $this->ci->d;
		
		$_raw = array(
			'kbm_materi_id'	=> $kbm_materi_id,
			'role'			=> $d['user']['role'],
			'user_id'		=> $d['user']['id'],
			'modified'		=> date('Y-m-d H:i:s'),
			'registered'	=> date('Y-m-d H:i:s'),
			'total_waktu'	=> 0,
			'aktif'			=> 1,
			);
			
		$this->db->trans_start();
		
		$this->db->insert('kbm_materi_record_vidcall' ,$_raw );
		$insert_id = $this->db->insert_id();
		
		$this->db->trans_complete();
		
		return $insert_id;
	}
	
	function save_record_vidcall(){
		
		$id_record_vidcall 	= $this->input->post('id_record_vidcall');
		
		if($id_record_vidcall==''){
			$response['warna'] = '#FF4444';	
			$response['message'] = 'Waktu video call GAGAL di simpan, coba "REFRESH" halaman ini dan cek "INTERNET".';	
		}else{
			
			$query = $this->query_record_vidcall($id_record_vidcall);
			$hasil = $this->md->query($query)->row();
			
			$_raw = array(
				'id'			=> $id_record_vidcall,
				'total_waktu'	=> ($hasil['total_waktu']+1),
				'modified' 		=> date('Y-m-d H:i:s'),
				);
			
			
			$this->db->trans_start();
			
			$this->db->where('id', $id_record_vidcall);
			$this->db->update('kbm_materi_record_vidcall', $_raw); 
					
			$this->db->trans_complete();
			
			if ($this->db->trans_status() === FALSE){
				$response['warna'] = '#FF4444';	
				$response['message'] = 'Waktu video call GAGAL di simpan, coba "REFRESH" halaman ini dan cek "INTERNET".';	
			}else{	
				$response['warna'] = '#00AAFF';	
				$response['message'] = 'Waktu baca berhasil di simpan.';	
			}
			
			$this->trans_done();
		}
		
		return $response;

	}
	
	function save_nilai_pembaca()
	{
		$d = & $this->ci->d;

		$this->form->ruleset($d['row'], 'validasi');
		$this->form->validate();

		if ($d['error'])
		{
			return FALSE;
		}

		$data = $this->inputset('fields_nilai_pembaca');

		return $this->update($data, $d['form']['id']);

	}
	
	function update($data, $id)
	{

		$this->db->trans_start();

		$this->db->update('kbm_materi_baca', $data, array('id' => $id));

		return $this->trans_done('Data materi siswa berhasil diperbarui.', 'Database error, coba beberapa saat lagi.');

	}
	
	function jawab() {
		$d = & $this->ci->d;

		if (!$d['row'])
			return;

		//if ($d['row']['respon_jawaban'])
			//return alert_info('Jawaban telah disimpan sebelumnya.');

		$this->form->get();

		if ($d['error'])
			return;

		$this->form->ruleset($d['row'], 'validasi');
		$this->form->validate();

		if ($d['error'])
			return;

		$respon = (string) $this->input->post('respon_jawaban');
		// clean FROALA ////
		$respon = str_replace('<p data-f-id="pbf" style="text-align: center; font-size: 14px; margin-top: 30px; opacity: 0.65; font-family: sans-serif;">
		Powered by <a href="https://www.froala.com/wysiwyg-editor?pb=1" title="Froala Editor">Froala Editor</a></p>','',$respon);
		$respon = str_replace('Powered by <a href="https://www.froala.com/wysiwyg-editor?pb=1" title="Froala Editor">Froala Editor</a>','',$respon);
		
		$respon = str_replace('Froala Editor','',$respon);
		$respon = str_replace('Powered by','',$respon);
		
		/////////////////
		
		$data['respon_waktu'] = $d['datetime'];
		$data['respon_cuplikan'] = (string) substr(strip_tags($respon), 0, 100);
		$data['respon_jawaban'] = base64_encode($respon);

		$this->db->trans_start();
		$this->db->update('kbm_materi_baca', $data, array('id' => $d['row']['baca_id']));

		$success = $this->trans_done('Jawaban berhasil disimpan.', 'Database error, jawaban belum tersimpan.');

		if (!$success)
			return;

		$d['row']['respon_waktu'] = $data['respon_waktu'];
		$d['row']['respon_cuplikan'] = $data['respon_cuplikan'];
		$d['row']['respon_jawaban'] = $respon;

		$this->update_stat($d['row']['id']);
	}

	function update_stat($materi_id) {
		$materi_id = (int) $materi_id;
		$sql = "
update kbm_materi materi
inner join
(
	select
		materi_id,
		count(id) siswa_total,
		count(baca_waktu) siswa_baca,
		count(respon_waktu) siswa_respon
	from kbm_materi_baca
	where materi_id = ?
	group by materi_id
)	baca
	on materi.id = baca.materi_id
set
	materi.siswa_total = baca.siswa_total,
	materi.siswa_baca = baca.siswa_baca,
	materi.siswa_respon = baca.siswa_respon
where
	materi.id = ?";

		$this->db->query($sql, array($materi_id, $materi_id));
	}

	function nama_file($id){
		
		$query = array(
				'select' => array(
						'materi.*',
						'pengajar'		=> 'sdm.nama',
						'semester_nama'	=> 'semester.nama',
						'ta_nama'		=> 'ta.nama',
						
				),
				'from' => 'kbm_materi materi',
				'join' => array(
						array('dakd_pelajaran pelajaran', 'materi.pelajaran_id = pelajaran.id', 'inner'),
						array('dprofil_sdm sdm', 'pelajaran.guru_id = sdm.id', 'inner'),
						array('prd_semester semester', 'materi.semester_id = semester.id', 'inner'),
						array('prd_ta ta', 'semester.ta_id = ta.id', 'inner'),
				),
		);
		
		$query['where']['materi.id'] = $id;
		
		return $this->md->query($query)->resultset(0, 1);
	}
	
	function download_nilai($id) {
		$d = & $this->ci->d;
		$d['resultset'] = $this->browse($id, 0, 10240);
		
		$nama_file = $this->nama_file($id);
		$this->load->helper('excel');
		
		$fallback = 'kbm/evaluasi_nilai' . array2qs();
		$no = 0;
		$awal_rowexcel = 5;
		$rowexcel = $awal_rowexcel;
		
		//$file_path = 'content/template/kbm-evaluasi-nilai.xls';
		$file_path = APP_ROOT."content/".strtolower(APP_SCOPE)."/template/kbm-evaluasi-nilai.xls";
		$map = array(
				'B' => 'kelas_nama',
				'C' => 'siswa_nama',
				'D' => 'siswa_gender',
				'E' => 'nilai',
				
		);

		
		if ($d['resultset']['selected_rows'] == 0)
			return alert_error('Data nilai kosong, periksa filter pencarian Anda.', $fallback);

		$this->load->library('PHPExcel');

		$objPHPExcel = PHPExcel_IOFactory::load($file_path);
		$style_border = array(
				'borders' => array(
						'allborders' => array(
								'style' => PHPExcel_Style_Border::BORDER_THIN
						)
				)
		);
		$style_nilai = array(
				'alignment' => array(
						'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
				),
		);
		$styleGreen = array(
			'fill' => array(
				'type'	 => PHPExcel_Style_Fill::FILL_SOLID,
				'color'	 => array('rgb' => '66FF99'),
			)
		);
		
		$styleYellow = array(
			'fill' => array(
				'type'	 => PHPExcel_Style_Fill::FILL_SOLID,
				'color'	 => array('rgb' => 'FFFF66'),
			)
		);
		
		$styleRed = array(
			'fill' => array(
				'type'	 => PHPExcel_Style_Fill::FILL_SOLID,
				'color'	 => array('rgb' => 'DD9898'),
			)
		);
		
		$styleGrey = array(
			'fill' => array(
				'type'	 => PHPExcel_Style_Fill::FILL_SOLID,
				'color'	 => array('rgb' => '808080'),
			)
		);
		
		if (!$objPHPExcel)
			return alert_error('Excel error.', $fallback);

		$sheet = $objPHPExcel->setActiveSheetIndex(0);
		
		$sheet->getColumnDimension('F')->setVisible(FALSE);
		$sheet->getColumnDimension('G')->setVisible(FALSE);
		
		
		$excel_col_offset = ord('Z') - 65;
		$col_no = $excel_col_offset;
		
	
		$cfg = array(
				'row.nikls'		 => array(
					// top header
					'A1' => array(
						'nama',
						'strtoupper',
						'prefix' => 'NAMA MATERI : ',
					),
					'A2' => array(
						'pengajar',
						'strtoupper',
						'prefix' => 'GURU : ',
					),
					'A3' => array(
						'semester_nama',
						'strtoupper',
						'prefix' => 'SEMESTER  ',
						'suffix' => array(
							' TAHUN ',
							'ta_nama',
						),
					),
				),
			);
		
		excel_row_write($sheet, $nama_file['data'][0], $cfg['row.nikls']);
		
					
		$jml_soal=0;
		
		$awal_coloumn = "AQ";
		$awal_merge = $awal_coloumn.'4';
		$tampil_kd=1;
		$last_excol='';
		//print_r($d['soal_array']);
		
				
		

		
		// mulai isi nilai
		
		$judul_kelas_nama='kosong';
		//print_r($d);
		foreach ($d['resultset']['data'] as $row):

			$no++;
			$rowexcel++;
			
			$judul_kelas_nama = $row['kelas_nama'];
			
			$sheet->setCellValue("A" . $rowexcel, $no);
			
			foreach ($map as $colex => $coldb):
				
				if($row['nilai']==''){
					$row['nilai']='kosong';
				}
				$sheet->setCellValue($colex . $rowexcel, $row[$coldb]);

			endforeach;
			
			
			
			
		
		endforeach;
		
		
		$set_font = 8;
		$max_coloumn='F';
		
		// format font size
		$sheet->getStyle("A1:G4")->getFont()->setBold(true);
		//$sheet->getStyle("A1:F70")->getFont()->setSize($set_font);
		$sheet->getStyle("A1:".$max_coloumn.$rowexcel)->getFont()->setSize($set_font);
		
		// format garis & align
		$sheet->getStyle("A1:G4")->getFont()->setBold(true);
		$sheet->getStyle("A5:F5")->getFont()->setBold(true);
		$sheet->getStyle("A5:".$max_coloumn.$rowexcel)->applyFromArray($style_border);
		$sheet->getStyle("E5:".$max_coloumn.$rowexcel)->applyFromArray($style_nilai);
		
		
		// output file 
		header("Content-Type: application/vnd.ms-excel");
		//header("Content-Disposition: attachment; filename=\"nilai_evaluasi_{$d['request']['evaluasi_id']}.xls\"");
		$judul_kelas_nama='0';
		if($d['request']['kelas_id']){
			$sheet->setCellValue('E2','Kelas : '.$judul_kelas_nama);
			$sheet->getColumnDimension('B')->setVisible(FALSE);
			header("Content-Disposition: attachment; filename=\"nilai_materi_{$nama_file['data'][0]['nama']}_{$nama_file['data'][0]['pengajar']}_({$judul_kelas_nama}).xls\"");
		}else{
			header("Content-Disposition: attachment; filename=\"nilai_materi_{$nama_file['data'][0]['nama']}_{$nama_file['data'][0]['pengajar']}.xls\"");
		}
		header("Cache-Control: max-age=0");
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, "Excel5");
		$objWriter->save("php://output");
		exit();
	}
}

