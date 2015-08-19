<?php

/**
 * gameseries_model
 *
 * @package     Database Project
 * @subpackage  models
 * @category	game series
 * @author      Crystal Barton
 * @version     1.00
 */
class gameseries_model extends MY_Model
{

	/**
	 * Default Constructor.
	 */
	function __construct() { parent::__construct(); }


	/**
	 * Check to determine if the game series already exists.
	 */
	function gameseries_exists( $name )
	{
		$result = $this->query_database(
			"SELECT 1 FROM `gameseries` WHERE `name`=? LIMIT 1", 
			array($name)
		);
		if( $this->has_error() ) return;
		
		if( $result->num_rows() > 0 )
			return TRUE;

		return FALSE;
	}


	/**
	 * Get the id of the game series.
	 */
	function get_gameseries_id( $name )
	{
		$result = $this->query_database(
			"SELECT `id` FROM `gameseries` WHERE `name`=?", 
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
	 * Get a list of all game series to be used when displaying the admin menu.
	 */
	function get_list_for_admin_menu()
	{
		$result = $this->query_database(
			"SELECT `id`, `name` FROM `gameseries` ORDER BY `name`"
		);
		if( $this->has_error() ) return;

		return $result->result_array();
	}

		
	/**
	 * Get the default information for adding game series.
	 */
	function get_gameseries_for_admin_add()
	{
		return array(
			'id' => -1,
			'name' => '',
			'synopsis' => '',
			'thumbnail' => '',
			'artwork' => '',
			'tag' => array()
		);
	}	
	
	
	/**
	 * Get the needed info for the admin edit interface.
	 */
	function get_gameseries_for_admin_edit( $id )
	{
		$result = $this->query_database(
			"SELECT `id`, `name`, `synopsis`, `thumbnail`, `artwork` FROM `gameseries` WHERE `id`=? LIMIT 1", 
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
			"SELECT `id`, `name` FROM `gameseries` WHERE `id`=? LIMIT 1",
			array( $id )
		);
		if( $this->has_error() ) return;
		
		if( $result->num_rows() > 0 )
			return $result->row_array();			
	}
	
	
	/**
	 * Adds a new game series to the table.
	 */
	function add_gameseries( $name, $synopsis, $thumbnail, $artwork )
	{
		$result = $this->query_database(
			"INSERT INTO `gameseries` (`name`, `synopsis`, `thumbnail`, `artwork`) VALUES (?,?,?,?)", 
			array($name, $synopsis, $thumbnail, $artwork)
		);
		if( $this->has_error() ) return;

		return $result;
	}


	/**
	 * Updates an existing game series in the table.
	 */
	function update_gameseries( $id, $name, $synopsis, $thumbnail, $artwork )
	{
		$result = $this->query_database(
			"UPDATE `gameseries` SET `name`=?, `synopsis`=?, `thumbnail`=?, `artwork`=? WHERE `id`=?", 
			array($name, $synopsis, $thumbnail, $artwork, $id)
		);
		if( $this->has_error() ) return;

		return $result;
	}

	
	/**
	 * Delete the game series and all associated information from the tables.
	 */
	function delete_gameseries( $id )
	{
		$result = $this->query_database(
			"DELETE FROM `gameseries` WHERE `id`=?", 
			array($id)
		);
		if( $this->has_error() ) return;

		return $result;
	}
	

	/**
	 * Get a list of all game series to be used when displaying the frontend menu.
	 */
	function get_list_for_menu()
	{
		$result = $this->query_database(
			"SELECT `gameseries`.`id` AS `id`, `gameseries`.`name` AS `name`, `gameseries`.`thumbnail` AS `thumbnail`, COUNT(`game`.`name`) AS `game_count` FROM `gameseries` LEFT JOIN `game` ON `game`.`gameseries-id`=`gameseries`.`id` GROUP BY `gameseries`.`id` ORDER BY `name`;"
		);
		if( $this->has_error() ) return;
		
		return $result->result_array();
	}
	
	
	/**
	 * Get the needed info to display the game series to the user.
	 */
	function get_gameseries_for_item_view( $id )
	{
		$result = $this->query_database(
			"SELECT `id`, `name`, `synopsis`, `artwork` FROM `gameseries` WHERE `id`=? LIMIT 1", 
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
			"SELECT `game`.`id` AS `id`, `game`.`name` AS `name`, MIN(`release`.`release-date`) AS `release-date` FROM `game`, `release` WHERE `game`.`id`=`release`.`game-id` AND `game`.`gameseries-id`=? GROUP BY `game`.`id`, `game`.`name` ORDER BY `game`.`name`",
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

/* End of file gameseries_model.php */
/* Location: ./application/models/gameseries_model.php */
