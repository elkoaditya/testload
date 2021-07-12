<?php 

class utama_model extends CI_Model {


	//// FUNCTION UTAMA DB GET ALL /////
	/*
		$table		= name table
		$limit	= batasan
		%offset	= offset
		$order_coloumn	= name coloumn id
		$order  = asc or desc
	*/
	function get_data_all_one_table($table, $limit, $offset, $order_coloumn='', $order='asc'){
		
		if($order_coloumn!='')
		{	$this->db->order_by($order_coloumn, $order);	}
		
		$query	=	$this->db->get($table , $offset, $limit);
		
		return $query->result(); 

    }

	
	
	//// FUNCTION UTAMA DB GET by ID /////
	/*
		$table		= name table
		$where_coloumn	= name coloumn id
		%id		= id
	*/
	function get_detail_id_one_table($table, $where_coloumn, $id){

		$this->db->limit(1);
		
        $this->db->where($where_coloumn, $id);

        $query	=	$this->db->get($table);
		
		return $query->result(); 
		
    }
	
	
	
	//// FUNCTION UTAMA DB GET by WHERE /////
	/*
		$table				= name table
		$limit			= batasan
		$offset			= offset
		$where_coloumn	= name coloumn where
		$where			= where
		$order_coloumn	= name coloumn id
		$order  		= asc or desc
	*/
	function get_data_by_where_one_table($table, $limit, $offset, $where_coloumn, $where, $order_coloumn='', $order='asc'){
		
		$this->db->where($where_coloumn, $where);
		
		if($order_coloumn!='')
		{	$this->db->order_by($order_coloumn, $order);	}
		
		$query	=	$this->db->get($table , $offset, $limit);
		
		return $query->result();
	}
	
	
	
	//// FUNCTION UTAMA DB GET by MULTIWHERE /////
	/*
		$table				= name table
		$limit			= batasan
		$offset			= offset
		$where_coloumn	= name coloumn where
		$where			= where
		$size			= jumlah where
		$order_coloumn	= name coloumn id
		$order  		= asc or desc
	*/
	function get_data_by_multiwhere_one_table($table, $where_coloumn = array(), $where = array(), $size, $order_coloumn='', $order='asc', $limit, $offset){
		
		$loop=0;
		while($loop<$size)
		{	
			$this->db->where($where_coloumn[$loop], $where[$loop]);	
			$loop++;
		}
		
		if($order_coloumn!='')
		{	$this->db->order_by($order_coloumn, $order);	}
		
		$query	=	$this->db->get($table , $offset, $limit);
		
		return $query->result();
	}
	
	//// FUNCTION UTAMA DB GET SELECT by MULTITABLE/////
	/*
		$select			= select get coloumn
		$table				= name table
		$limit			= batasan
		$offset			= offset
		$size			= jumlah where
		$order_coloumn	= name coloumn id
		$order  		= asc or desc
	*/
	function get_select_data_by_multitable($select, $table, $table_join = array(), $where_join = array(), $size_join, $limit, $offset, 
	$order_coloumn='', $order='asc'){
		
		$this->db->select($select);
		
		if($order_coloumn!='')
		{	$this->db->order_by($order_coloumn, $order);	}
		
		$loop=0;
		while($loop<$size_join)
		{
			$this->db->join($table_join[$loop], $where_join[$loop],'left');
			$loop++;
		}
		
		$query	=	$this->db->get($table , $offset, $limit);
		
		return $query->result();
	}
	
	//// FUNCTION UTAMA DB GET SELECT by MULTITABLE GROUP/////
	/*
		$select			= select get coloumn
		$table				= name table
		$limit			= batasan
		$offset			= offset
		$size			= jumlah where
		$order_coloumn	= name coloumn id
		$order  		= asc or desc
		$group			= group data
	*/
	function get_select_data_by_multitable_group($select, $table, $table_join = array(), $where_join = array(), $size_join, $group, $limit, $offset, 
	$order_coloumn='', $order='asc'){
		
		$this->db->select($select);
		
		if($order_coloumn!='')
		{	$this->db->order_by($order_coloumn, $order);	}
		
		$loop=0;
		while($loop<$size_join)
		{
			$this->db->join($table_join[$loop], $where_join[$loop],'left');
			$loop++;
		}
		
		$this->db->group_by($group);
		
		$query	=	$this->db->get($table , $offset, $limit);
		
		return $query->result();
	}
	
	
	//// FUNCTION UTAMA DB GET by MULTIWHERE MULTITABLE/////
	/*
		$table				= name table
		$limit			= batasan
		$offset			= offset
		$where_coloumn	= name coloumn where
		$where			= where
		$size			= jumlah where
		$order_coloumn	= name coloumn id
		$order  		= asc or desc
	*/
	function get_data_by_multiwhere_multitable($table, $table_join = array(), $where_join = array(), $size_join, $limit, $offset, 
	$where_coloumn = array(), $where = array(), $size_where, $order_coloumn='', $order='asc'){
		
		$loop=0;
		while($loop<$size_where)
		{	
			$this->db->where($where_coloumn[$loop], $where[$loop]);	
			$loop++;
		}
		
		if($order_coloumn!='')
		{	$this->db->order_by($order_coloumn, $order);	}
		
		$loop=0;
		while($loop<$size_join)
		{
			$this->db->join($table_join[$loop], $where_join[$loop],'left');
			$loop++;
		}
		
		$query	=	$this->db->get($table , $offset, $limit);
		
		return $query->result();
	}

	
	//// FUNCTION UTAMA DB GET SELECT by MULTIWHERE MULTITABLE/////
	/*
		$select			= select get coloumn
		$table				= name table
		$limit			= batasan
		$offset			= offset
		$where_coloumn	= name coloumn where
		$where			= where
		$size			= jumlah where
		$order_coloumn	= name coloumn id
		$order  		= asc or desc
	*/
	function get_select_data_by_multiwhere_multitable($select,$table, $table_join = array(), $where_join = array(), $size_join, $limit, $offset, 
	$where_coloumn = array(), $where = array(), $size_where, $order_coloumn='', $order='asc'){
		
		$loop=0;
		$this->db->select($select);
		
		while($loop<$size_where)
		{	
			$this->db->where($where_coloumn[$loop], $where[$loop]);	
			$loop++;
		}
		
		if($order_coloumn!='')
		{	$this->db->order_by($order_coloumn, $order);	}
		
		$loop=0;
		while($loop<$size_join)
		{
			$this->db->join($table_join[$loop], $where_join[$loop],'left');
			$loop++;
		}
		
		$query	=	$this->db->get($table , $offset, $limit);
		
		return $query->result();
	}
	
