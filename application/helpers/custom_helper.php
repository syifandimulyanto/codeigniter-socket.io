<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	function app_url($path = false)
	{
	    $CI = &get_instance();
	    $url = $CI->config->item('app_url') . $path;
	    return $url;
	}

	function app_asset_url($uri)
    {
        $CI = &get_instance();
        return $CI->config->item('app_asset_url') . $uri;
    }

    function app_asset_js($uri)
    {
        return '<script type="text/javascript" src="' . app_asset_url($uri) . '"></script>';
    }

    function app_asset_css($uri)
    {
        return '<link href="' . app_asset_url($uri) . '" type="text/css" rel="stylesheet" />';
    }

    function is_login()
    {
        $CI =& get_instance();
        if( !$CI->session->userdata('users_session') )
        {
            redirect(app_url());
        }
    }

    function get_users($key = TRUE)
    {
        $response = FALSE;
        $CI    =& get_instance();
        $data  = $CI->session->userdata('users_session');

        if(isset($data->$key))
            $response = $data->$key;
        return $response;
    }