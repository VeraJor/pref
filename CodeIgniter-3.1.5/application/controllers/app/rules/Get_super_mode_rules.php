<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Get_super_mode_rules extends MY_Controller {

    public function _remap() {

        if (!$this->input->is_ajax_request())
            die('Bad ajax_request status');
        //////////  ЭТО AJAX !!!  ///////////
        elseif (empty($this->user))
            return $this->showLoginForm();
        /////  ЕСТЬ АВТОРИЗАЦИЯ !!! //////

        // Сделать топменю
        $data = array(
            'sm' => 'rules',
            'nickname' => $this->user->nickname
        );
        $navbar = $this->load->view('front/app/navbar/viewNavbar', $data, TRUE);

        // наполнение суперрежима
//        $content = $this->user->supermode;
        $content = $this->load->view('front/app/rules/viewXXX', FALSE, TRUE);
        Jquery('#app')->html($navbar . $content);
        Jquery::getResponse();
    }

}
