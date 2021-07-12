<?php

// KTSP

class Cm_nilai_pelajaran_ktsp extends MY_Model
{

	var $filetypes = array('xlsx');

	public function __construct()
	{
		parent::__construct();
		
		$this->dm['map.nilai.expor'] = array(
			
			'J'	 => 'kompetensi',
			'M'	 => 'uas',
			
			//// HARIAN ////
			'O'	 => 'u1',
			'P'	 => 'r1',
			
			'R'	 => 'u2',
			'S'	 => 'r2',
			
			'U'	 => 'u3',
			'V'	 => 'r3',
			
			'X'	 => 'u4',
			'Y'	 => 'r4',
			
			'AA'	 => 'u5',
			'AB'	 => 'r5',
			
			//// TUGAS ////
			'AJ'	 => 't1',
			'AK'	 => 't2',
			'AL'	 => 't3',
			'AM'	 => 't4',
			'AN'	 => 't5',
			
			//// PRAKTEK ///
			'AQ'	 => 'p1',
			'AR'	 => 'p2',
			'AS'	 => 'p3',
			'AT'	 => 'p4',
			'AU'	 => 'p5',
			
			//// SIKAP ////
			'AX'	 => 's1',
			
		);
		
		$this->dm['map.nilai.impor'] = array(
			
			'G'	 => 'nas_teori',
			'H'	 => 'pred_teori',
			'J'	 => 'kompetensi',
			'M'	 => 'uas',	
			
			//// HARIAN ////
			'O'	 => 'u1',
			'P'	 => 'r1',
			'Q'	 => 'h1',
			
			'R'	 => 'u2',
			'S'	 => 'r2',
			'T'	 => 'h2',
			
			'U'	 => 'u3',
			'V'	 => 'r3',
			'W'	 => 'h3',
			
			'X'	 => 'u4',
			'Y'	 => 'r4',
			'Z'	 => 'h4',
			
			'AA'	 => 'u5',
			'AB'	 => 'r5',
			'AC'	 => 'h5',
			
			//// TUGAS ////
			'AJ'	 => 't1',
			'AK'	 => 't2',
			'AL'	 => 't3',
			'AM'	 => 't4',
			'AN'	 => 't5',
			
			//// PRAKTEK ///
			'AQ'	 => 'p1',
			'AR'	 => 'p2',
			'AS'	 => 'p3',
			'AT'	 => 'p4',
			'AU'	 => 'p5',
			
			//// SIKAP ////
			'AX'	 => 's1',
		);

	}

	function upload($upload_path, $file_name)
	{
		// var
		$input = 'upload';

		$upload = array(
			'upload_path' => $upload_path,
			'file_name' => $file_name,
			'allowed_types' => '*',
			'max_size' => 8192,
			'overwrite' => TRUE,
		);

		// cek adanya upload
		if (!isset($_FILES[$input]) OR $_FILES[$input]['size'] <= 0)
		{
			return NULL;
		}

		// init library
		$this->load->library('upload');
		$this->upload->initialize($upload);

		// upload
		$do_upload = $this->upload->do_upload($input);

		// bila gagal
		if ($do_upload == FALSE)
		{
			return alert_error($this->upload->display_errors());
		}

		// data file yg diupload
		$file = $this->upload->data();

		// menganti absolute path menjadi relative
		$file['file_path'] = path_relative($file['file_path']);
		$file['full_path'] = path_relative($file['full_path']);

		// ekstensi yg diupload
		$upload_ext = trim($file['file_ext'], ' .');

		// bila file bukan excel
		if (!in_array($upload_ext, $this->filetypes))
		{
			@unlink($file['full_path']);

			return alert_error('Tipe file tidak sesuai. Seharusnya berekstensi: ' . implode(', ', $this->filetypes));
		}

		// mengembalikan data upload
		return $file;

	}

