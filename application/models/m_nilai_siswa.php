<?php

class M_nilai_siswa extends MY_Model
{

	public function __construct()
	{
		parent::__construct(array(
			'fields' => array(
				// nilai absensi
				'absen_s', 'absen_i', 'absen_a',
			),
			'fields_catatan' => array(
				// nilai absensi
				'note_walikelas',
			),
			'fields_mutasi' => array(
				// nilai absensi
				'note_mutasi',
			),
		));
		
		$this->dm['admin'] = cfguc_admin('akses', 'nilai', 'siswa');
		$this->dm['view'] = cfguc_view('akses', 'nilai', 'siswa');
		$this->dm['walikelas'] = (array) cfgu('walikelas');
		$this->dm['kepribadian.ktsp'] = array(
			'kedisiplinan'	 => 'Kedisiplinan',
			'kebersihan'	 => 'Kebersihan',
			'kesehatan'		 => 'Kesehatan',
			'tgjawab'		 => 'Tanggungjawab',
			'kesopanan'		 => 'Sopan santun',
			'percayadiri'	 => 'Percaya diri',
			'kompetitif'	 => 'Kompetitif',
			'sosial'		 => 'Hubungan sosial',
			'kejujuran'		 => 'Kejujuran',
			'ritualibadah'	 => 'Pelaksanaan ibadah ritual',
		);
		$this->dm['map.absen'] = array(
			// absen
			'G'	 => 'absen_s',
			'H'	 => 'absen_i',
			'I'	 => 'absen_a',
		);
		$this->dm['map.kenaikan_kelas'] = array(
			// kenaikan kelas
			//'T' => 'ket_kenaikan_kelas',
			'AE' => 'ket_kenaikan_kelas',
		);/*
		$this->dm['map.nilai_sikap'] = array(
			// nilai sikap
			'U' => 'nilai_sikap_bk',
			'V' => 'nilai_sikap_wali',
		);*/
		$this->dm['map.kode_aspri.ktsp'] = array(
			'J'		 => 'kedisiplinan',
			'L'		 => 'kebersihan',
			'N'		 => 'kesehatan',
			'P'		 => 'tgjawab',
			'R'		 => 'kesopanan',
			'T'		 => 'percayadiri',
			'V'		 => 'kompetitif',
			'X'		 => 'sosial',
			'Z'		 => 'kejujuran',
			'AB'	 => 'ritualibadah',
		);
		$this->dm['map.aspri.ktsp'] = array(
			'K'	 	=> 'kedisiplinan',
			'M'		=> 'kebersihan',
			'O'		=> 'kesehatan',
			'Q'	 	=> 'tgjawab',
			'S'	 	=> 'kesopanan',
			'U'	 	=> 'percayadiri',
			'W'		=> 'kompetitif',
			'Y'		=> 'sosial',
			'AA'	=> 'kejujuran',
			'AC'	=> 'ritualibadah',
		);
		
		$this->dm['map.predikat_sikap.k13'] = array(
			'AG'	=> 'spiritual',
			'AI'	=> 'sosial',
		);
		
		$this->dm['map.deskripsi_sikap.k13'] = array(
			'AH'	=> 'spiritual',
			'AJ'	=> 'sosial',
		);
		
		$this->dm['map.kerja_lapangan'] = array(
			// kerja_lapangan
			'G'	 => 'pkl_nama',
			'H'	 => 'pkl_alamat',
			'I'	 => 'pkl_waktu',
			'J'	 => 'pkl_nilai',
			'K'	 => 'pkl_predikat',
			'L'	 => 'pkl_keterangan',
			
		);
		
		$this->dm['map.kerja_lapangan_smk6'] = array(
			// kerja_lapangan
			'G'	 => 'pkl_nama',
			'H'	 => 'pkl_alamat',
			'I'	 => 'pkl_waktu',
			'J'	 => 'pkl_nilai',
			'K'	 => 'pkl_predikat',
			'L'	 => 'pkl_keterangan',
			
			'M'	 => 'pkl_nama2',
			'N'	 => 'pkl_alamat2',
			'O'	 => 'pkl_waktu2',
			'P'	 => 'pkl_nilai2',
			'Q'	 => 'pkl_predikat2',
			'R'	 => 'pkl_keterangan2',
			
			'S'	 => 'pkl_nama3',
			'T'	 => 'pkl_alamat3',
			'U'	 => 'pkl_waktu3',
			'V'	 => 'pkl_nilai3',
			'W'	 => 'pkl_predikat3',
			'X'	 => 'pkl_keterangan3',
		);
		
		$this->dm['map.impor.des_perkembangan_karakter'] = array(
			// kerja_lapangan
			'G'	 => 'kode_des_integritas',
			'I'	 => 'kode_des_religius',
			'K'	 => 'kode_des_nasionalis',
			'M'	 => 'kode_des_mandiri',
			'O'	 => 'kode_des_got_royong',
			
			'H'	 => 'des_integritas',
			'J'	 => 'des_religius',
			'L'	 => 'des_nasionalis',
			'N'	 => 'des_mandiri',
			'P'	 => 'des_got_royong',
			
		);
		
		$this->dm['map.expor.des_perkembangan_karakter'] = array(
			// kerja_lapangan
			'G'	 => 'kode_des_integritas',
			'I'	 => 'kode_des_religius',
			'K'	 => 'kode_des_nasionalis',
			'M'	 => 'kode_des_mandiri',
			'O'	 => 'kode_des_got_royong',
			
		);

	}

	// dasar database

	function filter_2($query)
	{
		$s = & $this->ci->d['semaktif'];
		$r = & $this->ci->d['request'];
		$dm = & $this->dm;

		//if (!$dm['view'])
		//return $query;

		if (isset($r['term']) && strlen($r['term']) > 0)
		{
			if (is_numeric($r['term']))
			{
				$query['where_strings'][] = "(siswa.nis = {$r['term']} OR siswa.nisn = {$r['term']})";
			}
			else
			{
				$query['like'] = array($r['term'],  array('siswa.nis%', 'siswa.nama%'));
			}
		}

		if (isset($r['siswa_id']) && $r['siswa_id'] > 0)
			$query['where']['siswa.id'] = $r['siswa_id'];

		if (isset($r['kelas_id']) && $r['kelas_id'] > 0)
			$query['where']['kelas.id'] = $r['kelas_id'];

		if (isset($r['semester_id']) == FALSE OR ! $r['semester_id'])
		{
			$r['semester_id'] = $this->md->row_col('id', 'select id from prd_semester order by id desc limit 1');
		}

		$query['where']['nilai.semester_id'] = $r['semester_id'];

		return $query;

	}

	function query_2()
	{
		$dm = & $this->dm;
		$d = & $this->ci->d;

		// query dasar

		$query = array(
			'select'	 => array(
				'nilai.*',
				'ta_id'				 => 'ta.id',
				'ta_nama'			 => 'ta.nama',
				'semester_nama'		 => 'semester.nama',
				'semester_nama'		 => 'semester.nama',
				'kurikulum_id'	 	 => 'd_kurikulum.id',
				'kurikulum_nama'	 => 'd_kurikulum.nama',
				'siswa_nis'			 => 'siswa.nis',
				'siswa_nisn'		 => 'siswa.nisn',
				'siswa_no_un'		 => 'siswa.no_un',
				'siswa_nama'		 => 'siswa.nama',
				'siswa_gender'		 => 'siswa.gender',
				'siswa_masuk_tgl'	 => 'siswa.masuk_tgl',
				'siswa_no_un'		 => 'siswa.no_un',
				'siswa.lahir_tempat',
				'siswa.lahir_tgl',
				'siswa.ayah_nama',
				'siswa.ibu_nama',
				
				'siswa.agama_id',
				'kelas_nama'		 => 'kelas.nama',
				'kelas_grade'		 => 'kelas.grade',
				'kelas_wali_id'		 => 'kelas.wali_id',
				'kelas_gurubk_id'	 => 'kelas.gurubk_id',
				'tanggal_mid_nama'	 => 'tanggal_mid_new',
				'tanggal_uas_nama'	 => 'tanggal_uas_new',
				'tanggal_mutasi'	 => 'tanggal_mutasi',
				'tanggal_kelulusan'	 => 'tanggal_kelulusan',
				'kepsek_nama'	 	 => "trim(trim(TRAILING ', ' from concat(kepsek.prefix, ' ', kepsek.nama, ', ', kepsek.suffix)))",
				'kepsek_nip'	 	 => 'kepsek.nip',
				'kota_nama'	 => 'kota.nama',
				
				'kelas_diterima_nama'=> 'kelas_diterima.nama',
				//'wali_nama' => "trim(concat_ws(' ', wali.prefix, wali.nama, wali.suffix))",
				'wali_nama'			 => "trim(trim(TRAILING ', ' from concat(wali.prefix, ' ', wali.nama, ', ', wali.suffix)))",
				'wali_id'			 => 'nikls.kelas_wali_id',
				'wali_nip'			 => 'wali.nip',
			),
			'from'		 => 'nilai_siswa nilai',
			'join'		 => array(
				array('dprofil_siswa siswa', 'nilai.siswa_id = siswa.id', 'inner'),
				array('prd_semester semester', 'nilai.semester_id = semester.id', 'inner'),
				array('prd_ta ta', 'semester.ta_id = ta.id', 'inner'),
				array('dakd_kelas kelas', 'nilai.kelas_id = kelas.id', 'inner'),
				array('nilai_kelas nikls', 'nilai.kelas_nilai_id = nikls.id', 'inner'),
				array('dprofil_sdm wali', 'nikls.kelas_wali_id = wali.id', 'left'),
				array('dprofil_sdm kepsek', 'semester.kepsek_id = kepsek.id', 'left'),
				array('dakd_kelas kelas_diterima', 'siswa.masuk_kelas_id = kelas_diterima.id', 'left'),
				array('dmst_kurikulum d_kurikulum', 'nikls.kurikulum_id = d_kurikulum.id', 'left'),
				//array('dmst_tanggal tanggal_mid', 'nikls.tanggal_mid = tanggal_mid.id', 'left'),
			//	array('dmst_tanggal tanggal_uas', 'nikls.tanggal_uas = tanggal_uas.id', 'left'),
				array('dmst_kota kota', 'nikls.kota_id = kota.id', 'left'),
			),
			'order_by'	 => 'semester.id desc, kelas.grade, kelas.nama, nilai.absen_no, siswa.nama',
		);

		// filter akses
		if(APP_SUBDOMAIN=='smp_terbang'){
			$query['order_by'] = 'semester.id desc, kelas.grade, kelas.nama, nilai.absen_no, siswa.nis';
		}
		
		if ($d['user']['role'] == 'siswa'):
			$query['where']['siswa.id'] = (int) $d['user']['id'];

		elseif (!$dm['view']):

			if ($dm['walikelas'])
				$query['where_in']['nilai.kelas_id'] = $dm['walikelas'];
			else
				$query['where']['siswa.id'] = (int) $d['user']['id'];

		endif;

		return $query;

	}

	function query_3()
	{
		$dm = & $this->dm;
		$d = & $this->ci->d;

		// query dasar

		$query = array(
			'select'	 => array(
			//	'nilai.*',
				'nilai_id'			 => 'nilai.id',
				'siswa_id'			 => 'nilai.siswa_id',
				'ta_id'				 => 'ta.id',
				'ta_nama'			 => 'ta.nama',
				'semester_nama'		 => 'semester.nama',
			),
			'from'		 => 'nilai_siswa nilai',
			'join'		 => array(
				array('dprofil_siswa siswa', 'nilai.siswa_id = siswa.id', 'inner'),
				array('prd_semester semester', 'nilai.semester_id = semester.id', 'inner'),
				array('prd_ta ta', 'semester.ta_id = ta.id', 'inner'),
			),
			'order_by'	 => 'semester.id desc',
		);

		return $query;

	}
	// operasi data basic

	function browse($index = 0, $limit = 20)
	{
		$query = $this->query_2();
		$query = $this->filter_2($query);

		return $this->md->query($query)->resultset($index, $limit);

	}

