<?php

class M_nilai_siswa_pelajaran extends MY_Model
{

	public function __construct()
	{
		parent::__construct(array(
			'fields' => array(
				// nilai akhir semester
				'nas_teori', 'nas_praktek', 'nas_sikap',
				'pred_teori', 'pred_praktek', 'pred_sikap',
				// nilai mid semester
				'mid_teori', 'mid_praktek', 'mid_sikap',
				'mid_pred_teori', 'mid_pred_praktek', 'mid_pred_sikap',
				// nilai ulangan umum
				'uas', 'uts',
			),
			'fields_catatan' => array(
				'kompetensi', 'cat_teori', 'cat_praktek',
			),
			'fields_penuntasan' => array(
				'nas_teori_tuntas',
			),
		));

	}

	function catatan_guru($pelajaran_nilai_id, $index = 0, $limit = 50)
	{
		$d = $this->ci->d;
		$r = $this->ci->d['request'];

		// query dasar

		$query = array(
			'select'	 => array(
				'catatan.*',
				'nikls.kelas_id',
			),
			'from'		 => 'nilai_pelajaran_catatan catatan',
			'join'		 => array(
				array('nilai_kelas nikls', 'catatan.kelas_nilai_id = nikls.id', 'inner'),
			),
			'where'		 => array(
				'catatan.pelajaran_nilai_id' => (int) $pelajaran_nilai_id,
			),
			'order_by'	 => 'catatan.jenis_nilai,catatan.kode',
		);


		return $this->md->query($query)->resultset($index, $limit);

	}

	function pelajaran($pelajaran_nilai_id = 0, $index = 0, $limit = 50)
	{
		$d = $this->ci->d;
		$r = $this->ci->d['request'];

		// query dasar

		$query = array(
			'select'	 => array(
				'nisispel.*',
				'nikls.kelas_id',
				'nikls.kelas_wali_id',
				'siswa_nama'	 => 'siswa.nama',
				'siswa_gender'	 => 'siswa.gender',
				'siswa_nis'		 => 'siswa.nis',
				'siswa_nisn'	 => 'siswa.nisn',
				'kelas_grade'	 => 'kelas.grade',
				'kelas_nama'	 => 'kelas.nama',
				'kelas_wali'	 => 'guru.nama',
				'agama_nama'	 => 'agama.nama',
				
				'nipelkel.materi_teori',
				'nipelkel.materi_praktek',
			),
			'from'		 => 'nilai_siswa_pelajaran nisispel',
			'join'		 => array(
				array('nilai_siswa nilsis', 'nisispel.siswa_nilai_id = nilsis.id', 'inner'),
				array('nilai_pelajaran nipel', 'nisispel.pelajaran_nilai_id = nipel.id', 'inner'),
				
				array('nilai_pelajaran_kelas nipelkel', 'nisispel.pelajaran_nilai_id = nipelkel.pelajaran_nilai_id AND nisispel.kelas_nilai_id = nipelkel.kelas_nilai_id', 'inner'),
				
				array('dprofil_siswa siswa', 'nilsis.siswa_id = siswa.id', 'inner'),
				array('dmst_agama agama', 'siswa.agama_id = agama.id', 'inner'),
				array('nilai_kelas nikls', 'nisispel.kelas_nilai_id = nikls.id', 'inner'),
				array('dakd_kelas kelas', 'nikls.kelas_id = kelas.id', 'inner'),
				array('dprofil_sdm guru', 'kelas.wali_id = guru.id', 'left'),
			), 
			'order_by'	 => 'kelas.grade, kelas.nama, nilsis.absen_no, siswa.nama',
		);
		
		// SMP TERBANG
		if(APP_SUBDOMAIN=='smp_terbang'){
			$query['order_by'] = 'kelas.grade, kelas.nama, nilsis.absen_no, siswa.nis';
			$query['select'][] = 'kkm1_kd1';
			$query['select'][] = 'kkm1_kd2';
			$query['select'][] = 'kkm1_kd3';
			$query['select'][] = 'kkm1_kd4';
			$query['select'][] = 'kkm1_kd5';
			$query['select'][] = 'kkm1_kd6';
			$query['select'][] = 'kkm1_kd7';
			$query['select'][] = 'kkm1_kd8';
			$query['select'][] = 'kkm1_kd9';
			$query['select'][] = 'kkm1_kd10';
		}
		
		if($pelajaran_nilai_id != "x"){
			$query['where']['nisispel.pelajaran_nilai_id'] =  (int) $pelajaran_nilai_id;
		}
		// batasan akses

		if ($d['user']['role'] == 'siswa')
			$query['where']['siswa.id'] = $d['user']['id'];

		// filtering

		if (isset($r['term']))
			$query['like'] = array($r['term'], array('siswa.nis%', 'siswa.nama'));

		if (isset($r['kelas_id']) && $r['kelas_id'] > 0)
			$query['where']['kelas.id'] = $r['kelas_id'];

		// hasil

		return $this->md->query($query)->resultset($index, $limit);

	}

