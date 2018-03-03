<?php

class ModelScreenDataTorg1 extends CI_Model { // Model TORG1

    const PATTERN = '/^[p|t|b|c][1-8]$/';
    const OWNERS = ['u1', 'u2', 'u3', 'p'];
    const SIDES = ['i', 'left', 'right'];

    private $CI;
    public $uIds; // ID по порядку набора в игру, с ключами u1,u2,u3
    public $sideIds; // ID по стороне с ключами i,left,right
    public $users; // 3 записи с ID= user_id1
    public $cards; // Карты игрового стола, сгруппированные в u1,u2,u3,p,

    public function __construct() {
        parent::__construct();
        $this->CI = & get_instance();
    }

    public function getData() {
        $this->prepare();
        return [
            'iInfo' => (object) [
                'nickname' => $this->getUserNickname('i'),
                'status' => $this->getUserStatus('i'),
                'torg' => $this->getTorg('i')
            ],
            'iCommands' => $this->getCommands(),
            'iCards' => $this->getCards(),
            'leftInfo' => (object) [
                'nickname' => $this->getUserNickname('left'),
                'status' => $this->getUserStatus('left'),
                'torg' => $this->getTorg('left')
            ],
            'leftCardsCount' => $this->getCardsCount('left'),
            'rightInfo' => (object) [
                'nickname' => $this->getUserNickname('right'),
                'status' => $this->getUserStatus('right'),
                'torg' => $this->getTorg('right')
            ],
            'rightCardsCount' => $this->getCardsCount('right'),
            'le' => $this->CI->getLastEvent()
        ];
    }

    private function getUserNickname($side = '') {
        if (!in_array($side, self::SIDES)) {
            return '#####';
        }
        $id = $this->sideIds[$side];
        $nickname = $this->users[$id]->nickname;
        return $nickname;
    }

    private function getUserStatus($side = '') {
        $id = $this->sideIds[$side];
        $ux = array_flip($this->uIds);
        $u = $ux[$id];
        if ($this->CI->table->status2 == $u) {
            return 'ХОД';
        } else {
            return '';
        }
    }

    private function getCommands($side = '') {
        $status2 = $this->CI->table->status2;
        $id = $this->sideIds['i'];
        $ux = array_flip($this->uIds);
        $u = $ux[$id];
        if ($status2 == $u) {
            $result = explode(',', $this->CI->table->available_choices);
        } else {
            $result = [];
        }
        return $result;
    }

    private function getCards() {
        $id = $this->sideIds['i'];
        $ux = array_flip($this->uIds);
        $u = $ux[$id];
        return $this->cards[$u];
    }

    private function getCardsCount($side = '') {
        $id = $this->sideIds[$side];
        $ux = array_flip($this->uIds);
        $u = $ux[$id];
        return count($this->cards[$u]);
    }

    private function getTorg($side = '') {
        $id = $this->sideIds[$side];
        $ux = array_flip($this->uIds);
        $u = $ux[$id];
        $torgU = 'torg_' . $u;
        $torg = $this->CI->table->$torgU;
        if (empty($torg)) {
            $torg = '---';
        }
        return $torg;
    }

    private function prepare() {

        // ID игроков по очереди набора в игру
        $uIds = [
            'u1' => $this->CI->table->user_id1,
            'u2' => $this->CI->table->user_id2,
            'u3' => $this->CI->table->user_id3,
        ];
        $this->uIds = $uIds;

        // ID игроков по стороне
        // Если я u1
        if ($this->CI->user->id == $uIds['u1']) {
            $sideIds = [
                'i' => $uIds['u1'],
                'left' => $uIds['u2'],
                'right' => $uIds['u3']
            ];
        } elseif ($this->CI->user->id == $uIds['u2']) {
            $sideIds = [
                'i' => $uIds['u2'],
                'left' => $uIds['u3'],
                'right' => $uIds['u1']
            ];
        } elseif ($this->CI->user->id == $uIds['u3']) {
            $sideIds = [
                'i' => $uIds['u3'],
                'left' => $uIds['u1'],
                'right' => $uIds['u2']
            ];
        } else {
            $sideIds = [
                'i' => 0,
                'left' => 0,
                'right' => 0
            ];
        }
        $this->sideIds = $sideIds;

        // игроки
        $users0 = $this->db
                ->select('id,nickname')
                ->where_in('id', $uIds)
                ->get('users')
                ->result();
        $users = [];
        foreach ($users0 as $u) {
            $users[$u->id] = $u;
        }
        $this->users = $users;

        // карты
        $cards = [];
        foreach ($this->CI->table as $card => $owner) {
            if (!empty(preg_match(self::PATTERN, $card))) {
                if (in_array($owner, self::OWNERS)) {
                    $cards[$owner][] = $card;
                }
            }
        }
        $this->cards = $cards;
    }

}
