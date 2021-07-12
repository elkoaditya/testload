<?php

class M_kbm_angket_ljs extends MY_Model {

	public function __construct() {
		parent::__construct();
	}
	
	function filter_1($query) {
		$d = & $this->ci->d;
		$r = & $this->ci->d['request'];
		$def = array(
				'angket_id' => 0,
				'user_id' => 0,
				'term' => '',
		);
		$query['where']['ljs.angket_id'] = (int) $r['angket_id'];
		$query['like'] = array($r['term'], 'siswa.nama');

		array_default($r, $def);

		if ($r['user_id'] > 0 && $d['user']['role'] != 'siswa')
			$query['where']['ljs.user_id'] = (int) $r['user_id'];

		return $query;
	}
	
	function query_1() {
		$d = & $this->ci->d;
		$query = array(
				'from' => 'kbm_angket_ljs ljs',
				'join' => array(
						array('dprofil_siswa siswa', 'ljs.user_id = siswa.id', 'inner'),
						array('dakd_kelas kelas', 'ljs.kelas_id = kelas.id', 'inner'),
				),
				'select' => array(
						'ljs.*',
						'siswa_nama' => 'siswa.nama',
						'siswa_nis' => 'siswa.nis',
						'siswa_nisn' => 'siswa.nisn',
						'siswa_gender' => 'siswa.gender',
						'kelas_nama' => 'kelas.nama',
				),
		);

		if ($d['user']['role'] == 'siswa'):
			$query['join'][] = array('kbm_angket_nilai nilai', 'ljs.angket_id = nilai.angket_id', 'inner');
			$query['join'][] = array('dprofil_siswa menilai_siswa', 'menilai_siswa.id = nilai.menilai_user_id', 'inner');
			$query['join'][] = array('kbm_angket angket','ljs.angket_id = angket.id','inner');
			$query['where']['ljs.user_id'] = $d['user']['id'];
			$query['where']['nilai.menilai_user_id'] = $d['user']['menilai_id'];
			$query['select'][] = 'menilai_siswa.nama as menilai_siswa_nama';
			$query['select'][] = 'angket.jenis_penilaian';
		endif;
		return $query;
	}
	
	function browse($index, $limit) {
		$query = $this->query_1();
		$query = $this->filter_1($query);

		return $this->md->query($query)->resultset($index, $limit);
	}
	
	function rowset($id) {
		$query = $this->query_1();
		$query['where']['ljs.id'] = $id;

		return $this->md->query($query)->row();
	}