	function rerata(&$row, $nipel, $bobot_teori = 1)
	{
		$na_harian = array();
		$na_praktek = array();
		$na_sikap = array();

		for ($no = 1; $no <= 10; $no++):
			$u = $row['u' . $no];
			$r = $row['r' . $no];
			$kkm = (float) (empty($nipel['kkm' . $no])) ? $nipel['kkm'] : $nipel['kkm' . $no];

			// proses nilai harian

			if (empty($u) OR ! is_numeric($u)):
				$row['u' . $no] = NULL;
				$row['r' . $no] = NULL;
				$row['h' . $no] = NULL;

			elseif ($u >= $kkm OR empty($r) OR ! is_numeric($r) OR $u > $r):
				$row['u' . $no] = (float) $u;
				$row['r' . $no] = (is_numeric($r)) ? (float) $r : NULL;
				$row['h' . $no] = (float) $u;

			elseif ($r > $kkm):
				$row['u' . $no] = (float) $u;
				$row['r' . $no] = (float) $r;
				$row['h' . $no] = (float) $kkm;

			else:
				$row['u' . $no] = (float) $u;
				$row['r' . $no] = (float) $r;
				$row['h' . $no] = (float) $r;

			endif;

			if ($row['h' . $no])
				$na_harian[] = $row['h' . $no];

			// proses nilai tugas

			if (empty($row['t' . $no])):
				$row['t' . $no] = NULL;

			else:
				$row['t' . $no] = (float) $row['t' . $no];
				$na_harian[] = $row['t' . $no];

			endif;

			// proses nilai praktek

			if (empty($row['p' . $no])):
				$row['p' . $no] = NULL;

			else:
				$row['p' . $no] = (float) $row['p' . $no];
				$na_praktek[] = $row['p' . $no];

			endif;

			// proses nilai sikap

			if (empty($row['s' . $no])):
				$row['s' . $no] = NULL;

			else:
				$row['s' . $no] = (float) $row['s' . $no];
				$na_sikap[] = $row['s' . $no];

			endif;

		endfor;

		// ulangan umum

		$row['uts'] = (!empty($row['uts'])) ? (float) $row['uts'] : NULL;
		$row['uas'] = (!empty($row['uas'])) ? (float) $row['uas'] : NULL;

		// jumlah nilai masuk

		$na_harian_jml = count($na_harian);
		$na_praktek_jml = count($na_praktek);
		$na_sikap_jml = count($na_sikap);

		// proses nilai akhir teori

		if (!$row['uas'] && $na_harian_jml < 1):
			$row['nas_teori'] = NULL;

		elseif ($row['uas'] && $na_harian_jml < 1):
			$row['nas_teori'] = $row['uas'];

		elseif (!$row['uas'] && $na_harian_jml > 0):
			$row['nas_teori'] = array_sum($na_harian) / $na_harian_jml;

		else:
			$row['nas_teori'] = ( (2 * array_sum($na_harian) / $na_harian_jml) + $row['uas']) / 3;

		endif;

		// nilai akhir praktek & sikap

		$row['nas_praktek'] = ($na_praktek_jml > 0) ? (array_sum($na_praktek) / $na_praktek_jml) : NULL;
		$row['nas_sikap'] = ($na_sikap_jml > 0) ? (array_sum($na_sikap) / $na_sikap_jml) : NULL;

		// nilai akhir total

		if (!$row['nas_teori'] && !$row['nas_praktek']):
			$row['nas_total'] = 0;

		elseif (($row['nas_teori'] && !$row['nas_praktek'] ) OR $bobot_teori > 99):
			$row['nas_total'] = (float) $row['nas_teori'];

		elseif (!$row['nas_teori'] && $row['nas_praktek']):
			$row['nas_total'] = (float) $row['nas_praktek'];

		else:
			$bobot_praktek = 100 - $bobot_teori;
			$row['nas_total'] = (($bobot_teori * $row['nas_teori']) + ($bobot_praktek * $row['nas_praktek'])) / 100;

		endif;

		// kompetensi
		// sementara hanya proses kompetensi akhir semester

		$kompetensi = array(
			$nipel['kd_h1'],
			$nipel['kd_h2'],
			$nipel['kd_h3'],
			$nipel['kd_h4'],
			$nipel['kd_h5'],
			$nipel['kd_h6'],
			$nipel['kd_h7'],
			$nipel['kd_h8'],
			$nipel['kd_h9'],
			$nipel['kd_h10'],
		);
		$kompetensi = implode(', ', $kompetensi);
		$kompetensi = trim($kompetensi, ', \t\n\r\0\x0B');
		$row['kompetensi'] = ($row['nas_total'] < $nipel['kkm']) ? "Tingkatkan penguasaan {$kompetensi}." : ucfirst($kompetensi) . " telah mencapai KKM.";

	}

