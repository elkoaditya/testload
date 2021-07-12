<?php

class M_kbm_angket extends MY_Model {

	public function __construct() {
		parent::__construct(array(
				//'fields-umum' => array('nama', 'kkm'),
				'fields-umum' => array('nama',  'jml_menilai_siswa', 'jarak_absen'),
				'fields-pelajaran' => array('pelajaran_id'),
				'fields-bentuk' => array('pilihan_jml'),
				//'fields-aturan' => array('tipe', 'soal_jml', 'soal_acak', 'ljs_max'),
				'fields-aturan' => array('jenis_penilaian','urutan', 'soal_jml', 'soal_acak', 'ljs_max'),
				'fields-tutupan' => array('show_rank', 'show_kunci'),
		));
		$this->dm['admin'] = cfguc_admin('akses', 'kbm', 'evaluasi');
		$this->dm['view'] = cfguc_view('akses', 'kbm', 'evaluasi');
		$this->dm['mengajar_list'] = (array) cfgu('mengajar_list');
		$this->dm['pelajaran_list'] = (array) cfgu('pelajaran_list');
	}

	// dasar database

	function filter_1($query) {
		$d = & $this->ci->d;
		$r = & $this->ci->d['request'];
		$def = array(
				'term' => '',
				'semester_id' => $d['semaktif']['id'],
				'pelajaran_id' => 0,
				'mapel_id' => 0,
				'author_id' => 0,
		);

		// normalisasi

		array_default($r, $def);

		if ($r['semester_id'] == 0)
			$r['semester_id'] = $d['semaktif']['id'];

		// filtering

		if (!empty($r['term']))
			$query['like'] = array($r['term'], array('author.nama', 'angket.nama'));

		if ($r['semester_id'] > 0)
			$query['where']['angket.semester_id'] = $r['semester_id'];

		if ($r['pelajaran_id'] > 0)
			$query['where']['angket.pelajaran_id'] = $r['pelajaran_id'];

		if ($r['mapel_id'] > 0)
			$query['where']['angket.mapel_id'] = $r['mapel_id'];

		if ($r['author_id'] > 0 && $d['user']['role'] == 'admin')
			$query['where']['angket.author_id'] = $r['author_id'];

		return $query;
	}

	function query_1() {
		$d = & $this->ci->d;
		$dm = & $this->dm;
		$query = array(
				'from' => 'kbm_angket angket',
				'join' => array(
						array('prd_semester semester', 'angket.semester_id = semester.id', 'inner'),
						array('prd_ta ta', 'semester.ta_id = ta.id', 'inner'),
						array('dprofil_sdm author', 'angket.author_id = author.id', 'left'),
						array('dakd_pelajaran pelajaran', 'angket.pelajaran_id = pelajaran.id', 'inner'),
						array('dakd_mapel mapel', 'pelajaran.mapel_id = mapel.id', 'inner'),
						array('dmst_kolom_nilai nilai_kolom', 'angket.nilai_kolom_id = nilai_kolom.id', 'left')
				),
				'order_by' => 'angket.semester_id desc, pelajaran.nama, angket.tipe desc',
				'select' => array(
						'angket.*',
						'semester_nama' => 'semester.nama',
						'ta_nama' => 'ta.nama',
						'author_nama' => "trim(concat_ws(' ', author.prefix, author.nama, author.suffix))",
						'pelajaran_nama' => 'pelajaran.nama',
						'pelajaran_kode' => 'pelajaran.kode',
						'mapel_nama' => 'mapel.nama',
						'pelajaran.mapel_id',
						'nilai_kolom_kode' => 'nilai_kolom.kode',
				),
		);

		// filter akses

		if ($d['user']['role'] == 'siswa'):
			$query['join'][] = array('kbm_angket_nilai nilai', 'angket.id = nilai.angket_id', 'inner');
			$query['join'][] = array('dprofil_siswa menilai_siswa', 'menilai_siswa.id = nilai.menilai_user_id', 'inner');
			$query['join'][] = array('dprofil_siswa menilai_siswa2', 'menilai_siswa2.id = nilai.user_id', 'inner');
			$query['where']['nilai.user_id'] = $d['user']['id'];
			if($d['user']['menilai_id']!=0)
			{	$query['where']['nilai.menilai_user_id'] = $d['user']['menilai_id'];	}
			$query['select']['nilai_id'] = 'nilai.id';
			$query['select'][] = 'nilai.kelas_id';
			$query['select'][] = 'nilai.trial';
			$query['select'][] = 'nilai.angket_terkoreksi';
			$query['select'][] = 'nilai.angket_nilai';
			$query['select'][] = 'nilai.ljs_id';
			$query['select'][] = 'nilai.ljs_count';
			$query['select'][] = 'nilai.ljs_last';
			$query['select'][] = 'nilai.user_id';
			$query['select'][] = 'nilai.menilai_user_id';
			$query['select'][] = 'menilai_siswa.nama as menilai_siswa_nama';
			$query['select'][] = 'menilai_siswa2.nama as siswa_nama';

		elseif (!$dm['view'] && $dm['mengajar_list']):
			$query['where_in']['angket.pelajaran_id'] = $dm['mengajar_list'];

		elseif (!$dm['view']):
			$query['where']['angket.author_id'] = $d['user']['id'];

		endif;

		if (!$dm['admin'])
			$query['where']['angket.status !='] = 'deleted';

		return $query;
	}
	
