<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Tick extends MY_Controller {

    public function _remap($method = 0) {

        if (!$this->input->is_ajax_request())
            die('Bad ajax_request status');
        //////////  ЭТО AJAX !!!  ///////////
        elseif (empty($this->user))
            return $this->showLoginForm();
        /////  ЕСТЬ АВТОРИЗАЦИЯ !!! //////

        $le = $this->getLastEvent();

        // новых событий нету
        
        if (is_null($le) OR $le != $method) {
            // ЕСТЬ новое событие
            if (empty($table) OR $table->status == 'wait') {
                $script = '$.php("app/game/get_super_mode_game");';
            }else{
                $script = '$.php("app/bullet/get_status");';
            }
        } else {
            // нового события нет
            $script = 'now=' . time() . ';';
            if (empty($this->table) OR $this->table->status == 'wait') {
                $script .= 'PBcorrector();';
            }
            $script .= 'tick();';
        }
        Jquery::evalScript($script);
        Jquery::getResponse();
    }

}
