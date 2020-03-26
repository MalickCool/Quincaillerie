<?php
/**
 * Created by PhpStorm.
 * User: GLORIA TECHNOLOGY
 * Date: 09/07/2019
 * Time: 15:32
 */
if (! defined('BASEPATH')) exit("no direct script access allowed");
class detailinventaire_m extends MY_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function get_db_table(){
        return 'detailinventaire';
    }

    public function get_db_table_id(){
        return 'iddetail';
    }

    function add_item($post_data) {
        $this->db->insert('detailinventaire',$post_data);
        return $this->db->insert_id();
    }

    public function getAllByInventaireId($id){
        $this->db->select('dtl.*, itr.designation');
        $this->db->from('detailinventaire dtl, intrant itr');
        $this->db->where('dtl.idproduit = itr.idintrant');
        $this->db->where('idinventaire', $id);
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