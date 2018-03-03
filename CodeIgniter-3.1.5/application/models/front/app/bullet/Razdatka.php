<?php

class Razdatka extends CI_Model {

    public function first($table_id = 0) {
        $cards = [
            'p1', 'p2', 'p3', 'p4', 'p5', 'p6', 'p7', 'p8',
            'b1', 'b2', 'b3', 'b4', 'b5', 'b6', 'b7', 'b8',
            't1', 't2', 't3', 't4', 't5', 't6', 't7', 't8',
            'c1', 'c2', 'c3', 'c4', 'c5', 'c6', 'c7', 'c8'
        ];

        shuffle($cards);

        $owners = [
            'u1', 'u1', 'u2', 'u2', 'u3', 'u3',
            'u1', 'u1', 'u2', 'u2', 'u3', 'u3',
            'u1', 'u1', 'p', 'p', 'u2', 'u2', 'u3', 'u3',
            'u1', 'u1', 'u2', 'u2', 'u3', 'u3',
            'u1', 'u1', 'u2', 'u2', 'u3', 'u3'
        ];

        $this->db
                ->where('id', $table_id);

        foreach ($owners as $x => $owner) {
            $this->db
                    ->set($cards[$x], $owner);
        }

        $this->db
                ->update('tables');
    }

}