	function save() {
		$d = & $this->ci->d;

		if ($d['user']['role'] != 'siswa')
			return !alert_info('Simulasi berhasil, nilai tidak disimpan.');

		$start_dtm = (isset($d['form']['dtm_start'])) ? $d['form']['dtm_start'] : $d['date'];
		$durasi = (isset($d['form']['time_start'])) ? ($d['form']['time_start'] - $d['time']) : 7200;
		$ljs = array(
				'angket_id' => $d['angket']['id'],
				'user_id' => $d['user']['id'],
				'kelas_id' => (int) cfgu('kelas_id'),
				'trial' => $d['angket']['trial'],
				'waktu' => $start_dtm,
				'dikoreksi' => (($d['angket']['pilihan_jml'] > 1) ? $d['datetime'] : NULL),
				'nilai' => 0,
				'poin' => 0,
				'poin_max' => 0,
				'durasi' => $durasi,
				'ip' => $this->input->ip_address(),
				'client' => client_agent(),
		);
		$jawaban_array = array();
		
		$opsi_array = array('a','b','c','d','e');
		
		$ljs['poin_max'] = 0;
		foreach ($d['soal_result']['data'] as $soal):
			//soal_prepare($soal);
			soal_angket_prepare($soal);
			$name = "butir-{$soal['id']}";
			
			$_raw = array('soal_id' => $soal['id']);
			$_jwb = (string) $this->input->post($name);

			if ($ljs['dikoreksi']):
				$_jwb = trim($_jwb);
				$pilihan_valid = (strlen($_jwb) == 1);
				$_raw['pilihan'] = ($pilihan_valid) ? $_jwb : '';
				
				$opsi_loop	= 0;
				$opsi_value = 0;
				$poin_max	= 0;
				$temp = $soal['pilihan']['pengecoh'];
				foreach ($temp as $temp2):
					if($_jwb==$opsi_array[$opsi_loop])
					{$opsi_value=$opsi_loop+1;}
					//$opsi_jwb = $opsi_array[$opsi_loop];
					$opsi_loop++;
					if($poin_max<$soal['poin_'.$opsi_loop]){
						$poin_max = $soal['poin_'.$opsi_loop];
					}
				endforeach;
				$ljs['poin_max'] += $poin_max ;
				$_raw['poin'] = $soal['poin_'.$opsi_value];
				$ljs['poin'] += $_raw['poin'];
				
				/*$_jwb = trim($_jwb);
				$pilihan_valid = (strlen($_jwb) == 1);
				$kunci = array_node($soal, 'pilihan', 'kunci', 'index');
				$_raw['pilihan'] = ($pilihan_valid) ? $_jwb : '';
				$_raw['poin'] = ($_raw['pilihan'] == $kunci) ? $soal['poin_max'] : 0;
				$ljs['poin'] += $_raw['poin'];
				*/
			else:
				$_jwb = (string) clean_html($_jwb);
				$_raw['jawaban'] = base64_encode($_jwb);

			endif;

			$jawaban_array[] = $_raw;

		endforeach;

		if ($ljs['dikoreksi']):
			$ljs['nilai'] = 100 * $ljs['poin'] / $ljs['poin_max'];
		endif;

		$nilai = array(
				'angket_terkoreksi' => (bool) $ljs['dikoreksi'],
				'angket_nilai' => $ljs['nilai'],
				'angket_poin' => $ljs['poin'],
				'angket_poin_max' => $ljs['poin_max'],
				'angket_durasi' => $durasi,
				'ljs_last' => $d['datetime'],
				'ljs_count' => ++$d['angket']['ljs_count'],
		);
		
		//return !alert_info($_raw['pilihan']." x1 ".$_raw['poin']." x2 ".$ljs['poin']." x3 ".$ljs['poin_max']." x4 ".$ljs['nilai']." x5 ".$_jwb." x6 ".$opsi_value." x7 ".$opsi_loop);
		
		$this->db->trans_start();
		$this->db->insert('kbm_angket_ljs', $ljs);

		$ljs['id'] = $this->db->insert_id();
		$nilai['ljs_id'] = $ljs['id'];

		foreach (array_keys($jawaban_array) as $i)
			$jawaban_array[$i]['ljs_id'] = $ljs['id'];

		$this->db->insert_batch('kbm_angket_jawaban', $jawaban_array);
		$this->db->update('kbm_angket_nilai', $nilai, array('id' => $d['angket']['nilai_id']));

		if ($ljs['dikoreksi']):
			$this->update_nilai($d['angket']['id']);
		else:
			$this->update_pengerjaan($d['angket']['id']);
		endif;

		$msg_sukses = ($ljs['dikoreksi']) ? 'Jawaban dan nilai berhasil disimpan.' : 'Jawaban telah disimpan, menunggu koreksi guru.';

		return $this->trans_done($msg_sukses, 'Database error, coba beberapa saat lagi.');
		
	}

	function save_koreksi() {
		$d = & $this->ci->d;
		$poin = 0;
		$poin_max = 0;
		$no = 0;
		$jwb_dat = array();

		foreach ($d['butir_result']['data'] as $butir):
			//soal_prepare($butir);
			soal_angket_prepare($butir);
			
			$no++;
			$_input = "poin-{$butir['id']}";
			$_poin = (int) ($this->input->post($_input));
			$poin_max += $butir['poin_max'];
			$poin += $_poin;

			if ($_poin < $butir['poin_min'] OR $_poin > $butir['poin_max']):
				alert_error("Poin jawaban pertanyaan {$no} harus antara {$butir['poin_min']} sampai {$butir['poin_max']}");
				continue;
			endif;

			$jwb_dat[] = array(
					'where' => array(
							'ljs_id' => $d['row']['id'],
							'soal_id' => $butir['id'],
					),
					'data' => array(
							'poin' => $_poin,
					),
			);

		endforeach;

		if ($d['error'])
			return FALSE;

		// mulai simpan poin

		$ljs = array(
				'dikoreksi' => $d['datetime'],
				'poin' => $poin,
				'poin_max' => $poin_max,
				'nilai' => (100 * $poin / $poin_max),
		);

		$nilai = array(
				'angket_terkoreksi' => TRUE,
				'angket_nilai' => $ljs['nilai'],
				'angket_poin' => $poin,
				'angket_poin_max' => $poin_max,
		);

		$this->db->trans_start();
		$this->db->update('kbm_angket_ljs', $ljs, array('id' => $d['row']['id']));
		$this->db->update('kbm_angket_nilai', $nilai, array('ljs_id' => $d['row']['id']));

		foreach ($jwb_dat as $dat):
			$this->db->update('kbm_angket_jawaban', $dat['data'], $dat['where']);
		endforeach;

		$trx = $this->trans_done('Nilai berhasil disimpan.', 'Database error, coba beberapa saat lagi.');

		if ($trx):
			$this->db->trans_start();
			$this->update_nilai($d['angket']['id']);
			$this->trans_done();
		endif;

		return $trx;
	}
	
