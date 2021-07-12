<?php

class M_kbm_evaluasi extends MY_Model
{
	var $filetypes = array('mp3','wma','ogg','m4a','mpeg','wav','webma');
	
	var $filetypes2 = array('pdf','ppt','pptx','xls','xlsx','doc','docx','rtf');
	
	public function __construct()
	{
		parent::__construct(array(
			'fields-umum'		 => array('nama', 'kkm', 'jml_kd', 'kisi_kisi', 'kop', 'show_webcam', 'plus_isian', 'plus_uraian', 'tipe', 'metode', 'show_kunci'),
			'fields-pelajaran'	 => array('pelajaran_id'),
			'fields-bentuk'		 => array('pilihan_jml'),
			'fields-aturan'		 => array( 'soal_jml', 'soal_acak', 'ljs_max'),
			'fields-tutupan'	 => array('show_rank'),
			'fields-uraian'		 => array('detail_uraian'),
			'fields-bobot'		 => array('bobot_pilgan', 'bobot_isian', 'bobot_uraian'),
		));
		$this->dm['admin'] = cfguc_admin('akses', 'kbm', 'evaluasi');
		$this->dm['view'] = cfguc_view('akses', 'kbm', 'evaluasi');
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
			$query['like'] = array($r['term'], array('author.nama', 'evaluasi.nama'));

		if ($r['tglwaktu'] > 0)
		{
			$exptglwaktu = explode("-",$r['tglwaktu']);
			$tglwaktu = $exptglwaktu[2]."-".$exptglwaktu[1]."-".$exptglwaktu[0];
			$query['where_strings'][] = 'evaluasi.published >= "'.$tglwaktu.' 00:00" '.
			'AND evaluasi.published <= "'.$tglwaktu.' 23:59"';
		}
		
		if ($r['semester_id'] > 0)
			$query['where']['evaluasi.semester_id'] = $r['semester_id'];

		if ($r['pelajaran_id'] > 0)
			$query['where']['evaluasi.pelajaran_id'] = $r['pelajaran_id'];

		if ($r['mapel_id'] > 0)
			$query['where']['evaluasi.mapel_id'] = $r['mapel_id'];

		if ($r['author_id'] > 0 && $d['user']['role'] == 'admin')
			$query['where']['evaluasi.author_id'] = $r['author_id'];
		
		if (!empty($r['kisi_kisi']))
			$query['where']['evaluasi.kisi_kisi'] = $r['kisi_kisi'];
		
		if (!empty($r['status']))
			$query['where']['evaluasi.status'] = $r['status'];
		
		if (!empty($r['status_pengerjaan'])){
			if($r['status_pengerjaan'] == 'selesai'){
				$query['where']['nilai.evaluasi_terkoreksi'] = 1;
				
			}elseif($r['status_pengerjaan'] == 'belum'){
				$query['where']['nilai.evaluasi_terkoreksi'] = 0;
			}
		}
		
		
		if(($r['urutan'] == 'abjad_asc')||($r['urutan_siswa'] == 'abjad_asc')){
			$query['order_by'] = 'evaluasi.nama asc';
		}
		
		if(($r['urutan'] == 'abjad_desc')||($r['urutan_siswa'] == 'abjad_desc')){
			$query['order_by'] = 'evaluasi.nama desc';
		}
		
		
		return $query;

	}

