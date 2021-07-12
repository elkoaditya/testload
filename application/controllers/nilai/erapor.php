<?php

class Erapor extends MY_Controller
{

	public function __construct()
	{
		parent::__construct(array(
			'controller'		 => array(
				'user'		 => array('admin'),
				'model'		 => 'm_nilai_erapor',
				
			),
			'nilai/erapor/impor'	 => array(
				'user'		 => array('admin'),
				'library'	 => 'form',
				'helper'	 => array('form','excel'),
				
			),
		));
	}
	
	
	public function index()
	{
		$this->impor();

	}
	
	public function impor($aksi = '', $semester='')
	{
		$this->_set('nilai/erapor/impor');

		$d = & $this->d;
		$format = ($aksi === 'expor');

		if ($d['user']['role'] != 'admin')
		{
			return alert_error('Impor hanya dapat dilakukan melalui admin kurikulum.', 'nilai/erapor');
		}
		if ($d['semaktif']['id'] < 1)
			return alert_error('Tak dapat mengimpor deskripsi pada masa jeda semester.', 'nilai/erapor');

		if (!$format && $d['post_request'] && !$d['error'])
		{	$this->m_nilai_erapor->impor();	}
		else{		
		
		$this->form->set();
		$this->_view();
		}
	}

}
	
?>