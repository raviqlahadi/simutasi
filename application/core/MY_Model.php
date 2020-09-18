<?php

defined('BASEPATH') or exit('No direct script access allowed');

class MY_Model extends CI_Model
{

    private $table;
    private $id;
    public function __construct()
    {
    }

    public function table($table, $id)
    {
        $this->table = $table;
        $this->id = $id;
    }

    

    public function fetch_db($data, $count = false, $compiled = false)
    {

        $start = (isset($data['start'])) ? $data['start'] : null;
        $limit = (isset($data['limit'])) ? $data['limit'] : null;
        
        if ($count) {
            $start = null;
            $limit = null;
        }

        
        $select = (isset($data['select'])) ? $data['select'] : null;
        $select_join = (isset($data['select_join'])) ? $data['select_join'] : null;
        $join = (isset($data['join'])) ? $data['join'] : null;
        
        if ($select == null || !is_array($select)) {
            $this->db->select('*');
        } else {
            foreach ($select as $s) {
                if ($join != null) {
                    $this->db->select($this->table . '.' . $s);
                } else {
                    $this->db->select($s);
                }
            }
            if ($select_join != null) {
                foreach ($select_join as $sj) {
                    $this->db->select($sj);
                }
            }
        }

        $this->db->distinct();

        $this->db->from($this->table);

        
        if ($join != null && is_array($join)) {
            foreach ($join as $j) {

                if (isset($j['previx']) && $j['previx'] != null) {
                    $on = (isset($j['reverse']) && $j['reverse'])
                        ? $this->table . '.' . $this->id . '=' . $j['previx'] . '.' . $j['fk']
                        : $this->table . '.' . $j['fk'] . '=' . $j['previx'] . '.' . $this->id;
                    $this->db->join(
                        $j['table'],
                        $on,
                        $j['join']
                    );
                } else {
                    $on = (isset($j['reverse']) && $j['reverse'])
                        ? $this->table . '.' . $this->id . '=' . $j['table'] . '.' . $j['fk']
                        : $this->table . '.' . $j['fk'] . '=' . $j['table'] . '.' . $this->id;
                    $this->db->join(
                        $j['table'],
                        $this->table . '.' . $j['fk'] . '=' . $j['table'] . '.' . $this->id,
                        $j['join']
                    );
                }
            }
        }

        $where = (isset($data['where'])) ? $data['where'] : null;
        if ($where != null && is_array($where)) {
            $this->db->where($where);
        }

        $like = (isset($data['like'])) ? $data['like'] : null;

        if ($like != null && is_array($like)) {
            $this->db->group_start();
            $i = 0;
            foreach ($like['name'] as $l) {
                if ($i == 0) {
                    $this->db->like($l, $like['key']);
                } else {
                    $this->db->or_like($l, $like['key']);
                }
                $i++;
            }
            $this->db->group_end();
        }

        $group = (isset($data['group'])) ? $data['group'] : null;
        if ($group != null && is_array($group)) {

            $this->db->group_by($group['field']);
        }

        $order = (isset($data['order'])) ? $data['order'] : null;
        if ($order != null && is_array($order)) {
            $this->db->order_by($order['field'], $order['type']);
        }



        if ($limit != null) {
            $this->db->limit($limit, $start);
        }

        if (!$compiled) {
            $query = ($count) ? $this->db->count_all_results() : $this->db->get()->result();
        } else {
            $query = $this->db->get_compiled_select();
        }

        return $query;
    }

    public function new_fetch_db($data, $count = false, $compiled = false)
    {

        $start = (isset($data['start'])) ? $data['start'] : null;
        $limit = (isset($data['limit'])) ? $data['limit'] : null;

        if ($count) {
            $start = null;
            $limit = null;
        }


        $select = (isset($data['select'])) ? $data['select'] : null;
    
        $select_join = (isset($data['select_join'])) ? $data['select_join'] : null;
        $join = (isset($data['join'])) ? $data['join'] : null;

        if ($select == null || !is_array($select)) {
            $this->db->select('*');
        } else {
            foreach ($select as $s) {
                if ($join != null) {
                    $this->db->select($this->table . '.' . $s);
                } else {
                    $this->db->select($s);
                }
            }
            if ($select_join != null) {
                foreach ($select_join as $sj) {
                    $this->db->select($sj);
                }
            }
        }

        $this->db->distinct();

        $this->db->from($this->table);


        if ($join != null && is_array($join)) {
            foreach ($join as $j) {
                $this->db->join(
                    $j['table'],
                    $j['on'],
                    $j['join']
                );
            }
        }

        $where = (isset($data['where'])) ? $data['where'] : null;
        if ($where != null) {
            foreach ($where as $key => $value) {
                $this->db->where($value);
            }
            
        }

        $like = (isset($data['like'])) ? $data['like'] : null;

        if ($like != null && is_array($like)) {
            $this->db->group_start();
            $i = 0;
            foreach ($like['name'] as $l) {
                if ($i == 0) {
                    $this->db->like($l, $like['key']);
                } else {
                    $this->db->or_like($l, $like['key']);
                }
                $i++;
            }
            $this->db->group_end();
        }

        $group = (isset($data['group'])) ? $data['group'] : null;
        if ($group != null && is_array($group)) {

            $this->db->group_by($group['field']);
        }

        $order = (isset($data['order'])) ? $data['order'] : null;
        if ($order != null && is_array($order)) {
            $this->db->order_by($order['field'], $order['type']);
        }



        if ($limit != null) {
            $this->db->limit($limit, $start);
        }

        if (!$compiled) {
            $query = ($count) ? $this->db->count_all_results() : $this->db->get()->result();
        } else {
            $query = $this->db->get_compiled_select();
        }

        return $query;
    }
}
