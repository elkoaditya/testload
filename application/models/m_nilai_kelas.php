<?php

class M_nilai_kelas extends MY_Model
{
	var $filetypes = array('xlsx');
	
	public function __construct()
	{
		parent::__construct(array());
		$this->dm['admin'] = cfguc_admin('akses', 'nilai', 'kelas');
		$this->dm['view'] = cfguc_view('akses', 'nilai', 'kelas');
		$this->dm['walikelas'] = cfgu('walikelas');
		$this->dm['kelas_terkait'] = $this->kelas_terkait();

	}

	// dasar database
	function getNameFromNumber($num) 
	{
		$numeric = ($num - 1) % 26;
		$letter = chr(65 + $numeric);
		$num2 = intval(($num - 1) / 26);
		if ($num2 > 0) {
			return getNameFromNumber($num2) . $letter;
		} else {
			return $letter;
		}
	}
	function filter_1()
	{
		$r = & $this->ci->d['request'];
		$dm = & $this->dm;

		if (!$dm['view'])
			return;

		if (isset($r['kelas_id']) && $r['kelas_id'] > 0)
			$this->db->where('nilai.kelas_id', $r['kelas_id']);

	}

	function filter_2($query)
	{
		$r = & $this->ci->d['request'];
		$dm = & $this->dm;

		if (!$dm['view'])
			return $query;

		if (isset($r['kelas_id']) && $r['kelas_id'] > 0)
			$query['where']['nilai.kelas_id'] = $r['kelas_id'];

		if (isset($r['semester_id']) == FALSE OR ! $r['semester_id'])
		{
			$r['semester_id'] = $this->md->row_col('id', 'select id from prd_semester order by id desc limit 1');
		}

		$query['where']['nilai.semester_id'] = $r['semester_id'];

		return $query;

	}

	function kelas_terkait()
	{
		$dm = & $this->dm;
		$user = $this->ci->d['user'];
		$kelas_saya = (int) cfgu('kelas_id');
		$query = array(
			'select' => array('id', 'nama'),
			'from'	 => 'dakd_kelas',
		);

		if (!$dm['view'] OR $user['role'] == 'siswa'):

			if ($user['role'] == 'sdm' && $dm['walikelas']):
				$query['where_in']['id'] = $dm['walikelas'];

			elseif ($user['role'] == 'siswa' && $kelas_saya > 0):
				$query['where']['id'] = $kelas_saya;

			else:
				return NULL;

			endif;

		endif;

		return $this->md->query($query)->result_series('id', 'nama');

	}

	function query_2()
	{
		$d = $this->ci->d;
		$dm = & $this->dm;
		$kelas_list = array_keys($dm['kelas_terkait']);

		// query dasar

		$query = array(
			'select'	 => array(
				'nilai.*',
				'ta_id'				 	 => 'ta.id',
				'ta_nama'				 => 'ta.nama',
				'semester_nama'			 => 'semester.nama',
				'kelas_nama'			 => 'kelas.nama',
				'kelas_grade'			 => 'kelas.grade',
				'kelas_aktif'			 => 'kelas.aktif',
				'jurusan_nama'			 => 'jurusan.nama',
				'kelas_wali_nama'		 => "trim(concat_ws(' ', kelas_wali.prefix, kelas_wali.nama, kelas_wali.suffix))",
				'kelas_wali_aktif_id'	 => 'kelas.wali_id',
				
				'kurikulum_id'	 		=> 'd_kurikulum.id',
				'kurikulum_nama' 		=> 'd_kurikulum.nama',
			),
			'from'		 => 'nilai_kelas nilai',
			'join'		 => array(
				array('dmst_kurikulum d_kurikulum', 'nilai.kurikulum_id = d_kurikulum.id', 'left'),
				
				array('prd_semester semester', 'nilai.semester_id = semester.id', 'inner'),
				array('prd_ta ta', 'semester.ta_id = ta.id', 'inner'),
				array('dakd_kelas kelas', 'nilai.kelas_id = kelas.id', 'inner'),
				array('dakd_jurusan jurusan', 'kelas.jurusan_id = jurusan.id', 'inner'),
				array('dprofil_sdm kelas_wali', 'nilai.kelas_wali_id = kelas_wali.id', 'inner'),
			),
			'order_by'	 => 'semester.id desc, kelas.grade, kelas.nama',
		);

		// filter akses

		if (!$dm['admin'])
			$query['where']['kelas.aktif'] = 1;

		if (!$dm['view'])
			$query['where_in']['nilai.kelas_id'] = $kelas_list;

		if ($d['user']['role'] == 'siswa')
			$query['where']['nilai.semester_id'] = $d['semaktif']['id'];

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

		// pastikan rerata nilai siswa sudah valid

		$nisis_invalid = $this->m_nilai_siswa->rerata_invalid_list(array('kelas_nilai_id' => $id));

		if ($nisis_invalid)
			$this->m_nilai_siswa->rerata_by_list($nisis_invalid);

		// urutan peringkat

		$this->m_nilai_siswa->rank_kelas($id);

		// rerata nilai kelas

		$this->m_nilai_siswa->rerata_by_nikls($id);
		$this->rerata_by_list($id);
		$row = $this->md->query($query)->row();

		return $row;

	}

	function rowsub_mapel(&$row)
	{
		$query = array(
			'from'	 => 'nilai_pelajaran_kelas nilai_pelkls',
			'where'	 => array(
				'nilai_pelkls.kelas_nilai_id' => $row['id'],
			),
		);

		$row['nilai_pelajaran_result'] = $this->md->query($query)->result();

	}
	
	function rowsub_pelajaran($nilai_id, $index = 0, $limit = 50, $kurikulum_nama)
	{
		$r = $this->ci->d['request'];
		$u = $this->ci->d['user'];
		$query = array(
			'select'	 => array(
				'nipel.*',
				'nipekl.pelajaran_nilai_id',
				'pelajaran_id'	 => 'pelajaran.id',
				'pelajaran_kode' => 'pelajaran.kode',
				'pelajaran_nama' => 'pelajaran.nama',
				'kategori_id'	 => 'kategori.id',
				'kategori_kode'	 => 'kategori.kode',
				'kategori_nama'	 => 'kategori.nama',
				'kategori_nourut'=> 'kategori.nourut',
				
				'mapel_id'		 => 'mapel.id',
				'mapel_nama'	 => 'mapel.nama',
				'nipel_kkm'		 => 'nipel.kkm',
				'nipel_teori'	 => 'nipel.teori',
				'nipel_praktek'	 => 'nipel.praktek',
				'nipel_agama_id' => 'nipel.agama_id',
				'agama_nama'	 => 'agama.nama',
				
				'guru_nama'		 => "trim(trim(TRAILING ', ' from concat(guru.prefix, ' ', guru.nama, ', ', guru.suffix)))",
			),
			'from'		 => 'nilai_pelajaran nipel',
			'join'		 => array(
				array('nilai_pelajaran_kelas nipekl', 'nipekl.pelajaran_nilai_id = nipel.id', 'inner'),
				array('nilai_kelas nikls', 'nipekl.kelas_nilai_id = nikls.id', 'inner'),
				array('dmst_agama agama', 'nipel.agama_id = agama.id', 'left'),
				
				array('dakd_pelajaran pelajaran', 'nipel.pelajaran_id = pelajaran.id', 'inner'),
				array('dakd_kategori_mapel kategori', 'pelajaran.kategori_id = kategori.id', 'inner'),
				array('dakd_mapel mapel', 'pelajaran.mapel_id = mapel.id', 'inner'),
				array('dprofil_sdm guru', 'nipel.guru_id = guru.id', 'left'),
			),
			'where'		 => array(
				'nikls.id' => $nilai_id
			),
			
		);

		if($kurikulum_nama=='ktsp')
		{
			$query['order_by']	 = 'kategori.nourut ASC, mapel.no_urut_ktsp ASC';
		}else{
			$query['order_by']	 = 'kategori.nourut ASC, mapel.nourut ASC';
		}
		
		return $this->md->query($query)->resultset($index, $limit);

	}

	function rowsub_siswa($nilai_id, $index = 0, $limit = 50)
	{
		$r = $this->ci->d['request'];
		$u = $this->ci->d['user'];
		$query = array(
			'select'	 => array(
				'nilai_siswa.*',
				/*'nilai_siswa.id',
				'nilai_siswa.siswa_id',
				'nilai_siswa.absen_s',
				'nilai_siswa.absen_i',
				'nilai_siswa.absen_a',
				'nilai_siswa.nas_teori',
				'nilai_siswa.nas_praktek',
				'nilai_siswa.nas_total',
				'nilai_siswa.nas_skor',
				'nilai_siswa.rank_kelas',
				'nilai_siswa.rank_jurusan',
				'nilai_siswa.rank_grade',
				'nilai_siswa.rank_sekolah',
				'nilai_siswa.diolah',
				'nilai_siswa.valid',*/
				'siswa_nama'	 => 'siswa.nama',
				'siswa_nis'		 => 'siswa.nis',
				'siswa_nisn'	 => 'siswa.nisn',
				'siswa_aktif'	 => 'siswa.aktif',
				'siswa_gender'	 => 'siswa.gender',
				'siswa_masuk_tgl'	 => 'siswa.masuk_tgl',
				'siswa_no_un'		 => 'siswa.no_un',
				'siswa.lahir_tempat',
				'siswa.lahir_tgl',
				'siswa.ayah_nama',
				'siswa.ibu_nama',
				'siswa.agama_id',
				'agama_nama'	 => 'agama.nama',
				'kelas_nama'	 => 'kelas.nama',
				'kelas_grade'	 => 'kelas.grade',
				'kelas_jurusan'	 => 'kelas.jurusan_id',
			),
			'from'		 => 'nilai_siswa',
			'join'		 => array(
				array('dprofil_siswa siswa', 'nilai_siswa.siswa_id = siswa.id', 'inner'),
				array('dmst_agama agama', 'siswa.agama_id = agama.id', 'inner'),
				array('dakd_kelas kelas', 'kelas.id = nilai_siswa.kelas_id', 'inner'),
			),
			'where'		 => array(
				'nilai_siswa.kelas_nilai_id' => $nilai_id
			),
			'order_by'	 => 'nilai_siswa.absen_no, siswa.nama',
		);
		if (isset($r['term']) && $r['term'])
			$query['like'] = array($r['term'], 'siswa.nama');

		if ($u['role'] == 'siswa')
			$query['where']['siswa.id'] = $u['id'];

		return $this->md->query($query)->resultset($index, $limit);

	}
	
	function rowsub_siswa2($nilai_id, $index = 0, $limit = 50)
	{
		$r = $this->ci->d['request'];
		$u = $this->ci->d['user'];
		$this->db->join('dakd_kelas kelas', 'kelas.id = nilai_siswa.kelas_id', 'inner');
        $this->db->where('kelas_nilai_id', $nilai_id);
		$query1 = $this->db->get('nilai_siswa');
		
        $semester_id = 0;
        $grade = 0;
        $jurusan_id = 0;
        foreach ($query1->result() as $arra1) {
			$semester_id = $arra1->semester_id;
			$grade = $arra1->grade;
			$jurusan_id = $arra1->jurusan_id;
        }
		
		$query = array(
			'select'	 => array(
				'nilai_siswa.*',
				/*'nilai_siswa.id',
				'nilai_siswa.siswa_id',
				'nilai_siswa.absen_s',
				'nilai_siswa.absen_i',
				'nilai_siswa.absen_a',
				'nilai_siswa.nas_teori',
				'nilai_siswa.nas_praktek',
				'nilai_siswa.nas_total',
				'nilai_siswa.nas_skor',
				'nilai_siswa.rank_kelas',
				'nilai_siswa.rank_jurusan',
				'nilai_siswa.rank_grade',
				'nilai_siswa.rank_sekolah',
				'nilai_siswa.diolah',
				'nilai_siswa.valid',
				'nilai_siswa.semester_id',*/
				'siswa_nama'	 => 'siswa.nama',
				'siswa_nis'		 => 'siswa.nis',
				'siswa_nisn'	 => 'siswa.nisn',
				'siswa_aktif'	 => 'siswa.aktif',
				'siswa_gender'	 => 'siswa.gender',
				'siswa.agama_id',
				'agama_nama'	 => 'agama.nama',
				'kelas_nama'	 => 'kelas.nama',
				'kelas_grade'	 => 'kelas.grade',
				'kelas_jurusan'	 => 'kelas.jurusan_id',
			),
			'from'		 => 'nilai_siswa',
			'join'		 => array(
				array('dprofil_siswa siswa', 'nilai_siswa.siswa_id = siswa.id', 'inner'),
				array('dmst_agama agama', 'siswa.agama_id = agama.id', 'inner'),
				array('dakd_kelas kelas', 'kelas.id = nilai_siswa.kelas_id', 'inner'),
			),
			'where'		 => array(
				'nilai_siswa.semester_id' => $semester_id,
				'kelas.grade' => $grade,
				'kelas.jurusan_id' => $jurusan_id,
			),
			'order_by'	 => 'siswa.nama',
		);
		/*
		if (!empty($send_data['nilai_id'])) {
			$query['where'] = array('nilai_siswa.kelas_nilai_id' => $send_data['nilai_id']);
		}
		if (!empty($send_data['grade'])) {
			$query['where'] = array('dakd_kelas.grade' => $send_data['grade']);
		}
		if (!empty($send_data['kurikulum_id'])) {
			$query['where'] = array('dakd_kelas.kurikulum_id' => $send_data['kurikulum_id']);
		}
		*/
		if (isset($r['term']) && $r['term'])
			$query['like'] = array($r['term'], 'siswa.nama');

		if ($u['role'] == 'siswa')
			$query['where']['siswa.id'] = $u['id'];

		return $this->md->query($query)->resultset($index, $limit);

	}
	
	function leger_6semester($id)
	{
		$d = & $this->ci->d;
		
		$nisis_result = $this->m_nilai_kelas->rowsub_siswa($id, 0, 1024);
		
		$kelas_result = $this->m_nilai_kelas->rowset($id);
		
		if ($nisis_result['selected_rows'] == 0)
			return alert_error("Daftar nilai siswa tidak ditemukan.");
		
		foreach ($nisis_result['data'] as $nisis):
			$siswa_id = (int) $nisis['siswa_id'];
			$d['siswa_list'][] = $siswa_id;
			$d['leger'][$siswa_id] = $nisis;
		endforeach;	
		
		unset($nisis_result);
		
		// data nilai pelajaran tiap siswa

		$nisispel_query = array(
			'from'		 => 'nilai_siswa_pelajaran nisispel',
			'where_in'	 => array(
				'nisis.siswa_id' => $d['siswa_list'],
			),
			'join'		 => array(
				array('nilai_pelajaran nipel', 'nipel.id = nisispel.pelajaran_nilai_id', 'inner'),
				array('dakd_pelajaran pelajaran', 'nipel.pelajaran_id = pelajaran.id', 'inner'),
				
				array('nilai_siswa nisis', 'nisis.id = nisispel.siswa_nilai_id', 'inner'),
				array('dprofil_siswa siswa', 'nisis.siswa_id = siswa.id', 'inner'),
				array('dakd_kelas kelas', 'kelas.id = nisis.kelas_id', 'inner'),
				
				array('prd_semester semester', 'semester.id = nisis.semester_id', 'inner'),
			),
			'select'	 => array(
				'nisis.siswa_id',
				'semester_id'	=> 'semester.id',
				'semester_nama'	=> 'semester.nama',
				'kelas_grade'	=> 'kelas.grade',
				
				'nisispel.id',
				'nisispel.siswa_nilai_id',
				'nisispel.pelajaran_nilai_id',
				'nisispel.nas_teori',
				'nisispel.nas_praktek',
				'nisispel.nas_sikap',
				
				'nisispel.nas_total',
				
				'nisispel.mid_teori',
				'nisispel.mid_praktek',
				'nisispel.mid_sikap',
				
				'nisispel.pred_teori',
				'nisispel.pred_praktek',
				'nisispel.pred_sikap',
				
				'nisispel.mid_pred_teori',
				'nisispel.mid_pred_praktek',
				'nisispel.mid_pred_sikap',
				
				'nisispel.uts',
				'nisispel.uas',
				'nisispel.cat_teori',
				'nisispel.cat_praktek',
				'nisispel.cat_sikap',
				'nipel.pelajaran_id',
				'pelajaran.mapel_id',
				'pelajaran.kategori_id',
				'pelajaran.agama_id',
			),
		);

		$nisispel_result = $this->md->query($nisispel_query)->result();

		if ($nisispel_result['selected_rows'] == 0)
			return alert_error("Daftar nilai pelajaran tiap siswa tidak ditemukan.");

		// kumpulkan nisispel ke leger

		foreach ($nisispel_result['data'] as $nisispel):
			$siswa_id = (int) $nisispel['siswa_id'];
			$mapel_id = (int) $nisispel['mapel_id'];
			$kategori_id = (int) $nisispel['kategori_id'];
			$kelas_grade = (int) $nisispel['kelas_grade'];
			$semester_nama = strtoupper($nisispel['semester_nama']);
			
			$d['leger'][$siswa_id]['nisispel_array'][$kelas_grade][$semester_nama][$kategori_id][$mapel_id] = $nisispel;

		endforeach;

		unset($nisispel_result);
		
		// ambil daftar pelajaran kelas

		$nipelkls_query = array(
			'from'		 => 'dakd_pelajaran pelajaran',
			'join'		 => array(
				array('dakd_mapel mapel', 'mapel.id = pelajaran.mapel_id', 'inner'),
				array('dakd_kategori_mapel kategori', 'kategori.id = pelajaran.kategori_id', 'inner'),
			),
			// K 13
			'where'		 => array(
				'kategori.kurikulum_id' => $kelas_result['kurikulum_id'],
				//'pelajaran.nama NOT LIKE %"ZZ"%',
			),
			'group_by'	 => 'pelajaran.kategori_id , pelajaran.mapel_id',
			'order_by'	 => 'kategori.nourut , mapel.nourut',
			'select'	 => array(
				'pelajaran.mapel_id',
				'pelajaran.kategori_id',
				'kategori_kode' => 'kategori.kode',
				'mapel_kode' => 'mapel.kode',
				'mapel_nama' => 'mapel.nama'
			),
		);

		$nipelkls_result = $this->md->query($nipelkls_query)->result();

		if ($nipelkls_result['selected_rows'] == 0)
			return alert_error("Daftar pelajaran siswa tidak ditemukan.");

		// susun daftar pelajaran

		$d['kolom_nilai_count'] = 0;

		$no=0;
		foreach ($nipelkls_result['data'] as $nipelkls):
			//$kategori_id = (int) $nipelkls['kategori_id'];
			//$mapel_id = (int) $nipelkls['mapel_id'];
			
			if(!(strpos(strtoupper($nipelkls['mapel_nama']), 'ZZ') !== false))
			{
				$d['pelajaran_array'][$no] = $nipelkls;

				$d['kolom_nilai_count'] += 3;
				$no++;
			}			
		endforeach;

		unset($nipelkls_result);

		return TRUE;
		
	}
	
