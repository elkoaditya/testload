<?php

class M_kbm_angket_soal extends MY_Model {

	public function __construct() {
		parent::__construct(array(
				'fields' => array('pertanyaan', 'poin_1', 'poin_2', 'poin_3', 'poin_4', 'poin_5'),
				'sql' => array(
						'update-soal_jml' => "update kbm_angket angket inner join (select angket_id, count(*) as jml from kbm_angket_soal where angket_id = ? group by angket_id) soal on angket.id = soal.angket_id set angket.soal_total = soal.jml where angket.id = ?",
				),
		));
	}

	
	// operasi data

	function browse($index = 0, $limit = 20) {
		$r = $this->ci->d['request'];
		$query = array(
				'from' => 'kbm_angket_soal',
				'where' => array(
						'angket_id' => $r['angket_id'],
				),
				'like' => array($r['term'], array('cuplikan')),
				'order_by' => 'id',
		);
		return $this->md->query($query)->resultset($index, $limit);
	}
	
	function delete() {
		$d = & $this->ci->d;
		$kriteria['id'] = $d['row']['id'];

		$this->db->trans_start();
		$this->db->delete('kbm_angket_soal', $kriteria);
		$this->update_soal_total($d['row']['angket_id']);

		return $this->trans_done("Soal telah terhapus.", 'Database error, coba beberapa saat lagi.');
	}
	
	function rowset($id) {
		$row = $this->md->rowset($id, 'kbm_angket_soal');

		if ($row)
			soal_angket_prepare($row);

		return $row;
	}
	
	function save() {
		$d = & $this->ci->d;
		$edit = (bool) $d['form']['id'];
		$soal_id = (int) $d['form']['id'];
		$angket_id = (int) $d['form']['angket_id'];

		// atasi upl

		$this->form->ruleset($d['row'], 'validasi');
		$this->form->validate();

		if ($d['error'])
			return FALSE;
		
		$data = $this->input('fields');
		$data['cuplikan'] = (string) clean($data['pertanyaan']);
		$data['pertanyaan'] = base64_encode($data['pertanyaan']);

		// baca pilihan

		if ($d['angket']['pilihan_jml'] > 1):

			//vars

			$opsi_maxlen = 32000;
			$opsi = array('a', 'b', 'c', 'd', 'e');

			// index kunci
			/*
			$kunci_index = array_node($d['row'], 'pilihan', 'kunci', 'index');

			if (!$kunci_index OR !$edit):
				$registered = array_nodex($d['row'], array('registered'), $d['time']);
				$kunci_index = opsi_rand($registered);
				$data['pilihan']['kunci']['index'] = $kunci_index;
			endif;

			opsi_del($opsi, $kunci_index);
			*/
			//shuffle($opsi);

			// pilihan kunci
			/*
			$d['pilihan']['kunci'] = clean_html($this->input->post('kunci'));

			if (empty($d['pilihan']['kunci'])):
				alert_error('Kunci pilihan harus diisi.');

			elseif (strlen($d['pilihan']['kunci']) > $opsi_maxlen):
				alert_error('Kunci pilihan terlalu panjang.');

			else:
				$data['pilihan']['kunci']['label'] = base64_encode($d['pilihan']['kunci']);

			endif;
*/

			for ($i = 1; $i <= $d['angket']['pilihan_jml']; $i++):
				$_nama = "pilihan-{$i}";
				$d['pilihan'][$_nama] = clean_html($this->input->post($_nama));

				if (empty($d['pilihan'][$_nama])):
					alert_error("Pengecoh {$i}  harus diisi.");

				elseif (strlen($d['pilihan'][$_nama]) > $opsi_maxlen):
					alert_error("Pengecoh {$i} terlalu panjang.");

				else:
					$index = array_shift($opsi);
					$data['pilihan']['pengecoh'][$index] = base64_encode($d['pilihan'][$_nama]);

				endif;

			endfor;

			if ($d['error'])
				return FALSE;

			$data['pilihan'] = json_encode($data['pilihan']);

		endif;

		if ($d['error'])
			return FALSE;

		// mulai simpan data
		
		if ($edit):
			$this->db->trans_start();
			$this->db->update('kbm_angket_soal', $data, array('id' => $d['form']['id']));

			return $this->trans_done('Butir soal berhasil disimpan.', 'Database error, coba beberapa saat lagi.');

		endif;

		$data['angket_id'] = $angket_id;
		$data['registered'] = $d['datetime'];

		$this->db->trans_start();
		$this->db->insert('kbm_angket_soal', $data);

		$soal_id = $this->db->insert_id();
		$trx_status = $this->db->trans_status();

		if (!$trx_status OR !$soal_id)
			return $this->trans_rollback('Database error, coba beberapa saat lagi.');

		$this->update_soal_total($angket_id);

		$trx = $this->trans_done('Butir soal berhasil disimpan.', 'Database error, coba beberapa saat lagi.');

		if ($trx)
			$d['form']['id'] = $soal_id;

		return $trx;
	}

	function update_soal_total($angket_id) {
		$sql = "update kbm_angket angket inner join (select angket_id, count(*) as jml from kbm_angket_soal where angket_id = ? group by angket_id) soal on angket.id = soal.angket_id set angket.soal_total = soal.jml where angket.id = ?";

		$this->db->query($sql, array($angket_id, $angket_id));
	}		
}