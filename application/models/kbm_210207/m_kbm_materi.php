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

		// output

		return $row;

	}

	function save()
	{
		$d = & $this->ci->d;
		$edit = (bool) $d['form']['id'];
		$materi_id = (int) $d['form']['id'];
		$file = $this->upload('upload', 'pdf,doc,docx,xls,xlsx,ppt,pptx,odt,ods,odp,jpg,jpeg,png,gif,zip,rar');
		//$content_path = APP_ROOT . 'content';
		$peserta = array();
		$msg_sukses = "Materi berhasil disimpan.";
		$modit_pelajaran = ($d['author_ybs'] OR ! $edit);
		$pelajaran_id = (int) $d['row']['pelajaran_id'];
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
