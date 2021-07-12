<?php

// 2013

class Cm_nilai_pelajaran extends MY_Model
{

	var $filetypes = array('xlsx');

	public function __construct()
	{
		parent::__construct();
		
		$this->dm['map.nilai.expor'] = array(
			'P' => 'uts',
			'Q' => 'uas',
			
			//Pengetahuan//
			'S'		=>	'u1',
			'V'		=>	'u2',
			'Y'		=>	'u3',
			'AB'	=>	'u4',
			'AE'	=>	'u5',
			'AH'	=>	'u6',
			'AK'	=>	'u7',
			'AN'	=>	'u8',
			'AQ'	=>	'u9',
			'AT'	=>	'u10',
			
			'T'		=>	'r1',
			'W'		=>	'r2',
			'Z'		=>	'r3',
			'AC'	=>	'r4',
			'AF'	=>	'r5',
			'AI'	=>	'r6',
			'AL'	=>	'r7',
			'AO'	=>	'r8',
			'AR'	=>	'r9',
			'AU'	=>	'r10',
			
			'BH'	=>	't1',
			'BI'	=>	't2',
			'BJ'	=>	't3',
			'BK'	=>	't4',
			'BL'	=>	't5',
			'BM'	=>	't6',
			'BN'	=>	't7',
			'BO'	=>	't8',
			'BP'	=>	't9',
			'BQ'	=>	't10',
			
			//Praktek
			'BT'	=>	'p1',
			'BU'	=>	'p2',
			'BV'	=>	'p3',
			'BW'	=>	'p4',
			'BX'	=>	'p5',
			'BY'	=>	'p6',
			'BZ'	=>	'p7',
			'CA'	=>	'p8',
			'CB'	=>	'p9',
			'CC'	=>	'p10',
			
			'CE'	=>	'p11',
			'CF'	=>	'p12',
			'CG'	=>	'p13',
			'CH'	=>	'p14',
			'CI'	=>	'p15',
			'CJ'	=>	'p16',
			'CK'	=>	'p17',
			'CL'	=>	'p18',
			'CM'	=>	'p19',
			'CN'	=>	'p20',
			
			//SIKAP
			'CQ'	=>	's1',
			'CR'	=>	's2',
			'CS'	=>	's3',
			'CT'	=>	's4',
			'CU'	=>	's5',
			
		);
		
		$this->dm['map.nilai.impor'] = array(
			'P' => 'uts',
			'Q' => 'uas',
			
			//Pengetahuan//
			'S'		=>	'u1',
			'V'		=>	'u2',
			'Y'		=>	'u3',
			'AB'	=>	'u4',
			'AE'	=>	'u5',
			'AH'	=>	'u6',
			'AK'	=>	'u7',
			'AN'	=>	'u8',
			'AQ'	=>	'u9',
			'AT'	=>	'u10',
			
			'T'		=>	'r1',
			'W'		=>	'r2',
			'Z'		=>	'r3',
			'AC'	=>	'r4',
			'AF'	=>	'r5',
			'AI'	=>	'r6',
			'AL'	=>	'r7',
			'AO'	=>	'r8',
			'AR'	=>	'r9',
			'AU'	=>	'r10',
			
			'BH'	=>	't1',
			'BI'	=>	't2',
			'BJ'	=>	't3',
			'BK'	=>	't4',
			'BL'	=>	't5',
			'BM'	=>	't6',
			'BN'	=>	't7',
			'BO'	=>	't8',
			'BP'	=>	't9',
			'BQ'	=>	't10',
			
			//Praktek
			'BT'	=>	'p1',
			'BU'	=>	'p2',
			'BV'	=>	'p3',
			'BW'	=>	'p4',
			'BX'	=>	'p5',
			'BY'	=>	'p6',
			'BZ'	=>	'p7',
			'CA'	=>	'p8',
			'CB'	=>	'p9',
			'CC'	=>	'p10',
			
			'CE'	=>	'p11',
			'CF'	=>	'p12',
			'CG'	=>	'p13',
			'CH'	=>	'p14',
			'CI'	=>	'p15',
			'CJ'	=>	'p16',
			'CK'	=>	'p17',
			'CL'	=>	'p18',
			'CM'	=>	'p19',
			'CN'	=>	'p20',
			
			//SIKAP
			'CQ'	=>	's1',
			'CR'	=>	's2',
			'CS'	=>	's3',
			'CT'	=>	's4',
			'CU'	=>	's5',
			
			//'E' => 'mid_teori',
			//'I' => 'mid_praktek',
			
			'G' => 'nas_teori',
			'K' => 'nas_praktek',
			'M' => 'kompetensi',
			'CW'=> 'nas_sikap',
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
			$acc['admin'] = cfguc_admin('akses', 'nilai', 'pelajaran');
			$acc['view'] = cfguc_view('akses', 'nilai', 'pelajaran');
			$kelas_jml = 0;
			$sheet_no = 0;
			$data = array();
			$kelas_list = array();
			$excel_row_offset = 10;
			
			//agama , pkn, mat, sej, geo, eko, sosio
			$array_1kognitif = array('1','3','4','5','6','7', '8','13','14','15','16','44');
			//seni bud
			$array_1psikomotorik = array('17');
			//b.ind, b.ing, fis, kim, bio, b.mandrn, b.jawa
			$array_2kognitif = array('2','9','10','11','12','34','21');
			//penjas, tik
			$array_2psikomotorik = array('18','19','39');
			
			
			if(in_array($d['row']['mapel_id'], $array_1kognitif))
			{	$jenis_aspek = '1kog';	}
			elseif(in_array($d['row']['mapel_id'], $array_1psikomotorik))
			{	$jenis_aspek = '1psiko';	}
			elseif(in_array($d['row']['mapel_id'], $array_2kognitif))
			{	$jenis_aspek = '2kog';	}
			elseif(in_array($d['row']['mapel_id'], $array_2psikomotorik))
			{	$jenis_aspek = '2psiko';	}
			
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
				),
				'row.kelas' => array(
					'E2' => array(
						'nama',
						'prefix' => 'Kelas ',
					),
					'E3' => array(
						'didownload ' . $tgl,
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
					/*'AO', 'AP', 'AQ',  */
				),
				'kolom.invicible.praktek' => array(
					// PROSES 
					/*'CA', 'CB', 'CC', */
				),
				'kolom.invicible.sikap' => array(
					/*'DQ', 'DR', 'DS', */
				),
			);
		}
		/*
		$table_nisispel = array(
				'P' => 'uts',
				'Q' => 'uas',
				
		);*/
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
					// uts uas
					"P11:Q60",
					//sikap
					"CQ11:CU60",
					// daftar deskripsi
					"DC11:DE17",
			);
		$_cell_input[] = "C4";
		
		if($jenis_aspek != '1psiko')
		{	
			array_push($_cell_input,
						//Teori
						"S11:T60", "V11:W60", "Y11:Z60", "AB11:AC60", "AE11:AF60",
						"AH11:AI60","AK11:AL60", "AN11:AO60", "AQ11:AR60", "AT11:AU60", 
						"BH11:BQ60"
				);
		}
		
		if($jenis_aspek != '1kog')
		{
			array_push($_cell_input,
						//praktek
						"BT11:CC60", "CE11:CN60"
				);
		}	
		
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
			/*
			foreach ($cfg['kolom.invicible.teori'] as $_col)
				$_sheet->getColumnDimension($_col)->setVisible(FALSE);

			foreach ($cfg['kolom.invicible.praktek'] as $_col)
				$_sheet->getColumnDimension($_col)->setVisible(FALSE);

			foreach ($cfg['kolom.invicible.sikap'] as $_col)
				$_sheet->getColumnDimension($_col)->setVisible(FALSE);
			*/
			
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

	function expor_template($nipel_id,$jenis_aspek)
	{
		// pilihan file
		$folder = $this->storage_path($nipel_id);
		$template_pelajaran = $folder . "template.xlsx";
		
		$tamplate_nipel = APP_ROOT."content/".strtolower(APP_SCOPE)."/nilai-pelajaran/";
		if($jenis_aspek == '1kog')
		{	$template_kurikulum = $tamplate_nipel."rekap_nilai_ktsp_1aspek_kognitif.xlsx";		}
		elseif($jenis_aspek == '1psiko')
		{	$template_kurikulum = $tamplate_nipel."rekap_nilai_ktsp_1aspek_psikomotorik.xlsx";	}
		elseif($jenis_aspek == '2kog')
		{	$template_kurikulum = $tamplate_nipel."rekap_nilai_ktsp_2aspek_kognitif.xlsx";		}
		elseif($jenis_aspek == '2psiko')
		{	$template_kurikulum = $tamplate_nipel."rekap_nilai_ktsp_2aspek_psikomotorik.xlsx";	}
		
		//echo $nipel_id." ".$mapel_id." ".$template_kurikulum;
		//$template_kurikulum = APP_ROOT."content/".strtolower(APP_SCOPE)."/nilai-pelajaran/template.xlsx";
		$template_global = APP_ROOT.'content/'.strtolower(APP_SCOPE).'/template/nipel-flexible-2013.xlsx';

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
			//alert_error("aa".$upload['full_path']);
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
					'nas_teori' 		=> 'G',
					'nas_praktek' 		=> 'K',
					
					'uts' => 'U',
					'uas' => 'V',
					
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
		$file_name = "template.xlsx";

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
		$upload_path = "content/".strtolower(APP_SCOPE)."/nilai-pelajaran/";
		$file_name = "template.xlsx";

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