	// operasi data

	/*
	 * fungsi untuk menganalisa butir soal dan mengelompokan nilai siswa ke golongan: atas,tengah,bawah
	 * algoritma umum:
	 * - hanya khusus admin atau author yg bis. dan bila memang ada parameter analisa
	 * - status angket sudah dipublish
	 * - cek jml peserta yg mengerjakan, minimal harus 3
	 * - jika analisa sebelumnya masi valid kembali
	 * -- cek ljs yg munkin belum dikoreksi. bila ada, pending dulu, perintahkan u/ koreksi
	 * --> pengelompokan atas/tengah/bawah
	 * --> analisa butir soal
	 */

	function analisa_cek() {
		$d = & $this->ci->d;
		$analisa_cek = $this->input->get_post('analisa');
		$grants = ($d['admin'] OR $d['author_ybs']);
		$angket_id = (int) $d['row']['id'];

		if (!$analisa_cek OR !$grants)
			return;

		if (!in_array($d['row']['status'], array('published')))
			return alert_info('Angket masih berupa draft, belum selesai disusun.');

		if ($d['row']['siswa_menjawab'] < 3)
			return alert_info('Peserta angket yg mengerjakan masih dibawah 3.');

		if ($d['row']['analisa_valid'])
			return alert_info('Analisa angket masih valid.');

		// cek ljs yg belum dikoreksi

		$sql_nonkoreksi = "select count(*) jml from kbm_angket_nilai where angket_id = ? and ljs_id is not null and angket_terkoreksi = 0 and trial = 0";
		$jml_nonkoreksi = (int) $this->md->row_col('jml', $sql_nonkoreksi, array($angket_id));

		if ($jml_nonkoreksi > 0)
			return alert_error("Masih ada {$jml_nonkoreksi} LJS yang belum dikoreksi.");

		// mulai pengelompokan

		$trx = $this->analisa_grouping($angket_id);

		if (!$trx)
			return alert_error('Analisa error saat mengelompokkan nilai peserta.', FALSE);

		$trx = $this->analisa_soal($angket_id, $d['row']['siswa_total']);

		if ($trx)
			return alert_info('Analisa butir soal selesai.');

		return alert_error('Analisa error saat mengelompokkan nilai peserta.', FALSE);
	}
	
	function availability($row, $alert = FALSE) {
		$dm = & $this->dm;
		$d = & $this->ci->d;
		$u = & $this->ci->d['user'];

		// mutlak, pencegah error

		if ($row['soal_total'] == 0)
			return (!$alert) ? FALSE : alert_error('Butir soal angket tidak ditemukan.');

		// guru/admin trial

		$d['pengajar_ybs'] = mengajar($row['pelajaran_id']);
		$d['author_ybs'] = ($u['id'] == $row['author_id']);

		if ($u['role'] != 'siswa' && ($dm['view'] OR $d['pengajar_ybs'] OR $d['author_ybs']))
			return TRUE;

		// ngecek isi angket itu sendiri

		if (!$row['published'])
			return (!$alert) ? FALSE : alert_error('Angket ini belum dipublikasikan.');

		if ($row['closed'])
			return (!$alert) ? FALSE : alert_error('Angket tersebut telah ditutup.');

		if ($d['semaktif']['id'] != $row['semester_id'])
			return (!$alert) ? FALSE : alert_error('Angket tersebut tidak berlaku lagi.');

		// cek usernya (siswa)

		if (!isset($row['ljs_count']) OR !isset($row['angket_terkoreksi']) OR !isset($row['kelas_list']) OR !isset($row['kelas_result']))
			return (!$alert) ? FALSE : alert_error('Data angket error.');

		if ($row['ljs_max'] > 0 && $row['ljs_max'] <= $row['ljs_count'])
			return (!$alert) ? FALSE : alert_error('Anda telah menggunakan semua kesempatan untuk menjawab.');

		if ($row['ljs_id'] && !$row['angket_terkoreksi'])
			return (!$alert) ? FALSE : alert_error('Jawaban sebelumnya belum dikoreksi.');

		if (!in_array($row['kelas_id'], $row['kelas_list']))
			return (!$alert) ? FALSE : alert_error('Kelas Anda tidak termasuk dalam angket ini.');

		$kelas = $row['kelas_result']['data'][$row['kelas_id']];

		if ($kelas['angket_mulai'] && $kelas['angket_mulai'] > $d['datetime'])
			return (!$alert) ? FALSE : alert_error('Angket tersebut belum dimulai.');

		if ($kelas['angket_ditutup'] && $kelas['angket_ditutup'] < $d['datetime'])
			return (!$alert) ? FALSE : alert_error('Angket tersebut telah selesai.');

		return TRUE;
	}
	
