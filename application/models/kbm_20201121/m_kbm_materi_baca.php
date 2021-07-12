<?php

class M_kbm_materi_baca extends MY_Model {

	public function __construct() {
		parent::__construct(array(
			'fields_nilai_pembaca' => array(
				'nilai',
			),
		));
	}

	//

	function insert($materi_id) {
		$data = array(
				'materi_id' => $materi_id,
				'user_id' => $this->ci->d['user']['id'],
				'baca_waktu' => $this->ci->d['datetime'],
				'baca_count' => 1,
		);
		$sqlupdate = "update kbm_materi set siswa_total = siswa_total + 1, siswa_baca = siswa_baca + 1 where id = {$materi_id}";

		$this->db->trans_start();
		$this->db->insert('kbm_materi_baca', $data);

		$data['id'] = $this->db->insert_id();
		$data['respon_waktu'] = NULL;
		$data['respon_jawaban'] = NULL;

		$this->db->query($sqlupdate);
		$this->db->trans_commit();

		return $data;
	}

	//

	function browse($materi_id, $index = 0, $limit = 50) {
		$r = $this->ci->d['request'];
		$select = array(
				'komentar_registered' 	=> 'MAX(komentar.registered)',
				'komentar_konten' 	  	=> 'komentar.konten',
				'komentar_author_nama' 	=> 'user.nama',
				'baca.*',
				'siswa_id' 				=> 'siswa.id',
				'siswa_nis' 			=> 'siswa.nis',
				'siswa_nisn'	 		=> 'siswa.nisn',
				'siswa_nama' 			=> 'siswa.nama',
				'siswa_gender' 			=> 'siswa.gender',
				'siswa_aktif' 			=> 'siswa.aktif',
				'siswa.kelas_id',
				'kelas_nama' 			=> 'kelas.nama',
		);
		$this->md
					->select($select)
					->from('kbm_materi_baca baca')
					->join('dprofil_siswa siswa', 'baca.user_id = siswa.id', 'inner')
					->join('dakd_kelas kelas', 'siswa.kelas_id = kelas.id', 'inner')
					->join('kbm_materi_komentar komentar', 'komentar.kbm_materi_id = baca.materi_id AND komentar.pembaca_id = baca.id', 'left')
					->join('data_user user', 'user.id = komentar.author_id', 'left')
					->where('baca.materi_id', $materi_id)
					->group_by('baca.id')
					->order_by('kelas.nama, siswa.nama');

		// filter

		if (isset($r['term']) && strlen($r['term']) > 0)
			$this->md->like($r['term'], 'siswa.nama');

		if (isset($r['kelas_id']) && $r['kelas_id'] > 0)
			$this->db->where('siswa.kelas_id', $r['kelas_id']);

		if (isset($r['status_baca'])):
			if ($r['status_baca'] == 'sudah')
				$this->db->where('respon_waktu is not null');

			else if ($r['status_baca'] == 'belum')
				$this->db->where('respon_waktu is null');

		endif;

		// hasil

		return $this->md->resultset($index, $limit);
	}

	function query_1()
	{
		return array(
			'select' => array(
				'baca.*',
				'siswa_id' 		=> 'siswa.id',
				'siswa_nis' 	=> 'siswa.nis',
				'siswa_nisn' 	=> 'siswa.nisn',
				'siswa_nama' 	=> 'siswa.nama',
				'siswa_gender' 	=> 'siswa.gender',
				'siswa_aktif' 	=> 'siswa.aktif',
				'siswa.kelas_id',
				'kelas_nama' 	=> 'kelas.nama',
				'materi_id'		=> 'materi.id',
				'materi_nama'	=> 'materi.nama',
				'pertanyaan'	=> 'materi.pertanyaan',
			),
			'from'	 => 'kbm_materi_baca baca',
			'join'	 => array(
				array('dprofil_siswa siswa', 'baca.user_id = siswa.id', 'inner'),
				array('dakd_kelas kelas', 'siswa.kelas_id = kelas.id', 'inner'),
				array('kbm_materi materi', 'materi.id = baca.materi_id', 'inner'),
			),
			
			
		);

	}
	
	function query_2()
	{
		return array(
			'select' => array(
				'komentar_registered' 	=> 'komentar.registered',
				'komentar_konten' 	  	=> 'komentar.konten',
				'komentar_author_nama' 	=> 'user.nama',
				
				'siswa_id' 				=> 'siswa.id',
				'siswa_nis' 			=> 'siswa.nis',
				'siswa_nisn'	 		=> 'siswa.nisn',
				'siswa_nama' 			=> 'siswa.nama',
				'siswa_gender' 			=> 'siswa.gender',
				'siswa_aktif' 			=> 'siswa.aktif',
				'siswa.kelas_id',
				'kelas_nama' 			=> 'kelas.nama',
			),
			'from'	=> 'kbm_materi materi',
			'join'	=> array(
						array('kbm_materi_komentar komentar', 'komentar.kbm_materi_id = materi.id', 'inner'),
						array('data_user user', 'user.id = komentar.author_id', 'inner'),
						array('dprofil_siswa siswa', 'komentar.author_id = siswa.id', 'left'),
						array('dakd_kelas kelas', 'siswa.kelas_id = kelas.id', 'left'),
						
						
					),
			
			'order_by'=> 'komentar_registered DESC'
		);
		
	}
	
