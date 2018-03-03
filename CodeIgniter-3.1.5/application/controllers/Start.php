<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Start extends MY_Controller {

    public function _remap() {

        if (!$this->input->is_ajax_request())
            die('Bad ajax_request status');
        //////////  ЭТО AJAX !!!  ///////////
        elseif (empty($this->user))
            return $this->showLoginForm();
        /////  ЕСТЬ АВТОРИЗАЦИЯ !!! //////

        // Скрыть приветствие
        // Показать приложение
        $js = $this->load->view('front/app/js/viewJsShowApp', FALSE, TRUE);
        Jquery::evalScript($js);
//        $this->jgrowl('System started at' . date('c'));
        Jquery::getResponse();
    }

}
/*
 * 
 * Пика: p1 - p8
 * Трефы: t1 - t8 
 * Бубы: b1 - b8
 * Червы: c1 - c8
 * 
 *  */