	function browse($index = 0, $limit = 20) {
		$query = $this->query_1();
		$query = $this->filter_1($query);

		return $this->md->query($query)->resultset($index, $limit);
	}
	
	function rowset($id) {
		$d = & $this->ci->d;
		$query = $this->query_1();
		$query['where']['angket.id'] = $id;
		$row = $this->md->query($query)->row();
		$query_kelas = array(
				'select' => array(
						'evakls.*',
						'kelas_nama' => 'kelas.nama',
				),
				'from' => 'kbm_angket_kelas evakls',
				'join' => array(
						array('dakd_kelas kelas', 'evakls.kelas_id = kelas.id', 'inner'),
				),
				'order_by' => 'kelas.grade, kelas.jurusan_id, kelas.nama',
				'where' => array(
						'evakls.angket_id' => $id,
				),
		);

		if (!$row)
			return FALSE;

		if ($row['konten'])
			$row['konten'] = base64_decode($row['konten']);

		// data kelas

		$row['kelas_result'] = $this->md->query($query_kelas)->result();
		$row['kelas_list'] = array();
		$row['kelas'] = NULL;

		if ($row['kelas_result']['selected_rows'] > 0):
			$kdata = array();

			foreach ($row['kelas_result']['data'] as $ekls):
				$kid = (int) $ekls['kelas_id'];
				$row['kelas_list'][] = $kid;
				$kdata[$kid] = $ekls;
			endforeach;

			$row['kelas_result']['data'] = $kdata;

		endif;

		if ($d['user']['role'] == 'siswa'):
			$kid = (int) (isset($row['kelas_id'])) ? $row['kelas_id'] : 0;

			if (isset($row['kelas_result']['data'][$kid]))
				$row['kelas'] = $row['kelas_result']['data'][$kid];

		endif;

		// output

		return $row;
	}
	
