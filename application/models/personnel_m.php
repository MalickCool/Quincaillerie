<?php
/**
 * Created by PhpStorm.
 * User: GLORIA TECHNOLOGY
 * Date: 09/07/2019
 * Time: 15:32
 */
if (! defined('BASEPATH')) exit("no direct script access allowed");
class personnel_m extends MY_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function get_db_table(){
        return 'personnel';
    }

    public function get_db_table_id(){
        return 'idpersonnel';
    }

    function add_item($post_data) {
        $this->db->insert('personnel',$post_data);
        return $this->db->insert_id();
    }

    function getAllForPrint($id) {
        $this->db->select('*');
        $this->db->from($this->get_db_table());
        $this->db->where("magasin_id", $id);
        $query = $this->db->get();
        return $query->result();
    }

    function getActivated() {
        $this->db->select('*');
        $this->db->from($this->get_db_table());
        $this->db->where('etat = 0');
        $this->db->order_by($this->get_db_table_id(),'ASC');
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