	function rowset($id)
	{
		$query = $this->query_1();
		$query['where']['baca.id'] = $id;

		return $this->md->query($query)->row();

	}
	
	function komentar($id, $pembaca_id=0)
	{
		$query = $this->query_2();
		
		if($pembaca_id>0){
			$query['join'][] = array('kbm_materi_baca baca','komentar.pembaca_id = baca.id', 'inner');
		}
		$query['where']['komentar.pembaca_id'] = $pembaca_id;
		$query['where']['materi.id'] = $id;

		return $this->md->query($query)->resultset();

	}
	
	function save_komentar($id, $pembaca_id=""){
		$d = & $this->ci->d;

		if (!$d['row'])
			return;

		//if ($d['row']['respon_jawaban'])
			//return alert_info('Jawaban telah disimpan sebelumnya.');

		$this->form->get();

		if ($d['error'])
			return;

		$this->form->ruleset($d['row'], 'validasi');
		$this->form->validate();

		if ($d['error'])
			return;

		$respon = (string) $this->input->post('komentar');
		// clean FROALA ////
		$respon = str_replace('<p data-f-id="pbf" style="text-align: center; font-size: 14px; margin-top: 30px; opacity: 0.65; font-family: sans-serif;">
		Powered by <a href="https://www.froala.com/wysiwyg-editor?pb=1" title="Froala Editor">Froala Editor</a></p>','',$respon);
		$respon = str_replace('Powered by <a href="https://www.froala.com/wysiwyg-editor?pb=1" title="Froala Editor">Froala Editor</a>','',$respon);
		
		$respon = str_replace('Froala Editor','',$respon);
		$respon = str_replace('Powered by','',$respon);
		
		/////////////////
		
		$data['kbm_materi_id'] = $id;
		$data['author_id'] 	= $d['user']['id'];
		$data['pembaca_id'] = $pembaca_id;
		$data['konten'] 	= base64_encode($respon);
		$data['registered'] = $d['datetime'];
		
		$this->db->trans_start();
		$this->db->insert('kbm_materi_komentar', $data);

		$success = $this->trans_done('Jawaban berhasil disimpan.', 'Database error, jawaban belum tersimpan.');

		if (!$success)
			return;

	}
	
	function save_nilai_pembaca()
	{
		$d = & $this->ci->d;

		$this->form->ruleset($d['row'], 'validasi');
		$this->form->validate();

		if ($d['error'])
		{
			return FALSE;
		}

		$data = $this->inputset('fields_nilai_pembaca');

		return $this->update($data, $d['form']['id']);

	}
	
	function update($data, $id)
	{

		$this->db->trans_start();

		$this->db->update('kbm_materi_baca', $data, array('id' => $id));

		return $this->trans_done('Data materi siswa berhasil diperbarui.', 'Database error, coba beberapa saat lagi.');

	}
	
	function jawab() {
		$d = & $this->ci->d;

		if (!$d['row'])
			return;

		//if ($d['row']['respon_jawaban'])
			//return alert_info('Jawaban telah disimpan sebelumnya.');

		$this->form->get();

		if ($d['error'])
			return;

		$this->form->ruleset($d['row'], 'validasi');
		$this->form->validate();

		if ($d['error'])
			return;

		$respon = (string) $this->input->post('respon_jawaban');
		// clean FROALA ////
		$respon = str_replace('<p data-f-id="pbf" style="text-align: center; font-size: 14px; margin-top: 30px; opacity: 0.65; font-family: sans-serif;">
		Powered by <a href="https://www.froala.com/wysiwyg-editor?pb=1" title="Froala Editor">Froala Editor</a></p>','',$respon);
		$respon = str_replace('Powered by <a href="https://www.froala.com/wysiwyg-editor?pb=1" title="Froala Editor">Froala Editor</a>','',$respon);
		
		$respon = str_replace('Froala Editor','',$respon);
		$respon = str_replace('Powered by','',$respon);
		
		/////////////////
		
		$data['respon_waktu'] = $d['datetime'];
		$data['respon_cuplikan'] = (string) substr(strip_tags($respon), 0, 100);
		$data['respon_jawaban'] = base64_encode($respon);

		$this->db->trans_start();
		$this->db->update('kbm_materi_baca', $data, array('id' => $d['row']['baca_id']));

		$success = $this->trans_done('Jawaban berhasil disimpan.', 'Database error, jawaban belum tersimpan.');

		if (!$success)
			return;

		$d['row']['respon_waktu'] = $data['respon_waktu'];
		$d['row']['respon_cuplikan'] = $data['respon_cuplikan'];
		$d['row']['respon_jawaban'] = $respon;

		$this->update_stat($d['row']['id']);
	}

	function update_stat($materi_id) {
		$materi_id = (int) $materi_id;
		$sql = "
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
	materi.siswa_respon = baca.siswa_respon
where
	materi.id = ?";

		$this->db->query($sql, array($materi_id, $materi_id));
	}

}

