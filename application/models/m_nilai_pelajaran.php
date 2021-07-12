<?php

class M_nilai_pelajaran extends MY_Model
{

	public function __construct()
	{
		parent::__construct();
		$this->dm['admin'] = cfguc_admin('akses', 'nilai', 'pelajaran');
		$this->dm['view'] = cfguc_view('akses', 'nilai', 'pelajaran');
		$this->dm['mengajar_list'] = (array) cfgu('mengajar_list');

	}

	// dasar database

	function filter_1()
	{
		$r = & $this->ci->d['request'];
		$dm = & $this->dm;

		if (!$dm['view'])
			return;

		if (isset($r['pelajaran_id']) && $r['pelajaran_id'] > 0)
			$this->db->where('nilai.pelajaran_id', $r['pelajaran_id']);

	}

	function filter_2($query)
	{
		$r = & $this->ci->d['request'];

		if (isset($r['term']))
			$query['like'] = array($r['term'], array('pelajaran.kode%', 'pelajaran.nama'));

		if (isset($r['pelajaran_id']) && $r['pelajaran_id'] > 0)
			$query['where']['nilai.pelajaran_id'] = $r['pelajaran_id'];

		if (isset($r['semester_id']))
		{
			if (!$r['semester_id'])
			{
				$r['semester_id'] = $this->md->row_col('id', 'select id from prd_semester order by id desc limit 1');
			}

			$query['where']['nilai.semester_id'] = $r['semester_id'];
		}

		return $query;

	}

	function query_1()
	{
		//$dataset = (array) func_get_args();
		//$alldata = in_array('#all', $dataset);
		$dm = & $this->dm;
		$semaktif = $this->ci->d['semaktif'];
		$user = $this->ci->d['user'];

		// query dasar

		$select = array(
			'nilai.*',
			'csiswa'		 	 	=> "count(nisispel.id)",
			'cmid_teori_kosong'	 	=> "COUNT(  `id` )  - SUM( CASE WHEN  `mid_teori` >0 THEN 1 ELSE 0 END )",
			'cmid_praktek_kosong'	=> "COUNT(  `id` )  - SUM( CASE WHEN  `mid_praktek` >0 THEN 1 ELSE 0 END )",
			'cakhir_teori_kosong'	=> "COUNT(  `id` )  - SUM( CASE WHEN  `nas_teori` >0 THEN 1 ELSE 0 END )",
			'cakhir_praktek_kosong'	=> "COUNT(  `id` )  - SUM( CASE WHEN  `nas_praktek` >0 THEN 1 ELSE 0 END )",
			'prd_ta'			 	=> 'sem.ta',
			'prd_semester'		 	=> 'sem.semester',
			'pelajaran_kode'		=> 'pelajaran.kode',
			'pelajaran_nama'		=> 'pelajaran.nama',
			'pelajaran_aktif'		=> 'pelajaran.aktif',
			'pelajaran_guru_id'		=> 'pelajaran.guru_id',
			'mapel_id'				=> 'pelajaran.mapel_id',
			'mapel_nama'			=> 'mapel.nama',
			'guru_nama'				=> "trim(concat_ws(' ', guru.prefix, guru.nama, guru.suffix))",
		);
		$this->md
			->select($select)
			->from('nilai_pelajarann nilai')
			->join('nilai_siswa_pelajaran nisispel', 'nilai.id = nisispel.pelajaran_nilai_id', 'left')
			->join('dakd_pelajaran pelajaran', 'nilai.pelajaran_id = pelajaran.id', 'inner')
			->join('prd_semester sem', 'nilai.semester_id = sem.id', 'inner')
			->join('dprofil_sdm guru', 'nilai.guru_id = guru.id', 'inner')
			->join('dakd_mapel mapel', 'pelajaran.mapel_id = mapel.id', 'inner')
			->order_by('sem.id, pelajaran.nama')
			->group_by('nilai.id');

		// filter akses

		if ($user['role'] == 'siswa'):
			$pelajaran_list = cfgu('pelajaran_list');
			$this->db
				->where('nilai.semester_id', $semaktif['id'])
				->where_in('nilai.pelajaran_id', $pelajaran_list);

		else:

			if (!$dm['admin'])
				$this->db->where('pelajaran.aktif', 1);

			if (!$dm['view'] && $dm['mengajar_list'])
				$this->db->where_in('nilai.pelajaran_id', $dm['mengajar_list']);

		endif;

		// commit selection

		$this->md->select($select);

	}

