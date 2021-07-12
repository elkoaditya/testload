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

	public function _pdf($filename = 'download', $file = '')
	{
		$download = (bool) $this->input->get_post('download');
		$mode = ($download) ? 'D' : 'I';
		$html = $this->_view($file, TRUE);

		$this->load->library('mpdf');
		$this->mpdf->setAutoTopMargin = TRUE;
		$this->mpdf->setAutoBottomMargin = TRUE;
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
	$cek = $this->mod_login->cek_login();
	
	if($cek==0)
	{	redirect(base_url());	}
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
