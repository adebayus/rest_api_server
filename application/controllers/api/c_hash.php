<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . '/libraries/REST_Controller.php';

/**
 *
 */
class C_hash extends REST_Controller

{

  function __construct($config)
  {
    # code...
    parent::__construct($config);
    $this->load->database();
  }
}


 ?>