	//// FUNCTION UTAMA DB GET SELECT by MULTIWHERE MULTITABLE GROUP/////
	/*
		$select			= select get coloumn
		$table				= name table
		$limit			= batasan
		$offset			= offset
		$where_coloumn	= name coloumn where
		$where			= where
		$size			= jumlah where
		$order_coloumn	= name coloumn id
		$order  		= asc or desc
		$group			= group data
	*/
	function get_select_data_by_multiwhere_multitable_group($select,$table, $table_join = array(), $where_join = array(), $size_join, $limit, $offset, 
	$where_coloumn = array(), $where = array(), $size_where, $group, $order_coloumn='', $order='asc'){
		
		$loop=0;
		$this->db->select($select);
		
		while($loop<$size_where)
		{	
			$this->db->where($where_coloumn[$loop], $where[$loop]);	
			$loop++;
		}
		
		if($order_coloumn!='')
		{	$this->db->order_by($order_coloumn, $order);	}
		
		$loop=0;
		while($loop<$size_join)
		{
			$this->db->join($table_join[$loop], $where_join[$loop],'left');
			$loop++;
		}
		
		$this->db->group_by($group);
		
		$query	=	$this->db->get($table , $offset, $limit);
		
		return $query->result();
	}
	
	
	
	//// FUNCTION UTAMA DB CREATE QUERY /////
	/*
		$query		= query
	*/
	function master_query($query)
	{
		$this->db->trans_begin();
		
		$this->db->query($query);
		
		if ($this->db->trans_status() === FALSE) {

            $this->db->trans_rollback();

            return false;

        } else {

            $this->db->trans_commit();

            return true;

        }
	}
	
	function master_query_result($query)
	{
		$this->db->trans_begin();
		
		$query2 = $this->db->query($query);
		
		if ($this->db->trans_status() === FALSE) {

            $this->db->trans_rollback();

        } else {

            $this->db->trans_commit();

            return $query2->result();

        }
	}
	
	
	
	
	//// FUNCTION UTAMA DB CREATE UPDATE DELETE /////
	/*
		$crud	= c(create), u(update), d(delete)
		$data	= data 
		$table		= name db
		$where_coloumn	= name coloumn id
		%id		= id
	*/
	function master_crud_one_table($crud, $data, $table, $where_coloumn=0, $id=0) {

        $this->db->trans_begin();

		if($crud=='update')
		{
			$this->db->where($where_coloumn, $id);
			
			$this->db->update($table, $data);
		
		}elseif($crud=='insert'){		
		
			$this->db->insert($table, $data);
		
		}elseif($crud=='delete')
		{
			$this->db->where($where_coloumn, $id);
			
			$this->db->delete($table); 
		
		}
		
		if ($this->db->trans_status() === FALSE) {

            $this->db->trans_rollback();

            return false;

        } else {

            $this->db->trans_commit();

            return true;

        }

    }
	
	//// FUNCTION UTAMA DB CREATE UPDATE DELETE /////
	/*
		$crud	= c(create), u(update), d(delete)
		$data	= data 
		$table		= name db
		$where_coloumn	= name coloumn id
		%id		= id
	*/
	function master_crud_batch_table($crud, $data, $table, $where_coloumn=0) {

        $this->db->trans_begin();

		if($crud=='update')
		{
			
			$this->db->update_batch($table, $data, $where_coloumn);
		
		}elseif($crud=='insert'){		
		
			$this->db->insert_batch($table, $data);
		
		}
		
		if ($this->db->trans_status() === FALSE) {

            $this->db->trans_rollback();

            return false;

        } else {

            $this->db->trans_commit();

            return true;

        }

    }
	
}