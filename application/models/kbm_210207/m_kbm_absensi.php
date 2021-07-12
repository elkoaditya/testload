<?php

class M_kbm_absensi extends MY_Model
{
	var $filetypes = array('mp3','wma','ogg','m4a','mpeg','wav','webma');
	
	public function __construct()
	{
		parent::__construct(array(
			'fields-umum'		 => array('nama', 'kkm', 'jml_kd','plus_uraian'),
			'fields-pelajaran'	 => array('pelajaran_id'),
			'fields-bentuk'		 => array('pilihan_jml'),
			'fields-aturan'		 => array('tipe', 'metode', 'soal_jml', 'soal_acak', 'ljs_max'),
			'fields-tutupan'	 => array('show_rank', 'show_kunci'),
			'fields-uraian'		 => array('detail_uraian'),
		));
		$this->dm['admin'] = cfguc_admin('akses', 'kbm', 'absensi');
		$this->dm['view'] = cfguc_view('akses', 'kbm', 'absensi');
		$this->dm['mengajar_list'] = (array) cfgu('mengajar_list');
		$this->dm['pelajaran_list'] = (array) cfgu('pelajaran_list');

	}

	// dasar database

	function filter_1($query)
	{
		$d = & $this->ci->d;
		$r = & $this->ci->d['request'];
		$def = array(
			'term'			 => '',
			'semester_id'	 => $d['semaktif']['id'],
			'pelajaran_id'	 => 0,
			'mapel_id'		 => 0,
			'author_id'		 => 0,
		);

		// normalisasi

		array_default($r, $def);

		if ($r['semester_id'] == 0)
			$r['semester_id'] = $d['semaktif']['id'];

		// filtering

		if (!empty($r['term']))
			$query['like'] = array($r['term'], array('author.nama', 'absensi.nama'));

		if ($r['tglwaktu'] > 0)
		{
			$exptglwaktu = explode("-",$r['tglwaktu']);
			$tglwaktu = $exptglwaktu[2]."-".$exptglwaktu[1]."-".$exptglwaktu[0];
			$query['where_strings'] = 'absensi.published >= "'.$tglwaktu.' 00:00" '.
			'AND absensi.published <= "'.$tglwaktu.' 23:59"';
		}
		
		if ($r['semester_id'] > 0)
			$query['where']['absensi.semester_id'] = $r['semester_id'];

		if ($r['pelajaran_id'] > 0)
			$query['where']['absensi.pelajaran_id'] = $r['pelajaran_id'];

		if ($r['mapel_id'] > 0)
			$query['where']['absensi.mapel_id'] = $r['mapel_id'];

		if ($r['author_id'] > 0 && $d['user']['role'] == 'admin')
			$query['where']['absensi.author_id'] = $r['author_id'];
		
		// if (!empty($r['status']))
			// $query['where']['absensi.status'] = $r['status'];
		
		return $query;

	}

	function query_1()
	{
		$d = & $this->ci->d;
		$dm = & $this->dm;
		$query = array(
			'from'		 => 'kbm_absensi absensi',
			'join'		 => array(
				array('prd_semester semester', 'absensi.semester_id = semester.id', 'inner'),
				array('prd_ta ta', 'semester.ta_id = ta.id', 'inner'),
				array('dprofil_sdm author', 'absensi.author_id = author.id', 'left'),
				array('dakd_pelajaran pelajaran', 'absensi.pelajaran_id = pelajaran.id', 'inner'),
				array('dakd_mapel mapel', 'pelajaran.mapel_id = mapel.id', 'inner'),
				array('dakd_kategori_mapel kategori', 'pelajaran.kategori_id = kategori.id', 'inner'),
				array('dmst_kurikulum kurikulum', 'pelajaran.kurikulum_id = kurikulum.id', 'inner'),
				array('dmst_agama agama', 'pelajaran.agama_id = agama.id', 'left'),
				array('dmst_kolom_nilai nilai_kolom', 'absensi.nilai_kolom_id = nilai_kolom.id', 'left')
			),
			'order_by'	 => 'absensi.semester_id desc, pelajaran.nama, absensi.tipe desc',
			'select'	 => array(
				'absensi.*',
				'semester_nama'		 => 'semester.nama',
				'ta_nama'			 => 'ta.nama',
				'author_nama'		 => "trim(concat_ws(' ', author.prefix, author.nama, author.suffix))",
				'pelajaran_nama'	 => 'pelajaran.nama',
				'pelajaran_kode'	 => 'pelajaran.kode',
				'kurikulum_id'		 => 'kurikulum.id',
				'kurikulum_nama'	 => 'kurikulum.nama',
				'mapel_id'		 	 => 'mapel.id',
				'mapel_nama'		 => 'mapel.nama',
				'kategori_id'		 => 'kategori.id',
				'kategori_nama'		 => 'kategori.nama',
				'agama_nama'		 => 'agama.nama',
				'pelajaran.mapel_id',
				'pelajaran.kategori_id',
				'pelajaran.agama_id',
				'nilai_kolom_kode'	 => 'nilai_kolom.kode',
			),
		);
		// delete di hapus dari view
		// $query['where']['absensi.status !='] = 'deleted';
		
		// filter akses

		if ($d['user']['role'] == 'siswa'):
			$query['join'][] = array('kbm_absensi_nilai nilai', 'absensi.id = nilai.absensi_id', 'inner');
			$query['join'][] = array('kbm_absensi_ljs ljs', 'absensi.id = ljs.absensi_id AND ljs.user_id = nilai.user_id', 'left');
			$query['join'][] = array(
				'kbm_absensi_kelas evalkelas',
				'absensi.id = evalkelas.absensi_id AND nilai.kelas_id = evalkelas.kelas_id',
				'left',
			);
			$query['where']['nilai.user_id'] = $d['user']['id'];
			$query['select']['nilai_id'] = 'nilai.id';
			$query['select'][] = 'nilai.kelas_id';
			$query['select'][] = 'nilai.trial';
			$query['select'][] = 'nilai.absensi_terkoreksi';
			$query['select'][] = 'nilai.absensi_nilai';
			$query['select'][] = 'nilai.ljs_id';
			$query['select'][] = 'nilai.ljs_count';
			$query['select'][] = 'nilai.ljs_last';
			$query['select'][] = 'nilai.user_id';
			$query['select'][] = 'evalkelas.absensi_mulai';
			$query['select'][] = 'evalkelas.absensi_ditutup';
			$query['select'][] = 'evalkelas.absensi_durasi';
			$query['select']['waktu_mulai_kerja'] = 'ljs.waktu';
			$query['select']['waktu_selesai_kerja'] = 'ljs.dikoreksi';

			// aktif ikut absensi
			// $query['where']['absensi.status != '] = 'closed';
			
			// aktif ikut absensi
			$query['where']['nilai.aktif'] = 1;
			
		elseif (!$dm['view'] && $dm['mengajar_list']):
			$query['where_in']['absensi.pelajaran_id'] = $dm['mengajar_list'];

		elseif (!$dm['view']):
			$query['where']['absensi.author_id'] = $d['user']['id'];

		endif;

		//if (!$dm['admin'])
			//$query['where']['absensi.status !='] = 'deleted';

		return $query;

	}

