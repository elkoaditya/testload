<?php

// 2013

class Cm_nilai_pelajaran_k13 extends MY_Model
{

	var $filetypes = array('xlsx');

	public function __construct()
	{
		parent::__construct();
		
		$this->dm['map.nilai.expor'] = array(
			'AV' => 'uts',
			'BA' => 'uas',
			
			
			//Pengetahuan//
			'BM'	=>	'u1',
			'BS'	=>	'u2',
			'BY'	=>	'u3',
			'CE'	=>	'u4',
			'CK'	=>	'u5',
			'CR'	=>	'u6',
			'CX'	=>	'u7',
			'DD'	=>	'u8',
			'DJ'	=>	'u9',
			'DP'	=>	'u10',
			
			'BN'	=>	'r1',
			'BT'	=>	'r2',
			'BZ'	=>	'r3',
			'CF'	=>	'r4',
			'CL'	=>	'r5',
			'CS'	=>	'r6',
			'CY'	=>	'r7',
			'DE'	=>	'r8',
			'DK'	=>	'r9',
			'DQ'	=>	'r10',
			
			'EN'	=>	't1',
			'EQ'	=>	't2',
			'ET'	=>	't3',
			'EW'	=>	't4',
			'EZ'	=>	't5',
			'FC'	=>	't6',
			'FF'	=>	't7',
			'FI'	=>	't8',
			'FL'	=>	't9',
			'FO'	=>	't10',
			
			//Praktek
			'GP'	=>	'p1',
			'GQ'	=>	'p2',
			'GR'	=>	'p3',
			'GS'	=>	'p4',
			
			'GW'	=>	'p5',
			'GX'	=>	'p6',
			'GY'	=>	'p7',
			'GZ'	=>	'p8',
			
			'HD'	=>	'p9',
			'HE'	=>	'p10',
			'HF'	=>	'p11',
			'HG'	=>	'p12',
			
			'HK'	=>	'p13',
			'HL'	=>	'p14',
			'HM'	=>	'p15',
			'HN'	=>	'p16',
			
			'HR'	=>	'p17',
			'HS'	=>	'p18',
			'HT'	=>	'p19',
			'HU'	=>	'p20',
			///////
			'HZ'	=>	'p21',
			'IA'	=>	'p22',
			'IB'	=>	'p23',
			'IC'	=>	'p24',
			
			'IG'	=>	'p25',
			'IH'	=>	'p26',
			'II'	=>	'p27',
			'IJ'	=>	'p28',
			
			'IN'	=>	'p29',
			'IO'	=>	'p30',
			'IP'	=>	'p31',
			'IQ'	=>	'p32',
			
			'IU'	=>	'p33',
			'IV'	=>	'p34',
			'IW'	=>	'p35',
			'IX'	=>	'p36',
			
			'JB'	=>	'p37',
			'JC'	=>	'p38',
			'JD'	=>	'p39',
			'JE'	=>	'p40',
			
			//SIKAP
			/* 'KF'	=>	's1',
			'KG'	=>	's2',
			'KH'	=>	's3',
			'KI'	=>	's4',
			'KJ'	=>	's5',
			'KK'	=>	's6',
			'KL'	=>	's7',
			
			'KP'	=>	's11',
			'KQ'	=>	's12',
			'KR'	=>	's13',
			'KS'	=>	's14',
			'KT'	=>	's15',
			'KU'	=>	's16',
			'KV'	=>	's17',
			
			'KZ'	=>	's21',
			'LA'	=>	's22',
			'LB'	=>	's23',
			'LC'	=>	's24',
			'LD'	=>	's25',
			'LE'	=>	's26',
			'LF'	=>	's27', */
			
			'LK'	=>	's1',
			'LL'	=>	's2',
			'LM'	=>	's3',
			'LN'	=>	's4',
			'LO'	=>	's5',
			'LP'	=>	's6',
			'LQ'	=>	's7',
			'LR'	=>	's8',
			'LS'	=>	's9',
			'LT'	=>	's10',
			
		);
		
		$this->dm['map.nilai.impor'] = array(
			'AV' => 'uts',
			'BA' => 'uas',
			
			//Pengetahuan//
			'BM'	=>	'u1',
			'BS'	=>	'u2',
			'BY'	=>	'u3',
			'CE'	=>	'u4',
			'CK'	=>	'u5',
			'CR'	=>	'u6',
			'CX'	=>	'u7',
			'DD'	=>	'u8',
			'DJ'	=>	'u9',
			'DP'	=>	'u10',
			
			'BN'	=>	'r1',
			'BT'	=>	'r2',
			'BZ'	=>	'r3',
			'CF'	=>	'r4',
			'CL'	=>	'r5',
			'CS'	=>	'r6',
			'CY'	=>	'r7',
			'DE'	=>	'r8',
			'DK'	=>	'r9',
			'DQ'	=>	'r10',
			
			'EN'	=>	't1',
			'EQ'	=>	't2',
			'ET'	=>	't3',
			'EW'	=>	't4',
			'EZ'	=>	't5',
			'FC'	=>	't6',
			'FF'	=>	't7',
			'FI'	=>	't8',
			'FL'	=>	't9',
			'FO'	=>	't10',
			
			//Praktek
			'GP'	=>	'p1',
			'GQ'	=>	'p2',
			'GR'	=>	'p3',
			'GS'	=>	'p4',
			
			'GW'	=>	'p5',
			'GX'	=>	'p6',
			'GY'	=>	'p7',
			'GZ'	=>	'p8',
			
			'HD'	=>	'p9',
			'HE'	=>	'p10',
			'HF'	=>	'p11',
			'HG'	=>	'p12',
			
			'HK'	=>	'p13',
			'HL'	=>	'p14',
			'HM'	=>	'p15',
			'HN'	=>	'p16',
			
			'HR'	=>	'p17',
			'HS'	=>	'p18',
			'HT'	=>	'p19',
			'HU'	=>	'p20',
			///////
			'HZ'	=>	'p21',
			'IA'	=>	'p22',
			'IB'	=>	'p23',
			'IC'	=>	'p24',
			
			'IG'	=>	'p25',
			'IH'	=>	'p26',
			'II'	=>	'p27',
			'IJ'	=>	'p28',
			
			'IN'	=>	'p29',
			'IO'	=>	'p30',
			'IP'	=>	'p31',
			'IQ'	=>	'p32',
			
			'IU'	=>	'p33',
			'IV'	=>	'p34',
			'IW'	=>	'p35',
			'IX'	=>	'p36',
			
			'JB'	=>	'p37',
			'JC'	=>	'p38',
			'JD'	=>	'p39',
			'JE'	=>	'p40',
			
			//SIKAP
			/* 'KF'	=>	's1',
			'KG'	=>	's2',
			'KH'	=>	's3',
			'KI'	=>	's4',
			'KJ'	=>	's5',
			'KK'	=>	's6',
			'KL'	=>	's7',
			
			'KP'	=>	's11',
			'KQ'	=>	's12',
			'KR'	=>	's13',
			'KS'	=>	's14',
			'KT'	=>	's15',
			'KU'	=>	's16',
			'KV'	=>	's17',
			
			'KZ'	=>	's21',
			'LA'	=>	's22',
			'LB'	=>	's23',
			'LC'	=>	's24',
			'LD'	=>	's25',
			'LE'	=>	's26',
			'LF'	=>	's27', 
			
			'LK'	=>	's9',
			'LL'	=>	's19',
			'LM'	=>	's20',
			'LN'	=>	's29',
			'LO'	=>	's30',*/
			
			'LK'	=>	's1',
			'LL'	=>	's2',
			'LM'	=>	's3',
			'LN'	=>	's4',
			'LO'	=>	's5',
			'LP'	=>	's6',
			'LQ'	=>	's7',
			'LR'	=>	's8',
			'LS'	=>	's9',
			'LT'	=>	's10',
			
			/* MID */
			'E' => 'mid_teori',
			'S' => 'mid_praktek',
			'F' => 'mid_pred_teori',
			'T' => 'mid_pred_praktek',
			
			
			'K' => 'nas_teori',
			'Y' => 'nas_praktek',
			'M' => 'kompetensi',
			
			'N' => 'cat_teori',
			'AB' => 'cat_praktek',

			'L' => 'pred_teori',
			'Z' => 'pred_praktek',
			
			
			
			'AH'=> 'nas_sikap',
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
			/*
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
			//$tamplate_nipel = APP_ROOT."content/".strtolower(APP_SCOPE)."/nilai-pelajaran/";
			//$excel_source = $tamplate_nipel.'template.xlsx';
			///$excel_source = $this->expor_template($d['row']['id'], $jenis_aspek);
			*/
			$jenis_aspek = '1kog';
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
					'BN9' => array('kkm1'),
					'BT9' => array('kkm2'),
					'BZ9' => array('kkm3'),
					'CF9' => array('kkm4'),
					'CL9' => array('kkm5'),
					'CS9' => array('kkm6'),
					'CY9' => array('kkm7'),
					'DE9' => array('kkm8'),
					'DK9' => array('kkm9'),
					'DQ9' => array('kkm10'),
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
					"AV11:AV60",
					"BA11:BA60",
					//kkm
					"BN9:DQ9",
					//"EN9:FF9",
					//"GQ9:IH9",
					
					//PENGETAHUAN
					"BM11:BN60",
					"BS11:BT60",
					"BY11:BZ60",
					"CE11:CF60",
					"CK11:CL60",
					
					"CR11:CS60",
					"CX11:CY60",
					"DD11:DE60",
					"DJ11:DK60",
					"DP11:DQ60",
					
					///TUGAS
					"EN11:EN60",
					"EQ11:EQ60",
					"ET11:ET60",
					"EW11:EW60",
					"EZ11:EZ60",
					
					"FC11:FC60",
					"FF11:FF60",
					"FI11:FI60",
					"FL11:FL60",
					"FO11:FO60",
					
					//KETERAMPILAN
					"GP11:GS60",
					"GW11:GZ60",
					"HD11:HG60",
					// "HK11:HL60",
					// "HR11:HS60",
					
					"HZ11:IC60",
					"IG11:IJ60",
					"IN11:IQ60",
					"IU11:IX60",
					// "JB11:JC60",
					
					//sikap
					"LK11:LT60",
					
					//DESKRIPSI
					"NR13:NT24",
			);
		$_cell_input[] = "C4";
		// sikap 
		// array_push($_cell_input,
						//Teori
						// "LK11:LO60"
				// );
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
			
			excel_security_cell_lock($_sheet, 'A1:NS72');
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
		$template_kurikulum = $tamplate_nipel."template_k13.xlsx";
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
				'kkm1' => 'BN9',
				'kkm2' => 'BT9',
				'kkm3' => 'BZ9',
				'kkm4' => 'CF9',
				'kkm5' => 'CL9',
				'kkm6' => 'CS9',
				'kkm7' => 'CY9',
				'kkm8' => 'DE9',
				'kkm9' => 'DK9',
				'kkm10' => 'DQ9',
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
			$data_nipel['kkm1'] = $sheet->getCell($cfg['kkm1'])->getValue();
			$data_nipel['kkm2'] = $sheet->getCell($cfg['kkm2'])->getValue();
			$data_nipel['kkm3'] = $sheet->getCell($cfg['kkm3'])->getValue();
			$data_nipel['kkm4'] = $sheet->getCell($cfg['kkm4'])->getValue();
			$data_nipel['kkm5'] = $sheet->getCell($cfg['kkm5'])->getValue();
			$data_nipel['kkm6'] = $sheet->getCell($cfg['kkm6'])->getValue();
			$data_nipel['kkm7'] = $sheet->getCell($cfg['kkm7'])->getValue();
			$data_nipel['kkm8'] = $sheet->getCell($cfg['kkm8'])->getValue();
			$data_nipel['kkm9'] = $sheet->getCell($cfg['kkm9'])->getValue();
			$data_nipel['kkm10'] = $sheet->getCell($cfg['kkm10'])->getValue();
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
