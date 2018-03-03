<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Get_super_mode extends MY_Controller {

    public function _remap() {

        if (!$this->input->is_ajax_request())
            die('Bad ajax_request status');
        //////////  ЭТО AJAX !!!  ///////////
        elseif (empty($this->user))
            return $this->showLoginForm();
        /////  ЕСТЬ АВТОРИЗАЦИЯ !!! //////

        // Если супермод неизвестный,
        // Принудительно отправить на ПРАВИЛА
        $supermode = $this->user->supermode;
        $supermodes = array('game', 'finance', 'profile', 'rules');
        if (!in_array($supermode, $supermodes)) {
            $supermode = 'rules';
            $this->user->supermode = $supermode;
            $this->db
                    ->set('supermode', $supermode)
                    ->where('id', $this->user->id)
                    ->update('users');
        }

        // Перерисовать суперрежим
        $str = "$.php('app/{$supermode}/get_super_mode_{$supermode}')";
        Jquery::evalScript($str);
        Jquery::getResponse();
    }

}
