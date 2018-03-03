<?php

class Musers extends CI_Model {

    public function getUsers($ids = array()) {
        $users = array();
        if(!empty($ids)){
            if(is_array($ids)){
                $this->db
                        ->where_in('id', $ids);
            }
        }
        $users0 = $this->db
                ->get('users')
                ->result();
        if(!empty($users0)){
            foreach($users0 as $u){
                $users[$u->id] = $u;
            }
        }
        return $users;
    }

}
