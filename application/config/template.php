<?php

// contoh2 konfig di dev-kit ini
//
// controler->construct

$ctrl = array(
		//
		// config untuk fungsi2 / action dalam controller
		'controller' => array(
				'user' => array(), // daftar user-role yg boleh akses
				'uri' => '__', // alamat uri sistem
				'model' => array(), // daftar model yg diload
				'library' => array(), // daftar library yg diload
				'helper' => array(), // daftar helper yg diload
				'request' => array(// daftar request yg diambil
						'input' => 'fungsi_1|fungsi_2',
				),
		),
		//
		// config untuk uri dalam controller
		'uri/path' => array(
		// isi config lain sama seperti controller
		),
		'subconfigs' => array(
		// isi config bebas. bisa sama seperti controller
		),
		'resultsetshape' => array(
				'select' => array(),
				'from' => '',
				'join' => array(),
				'where' => '',
				'like' => '',
				'look' => '',
				'order_by' => '',
				'filter' => array(
						array(
								'type' => 'like/look/where',
								'input' => 'input request',
								'fields' => '',
						),
				),
		),
);

// model->construct

$mdl = array(); // isi config bebas. bisa sama seperti controller