	function leger($id)
	{
		$d = & $this->ci->d;

		// data nilai siswa

		$nisis_result = $this->m_nilai_kelas->rowsub_siswa($id, 0, 1024);

		if ($nisis_result['selected_rows'] == 0)
			return alert_error("Daftar nilai siswa tidak ditemukan.");

		// kumpulkan nisis ke leger

		foreach ($nisis_result['data'] as $nisis):
			$nisis_id = (int) $nisis['id'];
			$d['nisis_list'][] = $nisis_id;
			$d['leger'][$nisis_id] = $nisis;
		endforeach;

		unset($nisis_result);

		// data nilai pelajaran tiap siswa

		$nisispel_query = array(
			'from'		 => 'nilai_siswa_pelajaran nisispel',
			'where_in'	 => array(
				'siswa_nilai_id' => $d['nisis_list'],
			),
			'join'		 => array(
				array('nilai_pelajaran nipel', 'nipel.id = nisispel.pelajaran_nilai_id', 'inner'),
				array('dakd_pelajaran pelajaran', 'nipel.pelajaran_id = pelajaran.id', 'inner'),
			),
			'select'	 => array(
				'nisispel.id',
				'nisispel.siswa_nilai_id',
				'nisispel.pelajaran_nilai_id',
				'nisispel.nas_teori',
				'nisispel.nas_praktek',
				'nisispel.nas_sikap',
				
				'nisispel.nas_total',
				
				'nisispel.mid_teori',
				'nisispel.mid_praktek',
				'nisispel.mid_sikap',
				
				'nisispel.pred_teori',
				'nisispel.pred_praktek',
				'nisispel.pred_sikap',
				
				'nisispel.mid_pred_teori',
				'nisispel.mid_pred_praktek',
				'nisispel.mid_pred_sikap',
				
				'nisispel.uts',
				'nisispel.uas',
				'nisispel.cat_teori',
				'nisispel.cat_praktek',
				'nisispel.cat_sikap',
				'nisispel.kompetensi',
				
				'nipel.pelajaran_id',
				'pelajaran.mapel_id',
				'pelajaran.kategori_id',
				'pelajaran.agama_id',
			),
		);
		
		if((strtolower(APP_SCOPE)=='sma_terbang')||(strtolower(APP_SCOPE)=='sman9smg')){
			$nisispel_query['select'][] = 'nisispel.skhun_nrata';
			$nisispel_query['select'][] = 'nisispel.skhun_us';
			$nisispel_query['select'][] = 'nisispel.skhun_ns';
			$nisispel_query['select'][] = 'nisispel.skhun_un';
		}
		
		$nisispel_result = $this->md->query($nisispel_query)->result();

		if ($nisispel_result['selected_rows'] == 0)
			return alert_error("Daftar nilai pelajaran tiap siswa tidak ditemukan.");

		// kumpulkan nisispel ke leger

		foreach ($nisispel_result['data'] as $nisispel):
			$nisis_id = (int) $nisispel['siswa_nilai_id'];
			$mapel_id = (int) $nisispel['mapel_id'];
			$kategori_id = (int) $nisispel['kategori_id'];
			$d['leger'][$nisis_id]['nisispel_array'][$kategori_id][$mapel_id] = $nisispel;

		endforeach;

		unset($nisispel_result);

		// ambil daftar pelajaran kelas

		$nipelkls_query = array(
			'from'		 => 'nilai_pelajaran_kelas nipelkls',
			'join'		 => array(
				array('nilai_pelajaran nipel', 'nipel.id = nipelkls.pelajaran_nilai_id', 'inner'),
				array('dakd_pelajaran pelajaran', 'pelajaran.id = nipel.pelajaran_id', 'inner'),
				array('dakd_mapel mapel', 'mapel.id = pelajaran.mapel_id', 'inner'),
				array('dakd_kategori_mapel kategori', 'kategori.id = pelajaran.kategori_id', 'inner'),
			),
			'where'		 => array(
				'nipelkls.kelas_nilai_id' => $id,
			),
			'group_by'	 => 'pelajaran.kategori_id , pelajaran.mapel_id',
			'order_by'	 => 'kategori.nourut , mapel.nourut',
			'select'	 => array(
				'nipel.pelajaran_id',
				'nipel.kkm',
				'nipel.teori',
				'nipel.praktek',
				'pelajaran.mapel_id',
				'mapel_kode' => 'mapel.kode',
				'mapel_nama' => 'mapel.nama',
				'mapel_id' => 'mapel.id',
				'kategori_id' => 'kategori.id',
				'kategori_nama' => 'kategori.nama'
			),
		);

		$nipelkls_result = $this->md->query($nipelkls_query)->result();

		if ($nipelkls_result['selected_rows'] == 0)
			return alert_error("Daftar pelajaran siswa tidak ditemukan.");

		// susun daftar pelajaran

		$d['kolom_nilai_count'] = 0;

		foreach ($nipelkls_result['data'] as $nipelkls):
			if(!(strpos(strtoupper($nipelkls['mapel_nama']), 'ZZ') !== false))
			{
				//$pelajaran_id = (int) $nipelkls['pelajaran_id'];
				$pelajaran_id = (int) $nipelkls['mapel_id'].$nipelkls['kategori_id'];
				$d['pelajaran_array'][$pelajaran_id] = $nipelkls;

				if ($nipelkls['teori'] == 1 && $nipelkls['praktek'] == 1)
					$d['kolom_nilai_count'] += 3;
				else
					$d['kolom_nilai_count'] += 2;
			}
		endforeach;

		unset($nipelkls_result);

		return TRUE;

	}
	
	function leger2($send_data)
	{
		$d = & $this->ci->d;

		// data nilai siswa

		$nisis_result = $this->m_nilai_kelas->rowsub_siswa2($send_data, 0, 1024);

		if ($nisis_result['selected_rows'] == 0)
			return alert_error("Daftar nilai siswa tidak ditemukan.");

		// kumpulkan nisis ke leger
		foreach ($nisis_result['data'] as $nisis):
			$nisis_id = (int) $nisis['id'];
			$d['nisis_list'][] = $nisis_id;
			$d['leger'][$nisis_id] = $nisis;
			$d['list_search1']['semester_id'] = $nisis['semester_id'];
			$d['list_search1']['kelas_grade'] = $nisis['kelas_grade'];
			$d['list_search1']['kelas_jurusan'] = $nisis['kelas_jurusan'];
		endforeach;

		unset($nisis_result);

		// data nilai pelajaran tiap siswa

		$nisispel_query = array(
			'from'		 => 'nilai_siswa_pelajaran nisispel',
			'where_in'	 => array(
				'siswa_nilai_id' => $d['nisis_list'],
			),
			'join'		 => array(
				array('nilai_pelajaran nipel', 'nipel.id = nisispel.pelajaran_nilai_id', 'inner'),
				array('dakd_pelajaran pelajaran', 'nipel.pelajaran_id = pelajaran.id', 'inner'),
			),
			'select'	 => array(
				'nisispel.id',
				'nisispel.siswa_nilai_id',
				'nisispel.pelajaran_nilai_id',
				'nisispel.nas_teori',
				'nisispel.nas_praktek',
				'nisispel.nas_sikap',
				
				'nisispel.nas_total',
				
				'nisispel.mid_teori',
				'nisispel.mid_praktek',
				'nisispel.mid_sikap',
				
				'nisispel.pred_teori',
				'nisispel.pred_praktek',
				'nisispel.pred_sikap',
				
				'nisispel.mid_pred_teori',
				'nisispel.mid_pred_praktek',
				'nisispel.mid_pred_sikap',
				
				'nisispel.uts',
				'nisispel.uas',
				'nisispel.cat_teori',
				'nisispel.cat_praktek',
				'nisispel.cat_sikap',
				'nisispel.kompetensi',
				
				'nipel.pelajaran_id',
				'pelajaran.mapel_id',
				'pelajaran.kategori_id',
				'pelajaran.agama_id',
			),
		);

		$nisispel_result = $this->md->query($nisispel_query)->result();

		if ($nisispel_result['selected_rows'] == 0)
			return alert_error("Daftar nilai pelajaran tiap siswa tidak ditemukan.");

		// kumpulkan nisispel ke leger

		foreach ($nisispel_result['data'] as $nisispel):
			$nisis_id = (int) $nisispel['siswa_nilai_id'];
			$kategori_id = (int) $nisispel['kategori_id'];
			$mapel_id = (int) $nisispel['mapel_id'];
			$d['leger'][$nisis_id]['nisispel_array'][$kategori_id][$mapel_id] = $nisispel;

		endforeach;

		unset($nisispel_result);

		// ambil daftar pelajaran kelas

		$nipelkls_query = array(
			'from'		 => 'nilai_pelajaran_kelas nipelkls',
			'join'		 => array(
				array('nilai_pelajaran nipel', 'nipel.id = nipelkls.pelajaran_nilai_id', 'inner'),
				array('dakd_pelajaran pelajaran', 'pelajaran.id = nipel.pelajaran_id', 'inner'),
				array('dakd_mapel mapel', 'mapel.id = pelajaran.mapel_id', 'inner'),
				array('dakd_kategori_mapel kategori', 'kategori.id = pelajaran.kategori_id', 'inner'),
				array('dakd_kelas kelas', 'kelas.id = nipelkls.kelas_id', 'inner'),
			),
			'where'		 => array(
				'nipel.semester_id' => $d['list_search1']['semester_id'],
				'kelas.grade' => $d['list_search1']['kelas_grade'],
				'kelas.jurusan_id' => $d['list_search1']['kelas_jurusan'],
				
			),
			'group_by'	 => 'pelajaran.kategori_id , pelajaran.mapel_id',
			'order_by'	 => 'kategori.nourut , mapel.nourut',
			'select'	 => array(
				'nipel.pelajaran_id',
				'nipel.kkm',
				'nipel.teori',
				'nipel.praktek',
				'pelajaran.mapel_id',
				'mapel_kode' => 'mapel.kode',
				'mapel_nama' => 'mapel.nama',
				'mapel_id' => 'mapel.id',
				'kategori_id' => 'kategori.id',
				'kategori_nama' => 'kategori.nama'
			),
		);
		/*
		if (!empty($send_data['grade'])) {
			$query['where'] = array('kelas.grade' => $send_data['grade']);
		}
		if (!empty($send_data['kurikulum_id'])) {
			$query['where'] = array('kelas.kurikulum_id' => $send_data['kurikulum_id']);
		}
		*/
		$nipelkls_result = $this->md->query($nipelkls_query)->result();
		//echo "<pre>";
	//	print_r($d); 
	//	echo "</pre>";
	//	break;
		if ($nipelkls_result['selected_rows'] == 0)
			return alert_error("Daftar pelajaran siswa tidak ditemukan.");

		// susun daftar pelajaran

		$d['kolom_nilai_count'] = 0;

		foreach ($nipelkls_result['data'] as $nipelkls):
			if(!(strpos(strtoupper($nipelkls['mapel_nama']), 'ZZ') !== false))
			{
				$pelajaran_id = (int) $nipelkls['mapel_id'].$nipelkls['kategori_id'];
				$d['pelajaran_array'][$pelajaran_id] = $nipelkls;

				if ($nipelkls['teori'] == 1 && $nipelkls['praktek'] == 1)
					$d['kolom_nilai_count'] += 3;
				else
					$d['kolom_nilai_count'] += 2;
			}
		endforeach;

		unset($nipelkls_result);

		return TRUE;

	}
	// tambahan leger : ekskul

	function leger_exkul()
	{
		$d = & $this->ci->d;

		// ekskul

		$query_ekskul = array(
			'select'	 => array(
				'nisisxkul.*',
				'nixkul.ekskul_id',
				'ekskul_nama' => 'ekskul.nama',
			),
			'from'		 => 'nilai_siswa_ekskul nisisxkul',
			'join'		 => array(
				array('nilai_ekskul nixkul', 'nisisxkul.ekskul_nilai_id = nixkul.id', 'inner'),
				array('dnakd_ekskul ekskul', 'nixkul.ekskul_id = ekskul.id', 'inner'),
			),
			'where_in'	 => array(
				'nisisxkul.siswa_nilai_id' => $d['nisis_list'],
			)
		);

		$ekskul = $this->md->query($query_ekskul)->result();
		$d['sql'][] = $ekskul['sql'];

		// kumpulkan nisispel ke leger

		foreach ($ekskul['data'] as $nisixk):
			$nisis_id = (int) $nisixk['siswa_nilai_id'];
			$ekskul_id = (int) $nisixk['ekskul_id'];
			$d['leger'][$nisis_id]['nisixk_array'][$ekskul_id] = $nisixk;

		endforeach;

		unset($ekskul);

	}

	// tambahan leger : organisasi

	function leger_org()
	{
		$d = & $this->ci->d;

		// org

		$query_org = array(
			'select'	 => array(
				'nisisorg.*',
				'niorg.org_id',
				'org_nama' => 'org.nama',
			),
			'from'		 => 'nilai_siswa_org nisisorg',
			'join'		 => array(
				array('nilai_organisasi niorg', 'nisisorg.org_nilai_id = niorg.id', 'inner'),
				array('dnakd_organisasi org', 'niorg.org_id = org.id', 'inner'),
			),
			'where_in'	 => array(
				'nisisorg.siswa_nilai_id' => $d['nisis_list'],
			),
		);

		$org = $this->md->query($query_org)->result();
		$d['sql'][] = $org['sql'];

		// kumpulkan nisispel ke leger

		foreach ($org['data'] as $nisiorg):
			$nisis_id = (int) $nisiorg['siswa_nilai_id'];
			$org_id = (int) $nisiorg['org_id'];
			$d['leger'][$nisis_id]['nisiorg_array'][$org_id] = $nisiorg;

		endforeach;

		unset($org);

	}

