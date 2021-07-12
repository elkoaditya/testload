<?php

class User extends MY_Controller {

  public function __construct() {
    parent::__construct();
    $this->_must_login('admin');
  }

  public function index() {
    $this->browse();
  }

  public function browse() {
    $this->_set('dapplication/user/browse');

    $this->_view();
  }

}