	function siswa($siswa_nilai_id, $index = 0, $limit = 50)
	{

		// query dasar

		$select = array(
			'nisispel.*',
			'pelajaran_kode' => 'pelajaran.kode',
			'pelajaran_nama' => 'pelajaran.nama',
			'kategori_kode'	 => 'kategori.kode',
			'kategori_nama'	 => 'kategori.nama',
			'mapel_nama'	 => 'mapel.nama',
			'guru_nama'		 => "trim(concat_ws(' ', guru.prefix, guru.nama, guru.suffix))",
			'nipel_kkm'		 => 'nipel.kkm',
			'nipel_kkm1'	 => 'nipel.kkm1',
			'nipel_kkm2'	 => 'nipel.kkm2',
			'nipel_kkm3'	 => 'nipel.kkm3',
			'nipel_kkm4'	 => 'nipel.kkm4',
			'nipel_kkm5'	 => 'nipel.kkm5',
			'nipel_kkm6'	 => 'nipel.kkm6',
			'nipel_kkm7'	 => 'nipel.kkm7',
			'nipel_kkm8'	 => 'nipel.kkm8',
			'nipel_kkm9'	 => 'nipel.kkm9',
			'nipel_kkm10'	 => 'nipel.kkm10',
			'nipel_h1'		 => 'nipel.h1',
			'nipel_h2'		 => 'nipel.h2',
			'nipel_h3'		 => 'nipel.h3',
			'nipel_h4'		 => 'nipel.h4',
			'nipel_h5'		 => 'nipel.h5',
			'nipel_h6'		 => 'nipel.h6',
			'nipel_h7'		 => 'nipel.h7',
			'nipel_h8'		 => 'nipel.h8',
			'nipel_h9'		 => 'nipel.h9',
			'nipel_h10'		 => 'nipel.h10',
		);
		$this->md
			->select($select)
			->from('nilai_siswa_pelajaran nisispel')
			->join('nilai_pelajaran nipel', 'nisispel.pelajaran_nilai_id = nipel.id', 'inner')
			->join('dakd_pelajaran pelajaran', 'nipel.pelajaran_id = pelajaran.id', 'inner')
			->join('dakd_kategori_mapel kategori', 'pelajaran.kategori_id = kategori.id', 'inner')
			->join('dakd_mapel mapel', 'pelajaran.mapel_id = mapel.id', 'inner')
			->join('dprofil_sdm guru', 'nipel.guru_id = guru.id', 'inner')
			->where('nisispel.siswa_nilai_id', $siswa_nilai_id)
			->order_by('kategori.kode, mapel.nama');

		return $this->md->resultset($index, $limit);

	}

