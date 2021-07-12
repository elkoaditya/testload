<?php

class Reset_password_siswa
{

	var $ci;

	public function __construct()
	{
		$this->ci = & get_instance();

	}

	public function run()
	{
		$this->reset_password();

		return $this->download();

	}

	public function download()
	{
		$query = $this->query_password();

		return $this->generate_excel($query);

	}

	public function reset_password()
	{
		$sql = "CALL reset_password_siswa();";

		$this->ci->db->simple_query($sql);

	}

	public function query_password()
	{
		$query = array(
			'select'	 => array(
				'rahasia.*',
				'kelas_nama' => 'kelas.nama',
			),
			'from'		 => 'rahasia',
			'join'		 => array(
				array('dakd_kelas kelas', 'rahasia.kelas_id = kelas.id', 'inner'),
			),
			'order_by'	 => 'kelas.grade, kelas.jurusan_id, kelas.nama, rahasia.nama',
		);

		$this->ci->md->query($query);

		return $this->ci->db->get();

	}

	public function generate_excel($query)
	{
		if ($query->num_rows() == 0)
		{
			exit('data kosong');
		}

		$map = array(
			'B'	 => 'nama',
			'C'	 => 'username',
			'D'	 => 'password',
		);

		$phpexcel = new PHPExcel();

		$sheet = $phpexcel->getActiveSheet();



		$row = 1;
		$number = 0;
		$kelas_id = 0;

		foreach ($query->result() as $record)
		{
			if ($kelas_id != $record->kelas_id)
			{
				$kelas_id = $record->kelas_id;
				$number = 0;

				$row += 3;
				$sheet->setCellValue('A' . $row, 'Kelas: ' . $record->kelas_nama);

				$row++;
				$sheet->setCellValue('A' . $row, 'No');
				$sheet->setCellValue('B' . $row, 'Nama');
				$sheet->setCellValue('C' . $row, 'Username');
				$sheet->setCellValue('D' . $row, 'Password');
			}

			$row++;
			$number++;

			foreach ($map as $col => $field)
			{
				$sheet->setCellValueExplicit('A' . $row, $number);
				$sheet->setCellValueExplicit($col . $row, $record->$field, PHPExcel_Cell_DataType::TYPE_STRING);
			}
		}


		header("Content-Type: application/vnd.ms-excel");
		header("Content-Disposition: attachment; filename=\"password-siswa.xlsx\"");
		header("Cache-Control: max-age=0");
		$objWriter = new PHPExcel_Writer_Excel2007($phpexcel);
		$objWriter->save("php://output");
		exit();

	}

}
