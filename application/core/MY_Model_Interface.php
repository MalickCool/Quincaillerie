<?php

interface MY_Model_Interface{

	//getter qui permet e récuperer le nom de la table 
	public function get_db_table();
	//getter permettant de récuperer l'id de la table
	public function get_db_table_id();
}