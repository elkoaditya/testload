<?php

class M_nilai_siswa_pelajaran extends MY_Model {

	public function __construct() {
		parent::__construct();
	}

	function pelajaran($pelajaran_nilai_id, $index = 0, $limit = 50) {
		$d = $this->ci->d;
		$r = $this->ci->d['request'];

		// query dasar

		$query = array(
				'select' => array(
						'nisispel.*',
						'nikls.kelas_id',
						'nikls.kelas_wali_id',
						'siswa_nama' => 'siswa.nama',
						'siswa_gender' => 'siswa.gender',
						'siswa_nis' => 'siswa.nis',
						'siswa_nisn' => 'siswa.nisn',
						'kelas_grade' => 'kelas.grade',
						'kelas_nama' => 'kelas.nama',
						'agama_nama' => 'agama.nama',
				),
				'from' => 'nilai_siswa_pelajaran nisispel',
				'join' => array(
						array('nilai_siswa nilsis', 'nisispel.siswa_nilai_id = nilsis.id', 'inner'),
						array('dprofil_siswa siswa', 'nilsis.siswa_id = siswa.id', 'inner'),
						array('dmst_agama agama', 'siswa.agama_id = agama.id', 'inner'),
						array('nilai_kelas nikls', 'nisispel.kelas_nilai_id = nikls.id', 'inner'),
						array('dakd_kelas kelas', 'nikls.kelas_id = kelas.id', 'inner'),
				),
				'where' => array(
						'nisispel.pelajaran_nilai_id' => (int) $pelajaran_nilai_id,
				),
				'order_by' => 'kelas.grade, kelas.nama, siswa.nama',
		);

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

	function rerata(&$row, $nipel, $bobot_teori = 1) {
		$na_harian = array();
		$na_praktek = array();
		$na_sikap = array();

		for ($no = 1; $no <= 10; $no++):
			$u = $row['u' . $no];
			$r = $row['r' . $no];
			$kkm = (float) (empty($nipel['kkm' . $no])) ? $nipel['kkm'] : $nipel['kkm' . $no];

			// proses nilai harian

			if (empty($u) OR !is_numeric($u)):
				$row['u' . $no] = NULL;
				$row['r' . $no] = NULL;
				$row['h' . $no] = NULL;

			elseif ($u >= $kkm OR empty($r) OR !is_numeric($r) OR $u > $r):
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

	function siswa($siswa_nilai_id, $index = 0, $limit = 50) {

		// query dasar

		$select = array(
				'nisispel.*',
				'pelajaran_kode' => 'pelajaran.kode',
				'pelajaran_nama' => 'pelajaran.nama',
				'kategori_kode' => 'kategori.kode',
				'kategori_nama' => 'kategori.nama',
				'mapel_nama' => 'mapel.nama',
				'guru_nama' => "trim(concat_ws(' ', guru.prefix, guru.nama, guru.suffix))",
				'nipel_kkm' => 'nipel.kkm',
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
				->order_by('mapel.nourut, kategori.kode');

		return $this->md->resultset($index, $limit);



		/* 	$select = array(
		  'nilai.*',
		  'ta_nama' => 'ta.nama',
		  'semester_nama' => 'semester.nama',
		  'siswa_nis' => 'siswa.nis',
		  'siswa_nisn' => 'siswa.nisn',
		  'siswa_nama' => 'siswa.nama',
		  'siswa_gender' => 'siswa.gender',
		  'kelas_nama' => 'kelas.nama',
		  'kelas_wali_id' => 'kelas.wali_id',
		  'kelas_gurubk_id' => 'kelas.gurubk_id',
		  );
		  $this->md
		  ->select($select)
		  ->from('nilai_siswa nilai')
		  ->join('dprofil_siswa siswa', 'nilai.siswa_id = siswa.id', 'inner')
		  ->join('prd_semester semester', 'nilai.semester_id = semester.id', 'inner')
		  ->join('prd_ta ta', 'semester.ta_id = ta.id', 'inner')
		  ->join('dakd_kelas kelas', 'nilai.kelas_id = kelas.id', 'inner')

		  ->where('nilai.siswa_id', $siswa_nilai_id)
		  ->order_by('semester.id, kelas.grade, kelas.nama, siswa.nama');

		  return $this->md->resultset($index, $limit); */
	}

	function update_batch($data) {
		$data = array_values($data);
		$jml = count($data);
		$this->db->trans_start();
		$this->db->update_batch('nilai_siswa_pelajaran', $data, 'id');

		return $this->trans_done("Nilai pelajaran {$jml} siswa berhasil diperbarui", 'Database error saat memperbarui nilai pelajaran siswa.');
	}

	function nilsis_series($nilai_list) {
		$query = array(
				'select' => array('id', 'siswa_nilai_id'),
				'from' => 'nilai_siswa_pelajaran',
				'where_in' => array(
						'id' => $nilai_list,
				),
		);

		return $this->md->query($query)->result_series('id', 'siswa_nilai_id');
	}

	// tambahan

	function nilai_pelajaran($siswa_nilai_id, $index = 0, $limit = 50) {

		// query dasar

		$select = array(
				'nisispel.*',
				'pelajaran_kode' => 'pelajaran.kode',
				'pelajaran_nama' => 'pelajaran.nama',
				'kategori_kode' => 'kategori.kode',
				'kategori_nama' => 'kategori.nama',
				'mapel_nama' => 'mapel.nama',
				'guru_nama' => "trim(concat_ws(' ', guru.prefix, guru.nama, guru.suffix))",
				'nipel_kkm' => 'nipel.kkm',
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

	function nilai_mulok($siswa_nilai_id, $index = 0, $limit = 50) {

		// query dasar

		$select = array(
				'nisispel.*',
				'pelajaran_kode' => 'pelajaran.kode',
				'pelajaran_nama' => 'pelajaran.nama',
				'kategori_kode' => 'kategori.kode',
				'kategori_nama' => 'kategori.nama',
				'mapel_nama' => 'mapel.nama',
				'guru_nama' => "trim(concat_ws(' ', guru.prefix, guru.nama, guru.suffix))",
				'nipel_kkm' => 'nipel.kkm',
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

	function get_ta() {
		$select = array(
				'semester.*',
				'semester' => 'semester.nama',
				'tahunajaran' => 'ta.nama',
				'prefix' => 'user.prefix',
				'namakepsek' => 'user.nama',
				'sufix' => 'user.suffix',
				'nip' => 'user.nip'
		);
		$this->md
				->select($select)
				->from('prd_semester semester')
				->join('prd_ta ta', 'semester.ta_id = ta.id', 'inner')
				->join('dprofil_sdm user', 'user.id = semester.kepsek_id', 'inner')
				->where('semester.status', 'aktif');

		return $this->md->resultset();
	}

}