	function query_1( $rowset='' )
	{
		$d = & $this->ci->d;
		$r = & $this->ci->d['request'];
		$dm = & $this->dm;
		$query = array(
			'from'		 => 'kbm_evaluasi evaluasi',
			'join'		 => array(
				array('kbm_evaluasi_kelas evakel', 'evakel.evaluasi_id = evaluasi.id', 'left'),
				array('dakd_kelas kelas', 'evakel.kelas_id = kelas.id', 'left'),
				array('prd_semester semester', 'evaluasi.semester_id = semester.id', 'inner'),
				array('prd_ta ta', 'semester.ta_id = ta.id', 'inner'),
				array('dprofil_sdm author', 'evaluasi.author_id = author.id', 'left'),
				array('dakd_pelajaran pelajaran', 'evaluasi.pelajaran_id = pelajaran.id', 'inner'),
				array('dakd_mapel mapel', 'pelajaran.mapel_id = mapel.id', 'inner'),
				array('dakd_kategori_mapel kategori', 'pelajaran.kategori_id = kategori.id', 'inner'),
				array('dmst_kurikulum kurikulum', 'pelajaran.kurikulum_id = kurikulum.id', 'inner'),
				array('dmst_agama agama', 'pelajaran.agama_id = agama.id', 'left'),
				array('dmst_kolom_nilai nilai_kolom', 'evaluasi.nilai_kolom_id = nilai_kolom.id', 'left'),
				
				/*array('dakd_kompetensi_dasar komp_dasar', 
					'komp_dasar.kurikulum_id 	= pelajaran.kurikulum_id AND '.
					'komp_dasar.kategori_id 	= pelajaran.kategori_id AND '.
					'komp_dasar.mapel_id 		= pelajaran.mapel_id AND '.
					'komp_dasar.grade 			= GROUP_CONCAT(kelas.grade) AND '.
					, 'left')*/
			),
			'order_by'	 => 'evaluasi.semester_id desc, pelajaran.nama, evaluasi.id desc',
			//'order_by'	 => 'evaluasi.id desc',
			'group_by'	 => 'evaluasi.id',
			'select'	 => array(
				'evaluasi.*',
				'wali_id'			 => 'kelas.wali_id',
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
				//'pelajaran.mapel_id',
				//'pelajaran.kategori_id',
				'pelajaran.agama_id',
				'nilai_kolom_kode'	 => 'nilai_kolom.kode',
			),
		);
		// delete di hapus dari view
		$query['select']['kelas_nama'] = 'GROUP_CONCAT(kelas.nama)';
		$query['select']['kelas_grade'] = 'GROUP_CONCAT(kelas.grade)';
		$query['where']['evaluasi.status !='] = 'deleted';
		
		// filter akses

		if ($d['user']['role'] == 'siswa'):
			$date_now = date("Y-m-d");
			
			$query['join'][] = array('kbm_evaluasi_nilai nilai', 'evaluasi.id = nilai.evaluasi_id', 'inner');
			$query['join'][] = array('kbm_evaluasi_ljs ljs', 'evaluasi.id = ljs.evaluasi_id AND ljs.user_id = nilai.user_id', 'left');
			$query['join'][] = array(
				'kbm_evaluasi_kelas evalkelas',
				'evaluasi.id = evalkelas.evaluasi_id AND nilai.kelas_id = evalkelas.kelas_id',
				'left',
			);
			$query['where']['nilai.user_id'] = $d['user']['id'];
			$query['where_strings'][] = 'evalkelas.evaluasi_mulai <= "'.$date_now.' 23:59" ';
			
			$query['select']['nilai_id'] = 'nilai.id';
			$query['select'][] = 'nilai.kelas_id';
			$query['select'][] = 'nilai.trial';
			$query['select'][] = 'nilai.evaluasi_terkoreksi';
			$query['select'][] = 'nilai.evaluasi_nilai';
			$query['select'][] = 'nilai.ljs_id';
			$query['select'][] = 'nilai.ljs_count';
			$query['select'][] = 'nilai.ljs_last';
			$query['select'][] = 'nilai.user_id';
			$query['select'][] = 'evalkelas.evaluasi_mulai';
			$query['select'][] = 'evalkelas.evaluasi_ditutup';
			$query['select'][] = 'evalkelas.evaluasi_durasi';
			$query['select'][] = 'evalkelas.limit_akses';
			$query['select']['waktu_mulai_kerja'] = 'ljs.waktu';
			$query['select']['waktu_selesai_kerja'] = 'ljs.dikoreksi';

			$query['order_by'] = 'evalkelas.evaluasi_mulai desc';
			
			// aktif ikut evaluasi
			$query['where']['evaluasi.status != '] = 'closed';
			
			// aktif ikut evaluasi
			$query['where']['nilai.aktif'] = 1;
			
		//elseif ((!$dm['view'] && $dm['mengajar_list']) && (!isset($r['semester_id']))):
			//$query['where']['evaluasi.author_id'] = $d['user']['id'];
		
		//elseif ((!$dm['view'] && $dm['mengajar_list']) && ($r['semester_id'] == 0 )):
			//$query['where_in']['evaluasi.pelajaran_id'] = $dm['mengajar_list'];
				
		//elseif ((!$dm['view'] && $dm['mengajar_list']) && ($r['semester_id'] == $d['semaktif']['id'])):
			//$query['where_in']['evaluasi.pelajaran_id'] = $dm['mengajar_list'];

		elseif (!$dm['view']):
			
			if($rowset=='rowset'){
				$query['where_strings'][] = "(pelajaran.guru_id = ".$d['user']['id'].") OR 
												(kelas.wali_id = ".$d['user']['id'].")";
			}else{
				$query['where']['pelajaran.guru_id'] = $d['user']['id'];
			}
			
		endif;

		//if (!$dm['admin'])
			//$query['where']['evaluasi.status !='] = 'deleted';

		return $query;

	}

	// operasi data

