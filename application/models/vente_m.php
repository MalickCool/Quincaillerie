<?php
/**
 * Created by PhpStorm.
 * User: GLORIA TECHNOLOGY
 * Date: 09/07/2019
 * Time: 15:32
 */
if (! defined('BASEPATH')) exit("no direct script access allowed");
class vente_m extends MY_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function get_db_table(){
        return 'ventes';
    }

    public function get_db_table_id(){
        return 'idvente';
    }

    public function get_db_table_date(){
        return 'datevente';
    }

    function add_item($post_data) {
        $this->db->insert('ventes',$post_data);
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

	function getDataByPeriode2($begin, $end, $client) {
		$realDateBegin = date('Y-m-d', strtotime($begin));
		$realDateEnd = date('Y-m-d', strtotime($end));
		$this->db->select('*');
		$this->db->from('ventes');
		$this->db->where('datevente >=', $realDateBegin);
		$this->db->where('datevente <=', $realDateEnd);
		if(!is_null($client))
			$this->db->where('client_id', $client);
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
