<?php

class Konversi_nilai
{

	var $ci;
	var $data;

	public function __construct()
	{
		$this->ci = & get_instance();

		$query = array(
			'from' => 'konversi_nilai',
			'order_by' => 'rentang_nilai_max desc',
		);

		$result = $this->ci->md->query($query)->result();
		$this->data = $result['data'];

	}

	function konversi($nilai, $kolom = 'bobot')
	{
		$nilai = ($nilai);

		foreach ($this->data as $row)
		{
			$min = (float) $row['rentang_nilai_min'];
			$max = (float) $row['rentang_nilai_max'];

			if (( $min <= $nilai) && ($nilai <= $max))
			{
				return $row[$kolom];
			}
		}

		return NULL;

	}

	function bobot($nilai)
	{
		return $this->konversi($nilai, 'bobot');

	}

	function predikat($nilai)
	{
		return $this->konversi($nilai, 'predikat');

	}

	function kualifikasi($nilai)
	{
		return $this->konversi($nilai, 'kualifikasi');

	}

}
