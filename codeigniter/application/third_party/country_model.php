<?php


/**
 * description
 *
 * @package     Database Project
 * @subpackage  models
 * @category	page
 * @author      Crystal Barton
 * @version     1.00
 */
class country_model extends CI_Model
{

	/**
	 * Default Constructor.
	 */
	function __construct() { parent::__construct(); }
	
	/**
	 * 
	 */
	function get_list()
	{
		$result = $this->db->query("SELECT id, name, icon FROM country");
		return ($this->_process_result($result));
	}
	
	function get_item( $id )
	{
		$result = $this->db->query("SELECT id, name, icon FROM country WHERE id = ?", array($id));
		return ($this->_process_result($result));
	}
		
	function add_item( $data )
	{
		$values = array( $data['name'], $data['icon'] );
		$result = $this->db->query("INSERT INTO country (name, icon) VALUES (?,?)", $values);
		return ($this->_process_result($result));
	}
	
	function update_item( $id, $data )
	{
		$values = array( $data['name'], $data['icon'], $data['id'] );
		$result = $this->db->query("UPDATE country SET name = ?, icon = ? WHERE id = ?", $values);
		return ($this->_process_result($result));
	}
	
	function delete_item( $id )
	{
		$result = $this->db->query("DELETE FROM country WHERE id = ?", array($id));
		return ($this->_process_result($result));
	}
	
	function _process_result( $result )
	{
		if( !$result )
			return (get_failure_array('Database failure: ' . $this->db->error_message()));
		
		return (get_success_array( $result->result_array() );
	}
}


/* End of file classname_model.php */
/* Location: ./application/models/classname_model.php */
