<?php

class MY_Model extends CI_Model {

	var $ci;
	var $cfg;
	var $dm = array();
	//var $upload_temp = 'content/uploads/';

	public function __construct($cfg = array()) {
		parent::__construct();
		$this->ci = & get_instance();
		$this->cfg = $cfg;
	}

	// operasi tambahan

	function cfgm() {
		return array_node($this->cfg, func_get_args());
	}

	function file_store($upload, $folder, $old = array()) {
		$content_path = APP_ROOT . 'content';
		$folder = $content_path . '/' . $folder;

		// detek file lama dan hapus

		if (!empty($old)):
			$full_path = (string) array_node($old, array('full_path'));

			delete($full_path);

		endif;

		// simpan file file

		$file = $upload;
		$file['file_path'] = $folder;
		$file['full_path'] = $file['file_path'] . $file['file_name'];

		//@chmod($content_path, 0775);
		// siapkan folder

		if (!file_exists($file['file_path'])):
			try {
				mkdir($file['file_path'], 0775, TRUE);
			} catch (Exception $e) {
				@chmod($content_path, 0775);
				return alert_error("Folder penyimpanan error, coba beberapa saat lagi.<br/>" . $e->getMessage());
			}
		endif;

		// tempatkan file baru

		try {
			rename($upload['full_path'], $file['full_path']);
		} catch (Exception $e) {
			@chmod($content_path, 0775);
			return alert_error("Penyimpanan file error, coba beberapa saat lagi.<br/>" . $e->getMessage());
		}

		// finishing

		@chmod($file['full_path'], 0775);
		@chmod($file['file_path'], 0775);
		//@chmod($content_path, 0775);

		$file['file_path'] = path_relative($file['file_path']);
		$file['full_path'] = path_relative($file['full_path']);

		return $file;
	}

	function file_store_clasic($upload, $folder, $old = array()) {
		$content_path = APP_ROOT . 'content';
		$folder = $content_path . '/' . $folder;

		// detek file lama dan hapus

		if (!empty($old)):
			$full_path = (string) array_node($old, array('full_path'));

			delete($full_path);

		endif;

		// simpan file file

		$file = $upload;
		$file['file_path'] = $folder;
		$file['full_path'] = $file['file_path'] . $file['file_name'];

		//@chmod($content_path, 0777);
		chmod($content_path, 0777);

		// siapkan folder

		/*
		  if (!file_exists($file['file_path'])):
		  try {
		  mkdir($file['file_path'], 0777, TRUE);
		  } catch (Exception $e) {
		  @chmod($content_path, 0775);
		  return alert_error("Folder penyimpanan error, coba beberapa saat lagi.<br/>" . $e->getMessage());
		  }
		  endif;
		 *
		 */
		if (!file_exists($file['file_path']))
			mkdir($file['file_path'], 0777, TRUE);

		// tempatkan file baru

		/*
		  try {
		  rename($upload['full_path'], $file['full_path']);
		  } catch (Exception $e) {
		  @chmod($content_path, 0775);
		  return alert_error("Penyimpanan file error, coba beberapa saat lagi.<br/>" . $e->getMessage());
		  }
		 *
		 */
		rename($upload['full_path'], $file['full_path']);

		// finishing
		/*
		  @chmod($file['full_path'], 0775);
		  @chmod($file['file_path'], 0775);
		  @chmod($content_path, 0775);
		 *
		 */
		chmod($file['full_path'], 0775);
		chmod($file['file_path'], 0775);
		chmod($content_path, 0775);

		$file['file_path'] = path_relative($file['file_path']);
		$file['full_path'] = path_relative($file['full_path']);

		return $file;
	}

	function filter($cfg) {
		if (!is_array($cfg))
			$cfg = (array) $this->cfgm(func_get_args());

		$this->md->filter($cfg);
	}

	function input($fields = 'fields', $data = array()) {
		$data = (array) $data;

		if (!is_array($fields))
			$fields = $this->cfgm($fields);

		if (!$fields OR !is_array($fields))
			return $data;

		foreach ($fields as $field)
			$data[$field] = $this->input->post($field);

		return $data;
	}