	/*
	 * fungsi untuk menganalisa butir soal dan mengelompokan nilai siswa ke golongan: atas,tengah,bawah
	 * algoritma umum:
	 * - hanya khusus admin atau author yg bis. dan bila memang ada parameter analisa
	 * - status evaluasi sudah dipublish
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
		$evaluasi_id = (int) $d['row']['id'];

		if (!$analisa_cek OR ! $grants)
			return;

		if (!in_array($d['row']['status'], array('published')))
			return alert_info('Evaluasi masih berupa draft, belum selesai disusun.');

		if ($d['row']['siswa_menjawab'] < 3)
			return alert_info('Peserta evaluasi yg mengerjakan masih dibawah 3.');

		if ($d['row']['analisa_valid'])
			return alert_info('Analisa evaluasi masih valid.');

		// cek ljs yg belum dikoreksi

		$sql_nonkoreksi = "select count(*) jml from kbm_evaluasi_nilai where evaluasi_id = ? and ljs_id is not null and evaluasi_terkoreksi = 0 and trial = 0";
		$jml_nonkoreksi = (int) $this->md->row_col('jml', $sql_nonkoreksi, array($evaluasi_id));

		if ($jml_nonkoreksi > 0)
			return alert_error("Masih ada {$jml_nonkoreksi} LJS yang belum dikoreksi.");

		// mulai pengelompokan

		$trx = $this->analisa_grouping($evaluasi_id);

		if (!$trx)
			return alert_error('Analisa error saat mengelompokkan nilai peserta.', FALSE);

		$trx = $this->analisa_soal($evaluasi_id, $d['row']['siswa_total']);

		if ($trx)
			return alert_info('Analisa butir soal selesai.');

		return alert_error('Analisa error saat mengelompokkan nilai peserta.', FALSE);

	}

	function analisa_grouping($evaluasi_id)
	{
		$nilai_query = array(
			'from'		 => 'kbm_evaluasi_nilai',
			'where'		 => array(
				'evaluasi_id'	 => $evaluasi_id,
				'trial'			 => 0,
			),
			'order_by'	 => 'evaluasi_nilai desc',
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
				'evaluasi_kelompok'	 => $_grup,
			);

		endforeach;

		$this->db->trans_start();
		$this->db->update_batch('kbm_evaluasi_nilai', $kelompok_array, 'id');

		return $this->trans_done();

	}

	function analisa_soal($evaluasi_id, $siswa_total)
	{
		$d = & $this->ci->d;
		$siswa_total = (int) $siswa_total;
		$bindings = array(
			0	 => $evaluasi_id,
			1	 => $evaluasi_id,
			2	 => $siswa_total,
			3	 => $siswa_total,
			4	 => $siswa_total,
			5	 => $evaluasi_id,
		);
		$sql = "
update kbm_evaluasi_soal soal

left join
	(
	select
		jawaban.soal_id,
		sum(jawaban.poin) poin_jml

	from kbm_evaluasi_jawaban jawaban

	inner join kbm_evaluasi_nilai nilai on jawaban.ljs_id = nilai.ljs_id

	where	nilai.evaluasi_id = ?
	and	nilai.trial = 0
	and	evaluasi_kelompok = 'atas'

	group by
		jawaban.soal_id

	) kel_atas on soal.id = kel_atas.soal_id

left join
	(
	select
		jawaban.soal_id,
		sum(jawaban.poin) poin_jml

	from kbm_evaluasi_jawaban jawaban

	inner join kbm_evaluasi_nilai nilai on jawaban.ljs_id = nilai.ljs_id

	where	nilai.evaluasi_id = ?
	and	nilai.trial = 0
	and	evaluasi_kelompok = 'bawah'

	group by
		jawaban.soal_id

	) kel_bawah on soal.id = kel_bawah.soal_id

set
	soal.analisa_jml_atas = IFNULL(kel_atas.poin_jml, 0),
	soal.analisa_jml_bawah = IFNULL(kel_bawah.poin_jml, 0),
	analisa_index_tk = ( ( ( IFNULL(kel_atas.poin_jml, 0) + IFNULL(kel_bawah.poin_jml, 0) ) - ( 2 * ( ? / 4 ) * poin_min ) ) / ( 2 * ( ? / 4 ) * ( poin_max - poin_min ) ) ),
	analisa_index_db = ( ( IFNULL(kel_atas.poin_jml, 0) - IFNULL(kel_bawah.poin_jml, 0) ) / ( ( ? / 4 ) * ( poin_max - poin_min ) ) )

where
	soal.evaluasi_id = ?
";
		$evaluasi = array(
			'analisa_waktu'	 => $d['datetime'],
			'analisa_valid'	 => 1,
		);

		$this->db->trans_start();
		$this->db->query($sql, $bindings);
		$this->db->update('kbm_evaluasi', $evaluasi, array('id' => $evaluasi_id));

		return $this->trans_done();

	}

	function availability($row, $alert = FALSE)
	{
		$dm = & $this->dm;
		$d = & $this->ci->d;
		$u = & $this->ci->d['user'];

		// mutlak, pencegah error

		if ($row['soal_total'] == 0)
			return (!$alert) ? FALSE : alert_error('Butir soal evaluasi tidak ditemukan.');

		// guru/admin trial

		$d['pengajar_ybs'] = mengajar($row['pelajaran_id']);
		$d['author_ybs'] = ($u['id'] == $row['author_id']);

		if ($u['role'] != 'siswa' && ($dm['view'] OR $d['pengajar_ybs'] OR $d['author_ybs']))
			return TRUE;

		// ngecek isi evaluasi itu sendiri

		if (!$row['published'])
			return (!$alert) ? FALSE : alert_error('Evaluasi ini belum dipublikasikan.');

		if ($row['closed'])
			return (!$alert) ? FALSE : alert_error('Evaluasi tersebut telah ditutup.');

		if ($d['semaktif']['id'] != $row['semester_id'])
			return (!$alert) ? FALSE : alert_error('Evaluasi tersebut tidak berlaku lagi.');

		// cek usernya (siswa)

		if (!isset($row['ljs_count']) OR ! isset($row['evaluasi_terkoreksi']) OR ! isset($row['kelas_list']) OR ! isset($row['kelas_result']))
			return (!$alert) ? FALSE : alert_error('Data evaluasi error.');

		if ($row['ljs_max'] > 0 && $row['ljs_max'] <= $row['ljs_count'])
			return (!$alert) ? FALSE : alert_error('Anda telah menggunakan semua kesempatan untuk menjawab.');

		if ($row['ljs_id'] && !$row['evaluasi_terkoreksi'])
			return (!$alert) ? FALSE : alert_error('Jawaban sebelumnya belum dikoreksi.');

		if (!in_array($row['kelas_id'], $row['kelas_list']))
			return (!$alert) ? FALSE : alert_error('Kelas Anda tidak termasuk dalam evaluasi ini.');

		$kelas = $row['kelas_result']['data'][$row['kelas_id']];

		if ($kelas['evaluasi_mulai'] && $kelas['evaluasi_mulai'] > $d['datetime'])
			return (!$alert) ? FALSE : alert_error('Evaluasi tersebut belum dimulai.');

		if ($kelas['evaluasi_ditutup'] && $kelas['evaluasi_ditutup'] < $d['datetime'])
			return (!$alert) ? FALSE : alert_error('Evaluasi tersebut telah selesai.');

		//  SISA WAKTU SISWA MENGERJAKAN
		if (isset($d['pengerjaan_ljs']['waktu']))
		{
			$waktu_awal_pengerjaan = strtotime($d['pengerjaan_ljs']['waktu']);
			$siswa_waktu = strtotime($d['datetime']) - $waktu_awal_pengerjaan ;
			$durasi		 = JamToDetik($kelas['evaluasi_durasi']);
			if($durasi<$siswa_waktu)
			{
				return (!$alert) ? FALSE : alert_error('Waktu Pengerjaan Siswa pada Evaluasi tersebut telah selesai.');
			}
			//if(TIME_LJS < $siswa_waktu)
				//return (!$alert) ? FALSE : alert_error('Waktu Pengerjaan Siswa pada Evaluasi tersebut telah selesai.');
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
		$query = $this->query_1('rowset');
		$query['where']['evaluasi.id'] = $id;
		$row = $this->md->query($query)->row();
		$query_kelas = array(
			'select'	 => array(
				'evakls.*',
				'kelas_nama' => 'kelas.nama',
				'kelas_grade' => 'kelas.grade',
			),
			'from'		 => 'kbm_evaluasi_kelas evakls',
			'join'		 => array(
				array('dakd_kelas kelas', 'evakls.kelas_id = kelas.id', 'inner'),
			),
			'order_by'	 => 'kelas.grade, kelas.jurusan_id, kelas.nama',
			'where'		 => array(
				'evakls.evaluasi_id' => $id,
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
	
	function upload_doc($upload_path, $input)
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
		if (!in_array($upload_ext, $this->filetypes2))
		{
			@unlink($file['full_path']);

			return alert_error('Tipe file tidak sesuai. Seharusnya berekstensi: ' . implode(', ', $this->filetypes2));
		}

		// mengembalikan data upload
		return $file;

	}
	
	function save_dokumen()
	{
		$d = & $this->ci->d;
		$edit = (bool) $d['form']['id'];
		$evaluasi_id = (int) $d['form']['id'];
		$upload_path = APP_ROOT."content/".strtolower(APP_SCOPE)."/document/";
		$input = "upload";
		$upload_file = $this->upload_doc($upload_path,$input);
		
		$msg_sukses = "";
		

		if ($file):
			$old_path = array_node($d, array('form', 'upload', 'full_path'));
			$old_path = APP_ROOT.$old_path;
			//$old_path = APP_ROOT.$d['form']['upload']['full_path'];

			delete($old_path);

			$d['form']['upload'] = $file;
			$d['form']['upload']['full_path'] = APP_ROOT.$d['form']['upload']['full_path'];
//alert_error("A ".$d['form']['upload']['full_path']);
		endif;

		$this->form->ruleset($d['row'], 'validasi');
		$this->form->validate();
		
		$data['file'] = $upload_file['full_path'];
		// perubahan data

		if (!empty($data)):

			$this->db->trans_start();

			$updfilter['id'] = $evaluasi_id;
			
			$this->db->update('kbm_evaluasi', $data, $updfilter);

			if ($edit)
				$msg_sukses = 'Data evaluasi berhasil disimpan.';

			$trx = $this->trans_done();

			if (!$trx)
				return alert_error('Database error saat menyimpan evaluasi, coba beberapa saat lagi.');

		endif;

		return alert_success($msg_sukses);
	}
		
	function save()
	{
		$d = & $this->ci->d;
		$edit = (bool) $d['form']['id'];
		$msg_sukses = "Evaluasi berhasil disimpan.";
		$kelas_jadwal = NULL;
		$evaluasi_id = $d['form']['id'];
		$pelajaran_nilai_id = $d['row']['pelajaran_nilai_id'];

		$upload_path = APP_ROOT."content/".strtolower(APP_SCOPE)."/sound/";
		$input = "audio";
		$upload_sound = $this->upload($upload_path,$input);
		
		//bobot_nilai
		if ($d['modit']['bobot'])
			$this->form->ruleset($d['row'], 'validasi-bobot');
		
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
		
		//bobot nilai
		if ($d['modit']['bobot'])
			$data = $this->input('fields-bobot', $data);
		
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

		if ( ($d['modit']['uraian'])||($d['modit']['bobot']) ){
			
		}else{	
			$kelas_jadwal = $this->input_jadwal($pelajaran_nilai_id);
			if (empty($kelas_jadwal))
				alert_error('Jadwal kelas harus diisi.');
		}
			
		//alert_error($evaluasi_id.'AAAAA. '.$data['detail_uraian']);
		
		//if ($d['error'])
			//return FALSE;

		// mulai proses penyimpanan

		// SET LJS MAXIMAL 1
		$data['ljs_max'] = 1;
		if($data['soal_jml'] == ''){
			$data['soal_jml'] = 0;
		}
		
		// IF UPLOAD DOKUMEN
		if($data['metode'] == 'upload_dokumen_soal'){
			$data['soal_acak'] = 0;
		}
		
		$this->db->trans_start();

		if (!$edit):

			// siapkan data

			$data['semester_id'] = $d['semaktif']['id'];
			$data['author_id'] = $d['user']['id'];
			$data['registered'] = $d['datetime'];
			$data['cuplikan'] = '';
			$data['konten'] = '';
			$data['audio'] = '';
			$data['detail_uraian']='';
			
			// prosesi insert

			$this->db->insert('kbm_evaluasi', $data);

			// id baru ditampung di tabel terpisah dulu biar gak konflik saat error

			$evaluasi_id = $this->db->insert_id();
			$trx_status = $this->db->trans_status();

			if (!$trx_status OR ! $evaluasi_id)
				return $this->trans_rollback('Database error saat menyimpan evaluasi baru, coba beberapa saat lagi.');

			// insert berhasil

			$data = array();
			$msg_sukses = "Evaluasi baru berhasil ditambahkan.";

		endif;
		
		if ( ($d['modit']['uraian'])||($d['modit']['bobot']) ){
			
		}else{	
			// hapus data jadwal sebelumnya

			if ($edit)
				$this->db->delete('kbm_evaluasi_kelas', array('evaluasi_id' => $evaluasi_id));

			// entri jadwal baru

			$klsjadwal_array = array();

			foreach ($kelas_jadwal as $kid => $jadwal):
				$jadwal['kelas_id'] = $kid;
				$jadwal['evaluasi_id'] = $evaluasi_id;
				$klsjadwal_array[] = $jadwal;

			endforeach;

			//alert_dump($klsjadwal_array);

			if ($klsjadwal_array):
				$this->db->insert_batch('kbm_evaluasi_kelas', $klsjadwal_array);
			endif;
		}
		// perubahan data
		
		
		if (!empty($data)):
			if($upload_sound)
			{
				$data['audio'] = $upload_sound['full_path'];
			}
			$this->db->update('kbm_evaluasi', $data, array('id' => $evaluasi_id));

			if ($edit)
				$msg_sukses = 'Data evaluasi berhasil disimpan.';

		endif;

		// selesai

		$trx = $this->trans_done($msg_sukses, 'Database error, coba beberapa saat lagi.');

		if ($trx && !$edit)
			$d['form']['id'] = $evaluasi_id;

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

		// cek data kelas peserta evaluasi

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
		
		$evaluasi_durasi 	= (array) $this->input->post('evaluasi_durasi');
		$limit_akses 		= (array) $this->input->post('limit_akses');
		
		if($this->input->post('evaluasi_mulai')){
			$cek=1;
			$evaluasi_mulai = (array) $this->input->post('evaluasi_mulai');
			$evaluasi_ditutup = (array) $this->input->post('evaluasi_ditutup');
		}else{
			$cek=2;
			$evaluasi_mulai_date = (array) $this->input->post('evaluasi_mulai_date');
			$evaluasi_mulai_time = (array) $this->input->post('evaluasi_mulai_time');
			$evaluasi_ditutup_date = (array) $this->input->post('evaluasi_ditutup_date');
			$evaluasi_ditutup_time = (array) $this->input->post('evaluasi_ditutup_time');
		}
		$kelas_jadwal = array();
		
		foreach ($kelas_list as $kid => $knama):
			$ceki=0;
			if($this->input->post('evaluasi_mulai')){
				$ceki=1;
				$_jadwal = array(
					'evaluasi_mulai'	 => datefix(array_node($evaluasi_mulai, $kid)),
					'evaluasi_ditutup'	 => datefix(array_node($evaluasi_ditutup, $kid)),
					'evaluasi_durasi'	 => array_node($evaluasi_durasi, $kid),
					'limit_akses'		 => array_node($limit_akses, $kid),
				);

				
			}else{
				$ceki=2;
				$emulai_date = str_replace('/', '-', array_node($evaluasi_mulai_date, $kid));
				$emulai_date = date("Y-m-d",strtotime($emulai_date));
				$editutup_date = str_replace('/', '-', array_node($evaluasi_ditutup_date, $kid));
				$editutup_date = date("Y-m-d",strtotime($editutup_date));
				$emulai_time = date("H:i:s",strtotime(array_node($evaluasi_mulai_time, $kid)));
				$editutup_time = date("H:i:s",strtotime(array_node($evaluasi_ditutup_time, $kid)));
				
				$evaluasi_mulai = date("Y-m-d H:i:s", strtotime( $emulai_date ." ". $emulai_time ));
				$evaluasi_ditutup = date("Y-m-d H:i:s",strtotime( $editutup_date ." ". $editutup_time ));
				
				$_jadwal = array(
					'evaluasi_mulai'	 => $evaluasi_mulai,
					'evaluasi_ditutup'	 => $evaluasi_ditutup,
					'evaluasi_durasi'	 => array_node($evaluasi_durasi, $kid),
					'limit_akses'	 	 => array_node($limit_akses, $kid),
				);
			}
			
			

			if (!$_jadwal['evaluasi_mulai']):
				alert_error("Waktui mulai kelas {$knama} harus diisi dengan format tanggal-jam yang benar. format: yyyy-mm-dd. ".$_jadwal['evaluasi_mulai'].
				" ".$emulai_date." | ".$cek." | ".$ceki);
				continue;
			endif;

			if ($_jadwal['evaluasi_mulai'] && $_jadwal['evaluasi_ditutup'] && $_jadwal['evaluasi_mulai'] >= $_jadwal['evaluasi_ditutup']):
				alert_error("Waktu selesai kelas {$knama} salah, harus sesudah dimulai.". $evaluasi_mulai." ".$emulai_time." ".$evaluasi_ditutup);
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
		 * - update publish data evaluasi.
		 * - insert entry nilai [kbm_evaluasi_nilai] untuk tiap siswa
		 *
		 * * tunggu semua nilai masuk sebelum update nilai rata2 masing2
		 */

