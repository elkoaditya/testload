<?php

class Reset_password_sdm
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
		$sql = "CALL reset_password_sdm();";

		$this->ci->db->simple_query($sql);

	}

	public function query_password()
	{
		$query = array(
			'select' => array(),
			'from'	 => 'secret',
			'join'	 => array(
				array('', '', 'inner'),
			),
		);
		
		$this->ci->db->order_by('nama');
		return $this->ci->db->get('secret');

	}

	public function generate_excel($query)
	{
		if ($query->num_rows() == 0)
		{
			exit('data kosong');
		}

		$map = array(
			'A'	 => 'nama',
			'B'	 => 'username',
			'C'	 => 'password',
		);
		$phpexcel = new PHPExcel();
		$sheet = $phpexcel->getActiveSheet();

		$sheet->setCellValue('A1', 'Nama');
		$sheet->setCellValue('B1', 'Username');
		$sheet->setCellValue('C1', 'Password');

		$row = 1;

		foreach ($query->result() as $record)
		{
			$row++;

			foreach ($map as $col => $field)
			{
				$sheet->setCellValueExplicit($col . $row, $record->$field, PHPExcel_Cell_DataType::TYPE_STRING);
			}
		}


		header("Content-Type: application/vnd.ms-excel");
		header("Content-Disposition: attachment; filename=\"password-guru.xlsx\"");
		header("Cache-Control: max-age=0");
		$objWriter = new PHPExcel_Writer_Excel2007($phpexcel);
		$objWriter->save("php://output");
		exit();

	}

}