	function save() {
		
		$d = & $this->ci->d;
		$edit = (bool) $d['form']['id'];
		$msg_sukses = "Angket berhasil disimpan.";
		$kelas_jadwal = NULL;
		$angket_id = $d['form']['id'];
		$pelajaran_nilai_id = $d['row']['pelajaran_nilai_id'];

		if ($d['modit']['aturan'])
			$this->form->ruleset($d['row'], 'validasi-aturan');

		if ($d['modit']['pelajaran'])
			$this->form->ruleset($d['row'], 'validasi-pelajaran');

		if ($d['modit']['bentuk'])
			$this->form->ruleset($d['row'], 'validasi-bentuk');

		if ($d['modit']['tutupan'])
			$this->form->ruleset($d['row'], 'validasi-tutupan');

		$this->form->ruleset($d['row'], 'validasi-umum');
		$this->form->validate();
		
		if ($d['error'])
			return FALSE;

		$data = $this->input('fields-umum');
		$data['updated'] = $d['datetime'];
		
		if ($d['modit']['tutupan'])
			$data = $this->input('fields-tutupan', $data);

		if ($d['modit']['aturan'])
			$data = $this->input('fields-aturan', $data);

		if ($d['modit']['bentuk'])
			$data = $this->input('fields-bentuk', $data);
		
		if ($d['modit']['pelajaran']):
			$data = $this->input('fields-pelajaran', $data);
			$mengajar = mengajar($data['pelajaran_id']);

			if (!$mengajar && !$this->dm['admin'])
				return alert_error("Anda tidak sedang mengampu pelajaran tersebut.");

			// cek pelajaran_nilai_id

			$npel = $this->data_npelajaran($data['pelajaran_id']);

			if (!$npel)
				return alert_error("Kesalahan! Data riwayat semester pelajaran tidak ditemukan.");

			$data['pelajaran_nilai_id'] = $npel['id'];
			$pelajaran_nilai_id = $npel['id'];

		endif;
		
		$kelas_jadwal = $this->input_jadwal($pelajaran_nilai_id);
		
		if (empty($kelas_jadwal))
			alert_error('Jadwal kelas harus diisi.');
		
		if ($d['error'])
			return FALSE;
		
		// mulai proses penyimpanan
		
		$this->db->trans_start();

		if (!$edit):

			// siapkan data

			$data['semester_id'] = $d['semaktif']['id'];
			$data['author_id'] = $d['user']['id'];
			$data['registered'] = $d['datetime'];

			// prosesi insert

			$this->db->insert('kbm_angket', $data);

			// id baru ditampung di tabel terpisah dulu biar gak konflik saat error

			$angket_id = $this->db->insert_id();
			$trx_status = $this->db->trans_status();

			if (!$trx_status OR !$angket_id)
				return $this->trans_rollback('Database error saat menyimpan angket baru, coba beberapa saat lagi.');

			// insert berhasil

			$data = array();
			$msg_sukses = "Angket baru berhasil ditambahkan.";

		endif;

		// hapus data jadwal sebelumnya

		if ($edit)
			$this->db->delete('kbm_angket_kelas', array('angket_id' => $angket_id));

		// entri jadwal baru

		$klsjadwal_array = array();

		foreach ($kelas_jadwal as $kid => $jadwal):
			$jadwal['kelas_id'] = $kid;
			$jadwal['angket_id'] = $angket_id;
			$klsjadwal_array[] = $jadwal;

		endforeach;

		//alert_dump($klsjadwal_array);

		if ($klsjadwal_array):
			$this->db->insert_batch('kbm_angket_kelas', $klsjadwal_array);
		endif;

		// perubahan data

		if (!empty($data)):

			$this->db->update('kbm_angket', $data, array('id' => $angket_id));

			if ($edit)
				$msg_sukses = 'Data angket berhasil disimpan.';

		endif;

		// selesai

		$trx = $this->trans_done($msg_sukses, 'Database error, coba beberapa saat lagi.');

		if ($trx && !$edit)
			$d['form']['id'] = $angket_id;

		return $trx;
	}
	
	// input jadwal
	
	function data_npelajaran($pelajaran_id) {
		$d = & $this->ci->d;
		$query = array(
				'from' => 'nilai_pelajaran',
				'where' => array(
						'pelajaran_id' => $pelajaran_id,
						'semester_id' => $d['semaktif']['id'],
				),
		);

		return $this->md->query($query)->row();
	}

	function data_kelas($npel_id) {

		// cek data kelas peserta angket

		$query = array(
				'from' => 'dakd_kelas kelas',
				'join' => array(
						array('nilai_pelajaran_kelas npelkls', 'kelas.id = npelkls.kelas_id', 'inner'),
				),
				'where' => array(
						'npelkls.pelajaran_nilai_id' => $npel_id,
				),
				'select' => array('kelas.id', 'kelas.nama'),
		);

		return $this->md->query($query)->result_series('id', 'nama');
	}

	function input_jadwal($npel_id) {

		$kelas_list = $this->data_kelas($npel_id);

		if (empty($kelas_list))
			return alert_error("Kesalahan! Daftar kelas pelajaran tidak ditemukan.");

		// cek input jadwal

		$angket_mulai = (array) $this->input->post('angket_mulai');
		$angket_ditutup = (array) $this->input->post('angket_ditutup');
		$kelas_jadwal = array();

		foreach ($kelas_list as $kid => $knama):
			$_jadwal = array(
					'angket_mulai' => datefix(array_node($angket_mulai, $kid)),
					'angket_ditutup' => datefix(array_node($angket_ditutup, $kid)),
			);

			if (!$_jadwal['angket_mulai']):
				alert_error("Waktu mulai kelas {$knama} harus diisi dengan format tanggal-jam yang benar. format: yyyy-mm-dd.");
				continue;
			endif;

			if ($_jadwal['angket_mulai'] && $_jadwal['angket_ditutup'] && $_jadwal['angket_mulai'] >= $_jadwal['angket_ditutup']):
				alert_error("Waktu selesai kelas {$knama} salah, harus sesudah dimulai.");
				continue;
			endif;

			$kelas_jadwal[$kid] = $_jadwal;

		endforeach;

		return $kelas_jadwal;
	}
	