		$d = & $this->ci->d;
		$evaluasi_id = (int) $d['form']['id'];
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
				'evaluasi_id'	 => $evaluasi_id,
			);
		endforeach;

		// data update evaluasi

		$evaluasi_upd = array(
			'status'		 => 'published',
			'published'		 => $d['datetime'],
			'siswa_total'	 => $peserta_result['selected_rows'],
		);

		// update status evaluasi

		$this->db->trans_start();
		$this->db->update('kbm_evaluasi', $evaluasi_upd, array('id' => $evaluasi_id));
		$this->db->insert_batch('kbm_evaluasi_nilai', $evanil_array);

		$trx = $this->trans_done("Evaluasi berhasil dipublikasikan ke {$peserta_result['selected_rows']} siswa.", 'Database error, coba beberapa saat lagi.');

		if ($trx):
			$this->db->trans_start();
			$this->m_kbm_evaluasi_ljs->update_pengerjaan($evaluasi_id);
			$this->trans_done();
		endif;

		return $trx;

	}

	function tutup()
	{
		/*
		 * overview:
		 * - ambil data siswa peserta pelajaran saat ini.
		 * - update publish data evaluasi.
		 * - insert entry nilai [kbm_evaluasi_nilai] untuk tiap siswa
		 *
		 * * tunggu semua nilai masuk sebelum update nilai rata2 masing2
		 */

		$d = & $this->ci->d;
		$evaluasi_id = (int) $d['form']['id'];

		// data update evaluasi

		$evaluasi_upd = array(
			'status' => 'closed',
			'closed' => $d['datetime'],
		);

		// update status evaluasi

		$this->db->trans_start();
		$this->db->update('kbm_evaluasi', $evaluasi_upd, array('id' => $evaluasi_id));

		// fu: analisa evaluasi??

		return $this->trans_done("Evaluasi berhasil ditutup.", 'Database error, coba beberapa saat lagi.');

	}
	
	function buka()
	{

		$d = & $this->ci->d;
		$evaluasi_id = (int) $d['form']['id'];

		// data update evaluasi

		$evaluasi_upd = array(
			'status' => 'published',
			'closed' => NULL,
		);

		// update status evaluasi

		$this->db->trans_start();
		$this->db->update('kbm_evaluasi', $evaluasi_upd, array('id' => $evaluasi_id));

		// fu: analisa evaluasi??

		return $this->trans_done("Evaluasi berhasil di buka.", 'Database error, coba beberapa saat lagi.');

	}

	function delete()
	{
		/*
		 * overview:
		 * - ambil data siswa peserta pelajaran saat ini.
		 * - update publish data evaluasi.
		 * - insert entry nilai [kbm_evaluasi_nilai] untuk tiap siswa
		 *
		 * * tunggu semua nilai masuk sebelum update nilai rata2 masing2
		 */

		$d = & $this->ci->d;
		$evaluasi_id = (int) $d['form']['id'];

		// data update evaluasi

		$evaluasi_upd = array(
			'status'	 => 'deleted',
			'updated'	 => $d['datetime'],
			'editor_id'	 => $d['user']['id'],
		);

		// update status evaluasi

		$this->db->trans_start();
		$this->db->update('kbm_evaluasi', $evaluasi_upd, array('id' => $evaluasi_id));

		// fu: analisa evaluasi??

		return $this->trans_done("Evaluasi berhasil dihapus.", 'Database error, coba beberapa saat lagi.');

	}

	function rekap()
	{
		$this->load->helper('costumized/' . APP_SCOPE);
		$this->load->model('m_nilai_siswa');
		$this->load->model('m_nilai_pelajaran');
		$this->load->model('m_nilai_pelajaran_kelas');

		$d = & $this->ci->d;
		$evaluasi_id = (int) $d['row']['id'];
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
inner join kbm_evaluasi_nilai evanil on evanil.user_id = nisis.siswa_id

set
	nisispel.{$kolom} = evanil.evaluasi_nilai,
	nisispel.valid = 0

where nisispel.pelajaran_nilai_id = ?
  and evanil.trial = 0 and evanil.evaluasi_id = ?
  and nisis.kelas_id = {$kelas_id}
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
		$limit = $d['dto']->format('00:00');
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
				'evaluasi_mulai'	 => "'{$dths}'",
				'evaluasi_ditutup'	 => "''",
				'evaluasi_durasi'	 => "'{$durasi}'",
				'limit_akses'	 	 => "'{$limit}'",
			),
		);

		if ($row['id'] > 0):
			$subsql = "select * from kbm_evaluasi_kelas where evaluasi_id = {$row['id']}";
			$query['join'][] = array("({$subsql}) kbm_evakls", 'kelas.id = kbm_evakls.kelas_id', 'left');
			$query['select']['evaluasi_mulai'] = "IFNULL(kbm_evakls.evaluasi_mulai, '{$dths}')";
			$query['select']['evaluasi_durasi'] = "IFNULL(kbm_evakls.evaluasi_durasi, '{$durasi}')";
			$query['select']['limit_akses'] 	= "IFNULL(kbm_evakls.limit_akses, '{$limit}')";
			$query['select']['evaluasi_ditutup'] = "kbm_evakls.evaluasi_ditutup";

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

	function reuse($fromEvaluasi_id)
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

		///// EVALUASI
		$nilpel = $this->md->row($sql_nilpel);
		$pelajaran_nilai_id = $nilpel['id'];
		$author_id = $d['user']['id'];
		$sql_copy_evaluasi = <<<SQL

