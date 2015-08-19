<?php

/**
 * region_model
 *
 * @package     Database Project
 * @subpackage  models
 * @category	region
 * @author      Crystal Barton
 * @version     1.00
 */
 class region_model extends MY_Model
{

	/**
	 * Default Constructor.
	 */
	function __construct() { parent::__construct(); }


	/**
	 * Check to determine if the region already exists.
	 */
	function region_exists( $name )
	{
		$result = $this->query_database(
			"SELECT 1 FROM `region` WHERE `name`=? LIMIT 1", 
			array($name)
		);
		if( $this->has_error() ) return;
		
		if( $result->num_rows() > 0 )
			return TRUE;

		return FALSE;
	}
	
	
	/**
	 * Get the id of the region.
	 */
	function get_region_id( $name )
	{
		$result = $this->query_database(
			"SELECT `id` FROM `region` WHERE `name`=?", 
			array($name)
		);
		if( $this->has_error() ) return;

		if( $result->num_rows() > 0 )
		{
			$row = $result->row_array();
			return $row['id'];
		}
		
		return -1;
	}	
	
	
	/**
	 * Get a list of all regions to be used when displaying the admin menu.
	 */
	function get_list_for_admin_menu()
	{
		$result = $this->query_database(
			"SELECT `id`, `name`, `icon` FROM `region`"
		);
		if( $this->has_error() ) return;

		return $result->result_array();
	}	
	
	
	/**
	 * Get the default information for adding region.
	 */
	function get_region_for_admin_add()
	{
		return array(
			'id' => -1,
			'name' => '',
			'icon' => ''
		);
	}
	
		
	/**
	 * Get the needed info for the admin edit interface.
	 */
	function get_region_for_admin_edit( $id )
	{
		$result = $this->query_database(
			 "SELECT `id`, `name`, `icon` FROM `region` WHERE `id`=? LIMIT 1", 
			 array($id)
			);
		if( $this->has_error() ) return;

		if( $result->num_rows() > 0 )
			return $result->row_array();

		return $result->result_array();
	}
	

	/**
	 * Get the needed info for the admin delete interface.
	 */
	function get_game_for_admin_delete( $id )
	{
		$result = $this->query_database(
			"SELECT `id`, `name` FROM `region` WHERE `id`=? LIMIT 1",
			array( $id )
		);
		if( $this->has_error() ) return;
		
		if( $result->num_rows() > 0 )
			return $result->row_array();			
	}
	
	
	/**
	 * Adds a new region to the table.
	 */
	function add_region( $name, $icon )
	{
		$result = $this->query_database(
			"INSERT INTO `region` (`name`, `icon`) VALUES (?,?)",
			array($name, $icon)
		);
		if( $this->has_error() ) return;

		return $result;
	}


	/**
	 * Updates an existing region in the table.
	 */
	function update_region( $id, $name, $icon )
	{
		$result = $this->query_database(
			"UPDATE `region` SET `name`=?, `icon`=? WHERE `id`=?", 
			array($name, $icon, $id)
		);
		if( $this->has_error() ) return;

		return $result;
	}
	
	
	/**
	 * Delete the region and all associated information from the tables.
	 */
	function delete_region( $id )
	{
		$result = $this->query_database(
			"DELETE FROM `region` WHERE `id`=?", 
			array($id)
		);
		if( $this->has_error() ) return;

		return $result;
	}
	
	
	/**
	 * Get a list of all regions to be used when displaying the frontend menu.
	 */
	function get_list_for_menu()
	{
		$result = $this->query_database(
			"SELECT `id`, `name`, `icon` FROM `region`"
		);
		if( $this->has_error() ) return;
		
		return $result->result_array();
	}


	/**
	 * Get the needed info to display the region to the user.
	 */
	function get_region_for_item_view( $id )
	{
	}
}

/* End of file region_model.php */
/* Location: ./application/models/region_model.php */