	function publish() {
		/*
		 * overview:
		 * - ambil data siswa peserta pelajaran saat ini.
		 * - update publish data angket.
		 * - insert entry nilai [kbm_angket_nilai] untuk tiap siswa
		 *
		 * * tunggu semua nilai masuk sebelum update nilai rata2 masing2
		 */

		$d = & $this->ci->d;
		
		$angket_id = (int) $d['form']['id'];
		$angket_jenis_penilaian = $d['row']['jenis_penilaian'];
		$pelajaran_nilai_id = (int) $d['row']['pelajaran_nilai_id'];
		
		///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		//tambahan order by
		$query_siswa = array(
				'order_by' => 'nilsis.kelas_id,nilsis.siswa_id',
				'from' => 'nilai_siswa nilsis',
				'join' => array(
						array('nilai_siswa_pelajaran nisispel', 'nilsis.id = nisispel.siswa_nilai_id', 'inner'),
				),
				'where' => array(
						'nisispel.pelajaran_nilai_id' => $pelajaran_nilai_id,
				),
				'select' => array('nilsis.siswa_id', 'nilsis.kelas_id'),
				
		);
		$peserta_result = $this->md->query($query_siswa)->result();

		if ($peserta_result['selected_rows'] == 0)
			return alert_error('Kesalahan! Siswa peserta pelajaran tak dapat diketahui.');

		// ambil nilai_pelajaran

		$nilai_pel = $this->md->rowset($pelajaran_nilai_id, 'nilai_pelajaran');

		if (!$nilai_pel)
			return alert_error('Kesalahan! Daftar nilai pelajaran tak dapat diketahui.');

		// siapkan bat entry nilai

		$evanil_array = array();
		
		if($angket_jenis_penilaian=='penilaian_diri')
		{
			foreach ($peserta_result['data'] as $peserta):
				$evanil_array[] = array(
						'user_id' => $peserta['siswa_id'],
						'menilai_user_id' => $peserta['siswa_id'],
						'trial' => 0,
						'kelas_id' => $peserta['kelas_id'],
						'angket_id' => $angket_id,
				);
			endforeach;
		}
		elseif($angket_jenis_penilaian=='penilaian_sejawat')
		{
			/*
			foreach ($peserta_result['data'] as $peserta):
				$evanil_array[] = array(
						'user_id' => $peserta['siswa_id'],
						'menilai_user_id' => $peserta['siswa_id'],
						'trial' => 0,
						'kelas_id' => $peserta['kelas_id'],
						'angket_id' => $angket_id,
				);
			endforeach;
			*/
			$jml_menilai_siswa	= $d['row']['jml_menilai_siswa'];
			$jarak_absen		= $d['row']['jarak_absen'];
			if($jml_menilai_siswa==0)
			{	$semua_siswa = 1;	}
			else
			{	$semua_siswa = 0;	}
			
			$temp = $peserta_result['data'];
			$no_kelas=0;
			$no_peserta=1;
			$data_kelas[$no_kelas]=0;
			foreach ($peserta_result['data'] as $peserta):
				if($data_kelas[$no_kelas]!=$peserta['kelas_id'])
				{	
					$no_kelas++;
					$no_peserta							= 1;
					$jml_m_siswa_pkls[$no_kelas]		= 0;
					$data_kelas[$no_kelas] 				= $peserta['kelas_id'];	
				}
				if($semua_siswa==1)
				{	
					if($jml_menilai_siswa<$jml_m_siswa_pkls[$no_kelas])
					{	$jml_menilai_siswa	= $jml_m_siswa_pkls[$no_kelas];	}	
				}
				$jml_m_siswa_pkls[$no_kelas]++;
				$id_peserta[$no_kelas][$no_peserta] 	= $peserta['siswa_id'];
				$no_peserta++;
			endforeach;
			
			
			$batas_menilai	= 1;
			
			while($batas_menilai<=$jml_menilai_siswa)
			{
				$batas_kelas	= 1;
				$temp2 = $temp;
				$jarak_peserta = $jarak_absen;
				foreach ($temp2 as $peserta):
					$jarak_peserta++;
					if($data_kelas[$batas_kelas] != $peserta['kelas_id'])
					{	
						$batas_kelas++;
						$jarak_peserta = $jarak_absen;
						$jarak_peserta++;
					}
					if($jarak_peserta > $jml_m_siswa_pkls[$batas_kelas])
					{	$jarak_peserta = $jarak_peserta - $jml_m_siswa_pkls[$batas_kelas];	}	
					if($batas_menilai<$jml_m_siswa_pkls[$batas_kelas])
					{
						$evanil_array[] = array(
								'user_id' => $peserta['siswa_id'],
								'menilai_user_id' => $id_peserta[$batas_kelas][$jarak_peserta],
								'trial' => 0,
								'kelas_id' => $peserta['kelas_id'],
								'angket_id' => $angket_id,
						);
						
					}
				endforeach;
				$batas_menilai++;
				$jarak_absen++;
				
			}
			
		}
		

		// data update angket

		$angket_upd = array(
				'status' => 'published',
				'published' => $d['datetime'],
				'siswa_total' => $peserta_result['selected_rows'],
		);

		// update status angket

		$this->db->trans_start();
		$this->db->update('kbm_angket', $angket_upd, array('id' => $angket_id));
		$this->db->insert_batch('kbm_angket_nilai', $evanil_array);

		$trx = $this->trans_done("Angket berhasil dipublikasikan ke {$peserta_result['selected_rows']} siswa.", 'Database error, coba beberapa saat lagi.');

		if ($trx):
			$this->db->trans_start();
			$this->m_kbm_angket_ljs->update_pengerjaan($angket_id);
			$this->trans_done();
		endif;

		return $trx;
	}

