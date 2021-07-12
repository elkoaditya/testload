<?php

class Home extends MY_Controller {

  public function __construct() {
    parent::__construct();
  }

  public function _remap() {
    $this->_redir();
  }

}