INSERT INTO
	kbm_evaluasi
	(
		author_id, kisi_kisi, pelajaran_id, pelajaran_nilai_id, status,
		semester_id, nama, tipe, metode, jml_kd, kop, audio, kkm, pilihan_jml, 
		soal_jml, soal_total, soal_acak, soal_bank, show_webcam, ljs_max, jadwal_perkelas, registered, updated
		, plus_isian, plus_uraian, detail_uraian, file,
		cuplikan, konten
	)

SELECT
	author_id, kisi_kisi, {$newPelajaran_id}, {$pelajaran_nilai_id}, 'draft',
	{$semester_id}, nama, tipe, metode, jml_kd, kop, audio, kkm, pilihan_jml,
	soal_jml, soal_total, soal_acak, soal_bank, show_webcam, ljs_max, jadwal_perkelas, registered, updated
	, plus_isian, plus_uraian, detail_uraian, file,
	cuplikan, konten

FROM
	kbm_evaluasi

WHERE
	id = {$fromEvaluasi_id}
;

SQL;
		$this->db->query($sql_copy_evaluasi);

		if ($this->db->trans_status() === FALSE)
		{
			$this->db->trans_rollback();

			return alert_error("error saat menjalankan: <br/> {$sql_copy_evaluasi}");
		}

		//// EVALUASI KELAS
		$newEvaluasi_id = $this->db->insert_id();
		$sql_evaluasi_kelas = <<<SQL