	function leger_excel_6semester($id_nikel,$mode='teori',$original = 0)
	{
		$d = & $this->ci->d;
		$this->leger_6semester($id_nikel);
		
		//alert_error(print_r($d['leger']));
		if ($d['error'])
			return redir("nilai/kelas/{$id}");

		$this->load->library('konversi_nilai');
		$this->load->helper('excel');
		excel_load();

		$styleArray = array(
			'fill' => array(
				'type'	 => PHPExcel_Style_Fill::FILL_SOLID,
				'color'	 => array('rgb' => 'DD9898'),
			)
		);
		// deklarasi variabel

		if (TRUE):
			$excel_row_offset = 8;
			$excel_col_offset = ord('T') - 65;
			$style = array(
				'umum' => array(
					'borders'	 => array(
						'allborders' => array(
							'style' => PHPExcel_Style_Border::BORDER_THIN,
						),
					),
					'font'		 => array(
						'size' => 10,
					),
				),
			);
			$style['tengah'] = $style['umum'];
			$style['tengah']['alignment']['horizontal'] = PHPExcel_Style_Alignment::HORIZONTAL_CENTER;
			$style['tengah']['alignment']['vertical'] = PHPExcel_Style_Alignment::VERTICAL_CENTER;
			$style['tengah']['borders']['allborders']['style'] = PHPExcel_Style_Border::BORDER_MEDIUM;
			$style['tengah']['font']['bold'] = TRUE;

			$cfg = array(
				'row.nikls'		 => array(
					// top header
					'A1' => array(
						'semester_nama',
						'strtoupper',
						'prefix' => 'LEGER SEMESTER ',
						'suffix' => array(
							' TAHUN ',
							'ta_nama',
						),
					),
					'A2' => array('kelas_nama', 'strtoupper'),
					'A3' => array(
						'kelas_wali_nama',
						'prefix' => 'Wali Kelas: ',
					),
					// baris 1
					'A5' => 'No',
					'B5' => 'Nama Siswa',
					'C5' => 'NIS',
					'D5' => 'Presensi',
					
					
					'G5' => 'MID Rank',
					'I5' => 'MID Rata2',
					'K5' => 'MID Jumlah',
					
					'N5' => 'AKHIR Rank',
					'P5' => 'AKHIR Rata2',
					'R5' => 'AKHIR Jumlah',
					
					'T5' => 'AGAMA',
					// baris 2
					'D7' => 'S',
					'E7' => 'I',
					'F7' => 'A',
					'I7' => 'Peng',
					'J7' => 'Ketr',
					'K7' => 'Peng',
					'L7' => 'Ketr',
					
					'P7' => 'Peng',
					'Q7' => 'Ketr',
					'R7' => 'Peng',
					'S7' => 'Ketr',
					
					// BARIS 3
					'A8' => 'K K M',
				),
				'merge_cells'	 => array(
					'A5:A7', // no
					'B5:B7', // nama
					'C5:C7', // nis
					'D5:F6', // presensi
					'G5:G7', // rank
					'H5:H7', // spasi
					'I5:J6', // mid rata2
					'K5:L6', // mid jml
					
					'N5:N7', // rank
					'O5:O7', // spasi
					'P5:Q6', // akhir rata2
					'R5:S6', // akhir jml
					'T5:T7', // spasi
					
					'M5:M7', // spasi
					'A7:B7', // kkm
					'C8:S8', // kkm
				),
				'table.nisis'	 => array(
					'B'	 => 'siswa_nama',
					'C'	 => 'siswa_nis',
					
					'T'	 => 'agama_nama',
					
					
				),
				'col.width'		 => array(
					'A'	 => 3,
					'B'	 => 25,
					'C'	 => 8,
					'D'	 => 4,
					'E'	 => 4,
					'F'	 => 4,
					'G'	 => 6,
					'H'	 => 1,
					'I'	 => 5,
					'J'	 => 5,
					'K'	 => 6,
					'L'	 => 6,
					
					'N'	 => 6,
					'O'	 => 1,
					'P'	 => 5,
					'Q'	 => 5,
					'R'	 => 6,
					'S'	 => 6,
					'T'	 => 8,
					
				),
			);
		endif;

		// mulai buka excel

		$excel_obj = new PHPExcel();
		$sheet = $excel_obj->getActiveSheet();
		$row_no = $excel_row_offset;
		$col_no = $excel_col_offset;
		$no = 0;
		$col_teori = array();
		$col_prektek = array();
		$col_mid_teori = array();
		$col_mid_prektek = array();
		
		
		// buat header
		
		excel_mergecells($sheet, $cfg['merge_cells']);
		$sheet->getStyle('A5:T7')->getAlignment()->setWrapText(true); 
		excel_row_write($sheet, $d['row'], $cfg['row.nikls']);

		// ascii 65 = A (kapital)
		// kolom A = nomor 1
		//
		// bagian header pelajaran
		$sheet->getColumnDimension('D')->setVisible(FALSE);
		$sheet->getColumnDimension('E')->setVisible(FALSE);
		$sheet->getColumnDimension('F')->setVisible(FALSE);
		$sheet->getColumnDimension('G')->setVisible(FALSE);
		$sheet->getColumnDimension('H')->setVisible(FALSE);
		$sheet->getColumnDimension('I')->setVisible(FALSE);
		$sheet->getColumnDimension('J')->setVisible(FALSE);
		$sheet->getColumnDimension('K')->setVisible(FALSE);
		$sheet->getColumnDimension('L')->setVisible(FALSE);
		$sheet->getColumnDimension('M')->setVisible(FALSE);
		$sheet->getColumnDimension('N')->setVisible(FALSE);
		$sheet->getColumnDimension('O')->setVisible(FALSE);
		$sheet->getColumnDimension('P')->setVisible(FALSE);
		$sheet->getColumnDimension('Q')->setVisible(FALSE);
		$sheet->getColumnDimension('R')->setVisible(FALSE);
		$sheet->getColumnDimension('S')->setVisible(FALSE);
	
		
	
		foreach ($d['pelajaran_array'] as &$p3lajaran):

			$p3lajaran['teori'] = TRUE;
			$p3lajaran['praktek'] = TRUE;

			// nilai default
			
			
			
			for($jml_semester=1;$jml_semester<=6;$jml_semester++)
			{
				$p3lajaran['excol']['teori'][$jml_semester] = NULL;
				$p3lajaran['excol']['praktek'][$jml_semester] = NULL;
			
				////////// AKHIR /////////////////
				// kognitif
				if ($p3lajaran['teori'] == 1)
				{
					$p3lajaran['excol']['teori'][$jml_semester] = excel_colnumber(++$col_no);
					$col_teori[] = $p3lajaran['excol']['teori'][$jml_semester];
				}
				// psikomotorik
				if ($p3lajaran['praktek'] == 1)
				{
					$p3lajaran['excol']['praktek'][$jml_semester] = excel_colnumber(++$col_no);
					$col_prektek[] = $p3lajaran['excol']['praktek'][$jml_semester];
				}
				// afektif
				$p3lajaran['excol']['sikap_predikat'][$jml_semester] = excel_colnumber(++$col_no);
				
				
			}
			$p3lajaran['excol']['rata_teori'] = excel_colnumber(++$col_no);
			$p3lajaran['excol']['rata_praktek'] = excel_colnumber(++$col_no);
			
			// head baris 1, nama mapel
				$cell = (($p3lajaran['teori'] == 1 ) ? $p3lajaran['excol']['teori'][1] : $p3lajaran['excol']['praktek'][1]) . '5';
				$cell_merge = $cell . ':' . ($p3lajaran['excol']['rata_praktek']) . '5';
	
				if(isset($p3lajaran['mapel_nama']))
					$sheet->setCellValue($cell, "(".$p3lajaran['kategori_kode'].") ".strtoupper($p3lajaran['mapel_nama']));
				$sheet->mergeCells($cell_merge);
	
				// head baris 2 & 3, kategori nilai
			
			
			for($jml_semester=1;$jml_semester<=6;$jml_semester++)
			{
				////////// AKHIR //////////////////////
				//		kognitif
				if ($p3lajaran['teori'] == 1)
				{
					$cell_teori_label = $p3lajaran['excol']['teori'][$jml_semester].'6';
					$cell_teori_nilai = $p3lajaran['excol']['teori'][$jml_semester].'7';
					
					//$sheet->setCellValue($cell_teori_label, "Peng");
					$sheet->setCellValue($cell_teori_label, $jml_semester);
					//$sheet->setCellValue($cell_teori_nilai, "nilai");
					$sheet->setCellValue($cell_teori_nilai, "Peng");
					$sheet->getColumnDimension($p3lajaran['excol']['teori'][$jml_semester])->setWidth(5);
					// HIDDEN
					if($mode!='teori')
					{
						$sheet->getColumnDimension($p3lajaran['excol']['teori'][$jml_semester])->setVisible(FALSE);
					}
				}
				//		Psikomotorik
				if ($p3lajaran['praktek'] == 1)
				{
					$cell_praktek_label = $p3lajaran['excol']['praktek'][$jml_semester].'6';
					$cell_praktek_nilai = $p3lajaran['excol']['praktek'][$jml_semester].'7';
	
					$sheet->setCellValue($cell_praktek_nilai, "Ketr");
					$sheet->getColumnDimension($p3lajaran['excol']['praktek'][$jml_semester])->setWidth(5);
					// HIDDEN
					if($mode!='praktek')
					{
						$sheet->getColumnDimension($p3lajaran['excol']['praktek'][$jml_semester])->setVisible(FALSE);
					}
				}
				//		Afektif
				$cell_sikap_label = $p3lajaran['excol']['sikap_predikat'][$jml_semester].'6';
				$cell_sikap_konv = $p3lajaran['excol']['sikap_predikat'][$jml_semester] . '7';
				// HIDDEN
				if($mode!='sikap')
				{
					$sheet->getColumnDimension($p3lajaran['excol']['sikap_predikat'][$jml_semester])->setVisible(FALSE);
				}
				
				$sheet->setCellValue($cell_sikap_konv, "Sikap");
				$sheet->getColumnDimension($p3lajaran['excol']['sikap_predikat'][$jml_semester])->setWidth(4);
				
				$cell_merge = $p3lajaran['excol']['teori'][$jml_semester] . '6:' . $p3lajaran['excol']['sikap_predikat'][$jml_semester]. '6';
				$sheet->mergeCells($cell_merge);
				
				// head baris 4, KKM
				$cell = (($p3lajaran['teori'] == 1 ) ? $p3lajaran['excol']['teori'][$jml_semester] : $p3lajaran['excol']['praktek'][$jml_semester]) . '8';
				$cell_merge = $cell . ':' . $p3lajaran['excol']['sikap_predikat'][$jml_semester] . '8';
	
				//$sheet->setCellValue($cell, $kkm);
				$sheet->mergeCells($cell_merge);
			}
			
			/// RATA RATA NILAI 6 SEMESTER
			$cell_rata_teori_label		= $p3lajaran['excol']['rata_teori'].'6';
			$cell_rata_praktek_label	= $p3lajaran['excol']['rata_praktek'].'6';
			
			$sheet->mergeCells($p3lajaran['excol']['rata_teori'].'6:'.$p3lajaran['excol']['rata_teori'].'7');
			$sheet->mergeCells($p3lajaran['excol']['rata_praktek'].'6:'.$p3lajaran['excol']['rata_praktek'].'7');
			
			$sheet->getColumnDimension($p3lajaran['excol']['rata_teori'])->setWidth(5);
			$sheet->getColumnDimension($p3lajaran['excol']['rata_praktek'])->setWidth(5);
			
			$sheet->setCellValue($cell_rata_teori_label, "Rata Penge");
			$sheet->setCellValue($cell_rata_praktek_label, "Rata Ketr");
			
			if($mode!='teori')
			{
				$sheet->getColumnDimension($p3lajaran['excol']['rata_teori'])->setVisible(FALSE);
			}
			if($mode!='praktek')
			{
				$sheet->getColumnDimension($p3lajaran['excol']['rata_praktek'])->setVisible(FALSE);
			}
			
			$batas_kanan = $p3lajaran['excol']['rata_praktek'];
		endforeach;
		
		$sheet->getRowDimension(5)->setRowHeight(24);
		$sheet->getStyle('U5:'.$batas_kanan.'7')->getAlignment()->setWrapText(true); 
		
		
		
		
		
		
		// isi data nilai siswa

		foreach ($d['leger'] as $nisis):
			$row_no++;
			$no++;

			$cell = 'A' . $row_no;
			$sheet->setCellValue($cell, $no);

			// nilai siswa

			foreach ($cfg['table.nisis'] as $col_excel => $col_db):
				$cell = $col_excel . $row_no;
				$sheet->setCellValue($cell, $nisis[$col_db]);

			endforeach;
			// detail nilai pelajaran

			foreach ($d['pelajaran_array'] as $pelajaran_no => $pelajaran):

				$pelajaran['teori'] = TRUE;
				$pelajaran['praktek'] = TRUE;

				$kategori_id = $pelajaran['kategori_id'];
				$mapel_id	 = $pelajaran['mapel_id'];
				// statusikut pelajaran tsb tidaknya

				//$ikut_belajar = array_key_exists($pelajaran_id, $nisis['nisispel_array']);

				// teori

				if ($pelajaran['teori'] == 1)
				{
					
					$jml_semester=1;
					$rumus_rata_teori = '=AVERAGE(';
					for($tingkat_kelas=10;$tingkat_kelas<=12;$tingkat_kelas++)
					{
						for($no_semester=1;$no_semester<=2;$no_semester++)
						{
							
							if($no_semester==1)
								$nama_semester='GASAL';
							else
								$nama_semester='GENAP';
							
							$teori_nas = "-";
							//echo $kategori_id." ".$mapel_id; 
							
							$teori_nas_cel = $pelajaran['excol']['teori'][$jml_semester] . $row_no;
							
							if(isset($nisis['nisispel_array'][$tingkat_kelas][$nama_semester][$kategori_id]))
							{
								if(isset($nisis['nisispel_array'][$tingkat_kelas][$nama_semester][$kategori_id][$mapel_id]))
								{
								$teori_nas = ($nisis['nisispel_array'][$tingkat_kelas][$nama_semester][$kategori_id][$mapel_id]['nas_teori']);
								$semester_id = ($nisis['nisispel_array'][$tingkat_kelas][$nama_semester][$kategori_id][$mapel_id]['semester_id']);
									
								}
							}
							
							$sheet->setCellValue($teori_nas_cel, $teori_nas);
							if($jml_semester<6){
								$rumus_rata_teori = $rumus_rata_teori.$teori_nas_cel.",";
							}else{
								$rumus_rata_teori = $rumus_rata_teori.$teori_nas_cel.")";
							}
							$jml_semester++;
							
						}
					}
					
					$sheet->setCellValue($pelajaran['excol']['rata_teori'] . $row_no, $rumus_rata_teori);
				}
				
				if ($pelajaran['praktek'] == 1)
				{
					
					$jml_semester=1;
					$rumus_rata_praktek = '=AVERAGE(';
					for($tingkat_kelas=10;$tingkat_kelas<=12;$tingkat_kelas++)
					{
						for($no_semester=1;$no_semester<=2;$no_semester++)
						{
							
							if($no_semester==1)
								$nama_semester='GASAL';
							else
								$nama_semester='GENAP';
							
							$praktek_nas = "-";
							//echo $kategori_id." ".$mapel_id; 
							
							$praktek_nas_cel = $pelajaran['excol']['praktek'][$jml_semester] . $row_no;
							
							if(isset($nisis['nisispel_array'][$tingkat_kelas][$nama_semester][$kategori_id]))
							{
								if(isset($nisis['nisispel_array'][$tingkat_kelas][$nama_semester][$kategori_id][$mapel_id]))
								{
									
								$praktek_nas = ($nisis['nisispel_array'][$tingkat_kelas][$nama_semester][$kategori_id][$mapel_id]['nas_praktek']);
								$semester_id = ($nisis['nisispel_array'][$tingkat_kelas][$nama_semester][$kategori_id][$mapel_id]['semester_id']);
									
								}
							}
							
							$sheet->setCellValue($praktek_nas_cel, $praktek_nas);
							
							if($jml_semester<6){
								$rumus_rata_praktek = $rumus_rata_praktek.$praktek_nas_cel.",";
							}else{
								$rumus_rata_praktek = $rumus_rata_praktek.$praktek_nas_cel.")";
							}
							$jml_semester++;
							
						}
					}
					
					$sheet->setCellValue($pelajaran['excol']['rata_praktek'] . $row_no, $rumus_rata_praktek);
				}
				
				    $jml_semester=1;
					for($tingkat_kelas=10;$tingkat_kelas<=12;$tingkat_kelas++)
					{
						for($no_semester=1;$no_semester<=2;$no_semester++)
						{
							
							if($no_semester==1)
								$nama_semester='GASAL';
							else
								$nama_semester='GENAP';
							
							$sikap_predikat = "-";
							//echo $kategori_id." ".$mapel_id; 
							
							$sikap_nas_cel = $pelajaran['excol']['sikap_predikat'][$jml_semester] . $row_no;
							
							if(isset($nisis['nisispel_array'][$tingkat_kelas][$nama_semester][$kategori_id]))
							{
								if(isset($nisis['nisispel_array'][$tingkat_kelas][$nama_semester][$kategori_id][$mapel_id]))
								{
								$sikap_predikat = ($nisis['nisispel_array'][$tingkat_kelas][$nama_semester][$kategori_id][$mapel_id]['pred_sikap']);
								}
							}
							
							$sheet->setCellValue($sikap_nas_cel, $sikap_predikat);
							$jml_semester++;
							
						}
					}
					
			endforeach;
			
			
		endforeach;
			
			
		
		
		$getHighestColumn = $sheet->getHighestColumn();
		$row_first = $excel_row_offset + 1;
		$row_last = $row_no;

		// formating

		foreach ($cfg['col.width'] as $col => $wid)
			$sheet->getColumnDimension($col)->setWidth($wid);

		$sheet->getStyle("A{$row_first}:{$getHighestColumn}{$row_last}")->applyFromArray($style['umum']);
		$sheet->getStyle("A5:{$getHighestColumn}7")->applyFromArray($style['tengah']);
		$sheet->freezePane("C{$row_first}");

		// output

		return excel_output_2007($excel_obj, "leger_6semester_{$d['row']['kelas_nama']}.xlsx");
		
	}

	
	/*
	function leger_excel($id,$mode='UTS',$original = 0)
	{
		if($original == 0)
		{	$kkm = 2.67;	}
		elseif($original == 1)
		{	$kkm = 75;	}

		$d = & $this->ci->d;
		$deskripsi_nilai		= $this->m_nilai_siswa->deskripsi_nilai($d['row']['semester_id']);
		$deskripsi_pelajaran	= $this->m_nilai_siswa->deskripsi_pelajaran($d['row']['semester_id']);

		$this->leger($id);
		$this->leger_exkul();
		$this->leger_org();

		if ($d['error'])
			return redir("nilai/kelas/{$id}");

		$this->load->library('konversi_nilai');
		$this->load->helper('excel');
		excel_load();

		$styleArray = array(
			'fill' => array(
				'type'	 => PHPExcel_Style_Fill::FILL_SOLID,
				'color'	 => array('rgb' => 'DD9898'),
			)
		);
		// deklarasi variabel

		if (TRUE):
			$excel_row_offset = 8;
			$excel_col_offset = ord('T') - 65;
			$style = array(
				'umum' => array(
					'borders'	 => array(
						'allborders' => array(
							'style' => PHPExcel_Style_Border::BORDER_THIN,
						),
					),
					'font'		 => array(
						'size' => 10,
					),
				),
			);
			$style['tengah'] = $style['umum'];
			$style['tengah']['alignment']['horizontal'] = PHPExcel_Style_Alignment::HORIZONTAL_CENTER;
			$style['tengah']['alignment']['vertical'] = PHPExcel_Style_Alignment::VERTICAL_CENTER;
			$style['tengah']['borders']['allborders']['style'] = PHPExcel_Style_Border::BORDER_MEDIUM;
			$style['tengah']['font']['bold'] = TRUE;

			$cfg = array(
				'row.nikls'		 => array(
					// top header
					'A1' => array(
						'semester_nama',
						'strtoupper',
						'prefix' => 'LEGER SEMESTER ',
						'suffix' => array(
							' TAHUN ',
							'ta_nama',
						),
					),
					'A2' => array('kelas_nama', 'strtoupper'),
					'A3' => array(
						'kelas_wali_nama',
						'prefix' => 'Wali Kelas: ',
					),
					// baris 1
					'A5' => 'No',
					'B5' => 'Nama Siswa',
					'C5' => 'NIS',
					'D5' => 'Presensi',
					
					
					'G5' => 'MID Rank',
					'I5' => 'MID Rata2',
					'K5' => 'MID Jumlah',
					
					'N5' => 'AKHIR Rank',
					'P5' => 'AKHIR Rata2',
					'R5' => 'AKHIR Jumlah',
					
					'M5' => 'AGAMA',
					// baris 2
					'D7' => 'S',
					'E7' => 'I',
					'F7' => 'A',
					'I7' => 'Peng',
					'J7' => 'Ketr',
					'K7' => 'Peng',
					'L7' => 'Ketr',
					
					'P7' => 'Peng',
					'Q7' => 'Ketr',
					'R7' => 'Peng',
					'S7' => 'Ketr',
					
					// BARIS 3
					'A8' => 'K K M',
				),
				'merge_cells'	 => array(
					'A5:A7', // no
					'B5:B7', // nama
					'C5:C7', // nis
					'D5:F6', // presensi
					'G5:G7', // rank
					'H5:H7', // spasi
					'I5:J6', // mid rata2
					'K5:L6', // mid jml
					
					'N5:N7', // rank
					'O5:O7', // spasi
					'P5:Q6', // akhir rata2
					'R5:S6', // akhir jml
					'T5:T7', // spasi
					
					'M5:M7', // spasi
					'A7:B7', // kkm
					'C8:S8', // kkm
				),
				'table.nisis'	 => array(
					'B'	 => 'siswa_nama',
					'C'	 => 'siswa_nis',
					'D'	 => 'absen_s',
					'E'	 => 'absen_i',
					'F'	 => 'absen_a',
					
					'M'	 => 'agama_nama',
					//'' => '___',
					
					'P'	 => 'nas_teori',
					'Q'	 => 'nas_praktek',
				),
				'col.width'		 => array(
					'A'	 => 3,
					'B'	 => 25,
					'C'	 => 8,
					'D'	 => 4,
					'E'	 => 4,
					'F'	 => 4,
					'G'	 => 6,
					'H'	 => 1,
					'I'	 => 5,
					'J'	 => 5,
					'K'	 => 6,
					'L'	 => 6,
					'M'	 => 8,
					
					'N'	 => 6,
					'O'	 => 1,
					'P'	 => 5,
					'Q'	 => 5,
					'R'	 => 6,
					'S'	 => 6,
					'T'	 => 1,
					
				),
			);
		endif;

		// mulai buka excel

		$excel_obj = new PHPExcel();
		$sheet = $excel_obj->getActiveSheet();
		$row_no = $excel_row_offset;
		$col_no = $excel_col_offset;
		$no = 0;
		$col_teori = array();
		$col_prektek = array();
		$col_mid_teori = array();
		$col_mid_prektek = array();

		// buat header

		excel_mergecells($sheet, $cfg['merge_cells']);
		$sheet->getStyle('A5:T7')->getAlignment()->setWrapText(true); 
		excel_row_write($sheet, $d['row'], $cfg['row.nikls']);

		// ascii 65 = A (kapital)
		// kolom A = nomor 1
		//
		// bagian header pelajaran

		foreach ($d['pelajaran_array'] as &$p3lajaran):

			$p3lajaran['teori'] = TRUE;
			$p3lajaran['praktek'] = TRUE;

			// nilai default

			$p3lajaran['excol']['midteori'] = NULL;
			$p3lajaran['excol']['midpraktek'] = NULL;
			
			$p3lajaran['excol']['teori'] = NULL;
			$p3lajaran['excol']['praktek'] = NULL;
			
			////////// MID /////////////////
			// kognitif
			if ($p3lajaran['teori'] == 1)
			{
				$p3lajaran['excol']['midteori'] = excel_colnumber(++$col_no);
				$col_mid_teori[] = $p3lajaran['excol']['midteori'];
			}
			// psikomotorik
			if ($p3lajaran['praktek'] == 1)
			{
				$p3lajaran['excol']['midpraktek'] = excel_colnumber(++$col_no);
				$col_mid_prektek[] = $p3lajaran['excol']['midpraktek'];
			}
			// afektif
			$p3lajaran['excol']['midsikap_predikat'] = excel_colnumber(++$col_no);
			
			////////// AKHIR /////////////////
			// kognitif
			if ($p3lajaran['teori'] == 1)
			{
				$p3lajaran['excol']['teori'] = excel_colnumber(++$col_no);
				$col_teori[] = $p3lajaran['excol']['teori'];
			}
			// psikomotorik
			if ($p3lajaran['praktek'] == 1)
			{
				$p3lajaran['excol']['praktek'] = excel_colnumber(++$col_no);
				$col_prektek[] = $p3lajaran['excol']['praktek'];
			}
			// afektif
			$p3lajaran['excol']['sikap_predikat'] = excel_colnumber(++$col_no);
			
			// head baris 1, nama mapel
			$cell = (($p3lajaran['teori'] == 1 ) ? $p3lajaran['excol']['midteori'] : $p3lajaran['excol']['midpraktek']) . '5';
			$cell_merge = $cell . ':' . ($p3lajaran['excol']['sikap_predikat']) . '5';

			//$sheet->setCellValue($cell, strtoupper($p3lajaran['mapel_nama']));
			$title_kategori = '';
			if(strpos(strtoupper($p3lajaran['kategori_nama']),"WAJIB") !== false)
				$title_kategori = '(wajib)';	
			if(strpos(strtoupper($p3lajaran['kategori_nama']),"PEMINATAN") !== false)
				$title_kategori = '(peminatan)';
			if(strpos(strtoupper($p3lajaran['kategori_nama']),"LINTAS") !== false)
				$title_kategori = '(l. minat)';
			
			$sheet->setCellValue($cell, strtoupper($p3lajaran['mapel_kode']." ".$title_kategori));
			$sheet->mergeCells($cell_merge);

			// head baris 2 & 3, kategori nilai
			////////// MID //////////////////////
			//		kognitif
			if ($p3lajaran['teori'] == 1)
			{
				$cell_teori_label = "{$p3lajaran['excol']['midteori']}6";
				$cell_teori_nilai = $p3lajaran['excol']['midteori'] . '7';
				
				$sheet->setCellValue($cell_teori_label, "MID");
				$sheet->setCellValue($cell_teori_nilai, "Peng");
				$sheet->getColumnDimension($p3lajaran['excol']['midteori'])->setWidth(5);
				// HIDDEN
				if($mode=='UAS')
				{
					$sheet->getColumnDimension('I')->setVisible(FALSE);
					$sheet->getColumnDimension('J')->setVisible(FALSE);
					$sheet->getColumnDimension('K')->setVisible(FALSE);
					$sheet->getColumnDimension('L')->setVisible(FALSE);
					$sheet->getColumnDimension($p3lajaran['excol']['midteori'])->setVisible(FALSE);
				}
			}
			//		Psikomotorik
			if ($p3lajaran['praktek'] == 1)
			{
				$cell_praktek_nilai = $p3lajaran['excol']['midpraktek'] . '7';

				$sheet->setCellValue($cell_praktek_nilai, "Ketr");
				$sheet->getColumnDimension($p3lajaran['excol']['midpraktek'])->setWidth(5);
				// HIDDEN
				if($mode=='UAS')
				{
					$sheet->getColumnDimension($p3lajaran['excol']['midpraktek'])->setVisible(FALSE);
				}
			}
			//		Afektif
			$cell_sikap_konv = $p3lajaran['excol']['midsikap_predikat'] . '7';

			$sheet->setCellValue($cell_sikap_konv, "Sikap");
			$sheet->getColumnDimension($p3lajaran['excol']['midsikap_predikat'])->setWidth(4);
			// HIDDEN
			if($mode=='UAS')
			{
				$sheet->getColumnDimension($p3lajaran['excol']['midsikap_predikat'])->setVisible(FALSE);
			}
			
			$cell_merge = $p3lajaran['excol']['midteori'] . '6' . ':' . $p3lajaran['excol']['midsikap_predikat'] . '6';
			$sheet->mergeCells($cell_merge);
			
			
			////////// AKHIR //////////////////////
			//		kognitif
			if ($p3lajaran['teori'] == 1)
			{
				$cell_teori_label = "{$p3lajaran['excol']['teori']}6";
				$cell_teori_nilai = $p3lajaran['excol']['teori'] . '7';
				
				//$sheet->setCellValue($cell_teori_label, "Peng");
				$sheet->setCellValue($cell_teori_label, "AKHIR");
				//$sheet->setCellValue($cell_teori_nilai, "nilai");
				$sheet->setCellValue($cell_teori_nilai, "Peng");
				$sheet->getColumnDimension($p3lajaran['excol']['teori'])->setWidth(5);
				// HIDDEN
				if($mode=='UTS')
				{
					$sheet->getColumnDimension('P')->setVisible(FALSE);
					$sheet->getColumnDimension('Q')->setVisible(FALSE);
					$sheet->getColumnDimension('R')->setVisible(FALSE);
					$sheet->getColumnDimension('S')->setVisible(FALSE);
					$sheet->getColumnDimension($p3lajaran['excol']['teori'])->setVisible(FALSE);
					
					$sheet->getColumnDimension('N')->setVisible(FALSE);
				}
			}
			//		Psikomotorik
			if ($p3lajaran['praktek'] == 1)
			{
				$cell_praktek_label = "{$p3lajaran['excol']['praktek']}6";
				$cell_praktek_nilai = $p3lajaran['excol']['praktek'] . '7';

				//$sheet->setCellValue($cell_praktek_label, "Ketr");
				//$sheet->setCellValue($cell_praktek_nilai, "nilai");
				$sheet->setCellValue($cell_praktek_nilai, "Ketr");
				$sheet->getColumnDimension($p3lajaran['excol']['praktek'])->setWidth(5);
				// HIDDEN
				if($mode=='UTS')
				{
					$sheet->getColumnDimension($p3lajaran['excol']['praktek'])->setVisible(FALSE);
				}
			}
			//		Afektif
			$cell_sikap_label = "{$p3lajaran['excol']['sikap_predikat']}6";
			//$cell_sikap_nilai = $p3lajaran['excol']['sikap_predikat'] . '7';
			$cell_sikap_konv = $p3lajaran['excol']['sikap_predikat'] . '7';
			// HIDDEN
			if($mode=='UTS')
			{
				$sheet->getColumnDimension($p3lajaran['excol']['sikap_predikat'])->setVisible(FALSE);
			}
			//$sheet->setCellValue($cell_sikap_label, "Sikap");
			//$sheet->setCellValue($cell_sikap_nilai, "nilai");
			//$sheet->setCellValue($cell_sikap_konv, "pred");
			$sheet->setCellValue($cell_sikap_konv, "Sikap");
			$sheet->getColumnDimension($p3lajaran['excol']['sikap_predikat'])->setWidth(4);
			
			$cell_merge = $p3lajaran['excol']['teori'] . '6:' . $p3lajaran['excol']['sikap_predikat'] . '6';
			$sheet->mergeCells($cell_merge);
			
			// head baris 4, KKM
			$cell = (($p3lajaran['teori'] == 1 ) ? $p3lajaran['excol']['midteori'] : $p3lajaran['excol']['praktek']) . '8';
			$cell_merge = $cell . ':' . $p3lajaran['excol']['sikap_predikat'] . '8';

			// KKM ASLI
			$kkm = $p3lajaran['kkm'];
			$sheet->setCellValue($cell, $kkm);
			$sheet->mergeCells($cell_merge);

		endforeach;

		// template rumus jumlah & rata2 nilai
		/////////// MID ///////////////////
		$range_mid_teori = NULL;
		$range_mid_praktek = NULL;
		$rangelist_mid_teori = array();
		$rangelist_mid_praktek = array();

		foreach ($col_mid_teori as $c_m_t)
		{
			$rangelist_mid_teori[] = "{$c_m_t}{row}";
		}

		foreach ($col_mid_prektek as $c_m_p)
		{
			$rangelist_mid_praktek[] = "{$c_m_p}{row}";
		}

		if (!empty($rangelist_mid_teori))
			$range_mid_teori = implode(",", $rangelist_mid_teori);

		if (!empty($rangelist_mid_praktek))
			$range_mid_praktek = implode(",", $rangelist_mid_praktek);

		$rumus_jml_mid_teori = "=IF(COUNT({$range_mid_teori})>0, SUM({$range_mid_teori}))";
		$rumus_jml_mid_praktek = "=IF(COUNT({$range_mid_praktek})>0, SUM({$range_mid_praktek}))";
		$rumus_rt2_mid_teori = "=IF(COUNT({$range_mid_teori})>0, AVERAGE({$range_mid_teori}))";
		$rumus_rt2_mid_praktek = "=IF(COUNT({$range_mid_praktek})>0, AVERAGE({$range_mid_praktek}))";
		
		/////////// AKHIR ///////////////////
		$range_teori = NULL;
		$range_praktek = NULL;
		$rangelist_teori = array();
		$rangelist_praktek = array();

		foreach ($col_teori as $c_t)
		{
			$rangelist_teori[] = "{$c_t}{row}";
		}

		foreach ($col_prektek as $c_p)
		{
			$rangelist_praktek[] = "{$c_p}{row}";
		}

		if (!empty($rangelist_teori))
			$range_teori = implode(",", $rangelist_teori);

		if (!empty($rangelist_praktek))
			$range_praktek = implode(",", $rangelist_praktek);

		$rumus_jml_teori = "=IF(COUNT({$range_teori})>0, SUM({$range_teori}))";
		$rumus_jml_praktek = "=IF(COUNT({$range_praktek})>0, SUM({$range_praktek}))";
		$rumus_rt2_teori = "=IF(COUNT({$range_teori})>0, AVERAGE({$range_teori}))";
		$rumus_rt2_praktek = "=IF(COUNT({$range_praktek})>0, AVERAGE({$range_praktek}))";


		// rumus rangking
		$jml_siswa = count($d['leger']);
		$row_start = $row_no + 1;
		$row_end = $row_no + $jml_siswa;
		/// MID /////
		$rumus_mid_rank = "=IF(ISNUMBER(I{row}),RANK(I{row},I{$row_start}:I{$row_end},0),\"\")";
		
		/// AKHIR /////
		$rumus_rank = "=IF(ISNUMBER(P{row}),RANK(P{row},P{$row_start}:P{$row_end},0),\"\")";
		

		// spasi bagian

		$space_col = excel_colnumber(++$col_no);
		$space_range = "{$space_col}5:{$space_col}7";

		$sheet->mergeCells($space_range);
		$sheet->getColumnDimension($space_col)->setWidth(1);

		//* /
		//
		  // header tiap ekskul

		for ($i_xk = 1; $i_xk <= 3; $i_xk++)
		{
			$_xk['excol_nama'] = excel_colnumber(++$col_no);
			$_xk['excol_predikat'] = excel_colnumber(++$col_no);
			$_xk['excol_desc'] = excel_colnumber(++$col_no);
			$d['xk_array'][$i_xk] = $_xk;

			$sheet->setCellValue("{$_xk['excol_nama']}6", "Ekstrakurikuler {$i_xk}");
			$sheet->setCellValue("{$_xk['excol_nama']}7", "Nama");
			$sheet->setCellValue("{$_xk['excol_predikat']}7", "Predikat");
			$sheet->setCellValue("{$_xk['excol_desc']}7", "Deskripsi");
			$sheet->getColumnDimension($_xk['excol_nama'])->setWidth(10);
			$sheet->getColumnDimension($_xk['excol_predikat'])->setWidth(10);
			$sheet->getColumnDimension($_xk['excol_desc'])->setWidth(20);
			$sheet->mergeCells("{$_xk['excol_nama']}6:{$_xk['excol_desc']}6");
		}

		//* /
		// header bagian ekskul

		$_cell = "{$d['xk_array'][1]['excol_nama']}5";
		$_range = "{$d['xk_array'][1]['excol_nama']}5:{$d['xk_array'][3]['excol_desc']}5";

		$sheet->setCellValue($_cell, "Keterangan Ekstrakurikuler");
		$sheet->mergeCells($_range);

		//* /
		//
		  // spasi bagian

		$space_col = excel_colnumber(++$col_no);
		$space_range = "{$space_col}5:{$space_col}7";

		$sheet->mergeCells($space_range);
		$sheet->getColumnDimension($space_col)->setWidth(1);

		// * /
		//
		  // header tiap organisasi

		for ($i_org = 1; $i_org <= 3; $i_org++)
		{
			$_org['excol_nama'] = excel_colnumber(++$col_no);
			$_org['excol_desc'] = excel_colnumber(++$col_no);
			$d['org_array'][$i_org] = $_org;

			$sheet->setCellValue("{$_org['excol_nama']}6", "Organisasi {$i_org}");
			$sheet->setCellValue("{$_org['excol_nama']}7", "Nama");
			$sheet->setCellValue("{$_org['excol_desc']}7", "Deskripsi");
			$sheet->getColumnDimension($_org['excol_nama'])->setWidth(10);
			$sheet->getColumnDimension($_org['excol_desc'])->setWidth(20);
			$sheet->mergeCells("{$_org['excol_nama']}6:{$_org['excol_desc']}6");
		}

		// header bagian organisasi

		$_cell = "{$d['org_array'][1]['excol_nama']}5";
		$_range = "{$d['org_array'][1]['excol_nama']}5:{$d['org_array'][3]['excol_desc']}5";

		$sheet->setCellValue($_cell, "Keterangan Organisasi");
		$sheet->mergeCells($_range);

		// spasi bagian

		$space_col = excel_colnumber(++$col_no);
		$space_range = "{$space_col}5:{$space_col}7";
		$deskripsi_topleft = $col_no + 1;

		$sheet->mergeCells($space_range);
		$sheet->getColumnDimension($space_col)->setWidth(1);

		// bagian deskripsi pelajaran

		foreach ($d['pelajaran_array'] as &$p3lajaran_2):

			// nilai default

			$p3lajaran_2['excol']['teori_desc'] = NULL;
			$p3lajaran_2['excol']['praktek_desc'] = NULL;

			// kognitif

			if ($p3lajaran_2['teori'] == 1)
			{
				$p3lajaran_2['excol']['teori_desc'] = excel_colnumber(++$col_no);
			}

			// psikomotorik

			if ($p3lajaran_2['praktek'] == 1)
			{
				$p3lajaran_2['excol']['praktek_desc'] = excel_colnumber(++$col_no);
			}

			// afektif

			$p3lajaran_2['excol']['sikap_desc'] = excel_colnumber(++$col_no);

			// head baris 2, nama mapel

			$cell = (($p3lajaran_2['teori'] == 1) ? $p3lajaran_2['excol']['teori_desc'] : $p3lajaran_2['excol']['praktek_desc']) . '6';
			$cell_merge = $cell . ':' . ($p3lajaran_2['excol']['sikap_desc']) . '6';

			$sheet->mergeCells($cell_merge);
			$sheet->setCellValue($cell, strtoupper($p3lajaran_2['mapel_nama']));

			// head baris 3, kategori nilai
			//
			//		kognitif

			if ($p3lajaran_2['teori'] == 1)
			{
				$cell_teori = $p3lajaran_2['excol']['teori_desc'] . '7';
				$sheet->setCellValue($cell_teori, "Peng");
			}

			//		Psikomotorik

			if ($p3lajaran_2['praktek'] == 1)
			{
				$cell_praktek = $p3lajaran_2['excol']['praktek_desc'] . '7';
				$sheet->setCellValue($cell_praktek, "Ketr");
			}

			//		Afektif

			$cell_sikap = $p3lajaran_2['excol']['sikap_desc'] . '7';

			$sheet->setCellValue($cell_sikap, "Sikap");

		endforeach;

		// header deskripsi baris 1

		$_cell = excel_colnumber($deskripsi_topleft) . "5";
		$_range = "{$_cell}:{$p3lajaran_2['excol']['sikap_desc']}5";

		$sheet->mergeCells($_range);
		$sheet->setCellValue($_cell, "Keterangan / Deskripsi Pelajaran");

		// 
		//
		// isi data nilai siswa

		foreach ($d['leger'] as $nisis):
			$row_no++;
			$no++;

			$cell = 'A' . $row_no;
			$sheet->setCellValue($cell, $no);

			// nilai siswa

			foreach ($cfg['table.nisis'] as $col_excel => $col_db):
				$cell = $col_excel . $row_no;
				$sheet->setCellValue($cell, $nisis[$col_db]);

			endforeach;

			// detail nilai pelajaran

			foreach ($d['pelajaran_array'] as $pelajaran_id => $pelajaran):

				$pelajaran['teori'] = TRUE;
				$pelajaran['praktek'] = TRUE;
				$kategori_id = $pelajaran['kategori_id'];
				$mapel_id	 = $pelajaran['mapel_id'];
				
				// statusikut pelajaran tsb tidaknya

				$ikut_belajar = array_key_exists($pelajaran_id, $nisis['nisispel_array']);

				// teori

				if ($pelajaran['teori'] == 1)
				{
					$teori_mid = "-";
					$teori_nas = "-";

					//$teori_konv = "-";
					$teori_cat = "-";
					$teori_mid_cel = $pelajaran['excol']['midteori'] . $row_no;
					$teori_nas_cel = $pelajaran['excol']['teori'] . $row_no;
					//$teori_konv_cel = $pelajaran['excol']['teori_konversi'] . $row_no;
					$teori_cat_cel = $pelajaran['excol']['teori_desc'] . $row_no;

					//if ($ikut_belajar)
					//{
						$teori_mid = ($nisis['nisispel_array'][$kategori_id][$mapel_id]['mid_teori']);
						$teori_nas = ($nisis['nisispel_array'][$kategori_id][$mapel_id]['nas_teori']);

						
						
							foreach ($deskripsi_pelajaran['data'] as $deskripsi)
							{
								if (($deskripsi['mapel_id'] == $nisis['nisispel_array'][$kategori_id][$mapel_id]['mapel_id']) && 
								($deskripsi['kategori_id'] == $nisis['nisispel_array'][$kategori_id][$mapel_id]['kategori_id']) && 
								($deskripsi['grade'] == $nisis['kelas_grade']) && ($deskripsi['aspek_penilaian_id'] == 1) )
								{
									if(	( $nisis['nisispel_array'][$kategori_id][$mapel_id]['pred_teori']=='A' && $deskripsi['kode']==1 )||
										( $nisis['nisispel_array'][$kategori_id][$mapel_id]['pred_teori']=='B' && $deskripsi['kode']==2 )||
										( $nisis['nisispel_array'][$kategori_id][$mapel_id]['pred_teori']=='C' && $deskripsi['kode']==3 )||
										( $nisis['nisispel_array'][$kategori_id][$mapel_id]['pred_teori']=='D' && $deskripsi['kode']==4 )	)
									{							
										if ((($deskripsi['agama_id'] != 0) && 
										($deskripsi['agama_id'] == $nisis['nisispel_array'][$kategori_id][$mapel_id]['agama_id'])) || 
										($deskripsi['agama_id'] == 0))
										{
											$teori_cat = $deskripsi['deskripsi'];
										}
									}
								}
							}
						
					//}

					if ($teori_mid < $kkm)
					{
						$sheet->getStyle($teori_mid_cel)->applyFromArray($styleArray);
					}
					if ($teori_nas < $kkm)
					{
						$sheet->getStyle($teori_nas_cel)->applyFromArray($styleArray);
					}
					$sheet->setCellValue($teori_mid_cel, $teori_mid);
					$sheet->setCellValue($teori_nas_cel, $teori_nas);
					//$sheet->setCellValue($teori_konv_cel, $teori_konv);
					$sheet->setCellValue($teori_cat_cel, $teori_cat);
				}

				// praktek

				if ($pelajaran['praktek'] == 1 or TRUE)
				{
					$praktek_mid = "-";
					$praktek_nas = "-";
					//$praktek_konv = "-";
					$praktek_cat = "-";
					
					$praktek_mid_cel = $pelajaran['excol']['midpraktek'] . $row_no;
					$praktek_nas_cel = $pelajaran['excol']['praktek'] . $row_no;
					//$praktek_konv_cel = $pelajaran['excol']['praktek_konversi'] . $row_no;
					$praktek_cat_cel = $pelajaran['excol']['praktek_desc'] . $row_no;

					//if ($ikut_belajar)
					//{
						$praktek_mid = ($nisis['nisispel_array'][$kategori_id][$mapel_id]['mid_praktek']);
						$praktek_nas = ($nisis['nisispel_array'][$kategori_id][$mapel_id]['nas_praktek']);

						
							foreach ($deskripsi_pelajaran['data'] as $deskripsi)
							{
								if (($deskripsi['mapel_id'] == $nisis['nisispel_array'][$kategori_id][$mapel_id]['mapel_id']) && 
								($deskripsi['kategori_id'] == $nisis['nisispel_array'][$kategori_id][$mapel_id]['kategori_id']) && 
								($deskripsi['grade'] == $nisis['kelas_grade']) && ($deskripsi['aspek_penilaian_id'] == 2) )
								{
									if(	( $nisis['nisispel_array'][$kategori_id][$mapel_id]['pred_praktek']=='A' && $deskripsi['kode']==1 )||
										( $nisis['nisispel_array'][$kategori_id][$mapel_id]['pred_praktek']=='B' && $deskripsi['kode']==2 )||
										( $nisis['nisispel_array'][$kategori_id][$mapel_id]['pred_praktek']=='C' && $deskripsi['kode']==3 )||
										( $nisis['nisispel_array'][$kategori_id][$mapel_id]['pred_praktek']=='D' && $deskripsi['kode']==4 )	)
									{
										if ((($deskripsi['agama_id'] != 0) && 
										($deskripsi['agama_id'] == $nisis['nisispel_array'][$kategori_id][$mapel_id]['agama_id'])) || 
										($deskripsi['agama_id'] == 0))
										{
											$praktek_cat = $deskripsi['deskripsi'];
										}
									}
								}
							}
						
					//}
					
					if ($praktek_mid < $kkm)
					{
						$sheet->getStyle($praktek_mid_cel)->applyFromArray($styleArray);
					}
					if ($praktek_nas < $kkm)
					{
						$sheet->getStyle($praktek_nas_cel)->applyFromArray($styleArray);
					}
					$sheet->setCellValue($praktek_mid_cel, $praktek_mid);
					$sheet->setCellValue($praktek_nas_cel, $praktek_nas);
					//$sheet->setCellValue($praktek_konv_cel, $praktek_konv);
					$sheet->setCellValue($praktek_cat_cel, $praktek_cat);
				}

				// sikap
				//$sikap_nas = "-";
				$mid_sikap_pred = "-";
				$sikap_pred = "-";
				$sikap_cat = "-";
				//$sikap_nas_cel = $pelajaran['excol']['sikap'] . $row_no;
				
				$mid_sikap_pred_cel = $pelajaran['excol']['midsikap_predikat'] . $row_no;
				$sikap_pred_cel = $pelajaran['excol']['sikap_predikat'] . $row_no;
				$sikap_cat_cel = $pelajaran['excol']['sikap_desc'] . $row_no;

				if ($ikut_belajar)
				{
					
						$mid_sikap_pred = $nisis['nisispel_array'][$kategori_id][$mapel_id]['mid_pred_sikap'];
						$sikap_pred = $nisis['nisispel_array'][$kategori_id][$mapel_id]['pred_sikap'];
					
				}

				//$sheet->setCellValue($sikap_nas_cel, $sikap_nas);
				if (($mid_sikap_pred == 'C') || ($mid_sikap_pred == 'D') || ($mid_sikap_pred == 'E') || ($mid_sikap_pred == 'K') || ($mid_sikap_pred == "-"))
				{
					$sheet->getStyle($mid_sikap_pred_cel)->applyFromArray($styleArray);
				}
				if (($sikap_pred == 'C') || ($sikap_pred == 'D') || ($sikap_pred == 'E') || ($sikap_pred == 'K') || ($sikap_pred == "-"))
				{
					$sheet->getStyle($sikap_pred_cel)->applyFromArray($styleArray);
				}
				$sheet->setCellValue($mid_sikap_pred_cel, $mid_sikap_pred);
				$sheet->setCellValue($sikap_pred_cel, $sikap_pred);
				$sheet->setCellValue($sikap_cat_cel, $sikap_cat);

			endforeach;

			// jumlah & rerata nilai
			
			$rumus_list = array(
				/////// MID ////////
				"K{$row_no}" => str_replace("{row}", $row_no, $rumus_jml_mid_teori),
				"L{$row_no}" => str_replace("{row}", $row_no, $rumus_jml_mid_praktek),
				"I{$row_no}" => str_replace("{row}", $row_no, $rumus_rt2_mid_teori),
				"J{$row_no}" => str_replace("{row}", $row_no, $rumus_rt2_mid_praktek),
				"G{$row_no}" => str_replace("{row}", $row_no, $rumus_mid_rank),
			
				/////// AKHIR //////////
				"R{$row_no}" => str_replace("{row}", $row_no, $rumus_jml_teori),
				"S{$row_no}" => str_replace("{row}", $row_no, $rumus_jml_praktek),
				"P{$row_no}" => str_replace("{row}", $row_no, $rumus_rt2_teori),
				"Q{$row_no}" => str_replace("{row}", $row_no, $rumus_rt2_praktek),
				"N{$row_no}" => str_replace("{row}", $row_no, $rumus_rank),
			);

			foreach ($rumus_list as $cll => $rms)
				$sheet->setCellValue($cll, $rms);

			//continue;
			// bagian ekskul

			if (isset($nisis['nisixk_array']))
			{
				$i_xk = 0;

				foreach ($nisis['nisixk_array'] as $nisixk)
				{
					$i_xk++;

					if ($i_xk > 3)
						break;

					$_cell_nama = "{$d['xk_array'][$i_xk]['excol_nama']}{$row_no}";
					$_cell_predikat = "{$d['xk_array'][$i_xk]['excol_predikat']}{$row_no}";
					$_cell_desc = "{$d['xk_array'][$i_xk]['excol_desc']}{$row_no}";

					$sheet->setCellValue($_cell_nama, $nisixk['ekskul_nama']);
					$nisixk['nilai'] = strtoupper($nisixk['nilai']);
					$sheet->setCellValue($_cell_predikat, $nisixk['nilai']);
					///////////// PERBAIKAN NILAI EKSKUL ///////////
					if (strpos($nisixk['nilai'], 'A') !== false)
					{
						$nisixk['keterangan'] = 'Sangat Baik';
					}
					elseif (strpos($nisixk['nilai'], 'B') !== false)
					{
						$nisixk['keterangan'] = 'Baik';
					}
					else
					{
						$nisixk['keterangan'] = 'Kurang';
					}

					$sheet->setCellValue($_cell_desc, $nisixk['keterangan']);
				}
			}

			// bagian organisasi

			if (isset($nisis['nisiorg_array']))
			{
				$i_org = 0;

				foreach ($nisis['nisiorg_array'] as $nisiorg)
				{
					$i_org++;

					if ($i_org > 3)
						break;

					$_cell_nama = "{$d['org_array'][$i_org]['excol_nama']}{$row_no}";
					$_cell_desc = "{$d['org_array'][$i_org]['excol_desc']}{$row_no}";

					$sheet->setCellValue($_cell_nama, $nisiorg['org_nama']);
					$sheet->setCellValue($_cell_desc, $nisiorg['keterangan']);
				}
			}



		endforeach;

		// perumusan rangking alternatif
		 /
		  for ($i = $row_start; $i <= $row_end; $i++) {
		  $cll = "G{$i}";
		  $rumus_rank = "=IF(ISNUMBER(I{$i}),RANK(I{$i},I{$row_start}:I{$row_end},0),\"\")";
		  $sheet->setCellValue($cll, $rumus_rank);
		  }
		   */
/*
		$getHighestColumn = $sheet->getHighestColumn();
		$row_first = $excel_row_offset + 1;
		$row_last = $row_no;

		// formating

		foreach ($cfg['col.width'] as $col => $wid)
			$sheet->getColumnDimension($col)->setWidth($wid);

		$sheet->getStyle("A{$row_first}:{$getHighestColumn}{$row_last}")->applyFromArray($style['umum']);
		$sheet->getStyle("A5:{$getHighestColumn}7")->applyFromArray($style['tengah']);
		$sheet->freezePane("C{$row_first}");

		// output

		return excel_output_2007($excel_obj, "leger_{$d['row']['kelas_nama']}.xlsx");

	}*/
	function leger_excel($id,$mode='UTS',$original = 0)
	{
		$this->leger_core($id,$mode,$original,0);
	}
	