	function tutup() {
		/*
		 * overview:
		 * - ambil data siswa peserta pelajaran saat ini.
		 * - update publish data angket.
		 * - insert entry nilai [kbm_angket_nilai] untuk tiap siswa
		 *
		 * * tunggu semua nilai masuk sebelum update nilai rata2 masing2
		 */

		$d = & $this->ci->d;
		$angket_id = (int) $d['form']['id'];

		// data update angket

		$angket_upd = array(
				'status' => 'closed',
				'closed' => $d['datetime'],
		);

		// update status angket

		$this->db->trans_start();
		$this->db->update('kbm_angket', $angket_upd, array('id' => $angket_id));

		// fu: analisa angket??

		return $this->trans_done("Angket berhasil ditutup.", 'Database error, coba beberapa saat lagi.');
	}
	
	function delete() {
		/*
		 * overview:
		 * - ambil data siswa peserta pelajaran saat ini.
		 * - update publish data angket.
		 * - insert entry nilai [kbm_angket_nilai] untuk tiap siswa
		 *
		 * * tunggu semua nilai masuk sebelum update nilai rata2 masing2
		 */

		$d = & $this->ci->d;
		$angket_id = (int) $d['form']['id'];

		// data update angket

		$angket_upd = array(
				'status' => 'deleted',
				'updated' => $d['datetime'],
				'editor_id' => $d['user']['id'],
		);

		// update status angket

		$this->db->trans_start();
		$this->db->update('kbm_angket', $angket_upd, array('id' => $angket_id));

		// fu: analisa angket??

		return $this->trans_done("Angket berhasil dihapus.", 'Database error, coba beberapa saat lagi.');
	}
	
