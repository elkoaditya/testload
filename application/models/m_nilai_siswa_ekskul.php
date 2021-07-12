<?php

class M_nilai_siswa_ekskul extends MY_Model
{

	public function __construct()
	{
		parent::__construct(array(
			'fields' => array('nilai', 'keterangan'),
		));

	}

	function query_1()
	{
		return array(
			'select' => array(
				'nilsiskul.*',
				'siswa_nis'		 => 'siswa.nis',
				'siswa_nama'	 => 'siswa.nama',
				'semester_nama'	 => 'semester.nama',
				'ta_nama'		 => 'ta.nama',
				'ekskul_nama'	 => 'ekskul.nama',
				'pembina_nama'	 => "trim(concat_ws(' ', pembina.prefix, pembina.nama, pembina.suffix))",
			),
			'from'	 => 'nilai_siswa_ekskul nilsiskul',
			'join'	 => array(
				array('nilai_siswa nilsis', 'nilsiskul.siswa_nilai_id = nilsis.id', 'left'),
				array('dprofil_siswa siswa', 'nilsis.siswa_id = siswa.id', 'left'),
				array('prd_semester semester', 'nilsis.semester_id = semester.id', 'left'),
				array('prd_ta ta', 'semester.ta_id = ta.id', 'left'),
				array('nilai_ekskul nilkul', 'nilsiskul.ekskul_nilai_id = nilkul.id', 'left'),
				array('dnakd_ekskul ekskul', 'nilkul.ekskul_id = ekskul.id', 'left'),
				array('dprofil_sdm pembina', 'nilkul.pembina_id = pembina.id', 'left'),
				array('dakd_kelas kelas', 'nilsis.kelas_id = kelas.id', 'left'),
			),
		);

	}

	function rowset($id)
	{
		$query = $this->query_1();
		$query['where']['nilsiskul.id'] = $id;

		return $this->md->query($query)->row();

	}

	function save()
	{
		$d = & $this->ci->d;

		$this->form->ruleset($d['row'], 'validasi');
		$this->form->validate();

		if ($d['error'])
		{
			return FALSE;
		}

		$data = $this->inputset('fields');

		return $this->update($data, $d['form']['id']);

	}

	function update($data, $id)
	{

		$this->db->trans_start();

		$this->db->update('nilai_siswa_ekskul', $data, array('id' => $id));

		return $this->trans_done('Data nilai ekskul siswa berhasil diperbarui.', 'Database error, coba beberapa saat lagi.');

	}

	function tambah_ekskul_ke_siswa_($siswa_nilai_id)
	{
		// form validation

		$this->load->library('form_validation');

		$validation_rule = array(
			array(
				'field'	 => 'ekskul_nilai_id',
				'label'	 => 'Ekstrakurikuler',
				'rules'	 => 'required|is_exist[nilai_ekskul.id]'
			),
			array(
				'field'	 => 'nilai',
				'label'	 => 'Nilai Ekstrakurikuler',
				'rules'	 => 'clean|required|max_length[6]|strtoupper',
			),
			array(
				'field'	 => 'keterangan',
				'label'	 => 'Keterangan Ekstrakurikuler',
				'rules'	 => 'clean|required|max_length[400]',
			),
		);

		$this->form_validation->set_rules($validation_rule);

		if ($this->form_validation->run() == FALSE)
		{
			return FALSE;
		}

		$data = array(
			'siswa_nilai_id'	 => $siswa_nilai_id,
			'ekskul_nilai_id'	 => $this->input->post('ekskul_nilai_id'),
			'nilai'				 => $this->input->post('nilai'),
			'keterangan'		 => $this->input->post('keterangan'),
			'keikutsertaan'		 => 'V',
		);

		return $this->db->insert('nilai_siswa_ekskul', $data);

	}

	function tambah_ekskul_ke_siswa($siswa_nilai_id)
	{
		// form validation

		$this->load->library('form_validation');

		$validation_rule = array(
			array(
				'field'	 => 'ekskul_id',
				'label'	 => 'Ekstrakurikuler',
				'rules'	 => 'required|is_exist[dnakd_ekskul.id]'
			),
			array(
				'field'	 => 'nilai',
				'label'	 => 'Nilai Ekstrakurikuler',
				'rules'	 => 'clean|required|max_length[6]|strtoupper',
			),
			array(
				'field'	 => 'keterangan',
				'label'	 => 'Keterangan Ekstrakurikuler',
				'rules'	 => 'clean|required|max_length[400]',
			),
		);

		$this->form_validation->set_rules($validation_rule);

		if ($this->form_validation->run() == FALSE)
		{
			return FALSE;
		}

		$ekskul_id = $this->input->post('ekskul_id');
		$nilkul_id = $this->cek_nilai_ekskul($siswa_nilai_id, $ekskul_id);

		$data = array(
			'siswa_nilai_id'	 => $siswa_nilai_id,
			'ekskul_nilai_id'	 => $nilkul_id,
			'nilai'				 => $this->input->post('nilai'),
			'keterangan'		 => $this->input->post('keterangan'),
			'keikutsertaan'		 => 'V',
		);

		return $this->db->insert('nilai_siswa_ekskul', $data);

	}

	function cek_nilai_ekskul($siswa_nilai_id, $ekskul_id)
	{
		$query_nilsis = $this->db->get_where('nilai_siswa', array('id' => $siswa_nilai_id));
		$row_nilsis = $query_nilsis->first_row();
		$ekskul = array('semester_id' => $row_nilsis->semester_id, 'ekskul_id' => $ekskul_id);

		$query_nilkul = $this->db->get_where('nilai_ekskul', $ekskul);

		if ($query_nilkul->num_rows() > 0)
		{
			$row_nilkul = $query_nilkul->first_row();
			$nilkul_id = $row_nilkul->id;
		}
		else
		{
			$this->db->insert('nilai_ekskul', $ekskul);
			$nilkul_id = $this->db->insert_id();
		}

		return $nilkul_id;

	}

}
