<?php

class M_nilai_siswa_absensi extends MY_Model
{

	public function __construct()
	{
		parent::__construct(array(
			
		));
		
		$this->dm['admin'] = cfguc_admin('akses', 'nilai', 'siswa');
		$this->dm['view'] = cfguc_view('akses', 'nilai', 'siswa');
		$this->dm['walikelas'] = (array) cfgu('walikelas');
		
	}


	function catatan_download_rapor()
	{
		$this->load->library('PHPExcel');
		$this->load->helper('excel');

		// deklarasi variabel

		if (TRUE):
			$d = & $this->ci->d;
			$dm = & $this->dm;
			$excel_source = APP_ROOT.'content/'.strtolower(APP_SCOPE).'/template/nilai_siswa_absensi.catatan_download_rapor.blank.xlsx';
			$nisis_query = array(
				'from'	 => 'nilai_siswa nisis',
				'join'	 => array(
					array('dprofil_siswa siswa', 'nisis.siswa_id = siswa.id', 'inner'),
					array('dakd_kelas kelas', 'nisis.kelas_id = kelas.id', 'inner'),
					array('dmst_agama agama', 'siswa.agama_id = agama.id', 'left'),
					array('record_download_rapor record', 'record.siswa_id = siswa.id ', 'left'),
					array('prd_semester semester', 'nisis.semester_id = semester.id', 'left'),
					array('dprofil_sdm kepsek', 'semester.kepsek_id = kepsek.id', 'left'),
					array('dprofil_sdm wali', 'kelas.wali_id = wali.id', 'left'),
				),
				'where'	 => array(
					'nisis.semester_id' => $d['semaktif']['id'],
				),
				'order_by'	 => 'kelas_nama asc, nisis.absen_no, siswa_nama asc',
				'group_by'	 => 'siswa_nis',
				'select' => array(
					'nisis.*',
					'time'			 => 'min(record.time)',
					'siswa_nis'		 => 'siswa.nis',
					'siswa_nama'	 => 'siswa.nama',
					'siswa_gender'	 => 'siswa.gender',
					'agama_nama'	 => 'agama.nama',
					'kelas_id'	 	 => 'kelas.id',
					'kelas_nama'	 => 'kelas.nama',
					'kelas_wali_id'	 => 'kelas.wali_id',
					'wali_nip'		 => 'wali.nip',
					'kepsek_nama'	 => 'kepsek.nama',
					'kepsek_nip'	 => 'kepsek.nip',
				),
			);
			$style = array(
				'default' => array(
					'borders'	 => array(
						'allborders' => array(
							'style' => PHPExcel_Style_Border::BORDER_THIN,
						),
					),
					'font'		 => array(
						'size' => 10,
					),
					'alignment'	 => array(
						'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
					),
				),
			);
			$cfg = array(
				'table.nisis' => array(
					// data pribadi
					'B'	 => array('id'),
					'C'	 => array('siswa_nis'),
					'D'	 => array('siswa_nama'),
					'E'	 => array('siswa_gender', 'strtoupper'),
				),
			);
			$nisis_data = array();
			$kelas_jml = 0;
			$sheet_index = 0;
			$excel_row_offset = 6;
			$wali_query = array(
				'select' => array(
					'id',
					'nama' => "trim(concat_ws(' ', prefix, nama, suffix))"
				),
				'from'	 => 'dprofil_sdm',
			);

		endif;

		// cek request

		$kelas_list = (array) $this->input->post('kelas');

		///print_r($kelas_list);
		array_autoint($kelas_list);
		
		$kelas_list = (array) array_intersect($kelas_list, array_keys($d['opsi_kelas']));

		if (empty($kelas_list))
			return alert_error('Pilih kelas yang hendak diolah.', 'nilai/siswa/impor_keterangan_walikelas');

		// ambil daftar nilai siswa

		$nisis_query['where_in']['kelas.id'] = $kelas_list;
		$nisis_result = $this->md->query($nisis_query)->result();
		$kelas_list = array();

		if ($nisis_result['selected_rows'] == 0)
			return alert_error('Daftar nilai dari kelas yang dipilih kosong/tidak ditemukan.', 'nilai/siswa/impor_keterangan_walikelas');

		// pengelompokan per kelas

		foreach ($nisis_result['data'] as $row):
			$kelas_id = (int) $row['kelas_id'];
			$nisis_data[$kelas_id]['data'][] = $row;

			if (!in_array($kelas_id, $kelas_list)):
				$wali_query['where_in']['id'][] = (int) $row['kelas_wali_id'];
				$nisis_data[$kelas_id]['wali_id'] = (int) $row['kelas_wali_id'];
				$nisis_data[$kelas_id]['kelas_id'] = $row['kelas_id'];
				$nisis_data[$kelas_id]['nama'] = $row['kelas_nama'];
				$nisis_data[$kelas_id]['semester'] = $row['semester_id'];
				
				$nisis_data[$kelas_id]['wali_nip'] = (int) $row['wali_nip'];
				$nisis_data[$kelas_id]['kepsek_nama'] = $row['kepsek_nama'];
				$nisis_data[$kelas_id]['kepsek_nip'] = $row['kepsek_nip'];
				
				$nisis_data[$kelas_id]['jumlah'] = 1;
				$kelas_list[] = $kelas_id;
				$kelas_jml++;

			else:
				$nisis_data[$kelas_id]['jumlah'] += 1;

			endif;

		endforeach;

		// cari data wali kelas

		$wali_array = $this->md->query($wali_query)->result_series('id', 'nama');

		// mulai buka excel

		$excel = PHPExcel_IOFactory::load($excel_source);

		if (!$excel)
			return exit('File source error.');

		// mulai isi data tiap kelas

		foreach ($kelas_list as $kelas_id):
			$sheet_index++;
			$data = & $nisis_data[$kelas_id];
			$row_start = $excel_row_offset + 1;
			$row_end = $excel_row_offset + $data['jumlah'];
			$sheet = clone $excel->getSheetByName('nilai_siswa');

			$sheet->setTitle($data['nama']);
			$excel->addSheet($sheet, $sheet_index);

			$sheet = $excel->setActiveSheetIndex($sheet_index);

			// tulis atribut kelas

			$sheet->setCellValue('A4', 'Kelas : ' . $data['nama']);
			$sheet->setCellValue('A5', 'Wali Kelas : ' . array_node($wali_array, $data['wali_id']));
			
			$sheet->setCellValue('C51', array_node($wali_array, $data['wali_id']));
			if(strlen($data['wali_nip'])<18)
			{$data['wali_nip']='-';}
			$sheet->setCellValue('C52', 'NIP. ' . $data['wali_nip']);
			
			$sheet->setCellValue('G51', $data['kepsek_nama']);
			$sheet->setCellValue('G52', 'NIP. ' .$data['kepsek_nip']);
			
			// tulis kelas n semester
			$sheet->setCellValue('B4', $data['kelas_id']);
			$sheet->setCellValue('B5', $data['semester']);

			// tulis tabel data

			$no = 0;
			$excel_row = $excel_row_offset;

			foreach ($data['data'] as $row):
				$no++;
				$excel_row++;

				$sheet->setCellValue('A' . $excel_row, $no);

				foreach ($cfg['table.nisis'] as $colexcel => $dat):
					$sheet->setCellValue($colexcel . $excel_row, data_cell($dat, $row));
				endforeach;

				$sheet->setCellValue('G' . $excel_row, tglwaktu($row['time']) );

			endforeach;

			// styling blok

			$sheet->getStyle("A{$row_start}:G{$row_end}")->applyFromArray($style['default']);

			// hide

			$sheet->getColumnDimension('B')->setVisible(FALSE);

			// lock
			$_cell_input = array(
				"G{$row_start}:H{$row_end}",
				"L{$row_start}:L{$row_end}"
				);
			
			excel_security_cell_lock($sheet, 'A1:M' . $row_end);
			excel_security_cell_unlock($sheet, $_cell_input);
			excel_security_sheet_lock($sheet);

		endforeach;

		// sembunyikan template

		$excel->removeSheetByIndex(0);

		// keamanan dokumen

		excel_security_doc_lock($excel);

		// output

		return excel_output_2007($excel, 'Catatan download rapor.xlsx');

	}
	
}