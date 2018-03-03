<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Get_super_mode_game extends MY_Controller {

    public function _remap() {

        if (!$this->input->is_ajax_request())
            die('Bad ajax_request status');
        //////////  ЭТО AJAX !!!  ///////////
        elseif (empty($this->user))
            return $this->showLoginForm();
        /////  ЕСТЬ АВТОРИЗАЦИЯ !!! //////
        ////////////////////////////////
        // если ты свободен
        if (empty($this->table)) {
            $content = $this->getOffertasListContent();
            Jquery('#app')->html($content);
            Jquery::getResponse();
            return;
        }

        // если ты в игре
        if ($this->table->status != 'wait') {
            Jquery::evalScript('$.php("app/bullet/get_status")');
            Jquery::getResponse();
            return;
        }

        // если ты присоедился и ждешь второго/ третьего
        if (empty($this->table->user_id2) OR empty($this->table->user_id3)) {
            $content = $this->getOffertaContent();
            Jquery('#app')->html($content);
            Jquery::getResponse();
            return;
        }

        $this->jgrowl('Get_super_mode_game - STOP - UNKNOWN CASE', 'red');
        Jquery::getResponse();
        return;
    }

    private function getOffertasListContent() {
        // Сделать топменю
        $data = array(
            'sm' => 'game',
            'nickname' => $this->user->nickname
        );
        $navbar = $this->load->view('front/app/navbar/viewNavbar', $data, TRUE);

        // собрать тело
        $offertas = $this->db
                ->where('status', 'wait')
                ->get('tables')
                ->result();
        $this->load->model('front/app/musers');
        $users = $this->musers->getUsers();
        $le = $this->getLastEvent();
        if (is_null($le)) {
            $le = 0;
        }
        $data = array(
            'now' => time(),
            'offertas' => $offertas,
            'users' => $users,
            'le' => $le
        );
        $body = $this->load->view('front/app/game/viewOffertas', $data, TRUE);

        // отдать
        return $navbar . $body;
    }

    private function getOffertaContent() {
        $this->load->model('front/app/musers');
        $users = $this->musers->getUsers();
        $data = array(
            'now' => time(),
            'offerta' => $this->table,
            'users' => $users,
            'le' => $this->getLastEvent()
        );
        $content = $this->load->view('front/app/game/viewOffertaDesktop', $data, TRUE);
        return $content;
    }

}
