<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Auth extends CI_Controller{
	 public function __construct(){
        parent::__construct();
        $this->load->model('Globalmodel', 'modeldb');
  	}

    public function facebook()
    {
  	    $auth   = $this->facebook->get_access_facebook_data();
        $check  = $this->facebook->check_facebook_to_user($auth);
        if($check)
        {
          redirect(app_url('chat'));
        } 
    }

    public function googleplus()
    {
        $this->googleplus->getAuthenticate();

        $auth   = $this->googleplus->getUserInfo();
        $check  = $this->googleplus->check_facebook_to_user($auth);
        if($check)
        {
            redirect(app_url('chat'));
        }
    }

    public function logout()
    {
      $this->session->sess_destroy();
      redirect(app_url());
    }
}