	function query_2()
	{
		$d = $this->ci->d;
		$dm = & $this->dm;

		// query dasar

		$query = array(
			'select'	 => array(
				'nilai.*',
				'cmid_teori_kosong'	 	=> "COUNT(  'nilai.id' )  - SUM( CASE WHEN  nisispel.`mid_teori` >0 THEN 1 ELSE 0 END )",
				'cmid_praktek_kosong'	=> "COUNT(  'nilai.id' )  - SUM( CASE WHEN  nisispel.`mid_praktek` >0 THEN 1 ELSE 0 END )",
				'cakhir_teori_kosong'	=> "COUNT(  'nilai.id' )  - SUM( CASE WHEN  nisispel.`nas_teori` >0 THEN 1 ELSE 0 END )",
				'cakhir_praktek_kosong'	=> "COUNT(  'nilai.id' )  - SUM( CASE WHEN  nisispel.`nas_praktek` >0 THEN 1 ELSE 0 END )",
				'cakhir_desteori_kosong'	=> "SUM( CASE WHEN  nisispel.`cat_teori` ='' THEN 1 ELSE 0 END )",
				'cakhir_despraktek_kosong'	=> "SUM( CASE WHEN  nisispel.`cat_praktek` ='' THEN 1 ELSE 0 END )",
				
				'ta_nama'			 => 'ta.nama',
				'semester_nama'		 => 'semester.nama',
				'pelajaran_kode'	 => 'pelajaran.kode',
				'pelajaran_nama'	 => 'pelajaran.nama',
				'pelajaran_aktif'	 => 'pelajaran.aktif',
				'pelajaran_guru_id'	 => 'pelajaran.guru_id',
				'mapel_id'			 => 'pelajaran.mapel_id',
				'kategori_id'		 => 'pelajaran.kategori_id',
				'mapel_nama'		 => 'mapel.nama',
				'kategori_nama'		 => 'kategori.nama',
				'guru_nama'			 => "trim(concat_ws(' ', guru.prefix, guru.nama, guru.suffix))",
				'guru_nip'			 => 'guru.nip',
			),
			'from'		 => 'nilai_pelajaran nilai',
			'join'		 => array(
				array('nilai_siswa_pelajaran nisispel', 'nilai.id = nisispel.pelajaran_nilai_id', 'left'),
				array('dakd_pelajaran pelajaran', 'nilai.pelajaran_id = pelajaran.id', 'inner'),
				array('dakd_kategori_mapel kategori', 'pelajaran.kategori_id = kategori.id', 'inner'),
				array('prd_semester semester', 'nilai.semester_id = semester.id', 'inner'),
				array('prd_ta ta', 'semester.ta_id = ta.id', 'inner'),
				array('dprofil_sdm guru', 'nilai.guru_id = guru.id', 'inner'),
				array('dakd_mapel mapel', 'pelajaran.mapel_id = mapel.id', 'inner'),
			),
			'order_by'	 => 'semester.id desc, pelajaran.nama',
			'group_by'	 => 'nilai.id',
		);

		// filter akses

		if ($d['user']['role'] == 'siswa'):
			$query['join']['nisispel'] = array('nilai_siswa_pelajaran nisispel', 'nilai.id = nisispel.pelajaran_nilai_id', 'inner');
			$query['join']['nisis'] = array('nilai_siswa nisis', 'nisispel.siswa_nilai_id = nisis.id', 'inner');
			$query['where']['nisis.siswa_id'] = (int) $d['user']['id'];
			$query['select']['siswa_nas_total'] = 'nisis.nas_total';
			$query['select']['siswa_nas_teori'] = 'nisis.nas_teori';
			$query['select']['siswa_nas_praktek'] = 'nisis.nas_praktek';

		elseif (!$dm['view']):

			/*if ($dm['mengajar_list']):
				$query['where_in']['nilai.pelajaran_id'] = $dm['mengajar_list'];

			else:*/
				$query['where']['nilai.guru_id'] = (int) $d['user']['id'];

			//endif;

		endif;

		return $query;

	}

	// operasi data basic

	function browse($index = 0, $limit = 20)
	{
		$query = $this->query_2();
		$query = $this->filter_2($query);

		return $this->md->query($query)->resultset($index, $limit);

	}

