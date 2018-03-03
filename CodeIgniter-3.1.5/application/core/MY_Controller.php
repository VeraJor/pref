<?php

class MY_Controller extends CI_Controller {

    // данные игрока
    public $user = null;
    // данные игрового стола
    public $table = null;

    public function __construct() {
        parent::__construct();
        // найти данные игрока и его стола
        $this->setUserAndTable();
        // убить просроченные офферты
        $this->offertaKiller();
    }

    private function setUserAndTable() {
        // искать игрока
        $sess = $this->db
                ->select('user_id')
                ->where('id', session_id())
                ->get('ci_sessions')
                ->row();
        if (!empty($sess)) {
            $user_id = $sess->user_id;
            if (!empty($user_id)) {
                $this->user = $this->db
                        ->where('id', $user_id)
                        ->get('users')
                        ->row();
                if (!empty($this->user)) {
                    // игрок есть, искать его игровой стол
                    $this->table = $this->db
                            ->where('user_id1', $user_id)
                            ->or_where('user_id2', $user_id)
                            ->or_where('user_id3', $user_id)
                            ->get('tables')
                            ->row();
                }
            }
        }
    }

    private function offertaKiller() {
        // получить список просроченных офферт
        $t = time();
        $offertasToDie = $this->db
                ->select('id')
                ->where('time_die <=', $t)
                ->where('status', 'wait')
                ->get('tables')
                ->result();
        // если такие есть, то
        if (!empty($offertasToDie)) {
            // удалить их из таблицы
            $this->db
                    ->where('time_die <=', $t)
                    ->where('status', 'wait')
                    ->delete('tables');
            // сообщить о каждой удаленной офферте
            $d = date('c');
            foreach ($offertasToDie as $o) {
                $comment = "Table #{$o->id} is closed by timeout at {$d}";
                $this->saveEvent($o->id, 0, $comment);
            }
        }
    }

    public function saveEvent($table_id = 0, $user_id = 0, $comment = '###') {
        $this->db
                ->set('table_id', $table_id)
                ->set('user_id', $user_id)
                ->set('comment', $comment)
                ->insert('events');
    }

    public function getLastEvent() {
        
        if (!empty($this->table)) {
            $this->db
                    ->where('table_id', $this->table->id);
        }
        $event = $this->db
                ->select_max('id')
                ->get('events')
                ->row();
        if (empty($event)) {
            return 0;
        }
        
        return $event->id;
    }

    public function mymodal($header = 'Сообщение', $body = 'Текст сообщения') {
        Jquery('#myModalLabel')
                ->text($header);
        Jquery('.modal-body')
                ->html($body);
        Jquery('#myModal')
                ->modal('show');
    }

    public function jgrowl($text = 'Message not set!', $theme = 'white') {
        // для непонятных тем выставить тему warning
        $themes = array('white', 'blue', 'green', 'celeste', 'orange', 'red', 'black', 'yellow');
        if (!in_array($theme, $themes)) {
            $theme = 'white';
        }
        // яваскрипт не понимает эти коды
        $text = str_replace(array("\r\n", "\n", "\t"), '', $text);
        $data = array(
            'text' => $text,
            'options' => array(
                'theme' => $theme
            )
        );
        $js = $this->load->view('front/app/js/viewJgrowl', $data, TRUE);
        Jquery::evalScript($js);
    }
    
    public function showLoginForm(){
        Jquery::evalScript('$.php("login")');
        Jquery::getResponse();
    }

}
