<?php

class ModelAnalizerTorg1 extends CI_Model {

    private $CI;
    private $choice;

    public function __construct() {
        parent::__construct();
        $this->CI = & get_instance();
        $this->choice = $this->input->post('choice', true);
    }

    public function start() {
        if (empty($this->choice)) {
            $this->u2prepare();
        } else {
            switch ($this->CI->table->status2) {
                case 'u2':
                    $this->firstU2torg1();
                    break;
                case 'u3':
                    $this->secondU3torg1();
                    break;
                case 'u1':
                    $this->finalU1torg1();
                    break;
                default:
                    $this->jgrowl('IMPOSSIBLE!!!! TORG1 STATUS2 is bad', 'red');
            }
        }
    }

    private function u2prepare() {
        // Если никто не поторговался
        if (empty($this->CI->table->torg_u1) AND empty($this->CI->table->torg_u3) AND empty($this->CI->table->torg_u3)) {
            // Подготовить первого игрока U2 к ходу
            $this->db
                    ->where('id', $this->CI->table->id)
                    ->set('available_choices', '6p,miser,pass')
                    ->set('status2', 'u2')
                    ->update('tables');

            $t = date('c');
            $comment = "TORG1 begin. U2 is going. Table #" . $this->CI->table->id . " at " . $t;
            $this->CI->saveEvent($this->CI->table->id, $this->CI->table->user_id2, $comment);
        } else {
            $this->CI->jgrowl('TORG1 analise bad begin', 'red');
        }
    }

    //////////////////////////////////////
    // пришел торг от первого игрока U2
    //////////////////////////////////////
    private function firstU2torg1() {
        $choices = explode(',', $this->CI->table->available_choices);
        if (!in_array($this->choice, $choices)) {
            $this->CI->jgrowl('IMPOSSIBLE command', 'red');
            return;
        }

        switch ($this->choice) {
            case '6p':
                $c = '6t,miser,pass';
                break;
            case 'miser':
                $c = '9p,pass';
                break;
            case 'pass':
                $c = '6p,miser,pass';
                break;
        }

        $this->db
                ->where('id', $this->CI->table->id)
                ->set('torg_u2', $this->choice)
                ->set('status2', 'u3')
                ->set('available_choices', $c)
                ->update('tables');

        $t = date('c');
        $comment = "TORG1 begin. U3 is going. Table #{$this->CI->table->id} at {$t}";
        $this->CI->saveEvent($this->CI->table->id, $this->CI->table->user_id2, $comment);
    }

    //////////////////////////////////////
    // Пришел торг второго U3
    //////////////////////////////////////
    private function secondU3torg1() {
        $choices = explode(',', $this->CI->table->available_choices);
        if (!in_array($this->choice, $choices)) {
            $this->CI->jgrowl('IMPOSSIBLE command', 'red');
            return;
        }

        switch ($this->choice) {
            case '6t':
                $c = '6b,miser,pass';
                break;
            case '6p':
                $c = '6t,miser,pass';
                break;
            case 'miser':
                $c = '9p,pass';
                break;
            case '9p':
                $c = '9t,pass';
                break;
            case 'pass':

                switch ($this->CI->table->torg_u2) {
                    case '6p':
                        $c = '6t,miser,pass';
                        break;
                    case 'miser':
                        $c = '9p,pass';
                        break;
                    case 'pass':
                        $c = '6p,miser,pass';
                        break;
                }

                break;
        }

        $this->db
                ->where('id', $this->CI->table->id)
                ->set('torg_u3', $this->choice)
                ->set('status2', 'u1')
                ->set('available_choices', $c)
                ->update('tables');

        $t = date('c');
        $comment = "TORG1 begin. U1 is going. Table #{$this->CI->table->id} at {$t}";
        $this->CI->saveEvent($this->CI->table->id, $this->CI->table->user_id2, $comment);
    }

    //////////////////////////////////////
    // Пришел торг последнего U1
    //////////////////////////////////////
    private function finalU1torg1() {
        $choices = explode(',', $this->CI->table->available_choices);
        if (!in_array($this->choice, $choices)) {
            $this->CI->jgrowl('IMPOSSIBLE command', 'red');
            return;
        }

        // Записать выбор третьего
        $this->db
                ->where('id', $this->CI->table->id)
                ->set('torg_u1', $this->choice)
                ->set('status2', '')
                ->set('available_choices', '')
                ->update('tables');
        $this->CI->table->torg_u1 = $this->choice;

        $passCount = $this->getPassCount();
        
        if($passCount == 3){
        $this->db
                ->where('id', $this->CI->table->id)
                ->set('status', 'raspas')
                ->update('tables');
            return;
        }


        $data = [
            'table' => $this->CI->table,
            'passCount' => $this->getPassCount()
        ];

        $ura = $this->load->view('front/app/bullet/viewUra', $data, true);
        $this->CI->mymodal("Торг1 закончен", $ura);

        $this->clear();

        $t = date('c');
        $comment = "TORG1 ended. Table #{$this->CI->table->id} at {$t}";
        $this->CI->saveEvent($this->CI->table->id, $this->CI->table->user_id2, $comment);
    }

    private function clear() {
        $this->db
                ->where('id', $this->CI->table->id)
                ->set('torg_u1', '')
                ->set('torg_u2', '')
                ->set('torg_u3', '')
                ->set('status2', 'u2')
                ->set('available_choices', '')
                ->update('tables');

        // Поправить 
        $this->CI->table = $this->db
                ->where('id', $this->table->id)
                ->get('tables')
                ->row();

        // сдать карты
        $this->CI->load->model('front/app/bullet/razdatka');
        $this->CI->razdatka->first($this->table->id);

        // Провести анализ режима ТОРГ1
        $this->u2prepare();
    }
    
    private function getPassCount(){
        $passCount = 0;
        if($this->CI->table->torg_u2 == 'pass'){
            $passCount++;
        }
        if($this->CI->table->torg_u3 == 'pass'){
            $passCount++;
        }
        if($this->CI->table->torg_u1 == 'pass'){
            $passCount++;
        }
        return $passCount;
    }

}