	function leger_pararel($id,$mode='UTS',$original = 0)
	{
		$this->leger_core($id,$mode,$original,1);
	}
	
	function leger_core($id,$mode='UTS',$original = 0,$parallel=0)
	{
		if($parallel==0)
		{
			$this->leger($id);
			$this->leger_exkul();
			$this->leger_org();
		}else{
			$this->leger2($id);  
			$this->leger_exkul();
			$this->leger_org();
		}
		if($original == 0)
		{	$kkm = 2.67;	}
		elseif($original == 1)
		{	$kkm = 75;	}

		$d = & $this->ci->d;
		$deskripsi_nilai		= $this->m_nilai_siswa->deskripsi_nilai($d['row']['semester_id']);
		$deskripsi_pelajaran	= $this->m_nilai_siswa->deskripsi_pelajaran($d['row']['semester_id']);

		if ($d['error'])
			return redir("nilai/kelas/{$id}");

		$this->load->library('konversi_nilai');
		$this->load->helper('excel');
		excel_load();

		$styleArray = array(
			'fill' => array(
				'type'	 => PHPExcel_Style_Fill::FILL_SOLID,
				'color'	 => array('rgb' => 'DD9898'),
			)
		);
		// deklarasi variabel

		if (TRUE):
			$excel_row_offset = 8;
			//$excel_col_offset = ord('T') - 65;
			$excel_col_offset = ord('V') - 65;
			$style = array(
				'umum' => array(
					'borders'	 => array(
						'allborders' => array(
							'style' => PHPExcel_Style_Border::BORDER_THIN,
						),
					),
					'font'		 => array(
						'size' => 10,
					),
				),
			);
			$style['tengah'] = $style['umum'];
			$style['tengah']['alignment']['horizontal'] = PHPExcel_Style_Alignment::HORIZONTAL_CENTER;
			$style['tengah']['alignment']['vertical'] = PHPExcel_Style_Alignment::VERTICAL_CENTER;
			$style['tengah']['borders']['allborders']['style'] = PHPExcel_Style_Border::BORDER_MEDIUM;
			$style['tengah']['font']['bold'] = TRUE;


			
			
			$cfg = array(
				'row.nikls'		 => array(
					// top header
					'A1' => array(
						'semester_nama',
						'strtoupper',
						'prefix' => 'LEGER SEMESTER ',
						'suffix' => array(
							' TAHUN ',
							'ta_nama',
						),
					),
					// baris 1
					'A5' => 'No',
					'B5' => 'Nama Siswa',
					/*'C5' => 'NIS'.$this->getNameFromNumber(5),*/
					'C5' => 'NIS',
					'D5' => 'KELAS',
					'E5' => 'Presensi',
					
					
					'H5' => 'MID Rank',
					'I5' => 'MID Rata2',
					'K5' => 'MID Jumlah',
					
					'N5' => 'AKHIR Rank',
					'P5' => 'AKHIR Rata2',
					'R5' => 'AKHIR Jumlah',
					
					'M5' => 'AGAMA',
					
					'T5' => 'Sikap Spiritual',
					'U5' => 'Sikap Sosial',
					
					// baris 2
					'E7' => 'S',
					'F7' => 'I',
					'G7' => 'A',
					'I7' => 'Peng',
					'J7' => 'Ketr',
					'K7' => 'Peng',
					'L7' => 'Ketr',
					
					'P7' => 'Peng',
					'Q7' => 'Ketr',
					'R7' => 'Peng',
					'S7' => 'Ketr',
					
					// BARIS 3
					'A8' => 'K K M',
				),
				'merge_cells'	 => array(
					'A5:A7', // no
					'B5:B7', // nama
					'C5:C7', // nis
					'D5:D7', // kelas
					'E5:G6', // presensi
					'H5:H7', // rank
					'I5:J6', // mid rata2
					'K5:L6', // mid jml
					
					'N5:N7', // rank
					'O5:O7', // spasi
					'P5:Q6', // akhir rata2
					'R5:S6', // akhir jml
					'T5:T7', // spasi
					
					'M5:M7', // spasi
					
					'T5:T7', // s.spiritual
					'U5:U7', // s.sosial
					
					'A7:B7', // kkm
					'C8:S8', // kkm
				),
				'table.nisis'	 => array(
					'B'	 => 'siswa_nama',
					'C'	 => 'siswa_nis',
					'D'	 => 'kelas_nama',
					'E'	 => 'absen_s',
					'F'	 => 'absen_i',
					'G'	 => 'absen_a',
					
					'M'	 => 'agama_nama',
					//'' => '___',
					/*'I'	 => 'mid_teori',
					'J'	 => 'mid_praktek',
					*/
					'P'	 => 'nas_teori',
					'Q'	 => 'nas_praktek',
					
				),
				'col.width'		 => array(
					'A'	 => 3,
					'B'	 => 25,
					'C'	 => 8,
					'D'	 => 8,
					'E'	 => 4,
					'F'	 => 4,
					'G'	 => 4,
					'H'	 => 6,
					'I'	 => 5,
					'J'	 => 5,
					'K'	 => 6,
					'L'	 => 6,
					'M'	 => 8,
					
					'N'	 => 6,
					'O'	 => 1,
					'P'	 => 5,
					'Q'	 => 5,
					'R'	 => 6,
					'S'	 => 6,
					
					'T'	 => 8,
					'U'	 => 8,
					
					'V'	 => 1,
				),
			);
		endif;
		
		if($parallel==0)
		{
			$cfg['row.nikls']['A2']=array('kelas_nama', 'strtoupper');
			$cfg['row.nikls']['A3']=array('kelas_wali_nama','prefix' => 'Wali Kelas: ');
		}else{
			$cfg['row.nikls']['A2']=array('kelas_grade', 'prefix' => 'Kelas Angkatan: ');
			$cfg['row.nikls']['A3']=array('jurusan_nama', 'prefix' => 'Jurusan: ');
		}
		// mulai buka excel

		$excel_obj = new PHPExcel();
		$sheet = $excel_obj->getActiveSheet();
		$row_no = $excel_row_offset;
		$col_no = $excel_col_offset;
		$no = 0;
		$col_teori = array();
		$col_prektek = array();
		$col_mid_teori = array();
		$col_mid_prektek = array();

		// buat header

		excel_mergecells($sheet, $cfg['merge_cells']);
		$sheet->getStyle('A5:V7')->getAlignment()->setWrapText(true); 
		excel_row_write($sheet, $d['row'], $cfg['row.nikls']);

		// ascii 65 = A (kapital)
		// kolom A = nomor 1
		//
		// bagian header pelajaran
		
		// HIDDEN
		if($mode=='UAS')
		{
			//MID RANG
			$sheet->getColumnDimension('H')->setVisible(FALSE);
			
			$sheet->getColumnDimension('I')->setVisible(FALSE);
			$sheet->getColumnDimension('J')->setVisible(FALSE);
			$sheet->getColumnDimension('K')->setVisible(FALSE);
			$sheet->getColumnDimension('L')->setVisible(FALSE);
		}
		
		if($mode=='UTS')
		{
			//MID RANG
			$sheet->getColumnDimension('N')->setVisible(FALSE);
			
			$sheet->getColumnDimension('P')->setVisible(FALSE);
			$sheet->getColumnDimension('Q')->setVisible(FALSE);
			$sheet->getColumnDimension('R')->setVisible(FALSE);
			$sheet->getColumnDimension('S')->setVisible(FALSE);
		}
		
		foreach ($d['pelajaran_array'] as &$p3lajaran):

			$p3lajaran['teori'] = TRUE;
			$p3lajaran['praktek'] = TRUE;

			// nilai default

			$p3lajaran['excol']['midteori'] = NULL;
			$p3lajaran['excol']['midpraktek'] = NULL;
			
			$p3lajaran['excol']['teori'] = NULL;
			$p3lajaran['excol']['praktek'] = NULL;
			
			////////// MID /////////////////
			// kognitif
			if ($p3lajaran['teori'] == 1)
			{
				$p3lajaran['excol']['midteori'] = excel_colnumber(++$col_no);
				$col_mid_teori[] = $p3lajaran['excol']['midteori'];
			}
			// psikomotorik
			if ($p3lajaran['praktek'] == 1)
			{
				$p3lajaran['excol']['midpraktek'] = excel_colnumber(++$col_no);
				$col_mid_prektek[] = $p3lajaran['excol']['midpraktek'];
			}
			// afektif
			$p3lajaran['excol']['midsikap_predikat'] = excel_colnumber(++$col_no);
			
			////////// AKHIR /////////////////
			// kognitif
			if ($p3lajaran['teori'] == 1)
			{
				$p3lajaran['excol']['teori'] = excel_colnumber(++$col_no);
				$col_teori[] = $p3lajaran['excol']['teori'];
			}
			// psikomotorik
			if ($p3lajaran['praktek'] == 1)
			{
				$p3lajaran['excol']['praktek'] = excel_colnumber(++$col_no);
				$col_prektek[] = $p3lajaran['excol']['praktek'];
			}
			// afektif
			$p3lajaran['excol']['sikap_predikat'] = excel_colnumber(++$col_no);
			
			// head baris 1, nama mapel
			$cell = (($p3lajaran['teori'] == 1 ) ? $p3lajaran['excol']['midteori'] : $p3lajaran['excol']['midpraktek']) . '5';
			$cell_merge = $cell . ':' . ($p3lajaran['excol']['sikap_predikat']) . '5';

			//$sheet->setCellValue($cell, strtoupper($p3lajaran['mapel_nama']));
			$title_kategori = '';
			if(strpos(strtoupper($p3lajaran['kategori_nama']),"WAJIB") !== false)
				$title_kategori = '(wajib)';	
			if(strpos(strtoupper($p3lajaran['kategori_nama']),"PEMINATAN") !== false)
				$title_kategori = '(peminatan)';
			if(strpos(strtoupper($p3lajaran['kategori_nama']),"LINTAS") !== false)
				$title_kategori = '(l. minat)';
			
			$sheet->setCellValue($cell, strtoupper($p3lajaran['mapel_kode']." ".$title_kategori));
			$sheet->mergeCells($cell_merge);

			// head baris 2 & 3, kategori nilai
			////////// MID //////////////////////
			//		kognitif
			if ($p3lajaran['teori'] == 1)
			{
				$cell_teori_label = "{$p3lajaran['excol']['midteori']}6";
				$cell_teori_nilai = $p3lajaran['excol']['midteori'] . '7';
				
				$sheet->setCellValue($cell_teori_label, "MID");
				$sheet->setCellValue($cell_teori_nilai, "Peng");
				$sheet->getColumnDimension($p3lajaran['excol']['midteori'])->setWidth(5);
				// HIDDEN
				if($mode=='UAS')
				{
					/*$sheet->getColumnDimension('I')->setVisible(FALSE);
					$sheet->getColumnDimension('J')->setVisible(FALSE);
					$sheet->getColumnDimension('K')->setVisible(FALSE);
					$sheet->getColumnDimension('L')->setVisible(FALSE);*/
					$sheet->getColumnDimension($p3lajaran['excol']['midteori'])->setVisible(FALSE);
				}
			}
			//		Psikomotorik
			if ($p3lajaran['praktek'] == 1)
			{
				$cell_praktek_nilai = $p3lajaran['excol']['midpraktek'] . '7';

				$sheet->setCellValue($cell_praktek_nilai, "Ketr");
				$sheet->getColumnDimension($p3lajaran['excol']['midpraktek'])->setWidth(5);
				// HIDDEN
				if($mode=='UAS')
				{
					$sheet->getColumnDimension($p3lajaran['excol']['midpraktek'])->setVisible(FALSE);
				}
			}
			//		Afektif
			$cell_sikap_konv = $p3lajaran['excol']['midsikap_predikat'] . '7';

			$sheet->setCellValue($cell_sikap_konv, "Sikap");
			$sheet->getColumnDimension($p3lajaran['excol']['midsikap_predikat'])->setWidth(4);
			// HIDDEN
			if($mode=='UAS')
			{
				$sheet->getColumnDimension($p3lajaran['excol']['midsikap_predikat'])->setVisible(FALSE);
			}
			
			$cell_merge = $p3lajaran['excol']['midteori'] . '6' . ':' . $p3lajaran['excol']['midsikap_predikat'] . '6';
			$sheet->mergeCells($cell_merge);
			
			
			////////// AKHIR //////////////////////
			//		kognitif
			if ($p3lajaran['teori'] == 1)
			{
				$cell_teori_label = "{$p3lajaran['excol']['teori']}6";
				$cell_teori_nilai = $p3lajaran['excol']['teori'] . '7';
				
				//$sheet->setCellValue($cell_teori_label, "Peng");
				$sheet->setCellValue($cell_teori_label, "AKHIR");
				//$sheet->setCellValue($cell_teori_nilai, "nilai");
				$sheet->setCellValue($cell_teori_nilai, "Peng");
				$sheet->getColumnDimension($p3lajaran['excol']['teori'])->setWidth(5);
				// HIDDEN
				if($mode=='UTS')
				{
					/*$sheet->getColumnDimension('P')->setVisible(FALSE);
					$sheet->getColumnDimension('Q')->setVisible(FALSE);
					$sheet->getColumnDimension('R')->setVisible(FALSE);
					$sheet->getColumnDimension('S')->setVisible(FALSE);*/
					$sheet->getColumnDimension($p3lajaran['excol']['teori'])->setVisible(FALSE);
					
					$sheet->getColumnDimension('N')->setVisible(FALSE);
				}
			}
			//		Psikomotorik
			if ($p3lajaran['praktek'] == 1)
			{
				$cell_praktek_label = "{$p3lajaran['excol']['praktek']}6";
				$cell_praktek_nilai = $p3lajaran['excol']['praktek'] . '7';

				//$sheet->setCellValue($cell_praktek_label, "Ketr");
				//$sheet->setCellValue($cell_praktek_nilai, "nilai");
				$sheet->setCellValue($cell_praktek_nilai, "Ketr");
				$sheet->getColumnDimension($p3lajaran['excol']['praktek'])->setWidth(5);
				// HIDDEN
				if($mode=='UTS')
				{
					$sheet->getColumnDimension($p3lajaran['excol']['praktek'])->setVisible(FALSE);
				}
			}
			//		Afektif
			$cell_sikap_label = "{$p3lajaran['excol']['sikap_predikat']}6";
			//$cell_sikap_nilai = $p3lajaran['excol']['sikap_predikat'] . '7';
			$cell_sikap_konv = $p3lajaran['excol']['sikap_predikat'] . '7';
			// HIDDEN
			//if($mode=='UTS')
			if(APP_SUBDOMAIN != 'smaterbang.fresto.co')
			{
				$sheet->getColumnDimension($p3lajaran['excol']['sikap_predikat'])->setVisible(FALSE);
			}
			//$sheet->setCellValue($cell_sikap_label, "Sikap");
			//$sheet->setCellValue($cell_sikap_nilai, "nilai");
			//$sheet->setCellValue($cell_sikap_konv, "pred");
			$sheet->setCellValue($cell_sikap_konv, "Sikap");
			$sheet->getColumnDimension($p3lajaran['excol']['sikap_predikat'])->setWidth(4);
			
			$cell_merge = $p3lajaran['excol']['teori'] . '6:' . $p3lajaran['excol']['sikap_predikat'] . '6';
			$sheet->mergeCells($cell_merge);
			
			// head baris 4, KKM
			$cell = (($p3lajaran['teori'] == 1 ) ? $p3lajaran['excol']['midteori'] : $p3lajaran['excol']['praktek']) . '8';
			$cell_merge = $cell . ':' . $p3lajaran['excol']['sikap_predikat'] . '8';

			// KKM ASLI
			$kkm = $p3lajaran['kkm'];
			$mapel_kkm[$p3lajaran['kategori_id']][$p3lajaran['mapel_id']] = $p3lajaran['kkm'];
			$sheet->setCellValue($cell, $kkm);
			$sheet->mergeCells($cell_merge);

		endforeach;

		// template rumus jumlah & rata2 nilai
		/////////// MID ///////////////////
		$range_mid_teori = NULL;
		$range_mid_praktek = NULL;
		$rangelist_mid_teori = array();
		$rangelist_mid_praktek = array();

		foreach ($col_mid_teori as $c_m_t)
		{
			$rangelist_mid_teori[] = "{$c_m_t}{row}";
		}

		foreach ($col_mid_prektek as $c_m_p)
		{
			$rangelist_mid_praktek[] = "{$c_m_p}{row}";
		}

		if (!empty($rangelist_mid_teori))
			$range_mid_teori = implode(",", $rangelist_mid_teori);

		if (!empty($rangelist_mid_praktek))
			$range_mid_praktek = implode(",", $rangelist_mid_praktek);

		$rumus_jml_mid_teori = "=IF(COUNT({$range_mid_teori})>0, SUM({$range_mid_teori}))";
		$rumus_jml_mid_praktek = "=IF(COUNT({$range_mid_praktek})>0, SUM({$range_mid_praktek}))";
		$rumus_rt2_mid_teori = "=IF(COUNT({$range_mid_teori})>0, AVERAGE({$range_mid_teori}))";
		$rumus_rt2_mid_praktek = "=IF(COUNT({$range_mid_praktek})>0, AVERAGE({$range_mid_praktek}))";
		
		/////////// AKHIR ///////////////////
		$range_teori = NULL;
		$range_praktek = NULL;
		$rangelist_teori = array();
		$rangelist_praktek = array();

		foreach ($col_teori as $c_t)
		{
			$rangelist_teori[] = "{$c_t}{row}";
		}

		foreach ($col_prektek as $c_p)
		{
			$rangelist_praktek[] = "{$c_p}{row}";
		}

		if (!empty($rangelist_teori))
			$range_teori = implode(",", $rangelist_teori);

		if (!empty($rangelist_praktek))
			$range_praktek = implode(",", $rangelist_praktek);

		$rumus_jml_teori = "=IF(COUNT({$range_teori})>0, SUM({$range_teori}))";
		$rumus_jml_praktek = "=IF(COUNT({$range_praktek})>0, SUM({$range_praktek}))";
		$rumus_rt2_teori = "=IF(COUNT({$range_teori})>0, AVERAGE({$range_teori}))";
		$rumus_rt2_praktek = "=IF(COUNT({$range_praktek})>0, AVERAGE({$range_praktek}))";


		// rumus rangking
		$jml_siswa = count($d['leger']);
		$row_start = $row_no + 1;
		$row_end = $row_no + $jml_siswa;
		/// MID /////
		$rumus_mid_rank = "=IF(ISNUMBER(I{row}),RANK(I{row},I{$row_start}:I{$row_end},0),\"\")";
		
		/// AKHIR /////
		$rumus_rank = "=IF(ISNUMBER(P{row}),RANK(P{row},P{$row_start}:P{$row_end},0),\"\")";
		/* /
		  $rumus_rank = "=RANK(I{row},I{$row_start}:I{$row_end},0)";
		  =RANK(J34,J34:J37,0)
		  // */

		// spasi bagian

		$space_col = excel_colnumber(++$col_no);
		$space_range = "{$space_col}5:{$space_col}7";

		$sheet->mergeCells($space_range);
		$sheet->getColumnDimension($space_col)->setWidth(1);

		//* /
		//
		  // header tiap ekskul

		for ($i_xk = 1; $i_xk <= 4; $i_xk++)
		{
			$_xk['excol_nama'] = excel_colnumber(++$col_no);
			$_xk['excol_predikat'] = excel_colnumber(++$col_no);
			$_xk['excol_desc'] = excel_colnumber(++$col_no);
			$d['xk_array'][$i_xk] = $_xk;

			$sheet->setCellValue("{$_xk['excol_nama']}6", "Ekstrakurikuler {$i_xk}");
			$sheet->setCellValue("{$_xk['excol_nama']}7", "Nama");
			$sheet->setCellValue("{$_xk['excol_predikat']}7", "Predikat");
			$sheet->setCellValue("{$_xk['excol_desc']}7", "Deskripsi");
			$sheet->getColumnDimension($_xk['excol_nama'])->setWidth(10);
			$sheet->getColumnDimension($_xk['excol_predikat'])->setWidth(10);
			$sheet->getColumnDimension($_xk['excol_desc'])->setWidth(20);
			$sheet->mergeCells("{$_xk['excol_nama']}6:{$_xk['excol_desc']}6");
		}

		//* /
		// header bagian ekskul

		$_cell = "{$d['xk_array'][1]['excol_nama']}5";
		$_range = "{$d['xk_array'][1]['excol_nama']}5:{$d['xk_array'][3]['excol_desc']}5";

		$sheet->setCellValue($_cell, "Keterangan Ekstrakurikuler");
		$sheet->mergeCells($_range);

		//* /
		//
		  // spasi bagian

		$space_col = excel_colnumber(++$col_no);
		$space_range = "{$space_col}5:{$space_col}7";

		$sheet->mergeCells($space_range);
		$sheet->getColumnDimension($space_col)->setWidth(1);

		// * /
		//
		  // header tiap organisasi

		for ($i_org = 1; $i_org <= 3; $i_org++)
		{
			$_org['excol_nama'] = excel_colnumber(++$col_no);
			$_org['excol_desc'] = excel_colnumber(++$col_no);
			$d['org_array'][$i_org] = $_org;

			$sheet->setCellValue("{$_org['excol_nama']}6", "Organisasi {$i_org}");
			$sheet->setCellValue("{$_org['excol_nama']}7", "Nama");
			$sheet->setCellValue("{$_org['excol_desc']}7", "Deskripsi");
			$sheet->getColumnDimension($_org['excol_nama'])->setWidth(10);
			$sheet->getColumnDimension($_org['excol_desc'])->setWidth(20);
			$sheet->mergeCells("{$_org['excol_nama']}6:{$_org['excol_desc']}6");
		}

		// header bagian organisasi

		$_cell = "{$d['org_array'][1]['excol_nama']}5";
		$_range = "{$d['org_array'][1]['excol_nama']}5:{$d['org_array'][3]['excol_desc']}5";

		$sheet->setCellValue($_cell, "Keterangan Organisasi");
		$sheet->mergeCells($_range);

		// spasi bagian

		$space_col = excel_colnumber(++$col_no);
		$space_range = "{$space_col}5:{$space_col}7";
		$deskripsi_topleft = $col_no + 1;

		$sheet->mergeCells($space_range);
		$sheet->getColumnDimension($space_col)->setWidth(1);

		// bagian deskripsi pelajaran

		foreach ($d['pelajaran_array'] as &$p3lajaran_2):

			// nilai default

			$p3lajaran_2['excol']['teori_desc'] = NULL;
			$p3lajaran_2['excol']['praktek_desc'] = NULL;

			// kognitif

			if ($p3lajaran_2['teori'] == 1)
			{
				$p3lajaran_2['excol']['teori_desc'] = excel_colnumber(++$col_no);
			}

			// psikomotorik

			if ($p3lajaran_2['praktek'] == 1)
			{
				$p3lajaran_2['excol']['praktek_desc'] = excel_colnumber(++$col_no);
			}

			// afektif

			$p3lajaran_2['excol']['sikap_desc'] = excel_colnumber(++$col_no);

			// head baris 2, nama mapel

			$cell = (($p3lajaran_2['teori'] == 1) ? $p3lajaran_2['excol']['teori_desc'] : $p3lajaran_2['excol']['praktek_desc']) . '6';
			$cell_merge = $cell . ':' . ($p3lajaran_2['excol']['sikap_desc']) . '6';

			$sheet->mergeCells($cell_merge);
			$sheet->setCellValue($cell, strtoupper($p3lajaran_2['mapel_nama']));

			// head baris 3, kategori nilai
			//
			//		kognitif

			if ($p3lajaran_2['teori'] == 1)
			{
				$cell_teori = $p3lajaran_2['excol']['teori_desc'] . '7';
				$sheet->setCellValue($cell_teori, "Peng");
			}

			//		Psikomotorik

			if ($p3lajaran_2['praktek'] == 1)
			{
				$cell_praktek = $p3lajaran_2['excol']['praktek_desc'] . '7';
				$sheet->setCellValue($cell_praktek, "Ketr");
			}

			//		Afektif

			$cell_sikap = $p3lajaran_2['excol']['sikap_desc'] . '7';

			$sheet->setCellValue($cell_sikap, "Sikap");

		endforeach;

		// header deskripsi baris 1

		$_cell = excel_colnumber($deskripsi_topleft) . "5";
		$_range = "{$_cell}:{$p3lajaran_2['excol']['sikap_desc']}5";

		$sheet->mergeCells($_range);
		$sheet->setCellValue($_cell, "Keterangan / Deskripsi Pelajaran");

		// */
		//
		// isi data nilai siswa

		foreach ($d['leger'] as $nisis):
			$row_no++;
			$no++;

			$cell = 'A' . $row_no;
			$sheet->setCellValue($cell, $no);
			
			/// Cek OJK
			$ojk_exists = 0;
			if(array_key_exists("pkl_nama",$nisis)){
				$ojk_exists = 1;
			}
			
			// nilai siswa

			foreach ($cfg['table.nisis'] as $col_excel => $col_db):
				$cell = $col_excel . $row_no;
				$sheet->setCellValue($cell, $nisis[$col_db]);

			endforeach;

			// sikap spiritual sosial
			if(isset($nisis['predikat_sikap']))
			{
				//$deskripsi_sikap = (array) json_decode($nisis['deskripsi_sikap'], TRUE);
				$predikat_sikap = (array) json_decode($nisis['predikat_sikap'], TRUE);
			}else{
				$deskripsi_sikap = '';
				$predikat_sikap = '';
			}
			
			if(isset($predikat_sikap['spiritual']))
			{
				if($predikat_sikap['spiritual']==''){
					$predikat_sikap['spiritual']='-';
				}
				$sheet->setCellValue('T'.$row_no, $predikat_sikap['spiritual']);
			}
			
			if(isset($predikat_sikap['sosial']))
			{
				if($predikat_sikap['sosial']==''){
					$predikat_sikap['sosial']='-';
				}
				$sheet->setCellValue('U'.$row_no, $predikat_sikap['sosial']);
			}
			
			// detail nilai pelajaran

			foreach ($d['pelajaran_array'] as $pelajaran_id => $pelajaran):

				$pelajaran['teori'] = TRUE;
				$pelajaran['praktek'] = TRUE;
				$kategori_id = $pelajaran['kategori_id'];
				$mapel_id	 = $pelajaran['mapel_id'];
				$kkm		 = $mapel_kkm[$kategori_id][$mapel_id];
				// statusikut pelajaran tsb tidaknya
				
				$ikut_belajar = false;
				if(isset($nisis['nisispel_array'])){
					
				$ikut_belajar = array_key_exists($kategori_id, $nisis['nisispel_array']);
				if ($ikut_belajar)
					$ikut_belajar = array_key_exists($mapel_id, $nisis['nisispel_array'][$kategori_id]);

				}
				// teori
				
// echo "<br>--".$ikut_belajar."==<br>";
// echo "<pre>";
// print_r($nisis);
// echo "</pre>";
				if ($pelajaran['teori'] == 1)
				{
					$teori_mid = "-";
					$teori_nas = "-";

					//$teori_konv = "-";
					//$teori_cat = "-";
					
					$teori_mid_cel = $pelajaran['excol']['midteori'] . $row_no;
					$teori_nas_cel = $pelajaran['excol']['teori'] . $row_no;
					//$teori_konv_cel = $pelajaran['excol']['teori_konversi'] . $row_no;
					$teori_cat_cel = $pelajaran['excol']['teori_desc'] . $row_no;

					if ($ikut_belajar)
					{
						//echo $kategori_id." ".$mapel_id." a ";
						$teori_mid = $nisis['nisispel_array'][$kategori_id][$mapel_id]['mid_teori'];
						$teori_nas = $nisis['nisispel_array'][$kategori_id][$mapel_id]['nas_teori'];
						$teori_cat = $nisis['nisispel_array'][$kategori_id][$mapel_id]['cat_teori'];
						
						if($teori_cat == "")
						{	$teori_cat = $nisis['nisispel_array'][$kategori_id][$mapel_id]['kompetensi'];	}

							foreach ($deskripsi_pelajaran['data'] as $deskripsi)
							{
								if (($deskripsi['mapel_id'] == $nisis['nisispel_array'][$kategori_id][$mapel_id]['mapel_id']) && 
								($deskripsi['kategori_id'] == $nisis['nisispel_array'][$kategori_id][$mapel_id]['kategori_id']) && 
								($deskripsi['grade'] == $nisis['kelas_grade']) && ($deskripsi['aspek_penilaian_id'] == 1) )
								{
									if(	( $nisis['nisispel_array'][$kategori_id][$mapel_id]['pred_teori']=='A' && $deskripsi['kode']==1 )||
										( $nisis['nisispel_array'][$kategori_id][$mapel_id]['pred_teori']=='B' && $deskripsi['kode']==2 )||
										( $nisis['nisispel_array'][$kategori_id][$mapel_id]['pred_teori']=='C' && $deskripsi['kode']==3 )||
										( $nisis['nisispel_array'][$kategori_id][$mapel_id]['pred_teori']=='D' && $deskripsi['kode']==4 )	)
									{							
										if ((($deskripsi['agama_id'] != 0) && 
										($deskripsi['agama_id'] == $nisis['nisispel_array'][$kategori_id][$mapel_id]['agama_id'])) || 
										($deskripsi['agama_id'] == 0))
										{
											$teori_cat = $deskripsi['deskripsi'];
										}
									}
								}
							}
							
							
					}

					if ($teori_mid < $kkm)
					{
						$sheet->getStyle($teori_mid_cel)->applyFromArray($styleArray);
					}
					if ($teori_nas < $kkm)
					{
						$sheet->getStyle($teori_nas_cel)->applyFromArray($styleArray);
					}
					$sheet->setCellValue($teori_mid_cel, $teori_mid);
					$sheet->setCellValue($teori_nas_cel, $teori_nas);
					//$sheet->setCellValue($teori_konv_cel, $teori_konv);
					if(isset($teori_cat))
					{
						$sheet->setCellValue($teori_cat_cel, $teori_cat);
					}
				}

				// praktek

				if ($pelajaran['praktek'] == 1 or TRUE)
				{
					$praktek_mid = "-";
					$praktek_nas = "-";
					//$praktek_konv = "-";
					//$praktek_cat = "-";
					
					$praktek_mid_cel = $pelajaran['excol']['midpraktek'] . $row_no;
					$praktek_nas_cel = $pelajaran['excol']['praktek'] . $row_no;
					//$praktek_konv_cel = $pelajaran['excol']['praktek_konversi'] . $row_no;
					$praktek_cat_cel = $pelajaran['excol']['praktek_desc'] . $row_no;

					if ($ikut_belajar)
					{
						$praktek_mid = $nisis['nisispel_array'][$kategori_id][$mapel_id]['mid_praktek'];
						$praktek_nas = $nisis['nisispel_array'][$kategori_id][$mapel_id]['nas_praktek'];
						$praktek_cat = $nisis['nisispel_array'][$kategori_id][$mapel_id]['cat_praktek'];
						
							foreach ($deskripsi_pelajaran['data'] as $deskripsi)
							{
								if (($deskripsi['mapel_id'] == $nisis['nisispel_array'][$kategori_id][$mapel_id]['mapel_id']) && 
								($deskripsi['kategori_id'] == $nisis['nisispel_array'][$kategori_id][$mapel_id]['kategori_id']) && 
								($deskripsi['grade'] == $nisis['kelas_grade']) && ($deskripsi['aspek_penilaian_id'] == 2) )
								{
									if(	( $nisis['nisispel_array'][$kategori_id][$mapel_id]['pred_praktek']=='A' && $deskripsi['kode']==1 )||
										( $nisis['nisispel_array'][$kategori_id][$mapel_id]['pred_praktek']=='B' && $deskripsi['kode']==2 )||
										( $nisis['nisispel_array'][$kategori_id][$mapel_id]['pred_praktek']=='C' && $deskripsi['kode']==3 )||
										( $nisis['nisispel_array'][$kategori_id][$mapel_id]['pred_praktek']=='D' && $deskripsi['kode']==4 )	)
									{
										if ((($deskripsi['agama_id'] != 0) && 
										($deskripsi['agama_id'] == $nisis['nisispel_array'][$kategori_id][$mapel_id]['agama_id'])) || 
										($deskripsi['agama_id'] == 0))
										{
											$praktek_cat = $deskripsi['deskripsi'];
										}
									}
								}
							}
					}
					
					if ($praktek_mid < $kkm)
					{
						$sheet->getStyle($praktek_mid_cel)->applyFromArray($styleArray);
					}
					if ($praktek_nas < $kkm)
					{
						$sheet->getStyle($praktek_nas_cel)->applyFromArray($styleArray);
					}
					$sheet->setCellValue($praktek_mid_cel, $praktek_mid);
					$sheet->setCellValue($praktek_nas_cel, $praktek_nas);
					//$sheet->setCellValue($praktek_konv_cel, $praktek_konv);
					if(isset($praktek_cat))
					{
						$sheet->setCellValue($praktek_cat_cel, $praktek_cat);
					}
				}

				// sikap
				//$sikap_nas = "-";
				$mid_sikap_pred = "-";
				$sikap_pred = "-";
				$sikap_cat = "-";
				//$sikap_nas_cel = $pelajaran['excol']['sikap'] . $row_no;
				
				$mid_sikap_pred_cel = $pelajaran['excol']['midsikap_predikat'] . $row_no;
				$sikap_pred_cel = $pelajaran['excol']['sikap_predikat'] . $row_no;
				$sikap_cat_cel = $pelajaran['excol']['sikap_desc'] . $row_no;

				if ($ikut_belajar)
				{
					
						$mid_sikap_pred = $nisis['nisispel_array'][$kategori_id][$mapel_id]['mid_pred_sikap'];
						//$sikap_pred = $nisis['nisispel_array'][$kategori_id][$mapel_id]['pred_sikap'];
						if($nisis['nisispel_array'][$kategori_id][$mapel_id]['pred_sikap']!='')
						{	$sikap_pred = $nisis['nisispel_array'][$kategori_id][$mapel_id]['pred_sikap'];	}
						else
						{	$sikap_pred = $nisis['nisispel_array'][$kategori_id][$mapel_id]['nas_sikap'];	}
					
				}

				//$sheet->setCellValue($sikap_nas_cel, $sikap_nas);
				if (($mid_sikap_pred == 'C') || ($mid_sikap_pred == 'D') || ($mid_sikap_pred == 'E') || ($mid_sikap_pred == 'K') || ($mid_sikap_pred == "-"))
				{
					$sheet->getStyle($mid_sikap_pred_cel)->applyFromArray($styleArray);
				}
				if (($sikap_pred == 'C') || ($sikap_pred == 'D') || ($sikap_pred == 'E') || ($sikap_pred == 'K') || ($sikap_pred == "-"))
				{
					$sheet->getStyle($sikap_pred_cel)->applyFromArray($styleArray);
				}
				if($mid_sikap_pred==''){
					$sheet->setCellValue($mid_sikap_pred_cel, $sikap_pred);
				}else{
					$sheet->setCellValue($mid_sikap_pred_cel, $mid_sikap_pred);
				}
				$sheet->setCellValue($sikap_pred_cel, $sikap_pred);
				if(isset($sikap_cat))
				{
					$sheet->setCellValue($sikap_cat_cel, $sikap_cat);
				}

			endforeach;

			// jumlah & rerata nilai
			
			$rumus_list = array(
				/////// MID ////////
				"K{$row_no}" => str_replace("{row}", $row_no, $rumus_jml_mid_teori),
				"L{$row_no}" => str_replace("{row}", $row_no, $rumus_jml_mid_praktek),
				"I{$row_no}" => str_replace("{row}", $row_no, $rumus_rt2_mid_teori),
				"J{$row_no}" => str_replace("{row}", $row_no, $rumus_rt2_mid_praktek),
				"h{$row_no}" => str_replace("{row}", $row_no, $rumus_mid_rank),
			
				/////// AKHIR //////////
				"R{$row_no}" => str_replace("{row}", $row_no, $rumus_jml_teori),
				"S{$row_no}" => str_replace("{row}", $row_no, $rumus_jml_praktek),
				"P{$row_no}" => str_replace("{row}", $row_no, $rumus_rt2_teori),
				"Q{$row_no}" => str_replace("{row}", $row_no, $rumus_rt2_praktek),
				"N{$row_no}" => str_replace("{row}", $row_no, $rumus_rank),
			);

			foreach ($rumus_list as $cll => $rms)
				$sheet->setCellValue($cll, $rms);

			//continue;
			// bagian ekskul

			if (isset($nisis['nisixk_array']))
			{
				$i_xk = 0;

				foreach ($nisis['nisixk_array'] as $nisixk)
				{
					$i_xk++;

					if ($i_xk > 4)
						break;

					$_cell_nama = "{$d['xk_array'][$i_xk]['excol_nama']}{$row_no}";
					$_cell_predikat = "{$d['xk_array'][$i_xk]['excol_predikat']}{$row_no}";
					$_cell_desc = "{$d['xk_array'][$i_xk]['excol_desc']}{$row_no}";

					$sheet->setCellValue($_cell_nama, $nisixk['ekskul_nama']);
					$nisixk['nilai'] = strtoupper($nisixk['nilai']);
					$sheet->setCellValue($_cell_predikat, $nisixk['nilai']);
					///////////// PERBAIKAN NILAI EKSKUL ///////////
					if($nisixk['keterangan']=="")
					{
						if (strpos($nisixk['nilai'], 'A') !== false)
						{
							$nisixk['keterangan'] = 'Sangat Baik';
						}
						elseif (strpos($nisixk['nilai'], 'B') !== false)
						{
							$nisixk['keterangan'] = 'Baik';
						}
						else
						{
							$nisixk['keterangan'] = 'Kurang';
						}
					}
					$sheet->setCellValue($_cell_desc, $nisixk['keterangan']);
				}
			}

			// bagian organisasi

			if (isset($nisis['nisiorg_array']))
			{
				$i_org = 0;

				foreach ($nisis['nisiorg_array'] as $nisiorg)
				{
					$i_org++;

					if ($i_org > 3)
						break;

					$_cell_nama = "{$d['org_array'][$i_org]['excol_nama']}{$row_no}";
					$_cell_desc = "{$d['org_array'][$i_org]['excol_desc']}{$row_no}";

					$sheet->setCellValue($_cell_nama, $nisiorg['org_nama']);
					$sheet->setCellValue($_cell_desc, $nisiorg['keterangan']);
				}
			}



		endforeach;

		if($ojk_exists == 1){
			///OJK
			$ojk = array(
				'pkl_nama' => array(
					'coloumn'	=> 'pkl_nama',
					'nama' 		=> 'Nama',
					'width'		=> 22,
					),
				'pkl_alamat' => array(
					'coloumn'	=> 'pkl_alamat',
					'nama' 		=> 'Alamat',
					'width'		=> 30,
					),
				'pkl_waktu' => array(
					'coloumn'	=> 'pkl_waktu',
					'nama' 		=> 'Lama',
					'width'		=> 12,
					),
				'pkl_nilai' => array(
					'coloumn'	=> 'pkl_nilai',
					'nama' 		=> 'Nilai',
					'width'		=> 10,
					),
				'pkl_predikat' => array(
					'coloumn'	=> 'pkl_predikat',
					'nama' 		=> 'Predikat',
					'width'		=> 10,
					),
				'pkl_keterangan' => array(
					'coloumn'	=> 'pkl_keterangan',
					'nama' 		=> 'Keterangan',
					'width'		=> 15,
					),
			);
			// header ojk
			$jml_tPkl=0;
			foreach ($ojk as &$_ojk){
				
				$jml_tPkl++;
				$_ojk_col	= excel_colnumber(++$col_no);
				if($jml_tPkl ==1){
					$_ojk_col1 = $_ojk_col;
					$sheet->setCellValue("{$_ojk_col}5", "Praktek Kerja Lapangan");
				}
				$sheet->setCellValue("{$_ojk_col}7", "{$_ojk['nama']}");
				$sheet->getColumnDimension($_ojk_col)->setWidth($_ojk['width']);
				$_ojk['col'] = $_ojk_col;
			}
			$sheet->mergeCells("{$_ojk_col1}5:{$_ojk_col}6");
			
			// value
			$row_ojk = $excel_row_offset;
			foreach ($d['leger'] as &$siswa_ojk):
				//print_r($siswa_ojk);
				$row_ojk++;
				foreach ($ojk as &$_ojk){
					$sheet->setCellValue($_ojk['col'] .$row_ojk , $siswa_ojk[$_ojk['coloumn']]);
				}
			endforeach;
			/// END OJK
		}
		
		// perumusan rangking alternatif
		/* /
		  for ($i = $row_start; $i <= $row_end; $i++) {
		  $cll = "G{$i}";
		  $rumus_rank = "=IF(ISNUMBER(I{$i}),RANK(I{$i},I{$row_start}:I{$row_end},0),\"\")";
		  $sheet->setCellValue($cll, $rumus_rank);
		  }
		  // */

		$getHighestColumn = $sheet->getHighestColumn();
		$row_first = $excel_row_offset + 1;
		$row_last = $row_no;

		// formating

		foreach ($cfg['col.width'] as $col => $wid)
			$sheet->getColumnDimension($col)->setWidth($wid);

		$sheet->getStyle("A{$row_first}:{$getHighestColumn}{$row_last}")->applyFromArray($style['umum']);
		$sheet->getStyle("A5:{$getHighestColumn}8")->applyFromArray($style['tengah']);
		$sheet->freezePane("C{$row_first}");

		// output

		// output
		if($parallel==0)
			return excel_output_2007($excel_obj, "leger_{$d['row']['kelas_nama']}.xlsx");
		else
			return excel_output_2007($excel_obj, "leger_paralel_kelas_{$d['row']['kelas_grade']}_{$d['row']['jurusan_nama']}.xlsx");
	}

