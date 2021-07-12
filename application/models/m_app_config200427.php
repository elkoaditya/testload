<?php

class M_app_config extends CI_Model
{

	var $ci;

	var $dat = array();

	public function __construct()
	{
		parent::__construct();
		$this->ci = & get_instance();
		$this->refresh();

	}

	function refresh()
	{
		$query = $this->db->get('app_config');

		if ($query->num_rows() == 0)
			return FALSE;

		$this->dat = array();

		foreach ($query->result_array() as $row)
		{
			$this->load($row);
		}

	}

	function load($row)
	{
		$key = $row['key'];

		if (in_array($row['type'], array('json', 'array')))
		{
			$this->dat[$key] = (array) json_decode($row['value'], TRUE);
		}
		else if (in_array($row['type'], array('int', 'integer')))
		{
			$this->dat[$key] = (int) $row['value'];
		}
		else
		{
			$this->dat[$key] = $row['value'];
		}

	}

	function get_row($key)
	{
		$query = $this->db->get_where('app_config', array('key' => $key), 1, 0);

		if ($query->num_rows() > 0)
		{
			return $query->result_array();
		}

		return NULL;

	}

	function get($key)
	{
		if (array_key_exists($key, $this->dat) == FALSE)
		{
			$row = $this->get_row($key);

			if (!$row)
			{
				return NULL;
			}

			$this->load($row);
		}

		return $this->dat[$key];

	}

	function set($key, $value)
	{
		$row = $this->get_row($key);
		$data = $value;

		if ($row)
		{
			if(!isset($row['type'])){
				$row['type']='';
			}
			
			if (in_array($row['type'], array('json', 'array')) && is_array($data))
			{
				$data = json_encode($data);
			}
		}

		$update = $this->db->update('app_config', array('value' => $data), array('key' => $key));

		if ($update)
		{
			$this->dat[$key] = $value;
		}

		return $update;

	}

	function save($key)
	{
		$value = $this->input->post('config_value');

		return $this->set($key, $value);

	}

	function browse($index = 0, $limit = 50)
	{
		$this->db->from('app_config');
		$this->db->order_by('urut');
		return $this->md->resultset($index, $limit);

	}

	function private_tgl($index = 0, $limit = 50)
	{
		
		///$this->db->from('nilai_kelas');
		$query = $this->db->where(array('semester_id' => $this->d['semaktif']['id']), 1, 0);
		
		$select = array(
			'nilai_kelas_id'	=> 'nikel.id',
			'kelas_id'		 	=> 'nikel.kelas_id',
			'semester_id'	 	=> 'nikel.semester_id',
			'tanggal_mid_new'	=> 'nikel.tanggal_mid_new',
			'tanggal_uas_new'	=> 'nikel.tanggal_uas_new',
			'tanggal_mutasi'	=> 'nikel.tanggal_mutasi',
			
			'nama_kelas'	 	=> 'kelas.nama',
			'grade_kelas'	 	=> 'kelas.grade',
		);
		$this->db
			->from('nilai_kelas nikel')
			->join('dakd_kelas kelas', 'kelas.id = nikel.kelas_id', 'inner')
			->order_by('kelas.nama');

		// commit selection

		$this->md->select($select);

		
		return $this->md->resultset($index, $limit);

	}

	function save_private_tgl()
	{
		$post_mid = $this->input->post('config_value_mid');
		$post_uas = $this->input->post('config_value_uas');
		$post_mutasi = $this->input->post('config_value_mutasi');
		
		$a= 0;
		foreach ($post_mid as $key => $value) {
			$data = array(
						   'tanggal_mid_new' => $post_mid[$key],
						   'tanggal_uas_new' => $post_uas[$key],
						   
						);
			if (array_key_exists($key,$post_mutasi))
			{	$data['tanggal_mutasi']  = $post_mutasi[$key];	}
		
			$this->db->where('id', $key);
			$this->db->update('nilai_kelas', $data); 
			$a++;
		}
		return $a;
	}
}
