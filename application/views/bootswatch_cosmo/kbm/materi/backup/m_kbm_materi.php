<?php

class M_kbm_materi extends MY_Model
{

	public function __construct()
	{
		parent::__construct(array(
			'fields'			 => array('nama', 'konten', 'pertanyaan', 'tanggal_publish', 'tanggal_tutup'),
			'fields-pelajaran'	 => array('pelajaran_id'),
		));
		$this->dm['admin'] = cfguc_admin('akses', 'kbm', 'materi');
		$this->dm['view'] = cfguc_view('akses', 'kbm', 'materi');
		$this->dm['mengajar_list'] = (array) cfgu('mengajar_list');
		$this->dm['pelajaran_list'] = (array) cfgu('pelajaran_list');

	}

	// dasar database

	function filter_1($query)
	{
		$d = & $this->ci->d;
		$r = & $this->ci->d['request'];

		// normalisasi

		if (!isset($r['semester_id']) OR ! $r['semester_id'])
			$r['semester_id'] = $d['semaktif']['id'];

		// filtering

		if (isset($r['term']))
			$query['like'] = array($r['term'], array('materi.nama'));

		if (isset($r['semester_id']) && $r['semester_id'] > 0)
			$query['where']['materi.semester_id'] = $r['semester_id'];

		if (isset($r['mapel_id']) && $r['mapel_id'] > 0)
			$query['where']['pelajaran.mapel_id'] = $r['mapel_id'];

		if (isset($r['pelajaran_id']) && $r['pelajaran_id'] > 0)
			$query['where']['materi.pelajaran_id'] = $r['pelajaran_id'];

		if (isset($r['author_id']) && $r['author_id'] > 0)
			$query['where']['materi.author_id'] = $r['author_id'];

		if (isset($r['tanggal_publish']))
			$this->md->like($r['tanggal_publish'], 'materi.tanggal_publish');
		
		return $query;

	}

	function filtering()
	{
		$d = & $this->ci->d;
		$r = & $this->ci->d['request'];

		// normalisasi

		if (!isset($r['semester_id']) OR ! $r['semester_id'])
			$r['semester_id'] = $d['semaktif']['id'];

		// filtering

		if (isset($r['term']))
			$this->md->like($r['term'], 'materi.nama');

		if (isset($r['semester_id']) && $r['semester_id'] > 0)
			$this->db->where('materi.semester_id', $r['semester_id']);

		if (isset($r['mapel_id']) && $r['mapel_id'] > 0)
			$this->db->where('pelajaran.mapel_id', $r['mapel_id']);

		if (isset($r['pelajaran_id']) && $r['pelajaran_id'] > 0)
			$this->db->where('materi.pelajaran_id', $r['pelajaran_id']);

		if (isset($r['author_id']) && $r['author_id'] > 0)
			$this->db->where('materi.author_id', $r['author_id']);

		if (isset($r['tanggal_publish']))
			$this->md->like($r['tanggal_publish'], 'materi.tanggal_publish');
	}

