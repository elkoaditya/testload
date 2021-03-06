<?php

class MY_Public extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
        
        if($this->config->item('site_open') === FALSE)
        {
            show_error('Sorry the site is shut for now.');
        }


        // If the user is using a mobile, use a mobile theme
        $this->load->library('user_agent');
        if( $this->agent->is_mobile() )
        {
            $this->template->set_theme('mobile');
        }
    }
}