	function peringkat($id)
	{
		$d = & $this->ci->d;

		// data nilai siswa

		$nisis_query = array(
			'select'	 => array(
				'nilai_siswa.id',
				'nilai_siswa.siswa_id',
				'nilai_siswa.absen_s',
				'nilai_siswa.absen_i',
				'nilai_siswa.absen_a',
				'nilai_siswa.nas_teori',
				'nilai_siswa.nas_praktek',
				'nilai_siswa.nas_total',
				'nilai_siswa.nas_skor',
				'nilai_siswa.rank_kelas',
				'nilai_siswa.diolah',
				'nilai_siswa.valid',
				'siswa_nama'	 => 'siswa.nama',
				'siswa_nis'		 => 'siswa.nis',
				'siswa_nisn'	 => 'siswa.nisn',
				'siswa_aktif'	 => 'siswa.aktif',
				'siswa_gender'	 => 'siswa.gender',
				'siswa.agama_id',
			),
			'from'		 => 'nilai_siswa',
			'join'		 => array(
				array('dprofil_siswa siswa', 'nilai_siswa.siswa_id = siswa.id', 'inner'),
			),
			'where'		 => array(
				'nilai_siswa.kelas_nilai_id' => $id
			),
			'order_by'	 => 'nilai_siswa.rank_kelas',
		);

		$d['nisis_result'] = $this->md->query($nisis_query)->result();

		if ($d['nisis_result']['selected_rows'] == 0)
			return alert_error("Daftar nilai siswa tidak ditemukan.");

		return TRUE;

	}

