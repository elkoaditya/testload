<?php

class M_dprofil_admin extends MY_Model {

	public function __construct() {
		parent::__construct(array(
				'fields' => array('nama', 'prefix', 'suffix', 'gender', 'alamat', 'kota', 'telepon'),
		));
		$this->dm['admin'] = cfguc_admin('akses', 'data', 'profil', 'admin');
		$this->dm['view'] = cfguc_view('akses', 'data', 'profil', 'admin');
	}

	// dasar database

	function query_1() {
		$select = array(
				'admin.*',
				'nama_title' => "trim(both ' ,' from concat_ws(' ', admin.prefix, admin.nama, admin.suffix))",
				'user.expire',
				'user.username',
		);
		$this->md->select($select)
				->from('dprofil_admin admin')
				->join('data_user user', 'admin.id = user.id', 'left');

		if (!$this->dm['admin'])
			$this->db->where('admin.aktif', 1);
	}

	// operasi data

	function browse($index = 0, $limit = 20) {
		$term = $this->ci->d['request']['term'];

		$this->query_1();
		$this->md->like($term, 'admin.nama');

		return $this->md->resultset($index, $limit);
	}

	function rowset($id) {
		$this->query_1();
		$this->db->where('admin.id', $id);
		return $this->md->row();
	}

	function save() {
		$d = & $this->ci->d;
		$dm = & $this->dm;
		$edit = (bool) $d['form']['id'];
		$admin_id = (int) $d['form']['id'];
		$foto = $this->save_foto();
		$xdat = ($edit) ? (array) json_decode($d['row']['xdat'], TRUE) : array();
		//$content_path = APP_ROOT . 'content';
		$msg_sukses = 'Data admin berhasil disimpan.';

		if ($foto):
			if (is_array($d['form']['upload']) && isset($d['form']['upload']['full_path']))
				delete($d['form']['upload']['full_path']);

			$d['form']['upload'] = $foto;

		endif;

		if (!$edit)
			$this->form->ruleset($d['row'], 'validasi-akun');

		$this->form->ruleset($d['row'], 'validasi-umum');
		$this->form->validate();

		if ($d['error'])
			return FALSE;

		$data = $this->inputset('fields');
		$data['modified'] = $d['datetime'];
		$data['modifier_id'] = $d['user']['id'];

		if ($dm['admin'])
			$data['aktif'] = as_bool($this->input->post('aktif'));

		// mulai simpan data

		$this->db->trans_start();

		// olah data baru

		if (!$edit):

			// insert user baru

			$user['role'] = 'admin';
			$user['nama'] = trim("{$data['prefix']} {$data['nama']} {$data['suffix']}");
			$user['gender'] = $data['gender'];
			$user['modified'] = $data['modified'];
			$user['modifier_id'] = $data['modifier_id'];

			$user['username'] = $this->input->post('username');
			$user['password'] = crypto($this->input->post('password'));
			$user['alias'] = nama_alias($data['nama']);
			$email = $this->input->post('email');

			if ($email && $this->form_validation->valid_email($email))
				$user['email'] = $email;

			$this->db->insert('data_user', $user);

			// id baru ditampung di tabel terpisah dulu biar gak konflik saat error

			$admin_id = $this->db->insert_id();

			if (!$this->db->trans_status() OR !$admin_id)
				return $this->trans_rollback('Database error saat membuat user baru, coba beberapa saat lagi.');

			// insert admin

			$data['id'] = $admin_id;

			$this->db->insert('dprofil_admin', $data);

			$trx = $this->trans_done();
			$msg_sukses = "Data admin berhasil ditambahkan.";

			if (!$trx)
				return alert_error('Database error saat menyimpan profil baru, coba beberapa saat lagi.');

			// insert berhasil, id baru masukan ke var data utama. reset input data u/ proses berikutnya.

			$d['form']['id'] = $admin_id;
			$data = array();

			if (!$d['form']['upload'])
				return alert_info($msg_sukses);

		endif;

		// olah upload foto

		if ($d['form']['upload']):

			$folder = strtolower(APP_SCOPE) . "/data/profil/admin/{$admin_id}/";
			$old_foto = array_node($xdat, array('foto'));

			$xdat['foto'] = $this->file_store($d['form']['upload'], $folder, $old_foto);
			$data['xdat'] = json_encode($xdat);

			$this->m_data_user->generate_thumbnails($admin_id, $xdat['foto']['full_path']);

		endif;

		// perubahan data

		if (!empty($data)):

			$this->db->trans_start();

			$updfilter['id'] = $admin_id;

			// ubah nama di tabel user

			if ($edit):
				$user['nama'] = trim("{$data['prefix']} {$data['nama']} {$data['suffix']}");
				$user['gender'] = $data['gender'];

				$this->db->update('data_user', $user, $updfilter);

			endif;

			$this->db->update('dprofil_admin', $data, $updfilter);

			if ($edit)
				$msg_sukses = 'Data admin berhasil diperbarui.';

			$trx = $this->trans_done();

			if (!$trx)
				return alert_error('Database error saat menyimpan artikel, coba beberapa saat lagi.');

		endif;

		return alert_success($msg_sukses);
	}