INSERT INTO
	kbm_evaluasi_kelas
	(
		evaluasi_id,
		kelas_id
	)

SELECT
	{$newEvaluasi_id},
	kelas_id

FROM
	nilai_pelajaran_kelas

WHERE
	pelajaran_nilai_id = {$pelajaran_nilai_id}
;

SQL;
		$this->db->query($sql_evaluasi_kelas);

		if ($this->db->trans_status() === FALSE)
		{
			$this->db->trans_rollback();

			return alert_error("error saat menjalankan: <br/> {$sql_evaluasi_kelas}");
		}

		
		//// EVALUASI PEMBAGIAN KD
		$sql_evaluasi_pembagian_kd = <<<SQL

INSERT INTO
	kbm_evaluasi_pembagian_kd
	(
		evaluasi_id,
		posisi_kd,
		nama,
		soal_jml,
		keterangan,
		registered,
		updated,
		editor_id
	)

SELECT
	{$newEvaluasi_id},
	posisi_kd,
	nama,
	soal_jml,
	keterangan,
	registered,
	updated,
	editor_id

FROM
	kbm_evaluasi_pembagian_kd

WHERE
	evaluasi_id = {$fromEvaluasi_id}
;

SQL;
		$this->db->query($sql_evaluasi_pembagian_kd);

		if ($this->db->trans_status() === FALSE)
		{
			$this->db->trans_rollback();

			return alert_error("error saat menjalankan: <br/> {$sql_evaluasi_pembagian_kd}");
		}
		
		
		//// EVALUASI SOAL
		$sql_butir_soal = <<<SQL