	function rowset($id)
	{
		$query = $this->query_2();
		$query['where']['nilai.id'] = $id;
		$row = $this->md->query($query)->row();

		if (!$row OR $row['valid'])
			return $row;

		$this->rerata_by_id($id);
		$row = $this->md->query($query)->row();

		return $row;

	}

	// fungsi generate rata2 nilai tiap siswa ke record nilai pelajaran

	function rerata_by_id($id)
	{

		/*
		 * 1 pelajaran_nilai_id
		 * 2 datetime
		 * 3 pelajaran_nilai_id
		 */

		$id = (int) $id;
		$d = & $this->ci->d;
		$sql = "
update nilai_pelajaran nipel
inner join
(
	select
		pelajaran_nilai_id,
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
		avg(h13) h13,
		avg(h14) h14,
		avg(h15) h15,
		avg(h16) h16,
		avg(h17) h17,
		avg(h18) h18,
		avg(h19) h19,
		avg(h20) h20,
		" . /* avg(h21) h21,
			  avg(h22) h22,
			  avg(h23) h23,
			  avg(h24) h24,
			  avg(h25) h25,
			  avg(h26) h26,
			  avg(h27) h27,
			  avg(h28) h28,
			  avg(h29) h29,
			  avg(h30) h30,
			  avg(h31) h31,
			  avg(h32) h32,
			  avg(h33) h33,
			  avg(h34) h34,
			  avg(h35) h35,
			  avg(h36) h36,
			  avg(h37) h37,
			  avg(h38) h38,
			  avg(h39) h39,
			  avg(h40) h40, */
			"avg(t1) t1,
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
		avg(t13) t13,
		avg(t14) t14,
		avg(t15) t15,
		avg(t16) t16,
		avg(t17) t17,
		avg(t18) t18,
		avg(t19) t19,
		avg(t20) t20,
		" . /*avg(t21) t21,
			avg(t22) t22,
			avg(t23) t23,
			avg(t24) t24,
			avg(t25) t25,
			avg(t26) t26,
			avg(t27) t27,
			avg(t28) t28,
			avg(t29) t29,
			avg(t30) t30,
			 avg(t31) t31,
			  avg(t32) t32,
			  avg(t33) t33,
			  avg(t34) t34,
			  avg(t35) t35,
			  avg(t36) t36,
			  avg(t37) t37,
			  avg(t38) t38,
			  avg(t39) t39,
			  avg(t40) t40, */"
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
		avg(p12) p12,
		avg(p13) p13,
		avg(p14) p14,
		avg(p15) p15,
		avg(p16) p16,
		avg(p17) p17,
		avg(p18) p18,
		avg(p19) p19,
		avg(p20) p20
		" . /* avg(p21) p21,
			  avg(p22) p22,
			  avg(p23) p23,
			  avg(p24) p24,
			  avg(p25) p25,
			  avg(p26) p26,
			  avg(p27) p27,
			  avg(p28) p28,
			  avg(p29) p29,
			  avg(p30) p30,
			  avg(p31) p31,
			  avg(p32) p32,
			  avg(p33) p33,
			  avg(p34) p34,
			  avg(p35) p35,
			  avg(p36) p36,
			  avg(p37) p37,
			  avg(p38) p38,
			  avg(p39) p39,
			  avg(p40) p40 */"
	from nilai_siswa_pelajaran
	where pelajaran_nilai_id = ?
	group by pelajaran_nilai_id
) nisispel
	on nipel.id = nisispel.pelajaran_nilai_id
set
	nipel.nas_total = nisispel.nas_total,
	nipel.nas_teori = nisispel.nas_teori,
	nipel.nas_praktek = nisispel.nas_praktek,
	nipel.uas = nisispel.uas,
	nipel.uts = nisispel.uts,
	nipel.h1 = nisispel.h1,
	nipel.h2 = nisispel.h2,
	nipel.h3 = nisispel.h3,
	nipel.h4 = nisispel.h4,
	nipel.h5 = nisispel.h5,
	nipel.h6 = nisispel.h6,
	nipel.h7 = nisispel.h7,
	nipel.h8 = nisispel.h8,
	nipel.h9 = nisispel.h9,
	nipel.h10 = nisispel.h10,
	nipel.h11 = nisispel.h11,
	nipel.h12 = nisispel.h12,
	nipel.h13 = nisispel.h13,
	nipel.h14 = nisispel.h14,
	nipel.h15 = nisispel.h15,
	nipel.h16 = nisispel.h16,
	nipel.h17 = nisispel.h17,
	nipel.h18 = nisispel.h18,
	nipel.h19 = nisispel.h19,
	nipel.h20 = nisispel.h20,
	" . /* nipel.h21 = nisispel.h21,
			  nipel.h22 = nisispel.h22,
			  nipel.h23 = nisispel.h23,
			  nipel.h24 = nisispel.h24,
			  nipel.h25 = nisispel.h25,
			  nipel.h26 = nisispel.h26,
			  nipel.h27 = nisispel.h27,
			  nipel.h28 = nisispel.h28,
			  nipel.h29 = nisispel.h29,
			  nipel.h30 = nisispel.h30,
			  nipel.h31 = nisispel.h31,
			  nipel.h32 = nisispel.h32,
			  nipel.h33 = nisispel.h33,
			  nipel.h34 = nisispel.h34,
			  nipel.h35 = nisispel.h35,
			  nipel.h36 = nisispel.h36,
			  nipel.h37 = nisispel.h37,
			  nipel.h38 = nisispel.h38,
			  nipel.h39 = nisispel.h39,
			  nipel.h40 = nisispel.h40, */"
	nipel.t1 = nisispel.t1,
	nipel.t2 = nisispel.t2,
	nipel.t3 = nisispel.t3,
	nipel.t4 = nisispel.t4,
	nipel.t5 = nisispel.t5,
	nipel.t6 = nisispel.t6,
	nipel.t7 = nisispel.t7,
	nipel.t8 = nisispel.t8,
	nipel.t9 = nisispel.t9,
	nipel.t10 = nisispel.t10,
	nipel.t11 = nisispel.t11,
	nipel.t12 = nisispel.t12,
	nipel.t13 = nisispel.t13,
	nipel.t14 = nisispel.t14,
	nipel.t15 = nisispel.t15,
	nipel.t16 = nisispel.t16,
	nipel.t17 = nisispel.t17,
	nipel.t18 = nisispel.t18,
	nipel.t19 = nisispel.t19,
	nipel.t20 = nisispel.t20,
	" . /*nipel.t21 = nisispel.t21,
			nipel.t22 = nisispel.t22,
			nipel.t23 = nisispel.t23,
			nipel.t24 = nisispel.t24,
			nipel.t25 = nisispel.t25,
			nipel.t26 = nisispel.t26,
			nipel.t27 = nisispel.t27,
			nipel.t28 = nisispel.t28,
			nipel.t29 = nisispel.t29,
			nipel.t30 = nisispel.t30,
			 nipel.t31 = nisispel.t31,
			  nipel.t32 = nisispel.t32,
			  nipel.t33 = nisispel.t33,
			  nipel.t34 = nisispel.t34,
			  nipel.t35 = nisispel.t35,
			  nipel.t36 = nisispel.t36,
			  nipel.t37 = nisispel.t37,
			  nipel.t38 = nisispel.t38,
			  nipel.t39 = nisispel.t39,
			  nipel.t40 = nisispel.t40, */"
	nipel.p1 = nisispel.p1,
	nipel.p2 = nisispel.p2,
	nipel.p3 = nisispel.p3,
	nipel.p4 = nisispel.p4,
	nipel.p5 = nisispel.p5,
	nipel.p6 = nisispel.p6,
	nipel.p7 = nisispel.p7,
	nipel.p8 = nisispel.p8,
	nipel.p9 = nisispel.p9,
	nipel.p10 = nisispel.p10,
	nipel.p11 = nisispel.p11,
	nipel.p12 = nisispel.p12,
	nipel.p13 = nisispel.p13,
	nipel.p14 = nisispel.p14,
	nipel.p15 = nisispel.p15,
	nipel.p16 = nisispel.p16,
	nipel.p17 = nisispel.p17,
	nipel.p18 = nisispel.p18,
	nipel.p19 = nisispel.p19,
	nipel.p20 = nisispel.p20,
	" . /* nipel.p21 = nisispel.p21,
			  nipel.p22 = nisispel.p22,
			  nipel.p23 = nisispel.p23,
			  nipel.p24 = nisispel.p24,
			  nipel.p25 = nisispel.p25,
			  nipel.p26 = nisispel.p26,
			  nipel.p27 = nisispel.p27,
			  nipel.p28 = nisispel.p28,
			  nipel.p29 = nisispel.p29,
			  nipel.p30 = nisispel.p30,
			  nipel.p31 = nisispel.p31,
			  nipel.p32 = nisispel.p32,
			  nipel.p33 = nisispel.p33,
			  nipel.p34 = nisispel.p34,
			  nipel.p35 = nisispel.p35,
			  nipel.p36 = nisispel.p36,
			  nipel.p37 = nisispel.p37,
			  nipel.p38 = nisispel.p38,
			  nipel.p39 = nisispel.p39,
			  nipel.p40 = nisispel.p40, */"
	nipel.valid = 1,
	nipel.diolah = ?
where nipel.id = ?
";

		$this->db->trans_start();
		$this->db->query($sql, array($id, $d['datetime'], $id));

		return $this->trans_done("Nilai rata-rata pelajaran berhasil diperbarui", 'Database error saat memperbarui rata-rata nilai pelajaran.');

	}

