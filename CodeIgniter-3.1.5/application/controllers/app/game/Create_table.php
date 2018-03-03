<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Create_table extends MY_Controller {

    public function _remap() {

        if (!$this->input->is_ajax_request())
            die('Bad ajax_request status');
        //////////  ЭТО AJAX !!!  ///////////
        elseif (empty($this->user))
            return $this->showLoginForm();
        /////  ЕСТЬ АВТОРИЗАЦИЯ !!! //////

        $user_id = $this->user->id;
        
        $table = $this->db
                ->select('id')
                ->where('user_id1', $user_id)
                ->or_where('user_id2', $user_id)
                ->or_where('user_id3', $user_id)
                ->get('tables')
                ->row();
        // Если юзверь ИД есть в любой записи Игрового стола,
        // а конкретно - в любом из полей user_id1, 2 или 3
        // тогда перерисовать суперрежим нахер!
        if (!empty($table)) {
            Jquery::evalScript('$.php("app/get_super_mode")');
            Jquery::getResponse();
            return;
        }
        
        
        // без данных - рисовать форму
        if (empty($_POST)) {
            $form = $this->load->view('front/app/game/viewCreateTableForm', FALSE, TRUE);
            $this->mymodal('Create your table', $form);
            Jquery::getResponse();
            return;
        }

        // Проверить данные из формы логинизации
        $this->load->library('form_validation');
        $config = array(
            array(
                'field' => 'bullet',
                'label' => 'BULLET',
                'rules' => 'required|is_natural'
            ),
            array(
                'field' => 'vist',
                'label' => 'VIST',
                'rules' => 'required|is_natural'
            ),
            array(
                'field' => 'lifetime',
                'label' => 'LIFETIME',
                'rules' => 'required|is_natural'
            )            
        );

        $this->form_validation->set_rules($config);
        if ($this->form_validation->run() === FALSE) {

            // Вопрос: есть ошибка bullet?
            $error = form_error('bullet');
            if (empty($error)) {
                Jquery("#cBulletError")
                        ->hide();
            } else {
                Jquery("#cBulletError")
                        ->html($error)
                        ->show();
            }

            // Вопрос: есть ошибка vist?
            $error = form_error('vist');
            if (empty($error)) {
                Jquery("#cVistError")
                        ->hide();
            } else {
                Jquery("#cVistError")
                        ->html($error)
                        ->show();
            }

            // Вопрос: есть ошибка времени жизни в секундах?
            $error = form_error('lifetime');
            if (empty($error)) {
                Jquery("#cLifetimeError")
                        ->hide();
            } else {
                Jquery("#cLifetimeError")
                        ->html($error)
                        ->show();
            }

            Jquery::getResponse();
            return;
        }

        // Ошибок нет, создаем стол
        $time_create = time();
        $lifetime = set_value('lifetime');
        $time_die = $time_create + $lifetime;
        $data = array(
            'bullet' => set_value('bullet'),
            'vist' => set_value('vist'),
            'time_create' => $time_create,
            'time_die' => $time_die,
            'user_id1' => $this->user->id
        );
        $this->db
                ->set($data)
                ->insert('tables');
        
        // сделать запись в журнал событий
        $table_id = $this->db->insert_id();
        $nickname = $this->user->nickname;
        $t = date('c');
        $comment = "User {$nickname} create Table #{$table_id} at {$t}";
        $this->saveEvent($table_id, $this->user->id, $comment);
        
        // Перерисовать суперрежим
        Jquery('#myModal')
                ->modal('hide');
        Jquery::evalScript('$.php("app/get_super_mode")');
        $str ='TABLE #' . $table_id . ' successfully created';
        $this->jgrowl($str, 'blue');
        Jquery::getResponse();
    }

}