	function query_2()
	{
		$d = & $this->ci->d;
		$dm = & $this->dm;
		$query = array(
			'select'	 => array(
				'semester_nama'	 => 'semester.nama',
				'ta_nama'		 => 'ta.nama',
				'author_nama'	 => "trim(concat_ws(' ', author.prefix, author.nama, author.suffix))",
				'pelajaran_kode' => 'pelajaran.kode',
				'pelajaran_nama' => 'pelajaran.nama',
				'mapel_nama'	 => 'mapel.nama',
				'tanggal_publish'	 => 'materi.tanggal_publish',
				'tanggal_tutup'		 => 'materi.tanggal_tutup',
				'semester.ta_id',
			),
			'from'		 => 'kbm_materi materi',
			'join'		 => array(
				array('prd_semester semester', 'materi.semester_id = semester.id', 'inner'),
				array('prd_ta ta', 'semester.ta_id = ta.id', 'inner'),
				array('dprofil_sdm author', 'materi.author_id = author.id', 'inner'),
				array('dakd_pelajaran pelajaran', 'materi.pelajaran_id = pelajaran.id', 'inner'),
				array('dakd_mapel mapel', 'pelajaran.mapel_id = mapel.id', 'inner'),
			),
			'order_by'	 => 'materi.semester_id desc, pelajaran.nama, materi.id',
			'where'	 	 => array('materi.aktif' => 1),
		);

		if ($d['user']['role'] == 'siswa'):
			$query['join'][] = array('kbm_materi_baca baca', 'materi.id = baca.materi_id', 'inner');
			$query['where']['baca.user_id'] = $d['user']['id'];
			$query['select']['baca_id'] = 'baca.id';
			$query['select'][] = 'baca.baca_waktu';
			$query['select'][] = 'baca.baca_count';
			$query['select'][] = 'baca.respon_waktu';
			$query['select'][] = 'baca.respon_cuplikan';
			
			$now = date("Y-m-d H:i:s");
			$query['where_strings'] = "( ( materi.tanggal_publish <= '".$now."' && (materi.tanggal_tutup = '0000-00-00 00:00:00' || materi.tanggal_tutup is NULL ) ) || " ;
			$query['where_strings'] .= "( materi.tanggal_publish <= '".$now."' && materi.tanggal_tutup >= '".$now."' ) || " ;
			$query['where_strings'] .= "( materi.tanggal_publish = '0000-00-00 00:00:00' || materi.tanggal_publish is NULL ) )" ;

		elseif (!$dm['view'] && $dm['mengajar_list']):
			$query['where_in']['pelajaran_id'] = $dm['mengajar_list'];

		elseif (!$dm['view']):
			$query['where']['author_id'] = $d['user']['id'];

		endif;

		return $query;

	}

	function query_3($query = array())
	{
		$query['select'][] = 'materi.id';
		$query['select'][] = 'materi.semester_id';
		$query['select'][] = 'materi.author_id';
		$query['select'][] = 'materi.editor_id';
		$query['select'][] = 'materi.nama';
		$query['select'][] = 'materi.cuplikan';
		$query['select'][] = 'materi.publish';
		$query['select'][] = 'materi.tanggal_publish';
		$query['select'][] = 'materi.pelajaran_id';
		$query['select'][] = 'materi.konten_tipe';
		$query['select'][] = 'materi.lampiran';
		$query['select'][] = 'materi.siswa_total';
		$query['select'][] = 'materi.siswa_baca';
		$query['select'][] = 'materi.siswa_respon';
		$query['select'][] = 'materi.registered';

		return $query;

	}

	// operasi data

	function browse($index = 0, $limit = 20)
	{
		$query = $this->query_2();
		$query = $this->query_3($query);
		$query = $this->filter_1($query);

		return $this->md->query($query)->resultset($index, $limit);

	}

	function hit()
	{
		$d = & $this->ci->d;

		// klo pengiriman respon, lewati saja

		if ($d['post_request'])
			return;

		// mulai proses

		$materi_id = (int) $d['row']['id'];
		$user_id = (int) $d['user']['id'];
		$upd_stat = FALSE;
		$sql_baca = "
			update kbm_materi_baca
			set baca_count = baca_count + 1,
					baca_waktu = ?
			where materi_id = ? and user_id = ?";
		$sql_hit = "update kbm_materi set hit_count = hit_count + 1 where id = ?";
		$sql_stat = "
update kbm_materi materi
inner join
(
	select
		materi_id,
		count(id) siswa_total,
		count(baca_waktu) siswa_baca,
		count(respon_waktu) siswa_respon
	from kbm_materi_baca
	where materi_id = ?
	group by materi_id
)	baca
	on materi.id = baca.materi_id
set
	materi.siswa_total = baca.siswa_total,
	materi.siswa_baca = baca.siswa_baca,
	materi.siswa_respon = baca.siswa_respon,
	hit_count = hit_count + 1
where
	materi.id = ?";

		if ($d['user']['role'] == 'siswa'):

			if (!$d['row']['baca_waktu'])
				$upd_stat = TRUE;

			$d['row']['baca_count'] ++;
			$d['row']['baca_waktu'] = $d['datetime'];

			$this->db->query($sql_baca, array($d['datetime'], $materi_id, $user_id));

		endif;

		if ($upd_stat)
			$this->db->query($sql_stat, array($materi_id, $materi_id));
		else
			$this->db->query($sql_hit, array($materi_id));

	}