	function inputset($fields = 'fields') {
		$args = (array) func_get_args();
		$dat = array();

		foreach ($args as $fields):

			if (!is_array($fields))
				$fields = $this->cfgm($fields);

			if (!$fields OR !is_array($fields))
				continue;

			foreach ($fields as $field)
				$dat[$field] = $this->input->post($field);

		endforeach;

		return $dat;
	}

	function inputfilter($row, $fields = 'fields') {
		$dat = array();

		if (!is_array($fields))
			$fields = $this->cfgm($fields);

		if (!$fields OR !is_array($fields))
			return $dat;

		foreach ($fields as $idx => $val):

			if (is_int($idx)):
				$dat[$val] = $this->input->post($val);
				continue;
			endif;

			$input = $this->input->post($idx);

			if ($input !== FALSE && ($row['id'] == 0 OR !isset($row[$idx]) OR strcasecmp($input, $row[$idx]))):
				$dat[$idx] = $input;
			endif;

		endforeach;

		return $dat;
	}

	function row() {
		$query = $this->db->limit(1)->get();
		return ($query->num_rows() > 0) ? $query->row_array() : NULL;
	}

	function trans_commit($msg = '') {
		$this->db->trans_commit();
		return ($msg === '') ? TRUE : alert_success($msg);
	}

	function trans_done($msg_sukses = '', $msg_gagal = '') {
		$trx = $this->db->trans_status();

		if ($trx)
			$this->trans_commit($msg_sukses);
		else
			$this->trans_rollback($msg_gagal);

		return $trx;
	}

	function trans_rollback($msg = '') {
		$this->db->trans_rollback();

		if ($msg != '')
			alert_error($msg);

		return NULL;
	}

	//$maxsize = 8192;	
	function upload($input = 'upload', $type = '*', $maxsize = 200000) {

		if (!isset($_FILES[$input]) OR $_FILES[$input]['size'] <= 0)
			return FALSE;

		$upload_temp = APP_ROOT."content/". strtolower(APP_SCOPE) ."/uploads/";
		
		$upload = array(
				//'upload_path' => $this->upload_temp,
				'upload_path' => $upload_temp,
				'allowed_types' => '*',
				'max_size' => $maxsize,
				'overwrite' => FALSE,
		);

		$this->load->library('upload');
		$this->upload->initialize($upload);

		$do_upload = $this->upload->do_upload($input);

		if ($do_upload == FALSE)
			return alert_error($this->upload->display_errors());

		$file = $this->upload->data();
		$file['file_path'] = path_relative($file['file_path']);
		$file['full_path'] = path_relative($file['full_path']);

		if ($type === '*')
			return $file;

		if (!is_array($type))
			$type = explode(',', $type);

		$uptype = trim($file['file_ext'], ' .');

		if (!in_array($uptype, $type)):
			@unlink($file['full_path']);
			return alert_error('Tipe file tidak sesuai. Seharusnya berekstensi: ' . implode(', ', $type));
		endif;

		return $file;
	}

	function upload_gambar($input = 'upload', $maxsize = 8192, $maxwidth = 2048, $maxheight = 2048, $adaptive = FALSE) {
		$upload = $this->upload($input, 'gif,jpg,jpeg,png', $maxsize);

		if (!$upload)
			return FALSE;

		$this->load->library('PhpThumbFactory');

		if (!$upload)
			return FALSE;
			
		$upload['full_path'] = APP_ROOT.$upload['full_path'];
		//return alert_error($upload['full_path']);
		try {
			$thumb = PhpThumbFactory::create($upload['full_path']);

			if ($adaptive)
				$thumb->adaptiveResize($maxwidth, $maxheight);
			else
				$thumb->resize($maxwidth, $maxheight);

			$thumb->save($upload['full_path']);
			//
		} catch (Exception $e) {
			alert_info("Upload gambar error.<br/>" . $e->getMessage());
			delete($upload['full_path']);
			return NULL;
		}

		$img = getimagesize($upload['full_path']);
		$upload['image_width'] = $img[0];
		$upload['image_height'] = $img[1];
		//$upload['file_path'] = path_relative($upload['file_path']);
		//$upload['full_path'] = path_relative($upload['full_path']);

		return $upload;
	}

}
