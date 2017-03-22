<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	public function __construct()
	{
  		parent::__construct();

  		if( $this->session->userdata('users_session') )
        {
            redirect(app_url('chat'));
        }
	}

	public function index()
	{
		$data = array();
		$data['facebook_url'] 	= $this->facebook->get_facebook_url();
        $data['gooogle_url']    = $this->googleplus->loginURL();
        // $data['gooogle_url']    = '';
		$this->template->load('layout/template', 'home/index', $data);
	}


}