	function siswarapor($siswa_nilai_id, $kurikulum_nama, $mapel_tertentu='' )
	{

		// query dasar

		$query = array(
			'from'		 => 'nilai_siswa_pelajaran nisispel',
			'join'		 => array(
				array('nilai_pelajaran nipel', 'nisispel.pelajaran_nilai_id = nipel.id', 'inner'),
				
				array('nilai_pelajaran_kelas nipelkel', 'nisispel.pelajaran_nilai_id = nipelkel.pelajaran_nilai_id AND nisispel.kelas_nilai_id = nipelkel.kelas_nilai_id', 'inner'),
				
				array('dakd_pelajaran pelajaran', 'nipel.pelajaran_id = pelajaran.id', 'inner'),
				array('dakd_kategori_mapel kategori', 'pelajaran.kategori_id = kategori.id', 'inner'),
				array('dakd_mapel mapel', 'pelajaran.mapel_id = mapel.id', 'inner'),
				array('dprofil_sdm guru', 'nipel.guru_id = guru.id', 'left'),
			),
			'where'		 => array(
				'nisispel.siswa_nilai_id' => $siswa_nilai_id,
			),
			
			'select'	 => array(
				
				'nisispel.*',
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
				
			
				//'guru_nama' => "trim(concat_ws(' ', guru.prefix, guru.nama, guru.suffix))",
				'guru_nama'		 => "trim(trim(TRAILING ', ' from concat(guru.prefix, ' ', guru.nama, ', ', guru.suffix)))",
				'guru_nip'		 => 'guru.nip',
				'guru_id'		 => 'guru.id',
				
				'nipelkel.materi_teori',
				'nipelkel.materi_praktek',
			),
		);
		if($mapel_tertentu==''){
			$query['where']['kategori.show_rapor'] = 1;
		}else{
			$query['where']['mapel.kode'] = $mapel_tertentu;
		}
		
		if(APP_SUBDOMAIN=='smpterbang.fresto.co'){
			$bobot=1;
			while($bobot<=10){
				$query['select']['kd'.$bobot.'_bobot1'] = 'nipel.kd'.$bobot.'_bobot1';
				$query['select']['kd'.$bobot.'_bobot2'] = 'nipel.kd'.$bobot.'_bobot2';
				$query['select']['kd'.$bobot.'_bobot3'] = 'nipel.kd'.$bobot.'_bobot3';
				$bobot++;
			}
		}
		
		if($kurikulum_nama=='ktsp')
		{
			$query['order_by']	 = 'kategori.nourut ASC, mapel.no_urut_ktsp ASC';
		}else{
			$query['order_by']	 = 'kategori.nourut ASC, mapel.nourut ASC';
		}
		
		return $this->md->query($query)->result();

	}

	function update_batch($data)
	{
		$data = array_values($data);
		$jml = count($data);
		$this->db->trans_start();
		$this->db->update_batch('nilai_siswa_pelajaran', $data, 'id');

		return $this->trans_done("Nilai pelajaran {$jml} siswa berhasil diperbarui", 'Database error saat memperbarui nilai pelajaran siswa.');

	}

	function nilsis_series($nilai_list)
	{
		$query = array(
			'select'	 => array('id', 'siswa_nilai_id'),
			'from'		 => 'nilai_siswa_pelajaran',
			'where_in'	 => array(
				'id' => $nilai_list,
			),
		);

		return $this->md->query($query)->result_series('id', 'siswa_nilai_id');

	}

	// tambahan mas nur u/ theresiana

	function nilai_pelajaran($siswa_nilai_id, $index = 0, $limit = 50)
	{

		// query dasar

		$select = array(
			'nisispel.*',
			'pelajaran_kode' => 'pelajaran.kode',
			'pelajaran_nama' => 'pelajaran.nama',
			'kategori_kode'	 => 'kategori.kode',
			'kategori_nama'	 => 'kategori.nama',
			'mapel_nama'	 => 'mapel.nama',
			'guru_nama'		 => "trim(concat_ws(' ', guru.prefix, guru.nama, guru.suffix))",
			'nipel_kkm'		 => 'nipel.kkm',
		);
		$this->md
			->select($select)
			->from('nilai_siswa_pelajaran nisispel')
			->join('nilai_pelajaran nipel', 'nisispel.pelajaran_nilai_id = nipel.id', 'inner')
			->join('dakd_pelajaran pelajaran', 'nipel.pelajaran_id = pelajaran.id', 'inner')
			->join('dakd_kategori_mapel kategori', 'pelajaran.kategori_id = kategori.id', 'inner')
			->join('dakd_mapel mapel', 'pelajaran.mapel_id = mapel.id', 'inner')
			->join('dprofil_sdm guru', 'nipel.guru_id = guru.id', 'inner')
			->where('nisispel.siswa_nilai_id', $siswa_nilai_id)
			->where('kategori.id', '1')
			->order_by('mapel.nourut, kategori.kode');

		return $this->md->resultset($index, $limit);

	}