INSERT INTO
	kbm_evaluasi_soal
	(
		evaluasi_id,
		nomor, type, nilai_bonus, cuplikan, posisi_kd, audio, 
		komp_dasar_id, materi, level_kognitif, indikator, 
		pertanyaan, pilihan_ganda, poin_min, poin_max, pilihan,
		kunci_isian1, kunci_isian2, kunci_isian3, kunci_isian4, kunci_isian5, kunci_isian6, 
		kunci_isian7, kunci_isian8, kunci_isian9, toleran_huruf_kapital,
		registered
	)

SELECT
	{$newEvaluasi_id},
	nomor, type, nilai_bonus,  cuplikan, posisi_kd, audio, 
	komp_dasar_id, materi, level_kognitif, indikator, 
	pertanyaan, pilihan_ganda, poin_min, poin_max, pilihan,
	kunci_isian1, kunci_isian2, kunci_isian3, kunci_isian4, kunci_isian5, kunci_isian6, 
	kunci_isian7, kunci_isian8, kunci_isian9, toleran_huruf_kapital,
	registered

FROM
	kbm_evaluasi_soal

WHERE
	evaluasi_id = {$fromEvaluasi_id}
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

		return $newEvaluasi_id;

	}

	function reuse2($fromEvaluasi_id)
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
		$sql_copy_evaluasi = <<<SQL

INSERT INTO
	kbm_evaluasi
	(
		author_id, pelajaran_id, pelajaran_nilai_id, status,
		semester_id, nama, tipe, metode, jml_kd, audio, kkm, pilihan_jml, 
		soal_jml, soal_total, soal_acak, soal_bank, ljs_max, jadwal_perkelas, registered, updated
	)

SELECT
	author_id, {$newPelajaran_id}, {$pelajaran_nilai_id}, 'draft',
	semester_id, nama, tipe, metode, jml_kd, audio, kkm, pilihan_jml,
	soal_jml, soal_total, soal_acak, soal_bank, ljs_max, jadwal_perkelas, registered, updated

FROM
	kbm_evaluasi

WHERE
	id = {$fromEvaluasi_id}
;