	// rerata

	function rerata_by_list($list)
	{

		/*
		 * 1 datetime
		 */

		$list = (array) $list;
		$list = implode(',', $list);
		$d = & $this->ci->d;
		$sql = "
update nilai_kelas nikls
inner join
(
	select
		kelas_nilai_id,
		avg(nas_total) nas_total,
		avg(nas_teori) nas_teori,
		avg(nas_praktek) nas_praktek,
		avg(uas) uas,
		avg(uts) uts
	from nilai_siswa_pelajaran
	where kelas_nilai_id in ({$list})
	group by kelas_nilai_id
) nisispel
	on nikls.id = nisispel.kelas_nilai_id
set
	nikls.nas_total = nisispel.nas_total,
	nikls.nas_teori = nisispel.nas_teori,
	nikls.nas_praktek = nisispel.nas_praktek,
	nikls.uas = nisispel.uas,
	nikls.uts = nisispel.uts,
	nikls.valid = 1,
	nikls.diolah = ?
where id in ({$list})
";

		$this->db->trans_start();
		$this->db->query($sql, array($d['datetime']));

		return $this->trans_done("Nilai rata-rata kelas berhasil diperbarui", 'Database error saat memperbarui rata-rata nilai kelas.');

	}

	function expor()
	{
		$this->load->library('PHPExcel');

		// deklarasi variabel

		if (TRUE):
			$d = & $this->ci->d;
			$excel_source = 'content/template/coztumized/' . strtolower(APP_SCOPE) . '/nilai_pelajaran.blank.2.xlsx';
			$style = array(
				'umum' => array(
					'borders'	 => array(
						'allborders' => array(
							'style' => PHPExcel_Style_Border::BORDER_THIN,
						),
					),
					'font'		 => array(
						'size' => 10,
					),
				),
			);
			$cfg = array(
				'table.nisis' => array(
					'B'	 => array('siswa_nis'),
					'C'	 => array('siswa_nama'),
				),
			);

		endif;
	}
	