	function rekap() {
		$this->load->helper('costumized/' . APP_SCOPE);
		$this->load->model('m_nilai_siswa');
		$this->load->model('m_nilai_pelajaran');
		$this->load->model('m_nilai_pelajaran_kelas');

		$d = & $this->ci->d;
		$evaluasi_id = (int) $d['row']['id'];
		$semester_id = (int) $d['row']['semester_id'];
		$pelajaran_nilai_id = (int) $d['row']['pelajaran_nilai_id'];
		$kolom = $this->input->post('kolom');

		// cek kolom yg dipilih sesuai pilihan tersedia tidak.?

		//if (!array_key_exists($kolom, $d['kolom_list']))
		///	return alert_error("Kolom yang dipilih tidak ada.");

		// mulai memindah nilai
		// params: semester_id, nipel_id, eval_id
		return alert_error("Kolom yang dipilih tidak ada.");
		//return FALSE;
/*
		$sql_rekapan = "
update nilai_siswa_pelajaran nisispel
inner join nilai_siswa nisis on nisis.id = nisispel.siswa_nilai_id and nisis.semester_id = ?
inner join kbm_evaluasi_nilai evanil on evanil.user_id = nisis.siswa_id

set
	nisispel.{$kolom} = evanil.evaluasi_nilai,
	nisispel.valid = 0

where nisispel.pelajaran_nilai_id = ?
  and evanil.trial = 0 and evanil.evaluasi_id = ?
				";

		$this->db->trans_begin();
		$this->db->query($sql_rekapan, array($semester_id, $pelajaran_nilai_id, $evaluasi_id));
		$this->trans_done("Nilai evaluasi berhasil direkap.", "Database error saat merekap nilai evaluasi.");

		if ($d['error'])
			return FALSE;

		// ambil rekap nilai pelajaran

		$nipel = $this->md->rowset($pelajaran_nilai_id, 'nilai_pelajaran');

		if (!$nipel)
			return alert_error("Rekap nilai pelajaran tidak ditemukan.");

		// buat nilai rapor/rerata u/ tiap nisispel

		$nisispel_query = array(
				'from' => 'nilai_siswa_pelajaran',
				'where' => array(
						'pelajaran_nilai_id' => $pelajaran_nilai_id,
						'valid' => 0,
				),
		);
		$nisispel_result = $this->md->query($nisispel_query)->result();

		if ($nisispel_result['selected_rows'] == 0)
			return alert_error("Daftar nilai siswa tidak ditemukan.");

		$update_batch = array();
		$nisis_list = array();

		foreach ($nisispel_result['data'] as $nisispel):

			// olah rekap nilai

			nisispel_rerata($nisispel, $nipel['kkm'], $nipel['teori'], $nipel['praktek']);

			// data nilai utama

			$nil = array(
					'id' => (int) $nisispel['id'],
					'valid' => 1,
					'diolah' => $d['datetime'],
					'nas_teori' => $nisispel['nas_teori'],
					'nas_praktek' => $nisispel['nas_praktek'],
					'nas_total' => $nisispel['nas_total'],
			);

			// nilai harian

			for ($i = 1; $i <= 40; $i++):
				$h = 'h' . $i;
				$nil[$h] = $nisispel[$h];

			endfor;

			$nisis_list[] = (int) $nisispel['siswa_nilai_id'];
			$update_batch[] = $nil;

		endforeach;

		$this->db->trans_begin();
		$this->db->update_batch('nilai_siswa_pelajaran', $update_batch, 'id');
		$this->trans_done("Nilai semester siswa berhasil diperbarui.", "Database error saat memperbarui nilai semester siswa.");

		if ($d['error'])
			return FALSE;

		// reset rerata siswa, pelajaran & kelas

		$this->m_nilai_siswa->reratareset_by_nipel($pelajaran_nilai_id);
		$this->m_nilai_pelajaran->reratareset_by_id($pelajaran_nilai_id);
		$this->m_nilai_pelajaran_kelas->reratareset_by_nipel($pelajaran_nilai_id);

		return TRUE;
	*/
	}
	
	function opsi_jadwal_kelas($full = FALSE) {
		$row = & $this->ci->d['row'];
		$d = & $this->ci->d;
		$dm = $this->dm;
		$dths = $d['dto']->format('Y-m-d 08:00');
		$xdat = array();
		$query = array(
				'from' => 'dakd_kelas kelas',
				'join' => array(
						array('nilai_pelajaran_kelas nilai_pelkls', 'kelas.id = nilai_pelkls.kelas_id', 'inner'),
				),
				'where' => array(
						'nilai_pelkls.semester_id' => $d['semaktif']['id'],
				),
				'order_by' => 'kelas.grade, kelas.nama',
				'select' => array(
						'kelas.id',
						'kelas.nama',
						'nilai_pelkls.pelajaran_id',
						'angket_mulai' => "'{$dths}'",
						'angket_ditutup' => "''",
				),
		);

		if ($row['id'] > 0):
			$subsql = "select * from kbm_angket_kelas where angket_id = {$row['id']}";
			$query['join'][] = array("({$subsql}) kbm_evakls", 'kelas.id = kbm_evakls.kelas_id', 'left');
			$query['select']['angket_mulai'] = "IFNULL(kbm_evakls.angket_mulai, '{$dths}')";
			$query['select']['angket_ditutup'] = "kbm_evakls.angket_ditutup";

		endif;

		if ($dm['mengajar_list'] && $full)
			$query['where_in']['nilai_pelkls.pelajaran_id'] = $dm['mengajar_list'];
		else
			$query['where']['nilai_pelkls.pelajaran_id'] = $row['pelajaran_id'];
		//exit_dump($query);
		$result = $this->md->query($query)->result();

		if ($result['selected_rows'] == 0)
			return NULL;

		foreach ($result['data'] as $item):
			$item['id'] = (int) $item['id'];

			if (!array_key_exists($item['id'], $xdat))
				$xdat[$item['id']] = $item;

			$xdat[$item['id']]['pelajaran_list'][] = (int) $item['pelajaran_id'];

		endforeach;

		return $xdat;
	}

