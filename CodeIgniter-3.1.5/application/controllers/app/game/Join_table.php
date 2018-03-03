<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Join_table extends MY_Controller {

    public function _remap($method = 0) {

        if (!$this->input->is_ajax_request())
            die('Bad ajax_request status');
        //////////  ЭТО AJAX !!!  ///////////
        elseif (empty($this->user))
            return $this->showLoginForm();
        /////  ЕСТЬ АВТОРИЗАЦИЯ !!! //////
        //
        // Добавиться к офферте получится, только если
        // тебя нет ни в одном из трех полей user_id TABLES
        //
        if (!empty($this->table)) {
            if ($this->table->status == 'wait') {
                // Ты уже за столом и ждешь других игроков
                Jquery::evalScript('$.php("app/game/get_super_mode_game")');
                Jquery::getResponse();
                return;
            } else {
                // Ты уже в игре
                Jquery::evalScript('$.php("app/bullet/get_status")');
                Jquery::getResponse();
                return;
            }
        }

        //
        // Искать указанный стол
        $table = $this->db
                ->select('id,user_id2,user_id3,status')
                ->where('id', $method)
                ->get('tables')
                ->row();
        if (empty($table)) {
            // Хм, перерисовать стол
            Jquery::evalScript('$.php("app/game/get_super_mode_game")');
            Jquery::getResponse();
            return;
        }
        if ($table->status != 'wait') {
            // Хм, ты уже в игре
            Jquery::evalScript('$.php("app/bullet/get_status")');
            Jquery::getResponse();
            return;
        }


        // Присоединиться к офферте вторым номером
        if (empty($table->user_id2)) {
            $this->db
                    ->where('id', $table->id)
                    ->set('user_id2', $this->user->id)
                    ->update('tables');

            // сделать запись в журнал событий
            $table_id = $table->id;
            $nickname = $this->user->nickname;
            $t = date('c');
            $comment = "User 2 {$nickname} join Table #{$table_id} at {$t}";
            $this->saveEvent($table_id, $this->user->id, $comment);

            Jquery::evalScript('$.php("app/game/get_super_mode_game")');
            Jquery::getResponse();
            return;
        }


        // Присоединиться к офферте третьим номером
        if (empty($table->user_id3)) {
            $this->db
                    ->where('id', $table->id)
                    ->set('user_id3', $this->user->id)
                    ->update('tables');
            // Поправить 
            $this->table = $this->db
                    ->where('id', $method)
                    ->get('tables')
                    ->row();

            // сдать карты
            $this->load->model('front/app/bullet/razdatka');
            $message = $this->razdatka->first($table->id);

            // Сменить статус
            $this->db
                    ->where('id', $table->id)
                    ->set('status', 'torg1')
                    ->set('status2', 'u2')
                    ->update('tables');

            // Провести анализ режима ТОРГ1
            $this->load->model('front/app/bullet/modelAnalizerTorg1');
            $this->modelTorg1Analizer->start();



            // сделать запись в журнал событий
            /*
              $table_id = $table->id;
              $nickname = $this->user->nickname;
              $t = date('c');
              $comment = "User 3 {$nickname} join Table #{$table_id} at {$t}. Game STARTED";
              $this->saveEvent($table_id, $this->user->id, $comment);
             */
            // Перерисовать рендером пули
            Jquery::evalScript('$.php("app/bullet/get_status")');
            Jquery::getResponse();
            return;
        }

        Jquery::evalScript('$.php("app/game/get_super_mode_game")');
        Jquery::getResponse();
    }

}