	function nilai_mulok($siswa_nilai_id, $index = 0, $limit = 50)
	{

		// query dasar

		$select = array(
			'nisispel.*',
			'pelajaran_kode' => 'pelajaran.kode',
			'pelajaran_nama' => 'pelajaran.nama',
			'kategori_kode'	 => 'kategori.kode',
			'kategori_nama'	 => 'kategori.nama',
			'mapel_nama'	 => 'mapel.nama',
			'guru_nama'		 => "trim(concat_ws(' ', guru.prefix, guru.nama, guru.suffix))",
			'nipel_kkm'		 => 'nipel.kkm',
		);
		$this->md
			->select($select)
			->from('nilai_siswa_pelajaran nisispel')
			->join('dakd_pelajaran pelajaran', 'nisispel.pelajaran_id = pelajaran.id', 'inner')
			->join('dakd_kategori_mapel kategori', 'pelajaran.kategori_id = kategori.id', 'inner')
			->join('dakd_mapel mapel', 'pelajaran.mapel_id = mapel.id', 'inner')
			->join('nilai_pelajaran nipel', 'nisispel.pelajaran_nilai_id = nipel.id', 'inner')
			->join('dprofil_sdm guru', 'nipel.guru_id = guru.id', 'inner')
			->where('nisispel.siswa_nilai_id', $siswa_nilai_id)
			->where('kategori.id', '2')
			->order_by('mapel.nourut, kategori.kode');

		return $this->md->resultset($index, $limit);

	}

	function get_ta()
	{
		$select = array(
			'semester.*',
			'semester'		 => 'semester.nama',
			'tahunajaran'	 => 'ta.nama',
			'prefix'		 => 'user.prefix',
			'namakepsek'	 => 'user.nama',
			'sufix'			 => 'user.suffix',
			'nip'			 => 'user.nip'
		);
		$this->md
			->select($select)
			->from('prd_semester semester')
			->join('prd_ta ta', 'semester.ta_id = ta.id', 'inner')
			->join('dprofil_sdm user', 'user.id = semester.kepsek_id', 'inner')
			->where('semester.status', 'aktif');

		return $this->md->resultset();

	}

	function query_1()
	{
		return array(
			'select' => array(
				'nilsispel.*',
				'siswa_nis'		 => 'siswa.nis',
				'siswa_nama'	 => 'siswa.nama',
				'semester_nama'	 => 'semester.nama',
				'ta_nama'		 => 'ta.nama',
				'pelajaran_nama' => 'pelajaran.nama',
				'mapel_id'		 =>	'mapel.id',
				'mapel_nama'	 => 'mapel.nama',
				'guru_nama'		 => "trim(concat_ws(' ', guru.prefix, guru.nama, guru.suffix))",
				'kelas_nama'	 => 'kelas.nama',
			),
			'from'	 => 'nilai_siswa_pelajaran nilsispel',
			'join'	 => array(
				array('nilai_siswa nilsis', 'nilsispel.siswa_nilai_id = nilsis.id', 'left'),
				array('dprofil_siswa siswa', 'nilsis.siswa_id = siswa.id', 'left'),
				array('prd_semester semester', 'nilsis.semester_id = semester.id', 'left'),
				array('prd_ta ta', 'semester.ta_id = ta.id', 'left'),
				array('nilai_pelajaran nilpel', 'nilsispel.pelajaran_nilai_id = nilpel.id', 'left'),
				array('dakd_pelajaran pelajaran', 'nilpel.pelajaran_id = pelajaran.id', 'left'),
				array('dakd_mapel mapel', 'pelajaran.mapel_id = mapel.id', 'left'),
				array('dprofil_sdm guru', 'nilpel.guru_id = guru.id', 'left'),
				array('dakd_kelas kelas', 'nilsis.kelas_id = kelas.id', 'left'),
			),
		);

	}

	function rowset($id)
	{
		$query = $this->query_1();
		$query['where']['nilsispel.id'] = $id;

		return $this->md->query($query)->row();

	}