	function storage_path($nipel_id)
	{
		// alamat folder
		$path = APP_ROOT."content/".strtolower(APP_SCOPE)."/nilai-pelajaran/{$nipel_id}/";

		// siapkan folder
		if (file_exists($path) == FALSE)
		{
			try
			{
				mkdir($path, 0775, TRUE);
			}
			catch (Exception $e)
			{
				chmod($path, 0775);

				alert_error("Folder penyimpanan error, coba beberapa saat lagi.<br/>" . $e->getMessage());
			}
		}

		// kembalikan path folder
		return $path;

	}

	function expor()
	{
		$this->load->library('PHPExcel');

		if (TRUE)
		{
			$d = & $this->ci->d;
			$dm = & $this->dm;
			$tgl = $this->ci->d['dto']->format('d/m/Y');
			$nama_semester = strtoupper($d['row']['semester_nama']);
			$ta_semester = strtoupper($d['row']['ta_nama']);
			$acc['admin'] = cfguc_admin('akses', 'nilai', 'pelajaran');
			$acc['view'] = cfguc_view('akses', 'nilai', 'pelajaran');
			$kelas_jml = 0;
			$sheet_no = 0;
			$data = array();
			$kelas_list = array();
			$excel_row_offset = 10;
			
			//agama , pkn
			$agama_pkn = array('4','5', '8','44');
			//penjas, KPPI
			$kkpi_or = array('18','49');
			//normatif // adaptif // mulok
			$array_normatif = array('9','10','2');
			//produktif
			$array_produktif = array('11');
			
			
			$jenis_aspek="";
			///// MAPEL ID
			if(in_array($d['row']['mapel_id'], $agama_pkn))
			{	$jenis_aspek = 'agama_pkn';	}
			elseif(in_array($d['row']['mapel_id'], $kkpi_or))
			{	$jenis_aspek = 'kkpi_or';	}
			///// KATEGORI MAPEL ID
			elseif(in_array($d['row']['kategori_id'], $array_normatif))
			{	$jenis_aspek = 'normatif';	}
			elseif(in_array($d['row']['kategori_id'], $array_produktif))
			{	$jenis_aspek = 'produktif';	}
			
			
			$excel_source = $this->expor_template($d['row']['id'], $jenis_aspek);

			$wali_query = array(
				'select' => array(
					'id',
					'nama' => "trim(concat_ws(' ', prefix, nama, suffix))"
				),
				'from' => 'dprofil_sdm',
			);

			$cfg = array(
				'row.nipel' => array(
					'A1' => array('id'),
					'C2' => array('guru_nama'),
					'C3' => array(
						'mapel_nama',
						'suffix' => array(
							' [ ',
							'kategori_nama',
							' ]',
						),
					),
					'C4' => array('kkm'),
					'M56' => array('guru_nama'),
					'M57' => array('guru_nip','prefix' => 'Nip. '),
				),
				'row.kelas' => array(
					'G2' => array(
						'nama',
						'prefix' => 'Kelas ',
					),
					'G3' => array(
						'didownload ' . $tgl,
					),
					'C1' => array(
						'DAFTAR NILAI SISWA '.TITLE_LOGIN.' SEMESTER '.$nama_semester.' TAHUN PELAJARAN '.$ta_semester,
					),
					'K2' => array(
						'grade',
					),
					'L2' => array(
						strtoupper($nama_semester),
					),
				),
				'table.nisispel' => array(
					'B' => array('id'),
					'C' => array('siswa_nama'),
				),
				'baris.invicible' => array(5, 6),
				'kolom.invicible' => array('B'),
				
				'kolom.invicible.teori' => array(
					// PROSES 
					 
				),
				'kolom.invicible.praktek' => array(
					// PROSES 
					
				),
				'kolom.invicible.sikap' => array(
					
				),
			);
		}
		
		$table_nisispel = array(
				
				
		);
		//$cfg['table.nisispel'] = array_merge($cfg['table.nisispel'], $table_nisispel);
		$cfg['table.nisispel'] = array_merge($cfg['table.nisispel'], $dm['map.nilai.expor']);
		// mengelompokkan data nilai siswa per kelas

		foreach ($d['resultset']['data'] as $_row)
		{

			$_kls_id = (int) $_row['kelas_id'];

			if (isset($data[$_kls_id]['jml']))
			{
				$data[$_kls_id]['jml'] = $data[$_kls_id]['jml'] + 1;
			}
			else
			{
				$kelas_jml++;
				$data[$_kls_id]['jml'] = 1;
				$data[$_kls_id]['kelas_nilai_id'] = $_row['kelas_nilai_id'];
				$data[$_kls_id]['nama'] = $_row['kelas_nama'];
				$data[$_kls_id]['grade'] = $_row['kelas_grade'];
				$data[$_kls_id]['wali_id'] = (int) $_row['kelas_wali_id'];
				$wali_query['where_in']['id'][] = (int) $_row['kelas_wali_id'];
				$kelas_list[] = $_kls_id;
			}

			$data[$_kls_id]['data'][] = $_row;
		}

		// cari data wali kelas

		$wali_array = $this->md->query($wali_query)->result_series('id', 'nama');

		foreach ($kelas_list as $_kls_id)
		{
			$data[$_kls_id]['wali_nama'] = (string) array_node($wali_array, $data[$_kls_id]['wali_id']);
		}

		// mulai buka excel

		$excel_obj = PHPExcel_IOFactory::load($excel_source) OR die('Error pada template excel.');

		// mulai isi data tiap kelas

		$_cell_input = array(
					/// kompetensi UAS
					"J11:J60", "M11:M60",
					
					/// harian
					"O11:P60","R11:S60","U11:V60","X11:Y60","AA11:AB60",
					/// tugas
					"AJ11:AN60",
					/// praktek
					"AQ11:AU60",
					/// sikap
					"AX11:AX60",
					
					/// rentang
					"AZ14:BB17",
			);
			
			$_cell_input[] = "C4";

		foreach ($kelas_list as $_kls_id)
		{
			// variabel
			$sheet_no++;
			$data_kelas = & $data[$_kls_id];

			// copy template
			$_sheet = clone $excel_obj->getSheetByName('nilai_pelajaran');

			$_sheet->setTitle($data_kelas['nama']);
			$excel_obj->addSheet($_sheet, $sheet_no);

			$_sheet = $excel_obj->setActiveSheetIndex($sheet_no);

			// tulis data
			excel_row_write($_sheet, $d['row'], $cfg['row.nipel']);
			excel_row_write($_sheet, $data_kelas, $cfg['row.kelas']);
			excel_table_write($_sheet, $data_kelas['data'], $cfg['table.nisispel'], $excel_row_offset, 'A');

			// sembunyikan kolom & baris data sistem

			foreach ($cfg['baris.invicible'] as $_no)
			{
				$_sheet->getRowDimension($_no)->setVisible(FALSE);
			}

			foreach ($cfg['kolom.invicible'] as $_col)
			{
				$_sheet->getColumnDimension($_col)->setVisible(FALSE);
			}
			
			foreach ($cfg['kolom.invicible.teori'] as $_col)
				$_sheet->getColumnDimension($_col)->setVisible(FALSE);

			foreach ($cfg['kolom.invicible.praktek'] as $_col)
				$_sheet->getColumnDimension($_col)->setVisible(FALSE);

			foreach ($cfg['kolom.invicible.sikap'] as $_col)
				$_sheet->getColumnDimension($_col)->setVisible(FALSE);
			
			
			excel_security_cell_lock($_sheet, 'A1:FA72');
			excel_security_cell_unlock($_sheet, $_cell_input);

			// kunci sheet

			excel_security_sheet_lock($_sheet);
			
		}
		
		
				
		// hapus sheet template
		$excel_obj->removeSheetByIndex(0);

		// output
		return excel_output_2007($excel_obj, "{$d['row']['pelajaran_nama']}.xlsx");

	}

