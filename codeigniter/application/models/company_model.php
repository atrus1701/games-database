<?php

/**
 * company_model
 *
 * @package     Database Project
 * @subpackage  models
 * @category	company
 * @author      Crystal Barton
 * @version     1.00
 */
class company_model extends MY_Model
{

	/**
	 * Default Constructor.
	 */
	function __construct() { parent::__construct(); }


	/**
	 * Check to determine if the company already exists.
	 */
	function company_exists( $name )
	{
		$result = $this->query_database(
			"SELECT 1 FROM `company` WHERE `name`=? LIMIT 1", 
			array($name)
		);
		if( $this->has_error() ) return;
		
		if( $result->num_rows() > 0 )
			return TRUE;

		return FALSE;
	}


	/**
	 * Get the id of the company.
	 */
	function get_company_id( $name )
	{
		$result = $this->query_database(
			"SELECT `id` FROM `company` WHERE `name`=?", 
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
	 * Get a list of all companies to be used when displaying the admin menu.
	 */
	function get_list_for_admin_menu()
	{
		$result = $this->query_database(
			"SELECT `id`, `name` FROM `company` ORDER BY `name`"
		);
		if( $this->has_error() ) return;

		return $result->result_array();
	}


	/**
	 * Get the default information for adding company.
	 */
	function get_company_for_admin_add()
	{
		return array(
			'id' => -1,
			'name' => '',
			'address' => '',
			'description' => '',
			'artwork' => '',
			'tag' => array()
		);
	}	
	
	
	/**
	 * Get the needed info for the admin edit interface.
	 */
	function get_company_for_admin_edit( $id )
	{
		$result = $this->query_database(
			"SELECT `id`, `name`, `address`, `description`, `artwork` FROM `company` WHERE `id`=? LIMIT 1", 
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
			"SELECT `id`, `name` FROM `company` WHERE `id`=? LIMIT 1",
			array( $id )
		);
		if( $this->has_error() ) return;
		
		if( $result->num_rows() > 0 )
			return $result->row_array();			
	}
	
	
	/**
	 * Adds a new company to the table.
	 */
	function add_company( $name, $address, $description, $artwork )
	{
		$result = $this->query_database(
			"INSERT INTO `company` (`name`, `address`, `description`, `artwork`) VALUES (?,?,?,?)", 
			array($name, $address, $description, $artwork)
		);
		if( $this->has_error() ) return;

		return $result;
	}


	/**
	 * Updates an existing company in the table.
	 */
	function update_company( $id, $name, $address, $description, $artwork )
	{
		$result = $this->query_database(
			"UPDATE `company` SET `name`=?, `address`=?, `description`=?, `artwork`=? WHERE `id`=?", 
			array($name, $address, $description, $artwork, $id)
		);
		if( $this->has_error() ) return;

		return $result;
	}
	
	
	/**
	 * Delete the company and all associated information from the tables.
	 */
	function delete_company( $id )
	{
		$result = $this->query_database(
			"DELETE FROM `company` WHERE `id`=?", 
			array($id)
		);
		if( $this->has_error() ) return;

		return $result;
	}
		
		
	/**
	 * Get a list of all companies to be used when displaying the frontend menu.
	 */
	function get_list_for_menu()
	{
		$result = $this->query_database(
			"SELECT `id`, `name`, `address`, `description` FROM `company` ORDER BY `name`"
		);
		if( $this->has_error() ) return;
		
		return $result->result_array();
	}
	
	
	/**
	 * Get the needed info to display the company to the user.
	 */
	function get_company_for_item_view( $id )
	{
		$result = $this->query_database(
			"SELECT `id`, `name`, `address`, `description`, `artwork` FROM `company` WHERE `id`=? LIMIT 1", 
			array($id)
		);
		if( $this->has_error() ) return;

		$data = array();
		if( $result->num_rows() == 0 )
			return $data;
			
		$data = $result->row_array();

		$result = $this->query_database(
			"SELECT `id`,`date`,`title`,`author`,`synopsis` FROM `news`, `newstag` WHERE `newstag`.`news-id`=`news`.`id` AND `newstag`.`table`='company' AND `newstag`.`table-id`=? ORDER BY `date` DESC",
			array($id)
		);
		if( $this->has_error() ) return;

		$data['news'] = array( 'list' => $result->result_array() );

		$result = $this->query_database(
			"SELECT `tbl`.`id` AS `id`, `tbl`.`name` AS `name`, MIN(`release`.`release-date`) AS `release-date` FROM ( SELECT `game`.`id` AS `id`, `game`.`name` AS `name` FROM `game`, `gameisdevelopedbycompany` WHERE `game`.`id` = `gameisdevelopedbycompany`.`game-id` AND `gameisdevelopedbycompany`.`company-id`=? UNION SELECT `game`.`id` AS `id`, `game`.`name` AS `name` FROM `game`, `release` WHERE `game`.`id` = `release`.`game-id` AND `release`.`company-id`=? ) tbl, `release` WHERE `tbl`.`id`=`release`.`game-id` GROUP BY `tbl`.`id`, `tbl`.`name` ORDER BY `tbl`.`name`",
			array($id, $id)
		);
		if( $this->has_error() ) return;

		$data['games'] = array( 'list' => $result->result_array() );
		
		for($i = 0; $i < count($data['games']['list']); $i++)
		{
			$data['games']['list'][$i]['release-date'] = $this->format_date($data['games']['list'][$i]['release-date']);
		}

		return $data;
	}
	
		
	/**
	 * format the date from yyyy-mm-dd to mm/dd/yyyy
	 */
	function format_date( $db_date )
	{
		switch($db_date)
		{
			case('9999-99-99'):
				return 'TBD';
				break;
				
			default:
				$date_split = explode( '-', $db_date );
				return $date_split[1].'/'.$date_split[2].'/'.$date_split[0];
				break;
		}
	}
}

/* End of file company_model.php */
/* Location: ./application/models/company_model.php */