	// operasi data

	/*
	 * fungsi untuk menganalisa butir soal dan mengelompokan nilai siswa ke golongan: atas,tengah,bawah
	 * algoritma umum:
	 * - hanya khusus admin atau author yg bis. dan bila memang ada parameter analisa
	 * - status absensi sudah dipublish
	 * - cek jml peserta yg mengerjakan, minimal harus 3
	 * - jika analisa sebelumnya masi valid kembali
	 * -- cek ljs yg munkin belum dikoreksi. bila ada, pending dulu, perintahkan u/ koreksi
	 * --> pengelompokan atas/tengah/bawah
	 * --> analisa butir soal
	 */

	function analisa_cek()
	{
		$d = & $this->ci->d;
		$analisa_cek = $this->input->get_post('analisa');
		$grants = ($d['admin'] OR $d['author_ybs']);
		$absensi_id = (int) $d['row']['id'];

		if (!$analisa_cek OR ! $grants)
			return;

		if (!in_array($d['row']['status'], array('published')))
			return alert_info('absensi masih berupa draft, belum selesai disusun.');

		if ($d['row']['siswa_menjawab'] < 3)
			return alert_info('Peserta absensi yg mengerjakan masih dibawah 3.');

		if ($d['row']['analisa_valid'])
			return alert_info('Analisa absensi masih valid.');

		// cek ljs yg belum dikoreksi

		$sql_nonkoreksi = "select count(*) jml from kbm_absensi_nilai where absensi_id = ? and ljs_id is not null and absensi_terkoreksi = 0 and trial = 0";
		$jml_nonkoreksi = (int) $this->md->row_col('jml', $sql_nonkoreksi, array($absensi_id));

		if ($jml_nonkoreksi > 0)
			return alert_error("Masih ada {$jml_nonkoreksi} LJS yang belum dikoreksi.");

		// mulai pengelompokan

		$trx = $this->analisa_grouping($absensi_id);

		if (!$trx)
			return alert_error('Analisa error saat mengelompokkan nilai peserta.', FALSE);

		$trx = $this->analisa_soal($absensi_id, $d['row']['siswa_total']);

		if ($trx)
			return alert_info('Analisa butir soal selesai.');

		return alert_error('Analisa error saat mengelompokkan nilai peserta.', FALSE);

	}

	function analisa_grouping($absensi_id)
	{
		$nilai_query = array(
			'from'		 => 'kbm_absensi_nilai',
			'where'		 => array(
				'absensi_id'	 => $absensi_id,
				'trial'			 => 0,
			),
			'order_by'	 => 'absensi_nilai desc',
			'select'	 => array('id'),
		);
		$nilai_result = $this->md->query($nilai_query)->result();

		if ($nilai_result['selected_rows'] == 0)
			return alert_error("Kesalahan! Daftar nilai tidak dapat ditemukan.", FALSE);

		$siswa_jml = (int) $nilai_result['selected_rows'];
		$grup_atas_limit = floor($siswa_jml / 3);
		$grup_bawah_index = $siswa_jml - $grup_atas_limit;
		$kelompok_array = array();

		foreach ($nilai_result['data'] as $i => $nil):

			if ($i < $grup_atas_limit)
				$_grup = 'atas';
			else if ($i >= $grup_bawah_index)
				$_grup = 'bawah';
			else
				$_grup = 'tengah';

			$kelompok_array[] = array(
				'id'				 => $nil['id'],
				'absensi_kelompok'	 => $_grup,
			);

		endforeach;

		$this->db->trans_start();
		$this->db->update_batch('kbm_absensi_nilai', $kelompok_array, 'id');

		return $this->trans_done();

	}

	function analisa_soal($absensi_id, $siswa_total)
	{
		$d = & $this->ci->d;
		$siswa_total = (int) $siswa_total;
		$bindings = array(
			0	 => $absensi_id,
			1	 => $absensi_id,
			2	 => $siswa_total,
			3	 => $siswa_total,
			4	 => $siswa_total,
			5	 => $absensi_id,
		);
		$sql = "
update kbm_absensi_soal soal

left join
	(
	select
		jawaban.soal_id,
		sum(jawaban.poin) poin_jml

	from kbm_absensi_jawaban jawaban

	inner join kbm_absensi_nilai nilai on jawaban.ljs_id = nilai.ljs_id

	where	nilai.absensi_id = ?
	and	nilai.trial = 0
	and	absensi_kelompok = 'atas'

	group by
		jawaban.soal_id

	) kel_atas on soal.id = kel_atas.soal_id

left join
	(
	select
		jawaban.soal_id,
		sum(jawaban.poin) poin_jml

	from kbm_absensi_jawaban jawaban

	inner join kbm_absensi_nilai nilai on jawaban.ljs_id = nilai.ljs_id

	where	nilai.absensi_id = ?
	and	nilai.trial = 0
	and	absensi_kelompok = 'bawah'

	group by
		jawaban.soal_id

	) kel_bawah on soal.id = kel_bawah.soal_id

set
	soal.analisa_jml_atas = IFNULL(kel_atas.poin_jml, 0),
	soal.analisa_jml_bawah = IFNULL(kel_bawah.poin_jml, 0),
	analisa_index_tk = ( ( ( IFNULL(kel_atas.poin_jml, 0) + IFNULL(kel_bawah.poin_jml, 0) ) - ( 2 * ( ? / 4 ) * poin_min ) ) / ( 2 * ( ? / 4 ) * ( poin_max - poin_min ) ) ),
	analisa_index_db = ( ( IFNULL(kel_atas.poin_jml, 0) - IFNULL(kel_bawah.poin_jml, 0) ) / ( ( ? / 4 ) * ( poin_max - poin_min ) ) )

where
	soal.absensi_id = ?
";
		$absensi = array(
			'analisa_waktu'	 => $d['datetime'],
			'analisa_valid'	 => 1,
		);

		$this->db->trans_start();
		$this->db->query($sql, $bindings);
		$this->db->update('kbm_absensi', $absensi, array('id' => $absensi_id));

		return $this->trans_done();

	}