	function reratareset_by_id($id)
	{

		$id = (int) $id;

		$this->db->trans_start();
		$this->db->update('nilai_pelajaran', array('valid' => 0), array('id' => $id));
		return $this->trans_done();

	}
	
	function upload_deskripsi_expor( $semester='' )
	{
		$d = & $this->ci->d;
		$dm = & $this->dm;
		
		$this->load->library('PHPExcel');
		$this->load->helper('excel');
		if($semester=='')
		{
			$semester = $d['semaktif']['id'];
		}
		// deklarasi variabel
		if (TRUE):
			
			
			$excel_source = APP_ROOT.'content/'.strtolower(APP_SCOPE).'/template/nilai_pelajaran_deskripsi.blank.xlsx';
			$nides_query = array(
				'from'	 => 'dakd_pelajaran dapel',
				'join'	 => array(
					array('dakd_mapel mapel', 'mapel.id = dapel.mapel_id', 'inner'),
					array('dmst_agama agama', 'agama.id = dapel.agama_id', 'left'),
					array('dakd_kategori_mapel kategori', 'kategori.id = dapel.kategori_id', 'inner'),
					array('nilai_deskripsi nides', 
					'nides.mapel_id = dapel.mapel_id '.
					'AND nides.kategori_id = dapel.kategori_id '.
					'AND ((nides.agama_id >= 0 AND nides.agama_id = dapel.agama_id) OR dapel.agama_id IS NULL) '.
					'AND nides.semester_id = '.$semester, 'left'),
					//'AND nides.semester_id = 6', 'left'),
				),
				'where'	 => array(
					'dapel.aktif' => '1',
				),
				'order_by' => '
								length(dapel.kategori_id), dapel.kategori_id, 
								length(mapel.nourut), mapel.nourut,
								length(dapel.mapel_id), dapel.mapel_id, 
								length(dapel.agama_id), dapel.agama_id, 
								length(nides.aspek_penilaian_id), nides.aspek_penilaian_id',
				'select' => array(
					'ketegori_nama'	=> 'kategori.nama',
					'mapel_nama'	=> 'mapel.nama',
					'agama_nama'	=> 'agama.nama',
					'mapel_agama_nama' => 'concat_ws(" ", upper(mapel.nama), agama.nama)',
					'dapel.*',
					'deskripsi_id'	=> 'nides.id',
					'nides.aspek_penilaian_id	',
					'nides.grade',
					'nides.kode',
					'nides.deskripsi',
					'nides.aktif',
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
					'alignment'	 => array(
						'vertical' => PHPExcel_Style_Alignment::VERTICAL_TOP,
					),
				),
			);
			$cfg = array(
				'table.nides' => array(
					// data pribadi
					'B'	 => array('ketegori_nama'),
					'C'	 => array('mapel_agama_nama'),
					'D'	 => array('kategori_id'),
					'E'	 => array('mapel_id'),
					'F'	 => array('agama_id'),
				),
			);
			$nisis_data = array();
			$kelas_jml = 0;
			$sheet_index = 0;
			$excel_row_offset = 11;
			$wali_query = array(
				'select' => array(
					'id',
					'nama' => "trim(concat_ws(' ', prefix, nama, suffix))"
				),
				'from'	 => 'dprofil_sdm',
			);

		endif;
		
		$nides_result = $this->md->query($nides_query)->result();
		$excel = PHPExcel_IOFactory::load($excel_source);
		
		$sheet_index=0;
		$grade=12;
		$sheet = $excel->setActiveSheetIndex($sheet_index);
		
		while($grade>=10):
			$excel_row = $excel_row_offset;
			$sheet = $excel->setActiveSheetIndex($sheet_index);
			$temp_kategori_id=0;
			$temp_mapel_id=0;
			$temp_agama_id=0;
			$nides_data = $nides_result['data'];
			$no=0;
			$ket_semester = "SEMESTER ".strtoupper($d['semaktif']['nama'])." TAHUN ".$d['semaktif']['ta_nama'];
			$sheet->setCellValue('A2', $ket_semester);
			$sheet->setCellValue('D5', $d['semaktif']['id']);
			$sheet->setCellValue('D6', $grade);
			foreach ($nides_data as $row):
					if(	($temp_kategori_id!=$row['kategori_id']) || ($temp_mapel_id!=$row['mapel_id']) || ($temp_agama_id!=$row['agama_id'])	):
						$excel_row++;
						$no++;
						$sheet->setCellValue('A'. $excel_row, $no);
					endif;
					
					foreach ($cfg['table.nides'] as $colexcel => $dat):
						$sheet->setCellValue($colexcel . $excel_row, data_cell($dat, $row));
					endforeach;
					$sheet->setCellValue('A'. $excel_row, $no);
					
					if($row['grade']==$grade):
						if($row['aspek_penilaian_id']==1):
							if($row['kode']==1):
								$sheet->setCellValue('G' . $excel_row, $row['deskripsi']);
							elseif($row['kode']==2):
								$sheet->setCellValue('H' . $excel_row, $row['deskripsi']);
							elseif($row['kode']==3):
								$sheet->setCellValue('I' . $excel_row, $row['deskripsi']);
							elseif($row['kode']==4):
								$sheet->setCellValue('J' . $excel_row, $row['deskripsi']);
							elseif($row['kode']==5):
								$sheet->setCellValue('K' . $excel_row, $row['deskripsi']);
							endif;
						elseif($row['aspek_penilaian_id']==2):
							if($row['kode']==1):
								$sheet->setCellValue('M' . $excel_row, $row['deskripsi']);
							elseif($row['kode']==2):
								$sheet->setCellValue('N' . $excel_row, $row['deskripsi']);
							elseif($row['kode']==3):
								$sheet->setCellValue('O' . $excel_row, $row['deskripsi']);
							elseif($row['kode']==4):
								$sheet->setCellValue('P' . $excel_row, $row['deskripsi']);
							elseif($row['kode']==5):
								$sheet->setCellValue('Q' . $excel_row, $row['deskripsi']);
							endif;
						endif;
					endif;
					$temp_kategori_id	= $row['kategori_id'];
					$temp_mapel_id		= $row['mapel_id'];
					$temp_agama_id		= $row['agama_id'];
					if($row['agama_id']==''):
						$temp_agama_id = 0 ;
					endif;
			endforeach;
			$sheet->getStyle('A12:Q'.$excel_row)->getAlignment()->setWrapText(true); 
			$sheet->getStyle('A12:Q'.$excel_row)->applyFromArray($style['default']);
			
			$sheet->getColumnDimension('D')->setVisible(FALSE);
			$sheet->getColumnDimension('E')->setVisible(FALSE);
			$sheet->getColumnDimension('F')->setVisible(FALSE);
			
			$sheet->getRowDimension('5')->setVisible(FALSE);
			$sheet->getRowDimension('6')->setVisible(FALSE);
			$sheet->getRowDimension('7')->setVisible(FALSE);
			$sheet->getRowDimension('8')->setVisible(FALSE);
			
			excel_security_cell_lock($sheet, 'A1:R'.$excel_row);
			excel_security_cell_unlock($sheet, "G12:Q".$excel_row);
			excel_security_sheet_lock($sheet);
			
			$grade--;
			$sheet_index++;
		endwhile;
		
		return excel_output_2007($excel, 'deskripsi_pelajaran.xlsx');
	}
	