	function save()
	{
		$d = & $this->ci->d;

		$this->form->ruleset($d['row'], 'validasi');
		$this->form->validate();

		if ($d['error'])
		{
			return FALSE;
		}

		$data = $this->inputset('fields');

		return $this->update($data, $d['form']['id']);

	}

	function save_catatan()
	{
		$d = & $this->ci->d;

		$this->form->ruleset($d['row'], 'validasi');
		$this->form->validate();

		if ($d['error'])
		{
			return FALSE;
		}

		$data = $this->inputset('fields_catatan');

		return $this->update($data, $d['form']['id']);

	}
	
	function save_penuntasan()
	{
		$d = & $this->ci->d;

		$this->form->ruleset($d['row'], 'validasi');
		$this->form->validate();

		if ($d['error'])
		{
			return FALSE;
		}

		$data = $this->inputset('fields_penuntasan');

		return $this->update($data, $d['form']['id']);

	}
	
	function update($data, $id)
	{

		$this->db->trans_start();

		$this->db->update('nilai_siswa_pelajaran', $data, array('id' => $id));

		return $this->trans_done('Data nilai pelajaran siswa berhasil diperbarui.', 'Database error, coba beberapa saat lagi.');

	}
	
	function pelajaran_kelas($id = 0, $index=0, $limit=100)
	{
		$d = $this->ci->d;
		$dm = & $this->dm;
		
		// query dasar
		$query = array(
			'select' => array('kelas.*'),
			'from' => 'dakd_kelas kelas',
			'join' => array(
				array('nilai_pelajaran_kelas nipelkls', 'kelas.id = nipelkls.kelas_id', 'inner'),
			), 
			'order_by' => 'kelas.grade, kelas.nama',
		);
		
		if($id != "x"){
			$query['where']['nipelkls.pelajaran_nilai_id'] =  (int) $id;
		}

		// commit selection
		return $this->md->query($query)->resultset($index, $limit);
	}
	
	function rerata_pelajaran_perkelas($kolom, $kelas_id, $semester_id)
	{
		$d = $this->ci->d;
		$dm = & $this->dm;
		
		// cek pelajaran
		// query dasar
		$query = array(
			'select' => array('nipelkls.*'),
			'from' => 'dakd_kelas kelas',
			'join' => array(
				array('nilai_pelajaran_kelas nipelkls', 'kelas.id = nipelkls.kelas_id', 'inner'),
			),
			'where' => array(
				'kelas.id' => $kelas_id,
				'nipelkls.semester_id' => $semester_id,
			),
		);
		

		// commit selection
		$nilai_pelajaran_kelas = $this->md->query($query)->resultset( 0, 1024);
		
		if ($nilai_pelajaran_kelas['selected_rows'] == 0)
			return alert_error("Daftar nilai pelajaran tiap siswa tidak ditemukan.");

		// kumpulkan nisispel ke leger
		
		foreach ($nilai_pelajaran_kelas['data'] as $nipelkls):
			$pelajaran_nilai_id	= (int) $nipelkls['pelajaran_nilai_id'];
			$kelas_nilai_id		= (int) $nipelkls['kelas_nilai_id'];
			
			// query dasar
			$query = array(
				'select' => array(
					'nipel.pelajaran_id',
					'rerata' => 'ROUND(avg(nisispel.'.$kolom.'),0)'),
				'from' => 'nilai_siswa_pelajaran nisispel',
				'join' => array(
					array('nilai_pelajaran nipel', 'nisispel.pelajaran_nilai_id = nipel.id', 'inner'),
				),
				'where' => array(
					'nisispel.pelajaran_nilai_id'	=> $pelajaran_nilai_id,
					'nisispel.kelas_nilai_id'		=> $kelas_nilai_id,
				),
			);
			$nilai_pelajaran = $this->md->query($query)->resultset( 0, 1024);
			
			foreach ($nilai_pelajaran['data'] as $nisispel):
				$pelajaran_id	= (int) $nisispel['pelajaran_id'];
				$nilai_rerata	= (int) $nisispel['rerata'];
				$rerata[$pelajaran_id] = $nilai_rerata;
			endforeach;
		endforeach;
		
		// commit selection
		return $rerata;
	}

}