	function expor()
	{
		$no = 0;
		$rowexcel = 20;
		$row = $this->ci->d['row'];
		$resultset = $this->ci->d['resultset'];
		$map_siswa = $this->cfgm('excel-map-siswa');
		$map_mapel = $this->cfgm('excel-map-mapel');
		$map_nilai = $this->cfgm('excel-map-nilai');
		$xstyle = array(
			'border-tipis'	 => array(
				'borders' => array(
					'allborders' => array(
						'style' => PHPExcel_Style_Border::BORDER_THIN
					)
				)
			),
			'rata-kanan'	 => array(
				'alignment' => array(
					'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
				),
			),
			'rata-tengah'	 => array(
				'alignment' => array(
					'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
				),
			),
		);
		$file_path = APP_ROOT.'content/'.strtolower(APP_SCOPE).'/template/nilai-semester.xls';

		$objPHPExcel = PHPExcel_IOFactory::load($file_path);

		if (!$objPHPExcel)
			return exit('File template error.');

		$sheet = $objPHPExcel->setActiveSheetIndex(0);

		// hide item yg tak perlu

		foreach (array(9, 10, 11, 12, 13, 14, 19) as $irow)
			$sheet->getRowDimension($irow)->setVisible(FALSE);

		foreach (array('B', 'C', 'D', 'E', 'F', 'G', 'H') as $xcol)
			$sheet->getColumnDimension($xcol)->setVisible(FALSE);

		// tulis profil siswa

		foreach ($map_siswa as $col => $cell)
			$sheet->setCellValue($cell, $row[$col]);

		// mulai input nilai

		foreach ($resultset['data'] as $nilpel):
			$no++;
			$rowexcel++;
			$sheet->setCellValue('A' . $rowexcel, $no);

			// profil pelajaran

			foreach ($map_mapel as $xcol => $dbcol)
				if (array_key_exists($dbcol, $nilpel))
					$sheet->setCellValue($xcol . $rowexcel, $nilpel[$dbcol]);

			// nilai siswa, numeric

			foreach ($map_nilai as $xcol => $dbcol)
				if (array_key_exists($dbcol, $nilpel))
					$sheet->setCellValue($xcol . $rowexcel, formnil_angka($nilpel[$dbcol]));

			// nilai predikat huruf

			$sheet->setCellValue('Q' . $rowexcel, formnil_predikat($nilpel['nas_skp']));

		endforeach;

		// format garis & align

		$sheet->getStyle("A21:CC{$rowexcel}")->applyFromArray($xstyle['border-tipis']);
		$sheet->getStyle("Q21:Q{$rowexcel}")->applyFromArray($xstyle['rata-tengah']);
		$sheet->getStyle("O21:P{$rowexcel}")->applyFromArray($xstyle['rata-kanan']);
		$sheet->getStyle("S21:CC{$rowexcel}")->applyFromArray($xstyle['rata-kanan']);

		// patokan nilai yg digunakan

		$qn['u'] = 6; // ulangan
		$qn['r'] = $qn['u']; // remidi
		$qn['h'] = $qn['u']; // harian
		$qn['t'] = 2; // tugas
		$qn['p'] = 2; // praktek
		$qn['s'] = 2; // sikap
		//
		// sembunyikan yg tidak digunakan

		foreach ($qn as $n => $q):
			for ($i = $q + 1; $i <= 10; $i++):
				$xcol = array_search($n . $i, $map_nilai);

				if ($xcol !== FALSE)
					$sheet->getColumnDimension($xcol)->setVisible(FALSE);

			endfor;
		endforeach;

		// title/judul header sheet

		$sheet->setCellValue('A1', "DAFTAR NILAI SISWA");

		// output file

		$nama = "nilai-semester_{$row['prd_ta']}-{$row['prd_semester']}_nis-{$row['siswa_nis']}.xls";
		header("Content-Type: application/vnd.ms-excel");
		header("Content-Disposition: attachment; filename=\"{$nama}\"");
		header("Cache-Control: max-age=0");
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, "Excel5");
		$objWriter->save("php://output");
		exit();

	}

	function rowset($id)
	{
		$query = $this->query_2();
		$query['where']['nilai.id'] = $id;

		$row = $this->md->query($query)->row();

		if (!$row OR $row['valid'])
			return $row;

		$this->rerata_by_list($id);
		$row = $this->md->query($query)->row();

		return $row;

	}

	function rowset3($id, $ta_id, $index = 0, $limit = 50)
	{
		/*
		$query = $this->query_3();
		$query['where']['nilai.siswa_id'] = $id;

		$row = $this->md->query($query)->row();

		if (!$row OR $row['valid'])
			return $row;

		$this->rerata_by_list($id);
		$row = $this->md->query($query)->row();

		return $row;
		*/
		$query = array(
			'select'	 => array(
				'nilai_id'			 => 'nilai.id',
				'siswa_id'			 => 'nilai.siswa_id',
				'ta_id'				 => 'ta.id',
				'ta_nama'			 => 'ta.nama',
				'semester_id'		 => 'semester.id',
				'semester_nama'		 => 'semester.nama',
			),
			'from'		 => 'nilai_siswa nilai',
			'join'		 => array(
				array('dprofil_siswa siswa', 'nilai.siswa_id = siswa.id', 'inner'),
				array('prd_semester semester', 'nilai.semester_id = semester.id', 'inner'),
				array('prd_ta ta', 'semester.ta_id = ta.id', 'inner'),
			),
			'order_by'	 => 'semester.id desc',
			'where'		 => array(
				'nilai.siswa_id'=> $id,
				'ta.id'			=> $ta_id
			),
		);

		return $this->md->query($query)->resultset($index, $limit);

	}
	function subrow_ekskul($siswa_nilai_id)
	{
		$select = array(
			'nisisxkul.*',
			'nixkul.ekskul_id',
			'nixkul.pembina_id',
			'ekskul_nama'	 => 'ekskul.nama',
			'pembina_nama'	 => "trim(concat_ws(' ', pembina.prefix, pembina.nama, pembina.suffix))",
		);
		$this->md->select($select)
			->from('nilai_siswa_ekskul nisisxkul')
			->join('nilai_ekskul nixkul', 'nisisxkul.ekskul_nilai_id = nixkul.id', 'inner')
			->join('dnakd_ekskul ekskul', 'nixkul.ekskul_id = ekskul.id', 'inner')
			//->join('dprofil_sdm pembina', 'nixkul.pembina_id = pembina.id', 'inner')
			->join('dprofil_sdm pembina', 'nixkul.pembina_id = pembina.id', 'left')
			->where('nisisxkul.siswa_nilai_id', $siswa_nilai_id)
			->order_by('ekskul.nama');

		return $this->md->result();

	}

	function subrow_org($siswa_nilai_id)
	{
		$select = array(
			'nisisorg.*',
			'niorg.pembina_id',
			'org_nama'		 => 'org.nama',
			'pembina_nama'	 => "trim(concat_ws(' ', pembina.prefix, pembina.nama, pembina.suffix))",
		);
		$this->md->select($select)
			->from('nilai_siswa_org nisisorg')
			->join('nilai_organisasi niorg', 'nisisorg.org_nilai_id = niorg.id', 'inner')
			->join('dnakd_organisasi org', 'niorg.org_id = org.id', 'inner')
			->join('dprofil_sdm pembina', 'niorg.pembina_id = pembina.id', 'left')
			->where('nisisorg.siswa_nilai_id', $siswa_nilai_id)
			->order_by('org.nama');

		return $this->md->result();

	}
	
	// PRESTASI
	function subrow_prestasi($siswa_nilai_id)
	{
		$sql = "
                    select
                        all_prestasi.*,
                        kegiatan_prestasi.nama as kegiatan_prestasi_nama,
                        all_prestasi.nama as prestasi_nama
                    from
                        dnakd_kegiatan_prestasi kegiatan_prestasi
                    left join
                    (
                        select
                            nisisprestasi.*,
                            prestasi.kegiatan_prestasi_id,
                            prestasi.nama
                        from
                            dnakd_prestasi prestasi
                        inner join
                            nilai_prestasi niprestasi
                            on niprestasi.prestasi_id = prestasi.id
                        inner join
                            nilai_siswa_prestasi nisisprestasi
                            on nisisprestasi.prestasi_nilai_id = niprestasi.id
                        where
                            nisisprestasi.siswa_nilai_id = " . $siswa_nilai_id . "
                    ) all_prestasi
                    on all_prestasi.kegiatan_prestasi_id = kegiatan_prestasi.id
                    order by
                        kegiatan_prestasi.id,all_prestasi.nama
                    ";
		return $this->md->result($sql);

	}
	// rerata nilai

	function rerata_by_list($list)
	{

		/*
		 * 1 datetime
		 */

		if (is_array($list))
			$list = implode(',', $list);

		$d = & $this->ci->d;
		$sql = "
update nilai_siswa nisis
inner join
(
	select
		siswa_nilai_id,
		sum(nas_total) nas_skor,
		avg(nas_total) nas_total,
		avg(nas_teori) nas_teori,
		avg(nas_praktek) nas_praktek,
		avg(uas) uas,
		avg(uts) uts,
		avg(h1) h1,
		avg(h2) h2,
		avg(h3) h3,
		avg(h4) h4,
		avg(h5) h5,
		avg(h6) h6,
		avg(h7) h7,
		avg(h8) h8,
		avg(h9) h9,
		avg(h10) h10,
		avg(h11) h11,
		avg(h12) h12,
		avg(t1) t1,
		avg(t2) t2,
		avg(t3) t3,
		avg(t4) t4,
		avg(t5) t5,
		avg(t6) t6,
		avg(t7) t7,
		avg(t8) t8,
		avg(t9) t9,
		avg(t10) t10,
		avg(t11) t11,
		avg(t12) t12,
		avg(p1) p1,
		avg(p2) p2,
		avg(p3) p3,
		avg(p4) p4,
		avg(p5) p5,
		avg(p6) p6,
		avg(p7) p7,
		avg(p8) p8,
		avg(p9) p9,
		avg(p10) p10,
		avg(p11) p11,
		avg(p12) p12
	from nilai_siswa_pelajaran
	where siswa_nilai_id in ({$list})
	group by siswa_nilai_id
) nisispel
	on nisis.id = nisispel.siswa_nilai_id
set
	nisis.nas_skor = nisispel.nas_skor,
	nisis.nas_total = nisispel.nas_total,
	nisis.nas_teori = nisispel.nas_teori,
	nisis.nas_praktek = nisispel.nas_praktek,
	nisis.uas = nisispel.uas,
	nisis.uts = nisispel.uts,
	nisis.h1 = nisispel.h1,
	nisis.h2 = nisispel.h2,
	nisis.h3 = nisispel.h3,
	nisis.h4 = nisispel.h4,
	nisis.h5 = nisispel.h5,
	nisis.h6 = nisispel.h6,
	nisis.h7 = nisispel.h7,
	nisis.h8 = nisispel.h8,
	nisis.h9 = nisispel.h9,
	nisis.h10 = nisispel.h10,
	nisis.h11 = nisispel.h11,
	nisis.h12 = nisispel.h12,
	nisis.t1 = nisispel.t1,
	nisis.t2 = nisispel.t2,
	nisis.t3 = nisispel.t3,
	nisis.t4 = nisispel.t4,
	nisis.t5 = nisispel.t5,
	nisis.t6 = nisispel.t6,
	nisis.t7 = nisispel.t7,
	nisis.t8 = nisispel.t8,
	nisis.t9 = nisispel.t9,
	nisis.t10 = nisispel.t10,
	nisis.t11 = nisispel.t11,
	nisis.t12 = nisispel.t12,
	nisis.p1 = nisispel.p1,
	nisis.p2 = nisispel.p2,
	nisis.p3 = nisispel.p3,
	nisis.p4 = nisispel.p4,
	nisis.p5 = nisispel.p5,
	nisis.p6 = nisispel.p6,
	nisis.p7 = nisispel.p7,
	nisis.p8 = nisispel.p8,
	nisis.p9 = nisispel.p9,
	nisis.p10 = nisispel.p10,
	nisis.p11 = nisispel.p11,
	nisis.p12 = nisispel.p12,
	nisis.valid = 1,
	nisis.diolah = ?
where id in ({$list})
";

		$this->db->trans_start();
		$this->db->query($sql, array($d['datetime']));

		return $this->trans_done("Nilai rata-rata siswa berhasil diperbarui", 'Database error saat memperbarui rata-rata nilai siswa.');

	}

	function rerata_by_nikls($nikls_id)
	{

		/*
		 * 1 nikls_id
		 * 2 datetime
		 * 3 nikls_id
		 */

		$d = & $this->ci->d;
		$sql = "
update nilai_siswa nisis
inner join
(
	select
		siswa_nilai_id,
		avg(nas_total) nas_total,
		avg(nas_teori) nas_teori,
		avg(nas_praktek) nas_praktek,
		avg(uas) uas,
		avg(uts) uts,
		avg(h1) h1,
		avg(h2) h2,
		avg(h3) h3,
		avg(h4) h4,
		avg(h5) h5,
		avg(h6) h6,
		avg(h7) h7,
		avg(h8) h8,
		avg(h9) h9,
		avg(h10) h10,
		avg(h11) h11,
		avg(h12) h12,
		avg(t1) t1,
		avg(t2) t2,
		avg(t3) t3,
		avg(t4) t4,
		avg(t5) t5,
		avg(t6) t6,
		avg(t7) t7,
		avg(t8) t8,
		avg(t9) t9,
		avg(t10) t10,
		avg(t11) t11,
		avg(t12) t12,
		avg(p1) p1,
		avg(p2) p2,
		avg(p3) p3,
		avg(p4) p4,
		avg(p5) p5,
		avg(p6) p6,
		avg(p7) p7,
		avg(p8) p8,
		avg(p9) p9,
		avg(p10) p10,
		avg(p11) p11,
		avg(p12) p12
	from nilai_siswa_pelajaran
	where kelas_nilai_id = ?
	group by siswa_nilai_id
) nisispel
	on nisis.id = nisispel.siswa_nilai_id
set
	nisis.nas_total = nisispel.nas_total,
	nisis.nas_teori = nisispel.nas_teori,
	nisis.nas_praktek = nisispel.nas_praktek,
	nisis.uas = nisispel.uas,
	nisis.uts = nisispel.uts,
	nisis.h1 = nisispel.h1,
	nisis.h2 = nisispel.h2,
	nisis.h3 = nisispel.h3,
	nisis.h4 = nisispel.h4,
	nisis.h5 = nisispel.h5,
	nisis.h6 = nisispel.h6,
	nisis.h7 = nisispel.h7,
	nisis.h8 = nisispel.h8,
	nisis.h9 = nisispel.h9,
	nisis.h10 = nisispel.h10,
	nisis.h11 = nisispel.h11,
	nisis.h12 = nisispel.h12,
	nisis.t1 = nisispel.t1,
	nisis.t2 = nisispel.t2,
	nisis.t3 = nisispel.t3,
	nisis.t4 = nisispel.t4,
	nisis.t5 = nisispel.t5,
	nisis.t6 = nisispel.t6,
	nisis.t7 = nisispel.t7,
	nisis.t8 = nisispel.t8,
	nisis.t9 = nisispel.t9,
	nisis.t10 = nisispel.t10,
	nisis.t11 = nisispel.t11,
	nisis.t12 = nisispel.t12,
	nisis.p1 = nisispel.p1,
	nisis.p2 = nisispel.p2,
	nisis.p3 = nisispel.p3,
	nisis.p4 = nisispel.p4,
	nisis.p5 = nisispel.p5,
	nisis.p6 = nisispel.p6,
	nisis.p7 = nisispel.p7,
	nisis.p8 = nisispel.p8,
	nisis.p9 = nisispel.p9,
	nisis.p10 = nisispel.p10,
	nisis.p11 = nisispel.p11,
	nisis.p12 = nisispel.p12,
	nisis.valid = 1,
	nisis.diolah = ?
where nisis.kelas_nilai_id = ?
";

		$this->db->trans_start();
		$this->db->query($sql, array($nikls_id, $d['datetime'], $nikls_id));

		return $this->trans_done("Nilai rata-rata siswa telah diperbarui", 'Database error saat memperbarui rata-rata nilai siswa.');

	}

	function reratareset_by_nipel($id)
	{

		/*
		 * 1 datetime
		 */

		$id = (int) $id;
		$sql = "
update nilai_siswa nisis
inner join nilai_siswa_pelajaran nisispel on nisis.id = nisispel.siswa_nilai_id
set
	nisis.valid = 0
where
	nisispel.pelajaran_nilai_id = ?
";

		$this->db->trans_start();
		$this->db->query($sql, array($id));
		return $this->trans_done();

	}

	// import nilai absen, skepribadian, kenaikan

	function impor_absen_kepribadian_format()
	{
		$this->load->library('PHPExcel');
		$this->load->helper('excel');

		// deklarasi variabel
		/*$cacheMethod = PHPExcel_CachedObjectStorageFactory:: cache_to_phpTemp;
		$cacheSettings = array( ' memoryCacheSize ' => '8MB');
		PHPExcel_Settings::setCacheStorageMethod($cacheMethod, $cacheSettings);
		*/
		if (TRUE):
			$d = & $this->ci->d;
			$dm = & $this->dm;
			$excel_source = APP_ROOT.'content/'.strtolower(APP_SCOPE).'/template/nilai_siswa.absen_kenaikan.blank.xlsx';
			
			$nisis_query = array(
				'from'	 => 'nilai_siswa nisis',
				'join'	 => array(
					array('dprofil_siswa siswa', 'nisis.siswa_id = siswa.id', 'inner'),
					array('dakd_kelas kelas', 'nisis.kelas_id = kelas.id', 'inner'),
					array('dmst_agama agama', 'siswa.agama_id = agama.id', 'inner'),
					array('prd_semester semester', 'nisis.semester_id = semester.id', 'left'),
					array('prd_ta ta', 'semester.ta_id = ta.id', 'left'),
				),
				'where'	 => array(
					'nisis.semester_id' => $d['semaktif']['id'],
				),
				'order_by'	 => 'kelas_nama asc, absen_no asc, siswa_nama asc',
				'select' => array(
					'nisis.*',
					'siswa_nis'		 => 'siswa.nis',
					'siswa_nama'	 => 'siswa.nama',
					'siswa_gender'	 => 'siswa.gender',
					'agama_nama'	 => 'agama.nama',
					'kelas_nama'	 => 'kelas.nama',
					'kelas_wali_id'	 => 'kelas.wali_id',
					'semester_nama'	 => 'semester.nama',
					'ta_nama'	 => 'ta.nama',
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
					'F'	 => array('agama_nama', 'ucwords'),
				),
			);
			$nisis_data = array();
			$kelas_jml = 0;
			$sheet_index = 0;
			$excel_row_offset = 13;
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

		array_autoint($kelas_list);

		$kelas_list = (array) array_intersect($kelas_list, array_keys($d['opsi_kelas']));

		if (empty($kelas_list) && empty($d['request']['semester_id']))
			return alert_error('Pilih kelas yang hendak diolah.', 'nilai/siswa/impor_absen_kepribadian');

		// ambil daftar nilai siswa
		if($kelas_list)
			$nisis_query['where_in']['kelas.id'] = $kelas_list;
		
		if($d['request']['kelas_id'])
			$nisis_query['where']['nisis.kelas_id'] = $d['request']['kelas_id'];
		
		if($d['request']['semester_id'])
			$nisis_query['where']['nisis.semester_id'] = $d['request']['semester_id'];
			
		$nisis_result = $this->md->query($nisis_query)->result();
		$kelas_list = array();

		if ($nisis_result['selected_rows'] == 0)
			return alert_error('Daftar nilai dari kelas yang dipilih kosong/tidak ditemukan.', 'nilai/siswa/impor_absen_kepribadian');

		// pengelompokan per kelas

		foreach ($nisis_result['data'] as $row):
			$kelas_id = (int) $row['kelas_id'];
			$nisis_data[$kelas_id]['data'][] = $row;

			if (!in_array($kelas_id, $kelas_list)):
				$wali_query['where_in']['id'][] = (int) $row['kelas_wali_id'];
				$nisis_data[$kelas_id]['wali_id'] = (int) $row['kelas_wali_id'];
				$nisis_data[$kelas_id]['nama'] = $row['kelas_nama'];
				$nisis_data[$kelas_id]['semester_nama'] = $row['semester_nama'];
				$nisis_data[$kelas_id]['ta_nama'] = $row['ta_nama'];
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
			
			$set_loophide = 1;
			if(strtolower(APP_SCOPE)=='sman8smg')
			{
				$sheet->setCellValue('A1', 'PEMERINTAH PROVINSI JAWA TENGAH');
				$sheet->setCellValue('A2', 'DINAS PENDIDIKAN DAN KEBUDAYAAN');
				$sheet->setCellValue('A3', 'SMA NEGERI 8 SEMARANG');
				$sheet->setCellValue('A4', 'Jl. Raya Tugu Semarang Telp.024 8664553 Fax. 024 8661798');
				$set_loophide = 5;
			}
			
			$sheet->setCellValue('A7', 'DAFTAR NILAI SEMESTER ' . strtoupper($data['semester_nama']));
			$sheet->setCellValue('A8', 'TAHUN AJARAN ' . $data['ta_nama']);
			
			$sheet->setCellValue('A10', 'Kelas : ' . $data['nama']);
			$sheet->setCellValue('A11', 'Wali Kelas : ' . array_node($wali_array, $data['wali_id']));

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

				foreach ($dm['map.absen'] as $colexcel => $dat):
					$sheet->setCellValue($colexcel . $excel_row, data_cell($dat, $row));
				endforeach;
				
				foreach ($dm['map.kenaikan_kelas'] as $colexcel => $dat):
					$sheet->setCellValue($colexcel . $excel_row, data_cell($dat, $row));
				endforeach;
				/*
				foreach ($dm['map.nilai_sikap'] as $colexcel => $dat):
					$sheet->setCellValue($colexcel . $excel_row, data_cell($dat, $row));
				endforeach;
				*/
				if($row['kode_kepribadian']!='')
				{
					$kepribadian = (array) json_decode($row['kode_kepribadian'], TRUE);
	
					foreach ($dm['map.kode_aspri.ktsp'] as $colexcel => $index):
						$sheet->setCellValue($colexcel . $excel_row, array_node($kepribadian, $index));
					endforeach;
				}
				
				if($row['predikat_sikap']!='')
				{
					$sikap = (array) json_decode($row['predikat_sikap'], TRUE);
	
					foreach ($dm['map.predikat_sikap.k13'] as $colexcel => $index):
						$sheet->setCellValue($colexcel . $excel_row, array_node($sikap, $index));
					endforeach;
				}
				/*
				$kepribadian = (array) json_decode($row['kepribadian'], TRUE);

				foreach ($dm['map.aspri.ktsp'] as $colexcel => $index):
					$sheet->setCellValue($colexcel . $excel_row, array_node($kepribadian, $index));
				endforeach;
				*/
			endforeach;

			// styling blok

			$sheet->getStyle("A{$row_start}:AJ{$row_end}")->applyFromArray($style['default']);

			// hide

			$sheet->getColumnDimension('B')->setVisible(FALSE);

			// lock
			if(strtolower(APP_SCOPE)=='sman8smg')
			{
				$_cell_input = array(
						// absensi
						"G{$row_start}:AJ{$row_end}",
						
						/// keterangan
						"AW14:BF18",
						"AW23:BA27",
						
				);
			}else{
				$_cell_input = array(
						// absensi
						"G{$row_start}:J{$row_end}",
						"L{$row_start}:L{$row_end}",
						"N{$row_start}:N{$row_end}",
						"P{$row_start}:P{$row_end}",
						"R{$row_start}:R{$row_end}",
						"T{$row_start}:T{$row_end}",
						"V{$row_start}:V{$row_end}",
						"X{$row_start}:X{$row_end}",
						"Z{$row_start}:Z{$row_end}",
						"AB{$row_start}:AB{$row_end}",
						"AE{$row_start}:AE{$row_end}",
						"AG{$row_start}:AG{$row_end}",
						"AI{$row_start}:AI{$row_end}",
						
						/// keterangan
						"AW14:BF18",
						"AW23:BA27",
						
				);
			}
			
			
			
			excel_security_cell_lock($sheet, 'A1:AV' . $row_end);
			excel_security_cell_unlock($sheet, $_cell_input);
			excel_security_sheet_lock($sheet);

		endforeach;

		// sembunyikan template

		$excel->removeSheetByIndex(0);

		// keamanan dokumen

		//excel_security_doc_lock($excel);

		// output

		return excel_output_2007($excel, 'nilai_absen_siswa.xlsx');

	}

	function impor_absen_kenaikan_format()
	{
		$this->load->library('PHPExcel');
		$this->load->helper('excel');

		// deklarasi variabel
		/*$cacheMethod = PHPExcel_CachedObjectStorageFactory:: cache_to_phpTemp;
		$cacheSettings = array( ' memoryCacheSize ' => '8MB');
		PHPExcel_Settings::setCacheStorageMethod($cacheMethod, $cacheSettings);
		*/
		if (TRUE):
			$d = & $this->ci->d;
			$dm = & $this->dm;
			$excel_source = APP_ROOT.'content/'.strtolower(APP_SCOPE).'/template/nilai_siswa.absen_kenaikan.blank.xlsx';
			
			$nisis_query = array(
				'from'	 => 'nilai_siswa nisis',
				'join'	 => array(
					array('dprofil_siswa siswa', 'nisis.siswa_id = siswa.id', 'inner'),
					array('dakd_kelas kelas', 'nisis.kelas_id = kelas.id', 'inner'),
					array('dmst_agama agama', 'siswa.agama_id = agama.id', 'inner'),
					array('prd_semester semester', 'nisis.semester_id = semester.id', 'left'),
					array('prd_ta ta', 'semester.ta_id = ta.id', 'left'),
				),
				'where'	 => array(
					'nisis.semester_id' => $d['semaktif']['id'],
				),
				'order_by'	 => 'kelas_nama asc, nisis.absen_no, siswa_nama asc',
				'select' => array(
					'nisis.*',
					'siswa_nis'		 => 'siswa.nis',
					'siswa_nama'	 => 'siswa.nama',
					'siswa_gender'	 => 'siswa.gender',
					'agama_nama'	 => 'agama.nama',
					'kelas_nama'	 => 'kelas.nama',
					'kelas_wali_id'	 => 'kelas.wali_id',
					'semester_nama'	 => 'semester.nama',
					'ta_nama'	 => 'ta.nama',
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
					'F'	 => array('agama_nama', 'ucwords'),
				),
			);
			$nisis_data = array();
			$kelas_jml = 0;
			$sheet_index = 0;
			$excel_row_offset = 13;
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

		array_autoint($kelas_list);

		$kelas_list = (array) array_intersect($kelas_list, array_keys($d['opsi_kelas']));

		if (empty($kelas_list) && empty($d['request']['semester_id']))
			return alert_error('Pilih kelas yang hendak diolah.', 'nilai/siswa/impor_absen');

		// ambil daftar nilai siswa
		if($kelas_list)
			$nisis_query['where_in']['kelas.id'] = $kelas_list;
		
		if($d['request']['kelas_id'])
			$nisis_query['where']['nisis.kelas_id'] = $d['request']['kelas_id'];
		
		if($d['request']['semester_id'])
			$nisis_query['where']['nisis.semester_id'] = $d['request']['semester_id'];
			
		$nisis_result = $this->md->query($nisis_query)->result();
		$kelas_list = array();

		if ($nisis_result['selected_rows'] == 0)
			return alert_error('Daftar nilai dari kelas yang dipilih kosong/tidak ditemukan.', 'nilai/siswa/impor_absen_kepribadian');

		// pengelompokan per kelas

		foreach ($nisis_result['data'] as $row):
			$kelas_id = (int) $row['kelas_id'];
			$nisis_data[$kelas_id]['data'][] = $row;

			if (!in_array($kelas_id, $kelas_list)):
				$wali_query['where_in']['id'][] = (int) $row['kelas_wali_id'];
				$nisis_data[$kelas_id]['wali_id'] = (int) $row['kelas_wali_id'];
				$nisis_data[$kelas_id]['nama'] = $row['kelas_nama'];
				$nisis_data[$kelas_id]['semester_nama'] = $row['semester_nama'];
				$nisis_data[$kelas_id]['ta_nama'] = $row['ta_nama'];
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
			$sheet->setCellValue('A7', 'DAFTAR NILAI SEMESTER ' . strtoupper($data['semester_nama']));
			$sheet->setCellValue('A8', 'TAHUN AJARAN ' . $data['ta_nama']);
			
			$sheet->setCellValue('A10', 'Kelas : ' . $data['nama']);
			$sheet->setCellValue('A11', 'Wali Kelas : ' . array_node($wali_array, $data['wali_id']));

			$set_loophide = 1;
			if(strtolower(APP_SCOPE)=='sman8smg')
			{
				$sheet->setCellValue('A1', 'PEMERINTAH PROVINSI JAWA TENGAH');
				$sheet->setCellValue('A2', 'DINAS PENDIDIKAN DAN KEBUDAYAAN');
				$sheet->setCellValue('A3', 'SMA NEGERI 8 SEMARANG');
				$sheet->setCellValue('A4', 'Jl. Raya Tugu Semarang Telp.024 8664553 Fax. 024 8661798');
				$set_loophide = 5;
			}
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

				foreach ($dm['map.absen'] as $colexcel => $dat):
					$sheet->setCellValue($colexcel . $excel_row, data_cell($dat, $row));
				endforeach;
				
				foreach ($dm['map.kenaikan_kelas'] as $colexcel => $dat):
					$sheet->setCellValue($colexcel . $excel_row, data_cell($dat, $row));
				endforeach;
			endforeach;

			// styling blok

			$sheet->getStyle("A{$row_start}:AF{$row_end}")->applyFromArray($style['default']);

			// hide

			$sheet->getColumnDimension('B')->setVisible(FALSE);
			for ($x = $set_loophide; $x <= 5; $x++) {
				$sheet->getRowDimension($x)->setVisible(FALSE);
			} 
			
			foreach (array('J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z','AA','AB','AC','AD') as $xcol){
				$sheet->getColumnDimension($xcol)->setVisible(FALSE);
			}

			// lock
				$_cell_input = array(
						// absensi
						"G{$row_start}:I{$row_end}",
						
						
						// kenaikan kelas
						"AE{$row_start}:AE{$row_end}",
				);
				
			
			
			
			
			//excel_security_cell_lock($sheet, 'A1:AV' . $row_end);
			excel_security_cell_unlock($sheet, $_cell_input);
			excel_security_sheet_lock($sheet);

		endforeach;

		// sembunyikan template

		$excel->removeSheetByIndex(0);

		// keamanan dokumen

		//excel_security_doc_lock($excel);

		// output $d['semaktif']['nama']

		return excel_output_2007($excel, 'nilai_absensi_siswa_'.$d['semaktif']['nama'].'.xlsx');

	}
	
	function impor_kepribadian_format()
	{
		$this->load->library('PHPExcel');
		$this->load->helper('excel');

		// deklarasi variabel
		/*$cacheMethod = PHPExcel_CachedObjectStorageFactory:: cache_to_phpTemp;
		$cacheSettings = array( ' memoryCacheSize ' => '8MB');
		PHPExcel_Settings::setCacheStorageMethod($cacheMethod, $cacheSettings);
		*/
		if (TRUE):
			$d = & $this->ci->d;
			$dm = & $this->dm;
			$excel_source = APP_ROOT.'content/'.strtolower(APP_SCOPE).'/template/nilai_siswa.aspri.blank.xlsx';
			
			$nisis_query = array(
				'from'	 => 'nilai_siswa nisis',
				'join'	 => array(
					array('dprofil_siswa siswa', 'nisis.siswa_id = siswa.id', 'inner'),
					array('dakd_kelas kelas', 'nisis.kelas_id = kelas.id', 'inner'),
					array('dmst_agama agama', 'siswa.agama_id = agama.id', 'inner'),
					array('prd_semester semester', 'nisis.semester_id = semester.id', 'left'),
					array('prd_ta ta', 'semester.ta_id = ta.id', 'left'),
					array('dmst_kurikulum kurikulum', 'kurikulum.id = kelas.kurikulum_id', 'inner'),
				),
				'where'	 => array(
					'nisis.semester_id' => $d['semaktif']['id'],
				),
				'order_by'	 => 'kelas_nama asc, nisis.absen_no, siswa_nama asc',
				'select' => array(
					'nisis.*',
					'siswa_nis'		 => 'siswa.nis',
					'siswa_nama'	 => 'siswa.nama',
					'siswa_gender'	 => 'siswa.gender',
					'agama_nama'	 => 'agama.nama',
					'kelas_nama'	 => 'kelas.nama',
					'kelas_wali_id'	 => 'kelas.wali_id',
					'semester_nama'	 => 'semester.nama',
					'ta_nama'	 => 'ta.nama',
					'kurikulum_nama'	 => 'kurikulum.nama',
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
					'F'	 => array('agama_nama', 'ucwords'),
				),
			);
			$nisis_data = array();
			$kelas_jml = 0;
			$sheet_index = 0;
			$excel_row_offset = 13;
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

		array_autoint($kelas_list);

		$kelas_list = (array) array_intersect($kelas_list, array_keys($d['opsi_kelas']));

		if (empty($kelas_list) && empty($d['request']['semester_id']))
			return alert_error('Pilih kelas yang hendak diolah.', 'nilai/siswa/impor_absen_kepribadian');

		// ambil daftar nilai siswa
		if($kelas_list)
			$nisis_query['where_in']['kelas.id'] = $kelas_list;
		
		if($d['request']['kelas_id'])
			$nisis_query['where']['nisis.kelas_id'] = $d['request']['kelas_id'];
		
		if($d['request']['semester_id'])
			$nisis_query['where']['nisis.semester_id'] = $d['request']['semester_id'];
			
		$nisis_result = $this->md->query($nisis_query)->result();
		$kelas_list = array();

		if ($nisis_result['selected_rows'] == 0)
			return alert_error('Daftar nilai dari kelas yang dipilih kosong/tidak ditemukan.', 'nilai/siswa/impor_absen_kepribadian');

		// pengelompokan per kelas

		foreach ($nisis_result['data'] as $row):
			$kelas_id = (int) $row['kelas_id'];
			$nisis_data[$kelas_id]['data'][] = $row;

			if (!in_array($kelas_id, $kelas_list)):
				$wali_query['where_in']['id'][] = (int) $row['kelas_wali_id'];
				$nisis_data[$kelas_id]['wali_id'] = (int) $row['kelas_wali_id'];
				$nisis_data[$kelas_id]['nama'] = $row['kelas_nama'];
				$nisis_data[$kelas_id]['semester_nama'] = $row['semester_nama'];
				$nisis_data[$kelas_id]['ta_nama'] = $row['ta_nama'];
				$nisis_data[$kelas_id]['kurikulum_nama'] = $row['kurikulum_nama'];
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
			
			$set_loophide = 1;
			if(strtolower(APP_SCOPE)=='sman8smg')
			{
				$sheet->setCellValue('A1', 'PEMERINTAH PROVINSI JAWA TENGAH');
				$sheet->setCellValue('A2', 'DINAS PENDIDIKAN DAN KEBUDAYAAN');
				$sheet->setCellValue('A3', 'SMA NEGERI 8 SEMARANG');
				$sheet->setCellValue('A4', 'Jl. Raya Tugu Semarang Telp.024 8664553 Fax. 024 8661798');
				$set_loophide = 5;
			}
			
			$sheet->setCellValue('A7', 'DAFTAR NILAI SEMESTER ' . strtoupper($data['semester_nama']));
			$sheet->setCellValue('A8', 'TAHUN AJARAN ' . $data['ta_nama']);
			//$sheet->setCellValue('D9', $data['kurikulum_nama']);
			
			$sheet->setCellValue('A10', 'Kelas : ' . $data['nama']);
			$sheet->setCellValue('A11', 'Wali Kelas : ' . array_node($wali_array, $data['wali_id']));

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
				
				/*
				foreach ($dm['map.nilai_sikap'] as $colexcel => $dat):
					$sheet->setCellValue($colexcel . $excel_row, data_cell($dat, $row));
				endforeach;
				*/
				if(strtolower($data['kurikulum_nama']) == 'ktsp'){
					
					if($row['kode_kepribadian']!='')
					{
						$kepribadian = (array) json_decode($row['kode_kepribadian'], TRUE);
		
						foreach ($dm['map.kode_aspri.ktsp'] as $colexcel => $index):
							$sheet->setCellValue($colexcel . $excel_row, array_node($kepribadian, $index));
						endforeach;
					}
				}else{
				//if(strtolower($data['kurikulum_nama']) == '2013'){
					if($row['predikat_sikap']!='')
					{
						$sikap = (array) json_decode($row['predikat_sikap'], TRUE);
		
						foreach ($dm['map.predikat_sikap.k13'] as $colexcel => $index):
							$sheet->setCellValue($colexcel . $excel_row, array_node($sikap, $index));
						endforeach;
					}
				}
				
				/*
				$kepribadian = (array) json_decode($row['kepribadian'], TRUE);

				foreach ($dm['map.aspri.ktsp'] as $colexcel => $index):
					$sheet->setCellValue($colexcel . $excel_row, array_node($kepribadian, $index));
				endforeach;
				*/
			endforeach;

			// styling blok

			$sheet->getStyle("A{$row_start}:AJ{$row_end}")->applyFromArray($style['default']);

			// hide

			$sheet->getColumnDimension('B')->setVisible(FALSE);
			for ($x = $set_loophide; $x <= 5; $x++) {
				$sheet->getRowDimension($x)->setVisible(FALSE);
			} 
			
			foreach (array('G','H','I','AD','AE','AF') as $xcol){
				$sheet->getColumnDimension($xcol)->setVisible(FALSE);
			}
			
			if(strtolower($data['kurikulum_nama']) == 'ktsp'){
				foreach (array('AG','AH','AI','AJ') as $xcol){
					$sheet->getColumnDimension($xcol)->setVisible(FALSE);
				}
			}else{
			
			//if(strtolower($data['kurikulum_nama']) == '2013'){
				foreach (array('J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z','AA','AB','AC') as $xcol){
					$sheet->getColumnDimension($xcol)->setVisible(FALSE);
				}
			}
			// lock
			if(strtolower(APP_SCOPE)=='sman8smg')
			{
				$_cell_input = array(
						// absensi
						"G{$row_start}:AJ{$row_end}",
						
						/// keterangan
						"AW14:BF18",
						"AW23:BA27",
						
				);
			}else{
				$_cell_input = array(
						// absensi
						"G{$row_start}:J{$row_end}",
						"L{$row_start}:L{$row_end}",
						"N{$row_start}:N{$row_end}",
						"P{$row_start}:P{$row_end}",
						"R{$row_start}:R{$row_end}",
						"T{$row_start}:T{$row_end}",
						"V{$row_start}:V{$row_end}",
						"X{$row_start}:X{$row_end}",
						"Z{$row_start}:Z{$row_end}",
						"AB{$row_start}:AB{$row_end}",
						"AE{$row_start}:AE{$row_end}",
						"AG{$row_start}:AG{$row_end}",
						"AI{$row_start}:AI{$row_end}",
						
						/// keterangan
						"AW14:BF18",
						"AW23:BA27",
						
				);
			}
			
			
			
			excel_security_cell_lock($sheet, 'A1:AV' . $row_end);
			excel_security_cell_unlock($sheet, $_cell_input);
			excel_security_sheet_lock($sheet);

		endforeach;

		// sembunyikan template

		$excel->removeSheetByIndex(0);

		// keamanan dokumen

		//excel_security_doc_lock($excel);

		// output

		return excel_output_2007($excel, 'nilai_kepribadian_siswa_'.$d['semaktif']['nama'].'.xlsx');

	}
	function impor_absen_kepribadian()
	{
		$d = & $this->ci->d;
		$dm = & $this->dm;
		$this->form->get();

		if ($d['error'])
			return FALSE;

		// upload

		$upload = $this->upload('upload', array('xls', 'xlsx'));
		
		if ($d['error'])
			return FALSE;

		// load file

		$upload['full_path'] = APP_ROOT.$upload['full_path'];
		@chmod($upload['full_path'], 0777);
		$this->load->library('PHPExcel');
		$PHPExcel = PHPExcel_IOFactory::load($upload['full_path']);
		$sheet_jml = $PHPExcel->getSheetCount();

		if (!$PHPExcel)
			return alert_error('File excel tak dapat dibaca.');

		if ($sheet_jml < 1)
			return alert_error('Sheet/halaman tidak dapat dibaca. ');

		if ($d['error']):
			@unlink($upload['full_path']);
			return FALSE;
		endif;

		// deklarasi variabel

		if (TRUE):
			$data_nisis = array();
			$nisis_list = array();
			$nisis_jml = 0;
			$row_start = 14;

		endif;

		// mulai ambil data

		for ($_sheet_index = 0; $_sheet_index < $sheet_jml; $_sheet_index++):
			$sheet = $PHPExcel->setActiveSheetIndex($_sheet_index);
			$row_max = $sheet->getHighestRow();

			if ($row_max < $row_start)
				continue;

			for ($_row_no = $row_start; $_row_no <= $row_max; $_row_no++):
				$_nisis_id = (int) $sheet->getCell('B' . $_row_no)->getValue();

				if ($_nisis_id < 1)
					continue;
				
				//  $nisis_jml++;
				//  $nisis_list[] = $_nisis_id;
				//  $data_nisis[] = array(
				//  'id' => $_nisis_id,
				//  'absen_s' => (int) $sheet->getCell('G' . $_row_no)->getValue(),
				//  'absen_i' => (int) $sheet->getCell('H' . $_row_no)->getValue(),
				//  'absen_a' => (int) $sheet->getCell('I' . $_row_no)->getValue(),
				//  );
				 //*
				 
				$nisis_list[] = $_nisis_id;
				$_row = array('id' => $_nisis_id);

				foreach ($dm['map.absen'] as $_excel_col => $_db_col):
					$_row[$_db_col] = (int) $sheet->getCell($_excel_col . $_row_no)->getValue();
				endforeach;

				foreach ($dm['map.kenaikan_kelas'] as $_excel_col => $_db_col):
					$_row[$_db_col] = clean($sheet->getCell($_excel_col . $_row_no)->getValue());
				endforeach;
				/*
				foreach ($dm['map.nilai_sikap'] as $_excel_col => $_db_col):
					$_row[$_db_col] = clean($sheet->getCell($_excel_col . $_row_no)->getValue());
				endforeach;
				*/
				
				//ktsp
				foreach ($dm['map.kode_aspri.ktsp'] as $_excel_col => $_db_col):
					$_row['kode_kepribadian'][$_db_col] = clean($sheet->getCell($_excel_col . $_row_no)->getValue());
				endforeach;
				
				foreach ($dm['map.aspri.ktsp'] as $_excel_col => $_db_col):
					$_row['kepribadian'][$_db_col] = clean($sheet->getCell($_excel_col . $_row_no)->getCalculatedValue());
				endforeach;
				
				// k13
				foreach ($dm['map.predikat_sikap.k13'] as $_excel_col => $_db_col):
					$_row['predikat_sikap'][$_db_col] = clean($sheet->getCell($_excel_col . $_row_no)->getValue());
				endforeach;
				
				foreach ($dm['map.deskripsi_sikap.k13'] as $_excel_col => $_db_col):
					$_row['deskripsi_sikap'][$_db_col] = clean($sheet->getCell($_excel_col . $_row_no)->getCalculatedValue());
				endforeach;
				
				//ktsp
				$_row['kode_kepribadian']	= json_encode($_row['kode_kepribadian']);
				$_row['kepribadian']		= json_encode($_row['kepribadian']);
				// k13
				$_row['predikat_sikap']		= json_encode($_row['predikat_sikap']);
				$_row['deskripsi_sikap']	= json_encode($_row['deskripsi_sikap']);
				
				$data_nisis[] = $_row;
				$nisis_jml++;

			endfor;

		endfor;

		//exit(print_r($data_nisis, TRUE));
		//selesai extract data
		unset($sheet);
		$PHPExcel->disconnectWorksheets();
		unset($PHPExcel);
		@unlink($upload['full_path']);

		// cek daftar nisispel skaligus ambil data list nilsis

		if ($nisis_jml < 1):
			alert_error('Daftar Nilai siswa kosong atau tidak terbaca.');
		endif;

		// cekpoin untuk error

		if ($d['error'])
			return FALSE;

		// pembaruan nilai_siswa

		$this->db->trans_start();
		$this->db->update_batch('nilai_siswa', $data_nisis, 'id');
		$this->trans_done('Daftar nilai telah diperbarui.', 'Database error saat memperbarui nilai siswa.');

		// selesai

		return !$d['error'];

	}

	function impor_absen_kenaikan()
	{
		$d = & $this->ci->d;
		$dm = & $this->dm;
		$this->form->get();

		if ($d['error'])
			return FALSE;

		// upload

		$upload = $this->upload('upload', array('xls', 'xlsx'));
		
		if ($d['error'])
			return FALSE;

		// load file

		$upload['full_path'] = APP_ROOT.$upload['full_path'];
		@chmod($upload['full_path'], 0777);
		$this->load->library('PHPExcel');
		$PHPExcel = PHPExcel_IOFactory::load($upload['full_path']);
		$sheet_jml = $PHPExcel->getSheetCount();

		if (!$PHPExcel)
			return alert_error('File excel tak dapat dibaca.');

		if ($sheet_jml < 1)
			return alert_error('Sheet/halaman tidak dapat dibaca. ');

		if ($d['error']):
			@unlink($upload['full_path']);
			return FALSE;
		endif;

		// deklarasi variabel

		if (TRUE):
			$data_nisis = array();
			$nisis_list = array();
			$nisis_jml = 0;
			$row_start = 14;

		endif;

		// mulai ambil data

		for ($_sheet_index = 0; $_sheet_index < $sheet_jml; $_sheet_index++):
			$sheet = $PHPExcel->setActiveSheetIndex($_sheet_index);
			$row_max = $sheet->getHighestRow();

			if ($row_max < $row_start)
				continue;

			for ($_row_no = $row_start; $_row_no <= $row_max; $_row_no++):
				$_nisis_id = (int) $sheet->getCell('B' . $_row_no)->getValue();

				if ($_nisis_id < 1)
					continue;
				
				//  $nisis_jml++;
				//  $nisis_list[] = $_nisis_id;
				//  $data_nisis[] = array(
				//  'id' => $_nisis_id,
				//  'absen_s' => (int) $sheet->getCell('G' . $_row_no)->getValue(),
				//  'absen_i' => (int) $sheet->getCell('H' . $_row_no)->getValue(),
				//  'absen_a' => (int) $sheet->getCell('I' . $_row_no)->getValue(),
				//  );
				 //*
				 
				$nisis_list[] = $_nisis_id;
				$_row = array('id' => $_nisis_id);

				foreach ($dm['map.absen'] as $_excel_col => $_db_col):
					$_row[$_db_col] = (int) $sheet->getCell($_excel_col . $_row_no)->getValue();
				endforeach;

				foreach ($dm['map.kenaikan_kelas'] as $_excel_col => $_db_col):
					$_row[$_db_col] = clean($sheet->getCell($_excel_col . $_row_no)->getValue());
				endforeach;
				/*
				foreach ($dm['map.nilai_sikap'] as $_excel_col => $_db_col):
					$_row[$_db_col] = clean($sheet->getCell($_excel_col . $_row_no)->getValue());
				endforeach;
				*/
				
				$data_nisis[] = $_row;
				$nisis_jml++;

			endfor;

		endfor;

		//exit(print_r($data_nisis, TRUE));
		//selesai extract data
		unset($sheet);
		$PHPExcel->disconnectWorksheets();
		unset($PHPExcel);
		@unlink($upload['full_path']);

		// cek daftar nisispel skaligus ambil data list nilsis

		if ($nisis_jml < 1):
			alert_error('Daftar Nilai siswa kosong atau tidak terbaca.');
		endif;

		// cekpoin untuk error

		if ($d['error'])
			return FALSE;

		// pembaruan nilai_siswa

		$this->db->trans_start();
		$this->db->update_batch('nilai_siswa', $data_nisis, 'id');
		$this->trans_done('Daftar nilai telah diperbarui.', 'Database error saat memperbarui nilai siswa.');

		// selesai

		return !$d['error'];

	}
	// peringkat

	function impor_kepribadian()
	{
		$d = & $this->ci->d;
		$dm = & $this->dm;
		$this->form->get();

		if ($d['error'])
			return FALSE;

		// upload

		$upload = $this->upload('upload', array('xls', 'xlsx'));
		
		if ($d['error'])
			return FALSE;

		// load file

		$upload['full_path'] = APP_ROOT.$upload['full_path'];
		@chmod($upload['full_path'], 0777);
		$this->load->library('PHPExcel');
		$PHPExcel = PHPExcel_IOFactory::load($upload['full_path']);
		$sheet_jml = $PHPExcel->getSheetCount();

		if (!$PHPExcel)
			return alert_error('File excel tak dapat dibaca.');

		if ($sheet_jml < 1)
			return alert_error('Sheet/halaman tidak dapat dibaca. ');

		if ($d['error']):
			@unlink($upload['full_path']);
			return FALSE;
		endif;

		// deklarasi variabel

		if (TRUE):
			$data_nisis = array();
			$nisis_list = array();
			$nisis_jml = 0;
			$row_start = 14;

		endif;

		// mulai ambil data

		for ($_sheet_index = 0; $_sheet_index < $sheet_jml; $_sheet_index++):
			$sheet = $PHPExcel->setActiveSheetIndex($_sheet_index);
			$row_max = $sheet->getHighestRow();

			if ($row_max < $row_start)
				continue;

			for ($_row_no = $row_start; $_row_no <= $row_max; $_row_no++):
				$_nisis_id = (int) $sheet->getCell('B' . $_row_no)->getValue();

				if ($_nisis_id < 1)
					continue;
				
				//  $nisis_jml++;
				//  $nisis_list[] = $_nisis_id;
				//  $data_nisis[] = array(
				//  'id' => $_nisis_id,
				//  'absen_s' => (int) $sheet->getCell('G' . $_row_no)->getValue(),
				//  'absen_i' => (int) $sheet->getCell('H' . $_row_no)->getValue(),
				//  'absen_a' => (int) $sheet->getCell('I' . $_row_no)->getValue(),
				//  );
				 //*
				 
				$nisis_list[] = $_nisis_id;
				$_row = array('id' => $_nisis_id);

				//ktsp
				foreach ($dm['map.kode_aspri.ktsp'] as $_excel_col => $_db_col):
					$_row['kode_kepribadian'][$_db_col] = clean($sheet->getCell($_excel_col . $_row_no)->getValue());
				endforeach;
				
				foreach ($dm['map.aspri.ktsp'] as $_excel_col => $_db_col):
					$_row['kepribadian'][$_db_col] = clean($sheet->getCell($_excel_col . $_row_no)->getCalculatedValue());
				endforeach;
				
				// k13
				foreach ($dm['map.predikat_sikap.k13'] as $_excel_col => $_db_col):
					$_row['predikat_sikap'][$_db_col] = clean($sheet->getCell($_excel_col . $_row_no)->getValue());
				endforeach;
				
				foreach ($dm['map.deskripsi_sikap.k13'] as $_excel_col => $_db_col):
					$_row['deskripsi_sikap'][$_db_col] = clean($sheet->getCell($_excel_col . $_row_no)->getCalculatedValue());
				endforeach;
				
				//ktsp
				$_row['kode_kepribadian']	= json_encode($_row['kode_kepribadian']);
				$_row['kepribadian']		= json_encode($_row['kepribadian']);
				// k13
				$_row['predikat_sikap']		= json_encode($_row['predikat_sikap']);
				$_row['deskripsi_sikap']	= json_encode($_row['deskripsi_sikap']);
				
				$data_nisis[] = $_row;
				$nisis_jml++;

			endfor;

		endfor;

		//exit(print_r($data_nisis, TRUE));
		//selesai extract data
		unset($sheet);
		$PHPExcel->disconnectWorksheets();
		unset($PHPExcel);
		@unlink($upload['full_path']);

		// cek daftar nisispel skaligus ambil data list nilsis

		if ($nisis_jml < 1):
			alert_error('Daftar Nilai siswa kosong atau tidak terbaca.');
		endif;

		// cekpoin untuk error

		if ($d['error'])
			return FALSE;

		// pembaruan nilai_siswa

		$this->db->trans_start();
		$this->db->update_batch('nilai_siswa', $data_nisis, 'id');
		$this->trans_done('Daftar nilai telah diperbarui.', 'Database error saat memperbarui nilai siswa.');

		// selesai

		return !$d['error'];

	}
	function rank_kelas($nikls_id)
	{
		$query = array(
			'select'	 => array('id'),
			'from'		 => 'nilai_siswa',
			'where'		 => array(
				'kelas_nilai_id' => $nikls_id,
			),
			'order_by'	 => 'nas_skor desc',
		);

		$list = $this->md->query($query)->result_values('id');

		if (empty($list))
			return;

		foreach ($list as $rank => $nisis_id)
			$update_batch[] = array(
				'id'		 => $nisis_id,
				'rank_kelas' => ($rank + 1),
			);

		$this->db->trans_begin();
		$this->db->update_batch('nilai_siswa', $update_batch, 'id');

		return $this->trans_done("Peringkat siswa telah diperbarui", 'Database error saat memperbarui peringkat siswa.');

	}

	///////////////////////////////////////////////////////////////////////////////////////////////////////
	function impor_kerja_lapangan_format()
	{
		$this->load->library('PHPExcel');
		$this->load->helper('excel');

		// deklarasi variabel

		if (TRUE):
			$d = & $this->ci->d;
			$dm = & $this->dm;
			$excel_source = APP_ROOT.'content/'.strtolower(APP_SCOPE).'/template/nilai_siswa.kerja_lapangan.blank.xlsx';
			$nisis_query = array(
				'from'	 => 'nilai_siswa nisis',
				'join'	 => array(
					array('dprofil_siswa siswa', 'nisis.siswa_id = siswa.id', 'inner'),
					array('dakd_kelas kelas', 'nisis.kelas_id = kelas.id', 'inner'),
					array('dmst_agama agama', 'siswa.agama_id = agama.id', 'left'),
				),
				'where'	 => array(
					'nisis.semester_id' => $d['semaktif']['id'],
				),
				'order_by'	 => 'kelas_nama asc, nisis.absen_no, siswa_nama asc',
				'select' => array(
					'nisis.*',
					'siswa_nis'		 => 'siswa.nis',
					'siswa_nama'	 => 'siswa.nama',
					'siswa_gender'	 => 'siswa.gender',
					'agama_nama'	 => 'agama.nama',
					'kelas_nama'	 => 'kelas.nama',
					'kelas_wali_id'	 => 'kelas.wali_id',
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
					'F'	 => array('agama_nama', 'ucwords'),
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
				$nisis_data[$kelas_id]['nama'] = $row['kelas_nama'];
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

				// Kerja Lapangan
				if(APP_SUBDOMAIN=='smkn6smg'){
					foreach ($dm['map.kerja_lapangan_smk6'] as $colexcel => $dat):
						$sheet->setCellValue($colexcel . $excel_row, data_cell($dat, $row));
					endforeach;
				}else{
					foreach ($dm['map.kerja_lapangan'] as $colexcel => $dat):
						if($dat != 'pkl_predikat')
						{
							$sheet->setCellValue($colexcel . $excel_row, data_cell($dat, $row));
						}
					endforeach;
				}

			endforeach;

			// styling blok

			$sheet->getStyle("A{$row_start}:G{$row_end}")->applyFromArray($style['default']);

			// hide

			$sheet->getColumnDimension('B')->setVisible(FALSE);

			// lock
			$_cell_input = array("G{$row_start}:X{$row_end}","X{$row_start}:X{$row_end}");
			
			excel_security_cell_lock($sheet, 'A1:M' . $row_end);
			excel_security_cell_unlock($sheet, $_cell_input);
			excel_security_sheet_lock($sheet);

		endforeach;

		// sembunyikan template

		$excel->removeSheetByIndex(0);

		// keamanan dokumen

		excel_security_doc_lock($excel);

		// output

		return excel_output_2007($excel, 'laporan_kerja_lapangan.xlsx');

	}

	function impor_kerja_lapangan()
	{
		$d = & $this->ci->d;
		$dm = & $this->dm;
		$this->form->get();

		if ($d['error'])
			return FALSE;

		// upload

		$upload = $this->upload('upload', array('xls', 'xlsx'));

		if ($d['error'])
			return FALSE;

		// load file
		$upload['full_path'] = APP_ROOT.$upload['full_path'];
		@chmod($upload['full_path'], 0777);
		$this->load->library('PHPExcel');
		$PHPExcel = PHPExcel_IOFactory::load($upload['full_path']);
		$sheet_jml = $PHPExcel->getSheetCount();

		if (!$PHPExcel)
			return alert_error('File excel tak dapat dibaca.');

		if ($sheet_jml < 1)
			return alert_error('Sheet/halaman tidak dapat dibaca.');

		if ($d['error']):
			@unlink($upload['full_path']);
			return FALSE;
		endif;

		// deklarasi variabel

		if (TRUE):
			$data_nisis = array();
			$nisis_list = array();
			$nisis_jml = 0;
			$row_start = 7;

		endif;

		// mulai ambil data

		for ($_sheet_index = 0; $_sheet_index < $sheet_jml; $_sheet_index++):
			$sheet = $PHPExcel->setActiveSheetIndex($_sheet_index);
			$row_max = $sheet->getHighestRow();

			if ($row_max < $row_start)
				continue;

			for ($_row_no = $row_start; $_row_no <= $row_max; $_row_no++):
				$_nisis_id = (int) $sheet->getCell('B' . $_row_no)->getValue();

				if ($_nisis_id < 1)
					continue;

				$nisis_list[] = $_nisis_id;
				
				$_row['id'] = $_nisis_id;
				if(APP_SUBDOMAIN=='smkn6smg'){
					foreach ($dm['map.kerja_lapangan_smk6'] as $_excel_col => $_db_col):
						$_row[$_db_col] = clean($sheet->getCell($_excel_col . $_row_no)->getCalculatedValue());
					endforeach;
				}else{
					foreach ($dm['map.kerja_lapangan'] as $_excel_col => $_db_col):
						$_row[$_db_col] = clean($sheet->getCell($_excel_col . $_row_no)->getCalculatedValue());
					endforeach;
				}
				
				$data_nisis[] = $_row;
				$nisis_jml++;

			endfor;
			
			

		endfor;

		//selesai extract data

		unset($sheet);
		$PHPExcel->disconnectWorksheets();
		unset($PHPExcel);
		@unlink($upload['full_path']);

		// cek daftar nisispel skaligus ambil data list nilsis

		if ($nisis_jml < 1):
			alert_error('Daftar Nilai siswa kosong atau tidak terbaca.');
		endif;

		// cekpoin untuk error

		if ($d['error'])
			return FALSE;

		// pembaruan nilai_siswa

		$this->db->trans_start();
		$this->db->update_batch('nilai_siswa', $data_nisis, 'id');
		$this->trans_done('Daftar keterangan telah diperbarui.', 'Database error saat memperbarui nilai siswa.');

		// selesai

		return !$d['error'];

	}
	
	////////////////////////////////////////////////////////////////////////////////////////////////////////
	
	// import nilai keterangan_walikelas_format
	
	function impor_keterangan_walikelas_format()
	{
		$this->load->library('PHPExcel');
		$this->load->helper('excel');

		// deklarasi variabel

		if (TRUE):
			$d = & $this->ci->d;
			$dm = & $this->dm;
			$excel_source = APP_ROOT.'content/'.strtolower(APP_SCOPE).'/template/nilai_siswa.walikelas.blank.xlsx';
			$nisis_query = array(
				'from'	 => 'nilai_siswa nisis',
				'join'	 => array(
					array('dprofil_siswa siswa', 'nisis.siswa_id = siswa.id', 'inner'),
					array('dakd_kelas kelas', 'nisis.kelas_id = kelas.id', 'inner'),
					array('dmst_agama agama', 'siswa.agama_id = agama.id', 'left'),
				),
				'where'	 => array(
					'nisis.semester_id' => $d['semaktif']['id'],
				),
				'order_by'	 => 'kelas_nama asc, nisis.absen_no, siswa_nama asc',
				'select' => array(
					'nisis.*',
					'siswa_nis'		 => 'siswa.nis',
					'siswa_nama'	 => 'siswa.nama',
					'siswa_gender'	 => 'siswa.gender',
					'agama_nama'	 => 'agama.nama',
					'kelas_id'	 	 => 'kelas.id',
					'kelas_nama'	 => 'kelas.nama',
					'kelas_wali_id'	 => 'kelas.wali_id',
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
					'F'	 => array('agama_nama', 'ucwords'),
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

				$sheet->setCellValue('G' . $excel_row, $row['kode_note_walikelas']);

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

		return excel_output_2007($excel, 'keterangan_walikelas.xlsx');

	}

	function impor_keterangan_walikelas()
	{
		$d = & $this->ci->d;
		$dm = & $this->dm;
		$this->form->get();

		if ($d['error'])
			return FALSE;

		// upload

		$upload = $this->upload('upload', array('xls', 'xlsx'));

		if ($d['error'])
			return FALSE;

		// load file
		$upload['full_path'] = APP_ROOT.$upload['full_path'];
		@chmod($upload['full_path'], 0777);
		$this->load->library('PHPExcel');
		$PHPExcel = PHPExcel_IOFactory::load($upload['full_path']);
		$sheet_jml = $PHPExcel->getSheetCount();

		if (!$PHPExcel)
			return alert_error('File excel tak dapat dibaca.');

		if ($sheet_jml < 1)
			return alert_error('Sheet/halaman tidak dapat dibaca.');

		if ($d['error']):
			@unlink($upload['full_path']);
			return FALSE;
		endif;

		// deklarasi variabel

		if (TRUE):
			$data_nisis = array();
			$nisis_list = array();
			$nisis_jml = 0;
			$row_start = 7;

		endif;

		// mulai ambil data

		for ($_sheet_index = 0; $_sheet_index < $sheet_jml; $_sheet_index++):
			$sheet = $PHPExcel->setActiveSheetIndex($_sheet_index);
			$row_max = $sheet->getHighestRow();

			if ($row_max < $row_start)
				continue;

			for ($_row_no = $row_start; $_row_no <= $row_max; $_row_no++):
				$_nisis_id = (int) $sheet->getCell('B' . $_row_no)->getValue();

				if ($_nisis_id < 1)
					continue;

				$nisis_list[] = $_nisis_id;
				$_row = array(
					'id'			 => $_nisis_id,
					'kode_note_walikelas' => clean($sheet->getCell('G' . $_row_no)->getValue()),
					'note_walikelas' => clean($sheet->getCell('H' . $_row_no)->getCalculatedValue()),
				);
				$data_nisis[] = $_row;
				$nisis_jml++;

			endfor;

		endfor;

		//selesai extract data

		unset($sheet);
		$PHPExcel->disconnectWorksheets();
		unset($PHPExcel);
		@unlink($upload['full_path']);

		// cek daftar nisispel skaligus ambil data list nilsis

		if ($nisis_jml < 1):
			alert_error('Daftar Nilai siswa kosong atau tidak terbaca.');
		endif;

		// cekpoin untuk error

		if ($d['error'])
			return FALSE;

		// pembaruan nilai_siswa

		$this->db->trans_start();
		$this->db->update_batch('nilai_siswa', $data_nisis, 'id');
		$this->trans_done('Daftar keterangan telah diperbarui.', 'Database error saat memperbarui nilai siswa.');

		// selesai

		return !$d['error'];

	}
	
	function impor_cat_perkembangan_karakter_format()
	{
		$this->load->library('PHPExcel');
		$this->load->helper('excel');

		// deklarasi variabel

		if (TRUE):
			$d = & $this->ci->d;
			$dm = & $this->dm;
			$excel_source = APP_ROOT.'content/'.strtolower(APP_SCOPE).'/template/nilai_siswa.cat_perkembangan_karakter.blank.xlsx';
			$nisis_query = array(
				'from'	 => 'nilai_siswa nisis',
				'join'	 => array(
					array('dprofil_siswa siswa', 'nisis.siswa_id = siswa.id', 'inner'),
					array('dakd_kelas kelas', 'nisis.kelas_id = kelas.id', 'inner'),
					array('dmst_agama agama', 'siswa.agama_id = agama.id', 'left'),
				),
				'where'	 => array(
					'nisis.semester_id' => $d['semaktif']['id'],
				),
				'order_by'	 => 'kelas_nama asc, nisis.absen_no, siswa_nama asc',
				'select' => array(
					'nisis.*',
					'siswa_nis'		 => 'siswa.nis',
					'siswa_nama'	 => 'siswa.nama',
					'siswa_gender'	 => 'siswa.gender',
					'agama_nama'	 => 'agama.nama',
					'kelas_id'	 	 => 'kelas.id',
					'kelas_nama'	 => 'kelas.nama',
					'kelas_wali_id'	 => 'kelas.wali_id',
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
					'F'	 => array('agama_nama', 'ucwords'),
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

				$sheet->setCellValue('G' . $excel_row, $row['kode_note_kembang_siswa']);

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

		return excel_output_2007($excel, 'catatan_perkembangan_karakter.xlsx');

	}
	
	function impor_cat_perkembangan_karakter()
	{
		$d = & $this->ci->d;
		$dm = & $this->dm;
		$this->form->get();

		if ($d['error'])
			return FALSE;

		// upload

		$upload = $this->upload('upload', array('xls', 'xlsx'));

		if ($d['error'])
			return FALSE;

		// load file
		$upload['full_path'] = APP_ROOT.$upload['full_path'];
		@chmod($upload['full_path'], 0777);
		$this->load->library('PHPExcel');
		$PHPExcel = PHPExcel_IOFactory::load($upload['full_path']);
		$sheet_jml = $PHPExcel->getSheetCount();

		if (!$PHPExcel)
			return alert_error('File excel tak dapat dibaca.');

		if ($sheet_jml < 1)
			return alert_error('Sheet/halaman tidak dapat dibaca.');

		if ($d['error']):
			@unlink($upload['full_path']);
			return FALSE;
		endif;

		// deklarasi variabel

		if (TRUE):
			$data_nisis = array();
			$nisis_list = array();
			$nisis_jml = 0;
			$row_start = 7;

		endif;

		// mulai ambil data

		for ($_sheet_index = 0; $_sheet_index < $sheet_jml; $_sheet_index++):
			$sheet = $PHPExcel->setActiveSheetIndex($_sheet_index);
			$row_max = $sheet->getHighestRow();

			if ($row_max < $row_start)
				continue;

			for ($_row_no = $row_start; $_row_no <= $row_max; $_row_no++):
				$_nisis_id = (int) $sheet->getCell('B' . $_row_no)->getValue();

				if ($_nisis_id < 1)
					continue;

				$nisis_list[] = $_nisis_id;
				$_row = array(
					'id'			 => $_nisis_id,
					'kode_note_kembang_siswa' => clean($sheet->getCell('G' . $_row_no)->getValue()),
					'note_kembang_siswa' => clean($sheet->getCell('H' . $_row_no)->getCalculatedValue()),
				);
				$data_nisis[] = $_row;
				$nisis_jml++;

			endfor;

		endfor;

		//selesai extract data

		unset($sheet);
		$PHPExcel->disconnectWorksheets();
		unset($PHPExcel);
		@unlink($upload['full_path']);

		// cek daftar nisispel skaligus ambil data list nilsis

		if ($nisis_jml < 1):
			alert_error('Daftar Nilai siswa kosong atau tidak terbaca.');
		endif;

		// cekpoin untuk error

		if ($d['error'])
			return FALSE;

		// pembaruan nilai_siswa

		$this->db->trans_start();
		$this->db->update_batch('nilai_siswa', $data_nisis, 'id');
		$this->trans_done('Daftar keterangan telah diperbarui.', 'Database error saat memperbarui nilai siswa.');

		// selesai

		return !$d['error'];

	}
	
	/////  deskripsi perkembangan_karakter
	function impor_des_perkembangan_karakter_format()
	{
		$this->load->library('PHPExcel');
		$this->load->helper('excel');

		// deklarasi variabel

		if (TRUE):
			$d = & $this->ci->d;
			$dm = & $this->dm;
			$excel_source = APP_ROOT.'content/'.strtolower(APP_SCOPE).'/template/nilai_siswa.des_perkembangan_karakter.blank.xlsx';
			$nisis_query = array(
				'from'	 => 'nilai_siswa nisis',
				'join'	 => array(
					array('dprofil_siswa siswa', 'nisis.siswa_id = siswa.id', 'inner'),
					array('dakd_kelas kelas', 'nisis.kelas_id = kelas.id', 'inner'),
					array('dmst_agama agama', 'siswa.agama_id = agama.id', 'left'),
				),
				'where'	 => array(
					'nisis.semester_id' => $d['semaktif']['id'],
				),
				'order_by'	 => 'kelas_nama asc, nisis.absen_no, siswa_nama asc',
				'select' => array(
					'nisis.*',
					'siswa_nis'		 => 'siswa.nis',
					'siswa_nama'	 => 'siswa.nama',
					'siswa_gender'	 => 'siswa.gender',
					'agama_nama'	 => 'agama.nama',
					'kelas_id'	 	 => 'kelas.id',
					'kelas_nama'	 => 'kelas.nama',
					'kelas_wali_id'	 => 'kelas.wali_id',
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
					'F'	 => array('agama_nama', 'ucwords'),
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
/*
				$sheet->setCellValue('G' . $excel_row, $row['des_integritas']);
				$sheet->setCellValue('H' . $excel_row, $row['des_religius']);
				$sheet->setCellValue('I' . $excel_row, $row['des_nasionalis']);
				$sheet->setCellValue('J' . $excel_row, $row['des_mandiri']);
				$sheet->setCellValue('K' . $excel_row, $row['des_got_royong']);
		*/		
				foreach ($dm['map.expor.des_perkembangan_karakter'] as $_excel_col => $_db_col):
					$sheet->setCellValue($_excel_col . $excel_row, $row[$_db_col]);
				endforeach;

			endforeach;

			// styling blok

			$sheet->getStyle("A{$row_start}:G{$row_end}")->applyFromArray($style['default']);

			// hide

			$sheet->getColumnDimension('B')->setVisible(FALSE);

			// lock
			$_cell_input = array(
				"G{$row_start}:G{$row_end}",
				"I{$row_start}:I{$row_end}",
				"K{$row_start}:K{$row_end}",
				"M{$row_start}:M{$row_end}",
				"O{$row_start}:O{$row_end}"
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

		return excel_output_2007($excel, 'deskripsi_perkembangan_karakter.xlsx');

	}
	
	function impor_des_perkembangan_karakter()
	{
		$d = & $this->ci->d;
		$dm = & $this->dm;
		$this->form->get();

		if ($d['error'])
			return FALSE;

		// upload

		$upload = $this->upload('upload', array('xls', 'xlsx'));

		if ($d['error'])
			return FALSE;

		// load file
		$upload['full_path'] = APP_ROOT.$upload['full_path'];
		@chmod($upload['full_path'], 0777);
		$this->load->library('PHPExcel');
		$PHPExcel = PHPExcel_IOFactory::load($upload['full_path']);
		$sheet_jml = $PHPExcel->getSheetCount();

		if (!$PHPExcel)
			return alert_error('File excel tak dapat dibaca.');

		if ($sheet_jml < 1)
			return alert_error('Sheet/halaman tidak dapat dibaca.');

		if ($d['error']):
			@unlink($upload['full_path']);
			return FALSE;
		endif;

		// deklarasi variabel

		if (TRUE):
			$data_nisis = array();
			$nisis_list = array();
			$nisis_jml = 0;
			$row_start = 7;

		endif;

		// mulai ambil data

		for ($_sheet_index = 0; $_sheet_index < $sheet_jml; $_sheet_index++):
			$sheet = $PHPExcel->setActiveSheetIndex($_sheet_index);
			$row_max = $sheet->getHighestRow();

			if ($row_max < $row_start)
				continue;

			for ($_row_no = $row_start; $_row_no <= $row_max; $_row_no++):
				$_nisis_id = (int) $sheet->getCell('B' . $_row_no)->getValue();

				if ($_nisis_id < 1)
					continue;

				$nisis_list[] = $_nisis_id;
				$_row = array(
					'id'			 	=> $_nisis_id
				);
				
				foreach ($dm['map.impor.des_perkembangan_karakter'] as $_excel_col => $_db_col):
					$_row[$_db_col] = clean($sheet->getCell($_excel_col . $_row_no)->getCalculatedValue());
				endforeach;
				
				$data_nisis[] = $_row;
				$nisis_jml++;

			endfor;

		endfor;

		//selesai extract data

		unset($sheet);
		$PHPExcel->disconnectWorksheets();
		unset($PHPExcel);
		@unlink($upload['full_path']);

		// cek daftar nisispel skaligus ambil data list nilsis

		if ($nisis_jml < 1):
			alert_error('Daftar Nilai siswa kosong atau tidak terbaca.');
		endif;

		// cekpoin untuk error

		if ($d['error'])
			return FALSE;

		// pembaruan nilai_siswa

		$this->db->trans_start();
		$this->db->update_batch('nilai_siswa', $data_nisis, 'id');
		$this->trans_done('Daftar keterangan telah diperbarui.', 'Database error saat memperbarui nilai siswa.');

		// selesai

		return !$d['error'];

	}
	
	/////  Data Prestasi BTA
	function impor_data_prestasi_bta_format()
	{
		$this->load->library('PHPExcel');
		$this->load->helper('excel');

		// deklarasi variabel

		if (TRUE):
			$d = & $this->ci->d;
			$dm = & $this->dm;
			$excel_source = APP_ROOT.'content/'.strtolower(APP_SCOPE).'/template/nilai_siswa.data_prestasi_bta.blank.xlsx';
			$nisis_query = array(
				'from'	 => 'nilai_siswa nisis',
				'join'	 => array(
					array('dprofil_siswa siswa', 'nisis.siswa_id = siswa.id', 'inner'),
					array('dakd_kelas kelas', 'nisis.kelas_id = kelas.id', 'inner'),
					array('dmst_agama agama', 'siswa.agama_id = agama.id', 'left'),
				),
				'where'	 => array(
					'nisis.semester_id' => $d['semaktif']['id'],
				),
				'order_by'	 => 'kelas_nama asc, nisis.absen_no, siswa_nama asc',
				'select' => array(
					'nisis.*',
					'siswa_nis'		 => 'siswa.nis',
					'siswa_nama'	 => 'siswa.nama',
					'siswa_gender'	 => 'siswa.gender',
					'agama_nama'	 => 'agama.nama',
					'kelas_id'	 	 => 'kelas.id',
					'kelas_nama'	 => 'kelas.nama',
					'kelas_wali_id'	 => 'kelas.wali_id',
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
					'F'	 => array('agama_nama', 'ucwords'),
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

				$sheet->setCellValue('G' . $excel_row, $row['bta_materi1']);
				$sheet->setCellValue('H' . $excel_row, $row['bta_nilai1']);
				$sheet->setCellValue('I' . $excel_row, $row['bta_ket1']);
				
				$sheet->setCellValue('J' . $excel_row, $row['bta_materi2']);
				$sheet->setCellValue('K' . $excel_row, $row['bta_nilai2']);
				$sheet->setCellValue('L' . $excel_row, $row['bta_ket2']);

				$sheet->setCellValue('M' . $excel_row, $row['bta_materi3']);
				$sheet->setCellValue('N' . $excel_row, $row['bta_nilai3']);
				$sheet->setCellValue('O' . $excel_row, $row['bta_ket3']);
				
				$sheet->setCellValue('P' . $excel_row, $row['bta_materi4']);
				$sheet->setCellValue('Q' . $excel_row, $row['bta_nilai4']);
				$sheet->setCellValue('R' . $excel_row, $row['bta_ket4']);

				$sheet->setCellValue('S' . $excel_row, $row['bta_materi5']);
				$sheet->setCellValue('T' . $excel_row, $row['bta_nilai5']);
				$sheet->setCellValue('U' . $excel_row, $row['bta_ket5']);
				
				$sheet->setCellValue('V' . $excel_row, $row['bta_catatan']);

			endforeach;

			// styling blok

			$sheet->getStyle("A{$row_start}:G{$row_end}")->applyFromArray($style['default']);

			// hide

			$sheet->getColumnDimension('B')->setVisible(FALSE);

			// lock
			$_cell_input = array(
				"G{$row_start}:V{$row_end}"
				);
			
			excel_security_cell_lock($sheet, 'A1:W' . $row_end);
			excel_security_cell_unlock($sheet, $_cell_input);
			excel_security_sheet_lock($sheet);

		endforeach;

		// sembunyikan template

		$excel->removeSheetByIndex(0);

		// keamanan dokumen

		excel_security_doc_lock($excel);

		// output

		return excel_output_2007($excel, 'data_prestasi_bta.xlsx');

	}
	
	function impor_data_prestasi_bta()
	{
		$d = & $this->ci->d;
		$dm = & $this->dm;
		$this->form->get();

		if ($d['error'])
			return FALSE;

		// upload

		$upload = $this->upload('upload', array('xls', 'xlsx'));

		if ($d['error'])
			return FALSE;

		// load file
		$upload['full_path'] = APP_ROOT.$upload['full_path'];
		@chmod($upload['full_path'], 0777);
		$this->load->library('PHPExcel');
		$PHPExcel = PHPExcel_IOFactory::load($upload['full_path']);
		$sheet_jml = $PHPExcel->getSheetCount();

		if (!$PHPExcel)
			return alert_error('File excel tak dapat dibaca.');

		if ($sheet_jml < 1)
			return alert_error('Sheet/halaman tidak dapat dibaca.');

		if ($d['error']):
			@unlink($upload['full_path']);
			return FALSE;
		endif;

		// deklarasi variabel

		if (TRUE):
			$data_nisis = array();
			$nisis_list = array();
			$nisis_jml = 0;
			$row_start = 7;

		endif;

		// mulai ambil data

		for ($_sheet_index = 0; $_sheet_index < $sheet_jml; $_sheet_index++):
			$sheet = $PHPExcel->setActiveSheetIndex($_sheet_index);
			$row_max = $sheet->getHighestRow();

			if ($row_max < $row_start)
				continue;

			for ($_row_no = $row_start; $_row_no <= $row_max; $_row_no++):
				$_nisis_id = (int) $sheet->getCell('B' . $_row_no)->getValue();

				if ($_nisis_id < 1)
					continue;

				$nisis_list[] = $_nisis_id;
				$_row = array(
					'id'			=> $_nisis_id,
					'bta_materi1' 	=> clean($sheet->getCell('G' . $_row_no)->getValue()),
					'bta_nilai1'	=> clean($sheet->getCell('H' . $_row_no)->getValue()),
					'bta_ket1'		=> clean($sheet->getCell('I' . $_row_no)->getValue()),
					
					'bta_materi2'	=> clean($sheet->getCell('J' . $_row_no)->getValue()),
					'bta_nilai2'	=> clean($sheet->getCell('K' . $_row_no)->getValue()),
					'bta_ket2'		=> clean($sheet->getCell('L' . $_row_no)->getValue()),
					
					'bta_materi3' 	=> clean($sheet->getCell('M' . $_row_no)->getValue()),
					'bta_nilai3'	=> clean($sheet->getCell('N' . $_row_no)->getValue()),
					'bta_ket3'		=> clean($sheet->getCell('O' . $_row_no)->getValue()),
					
					'bta_materi4'	=> clean($sheet->getCell('P' . $_row_no)->getValue()),
					'bta_nilai4'	=> clean($sheet->getCell('Q' . $_row_no)->getValue()),
					'bta_ket4'		=> clean($sheet->getCell('R' . $_row_no)->getValue()),
					
					'bta_materi5' 	=> clean($sheet->getCell('S' . $_row_no)->getValue()),
					'bta_nilai5'	=> clean($sheet->getCell('T' . $_row_no)->getValue()),
					'bta_ket5'		=> clean($sheet->getCell('U' . $_row_no)->getValue()),
					
					'bta_catatan'	=> clean($sheet->getCell('V' . $_row_no)->getValue()),
				);
				$data_nisis[] = $_row;
				$nisis_jml++;

			endfor;

		endfor;

		//selesai extract data

		unset($sheet);
		$PHPExcel->disconnectWorksheets();
		unset($PHPExcel);
		@unlink($upload['full_path']);

		// cek daftar nisispel skaligus ambil data list nilsis

		if ($nisis_jml < 1):
			alert_error('Daftar Nilai siswa kosong atau tidak terbaca.');
		endif;

		// cekpoin untuk error

		if ($d['error'])
			return FALSE;

		// pembaruan nilai_siswa

		$this->db->trans_start();
		$this->db->update_batch('nilai_siswa', $data_nisis, 'id');
		$this->trans_done('Daftar keterangan telah diperbarui.', 'Database error saat memperbarui nilai siswa.');

		// selesai

		return !$d['error'];

	}
	// lainnya

	function rerata_invalid_list($where = '')
	{
		$query = array(
			'select' => array('id'),
			'from'	 => 'nilai_siswa',
		);

		if ($where !== '')
			$query['where'] = $where;

		$query['where']['valid'] = 0;

		return $this->md->query($query)->result_values('id');

	}

	function konversi_nilai()
	{
		$query = array(
			'select' => array('konversi.*'),
			'from'	 => 'konversi_nilai konversi'
		);

		return $this->md->query($query)->result();

	}

	function deskripsi_nilai($semester_id)
	{
		$d = & $this->ci->d;
		$select = array(
			'rentang.*',
			'deskripsi.*',
		);
		$this->md->select($select)
			->from('nilai_rentang_aspek_penilaian rentang')
			->join('nilai_deskripsi deskripsi', 'rentang.kode = deskripsi.kode '.
			 	'AND rentang.aspek_penilaian_id = deskripsi.aspek_penilaian_id '. 
				'AND rentang.semester_id = deskripsi.semester_id', 'left')
			->join('dakd_aspek_penilaian aspen', 'rentang.aspek_penilaian_id = aspen.id', '')
			->where('deskripsi.aktif', '1')
			->where('rentang.aktif', '1')
			->where('rentang.semester_id', $semester_id)
			->where('aspen.aktif', '1');

		return $this->md->result();

	}
	
	function deskripsi_pelajaran($semester_id)
	{
		$d = & $this->ci->d;
		$select = array(
			'deskripsi.*',
		);
		$this->md->select($select)
			->from('nilai_deskripsi deskripsi')
			->where('deskripsi.aktif', '1')
			->where('deskripsi.semester_id',$semester_id);

		return $this->md->result();

	}

	function aspek_penilaian($siswa_nilai_id)
	{
		$select = array(
			'aspek_nama'		 => 'aspek.nama',
			'aspek_nilai'		 => 'niaspek.aspek_nilai',
			'aspek_keterangan'	 => 'niaspek.keterangan',
		);
		$this->md->select($select)
			->from('nilai_siswa nisis')
			->join('nilai_siswa_pribadi niaspek', 'nisis.siswa_id = niaspek.siswa_nilai_id', 'inner')
			->join('dmst_aspek_pribadi aspek', 'niaspek.aspek_id = aspek.id', 'inner')
			->where('niaspek.siswa_nilai_id', $siswa_nilai_id)
			->order_by('aspek.nama');

		return $this->md->result();

	}
	
	function search_semester_id($id_siswa,$ta_id)
	{
		$query = array(
			'select'	 => array(
				'id_nilai'	=> 'nilai.id',
				'semester_nama'	=> 'semester.nama',
				'semester_id'	=> 'semester.id',
				),
			'from'		 => 'nilai_siswa nilai',
			'join'		 => array(
				array('dprofil_siswa siswa', 'nilai.siswa_id = siswa.id', 'inner'),
				array('prd_semester semester', 'nilai.semester_id = semester.id', 'inner'),
				array('prd_ta ta', 'semester.ta_id = ta.id', 'inner'),
				),
		);
		
		$query['where']['siswa.id'] = (int) $id_siswa;
		$query['where']['ta.id'] = (int) $ta_id;
			
		return $this->md->query($query)->resultset(0, 2);
		
	}
	
	function save($ket='absen')
	{
		$d = & $this->ci->d;

		$this->form->ruleset($d['row'], 'validasi');
		$this->form->validate();

		if ($d['error'])
		{
			return FALSE;
		}
		if($ket=='absen'){	
			$data = $this->inputset('fields');
		}elseif($ket=='catatan'){
			$data = $this->inputset('fields_catatan');
		}elseif($ket=='mutasi'){
			$data = $this->inputset('fields_mutasi');
		}
		return $this->update($data, $d['form']['id']);

	}
	
	function save_kepribadian($ket='aspri_ktsp')
	{
		$d = & $this->ci->d;
		$dm = & $this->dm;
		//$this->form->ruleset($d['row'], 'validasi');
		//$this->form->validate();

		if ($d['error'])
		{
			return FALSE;
		}
		
		if($ket=='aspri_ktsp'){
			foreach ($dm['kepribadian.ktsp'] as $idx => $label):
				$data_aspri[$idx] = $this->input->post($idx);
			endforeach;
			$data['kepribadian']		= json_encode($data_aspri);
		}
		//return alert_error('dddd'.$data['kepribadian']);
		return $this->update($data, $d['form']['id']);

	}

	function update($data, $id)
	{

		$this->db->trans_start();

		$this->db->update('nilai_siswa', $data, array('id' => $id));

		return $this->trans_done('Data absensi siswa berhasil diperbarui.', 'Database error, coba beberapa saat lagi.');

	}
}
