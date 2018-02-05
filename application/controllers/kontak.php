<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . '/libraries/REST_Controller.php';
require_once APPPATH . '/libraries/JWT.php';

use \Firebase\JWT\JWT;

/**
 *
 */
class Kontak extends REST_Controller
{

  function __construct($config = 'rest')
  {

    # code...
    parent::__construct($config);
    $this->load->database();
  }
  public function index_get()

  {
    # code...
    $id = $this->get('id');
    if ($id == '') {
      $kontak = $this->db->get('telepon')->result();

      # code...
    }
    else {
      # code...
      $this->db->where('id',$id);
      $kontak = $this->db->get('telepon')->result();
    }
    $this->response($kontak,200);
  }

  public function index_post()
  {
    # code...
    $data = array(
      'id'          => $this->post('id'),
      'username'    => $this->post('username'),
      'password'    => password_hash($this->post('password'),PASSWORD_BCRYPT),
      'nama'        => $this->post('nama'),
      'nomor'       => $this->post('nomor')
    );
    $insert = $this->db->insert('telepon',$data);
    if ($insert) {
      # code...
      $this->response($data,200);

    }
    else {
      # code...
      $this->response(array('status' => 'fail',502));
    }


  }
  public function index_put()
  {
    # code...
    $id = $this->put('id');
    $data = array(
      'id'                => $this->put('id'),
      'username'          => $this->put('username'),
      'password'          => password_hash($this->put('password'),PASSWORD_BCRYPT),
      'nama'              => $this->put('nama'),
      'nomor'             => $this->put('nomor')
    );
     $this->db->where('id', $id);
    $update = $this->db->update('telepon',$data);
    if ($update) {
           $this->response($data, 200);
       } else {
           $this->response(array('status' => 'fail', 502));
       }
  }

  	function index_delete() {
          $id = $this->delete('id');
          $this->db->where('id', $id);
          $delete = $this->db->delete('telepon');
          if ($delete) {
              $this->response(array('status' => 'success'), 201);
          } else {
              $this->response(array('status' => 'fail', 502));
          }
      }
      public function login_post()
      {
          $username = $this->post('username');
          $password = $this->post('password');
          $id     = $this->post('id');
          $this->db->where('username', $username);
          $query= $this->db->get('telepon');

          //$query = $this->db->query("SELECT * FROM telepon WHERE username = '$username'");

          //$result = mysqli_query($connect, $query);
          if($query->num_rows() > 0)
          {

               $row = $query->row();
                    if(password_verify($password, $row->password))
                    {

                      $token['id'] = $id;
                      $output['id_token']   = JWT::encode($token,"my secret key");
                      $this->response($output,REST_Controller::HTTP_OK);


                    }
                    else
                    {
                        $this->response(array('status' => 'fail', 502));
                    }

          }
          else
          {
              $this->response(array('status' => 'fail', 502));
          }


      }

}


 ?>
