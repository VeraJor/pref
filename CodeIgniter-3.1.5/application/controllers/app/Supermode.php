<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Supermode extends MY_Controller {

    public function _remap($method) {

        if (!$this->input->is_ajax_request())
            die('Bad ajax_request status');
        //////////  ЭТО AJAX !!!  ///////////
        elseif (empty($this->user))
            return $this->showLoginForm();
        /////  ЕСТЬ АВТОРИЗАЦИЯ !!! //////

        // Если супермод неизвестный, пока сообщать
        $supermodes = array('game','finance', 'profile', 'rules');
        if(!in_array($method, $supermodes)){
            $this->mymodal('Unknown supermode', 'Unknown supermode: ' . $method);
            Jquery::getResponse();
            return;
        }
        
        // Запомнить новый супермод в БД
        $this->db
                ->set('supermode', $method)
                ->where('id', $this->user->id)
                ->update('users');
        
        // Перерисовать суперрежим
        Jquery::evalScript('$.php("app/get_super_mode")');
        Jquery::getResponse();
    }

}
