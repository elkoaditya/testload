<?php

class Md extends CI_Model {

	var $ci;

	public function __construct() {
		parent::__construct();
		$this->ci = & get_instance();
	}

	function empty_result($index = 0, $limit = 0) {
		return array(
				'total_rows' => 0,
				'selected_rows' => 0,
				'index' => (int) $index,
				'start' => ( $index + 1),
				'end' => 0,
				'limit' => (int) $limit,
				'data' => array(),
				'pagination' => FALSE,
				'overload' => FALSE,
		);
	}

	function filter($cfg) {
		$d = $this->ci->d;

		foreach ($cfg as $item):
			$input = isset($d[$item['input']]) ? $d[$item['input']] : NULL;

			if (!$input)
				continue;

			if ($item['type'] == 'like')
				$this->like($input, $item['field']);
			else if ($item['type'] == 'look')
				$this->look($input, $item['field']);
			else
				$this->db->where($item['field'], $input);

		endforeach;
	}

	function like($term, $fields) {
		$term = clean(trimin($term));
		$fields = (array) $fields;
		$filter = array();

		if (!strlen($term))
			return;

		if (func_num_args() > 2)
			$fields = array_merge($fields, array_slice(func_get_args(), 2));

		foreach ($fields as $field):
			$wc = strpos($field, '%');

			if ($wc === FALSE):
				$filter[] = "{$field} like '%{$term}%'";
				continue;
			endif;

			$field = str_replace('%', '', $field);
			$filter[] = ($wc === 0) ? "{$field} like '%{$term}'" : "{$field} like '{$term}%'";

		endforeach;

		$filterset = '( ' . implode(' OR ', $filter) . ' )';
		$this->db->where($filterset);
	}

	function paging(&$result, $config = '') {
		if (!is_array($config))
			$config = cfgc($config);

		if (!$config)
			return;

		$this->load->library('pagination');

		$defaults = array(
				'uri_segment' => 4,
				'num_links' => 5,
				'next_link' => '&blacktriangleright;',
				'prev_link' => '&blacktriangleleft;',
				'first_link' => '&compfn;',
				'last_link' => '&compfn;',
				'base_url' => $this->d['uri'],
		);

		array_default($config, $defaults);

		$config['base_url'] = base_url($config['base_url']);
		$config['first_url'] = $config['base_url'] . array2qs();
		$config['suffix'] = array2qs();
		$config['total_rows'] = $result['total_rows'];
		$config['per_page'] = $result['limit'];

		$this->pagination->initialize($config);

		$result['pagination'] = $this->pagination->create_links();
	}

	function query($query) {

		if (isset($query['select']))
			$this->select($query['select']);

		if (isset($query['from']))
			$this->db->from($query['from']);

		if (isset($query['join']))
			foreach ($query['join'] as $join)
				$this->db->join($join[0], $join[1], ((isset($join[2])) ? $join[2] : ''));

		if (isset($query['where']))
			$this->db->where($query['where']);

		if (isset($query['where_strings'])):
			$query['where_strings'] = (array) $query['where_strings'];

			foreach ($query['where_strings'] as $where):
				if (is_array($where)):
					$this->db->where($where);
				else:
					$this->db->where("({$where})");
				endif;
			endforeach;

		endif;

		if (isset($query['where_in']) && is_array($query['where_in']))
			foreach ($query['where_in'] as $col => $val)
				$this->db->where_in($col, $val);

		if (isset($query['like']))
			$this->like($query['like'][0], $query['like'][1]);

		if (isset($query['filter']))
			$this->filter($query['filter']);

		if (isset($query['limit']))
			$this->db->limit($query['limit']);

		if (isset($query['order_by']))
			$this->db->order_by($query['order_by']);
			
		if (isset($query['group_by']))
			$this->db->group_by($query['group_by']);

		return $this;
	}

	function quick_insert($table, $input) {
		$this->db->trans_start();
		$this->db->insert($table, $input);
		$id = $this->db->insert_id();

		if ($this->db->trans_status()):
			$this->db->trans_commit();
			return $id;
		endif;

		$this->db->trans_rollback();
		return FALSE;
	}

	function quick_insert_batch($table, $input) {
		$this->db->trans_start();
		$this->db->insert_batch($table, $input);

		if ($this->db->trans_status()):
			$this->db->trans_commit();
			return TRUE;
		endif;

		$this->db->trans_rollback();
		return FALSE;
	}

