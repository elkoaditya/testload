<?php

class Kenaikan extends MY_Controller
{

	public function __construct()
	{
		parent::__construct(array(
			'controller' => array(
				'user'	 => array('admin'),
				'model'	 => array('m_option'),
				'helper' => array('form'),
			),
		));

	}

	public function tes($teks = '')
	{
		$this->d['output'] .= 'tes ' . $teks;

	}

	public function index()
	{
		$d = & $this->d;
		$d['output'] = '';

		$this->_persiapan();

		$this->_header();

		$this->_form_ganti_kelas();

		if (is_numeric($d['request']['kelas_id']))
		{
			$this->_data_siswa();
		}

		if ($d['post_request'])
		{
			$this->_simpan_siswa();

			if (count($d['saved']) > 0)
			{
				$this->_hasil_update();
			}
		}

		exit($d['output']);

	}

	public function _persiapan()
	{
		$d = & $this->d;

		$this->_set('kenaikan');

		if ($d['semaktif']['id'] > 0)
		{
			return alert_error('Semester harus ditutup dahulu.', TRUE);
		}

		$this->_request(array('kelas_id'));

		$d['opsi_kelas'] = $this->m_option->kelas(array('0' => '[alumni]'));

	}

	public function _separator()
	{
		$this->d['output'] .= '<hr/><br/></br>';

	}

	public function _header()
	{
		$this->d['output'] .= a('', 'Halaman Depan');

		$this->_separator();

	}

	public function _form_ganti_kelas()
	{
		$d = & $this->d;

		$this->d['output'] .= '<form method="get">';
		$this->d['output'] .= 'Tampilkan Kelas : ';
		$this->d['output'] .= form_dropdown('kelas_id', $d['opsi_kelas'], $d['request']['kelas_id']) . ' ';
		$this->d['output'] .= form_submit('filter', 'Tampilkan Siswa');
		$this->d['output'] .= '</form>';

		$this->_separator();

	}

	public function _query_siswa()
	{
		$d = & $this->d;

		return $this
				->db
				->select('id, nis, nisn, nama, kelas_id')
				->from('dprofil_siswa')
				->where('kelas_id', $d['request']['kelas_id'])
				->order_by('nama')
				->get();

	}

	public function _data_siswa()
	{
		$query = $this->_query_siswa();

		if ($query->num_rows() > 0)
		{
			$this->_tabel_siswa($query);
		}
		else
		{
			$this->d['output'] .= '<h2> Data Siswa Tidak Ditemukan !</h2>';
		}

		$this->_separator();

	}

	public function _tabel_siswa($query)
	{
		$d = & $this->d;

		$this->d['output'] .= form_open('kenaikan', 'method="post"');
		$this->d['output'] .= '<table border="1" cellpadding="4">';
		$this->d['output'] .= '	<tr>';
		$this->d['output'] .= '		<th>No</th>';
		$this->d['output'] .= '		<th>NIS</th>';
		$this->d['output'] .= '		<th>Nama Siswa</th>';
		$this->d['output'] .= '		<th>Kelas Baru</th>';
		$this->d['output'] .= '	</tr>';

		$no = 0;
		foreach ($query->result() as $row)
		{
			$no++;
			$this->d['output'] .= "	<tr>";
			$this->d['output'] .= "		<td>{$no}</td>";
			$this->d['output'] .= "		<td>{$row->nis}</td>";
			$this->d['output'] .= "		<td>{$row->nama}</td>";
			$this->d['output'] .= "		<td>";
			$this->d['output'] .= form_dropdown("siswa[{$row->id}]", $d['opsi_kelas'], $row->kelas_id);
			$this->d['output'] .= "		</td>";
			$this->d['output'] .= "	</tr>";
		}

		$this->d['output'] .= '	<tr>';
		$this->d['output'] .= '		<td colspan="4">';
		$this->d['output'] .= 'Tampilkan kelas berikutnya ';
		$this->d['output'] .= form_dropdown('kelas_id', $d['opsi_kelas'], $d['request']['kelas_id']);
		$this->d['output'] .= "		</td>";
		$this->d['output'] .= '	</tr>';

		$this->d['output'] .= '	<tr>';
		$this->d['output'] .= '		<td colspan="4" align="right">';
		$this->d['output'] .= form_submit('simpan', 'Simpan');
		$this->d['output'] .= "		</td>";
		$this->d['output'] .= '	</tr>';

		$this->d['output'] .= '</table>';
		$this->d['output'] .= form_close();

	}

	public function _simpan_siswa()
	{
		$d = & $this->d;
		$siswa = (array) $this->input->post('siswa');
		$saved = array();

		foreach ($siswa as $id => $kelas_id)
		{
			if (is_numeric($id) && is_numeric($kelas_id))
			{
				$saved[$id] = $kelas_id;

				$this->db->update('dprofil_siswa', array('kelas_id' => $kelas_id), array('id' => $id));
			}
		}

		$d['output'] .= count($saved) . ' pembaruan';
		$d['saved'] = $saved;

		$this->_separator();

	}

	public function _hasil_update()
	{
		$d = & $this->d;
		$siswa_list = array_keys($d['saved']);
		$query = $this
			->db
			->select('id, nis, nisn, nama, kelas.nama nama_kelas ')
			->from('dprofil_siswa')
			->where_in('id', $siswa_list)
			->order_by('nama')
			->get();

		$this->d['output'] .= '<h2> Data Kenaikan Berhasil Disimpan !</h2>';
		$this->d['output'] .= '<table border="1" cellpadding="4">';
		$this->d['output'] .= '	<tr>';
		$this->d['output'] .= '		<th>No</th>';
		$this->d['output'] .= '		<th>NIS</th>';
		$this->d['output'] .= '		<th>Nama Siswa</th>';
		$this->d['output'] .= '		<th>Kelas Baru</th>';
		$this->d['output'] .= '	</tr>';

		$no = 0;
		foreach ($query->result() as $row)
		{
			$no++;
			$this->d['output'] .= "	<tr>";
			$this->d['output'] .= "		<td>{$no}</td>";
			$this->d['output'] .= "		<td>{$row->nis}</td>";
			$this->d['output'] .= "		<td>{$row->nama}</td>";
			$this->d['output'] .= "		<td>{$row->nama_kelas}</td>";
			$this->d['output'] .= "	</tr>";
		}

		$this->d['output'] .= '</table>';

		$this->_separator();

		$this->d['output'] .= 'ID Siswa: ' . implode(', ', $siswa_list);

		$this->_separator();

	}

}
