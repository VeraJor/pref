<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Choice extends MY_Controller {

    public function _remap() {

        if (!$this->input->is_ajax_request())
            die('Bad ajax_request status');
        //////////  ЭТО AJAX !!!  ///////////
        elseif (empty($this->user))
            return $this->showLoginForm();
        /////  ЕСТЬ АВТОРИЗАЦИЯ !!! //////

        switch($this->table->status){
            case 'torg1':
                $this->load->model('front/app/bullet/modelAnalizerTorg1');
                $this->modelAnalizerTorg1->start();
                break;
            case 'raspas':
                $this->load->model('front/app/bullet/modelAnalizerRaspas');
                $this->modelAnalizerRaspas->start();
                break;
        }
        Jquery::getResponse();
    }

}