	function rowset($id)
	{
		$d = & $this->ci->d;
		$query = $this->query_2();
		$query['select'][] = 'materi.*';
		$query['where']['materi.id'] = $id;

		if ($d['user']['role'] == 'siswa')
			$query['select'][] = 'baca.respon_jawaban';

		$row = $this->md->query($query)->row();

		if (!$row)
			return FALSE;

		$row['konten'] = base64_decode($row['konten']);
		$row['pertanyaan'] = base64_decode($row['pertanyaan']);
		$row['lampiran'] = (array) json_decode($row['lampiran'], TRUE);

		if ($d['user']['role'] == 'siswa')
			$row['respon_jawaban'] = base64_decode($row['respon_jawaban']);

		// data kelas

		$query_kelas = array(
			'select'	 => array(
				'evakls.*',
				'kelas_nama' => 'kelas.nama',
			),
			'from'		 => 'kbm_materi_kelas evakls',
			'join'		 => array(
				array('dakd_kelas kelas', 'evakls.kelas_id = kelas.id', 'inner'),
			),
			'order_by'	 => 'kelas.grade, kelas.jurusan_id, kelas.nama',
			'where'		 => array(
				'evakls.materi_id' => $id,
			),
		);

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

		// cek data kelas peserta materi

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
		
		if($this->input->post('materi_mulai')){
			$cek=1;
			$materi_mulai = (array) $this->input->post('materi_mulai');
			$materi_ditutup = (array) $this->input->post('materi_ditutup');
		}else{
			$cek=2;
			$materi_mulai_date = (array) $this->input->post('materi_mulai_date');
			$materi_mulai_time = (array) $this->input->post('materi_mulai_time');
			$materi_ditutup_date = (array) $this->input->post('materi_ditutup_date');
			$materi_ditutup_time = (array) $this->input->post('materi_ditutup_time');
		}
		
		$meeting_id = (array) $this->input->post('meeting_id');
		
		$kelas_jadwal = array();
		
		foreach ($kelas_list as $kid => $knama):
			$ceki=0;
			if($this->input->post('materi_mulai')){
				$ceki=1;
				$_jadwal = array(
					'materi_mulai'	 => datefix(array_node($materi_mulai, $kid)),
					'materi_ditutup'	 => datefix(array_node($materi_ditutup, $kid)),
					'meeting_id'	 => $meeting_id,
				);

				
			}else{
				$ceki=2;
				$emulai_date = str_replace('/', '-', array_node($materi_mulai_date, $kid));
				$emulai_date = date("Y-m-d",strtotime($emulai_date));
				$editutup_date = str_replace('/', '-', array_node($materi_ditutup_date, $kid));
				$editutup_date = date("Y-m-d",strtotime($editutup_date));
				$emulai_time = date("H:i:s",strtotime(array_node($materi_mulai_time, $kid)));
				$editutup_time = date("H:i:s",strtotime(array_node($materi_ditutup_time, $kid)));
				
				$materi_mulai = date("Y-m-d H:i:s", strtotime( $emulai_date ." ". $emulai_time ));
				$materi_ditutup = date("Y-m-d H:i:s",strtotime( $editutup_date ." ". $editutup_time ));
				
				$_jadwal = array(
					'materi_mulai'	 	=> $materi_mulai,
					'materi_ditutup'	=> $materi_ditutup,
					'meeting_id'	 	=> $meeting_id,
				);
			}
			
			if (!$_jadwal['materi_mulai']):
				alert_error("Waktui mulai kelas {$knama} harus diisi dengan format tanggal-jam yang benar. format: yyyy-mm-dd. ".$_jadwal['materi_mulai'].
				" ".$emulai_date." | ".$cek." | ".$ceki);
				continue;
			endif;

			if ($_jadwal['materi_mulai'] && $_jadwal['materi_ditutup'] && $_jadwal['materi_mulai'] >= $_jadwal['materi_ditutup']):
				alert_error("Waktu selesai kelas {$knama} salah, harus sesudah dimulai.". $materi_mulai." ".$emulai_time." ".$materi_ditutup);
				continue;
			endif;
			
			$kelas_jadwal[$kid] = $_jadwal;

		endforeach;

		return $kelas_jadwal;

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
				'materi_mulai'	 => "'{$dths}'",
				'materi_ditutup' => "''",
				'meeting_id'	 => "''",
			),
		);

		if ($row['id'] > 0):
			$subsql = "select * from kbm_materi_kelas where materi_id = {$row['id']}";
			$query['join'][] 					= array("({$subsql}) kbm_evakls", 'kelas.id = kbm_evakls.kelas_id', 'left');
			$query['select']['materi_mulai'] 	= "IFNULL(kbm_evakls.materi_mulai, '{$dths}')";
			$query['select']['materi_ditutup'] 	= "kbm_evakls.materi_ditutup";
			$query['select']['meeting_id'] 		= "kbm_evakls.meeting_id";
			
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
	
	function save()
	{
		require_once(APPPATH.'controllers/zoom/create_meeting.php');
		require_once(APPPATH.'controllers/zoom/delete.php');
		//$cmObj = new create_meeting();  //create object 
        
		
		$d = & $this->ci->d;
		$edit = (bool) $d['form']['id'];
		$materi_id = (int) $d['form']['id'];
		$file = $this->upload('upload', 'pdf,doc,docx,xls,xlsx,ppt,pptx,odt,ods,odp,jpg,jpeg,png,gif,zip,rar');
		//$content_path = APP_ROOT . 'content';
		$peserta = array();
		$msg_sukses = "Materi berhasil disimpan.";
		$modit_pelajaran = ($d['author_ybs'] OR ! $edit);
		$pelajaran_id = (int) $d['row']['pelajaran_id'];
		
		$pelajaran_nilai_id = $d['row']['pelajaran_nilai_id'];
		$cek_peserta = FALSE;

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

		if ($d['error'])
			return FALSE;

		$data = $this->input('fields');
		// clean FROALA ////
		$data['konten'] = str_replace('<p data-f-id="pbf" style="text-align: center; font-size: 14px; margin-top: 30px; opacity: 0.65; font-family: sans-serif;">
		Powered by <a href="https://www.froala.com/wysiwyg-editor?pb=1" title="Froala Editor">Froala Editor</a></p>','',$data['konten']);
		$data['konten']= str_replace('Powered by <a href="https://www.froala.com/wysiwyg-editor?pb=1" title="Froala Editor">Froala Editor</a>','',$data['konten']);
		
		$data['konten'] = str_replace('Froala Editor','',$data['konten']);
		$data['konten'] = str_replace('Powered by','',$data['konten']);
		
		/////////////////
		$data['pertanyaan'] = str_replace('<p data-f-id="pbf" style="text-align: center; font-size: 14px; margin-top: 30px; opacity: 0.65; font-family: sans-serif;">
		Powered by <a href="https://www.froala.com/wysiwyg-editor?pb=1" title="Froala Editor">Froala Editor</a></p>','',$data['pertanyaan']);
		$data['pertanyaan']= str_replace('Powered by <a href="https://www.froala.com/wysiwyg-editor?pb=1" title="Froala Editor">Froala Editor</a>','',$data['pertanyaan']);
		
		$data['pertanyaan'] = str_replace('Froala Editor','',$data['pertanyaan']);
		$data['pertanyaan'] = str_replace('Powered by','',$data['pertanyaan']);
		/////////////////
		
		$data['cuplikan'] = (string) substr(clean($data['konten']), 0, 200);
		$data['konten'] = base64_encode($data['konten']);
		$data['pertanyaan'] = base64_encode($data['pertanyaan']);

		if ($modit_pelajaran):
			$data = $this->input('fields-pelajaran', $data);
			$pelajaran_id = (int) $data['pelajaran_id'];
			$mengajar = mengajar($data['pelajaran_id']);
			$cek_peserta = (!$edit OR ( $d['row']['pelajaran_id'] != $data['pelajaran_id']));

			// cek pelajaran_nilai_id

			$npel = $this->data_npelajaran($data['pelajaran_id']);

			if (!$npel)
				return alert_error("Kesalahan! Data riwayat semester pelajaran tidak ditemukan.");

			$data['pelajaran_nilai_id'] = $npel['id'];
			$pelajaran_nilai_id = $npel['id'];
			
			if (!$mengajar)
				alert_error("Anda tidak sedang mengampu pelajaran tersebut.");

		endif;

		$file_ofis = file_ofis($d, array('form', 'upload', 'file_ext'));
		$file_lama = file_ofis($d, array('row', 'lampiran', 'file_ext'));

		if (empty($data['konten']) && !$file_ofis && !$file_lama)
			alert_error('konten harus berupa tulisan artikel atau upload file office.');

		if ($cek_peserta):
			$peserta = $this->peserta($data['pelajaran_id']);

			if (empty($peserta)):
				alert_error('Peserta pelajaran yang Anda pilih tidak ditemukan.');

			else:
				$data['siswa_total'] = count($peserta);
				$data['siswa_baca'] = 0;
				$data['siswa_respon'] = 0;

			endif;

		endif;

		if ($d['error'])
			return FALSE;

		$kelas_jadwal = $this->input_jadwal($pelajaran_nilai_id);
		if (empty($kelas_jadwal))
			alert_error('Jadwal kelas harus diisi.');
				
		// olah data baru

		if (!$edit):

			// prep vars

			$data['semester_id'] = $d['semaktif']['id'];
			$data['author_id'] = $d['user']['id'];
			//$data['konten_tipe'] = ($d['konten']) ? 'artikel' : 'file';
			if(empty($d['konten'])){
				$data['konten_tipe'] = 'file';
			}else{
				$data['konten_tipe'] = 'artikel';
			}
			$data['registered'] = $d['datetime'];
			
			if(empty($d['lampiran'])){
				$data['lampiran'] = '';
			}
			
			if(empty($d['tanggal_tutup'])){
				$data['tanggal_tutup'] = '0000-00-00 00:00:00';
			}
			// insert siswa

			$this->db->trans_start();
			$this->db->insert('kbm_materi', $data);

			$materi_id = (int) $this->db->insert_id();

			$this->save_peserta($materi_id, $peserta);

			$trx = $this->trans_done();
			$msg_sukses = "Materi berhasil ditambahkan.";

			if (!$trx)
				return alert_error('Database error saat menyimpan materi baru, coba beberapa saat lagi.');

			// insert berhasil, id baru masukan ke var data utama. reset input data u/ proses berikutnya.

			$d['form']['id'] = $materi_id;
			$data = array();

			// bila takada upload, operasi selesai

			if (!$d['form']['upload'])
				return alert_info($msg_sukses);

		endif;

		// olah upload file

		if ($d['form']['upload']):

			$folder = strtolower(APP_SCOPE) ."/kbm/materi/{$materi_id}/";

			$data['lampiran'] = $this->file_store($d['form']['upload'], $folder, $d['row']['lampiran']);
			$data['lampiran'] = (string) json_encode($data['lampiran']);

		endif;

		// perubahan data

		if (!empty($data)):

			$this->db->trans_start();

			if ($edit && $d['row']['author_id'] != $d['user']['id'])
				$data['editor_id'] = $d['user']['id'];

			$updfilter['id'] = $materi_id;

			if($data['tanggal_tutup']==""){
				$data['tanggal_tutup'] = '0000-00-00 00:00:00';
			}
			
			$this->db->update('kbm_materi', $data, $updfilter);

			
			if ($edit && $cek_peserta && $this->db->trans_status()):
				$this->db->delete('kbm_materi_baca', array('materi_id' => $materi_id));
				$this->save_peserta($materi_id, $peserta);
			endif;

			if ($edit)
				$msg_sukses = 'Data materi berhasil disimpan.';

			$trx = $this->trans_done();

			if (!$trx)
				return alert_error('Database error saat menyimpan materi, coba beberapa saat lagi.');

		endif;
		
		// JADWAL KELAS
		$this->db->trans_start();
		if ($edit){
			// DELETE ZOOM MEET
			/*
			$sql_materi_kelas="select * from kbm_materi_kelas where materi_id = '".$materi_id."'";    
			$query_materi_kelas = $this->db->query($sql_materi_kelas);
			$result_materi_kelas = $query_materi_kelas->result_array();
			
		//	print_r($result_materi_kelas);
			foreach($result_materi_kelas as $matkelas){
				
				//echo $matkelas['meeting_id'];
				$metting = delete_meeting($matkelas['meeting_id']);
			}
			*/
			$this->db->delete('kbm_materi_kelas', array('materi_id' => $materi_id));
		}

		// entri jadwal baru

		$klsjadwal_array = array();

		foreach ($kelas_jadwal as $kid => $jadwal):
			$jadwal['kelas_id'] = $kid;
			$jadwal['materi_id'] = $materi_id;
			
			//ZOOM_GENERATE
			/*
			$metting = create_meeting($data, $jadwal); //call function
			 
			$jadwal['meeting_id'] 	= $metting->id;
			$jadwal['password'] 	= $metting->encrypted_password;*/
			
			$klsjadwal_array[] = $jadwal;

		endforeach;

		//alert_dump($klsjadwal_array);

		if ($klsjadwal_array):
			$this->db->insert_batch('kbm_materi_kelas', $klsjadwal_array);
		endif;
		$trx = $this->trans_done();
		

		return alert_success($msg_sukses);

	}

	function save_peserta($materi_id, $peserta)
	{
		if ($materi_id <= 0)
			return;

		$baca_bat = array();

		foreach ($peserta as $sid)
			$baca_bat[] = array(
				'materi_id'	 => $materi_id,
				'user_id'	 => $sid,
				'respon_cuplikan'	=> '',
			);

		if (!empty($baca_bat))
			$this->db->insert_batch('kbm_materi_baca', $baca_bat);

	}

	function peserta($pelajaran_id)
	{
		$d = & $this->ci->d;
		$query = array(
			'select' => array('nilsis.siswa_id'),
			'from'	 => 'nilai_siswa nilsis',
			'join'	 => array(
				array('nilai_siswa_pelajaran nisispel', 'nilsis.id = nisispel.siswa_nilai_id', 'inner'),
				array('nilai_pelajaran nipel', 'nisispel.pelajaran_nilai_id = nipel.id', 'inner'),
			),
			'where'	 => array(
				'nilsis.semester_id' => $d['semaktif']['id'],
				'nipel.semester_id'	 => $d['semaktif']['id'],
				'nipel.pelajaran_id' => $pelajaran_id,
			),
		);

		return $this->md->query($query)->result_values('siswa_id');

	}

	function reuse($fromMateri_id)
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

		$nilpel = $this->md->row($sql_nilpel);

		if ($this->db->trans_status() === FALSE)
		{
			$this->db->trans_rollback();

			return alert_error("error saat menjalankan: <br/> {$sql_nilpel}");
		}

		$pelajaran_nilai_id = $nilpel['id'];
		$author_id = $nilpel['guru_id'];
		$editor_id = $d['user']['id'];

		$sql_copy_materi = <<<SQL

INSERT INTO
	kbm_materi
	(
		semester_id, author_id, editor_id,
		nama, cuplikan, pelajaran_id, konten_tipe, konten, lampiran, pertanyaan,
		registered, updated
	)

SELECT
	{$semester_id}, {$author_id}, {$editor_id},
	nama, cuplikan, {$newPelajaran_id}, konten_tipe, konten, lampiran, pertanyaan,
	registered, updated

FROM
	kbm_materi

WHERE
	id = {$fromMateri_id}
;

SQL;
		$this->db->query($sql_copy_materi);

		if ($this->db->trans_status() === FALSE)
		{
			$this->db->trans_rollback();

			return alert_error("error saat menjalankan: <br/> {$sql_copy_materi}");
		}

		$newMateri_id = $this->db->insert_id();

		$sql_pembaca = <<<SQL

INSERT INTO
	kbm_materi_baca
	(
		respon_cuplikan,
		materi_id, 
		user_id
	)

SELECT
	'',
	'{$newMateri_id}',
	ns.siswa_id

FROM
	nilai_siswa_pelajaran nsp

INNER JOIN
	nilai_siswa ns
ON
	nsp.siswa_nilai_id = ns.id

WHERE
	nsp.pelajaran_nilai_id = {$pelajaran_nilai_id}
;

SQL;

		$this->db->query($sql_pembaca);

		if ($this->db->trans_status() === FALSE)
		{
			$this->db->trans_rollback();

			return alert_error("error saat menjalankan: <br/> {$sql_pembaca}");
		}
		else
		{
			$this->db->trans_commit();
		}

		$sql_siswa = <<<SQL

UPDATE
	kbm_materi

LEFT JOIN
	(
	SELECT count(*) jml, materi_id

	FROM
		kbm_materi_baca

	WHERE
		materi_id = {$newMateri_id}

	GROUP BY
		materi_id
	) baca
ON
	kbm_materi.id = baca.materi_id

SET
	kbm_materi.siswa_total = IFNULL( baca.jml, 0 )

WHERE
	kbm_materi.id = {$newMateri_id}
;

SQL;

		$this->db->query($sql_siswa);

		return $newMateri_id;

	}

}