	///////////////// UPLOAD SKHUN ////////////////////////////////////////////////

	function skhun_expor($id,$original = 0,$parallel=0)
	{
		$this->leger($id);
		
		$d = & $this->ci->d;

		if ($d['error'])
			return redir("nilai/kelas/{$id}");

		$this->load->helper('excel');
		excel_load();

		$styleArray = array(
			'fill' => array(
				'type'	 => PHPExcel_Style_Fill::FILL_SOLID,
				'color'	 => array('rgb' => 'DD9898'),
			)
		);
		// deklarasi variabel

		if (TRUE):
			$excel_row_offset = 7;
			$excel_col_offset = ord('E') - 65;
			$style = array(
				'umum' => array(
					'borders'	 => array(
						'allborders' => array(
							'style' => PHPExcel_Style_Border::BORDER_THIN,
						),
					),
					'font'		 => array(
						'size' => 10,
					),
				),
			);
			$style['tengah'] = $style['umum'];
			$style['tengah']['alignment']['horizontal'] = PHPExcel_Style_Alignment::HORIZONTAL_CENTER;
			$style['tengah']['alignment']['vertical'] = PHPExcel_Style_Alignment::VERTICAL_CENTER;
			$style['tengah']['borders']['allborders']['style'] = PHPExcel_Style_Border::BORDER_MEDIUM;
			$style['tengah']['font']['bold'] = TRUE;


			
			
			$cfg = array(
				'row.nikls'		 => array(
					// top header
					'A1' => array(
						'semester_nama',
						'strtoupper',
						'prefix' => 'NILAI SKHUN ',
						'suffix' => array(
							' TAHUN ',
							'ta_nama',
						),
					),
					// baris 1
					'A5' => 'No',
					'B5' => 'Nama Siswa',
					/*'C5' => 'NIS'.$this->getNameFromNumber(5),*/
					'C5' => 'NIS',
					'D5' => 'KELAS',
					
					
					
				),
				'merge_cells'	 => array(
					'A5:A7', // no
					'B5:B7', // nama
					'C5:C7', // nis
					'D5:D7', // kelas
					
				),
				'table.nisis'	 => array(
					'B'	 => 'siswa_nama',
					'C'	 => 'siswa_nis',
					'D'	 => 'kelas_nama',
					
				),
				'col.width'		 => array(
					'A'	 => 3,
					'B'	 => 25,
					'C'	 => 15,
					'D'	 => 15,
					
					
				),
			);
		endif;
		
		
		$cfg['row.nikls']['A2']=array('kelas_nama', 'strtoupper');
		$cfg['row.nikls']['A3']=array('kelas_wali_nama','prefix' => 'Wali Kelas: ');
	
		// mulai buka excel

		$excel_obj = new PHPExcel();
		$sheet = $excel_obj->getActiveSheet();
		$row_no = $excel_row_offset;
		$col_no = $excel_col_offset;
		$no = 0;
		
		// buat header
		$sheet->setCellValue('B4', $id);
		$sheet->getRowDimension('4')->setVisible(FALSE);
		
		excel_mergecells($sheet, $cfg['merge_cells']);
		$sheet->getStyle('A5:D7')->getAlignment()->setWrapText(true); 
		excel_row_write($sheet, $d['row'], $cfg['row.nikls']);
		
		$sheet->getColumnDimension("E")->setWidth(3);
		$space_range = "E5:E7";
		$sheet->mergeCells($space_range);
		// ascii 65 = A (kapital)
		// kolom A = nomor 1
		//
		// bagian header pelajaran
		
		
		foreach ($d['pelajaran_array'] as &$p3lajaran):

			$p3lajaran['excol']['id'] 	= excel_colnumber(++$col_no);
			$p3lajaran['excol']['skhun_nrata'] 	= excel_colnumber(++$col_no);
			$p3lajaran['excol']['skhun_us'] 	= excel_colnumber(++$col_no);
			$p3lajaran['excol']['skhun_ns'] 	= excel_colnumber(++$col_no);
			$p3lajaran['excol']['skhun_un'] 	= excel_colnumber(++$col_no);
			
			$p3lajaran['excol']['skhun_blank'] = excel_colnumber(++$col_no);
			
			$cell = $p3lajaran['excol']['id'] . '5';
			$cell_merge = $cell . ':' . ($p3lajaran['excol']['skhun_un']) . '5';

			
			$cell_nrata = "{$p3lajaran['excol']['skhun_nrata']}6";
			$sheet->setCellValue($cell_nrata, "Nilai Rata2");
			$sheet->getColumnDimension($p3lajaran['excol']['skhun_nrata'])->setWidth(9);
			
			$cell_us= "{$p3lajaran['excol']['skhun_us']}6";
			$sheet->setCellValue($cell_us, "Nilai US");
			$sheet->getColumnDimension($p3lajaran['excol']['skhun_us'])->setWidth(9);
			
			$cell_ns = "{$p3lajaran['excol']['skhun_ns']}6";
			$sheet->setCellValue($cell_ns, "Nilai Sekolah ");
			$sheet->getColumnDimension($p3lajaran['excol']['skhun_ns'])->setWidth(9);
			
			$cell_un = "{$p3lajaran['excol']['skhun_un']}6";
			$sheet->setCellValue($cell_un, "Nilai Ujian Nasional");
			$sheet->getColumnDimension($p3lajaran['excol']['skhun_un'])->setWidth(9);
			
			$sheet->getColumnDimension($p3lajaran['excol']['skhun_blank'])->setWidth(3);
			$space_range = $p3lajaran['excol']['skhun_blank']."5:".$p3lajaran['excol']['skhun_blank']."7";
			$sheet->mergeCells($space_range);
				
			//$sheet->setCellValue($cell, strtoupper($p3lajaran['mapel_nama']));
			$title_kategori = '';
			if(strpos(strtoupper($p3lajaran['kategori_nama']),"WAJIB") !== false)
				$title_kategori = '(wajib)';	
			if(strpos(strtoupper($p3lajaran['kategori_nama']),"PEMINATAN") !== false)
				$title_kategori = '(peminatan)';
			if(strpos(strtoupper($p3lajaran['kategori_nama']),"LINTAS") !== false)
				$title_kategori = '(l. minat)';
			
			$sheet->setCellValue($cell, strtoupper($p3lajaran['mapel_kode']." ".$title_kategori));
			$sheet->mergeCells($cell_merge);
			
			$sheet->getColumnDimension($p3lajaran['excol']['id'])->setVisible(FALSE);
			
		endforeach;
		
		$sheet->getStyle('A5:'.$p3lajaran['excol']['skhun_un'].'7')->getAlignment()->setWrapText(true); 

		// isi data nilai siswa

		foreach ($d['leger'] as $nisis):
			$row_no++;
			$no++;

			$cell = 'A' . $row_no;
			$sheet->setCellValue($cell, $no);
			
			// nilai siswa
			foreach ($cfg['table.nisis'] as $col_excel => $col_db):
				$cell = $col_excel . $row_no;
				$sheet->setCellValue($cell, $nisis[$col_db]);

			endforeach;

			// detail nilai pelajaran

			foreach ($d['pelajaran_array'] as $pelajaran_id => $pelajaran):
			
				$kategori_id = $pelajaran['kategori_id'];
				$mapel_id	 = $pelajaran['mapel_id'];
				
				
				$cell_id	= $pelajaran['excol']['id'] . $row_no;
				$id 		= $nisis['nisispel_array'][$kategori_id][$mapel_id]['id'];
				$sheet->setCellValue($cell_id, $id);
				
				$cell_skhun_nrata 	= $pelajaran['excol']['skhun_nrata'] . $row_no;
				$skhun_nrata 		= $nisis['nisispel_array'][$kategori_id][$mapel_id]['skhun_nrata'];
				$sheet->setCellValue($cell_skhun_nrata, $skhun_nrata);
				
				$cell_skhun_us 	= $pelajaran['excol']['skhun_us'] . $row_no;
				$skhun_us 		= $nisis['nisispel_array'][$kategori_id][$mapel_id]['skhun_us'];
				$sheet->setCellValue($cell_skhun_us, $skhun_us);
				
				$cell_skhun_ns 	= $pelajaran['excol']['skhun_ns'] . $row_no;
				$skhun_ns 		= "=((".$cell_skhun_nrata."*7)+(".$cell_skhun_us."*3))/10";
				$sheet->setCellValue($cell_skhun_ns, $skhun_ns);
				
				$cell_skhun_un 	= $pelajaran['excol']['skhun_un'] . $row_no;
				$skhun_un 		= $nisis['nisispel_array'][$kategori_id][$mapel_id]['skhun_un'];
				$sheet->setCellValue($cell_skhun_un, $skhun_un);
				
				$_cell_input[] = $cell_skhun_nrata ;
				$_cell_input[] = $cell_skhun_us ;
				$_cell_input[] = $cell_skhun_un ;
				
			endforeach;
			
		endforeach;

		$getHighestColumn = $sheet->getHighestColumn();
		$row_first = $excel_row_offset + 1;
		$row_last = $row_no;

		// formating

		foreach ($cfg['col.width'] as $col => $wid)
			$sheet->getColumnDimension($col)->setWidth($wid);

		$sheet->getStyle("A{$row_first}:{$getHighestColumn}{$row_last}")->applyFromArray($style['umum']);
		$sheet->getStyle("A5:{$getHighestColumn}7")->applyFromArray($style['tengah']);
		$sheet->freezePane("C{$row_first}");

		// lock
		excel_security_cell_lock($sheet, 'A1:'.$getHighestColumn.$row_last);
		excel_security_cell_unlock($sheet, $_cell_input);
		
		excel_security_sheet_lock($sheet);
		// output
		
		return excel_output_2007($excel_obj, "skhun_{$d['row']['kelas_nama']}.xlsx");
	}
	