	function butir_ljs($ljs_id) {
		$query = array(
				'from' => 'kbm_angket_soal soal',
				'join' => array(
						array('kbm_angket_jawaban jwb', 'soal.id = jwb.soal_id', 'inner'),
				),
				'where' => array(
						'jwb.ljs_id' => $ljs_id,
				),
				'select' => array(
						'soal.*',
						'jwb_poin' => 'jwb.poin',
						'jwb_pilihan' => 'jwb.pilihan',
						'jwb_jawaban' => 'jwb.jawaban',
				),
				'order_by' => 'soal.id',
		);

		return $this->md->query($query)->result();
	}
	function soal($angket) {
		$query = array(
				'from' => 'kbm_angket_soal',
				'where' => array(
						'angket_id' => $angket['id'],
				),
		);

		$randomize_indexed = ($angket['soal_acak'] && $angket['soal_jml'] > 0 && $angket['soal_total'] > $angket['soal_jml']);

		if ($randomize_indexed)
			$query['order_by'] = 'hit_count, rand()';

		else if ($angket['soal_acak'])
			$query['order_by'] = 'rand()';

		if ($angket['soal_jml'] > 0)
			$query['limit'] = $angket['soal_jml'];

		$result = $this->md->query($query)->result();

		if (!$randomize_indexed OR $result['selected_rows'] == 0)
			return $result;

		$soal_list = array();

		foreach ($result['data'] as $soal)
			$soal_list[] = $soal['id'];

		$list_string = implode(',', $soal_list);

		$sql = "update kbm_angket_soal set hit_count = hit_count + 1 where id in ({$list_string})";

		$this->db->query($sql);

		return $result;
	}
	
	function update_nilai($angket_id) {
		$sql_angket = "
update kbm_angket angket
inner join
(
	select
		angket_id,
		min(angket_poin) poin_min,
		max(angket_poin) poin_max,
		avg(angket_poin) rata2_poin,
		avg(angket_nilai) rata2_nilai,
		count(id) siswa_total,
		count(ljs_id) siswa_menjawab
	from kbm_angket_nilai
	where trial = 0
		and angket_id = ?
	group by angket_id
)	nilai
	on angket.id = nilai.angket_id
set
	angket.poin_min = nilai.poin_min,
	angket.poin_max = nilai.poin_max,
	angket.rata2_poin = nilai.rata2_poin,
	angket.rata2_nilai = nilai.rata2_nilai,
	angket.siswa_total = nilai.siswa_total,
	angket.siswa_menjawab = nilai.siswa_menjawab,
	angket.analisa_valid = 0
where
	angket.id = ?";
		$sql_evakls = "
update kbm_angket_kelas evakls
inner join
(
	select
		angket_id,
		kelas_id,
		avg(angket_nilai) rata2_nilai,
		count(id) siswa_total,
		count(ljs_id) siswa_menjawab
	from kbm_angket_nilai
	where trial = 0
		and kelas_id is not null
		and angket_id = ?
	group by angket_id, kelas_id
) nilai
	on evakls.angket_id = nilai.angket_id and evakls.kelas_id = nilai.kelas_id
set
	evakls.rata2_nilai = nilai.rata2_nilai,
	evakls.siswa_total = nilai.siswa_total,
	evakls.siswa_menjawab = nilai.siswa_menjawab
where evakls.angket_id = ?";

		$this->db->query($sql_evakls, array($angket_id, $angket_id));
		$this->db->query($sql_angket, array($angket_id, $angket_id));
	}
	
	function update_pengerjaan($angket_id) {
		$sql_angket = "
update kbm_angket angket
inner join
(
	select
		angket_id,
		count(id) siswa_total,
		count(ljs_id) siswa_menjawab
	from kbm_angket_nilai
	where trial = 0
		and angket_id = ?
	group by angket_id
)	nilai
	on angket.id = nilai.angket_id
set
	angket.siswa_total = nilai.siswa_total,
	angket.siswa_menjawab = nilai.siswa_menjawab
where
	angket.id = ?";
		$sql_evakls = "
update kbm_angket_kelas evakls
inner join
(
	select
		angket_id,
		kelas_id,
		count(id) siswa_total,
		count(ljs_id) siswa_menjawab
	from kbm_angket_nilai
	where trial = 0
		and kelas_id is not null
		and angket_id = ?
	group by angket_id, kelas_id
) nilai
	on evakls.angket_id = nilai.angket_id and evakls.kelas_id = nilai.kelas_id
set
	evakls.siswa_total = nilai.siswa_total,
	evakls.siswa_menjawab = nilai.siswa_menjawab
where evakls.angket_id = ?";

		$this->db->query($sql_evakls, array($angket_id, $angket_id));
		$this->db->query($sql_angket, array($angket_id, $angket_id));
	}
	
	
}