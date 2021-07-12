<?php

$config = array(
	'model' => array('m_data_user'),
	'library' => array('form', 'form_validation'),
	'helper' => array('form'),
	'request' => 'redir',
	'validation' => array(
		array(
			'field' => 'username',
			'label' => 'username',
			'rules' => 'as_string|required|alpha_char[@]'
		),
		array(
			'field' => 'password',
			'label' => 'password',
			'rules' => 'as_string|required|crypto'
		),
	),
);