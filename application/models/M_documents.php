<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_documents extends MY_Model
{

    function __construct()
    {
        parent::__construct();
        parent::table('documents', 'id');
    }

    private $table = 'documents';
    private $id = 'id';

    public function fetch($data, $count = false, $compiled = false)
    {
        return $this->new_fetch_db($data, $count, $compiled);
    }

    public function get()
    {
        $query = $this->db->get($this->table);
        return $query->result();
    }
    public function getWhere($data)
    {
        $this->db->order_by('date_created', 'DESC');
        $query = $this->db->where($data)->get($this->table);
        return $query->result();
    }

    public function get_total()
    {
        return $this->db->count_all($this->table);
    }

    public function add($data)
    {
        $this->db->insert($this->table, $data);
        return ($this->db->affected_rows() != 1) ? false : true;
    }

    public function update($id, $data)
    {
        //run Query to update data
        if (isset($data[$this->id])) unset($data[$this->id]);
        $query = $this->db->where('id', $id)->update(
            $this->table,
            $data
        );
        return ($this->db->affected_rows() != 1) ? false : true;
    }

    public function delete($data)
    {

        $this->db->delete($this->table, $data);
        return ($this->db->affected_rows() != 1) ? false : true;
    }


    public function last()
    {
        return $this->db->count_all($this->table);;
    }
}
