<?php

// KTSP

class Cm_nilai_pelajaran extends MY_Model
{

	var $filetypes = array('xlsx');

	public function __construct()
	{
		parent::__construct();

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

		// deklarasi variabel

		if (TRUE)
		{
			$d = & $this->ci->d;
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
			$excel_source = $this->expor_template($d['row']['id']);

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
					'H3' => array(
						'DAFTAR NILAI SEMESTER '.$nama_semester,
					),
					'H4' => array(
						'TAHUN PELAJARAN '.$ta_semester,
					),
				),
				'table.nisispel' => array(
					'B' => array('id'),
					'C' => array('siswa_nama'),
				),
				'baris.invicible' => array(5, 6),
				'kolom.invicible' => array('B'),
			);
		}

		// siapkan data.dikelompokan per kelas

		
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

		foreach ($kelas_list as $_kls_id)
		{
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
			
		}

		// hapus sheet template
		$excel_obj->removeSheetByIndex(0);

		// output
		return excel_output_2007($excel_obj, "{$d['row']['pelajaran_nama']}.xlsx");

	}

	function expor_template($nipel_id)
	{
		// pilihan file
		$folder = $this->storage_path($nipel_id);
		$template_pelajaran = $folder . "template.xlsx";
		$template_kurikulum = APP_ROOT."content/".strtolower(APP_SCOPE)."/nilai-pelajaran/template.xlsx";
		$template_global = APP_ROOT."content/".strtolower(APP_SCOPE)."/template/nipel-flexible-2013.xlsx";

		// memilih template
		// disable ambil history
		/*
		if (file_ada($template_pelajaran))
		{
			return $template_pelajaran;
		}
*/
		if (file_ada($template_kurikulum))
		{
			return $template_kurikulum;
		}

		return $template_global;

	}

	function impor()
	{
		$d = & $this->ci->d;
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
					'nas_total' => 'E',
					'nas_teori' => 'G',
					'nas_praktek' => 'H',
					'nas_sikap' => 'I',
					'cat_teori' => 'J',
					'uas' => 'N',
					'uts' => 'M',
					'u1' => 'L', // menampung nilai rata2 harian
				),
			);
		}

		// ambil data nilai pelajaran: kompetensi

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

		$nilai_map = $cfg['kolom.nilai'];

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

				foreach ($nilai_map as $_db_col => $_excel_col)
				{
					try
					{
						$_cell = $_excel_col . $_row_no;
						$_nilai = $sheet->getCell($_cell)->getCalculatedValue();
						$_row[$_db_col] = (empty($_nilai) == FALSE) ? $_nilai : NULL;
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

		// selesai extract data
		unset($sheet);
		$PHPExcel->disconnectWorksheets();
		unset($PHPExcel);

		// cek daftar nisispel skaligus ambil data list nilsis

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
		$upload_path = APP_ROOT."content/".strtolower(APP_SCOPE)."/nilai-pelajaran/";
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
