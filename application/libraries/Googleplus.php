<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Googleplus {
	
	private $CI;
	public function __construct() {
		
		$this->CI = &get_instance();
		
		require APPPATH .'third_party/google-login-api/apiClient.php';
		require APPPATH .'third_party/google-login-api/contrib/apiOauth2Service.php';
		
		$this->client = new apiClient();
		$this->client->setApplicationName($this->CI->config->item('application_name', 'googleplus'));
		$this->client->setClientId($this->CI->config->item('client_id', 'googleplus'));
		$this->client->setClientSecret($this->CI->config->item('client_secret', 'googleplus'));
		$this->client->setRedirectUri($this->CI->config->item('redirect_uri', 'googleplus'));
		$this->client->setDeveloperKey($this->CI->config->item('api_key', 'googleplus'));
		$this->client->setScopes($this->CI->config->item('scopes', 'googleplus'));
		$this->client->setAccessType('online');
		$this->client->setApprovalPrompt('auto');
		$this->oauth2 = new apiOauth2Service($this->client);
	}
	
	public function loginURL() {
        return $this->client->createAuthUrl();
    }
	
	public function getAuthenticate() {
        return $this->client->authenticate();
    }
	
	public function getAccessToken() {
        return $this->client->getAccessToken();
    }
	
	public function setAccessToken() {
        return $this->client->setAccessToken();
    }
	
	public function revokeToken() {
        return $this->client->revokeToken();
    }
	
	public function getUserInfo() {
        return $this->oauth2->userinfo->get();
    }
	
	function check_facebook_to_user($google_data)
    {
        $this->CI->load->model('Globalmodel', 'librarydb');
        $response   = TRUE;
        $cnt_users  = $this->CI->librarydb->count('users', ['google_id' => $google_data['id']] );
        if($cnt_users > 0)
        {
          $data_users = $this->CI->librarydb->get_list('users', ['google_id' => $google_data['id']] );
          $this->CI->session->set_userdata('users_session', $data_users[0]);
        }
        else
        {
            $cnt_users_email = $this->CI->librarydb->count('users', ['email' => $google_data['email']] );
            if($cnt_users > 0)
            {
                $data_users_email = $this->CI->librarydb->get_list('users', ['email' => $google_data['email']] );
                $this->CI->librarydb->update('users', array('google_id' => $google_data['id']), ['email' => $google_data['email']]  );
                $this->CI->session->set_userdata('users_session', $data_users_email[0]);
            }
            else
            {
                $ori    = $google_data['picture'];
            
                $name = explode(" ", $google_data['name']);
                $param  = array();
                $param['email']         = $google_data['email'];
                $param['google_id']     = $google_data['id'];
                $param['first_name']    = @$name[0]; 
                $param['last_name']     = @$name[1]; 
                $param['avatar']        = $google_data['picture'];
                $param['register_at']   = date('Y-m-d H:i:s');
                $param['last_login']    = date('Y-m-d H:i:s');
                $save = $this->CI->librarydb->insert('users', $param);

                if($save > 0)
                {   
                    $response = TRUE;
                    $users    = $this->CI->librarydb->get_list('users', ['id' => $save] );
                    $this->CI->session->set_userdata('users_session', $users[0]);                    
                }
                else
                {
                  $response = FALSE;
                }
             
            }
        }
        return $response;
    }

}
?>