	// kolom list di nisispel
	
	function kolom_nilai_list($_row) {

		$kolom_list = array();
		$kolom_list['actif']= array();
		$kolom_list['name']= array();
		$kategori_list = array(
				's3' => 'penilaian_sejawat',
				's2' => 'penilaian_diri',
		);

		// format: ulangan kd x

		foreach ($kategori_list as $kode => $kategori):
			
			$kolom = $kode;
			if($_row['jenis_penilaian']==$kategori)
			{
				$result = $kode;
			}
				
		endforeach;
		
		return $result;
	}
	
	function reuse($fromangket_id)
	{
		$d = & $this->ci->d;
		$semester_id = $d['semaktif']['id'];
		$newPelajaran_id = (int) $this->input->post('pelajaran_id');

		$this->db->trans_begin();

		/**
		 * mencari id nilai_pelajaran
		 */
		$sql_nilpel = <<<SQL

SELECT
	id,
	guru_id

FROM
	nilai_pelajaran

WHERE
	pelajaran_id = {$newPelajaran_id}
AND
	semester_id = {$semester_id}

ORDER BY
	id DESC

LIMIT
	1
;
SQL;

		if ($this->db->trans_status() === FALSE)
		{
			$this->db->trans_rollback();

			return alert_error("error saat menjalankan: <br/> {$sql_nilpel}");
		}

		$nilpel = $this->md->row($sql_nilpel);
		$pelajaran_nilai_id = $nilpel['id'];
		$author_id = $d['user']['id'];
		$sql_copy_angket = <<<SQL

INSERT INTO
	kbm_angket
	(
		jenis_penilaian, jml_menilai_siswa, jarak_absen, urutan,
		author_id, pelajaran_id, pelajaran_nilai_id, status, 
		semester_id, nama, tipe,  kkm, pilihan_jml, 
		soal_jml, soal_total, soal_acak, soal_bank, ljs_max, jadwal_perkelas, registered, updated
	)

SELECT
	jenis_penilaian, jml_menilai_siswa, jarak_absen, urutan,
	{$author_id}, {$newPelajaran_id}, {$pelajaran_nilai_id}, 'draft',
	{$semester_id}, nama, tipe,  kkm, pilihan_jml,
	soal_jml, soal_total, soal_acak, soal_bank, ljs_max, jadwal_perkelas, registered, updated

FROM
	kbm_angket

WHERE
	id = {$fromangket_id}
;

SQL;
		$this->db->query($sql_copy_angket);

		if ($this->db->trans_status() === FALSE)
		{
			$this->db->trans_rollback();

			return alert_error("error saat menjalankan: <br/> {$sql_copy_angket}");
		}

		$newangket_id = $this->db->insert_id();
		$sql_angket_kelas = <<<SQL

INSERT INTO
	kbm_angket_kelas
	(
		angket_id,
		kelas_id
	)

SELECT
	{$newangket_id},
	kelas_id

FROM
	nilai_pelajaran_kelas

WHERE
	pelajaran_nilai_id = {$pelajaran_nilai_id}
;

SQL;
		$this->db->query($sql_angket_kelas);

		if ($this->db->trans_status() === FALSE)
		{
			$this->db->trans_rollback();

			return alert_error("error saat menjalankan: <br/> {$sql_angket_kelas}");
		}

		$sql_butir_soal = <<<SQL

INSERT INTO
	kbm_angket_soal
	(
		angket_id,
		 pertanyaan, pilihan_ganda, poin_min, poin_max, pilihan, poin_1, poin_2, poin_3, poin_4, poin_5,
		 analisa_jml_atas, analisa_jml_bawah, analisa_index_tk, analisa_index_db, registered
	)

SELECT
	{$newangket_id},
	 pertanyaan, pilihan_ganda, poin_min, poin_max, pilihan, poin_1, poin_2, poin_3, poin_4, poin_5, 
	 analisa_jml_atas, analisa_jml_bawah, analisa_index_tk, analisa_index_db, registered

FROM
	kbm_angket_soal

WHERE
	angket_id = {$fromangket_id}
;

SQL;

		$this->db->query($sql_butir_soal);

		if ($this->db->trans_status() === FALSE)
		{
			$this->db->trans_rollback();

			return alert_error("error saat menjalankan: <br/> {$sql_butir_soal}");
		}
		else
		{
			$this->db->trans_commit();
		}

		return $newangket_id;

	}

}