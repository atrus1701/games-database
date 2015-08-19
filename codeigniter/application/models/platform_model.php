<?php

/**
 * platform_model
 *
 * @package     Database Project
 * @subpackage  models
 * @category	platform
 * @author      Crystal Barton
 * @version     1.00
 */
class platform_model extends MY_Model
{

	/**
	 * Default Constructor.
	 */
	function __construct() { parent::__construct(); }


	/**
	 * Check to determine if the platform already exists.
	 */
	function platform_exists( $name )
	{
		$result = $this->query_database(
			"SELECT 1 FROM `platform` WHERE `name`=? LIMIT 1", 
			array($name)
		);
		if( $this->has_error() ) return;
		
		if( $result->num_rows() > 0 )
			return TRUE;

		return FALSE;
	}
	

	/**
	 * Get the id of the platform.
	 */
	function get_platform_id( $name )
	{
		$result = $this->query_database(
			"SELECT `id` FROM `platform` WHERE `name`=?",
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
	 * Get a list of all platforms to be used when displaying the admin menu.
	 */
	function get_list_for_admin_menu()
	{
		$result = $this->query_database(
			"SELECT `id`, `maker`, `name`, `icon` FROM `platform` ORDER BY `maker`,`name`"
		);
		if( $this->has_error() ) return;

		return $result->result_array();
	}


	/**
	 * Get the default information for adding platform.
	 */
	function get_platform_for_admin_add()
	{
		return array(
			'id' => -1,
			'name' => '',
			'maker' => '',
			'description' => '',
			'icon' => '',
			'thumbnail' => '',
			'artwork' => '',
			'tag' => array()
		);
	}


	/**
	 * Get the needed info for the admin edit interface.
	 */
	function get_platform_for_admin_edit( $id )
	{
		$result = $this->query_database(
			"SELECT `id`, `name`, `maker`, `description`, `icon`, `thumbnail`, `artwork` FROM `platform` WHERE `id`=? LIMIT 1", 
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
			"SELECT `id`, `name` FROM `platform` WHERE `id`=? LIMIT 1",
			array( $id )
		);
		if( $this->has_error() ) return;
		
		if( $result->num_rows() > 0 )
			return $result->row_array();			
	}
	
	
	/**
	 *
	 */
	function add_platform( $name, $maker, $description, $icon, $thumbnail, $artwork )
	{
		$result = $this->query_database(
			"INSERT INTO `platform` (`name`, `maker`, `description`, `icon`, `thumbnail`, `artwork`) VALUES (?,?,?,?,?,?)", 
			array($name, $maker, $description, $icon, $thumbnail, $artwork)
		);
		if( $this->has_error() ) return;

		return $result;
	}

	/**
	 *
	 */
	function update_platform( $id, $name, $maker, $description, $icon, $thumbnail, $artwork )
	{
		$result = $this->query_database(
			"UPDATE `platform` SET `name`=?, `maker`=?, `description`=?, `icon`=?, `thumbnail`=?, `artwork`=? WHERE `id`=?",
			array($name, $maker, $description, $icon, $thumbnail, $artwork, $id)
		);
		if( $this->has_error() ) return;

		return $result;
	}
	
	/**
	 *
	 */
	function delete_platform( $id )
	{
		$result = $this->query_database(
			"DELETE FROM `platform` WHERE `id`=?", 
			array($id)
		);
		if( $this->has_error() ) return;

		return $result;
	}
	

	/**
	 * Get a list of all platforms to be used when displaying the frontend menu.
	 */
	function get_list_for_menu()
	{
		$result = $this->query_database(
			"SELECT `id`, `name`, `maker`, `description`, `icon`, `thumbnail`, `artwork` FROM `platform` ORDER BY `maker`,`name`"
		);
		if( $this->has_error() ) return;
		
		return $result->result_array();
	}

	
	/**
	 * Get the needed info to display the platform to the user.
	 */
	function get_platform_for_item_view( $id )
	{
		$result = $this->query_database(
			"SELECT `id`, `name`, `maker`, `description`, `artwork` FROM `platform` WHERE `id`=? LIMIT 1", 
			array($id)
		);
		if( $this->has_error() ) return;

		$data = array();
		if( $result->num_rows() == 0 )
			return $data;
			
		$data = $result->row_array();

		$result = $this->query_database(
			"SELECT `id`,`date`,`title`,`author`,`synopsis` FROM `news`, `newstag` WHERE `newstag`.`news-id`=`news`.`id` AND `newstag`.`table`='platform' AND `newstag`.`table-id`=? ORDER BY `date` DESC",
			array($id)
		);
		if( $this->has_error() ) return;

		$data['news'] = array( 'list' => $result->result_array() );

		$result = $this->query_database(
			"SELECT `tbl`.`id` AS `id`, `tbl`.`name` AS `name`, MIN(`release`.`release-date`) AS `release-date` FROM ( SELECT `game`.`id` AS `id`, `game`.`name` AS `name` FROM `game`, `release` WHERE `game`.`id` = `release`.`game-id` AND `release`.`platform-id`=? ) tbl, `release` WHERE `tbl`.`id`=`release`.`game-id` GROUP BY `tbl`.`id`, `tbl`.`name` ORDER BY `tbl`.`name`",
			array($id)
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

/* End of file platform_model.php */
/* Location: ./application/models/platform_model.php */
