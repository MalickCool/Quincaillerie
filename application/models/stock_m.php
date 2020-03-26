<?php
/**
 * Created by PhpStorm.
 * User: GLORIA TECHNOLOGY
 * Date: 09/07/2019
 * Time: 15:32
 */
if (! defined('BASEPATH')) exit("no direct script access allowed");
class stock_m extends MY_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function get_db_table(){
        return 'stock';
    }

    public function get_db_table_id(){
        return 'idstock';
    }

    function add_item($post_data) {
        $this->db->insert('stock',$post_data);
        return $this->db->insert_id();
    }

    public function checkIfHasStock($id){
        $this->db->select('*');
        $this->db->from($this->get_db_table());
        $this->db->where("idproduit", $id);
        $query = $this->db->get();
        $result = $query->result();
        $rep = false;
        if(!empty($result)){
            $rep = true;
        }
        return $rep;
    }

    public function getStockByProductId($id){
        $this->db->select('*');
        $this->db->from('stock');
        $this->db->where('idproduit', $id);
        $query = $this->db->get();
        return $query->result();
    }

    public function getAllProductsWithDetails(){
        $this->db->select('stk.*, int.designation, int.seuil');
        $this->db->from('stock stk, intrant int');
        $this->db->where('stk.idproduit = int.idintrant');
        $query = $this->db->get();
        return $query->result();
    }

    public function getAllProducts(){
        $this->db->select('*');
        $this->db->from('stock');
        $this->db->where('qte > 0');
        $query = $this->db->get();
        return $query->result();
    }

    public function getAllProductsByDate($debut, $fin){
        $this->db->select('*');
        $this->db->from('stock');
        $this->db->where('qte > 0');
        $this->db->where('dateachat >=', date('Y-m-d', strtotime($debut)));
        $this->db->where('dateachat <=', date('Y-m-d', strtotime($fin)));
        $query = $this->db->get();
        return $query->result();
    }

    public function getStock(){
        $this->db->select('*');
        $this->db->from('stock');
        $this->db->where('qte > 0');
        $query = $this->db->get();
        return $query->result();
    }

    public function getProductsWithDetails($id){
        $this->db->select_sum('qte');
        $this->db->from('stock');
        $this->db->where('idproduit', $id);
        $query = $this->db->get();
        $result = $query->result();
        return $result[0]->qte;
    }

    public function getProductsWithDetails2($id){
        $this->db->select('qte, prixachat');
        $this->db->from('stock');
        $this->db->where('idproduit', $id);
        $query = $this->db->get();
        return $query->result();
    }

    function getDistinctProduct() {
        $this->db->select('DISTINCT(idproduit)');
        $this->db->from($this->get_db_table());
        $this->db->order_by($this->get_db_table_id(),'DESC');
        $query = $this->db->get();
        return $query->result();
    }

    function getProductByWarehouse($idWarehouse) {
        $this->db->select('DISTINCT(idproduit)');
        $this->db->from($this->get_db_table());
        $this->db->where('identrepot', $idWarehouse);
        $this->db->order_by($this->get_db_table_id(),'DESC');
        $query = $this->db->get();
        return $query->result();
    }

    public function getProductsByEntrepotWithDetails($id, $identrepot){
        $this->db->select_sum('qte');
        $this->db->from('stock');
        $this->db->where('idproduit', $id);
        $this->db->where('identrepot', $identrepot);
        $query = $this->db->get();
        $result = $query->result();
        return $result[0]->qte;
    }

    public function getProductsLineByEntrepotWithDetails($id, $identrepot){
        $this->db->select('*');
        $this->db->from('stock');
        $this->db->where('idproduit', $id);
        $this->db->where('identrepot', $identrepot);
        $query = $this->db->get();
        return $query->result();
    }

    public function getProductsLineWithDetails($id){
        $this->db->select('*');
        $this->db->from('stock');
        $this->db->where('idproduit', $id);
        $query = $this->db->get();
        return $query->result();
    }

    public function getProductsLineWithDetails2($idIntrant, $idEntrepot, $regle = null){
        $this->db->select('*');
        $this->db->from('stock');
        $this->db->where('idproduit', $idIntrant);
        if(!is_null($regle)){
            $this->db->where('identrepot', $idEntrepot);
        }else{
            $this->db->where('identrepot <>', $idEntrepot);
        }
        $query = $this->db->get();
        return $query->result();
    }



	public function getProductStock($id){
    	$k = 0;
		$this->db->select_sum('qte');
		$this->db->from('stock');
		$this->db->where('idproduit', $id);
		$query = $this->db->get();
		$result = $query->result();
		if(!empty($result))
			return $result[0]->qte;
		else
			return $k;
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