	function expor_template($nipel_id,$jenis_aspek='')
	{
		// pilihan file
		$folder = $this->storage_path($nipel_id);
		$template_pelajaran = $folder . "template_ktsp.xlsx";
		$tamplate_nipel = APP_ROOT."content/".strtolower(APP_SCOPE)."/nilai-pelajaran/";
		
		$template_kurikulum = $tamplate_nipel."template_ktsp.xlsx";
		$template_global = APP_ROOT."content/".strtolower(APP_SCOPE)."/template/nipel-flexible-2013.xlsx";

		if($jenis_aspek!='')
		{
			$template_kurikulum = $tamplate_nipel."template_ktsp_".$jenis_aspek.".xlsx";	
		}
		// memilih template

		if (file_ada($template_pelajaran))
		{
			return $template_pelajaran;
		}

		if (file_ada($template_kurikulum))
		{
			return $template_kurikulum;
		}

		return $template_global;

	}

	function impor()
	{
		$d = & $this->ci->d;
		$dm = & $this->dm;
		$this->form->get();

		if ($d['error'])
		{
			return FALSE;
		}

		// upload
		$upload_path = $this->storage_path($d['row']['id']);
		$file_name = "nilai.xlsx";
		$upload = $this->upload($upload_path, $file_name);

		if ($d['error'])
		{
			return FALSE;
		}

		// load file

		$this->load->library('PHPExcel');

		try
		{
			$upload['full_path'] = APP_ROOT.$upload['full_path'];
			chmod($upload['full_path'], 0777);
			$PHPExcel = PHPExcel_IOFactory::load($upload['full_path']);
		}
		catch (Exception $exc)
		{
			$message = "File excel tak dapat dibaca.<br/>" . NL
				. print_r($exc->getMessage(), TRUE);

			@unlink($upload['full_path']);
			return alert_error($message);
		}

		$sheet_jml = $PHPExcel->getSheetCount();

		if ($sheet_jml < 1)
		{
			@unlink($upload['full_path']);
			return alert_error('Sheet/halaman tidak dapat dibaca.');
		}

		if ($d['error'])
		{
			@unlink($upload['full_path']);
			return FALSE;
		}

		// deklarasi variabel

		if (TRUE)
		{
			$acc['admin'] = cfguc_admin('akses', 'nilai', 'pelajaran');
			$acc['view'] = cfguc_view('akses', 'nilai', 'pelajaran');
			$data_nipel = array();
			$data_nisispel = array();
			$cfg = array(
				'kkm' => 'C4',
				'kolom.nilai' => array(
					//'nas_total' => 'E',
					
				),
			);
		}

		// ambil data nilai pelajaran

		$sheet = $PHPExcel->setActiveSheetIndex(0);

		try
		{
			$pelajaran_nilai_id = $sheet->getCell('A1')->getValue();
		}
		catch (Exception $ex)
		{
			$pelajaran_nilai_id = 0;
		}

		if ($d['row']['id'] != $pelajaran_nilai_id)
		{
			unset($PHPExcel);
			@unlink($upload['full_path']);
			return alert_error('Anda tidak dapat mengimpor dari file excel pelajaran lain atau semester sebelumnya.');
		}

		// ambil data kkm
		try
		{
			$data_nipel['kkm'] = $sheet->getCell($cfg['kkm'])->getValue();
		}
		catch (Exception $ex)
		{

		}

		// tentukan daftar nilai yg diambil
		//$nilai_map = $cfg['kolom.nilai'];
		$nilai_map = $dm['map.nilai.impor'];

		// mulai ambil data nilai tiap sheet
		$nisispel_list = array();
		$nisispel_jml = 0;

		for ($_sheet_index = 0; $_sheet_index < $sheet_jml; $_sheet_index++)
		{
			$sheet = $PHPExcel->setActiveSheetIndex($_sheet_index);
			$row_max = $sheet->getHighestRow();
			$row_start = 11;

			if ($row_max > 512)
			{
				$row_max = 512;
			}

			for ($_row_no = $row_start; $_row_no < $row_max; $_row_no++)
			{
				try
				{
					$_nisispel_id = $sheet->getCell('B' . $_row_no)->getValue();
				}
				catch (Exception $ex)
				{
					continue;
				}

				if (empty($_nisispel_id) OR is_numeric($_nisispel_id) == FALSE OR $_nisispel_id < 1)
				{
					continue;
				}

				$nisispel_list[] = $_nisispel_id;
				$_row = array();

				foreach ($nilai_map as $_excel_col => $_db_col)
				{
					try
					{
						$_cell = $_excel_col . $_row_no;
						$_nilai = $sheet->getCell($_cell)->getCalculatedValue();
						//$_row[$_db_col] = (empty($_nilai) == FALSE) ? $_nilai : NULL;
						$_row[$_db_col] = $_nilai;
					}
					catch (Exception $ex)
					{
						$_row[$_db_col] = NULL;
					}
				}

				$data_nisispel[$_nisispel_id] = $_row;
				$nisispel_jml++;
			}
		}

		// selesai extract data, tutup file
		unset($sheet);
		$PHPExcel->disconnectWorksheets();
		unset($PHPExcel);

		// cek data yg terbaca
		if ($nisispel_jml < 1)
		{
			alert_error('Daftar Nilai siswa kosong atau tidak terbaca.');
		}
		else
		{
			$nilsis_series = $this->m_nilai_siswa_pelajaran->nilsis_series($nisispel_list);

			if (empty($nilsis_series))
			{
				alert_error('Daftar nilai yang akan diperbarui tidak terbaca.');
			}
		}

		// cekpoin untuk error

		if ($d['error'])
		{
			@unlink($upload['full_path']);
			return FALSE;
		}

		// reset data rata2

		$data_nipel['valid'] = 0;

		//mulai operasi database
		$this->db->trans_begin();

		// pembaruan info nipel & nilai_siswa_pelajaran
		$this->db->update('nilai_pelajaran', $data_nipel, array('id' => $d['row']['id']));

		// update masing2 nilai siswa
		foreach ($data_nisispel as $nisispel_id => $nisispel)
		{
			$this->db->update('nilai_siswa_pelajaran', $nisispel, array('id' => $nisispel_id));
		}

		// commit database
		$this->trans_done('Daftar nilai telah diperbarui.', 'Database error saat memperbarui nilai siswa.');

		// cek error
		if ($d['error'])
		{
			return FALSE;
		}

		// update rata2 nilai pelajaran kelas
		$this->m_nilai_pelajaran_kelas->reratareset_by_nipel($d['row']['id']);

		// update rata2 nilai siswa
		$this->m_nilai_siswa->reratareset_by_nipel($d['row']['id']);

		// selesai
		return !$d['error'];

	}

	function template_pelajaran()
	{
		$d = & $this->ci->d;
		$this->form->get();

		if ($d['error'])
		{
			return FALSE;
		}

		// upload
		$upload_path = $this->storage_path($d['row']['id']);
		$file_name = "template_ktsp.xlsx";

		$this->upload($upload_path, $file_name);

		// selesai
		if ($d['error'])
		{
			return alert_error("Template gagal disimpan.");
		}
		else
		{
			return alert_success("Template berhasil disimpan.");
		}

	}

	function template_sekolah()
	{
		$d = & $this->ci->d;
		$this->form->get();

		if ($d['error'])
		{
			return FALSE;
		}

		// upload
		$upload_path = APP_ROOT."content/".strtolower(APP_SCOPE)."/nilai-pelajaran/";
		$file_name = "template_ktsp.xlsx";

		$this->upload($upload_path, $file_name);

		// selesai
		if ($d['error'])
		{
			return alert_error("Template gagal disimpan.");
		}
		else
		{
			return alert_success("Template berhasil disimpan.");
		}

	}

}