	function skhun_impor(){
		$d = & $this->ci->d;
		$this->form->get();

		$this->load->helper('excel');
		
		if ($d['error'])
		{
			return FALSE;
		}

		// upload
		$upload_path = $this->storage_path($d['row']['id']);
		$file_name = "nilai_skhun.xlsx";
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
			$acc['admin'] = cfguc_admin('akses', 'nilai', 'kelas');
			$acc['view'] = cfguc_view('akses', 'nilai', 'kelas');
			$data_nipel = array();
			$data_nisispel = array();
			$cfg = array(
				'kolom.nilai' => array(
					'id',
					'skhun_nrata' ,
					'skhun_us' ,
					'skhun_ns' ,
					'skhun_un' ,
					
					
				),
			);
		}

		// ambil data nilai kelas

		$sheet = $PHPExcel->setActiveSheetIndex(0);

		try
		{
			$kelas_nilai_id = $sheet->getCell('B4')->getValue();
		}
		catch (Exception $ex)
		{
			$kelas_nilai_id = 0;
		}

		if ($d['row']['id'] != $kelas_nilai_id)
		{
			unset($PHPExcel);
			@unlink($upload['full_path']);
			return alert_error('Anda tidak dapat mengimpor dari file excel kelas lain atau semester sebelumnya.');
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
			$column_max = $sheet->getHighestColumn();
			$row_start = 8;

			if ($row_max > 512)
			{
				$row_max = 512;
			}

			for ($_row_no = $row_start; $_row_no <= $row_max; $_row_no++)
			{
				/*
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
				*/
				//$nisispel_list[] = $_nisispel_id;
				$_row = array();

				//$_excel_col = 'F';
				$_excel_col = ord('E') - 65;
				$_col_no=excel_colnumber(++$_excel_col);
				$done=0;
				//echo "aa".$_col_no."b".$column_max;
				while($done==0){
					foreach ($nilai_map as $_db_col )
					{
						
						try
						{
							$_cell = $_col_no . $_row_no;
							if($_db_col=="id"){
								$_nisispel_id = $sheet->getCell($_cell)->getCalculatedValue();
								
							}else{
								$_nilai = $sheet->getCell($_cell)->getCalculatedValue();
								$_row[$_db_col] = $_nilai;
							}
						}
						catch (Exception $ex)
						{
							$_row[$_db_col] = NULL;
						}
						
						$_col_no=excel_colnumber(++$_excel_col);
						if($_col_no==$column_max){
							$done=1;
						}
						
						
					}
					
					$_col_no=excel_colnumber(++$_excel_col);
					if($_col_no==$column_max){
						$done=1;
					}
					
					if($_nisispel_id>0){
						$data_nisispel[$_nisispel_id] = $_row;
						
					}
					$nisispel_jml++;
				}
			}
		}

		//print_r($data_nisispel);
		//echo " aa".$nisispel_jml." b".$_sheet_index;
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
			///$nilsis_series = $this->m_nilai_siswa_pelajaran->nilsis_series($nisispel_list);

			//if (empty($nilsis_series))
			//{
				//alert_error('Daftar nilai yang akan diperbarui tidak terbaca.');
			//}
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

		// selesai
		return !$d['error'];
	}
	
	///////////////////////////////////////////////////////////////////////////////////
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
		$path = APP_ROOT."content/".strtolower(APP_SCOPE)."/nilai-kelas/{$nipel_id}/";

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
	
}