	function save_foto() {
		$skala_ideal = (3 / 4);
		$max_width = 360;
		$max_height = round($max_width / $skala_ideal);
		$foto = $this->upload_gambar('foto', 4096, $max_width, $max_height, TRUE);

		if (!$foto)
			return NULL;

		// cek kondisi gambar

		if ($foto['image_width'] < 75 OR $foto['image_height'] < 100):
			delete($foto['full_path']);
			return alert_error('Foto minimal berukuran 75x100 pixel.');
		endif;

		$skala_foto = ($foto['image_width'] / $foto['image_height']);

		if ($skala_foto == $skala_ideal)
			return $foto;

		if ($skala_foto < $skala_ideal):
			$target_width = $foto['image_width'];
			$target_height = round($foto['image_width'] / $skala_ideal);

		else:
			$target_width = round($foto['image_height'] * $skala_ideal);
			$target_height = $foto['image_height'];

		endif;

		try {
			$thumb = PhpThumbFactory::create($foto['full_path']);
			$thumb->adaptiveResize($target_width, $target_height);
			$thumb->save($foto['full_path']);
		} catch (Exception $e) {
			alert_info("Penyesuaian gambar error.<br/>" . $e->getMessage());
			delete($foto['full_path']);
			return NULL;
		}

		$img = getimagesize($foto['full_path']);
		$foto['image_width'] = $img[0];
		$foto['image_height'] = $img[1];
		//$foto['full_path'] = path_relative($foto['full_path']);

		return $foto;
	}

	function jumlah_guru(){
		$select = array(
				'jumlah' => 'COUNT(id)',
		);
		$this->md->select($select)
				->from('dprofil_sdm');

		$this->db->where('aktif', 1);
		$this->db->not_like('nama', 'coba', 'both'); 
		$this->db->not_like('nama', 'zz', 'both');
		
		return $this->md->row();
	}
	
	function jumlah_kelas(){
		
		$select = array(
				'jumlah' => 'COUNT(id)',
		);
		$this->md->select($select)
				->from('dakd_kelas');

		$this->db->where('aktif', 1);
		//$this->db->like('title', $query);
		$this->db->not_like('nama', 'keluar', 'both'); 
		$this->db->not_like('nama', 'mutasi', 'both');
		
		return $this->md->row();
	}
	
	function jumlah_siswa(){
		
		$select = array(
				'grade'		=> 'grade.nama',
				'jumlah' 	=> 'COUNT(siswa.id)',
		);
		$this->md->select($select)
				->from('dprofil_siswa siswa')
				->join('dakd_kelas kelas', 'kelas.id = siswa.kelas_id ', 'inner')
				->join('dmst_grade grade', 'grade.id = kelas.grade', 'inner');
		
		$this->db->group_by("grade.id");
		$this->db->where('grade.aktif', 1);
		$this->db->where('kelas.aktif', 1);
		$this->db->not_like('siswa.nama', 'zz', 'both');
		
		return $this->md->resultset(0,30);
	}
}
