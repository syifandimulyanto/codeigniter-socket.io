<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Facebook {

  private $CI;
  function __construct()
  {
      require_once( APPPATH . 'third_party/facebook-php-sdk-v4-5.0.0/src/Facebook/autoload.php' );
      $this->CI = &get_instance();
  }

  function get_facebook_url()
  {
      $fb = new Facebook\Facebook([
          'app_id'                => $this->CI->config->item('fb_app_id'),
          'app_secret'            => $this->CI->config->item('fb_app_secret'),
          'default_graph_version' => 'v2.5',
      ]);

      $helper       = $fb->getRedirectLoginHelper();
      $permissions  = ['email', 'public_profile'];
      $callback     = app_url('auth/facebook');
      return $helper->getLoginUrl($callback, $permissions);
  }

  function get_access_facebook_data()
  {
  	  $fb = new Facebook\Facebook([
          'app_id'                => $this->CI->config->item('fb_app_id'),
          'app_secret'            => $this->CI->config->item('fb_app_secret'),
          'default_graph_version' => 'v2.5',
      ]);

      $helper = $fb->getRedirectLoginHelper();
      try {
        $accessToken  = $helper->getAccessToken();
        $response     = $fb->get('/me?fields=id,email,first_name,last_name', $accessToken);
        $user         = $response->getGraphUser();

      } catch(Facebook\Exceptions\FacebookResponseException $e) {
        $accessToken = 'Graph returned an error: ' . $e->getMessage();
        exit;
      } catch(Facebook\Exceptions\FacebookSDKException $e) {
        $accessToken = 'Facebook SDK returned an error: ' . $e->getMessage();
        exit;
      }
      return $user;
  }

  function check_facebook_to_user($fb_data)
  {
      $this->CI->load->model('Globalmodel', 'librarydb');
      $response   = TRUE;
      $cnt_users  = $this->CI->librarydb->count('users', ['fb_id' => $fb_data['id']] );
      if($cnt_users > 0)
      {
        $data_users = $this->CI->librarydb->get_list('users', ['fb_id' => $fb_data['id']] );
        $this->CI->session->set_userdata('users_session', $data_users[0]);
      }
      else
      {
          $cnt_users_email = $this->CI->librarydb->count('users', ['email' => $fb_data['email']] );
          if($cnt_users > 0)
          {
              $data_users_email = $this->CI->librarydb->get_list('users', ['email' => $fb_data['email']] );
              $this->CI->librarydb->update('users', array('fb_id' => $fb_data['id']), ['email' => $fb_data['email']]  );
              $this->CI->session->set_userdata('users_session', $data_users_email[0]);
          }
          else
          {
              $param  = array();
              $param['email']         = $fb_data['email'];
              $param['fb_id']         = $fb_data['id'];
              $param['first_name']    = $fb_data['first_name'];
              $param['last_name']     = $fb_data['last_name'];
              $param['avatar']        = "http://graph.facebook.com/".$fb_data['id']."/picture?width=800&height=500";
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
