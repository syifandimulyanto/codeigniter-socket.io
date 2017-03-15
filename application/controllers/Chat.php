<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Chat extends CI_Controller {

	public function __construct()
	{
  		parent::__construct();
  		is_login();
  		$this->load->model('Globalmodel', 'modeldb');
  		$this->load->model('Custommodel', 'customdb');
	}

	public function index()
	{
		$data = array();
		$this->template->load('layout/template', 'chat/index', $data);
	}

	public function send()
	{
		$response = array();
	    $this->form_validation->set_rules('content', 'Konten harap diisi', 'required');
	    if ($this->form_validation->run() == TRUE)
	    {
	            $users_id      = get_users('id');

	            if(!empty($users_id))
	            { 
	            	$param = $this->input->post();
		            $param['users_id']     	= get_users('id');
		            $param['create_at']   	= date('Y-m-d H:i:s');
		            $insert = $this->modeldb->insert('chats', $param);

		            if ($insert > 0) 
		            {
		                $response['status']     = TRUE; 
		                $response['content']  	= $this->input->post('content');
		                $response['avatar'] 	= get_users('avatar');
		            }
	            }else
	            {
	                $response['status'] = FALSE;
	                $response['notif']  = "Login terlebih dahulu";
	            }

	    }else
	    {
	            $response['status'] = FALSE;
	            $response['notif']  = (validation_errors() ? validation_errors() : "");
	    }
	    echo json_encode($response);
	}

	public function get_chats()
	{
		$param 		= $this->input->post();
		$message 	= $this->customdb->get_chats($param['group']);

		$response = array();
		$response['status'] = TRUE;
		$response['data'] 	= $message;
		echo json_encode($response);

	}


}
