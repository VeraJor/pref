<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Get_status extends MY_Controller {

    public function _remap() {

        if (!$this->input->is_ajax_request())
            die('Bad ajax_request status');
        //////////  ЭТО AJAX !!!  ///////////
        elseif (empty($this->user))
            return $this->showLoginForm();
        /////  ЕСТЬ АВТОРИЗАЦИЯ !!! //////

        
        
        if (empty($this->table)) {
            $this->jgrowl('Get_status - STOP - Table lost', 'red');
            
            // сделать запись в журнал событий
            $t = date('c');
            $comment = "Your Table lost. Game canceled at {$t}";
            $this->saveEvent(0, 0, $comment);
            
            Jquery::evalScript('le=-1;$.php("app/game/get_super_mode_game");');
            Jquery::getResponse();
            return;
        }

        if (empty($this->table->user_id1) OR empty($this->table->user_id2) OR empty($this->table->user_id3)) {
            $this->jgrowl('IMPOSSIBLE!!!! User(s) lost', 'red');
//            Jquery::evalScript('$.php("app/game/get_super_mode_game")');
            Jquery::getResponse();
            return;
        }

        switch($this->table->status){
            case 'torg1':
                $this->load->model('front/app/bullet/modelScreenDataTorg1');
                $data = $this->modelScreenDataTorg1->getData();
                $content = $this->load->view('front/app/bullet/viewTable', $data, TRUE);
                break;
            case 'raspas':
                $this->load->model('front/app/bullet/modelScreenDataRaspas');
                $data = $this->modelScreenDataRaspas->getData();
                $content = $this->load->view('front/app/bullet/viewTable', $data, TRUE);
                break;
            default:
                $content = "Unknown BULLET mode";
        }

        Jquery('#app')->html($content);
        Jquery::getResponse();
    }

}
