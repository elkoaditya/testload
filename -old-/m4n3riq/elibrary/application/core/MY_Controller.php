<?php

class MY_Controller extends CI_Controller {


	var $d = array(
		'sql'		 => array(),
		'error'		 => FALSE,
	);
	public function __construct($cfg = array()) {
//    protected $d;
		parent::__construct();
		
		$this->d['data_setting'] = $this->mod_setting->all_set();
        if($this->d['data_setting'])
        {
           // show_error('Sorry the site is shut for now.');
        }
	
	}

	public function _dump($var = NULL)
	{
		echo "<pre>";

		if ($var !== NULL)
			echo "<h2>Var :</h2><p>{$var}</p>";

		echo " <h2>Data :</h2><p>" . print_r($this->d, TRUE) . "</p>";
		echo " <h2>Session :</h2><p>" . print_r($this->session->all_userdata(), TRUE) . "</p>";
		echo '</pre>';
		exit();

	}
	
	function do_upload()
	{
		$config['upload_path'] = UPLOAD_PATH_IMAGE;
		$config['allowed_types'] = 'gif|jpg|png';
		//$config['max_size']	= '1000';
		//$config['max_width']  = '1024';
		//$config['max_height']  = '768';

		$this->load->library('upload', $config);

		if ( ! $this->upload->do_upload('file'))
		{
			$error = array('error' => $this->upload->display_errors());
			//echo"salah".$config['upload_path']."<br/>";
			//print_r($error);
			//$this->load->view('upload_form', $error);
		}
		else
		{
			$data = array('upload_data' => $this->upload->data());
			//echo"benar";
			$this->do_resize($data['upload_data']['file_name']);
			
			return $data['upload_data'];
			//$this->load->view('upload_success', $data);
		}
		//echo $data['full_path'];
	}
	
	public function do_resize($filename)
	{
		$path			= PATH_IMAGE;
		$source_path	= $path . $filename;
		$target_path	= $path . 'thumbnail/' . $filename;
		echo $filename." ".$source_path." ".$target_path;
		$config_manip = array(
			'image_library' => 'gd2',
			'source_image' => $source_path,
			'new_image' => $target_path,
			'maintain_ratio' => TRUE,
			'create_thumb' => TRUE,
			'thumb_marker' => '',
			'width' => 80,
			'height' => 80
		);
		$this->load->library('image_lib', $config_manip);
		if (!$this->image_lib->resize()) {
			echo $this->image_lib->display_errors();
		}
		// clear //
		$this->image_lib->clear();
	}

	function upload_file($name, $type_file ,$path)
	{
		$upload_path = 'content/upload/';
		$config['upload_path'] = APP_ROOT.$upload_path.$path;
		//$config['allowed_types'] = 'gif|jpg|png';
		$config['allowed_types'] = $type_file;
		//$config['max_size']	= '1000';
		//$config['max_width']  = '1024';
		//$config['max_height']  = '768';

		$this->load->library('upload', $config);

		if ( ! $this->upload->do_upload($name))
		{
			$error = array('error' => $this->upload->display_errors());
			//echo"salah".$config['upload_path']."<br/>";
			//print_r($error);
			//$this->load->view('upload_form', $error);
		}
		else
		{
			$data = array('upload_data' => $this->upload->data());
			//echo"benar";
			return $data['upload_data'];
			//$this->load->view('upload_success', $data);
		}
		//echo $data['full_path'];
	}

	// output PDF

	public function _pdf($html, $filename = 'download')
	{
		$download = (bool) $this->input->get_post('download');
		$mode = ($download) ? 'D' : 'I';
		
		$this->load->library('mpdf');
		$this->mpdf->setAutoTopMargin = TRUE;
		$this->mpdf->setAutoBottomMargin = TRUE;
		$this->mpdf->showWatermarkText = TRUE;
		$this->mpdf->showWatermarkImage = TRUE;
		$this->mpdf->WriteHTML($html);
		$this->mpdf->Output("{$filename}.pdf", $mode);

	}
}
 
class Admin_Controller extends MY_Controller
{
  function __construct()
  {
    parent::__construct();
    echo 'This is from admin controller';
  }
}
 
class Member_Controller extends MY_Controller
{
  function __construct()
  {
    parent::__construct();
   // echo 'This is from Member controller';
	$cek = $this->mod_login->cek_siswa();
	
	if($cek==0)
	{	//redirect(base_url());
		$cek = $this->mod_login_admin->cek_login();
		if($cek==0)
		{
			redirect(base_url()."dashboard/login");
		}
	}
  }
}
class Public_Controller extends MY_Controller
{
  function __construct()
  {
    parent::__construct();
	
    //echo 'This is from public controller';
	//print_r($this->session->all_userdata());
  }
}