	function quick_update($table, $data, $id) {
		$this->db->trans_start();

		if (is_array($id) == FALSE)
			$this->db->where('id', $id);
		else
			$this->db->where($id);

		$this->db->update($table, $data);

		if ($this->db->trans_status()):
			$this->db->trans_commit();
			return TRUE;
		endif;

		$this->db->trans_rollback();
		return FALSE;
	}

	function result($sql = '', $bindings = array()) {
		$result = $this->empty_result();

		if ($sql === '')
			$query = $this->db->get();
		else
			$query = $this->db->query($sql, $bindings);

		if (ENVIRONMENT == 'development')
			$result['sql'] = $this->db->last_query();

		$result['total_rows'] = $query->num_rows();

		if ($result['total_rows'] > 0):
			$result['data'] = $query->result_array();
			$result['selected_rows'] = $result['total_rows'];
			$result['end'] = $result['total_rows'];
		endif;

		$query->free_result();

		return $result;
	}

	function result_series($id, $label, $sql = '', $bindings = array()) {
		$seri = array();

		if ($sql === '')
			$query = $this->db->get();
		else
			$query = $this->db->query($sql, $bindings);

		if ($query->num_rows() > 0)
			foreach ($query->result_array() as $row):
				$idx = intif($row[$id]); // (is_numeric($row[$id])) ? abs($row[$id]) : $row[$id];
				$val = intif($row[$label]); //(is_numeric($row[$label])) ? abs($row[$label]) : $row[$label];
				$seri[$idx] = $val;
			endforeach;

		return $seri;
	}

	function result_values($label, $sql = '', $bindings = array()) {
		$seri = array();

		if ($sql === '')
			$query = $this->db->get();
		else
			$query = $this->db->query($sql, $bindings);


		if ($query->num_rows() > 0)
			foreach ($query->result_array() as $row)
				$seri[] = intif($row[$label]); // (is_numeric($row[$label])) ? abs($row[$label]) : $row[$label];

		return $seri;
	}

	function resultset($index = 0, $limit = 0, $pagination = FALSE) {
		$index = (int) $index;
		$limit = (int) $limit;
		$overload_limit = 2048;

		if ($limit == 0)
			$limit = $overload_limit;

		elseif ($limit < 2)
			$limit = 2;

		$result = $this->empty_result($index, $limit);

		if ($limit > 100)
			$db_limit = $limit + 1;
		else
			$db_limit = $limit * 5;

		$this->db->limit($db_limit, $index);
		$query = $this->db->get();

		if (ENVIRONMENT == 'development')
			$result['sql'] = $this->db->last_query();

		$result['num_rows'] = $query->num_rows();
		$result['total_rows'] = $result['num_rows'] + $index;
		$result['overload'] = (bool) ($result['num_rows'] >= $db_limit);

		if ($result['total_rows'] > 0):
			$result['data'] = array_slice($query->result_array(), 0, $limit);
			$result['selected_rows'] = count($result['data']);
			$result['end'] = $index + $result['selected_rows'];
		endif;

		$query->free_result();

		if ($pagination)
			$this->paging($result, $pagination);

		return $result;
	}

	function row($sql = '', $bindings = array()) {

		if ($sql === '')
			$query = $this->db->limit(1)->get();
		else
			$query = $this->db->query($sql, $bindings);

		if ($query->num_rows() > 0)
			$row = $query->row_array();
		else
			$row = FALSE;

		$query->free_result();

		return $row;
	}

	function row_col($col, $sql = '', $bindings = array()) {
		$row = $this->row($sql, $bindings);

		if (!$row)
			return FALSE;

		return $row[$col];
	}

	function rowset($id = 0, $table = '') {

		if ($table !== '')
			$this->db->from($table);

		if (is_array($id))
			$this->db->where($id);
		else if ($id)
			$this->db->where('id', $id);

		$query = $this->db->limit(1)->get();

		return ($query->num_rows() > 0) ? $query->row_array() : FALSE;
	}

	function select($kolom) {
		$cols = array();

		if (!$kolom)
			return;

		foreach ($kolom as $idx => $field)
			$cols[] = $field . (!is_int($idx) ? " {$idx}" : "");

		return $this->db->select(implode(', ', $cols), FALSE);
	}

}