	function availability($row, $alert = FALSE)
	{
		$dm = & $this->dm;
		$d = & $this->ci->d;
		$u = & $this->ci->d['user'];

		// mutlak, pencegah error

		if ($row['soal_total'] == 0)
			return (!$alert) ? FALSE : alert_error('Butir soal absensi tidak ditemukan.');

		// guru/admin trial

		$d['pengajar_ybs'] = mengajar($row['pelajaran_id']);
		$d['author_ybs'] = ($u['id'] == $row['author_id']);

		if ($u['role'] != 'siswa' && ($dm['view'] OR $d['pengajar_ybs'] OR $d['author_ybs']))
			return TRUE;

		// ngecek isi absensi itu sendiri

		if (!$row['published'])
			return (!$alert) ? FALSE : alert_error('absensi ini belum dipublikasikan.');

		if ($row['closed'])
			return (!$alert) ? FALSE : alert_error('absensi tersebut telah ditutup.');

		if ($d['semaktif']['id'] != $row['semester_id'])
			return (!$alert) ? FALSE : alert_error('absensi tersebut tidak berlaku lagi.');

		// cek usernya (siswa)

		if (!isset($row['ljs_count']) OR ! isset($row['absensi_terkoreksi']) OR ! isset($row['kelas_list']) OR ! isset($row['kelas_result']))
			return (!$alert) ? FALSE : alert_error('Data absensi error.');

		if ($row['ljs_max'] > 0 && $row['ljs_max'] <= $row['ljs_count'])
			return (!$alert) ? FALSE : alert_error('Anda telah menggunakan semua kesempatan untuk menjawab.');

		if ($row['ljs_id'] && !$row['absensi_terkoreksi'])
			return (!$alert) ? FALSE : alert_error('Jawaban sebelumnya belum dikoreksi.');

		if (!in_array($row['kelas_id'], $row['kelas_list']))
			return (!$alert) ? FALSE : alert_error('Kelas Anda tidak termasuk dalam absensi ini.');

		$kelas = $row['kelas_result']['data'][$row['kelas_id']];

		if ($kelas['absensi_mulai'] && $kelas['absensi_mulai'] > $d['datetime'])
			return (!$alert) ? FALSE : alert_error('absensi tersebut belum dimulai.');

		if ($kelas['absensi_ditutup'] && $kelas['absensi_ditutup'] < $d['datetime'])
			return (!$alert) ? FALSE : alert_error('absensi tersebut telah selesai.');

		//  SISA WAKTU SISWA MENGERJAKAN
		if (isset($d['pengerjaan_ljs']['waktu']))
		{
			$waktu_awal_pengerjaan = strtotime($d['pengerjaan_ljs']['waktu']);
			$siswa_waktu = strtotime($d['datetime']) - $waktu_awal_pengerjaan ;
			$durasi		 = JamToDetik($kelas['absensi_durasi']);
			if($durasi<$siswa_waktu)
			{
				return (!$alert) ? FALSE : alert_error('Waktu Pengerjaan Siswa pada absensi tersebut telah selesai.');
			}
			//if(TIME_LJS < $siswa_waktu)
				//return (!$alert) ? FALSE : alert_error('Waktu Pengerjaan Siswa pada absensi tersebut telah selesai.');
		}
		
		
		return TRUE;

	}

	function browse($index = 0, $limit = 20)
	{
		$query = $this->query_1();
		$query = $this->filter_1($query);

		return $this->md->query($query)->resultset($index, $limit);

	}

