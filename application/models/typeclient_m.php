<?php
/**
 * Created by PhpStorm.
 * User: GLORIA TECHNOLOGY
 * Date: 09/07/2019
 * Time: 15:32
 */
if (! defined('BASEPATH')) exit("no direct script access allowed");
class typecommercial_m extends MY_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function get_db_table(){
        return 'typecommercial';
    }

    public function get_db_table_id(){
        return 'idType';
    }

    function add_item($post_data) {
        $this->db->insert('typecommercial',$post_data);
        return $this->db->insert_id();
    }

    function getActivated() {
        $this->db->select('*');
        $this->db->from($this->get_db_table());
        $this->db->where('etat = 0');
        $this->db->order_by($this->get_db_table_id(),'DESC');
        $query = $this->db->get();
        return $query->result();
    }

    public function exist($token){
        $this->db->select('*');
        $this->db->from($this->get_db_table());
        $this->db->where("token", $token);
        $query = $this->db->get();
        $result = $query->result();
        $rep = false;
        if(!empty($result)){
            $rep = true;
        }
        return $rep;
    }
}
