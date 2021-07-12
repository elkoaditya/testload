<?php

class M_dnakd_prestasi extends MY_Model
{

	public function __construct()
	{
		parent::__construct(array(
			'field-baru' => array('nama', 'kegiatan_prestasi_id', 'tentang'),
			'field-edit' => array('nama', 'kegiatan_prestasi_id', 'tentang', 'aktif'),
		));

	}

	// dasar database

	function filter()
	{
		$r = $this->ci->d['request'];

		if (isset($r['term']))
			$this->md->like($r['term'], 'prestasi.nama');

		if (isset($r['kegiatan_prestasi_id']) && $r['kegiatan_prestasi_id'] > 0)
			$this->db->where('prestasi.kegiatan_prestasi_id', $r['kegiatan_prestasi_id']);

	}

	function insert($data)
	{
		$d = & $this->ci->d;

		$data['aktif'] = 1;

		$this->db->trans_start();
		$this->db->insert('dnakd_prestasi', $data);
		$d['row_id'] = $this->db->insert_id();

		// rekap semester
		if ($d['semaktif']['id'] > 0)
		{
			$nilai_prestasi = array(
				'semester_id'	 => $d['semaktif']['id'],
				'prestasi_id'		 => $d['row_id'],
				'kegiatan_prestasi_id'	 => $data['kegiatan_prestasi_id'],
			);
			$this->db->insert('nilai_prestasi', $nilai_prestasi);
		}

		return $this->trans_done('Data ekstrakurikuler berhasil ditambahkan.', 'Database error, coba beberapa saat lagi.');

	}

	function query_1()
	{
		$view = cfguc_view('akses', 'data', 'non_akademik', 'prestasi');
		$dataset = (array) func_get_args();
		$alldata = in_array('#all', $dataset);

		if ($alldata OR in_array('prestasi', $dataset)):
			$select = array(
				'prestasi.*',
			);
		else:
			$select = array(
				'prestasi.id',
				'prestasi.nama',
				'prestasi.aktif',
				//'prestasi.cuplikan',
				'prestasi.kegiatan_prestasi_id',
			);

		endif;

		$this->db->from('dnakd_prestasi prestasi');

		if (!$view)
			$this->db->where('prestasi.aktif', 1);

		// data pembina
/*
		if ($alldata OR in_array('pembina', $dataset)):
			$this->db->join('dprofil_sdm pembina', 'ekskul.pembina_id = pembina.id', 'left');
			$select['pembina_nama'] = "IF(ekskul.pembina_id, trim(concat_ws(' ', pembina.prefix, pembina.nama, pembina.suffix)), '-')";
		endif;
*/
		$this->db->join('dnakd_kegiatan_prestasi kegiatan_prestasi', 'prestasi.kegiatan_prestasi_id = kegiatan_prestasi.id', 'left');
			$select['kegiatan_prestasi_nama'] = "kegiatan_prestasi.nama";
		// data modifikasi

		if ($alldata OR in_array('modif', $dataset)):
			$this->db->join('data_user modifier', 'prestasi.modifier_id = modifier.id', 'left');
			$select['modifier_nama'] = 'modifier.nama';
			$select['modifier_alias'] = 'modifier.alias';
		endif;

		// commit selection
		$this->md->select($select);

	}

	function update($data, $id)
	{
		$d = & $this->ci->d;

		if (!$data['aktif'])
		{
			$data['kegiatan_prestasi_id'] = NULL;
		}

		$this->db->trans_start();
		$this->db->update('dnakd_prestasi', $data, array('id' => $id));

		// rekap semester
		if ($d['semaktif']['id'] > 0)
		{
			$filter_nilai_prestasi = array(
				'semester_id'	 => $d['semaktif']['id'],
				'prestasi_id'		 => $id,
			);
			$data_nilai_prestasi = array(
				'kegiatan_prestasi_id' => $data['kegiatan_prestasi_id'],
			);
			$this->db->update('nilai_prestasi', $data_nilai_prestasi, $filter_nilai_prestasi);
		}

		return $this->trans_done('Data ekstrakurikuler berhasil diperbarui.', 'Database error, coba beberapa saat lagi.');

	}

	// operasi data

	function browse($index = 0, $limit = 20)
	{
		$this->query_1('kegiatan_prestasi');
		$this->filter();
		return $this->md->resultset($index, $limit);

	}

	function rowset($id)
	{
		$this->query_1('#all');
		$this->db->where('prestasi.id', $id);
		return $this->md->row();

	}

	function save()
	{
		$sesi = $this->ci->form->sesi;
		$row = $this->ci->d['row'];
		$edit = (bool) $sesi['id'];
		$aktif = ($edit) ? $this->input->post('aktif') : 1;

		if ($aktif)
			$this->form->ruleset($row, 'validasi-aktif');

		$this->form->ruleset($row, 'validasi-umum');
		$this->form->validate();

		if ($this->d['error'])
			return FALSE;

		$fieldset = ($edit) ? 'field-edit' : 'field-baru';
		$data = $this->inputset($fieldset);
		//$data['cuplikan'] = character_limiter(strip_tags($data['tentang']), 200);
		$data['modified'] = $this->d['datetime'];
		$data['modifier_id'] = $this->d['user']['id'];

		if ($edit)
			return $this->update($data, $sesi['id']);
		else
			return $this->insert($data);

	}

}
