<?php

// penulisan data

function excel_cell_write(&$sheet, &$row, $cell, $cfg) {
	$cfg = (array) $cfg;
	$data = (string) data_cell($cfg, $row);

	if (isset($cfg[0]))
		$sheet->setCellValue($cell, $data);

	if (isset($cfg['style']))
		$sheet->getStyle($cell)->applyFromArray($cfg['style']);
}

function excel_list_write(&$sheet, $list) {
	foreach ($list as $cell => $text)
		$sheet->setCellValue($cell, (string) $text);
}

function excel_row_write(&$sheet, &$row, $cfg) {
	foreach ($cfg as $cell => $dat)
		excel_cell_write($sheet, $row, $cell, $dat);
}

function excel_table_write(&$sheet, &$data, $cfg, $offset = 0, $no_col = 'A') {
	$excel_row = (int) $offset;
	$no = 0;
	$use_number = ($no_col && is_string($no_col));

	foreach ($data as $row):
		$excel_row++;
		$no++;

		foreach ($cfg as $col => $dat):

			if ($use_number):
				$no_cell = $no_col . $excel_row;
				$sheet->setCellValue($no_cell, $no);
			endif;

			$cell = $col . $excel_row;
			excel_cell_write($sheet, $row, $cell, $dat);

		endforeach;

	endforeach;
}

// penulisan formula

function excel_cell_formula_write(&$sheet, $col, $row, $formula) {
	$formula = (string) str_replace('@{row}', $row, $formula);
	$cell = $col . $row;

	$sheet->setCellValue($cell, $formula);
}

function excel_table_formula_write(&$sheet, $cfg, $row_start, $row_end) {

	for ($row = $row_start; $row <= $row_end; $row++):
		foreach ($cfg as $col => $formula):
			excel_cell_formula_write($sheet, $col, $row, $formula);

		endforeach;

	endfor;
}

// objek lain

function excel_output($excel_obj, $nama) {
	header("Content-Type: application/vnd.ms-excel");
	header("Content-Disposition: attachment; filename=\"{$nama}\"");
	header("Cache-Control: max-age=0");
	$objWriter = PHPExcel_IOFactory::createWriter($excel_obj, "Excel5");
	$objWriter->save("php://output");
	exit();
}

function excel_output_2007($excel_obj, $nama) {
	header("Content-Type: application/vnd.ms-excel");
	header("Content-Disposition: attachment; filename=\"{$nama}\"");
	header("Cache-Control: max-age=0");
	$objWriter = new PHPExcel_Writer_Excel2007($excel_obj);
	$objWriter->save("php://output");
	exit();
}

// fungsi keamanan/security

function excel_security_doc_lock(&$objPHPExcel, $password = 'tanpaspasi') {
	$objPHPExcel->getSecurity()->setLockWindows(true);
	$objPHPExcel->getSecurity()->setLockStructure(true);
	$objPHPExcel->getSecurity()->setWorkbookPassword($password);
}

function excel_security_sheet_lock(&$sheet, $password = 'tanpaspasi') {
	$sheet->getProtection()->setPassword($password);
	$sheet->getProtection()->setSheet(true);
	$sheet->getProtection()->setSort(true);
	$sheet->getProtection()->setInsertRows(true);
	$sheet->getProtection()->setFormatCells(true);
}

function excel_security_cell_lock(&$sheet, $cellrange) {
	$cellrange = (array) $cellrange;

	foreach ($cellrange as $cell)
		$sheet->getStyle($cell)->getProtection()->setLocked(PHPExcel_Style_Protection::PROTECTION_PROTECTED);
}

function excel_security_cell_unlock(&$sheet, $cellrange) {
	$cellrange = (array) $cellrange;

	foreach ($cellrange as $cell)
		$sheet->getStyle($cell)->getProtection()->setLocked(PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);
}

// pembacaan data

function excel_cell_read(&$sheet, $cfg) {
	$cfg = (array) $cfg;
	$as = isset($cfg['as']) ? $cfg['as'] : NULL;
	$value = $sheet->getCell($cfg[0])->getValue();

	if (empty($value))
		return NULL;

	if (!$as)
		return clean_excel_value($value);

	if ($as === 'date')
		return excel_data_date($value);

	if ($as === 'datetime')
		return excel_data_date($value, 'Y-m-d H:i:s');

	if ($as === 'float')
		return (float) $value;

	if (in_array($as, array('int', 'integer')))
		return (int) $value;

	if (in_array($as, array('string')))
		return (string) clean_excel_value($value);

	// fail safe
	return clean_excel_value($value);
}

function excel_row_read(&$sheet, $cfg, $data = array()) {

	foreach ($cfg as $col => $dat)
		$dat[$col] = excel_cell_read($sheet, $dat);

	return $data;
}

function excel_table_read(&$sheet, $cfg, $row_start, $row_end) {
	$data = array();

	for ($i = $row_start; $i <= $row_end; $i++):
		foreach ($cfg as $dbcol => $dat):
			$dat = (array) $dat;
			$dat[0] .= $i;
			$data[$i][$dbcol] = excel_cell_read($sheet, $dat);

		endforeach;

	endfor;

	return $data;
}

// tools
// extract date dr data excel

function excel_data_date($data, $format = 'Y-m-d') {
	$data = (int) $data;
	$data -= 2;
	$date = date_create('1900-01-01');

	$date->modify("+{$data} day");

	return (!$format) ? $date : $date->format($format);
}

// xtra tambahan

function excel_formula_nilai_uh($col_ulangan, $col_remidi, $cell_kkm = '$Z$3') {
	return '=IF(ISNUMBER(' . $col_ulangan . '@{row})=FALSE(),"",IF(OR(' . $col_ulangan . '@{row}>=' . $cell_kkm . ',ISNUMBER(' . $col_remidi . '@{row})=FALSE(),' . $col_ulangan . '@{row}>' . $col_remidi . '@{row}),' . $col_ulangan . '@{row},IF(' . $col_remidi . '@{row}>=' . $cell_kkm . ',' . $cell_kkm . ',' . $col_remidi . '@{row})))';
}

function excel_formula_avg() {
	$params = (array) func_get_args();

	if (empty($params))
		return NULL;

	$range_list = implode(',', $params);

	return "=IF(COUNT({$range_list})=0, \"\", AVERAGE({$range_list}))";
}

function excel_formula_avg_row() {
	//=IF(COUNT(I16,L16)=0, "", AVERAGE(I16,L16))

	$params = (array) func_get_args();

	if (empty($params))
		return NULL;

	foreach (array_keys($params) as $i)
		$params[$i] = excel_range_prepend_row($params[$i]);

	$range_list = implode(',', $params);

	return "=IF(COUNT({$range_list})=0, \"\", AVERAGE({$range_list}))";
}

function excel_range_prepend_row($range, $row = '@{row}') {
	return str_replace(':', ( $row . ':'), $range) . $row;
}

function excel_mergecells(&$sheet, $ranges) {

	if (!is_array($ranges))
		return $sheet->mergeCells($ranges);

	foreach ($ranges as $range)
		$sheet->mergeCells($range);
}

function excel_load() {
	$ci = & get_instance();

	$ci->load->library('PHPExcel');
	$ci->phpexcel->disconnectWorksheets();
	unset($ci->phpexcel);
}

function excel_colnumber($num) {
	$numeric = $num % 26;
	$letter = chr(65 + $numeric);
	$num2 = intval($num / 26);

	if ($num2 <= 0)
		return $letter;

	return excel_colnumber($num2 - 1) . $letter;
}