	function upload_deskripsi_impor()
	{
		$map_des = array(
			'G'=>'1',
			'H'=>'2',
			'I'=>'3',
			'J'=>'4',
			'K'=>'5',
			'M'=>'1',
			'N'=>'2',
			'O'=>'3',
			'P'=>'4',
			'Q'=>'5'
		);
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
		
		$grade=0;
		$kategori_id=0;
		$mapel_id=0;
		$agama_id=0;
		
		$this->db->trans_start();
		$sheet_jml=3;
		for ($_sheet_index = 0; $_sheet_index < $sheet_jml; $_sheet_index++):
			$sheet		= $PHPExcel->setActiveSheetIndex($_sheet_index);
			
			$semester_id = (int) $sheet->getCell("D5")->getValue();
			$grade		 = (int) $sheet->getCell("D6")->getValue();
			$row_max	 = $sheet->getHighestRow();
			$row_start	 = 12;
			while($row_max>=$row_start):
			
				$kategori_id	= (int) $sheet->getCell("D". $row_start)->getValue();
				$mapel_id		= (int) $sheet->getCell("E". $row_start)->getValue();
				$agama_id		= (int) $sheet->getCell("F". $row_start)->getValue();
				
				$aspek_penilaian_id=1;
				//return alert_error($semester_id." ".$grade." ".$kategori_id." ".$mapel_id." ".$agama_id." ".$aspek_penilaian_id." ".$row_max);
				foreach($map_des  as $_excel_col=>$kode):
					$deskripsi		= $sheet->getCell($_excel_col. $row_start)->getValue();
					$deskripsi		= str_replace("'","`",$deskripsi);
					$deskripsi		= str_replace("'","`",$deskripsi);
					$deskripsi		= str_replace("/n","<br/>",$deskripsi);
					
					$sql_cek = "
						select * from nilai_deskripsi 
						where 
							kategori_id = ".$kategori_id."
						and
							mapel_id	= ".$mapel_id."
						and
							agama_id	= ".$agama_id."
						and
							aspek_penilaian_id=".$aspek_penilaian_id."
						and
							grade		= ".$grade."
						and
							kode		= ".$kode."
						and
							semester_id	= ".$semester_id."
						";
					$query = $this->db->query($sql_cek);
					
					$update = 0;
					if($query->num_rows()>=1):
						$update = 1;
					endif;
				//return alert_error($semester_id." ".$grade." ".$kategori_id." ".$mapel_id." ".$agama_id." ".$aspek_penilaian_id." ".$row_max);
					$sql = "";
					if($update==1):
						$sql = "
							UPDATE nilai_deskripsi
							SET deskripsi 	= '".$deskripsi."' 
							WHERE 
								kategori_id = ".$kategori_id."
							and
								mapel_id	= ".$mapel_id."
							and
								agama_id	= ".$agama_id."
							and
								aspek_penilaian_id=".$aspek_penilaian_id."
							and
								grade		= ".$grade."
							and
								kode		= ".$kode."
							and
								semester_id	= ".$semester_id."
						";
					elseif(	($update==0)&&($deskripsi!='')	):
						$sql = "
							INSERT INTO nilai_deskripsi
							SET 
								deskripsi 	= '".$deskripsi."' ,
								kategori_id = ".$kategori_id.",
								mapel_id	= ".$mapel_id.",
								agama_id	= ".$agama_id.",
								aspek_penilaian_id=".$aspek_penilaian_id.",
								grade		= ".$grade.",
								kode		= ".$kode.",
								semester_id	= ".$semester_id.",
								aktif		= 1
						";
					endif;
					//return alert_error($semester_id." ".$grade." ".$kategori_id." ".$mapel_id." ".$agama_id." ".$aspek_penilaian_id." ".$row_max);
					
					if($sql!=''):
						$this->db->query($sql);
						//return alert_error( $sql." ".$update);
					
					endif;
					
					if($kode==5):
						$aspek_penilaian_id++;
					endif;
					//return alert_error('TEST 1');
				endforeach;
				//return alert_error('TEST 2');
				$row_start++;
			endwhile;		
			//return alert_error('TEST 3');
		endfor;
		
		//return alert_error('TEST 4');
		
		$this->trans_done('Daftar nilai telah diperbarui.', 'Database error saat memperbarui nilai siswa.');
	}
	
}