SQL;
		$this->db2->query($sql_copy_evaluasi);

		if ($this->db2->trans_status() === FALSE)
		{
			$this->db2->trans_rollback();

			return alert_error("error saat menjalankan: <br/> {$sql_copy_evaluasi}");
		}

		$newEvaluasi_id = $this->db2->insert_id();
		$sql_evaluasi_kelas = <<<SQL

INSERT INTO
	kbm_evaluasi_kelas
	(
		evaluasi_id,
		kelas_id
	)

SELECT
	{$newEvaluasi_id},
	kelas_id

FROM
	nilai_pelajaran_kelas

WHERE
	pelajaran_nilai_id = {$pelajaran_nilai_id}
;

SQL;
		$this->db2->query($sql_evaluasi_kelas);

		if ($this->db2->trans_status() === FALSE)
		{
			$this->db2->trans_rollback();

			return alert_error("error saat menjalankan: <br/> {$sql_evaluasi_kelas}");
		}

		$sql_butir_soal = <<<SQL

INSERT INTO
	kbm_evaluasi_soal
	(
		evaluasi_id,
		posisi_kd, audio, pertanyaan, pilihan_ganda, poin_min, poin_max, pilihan, registered
	)

SELECT
	{$newEvaluasi_id},
	posisi_kd, audio, pertanyaan, pilihan_ganda, poin_min, poin_max, pilihan, registered

FROM
	kbm_evaluasi_soal

WHERE
	evaluasi_id = {$fromEvaluasi_id}
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

		return $newEvaluasi_id;

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

	function reuse_OLD($fromEvaluasi_id)
	{
		$d = & $this->ci->d;
		$newPelajaran_id = (int) $this->input->post('pelajaran_id');
		$sql_copy_evaluasi = <<<SQL

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
	kbm_evaluasi
	(
		author_id, pelajaran_id, pelajaran_nilai_id, status,
		semester_id, nama, tipe, metode, kkm, pilihan_jml, soal_jml, soal_total, soal_acak, soal_bank, jadwal_perkelas, registered, updated
	)

SELECT
	@author_id, {$newPelajaran_id}, @pelajaran_nilai_id, 'draft',
	semester_id, nama, tipe, metode, kkm, pilihan_jml, soal_jml, soal_total, soal_acak, soal_bank, jadwal_perkelas, registered, updated

FROM
	kbm_evaluasi

WHERE
	id = {$fromEvaluasi_id}
;

SQL;

		$this->db->query($sql_copy_evaluasi);

		$newEvaluasi_id = $this->db->insert_id();

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
	kbm_evaluasi_kelas
	(
		evaluasi_id,
		kelas_id
	)

SELECT
	{$newEvaluasi_id},
	kelas_id

FROM
	nilai_pelajaran_kelas

WHERE
	pelajaran_nilai_id = @pelajaran_nilai_id
;

INSERT INTO
	kbm_evaluasi_soal
	(
		evaluasi_id,
		pertanyaan, pilihan_ganda, poin_min, poin_max, pilihan, registered
	)

SELECT
	{$newEvaluasi_id},
	pertanyaan, pilihan_ganda, poin_min, poin_max, pilihan, registered

FROM
	kbm_evaluasi_soal

WHERE
	evaluasi_id = {$fromEvaluasi_id}
;

SQL;

		$this->db->query($sql_copy_soal);

		return $newEvaluasi_id;

	}

	function reuse_old_2($fromEvaluasi_id)
	{
		$d = & $this->ci->d;
		$newPelajaran_id = (int) $this->input->post('pelajaran_id');
		$sql_copy_evaluasi = <<<SQL

# atur variabel
SET @fromEvaluasi_id = {$fromEvaluasi_id}; # diisi id evaluasi yg hendak dicopy
SET @newPelajaran_id = {$newPelajaran_id}; # diisi id pelajaran yg hendak diisi evaluasi

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

# Copy evaluasi

INSERT INTO
	kbm_evaluasi
	(
		author_id, pelajaran_id, pelajaran_nilai_id, status,
		semester_id, nama, tipe, metode, kkm, pilihan_jml, soal_jml, soal_total, soal_acak, soal_bank, jadwal_perkelas, registered, updated
	)

SELECT
	@author_id, @newPelajaran_id, @pelajaran_nilai_id, 'draft',
	semester_id, nama, tipe, metode, kkm, pilihan_jml, soal_jml, soal_total, soal_acak, soal_bank, jadwal_perkelas, registered, updated

FROM
	kbm_evaluasi

WHERE
	id = @fromEvaluasi_id
;

# simpan id evaluasi tersimpan

SET @newEvaluasi_id = LAST_INSERT_ID();

# susun daftar kelas

INSERT INTO
	kbm_evaluasi_kelas
	(
		evaluasi_id,
		kelas_id
	)

SELECT
	@newEvaluasi_id,
	kelas_id

FROM
	nilai_pelajaran_kelas

WHERE
	pelajaran_nilai_id = @pelajaran_nilai_id
;

# copy butir soal

INSERT INTO
	kbm_evaluasi_soal
	(
		evaluasi_id,
		pertanyaan, pilihan_ganda, poin_min, poin_max, pilihan, registered
	)

SELECT
	@newEvaluasi_id,
	pertanyaan, pilihan_ganda, poin_min, poin_max, pilihan, registered

FROM
	kbm_evaluasi_soal

WHERE
	evaluasi_id = @fromEvaluasi_id
;


SELECT @newEvaluasi_id;
SQL;

		$this->db->query($sql_copy_evaluasi);

		return $newPelajaran_id;

	}

}
