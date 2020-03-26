<?php
/**
 * Created by PhpStorm.
 * User: GLORIA TECHNOLOGY
 * Date: 09/07/2019
 * Time: 15:32
 */
if (! defined('BASEPATH')) exit("no direct script access allowed");
class boncommande_m extends MY_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function get_db_table(){
        return 'boncommande';
    }

    public function get_db_table_id(){
        return 'idfacture';
    }

    function add_item($post_data) {
        $this->db->insert('boncommande',$post_data);
        return $this->db->insert_id();
    }

	function getDataByPeriode($begin, $end) {
		$realDateBegin = date('Y-m-d', strtotime($begin));
		$realDateEnd = date('Y-m-d', strtotime($end));
		$this->db->select('*');
		$this->db->from('boncommande');
		$this->db->where('datebon >=', $realDateBegin);
		$this->db->where('datebon <=', $realDateEnd);

		$query = $this->db->get();
		return $query->result();
	}

	function getDataByPeriode2($begin, $end, $fournisseur) {
		$realDateBegin = date('Y-m-d', strtotime($begin));
		$realDateEnd = date('Y-m-d', strtotime($end));
		$this->db->select('*');
		$this->db->from('boncommande');
		$this->db->where('datebon >=', $realDateBegin);
		$this->db->where('datebon <=', $realDateEnd);
		if(!is_null($fournisseur))
			$this->db->where('idfournisseur', $fournisseur);
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