	function rowset($id)
	{
		$d = & $this->ci->d;
		$query = $this->query_1();
		$query['where']['absensi.id'] = $id;
		$row = $this->md->query($query)->row();
		$query_kelas = array(
			'select'	 => array(
				'evakls.*',
				'kelas_nama' => 'kelas.nama',
			),
			'from'		 => 'kbm_absensi_kelas evakls',
			'join'		 => array(
				array('dakd_kelas kelas', 'evakls.kelas_id = kelas.id', 'inner'),
			),
			'order_by'	 => 'kelas.grade, kelas.jurusan_id, kelas.nama',
			'where'		 => array(
				'evakls.absensi_id' => $id,
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

	function upload($upload_path, $input)
	{
		// var
		//$input = 'upload';

		$upload = array(
			'upload_path' => $upload_path,
			//'file_name' => $file_name,
			'allowed_types' => '*',
			//'max_size' => 8192,
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
	
	function save()
	{
		$d = & $this->ci->d;
		$edit = (bool) $d['form']['id'];
		$msg_sukses = "absensi berhasil disimpan.";
		$kelas_jadwal = NULL;
		$absensi_id = $d['form']['id'];
		$pelajaran_nilai_id = $d['row']['pelajaran_nilai_id'];

		$upload_path = APP_ROOT."content/".strtolower(APP_SCOPE)."/sound/";
		$input = "audio";
		$upload_sound = $this->upload($upload_path,$input);
		
		//uraian
		if ($d['modit']['uraian'])
			$this->form->ruleset($d['row'], 'validasi-uraian');
		
		if ($d['modit']['aturan'])
			$this->form->ruleset($d['row'], 'validasi-aturan');

		if ($d['modit']['pelajaran'])
			$this->form->ruleset($d['row'], 'validasi-pelajaran');

		if ($d['modit']['bentuk'])
			$this->form->ruleset($d['row'], 'validasi-bentuk');

		if ($d['modit']['tutupan'])
			$this->form->ruleset($d['row'], 'validasi-tutupan');

		//$this->form->ruleset($d['row'], 'validasi-umum');
		if ($d['modit']['umum'])
			$this->form->ruleset($d['row'], 'validasi-umum');
		
		$this->form->validate();

		//if ($d['error'])
			//return FALSE;

		//$data = $this->input('fields-umum');
		$data['updated'] = $d['datetime'];
		
		//uraian
		if ($d['modit']['uraian'])
			$data = $this->input('fields-uraian', $data);
		
		if ($d['modit']['umum'])
			$data = $this->input('fields-umum', $data);
		
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

		if ($d['modit']['uraian']){
			
		}else{	
			$kelas_jadwal = $this->input_jadwal($pelajaran_nilai_id);
			if (empty($kelas_jadwal))
				alert_error('Jadwal kelas harus diisi.');
		}
			
		//alert_error($absensi_id.'AAAAA. '.$data['detail_uraian']);
		
		//if ($d['error'])
			//return FALSE;

		// mulai proses penyimpanan

		// SET LJS MAXIMAL 1
		$data['ljs_max'] = 1;
		
		$this->db->trans_start();

		if (!$edit):

			// siapkan data

			$data['semester_id'] = $d['semaktif']['id'];
			$data['author_id'] = $d['user']['id'];
			$data['registered'] = $d['datetime'];

			// prosesi insert

			$this->db->insert('kbm_absensi', $data);

			// id baru ditampung di tabel terpisah dulu biar gak konflik saat error

			$absensi_id = $this->db->insert_id();
			$trx_status = $this->db->trans_status();

			if (!$trx_status OR ! $absensi_id)
				return $this->trans_rollback('Database error saat menyimpan absensi baru, coba beberapa saat lagi.');

			// insert berhasil

			$data = array();
			$msg_sukses = "absensi baru berhasil ditambahkan.";

		endif;
		
		if ($d['modit']['uraian']){
			
		}else{	
			// hapus data jadwal sebelumnya

			if ($edit)
				$this->db->delete('kbm_absensi_kelas', array('absensi_id' => $absensi_id));

			// entri jadwal baru

			$klsjadwal_array = array();

			foreach ($kelas_jadwal as $kid => $jadwal):
				$jadwal['kelas_id'] = $kid;
				$jadwal['absensi_id'] = $absensi_id;
				$klsjadwal_array[] = $jadwal;

			endforeach;

			//alert_dump($klsjadwal_array);

			if ($klsjadwal_array):
				$this->db->insert_batch('kbm_absensi_kelas', $klsjadwal_array);
			endif;
		}
		// perubahan data
		
		
		if (!empty($data)):
			if($upload_sound)
			{
				$data['audio'] = $upload_sound['full_path'];
			}
			$this->db->update('kbm_absensi', $data, array('id' => $absensi_id));

			if ($edit)
				$msg_sukses = 'Data absensi berhasil disimpan.';

		endif;

		// selesai

		$trx = $this->trans_done($msg_sukses, 'Database error, coba beberapa saat lagi.');

		if ($trx && !$edit)
			$d['form']['id'] = $absensi_id;

		return $trx;

	}

	function data_npelajaran($pelajaran_id)
	{
		$d = & $this->ci->d;
		$query = array(
			'from'	 => 'nilai_pelajaran',
			'where'	 => array(
				'pelajaran_id'	 => $pelajaran_id,
				'semester_id'	 => $d['semaktif']['id'],
			),
		);

		return $this->md->query($query)->row();

	}

	function data_kelas($npel_id)
	{

		// cek data kelas peserta absensi

		$query = array(
			'from'	 => 'dakd_kelas kelas',
			'join'	 => array(
				array('nilai_pelajaran_kelas npelkls', 'kelas.id = npelkls.kelas_id', 'inner'),
			),
			'where'	 => array(
				'npelkls.pelajaran_nilai_id' => $npel_id,
			),
			'select' => array('kelas.id', 'kelas.nama'),
		);

		return $this->md->query($query)->result_series('id', 'nama');

	}

	function input_jadwal($npel_id)
	{

		$kelas_list = $this->data_kelas($npel_id);

		if (empty($kelas_list))
			return alert_error("Kesalahan! Daftar kelas pelajaran tidak ditemukan.");

		// cek input jadwal
		
		$cek=0;
		
		$absensi_durasi 	= (array) $this->input->post('absensi_durasi');
		
		if($this->input->post('absensi_mulai')){
			$cek=1;
			$absensi_mulai = (array) $this->input->post('absensi_mulai');
			$absensi_ditutup = (array) $this->input->post('absensi_ditutup');
		}else{
			$cek=2;
			$absensi_mulai_date = (array) $this->input->post('absensi_mulai_date');
			$absensi_mulai_time = (array) $this->input->post('absensi_mulai_time');
			$absensi_ditutup_date = (array) $this->input->post('absensi_ditutup_date');
			$absensi_ditutup_time = (array) $this->input->post('absensi_ditutup_time');
		}
		$kelas_jadwal = array();
		
		foreach ($kelas_list as $kid => $knama):
			$ceki=0;
			if($this->input->post('absensi_mulai')){
				$ceki=1;
				$_jadwal = array(
					'absensi_mulai'	 => datefix(array_node($absensi_mulai, $kid)),
					'absensi_ditutup'	 => datefix(array_node($absensi_ditutup, $kid)),
					'absensi_durasi'	 => array_node($absensi_durasi, $kid),
				);

				
			}else{
				$ceki=2;
				$emulai_date = str_replace('/', '-', array_node($absensi_mulai_date, $kid));
				$emulai_date = date("Y-m-d",strtotime($emulai_date));
				$editutup_date = str_replace('/', '-', array_node($absensi_ditutup_date, $kid));
				$editutup_date = date("Y-m-d",strtotime($editutup_date));
				$emulai_time = date("H:i:s",strtotime(array_node($absensi_mulai_time, $kid)));
				$editutup_time = date("H:i:s",strtotime(array_node($absensi_ditutup_time, $kid)));
				
				$absensi_mulai = date("Y-m-d H:i:s", strtotime( $emulai_date ." ". $emulai_time ));
				$absensi_ditutup = date("Y-m-d H:i:s",strtotime( $editutup_date ." ". $editutup_time ));
				
				$_jadwal = array(
					'absensi_mulai'	 => $absensi_mulai,
					'absensi_ditutup'	 => $absensi_ditutup,
					'absensi_durasi'	 => array_node($absensi_durasi, $kid),
				);
			}
			
			

			if (!$_jadwal['absensi_mulai']):
				alert_error("Waktui mulai kelas {$knama} harus diisi dengan format tanggal-jam yang benar. format: yyyy-mm-dd. ".$_jadwal['absensi_mulai'].
				" ".$emulai_date." | ".$cek." | ".$ceki);
				continue;
			endif;

			if ($_jadwal['absensi_mulai'] && $_jadwal['absensi_ditutup'] && $_jadwal['absensi_mulai'] >= $_jadwal['absensi_ditutup']):
				alert_error("Waktu selesai kelas {$knama} salah, harus sesudah dimulai.". $absensi_mulai." ".$emulai_time." ".$absensi_ditutup);
				continue;
			endif;
			
			$kelas_jadwal[$kid] = $_jadwal;

		endforeach;

		return $kelas_jadwal;

	}

	function publish()
	{
		/*
		 * overview:
		 * - ambil data siswa peserta pelajaran saat ini.
		 * - update publish data absensi.
		 * - insert entry nilai [kbm_absensi_nilai] untuk tiap siswa
		 *
		 * * tunggu semua nilai masuk sebelum update nilai rata2 masing2
		 */

		$d = & $this->ci->d;
		$absensi_id = (int) $d['form']['id'];
		$pelajaran_nilai_id = (int) $d['row']['pelajaran_nilai_id'];
		$query_siswa = array(
			'from'	 => 'nilai_siswa nilsis',
			'join'	 => array(
				array('nilai_siswa_pelajaran nisispel', 'nilsis.id = nisispel.siswa_nilai_id', 'inner'),
			),
			'where'	 => array(
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

		foreach ($peserta_result['data'] as $peserta):
			$evanil_array[] = array(
				'user_id'		 => $peserta['siswa_id'],
				'trial'			 => 0,
				'kelas_id'		 => $peserta['kelas_id'],
				'absensi_id'	 => $absensi_id,
			);
		endforeach;

		// data update absensi

		$absensi_upd = array(
			'status'		 => 'published',
			'published'		 => $d['datetime'],
			'siswa_total'	 => $peserta_result['selected_rows'],
		);

		// update status absensi

		$this->db->trans_start();
		$this->db->update('kbm_absensi', $absensi_upd, array('id' => $absensi_id));
		$this->db->insert_batch('kbm_absensi_nilai', $evanil_array);

		$trx = $this->trans_done("absensi berhasil dipublikasikan ke {$peserta_result['selected_rows']} siswa.", 'Database error, coba beberapa saat lagi.');

		if ($trx):
			$this->db->trans_start();
			$this->m_kbm_absensi_ljs->update_pengerjaan($absensi_id);
			$this->trans_done();
		endif;

		return $trx;

	}

	function tutup()
	{
		/*
		 * overview:
		 * - ambil data siswa peserta pelajaran saat ini.
		 * - update publish data absensi.
		 * - insert entry nilai [kbm_absensi_nilai] untuk tiap siswa
		 *
		 * * tunggu semua nilai masuk sebelum update nilai rata2 masing2
		 */

		$d = & $this->ci->d;
		$absensi_id = (int) $d['form']['id'];

		// data update absensi

		$absensi_upd = array(
			'status' => 'closed',
			'closed' => $d['datetime'],
		);

		// update status absensi

		$this->db->trans_start();
		$this->db->update('kbm_absensi', $absensi_upd, array('id' => $absensi_id));

		// fu: analisa absensi??

		return $this->trans_done("absensi berhasil ditutup.", 'Database error, coba beberapa saat lagi.');

	}

	function delete()
	{
		/*
		 * overview:
		 * - ambil data siswa peserta pelajaran saat ini.
		 * - update publish data absensi.
		 * - insert entry nilai [kbm_absensi_nilai] untuk tiap siswa
		 *
		 * * tunggu semua nilai masuk sebelum update nilai rata2 masing2
		 */

		$d = & $this->ci->d;
		$absensi_id = (int) $d['form']['id'];

		// data update absensi

		$absensi_upd = array(
			'status'	 => 'deleted',
			'updated'	 => $d['datetime'],
			'editor_id'	 => $d['user']['id'],
		);

		// update status absensi

		$this->db->trans_start();
		$this->db->update('kbm_absensi', $absensi_upd, array('id' => $absensi_id));

		// fu: analisa absensi??

		return $this->trans_done("absensi berhasil dihapus.", 'Database error, coba beberapa saat lagi.');

	}

	function rekap()
	{
		$this->load->helper('costumized/' . APP_SCOPE);
		$this->load->model('m_nilai_siswa');
		$this->load->model('m_nilai_pelajaran');
		$this->load->model('m_nilai_pelajaran_kelas');

		$d = & $this->ci->d;
		$absensi_id = (int) $d['row']['id'];
		$semester_id = (int) $d['row']['semester_id'];
		$pelajaran_nilai_id = (int) $d['row']['pelajaran_nilai_id'];
		$kolom = $this->input->post('kolom');
		$kelas_id = $this->input->post('kelas_id');

		// cek kolom yg dipilih sesuai pilihan tersedia tidak.?

		if (!array_key_exists($kolom, $d['kolom_list']))
			return alert_error("Kolom yang dipilih tidak ada.");

		// mulai memindah nilai
		// params: semester_id, nipel_id, eval_id

		$sql_rekapan = "
update nilai_siswa_pelajaran nisispel
inner join nilai_siswa nisis on nisis.id = nisispel.siswa_nilai_id and nisis.semester_id = ?
inner join kbm_absensi_nilai evanil on evanil.user_id = nisis.siswa_id

set
	nisispel.{$kolom} = evanil.absensi_nilai,
	nisispel.valid = 0

where nisispel.pelajaran_nilai_id = ?
  and evanil.trial = 0 and evanil.absensi_id = ?
  and nisis.kelas_id = {$kelas_id}
				";

		$this->db->trans_begin();
		$this->db->query($sql_rekapan, array($semester_id, $pelajaran_nilai_id, $absensi_id));
		$this->trans_done("Nilai absensi berhasil direkap.", "Database error saat merekap nilai absensi.");

		if ($d['error'])
			return FALSE;

		// ambil rekap nilai pelajaran

		$nipel = $this->md->rowset($pelajaran_nilai_id, 'nilai_pelajaran');

		if (!$nipel)
			return alert_error("Rekap nilai pelajaran tidak ditemukan.");

		// buat nilai rapor/rerata u/ tiap nisispel

		$nisispel_query = array(
			'from'	 => 'nilai_siswa_pelajaran',
			'where'	 => array(
				'pelajaran_nilai_id' => $pelajaran_nilai_id,
				'valid'				 => 0,
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
				'id'			 => (int) $nisispel['id'],
				'valid'			 => 1,
				'diolah'		 => $d['datetime'],
				'nas_teori'		 => $nisispel['nas_teori'],
				'nas_praktek'	 => $nisispel['nas_praktek'],
				'nas_total'		 => $nisispel['nas_total'],
			);

			// nilai harian

			for ($i = 1; $i <= 10; $i++):
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

	}

	// input jadwal

	function opsi_jadwal_kelas($full = FALSE)
	{
		$row = & $this->ci->d['row'];
		$d = & $this->ci->d;
		$dm = $this->dm;
		$dths = $d['dto']->format('Y-m-d 08:00');
		$durasi = $d['dto']->format('02:00');
		$xdat = array();
		$query = array(
			'from'		 => 'dakd_kelas kelas',
			'join'		 => array(
				array('nilai_pelajaran_kelas nilai_pelkls', 'kelas.id = nilai_pelkls.kelas_id', 'inner'),
			),
			'where'		 => array(
				'nilai_pelkls.semester_id' => $d['semaktif']['id'],
			),
			'order_by'	 => 'kelas.grade, kelas.nama',
			'select'	 => array(
				'kelas.id',
				'kelas.nama',
				'nilai_pelkls.pelajaran_id',
				'absensi_mulai'	 => "'{$dths}'",
				'absensi_ditutup'	 => "''",
				'absensi_durasi'	 => "'{$durasi}'",
			),
		);

		if ($row['id'] > 0):
			$subsql = "select * from kbm_absensi_kelas where absensi_id = {$row['id']}";
			$query['join'][] = array("({$subsql}) kbm_evakls", 'kelas.id = kbm_evakls.kelas_id', 'left');
			$query['select']['absensi_mulai'] = "IFNULL(kbm_evakls.absensi_mulai, '{$dths}')";
			$query['select']['absensi_durasi'] = "IFNULL(kbm_evakls.absensi_durasi, '{$durasi}')";
			$query['select']['absensi_ditutup'] = "kbm_evakls.absensi_ditutup";

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

	function kolom_nilai_list()
	{

		// satu KD satu nilai u/r/t/p

		$list_sistem_tunggal = array('theresiana_sma');
		$list_sistem_bobot = array('smp_terbang');

		if (in_array(APP_SCOPE, $list_sistem_tunggal))
			return $this->kolom_nilai_list_tunggal();
		
		if (in_array(APP_SCOPE, $list_sistem_bobot))
			return $this->kolom_nilai_list_bobot();

		// lainnya sesuai standar lengkap

		return $this->kolom_nilai_list_lengkap();

	}

	function kolom_nilai_list_tunggal()
	{
		$kolom_list = array();
		$kategori_list = array(
			'u'	 => 'Ulangan',
			'r'	 => 'Remidi',
			't'	 => 'Tugas',
			'p'	 => 'Praktek',
		);

		// format: ulangan kd x

		foreach ($kategori_list as $kode => $kategori):
			for ($i = 1; $i <= 10; $i++):
				$no_kd = $i;
				$no_nilai = ($i * 4) - 3;
				$kolom = $kode . $no_nilai;
				$label = $kategori . ' KD ' . $no_kd;
				$kolom_list[$kolom] = $label;

			endfor;
		endforeach;

		return $kolom_list;

	}

	function kolom_nilai_list_bobot()
	{
		$kolom_list = array();
		$kategori_list = array(
			'u'	 => 'Ulangan',
			// 't'	 => 'Tugas',
			// 'p'	 => 'Praktek',
		);

		// format: ulangan kd x

		foreach ($kategori_list as $kode => $kategori):
			for ($i = 1; $i <= 10; $i++):
				$no_kd = $i;
				for ($j = 1; $j <= 3; $j++):
					$no_nilai = $j + (($i - 1) * 4);
					$kolom = $kode . $no_nilai;
					$label = $kategori . ' KD ' . $no_kd . ' (Bobot '. $j .')';
					$kolom_list[$kolom] = $label;
				endfor;
			endfor;
		endforeach;

		return $kolom_list;

	}
	function kolom_nilai_list_lengkap()
	{
		$kolom_list = array();
		$kategori_list = array(
			'u'	 => 'Ulangan',
			'r'	 => 'Remidi',
			't'	 => 'Tugas',
			'p'	 => 'Praktek',
		);

		// format: Ulangan x (KD y)

		foreach ($kategori_list as $kode => $kategori):
			for ($i = 1; $i <= 40; $i++):
				$no_kd = ceil($i / 4);
				$no_nilai = $i;
				$kolom = $kode . $no_nilai;
				$label = "{$kategori} {$no_nilai} (KD {$no_kd})";
				$kolom_list[$kolom] = $label;

			endfor;
		endforeach;

		return $kolom_list;

	}

	function reuse($fromabsensi_id)
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

		///// absensi
		$nilpel = $this->md->row($sql_nilpel);
		$pelajaran_nilai_id = $nilpel['id'];
		$author_id = $d['user']['id'];
		$sql_copy_absensi = <<<SQL

INSERT INTO
	kbm_absensi
	(
		author_id, pelajaran_id, pelajaran_nilai_id, status,
		semester_id, nama, tipe, metode, jml_kd, audio, kkm, pilihan_jml, 
		soal_jml, soal_total, soal_acak, soal_bank, ljs_max, jadwal_perkelas, registered, updated
		, plus_uraian, detail_uraian
	)

SELECT
	{$author_id}, {$newPelajaran_id}, {$pelajaran_nilai_id}, 'draft',
	{$semester_id}, nama, tipe, metode, jml_kd, audio, kkm, pilihan_jml,
	soal_jml, soal_total, soal_acak, soal_bank, ljs_max, jadwal_perkelas, registered, updated
	, plus_uraian, detail_uraian

FROM
	kbm_absensi

WHERE
	id = {$fromabsensi_id}
;

SQL;
		$this->db->query($sql_copy_absensi);

		if ($this->db->trans_status() === FALSE)
		{
			$this->db->trans_rollback();

			return alert_error("error saat menjalankan: <br/> {$sql_copy_absensi}");
		}

		//// absensi KELAS
		$newabsensi_id = $this->db->insert_id();
		$sql_absensi_kelas = <<<SQL

INSERT INTO
	kbm_absensi_kelas
	(
		absensi_id,
		kelas_id
	)

SELECT
	{$newabsensi_id},
	kelas_id

FROM
	nilai_pelajaran_kelas

WHERE
	pelajaran_nilai_id = {$pelajaran_nilai_id}
;

SQL;
		$this->db->query($sql_absensi_kelas);

		if ($this->db->trans_status() === FALSE)
		{
			$this->db->trans_rollback();

			return alert_error("error saat menjalankan: <br/> {$sql_absensi_kelas}");
		}

		
		//// absensi PEMBAGIAN KD
		$sql_absensi_pembagian_kd = <<<SQL

INSERT INTO
	kbm_absensi_pembagian_kd
	(
		absensi_id,
		posisi_kd,
		nama,
		soal_jml,
		keterangan,
		registered,
		updated,
		editor_id
	)

SELECT
	{$newabsensi_id},
	posisi_kd,
	nama,
	soal_jml,
	keterangan,
	registered,
	updated,
	editor_id

FROM
	kbm_absensi_pembagian_kd

WHERE
	absensi_id = {$fromabsensi_id}
;

SQL;
		$this->db->query($sql_absensi_pembagian_kd);

		if ($this->db->trans_status() === FALSE)
		{
			$this->db->trans_rollback();

			return alert_error("error saat menjalankan: <br/> {$sql_absensi_pembagian_kd}");
		}
		
		
		//// absensi SOAL
		$sql_butir_soal = <<<SQL

INSERT INTO
	kbm_absensi_soal
	(
		absensi_id,
		posisi_kd, audio, pertanyaan, pilihan_ganda, poin_min, poin_max, pilihan, registered
	)

SELECT
	{$newabsensi_id},
	posisi_kd, audio, pertanyaan, pilihan_ganda, poin_min, poin_max, pilihan, registered

FROM
	kbm_absensi_soal

WHERE
	absensi_id = {$fromabsensi_id}
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

		return $newabsensi_id;

	}

	function reuse2($fromabsensi_id)
	{
		$d = & $this->ci->d;
		$semester_id = $d['semaktif']['id'];
		$newPelajaran_id = (int) $this->input->post('pelajaran_id');

		$this->db2->trans_begin();

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

		if ($this->db2->trans_status() === FALSE)
		{
			$this->db2->trans_rollback();

			return alert_error("error saat menjalankan: <br/> {$sql_nilpel}");
		}

		$nilpel = $this->md->row($sql_nilpel);
		$pelajaran_nilai_id = $nilpel['id'];
		$author_id = $d['user']['id'];
		$sql_copy_absensi = <<<SQL

INSERT INTO
	kbm_absensi
	(
		author_id, pelajaran_id, pelajaran_nilai_id, status,
		semester_id, nama, tipe, metode, jml_kd, audio, kkm, pilihan_jml, 
		soal_jml, soal_total, soal_acak, soal_bank, ljs_max, jadwal_perkelas, registered, updated
	)

SELECT
	{$author_id}, {$newPelajaran_id}, {$pelajaran_nilai_id}, 'draft',
	semester_id, nama, tipe, metode, jml_kd, audio, kkm, pilihan_jml,
	soal_jml, soal_total, soal_acak, soal_bank, ljs_max, jadwal_perkelas, registered, updated

FROM
	kbm_absensi

WHERE
	id = {$fromabsensi_id}
;

SQL;
		$this->db2->query($sql_copy_absensi);

		if ($this->db2->trans_status() === FALSE)
		{
			$this->db2->trans_rollback();

			return alert_error("error saat menjalankan: <br/> {$sql_copy_absensi}");
		}

		$newabsensi_id = $this->db2->insert_id();
		$sql_absensi_kelas = <<<SQL

INSERT INTO
	kbm_absensi_kelas
	(
		absensi_id,
		kelas_id
	)

SELECT
	{$newabsensi_id},
	kelas_id

FROM
	nilai_pelajaran_kelas

WHERE
	pelajaran_nilai_id = {$pelajaran_nilai_id}
;

SQL;
		$this->db2->query($sql_absensi_kelas);

		if ($this->db2->trans_status() === FALSE)
		{
			$this->db2->trans_rollback();

			return alert_error("error saat menjalankan: <br/> {$sql_absensi_kelas}");
		}

		$sql_butir_soal = <<<SQL

INSERT INTO
	kbm_absensi_soal
	(
		absensi_id,
		posisi_kd, audio, pertanyaan, pilihan_ganda, poin_min, poin_max, pilihan, registered
	)

SELECT
	{$newabsensi_id},
	posisi_kd, audio, pertanyaan, pilihan_ganda, poin_min, poin_max, pilihan, registered

FROM
	kbm_absensi_soal

WHERE
	absensi_id = {$fromabsensi_id}
;

SQL;

		$this->db2->query($sql_butir_soal);

		if ($this->db2->trans_status() === FALSE)
		{
			$this->db2->trans_rollback();

			return alert_error("error saat menjalankan: <br/> {$sql_butir_soal}");
		}
		else
		{
			$this->db2->trans_commit();
		}

		return $newabsensi_id;

	}

	/*
	 * memanggil stored procedure
	 */

	function call($procedure)
	{
		$procedure = "CALL " . $procedure;
		$result = @$this->db->conn_id->query($procedure);

		alert_dump($result);

		while ($this->db->conn_id->next_result())
		{
			//free each result.
			$not_used_result = $this->db->conn_id->use_result();

			if ($not_used_result instanceof mysqli_result)
			{
				$not_used_result->free();
			}
		}

		return $result;

	}

	function reuse_OLD($fromabsensi_id)
	{
		$d = & $this->ci->d;
		$newPelajaran_id = (int) $this->input->post('pelajaran_id');
		$sql_copy_absensi = <<<SQL

SELECT
	@semester_id := id

FROM
	prd_semester

ORDER BY
	id DESC

LIMIT
	1
;

SELECT
	@pelajaran_nilai_id := id,
	@author_id := guru_id

FROM
	nilai_pelajaran

WHERE
	pelajaran_id = {$newPelajaran_id}
AND
	semester_id = @semester_id

ORDER BY
	id DESC

LIMIT
	1
;

INSERT INTO
	kbm_absensi
	(
		author_id, pelajaran_id, pelajaran_nilai_id, status,
		semester_id, nama, tipe, metode, kkm, pilihan_jml, soal_jml, soal_total, soal_acak, soal_bank, jadwal_perkelas, registered, updated
	)

SELECT
	@author_id, {$newPelajaran_id}, @pelajaran_nilai_id, 'draft',
	semester_id, nama, tipe, metode, kkm, pilihan_jml, soal_jml, soal_total, soal_acak, soal_bank, jadwal_perkelas, registered, updated

FROM
	kbm_absensi

WHERE
	id = {$fromabsensi_id}
;

SQL;

		$this->db->query($sql_copy_absensi);

		$newabsensi_id = $this->db->insert_id();

		$sql_copy_soal = <<<SQL

SELECT
	@semester_id := id

FROM
	prd_semester

ORDER BY
	id DESC

LIMIT
	1
;

SELECT
	@pelajaran_nilai_id := id,
	@author_id := guru_id

FROM
	nilai_pelajaran

WHERE
	pelajaran_id = {$newPelajaran_id}
AND
	semester_id = @semester_id

ORDER BY
	id DESC

LIMIT
	1
;

INSERT INTO
	kbm_absensi_kelas
	(
		absensi_id,
		kelas_id
	)

SELECT
	{$newabsensi_id},
	kelas_id

FROM
	nilai_pelajaran_kelas

WHERE
	pelajaran_nilai_id = @pelajaran_nilai_id
;

INSERT INTO
	kbm_absensi_soal
	(
		absensi_id,
		pertanyaan, pilihan_ganda, poin_min, poin_max, pilihan, registered
	)

SELECT
	{$newabsensi_id},
	pertanyaan, pilihan_ganda, poin_min, poin_max, pilihan, registered

FROM
	kbm_absensi_soal

WHERE
	absensi_id = {$fromabsensi_id}
;

SQL;

		$this->db->query($sql_copy_soal);

		return $newabsensi_id;

	}

	function reuse_old_2($fromabsensi_id)
	{
		$d = & $this->ci->d;
		$newPelajaran_id = (int) $this->input->post('pelajaran_id');
		$sql_copy_absensi = <<<SQL

# atur variabel
SET @fromabsensi_id = {$fromabsensi_id}; # diisi id absensi yg hendak dicopy
SET @newPelajaran_id = {$newPelajaran_id}; # diisi id pelajaran yg hendak diisi absensi

# semester_id
SELECT
	@semester_id := id

FROM
	prd_semester

ORDER BY
	id DESC

LIMIT
	1
;

# id nilai pelajaran
SELECT
	@pelajaran_nilai_id := id,
	@author_id := guru_id

FROM
	nilai_pelajaran

WHERE
	pelajaran_id = @newPelajaran_id
AND
	semester_id = @semester_id

ORDER BY
	id DESC

LIMIT
	1
;

# Copy absensi

INSERT INTO
	kbm_absensi
	(
		author_id, pelajaran_id, pelajaran_nilai_id, status,
		semester_id, nama, tipe, metode, kkm, pilihan_jml, soal_jml, soal_total, soal_acak, soal_bank, jadwal_perkelas, registered, updated
	)

SELECT
	@author_id, @newPelajaran_id, @pelajaran_nilai_id, 'draft',
	semester_id, nama, tipe, metode, kkm, pilihan_jml, soal_jml, soal_total, soal_acak, soal_bank, jadwal_perkelas, registered, updated

FROM
	kbm_absensi

WHERE
	id = @fromabsensi_id
;

# simpan id absensi tersimpan

SET @newabsensi_id = LAST_INSERT_ID();

# susun daftar kelas

INSERT INTO
	kbm_absensi_kelas
	(
		absensi_id,
		kelas_id
	)

SELECT
	@newabsensi_id,
	kelas_id

FROM
	nilai_pelajaran_kelas

WHERE
	pelajaran_nilai_id = @pelajaran_nilai_id
;

# copy butir soal

INSERT INTO
	kbm_absensi_soal
	(
		absensi_id,
		pertanyaan, pilihan_ganda, poin_min, poin_max, pilihan, registered
	)

SELECT
	@newabsensi_id,
	pertanyaan, pilihan_ganda, poin_min, poin_max, pilihan, registered

FROM
	kbm_absensi_soal

WHERE
	absensi_id = @fromabsensi_id
;


SELECT @newabsensi_id;
SQL;

		$this->db->query($sql_copy_absensi);

		return $newPelajaran_id;

	}

}
