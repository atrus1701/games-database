<?php

/**
 * game_model
 *
 * @package     Database Project
 * @subpackage  models
 * @category	game
 * @author      Crystal Barton
 * @version     1.00
 */
class game_model extends MY_Model
{

	/**
	 * Default Constructor.
	 */
	function __construct() { parent::__construct(); }


	/**
	 * Check to determine if the game already exists.
	 */
	function game_exists( $name )
	{
		$result = $this->query_database(
			"SELECT 1 FROM game WHERE name = ? LIMIT 1", 
			array($name)
		);
		if( $this->has_error() ) return;
		
		if( $result->num_rows() > 0 )
			return TRUE;

		return FALSE;
	}
	
	
	/**
	 * Get the id of the game.
	 */
	function get_game_id( $name )
	{
		$result = $this->query_database("SELECT `id` FROM `game` WHERE `name`=?", array($name));
		if( $this->has_error() ) return;

		if( $result->num_rows() > 0 )
		{
			$row = $result->row_array();
			return $row['id'];
		}
		
		return -1;
	}	
	
	
	/**
	 * Get a list of all games to be used when displaying the admin menu.
	 */
	function get_list_for_admin_menu()
	{
		$result = $this->query_database(
			"SELECT `id`, `name`, `thumbnail` FROM `game` ORDER BY `name`",
			array()
		);
		if( $this->has_error() ) return;
		
		return $result->result_array();		
	}	
	
	
	/**
	 * Get the default information needed for the admin add interface.
	 */
	function get_game_for_admin_add()
	{
		return array(
			'id' => -1,
			'name' => '',
			'synopsis' => '',
			'thumbnail' => '',
			'artwork' => '',
			'gallery-folder' => '',
			'gameseries-id' => NULL,
			'developer' => array(),
			'release' => array(),
			'tag' => array()
		);
	}	
	
	
	/**
	 * Get the needed info for the admin edit interface.
	 */
	function get_game_for_admin_edit( $id )
	{
		$result = $this->query_database(
			"SELECT `id`, `name`, `genre`, `synopsis`, `thumbnail`, `artwork`, `gallery-folder`, `gameseries-id` FROM `game` WHERE `id`=? LIMIT 1",
			array( $id )
		);
		if( $this->has_error() ) return;

		if( $result->num_rows() > 0 )
			$data = $result->row_array();

		$result = $this->query_database(
			"SELECT `company-id` FROM gameisdevelopedbycompany WHERE `game-id`=?",
			array( $id )
		);
		if( $this->has_error() ) return;

		$data['developer'] = $result->result_array();
	
		$result = $this->query_database(
			"SELECT `region-id`, `platform-id`, `company-id`, `release-date` FROM `release` WHERE `game-id`=? ORDER BY `platform-id`, `region-id`",
			array( $id )
		);
		if( $this->has_error() ) return;

		$data['release'] = $result->result_array();
		
		for($i = 0; $i < count($data['release']); $i++)
		{
			$data['release'][$i]['release-date'] = $this->format_date($data['release'][$i]['release-date']);
		}
		
		return $data;
	}


	/**
	 * Get the needed info for the admin delete interface.
	 */
	function get_game_for_admin_delete( $id )
	{
		$result = $this->query_database(
			"SELECT `id`, `name` FROM `game` WHERE `id`=? LIMIT 1",
			array( $id )
		);
		if( $this->has_error() ) return;
		
		if( $result->num_rows() > 0 )
			return $result->row_array();			
	}
	
	
	/**
	 * Adds a new game to the table.
	 */
	function add_game( $name, $genre, $synopsis, $thumbnail, $artwork, $gallery, $gameseries )
	{
		if( $gallery === FALSE ) $gallery = NULL;
		if( $gameseries === 'NULL' ) $gameseries = NULL;
		
		$result = $this->query_database(
			"INSERT INTO `game` (`name`, `genre`, `synopsis`, `thumbnail`, `artwork`, `gallery-folder`, `gameseries-id`) VALUES (?,?,?,?,?,?,?)",
			array($name, $genre, $synopsis, $thumbnail, $artwork, $gallery, $gameseries)
		);
	}


	/**
	 * Updates an existing game in the table.
	 */
	function update_game( $id, $name, $genre, $synopsis, $thumbnail, $artwork, $gallery, $gameseries )
	{
		if( $gallery === FALSE ) $gallery = NULL;
		if( $gameseries === 'NULL' ) $gameseries = NULL;
		
		$result = $this->query_database(
			"UPDATE `game` SET `name`=?, `genre`=?, `synopsis`=?, `thumbnail`=?, `artwork`=?, `gallery-folder`=?, `gameseries-id`=? WHERE `id`=?",
			array($name, $genre, $synopsis, $thumbnail, $artwork, $gallery, $gameseries, $id)
		);
	}
	
	
	/**
	 * Get a list of all games to be used when displaying the frontend menu.
	 */
	function get_list_for_menu()
	{
		$result = $this->query_database(
			"SELECT `game`.`id` AS `id`, `game`.`name` AS `name`, MIN(`release`.`release-date`) AS `release-date` FROM `game` LEFT JOIN `release` ON `game`.`id`=`release`.`game-id` GROUP BY `game`.`id`, `game`.`name` ORDER BY `game`.`name`",
			array()
		);
		if( $this->has_error() ) return;
		
		$data = $result->result_array();
		
		for( $i = 0; $i < count($data); $i++ )
		{
			$data[$i]['release-date'] = $this->format_date($data[$i]['release-date']);
		
			$result = $this->query_database(
				"SELECT `platform`.`id` AS `id`, `icon` FROM `platform`,`release` WHERE `platform`.`id`=`release`.`platform-id` AND `release`.`game-id`=? GROUP BY `platform`.`id`",
				array($data[$i]['id'])
			);
			if( $this->has_error() ) return;
			
			$data[$i]['platforms'] = $result->result_array();
		}
		
		return $data;
	}	
	
		
	/**
	 * Get the needed info to display the game to the user.
	 */
	function get_game_for_item_view( $id )
	{
		$result = $this->query_database(
			"SELECT `game`.`id` AS `id`, `game`.`name` AS `name`, `genre`, `game`.`synopsis` AS `synopsis`, `game`.`artwork` AS `artwork`, `gallery-folder`, `gameseries-id`, `gameseries`.`name` AS `gameseries-name`, AVG(`news`.`rating`) AS `average_rating` FROM `game` LEFT JOIN `gameseries` ON `game`.`gameseries-id` = `gameseries`.`id` LEFT JOIN `newstag` ON `newstag`.`table`='game' AND `game`.`id`=`newstag`.`table-id` LEFT JOIN `news` ON `newstag`.`news-id`=`news`.`id` WHERE `game`.`id`=? GROUP BY `game`.`id` LIMIT 1",
			array( $id )
		);
		if( $this->has_error() ) return;

		if( $result->num_rows() == 0 )
			return array();
			
		$data = $result->row_array();
		
		$data['genre'] = $this->convert_genre_key($data['genre']);

		$result = $this->query_database(
			"SELECT `company-id`, `company`.`name` AS `company-name` FROM `gameisdevelopedbycompany`,`company` WHERE `gameisdevelopedbycompany`.`company-id`=`company`.`id` AND `gameisdevelopedbycompany`.`game-id`=?",
			array( $id )
		);
		if( $this->has_error() ) return;

		$data['developer'] = $result->result_array();
	
		$result = $this->query_database(
			"SELECT `region-id`, `region`.`icon` AS `region-icon`, `platform-id`, `platform`.`icon` AS `platform-icon`, `company-id`, `company`.`name` AS `company-name`, `release-date` FROM `release`, `region`, `platform`, `company` WHERE `release`.`region-id`=`region`.`id` AND `release`.`platform-id`=`platform`.`id` AND `release`.`company-id`=`company`.`id` AND `release`.`game-id`=? ORDER BY `platform`.`name`, `region`.`name`",
			array( $id )
		);
		if( $this->has_error() ) return;

		$data['release'] = $result->result_array();
		
		for($i = 0; $i < count($data['release']); $i++)
		{
			$data['release'][$i]['release-date'] = $this->format_date($data['release'][$i]['release-date']);
		}
		
		$result = $this->query_database(
			"SELECT `id`,`date`,`title`,`author`,`synopsis`, `rating` FROM `news`, `newstag` WHERE `newstag`.`news-id`=`news`.`id` AND `newstag`.`table`='game' AND `newstag`.`table-id`=? ORDER BY `date` DESC",
			array($id)
		);
		if( $this->has_error() ) return;

		$data['news'] = array( 'list' => $result->result_array() );

		return $data;
	}
	
	
	/**
	 * Delete the game and all associated information from the tables.
	 */
	function delete_game( $id )
	{
		$result = $this->query_database(
			"DELETE FROM `game` WHERE `id`=?",
			array( $id )
		);
	}
	
	
	/**
	 * 
	 */
	function add_developer( $id, $developer )
	{
		$result = $this->query_database(
			"INSERT INTO `gameisdevelopedbycompany` (`game-id`, `company-id`) VALUES (?,?)",
			array($id, $developer)
		);
	}
	

	/**
	 * 
	 */
	function delete_developer( $id, $developer )
	{
		$result = $this->query_database(
			"DELETE FROM `gameisdevelopedbycompany` WHERE `game-id`=? AND `company-id`=?",
			array($id, $developer)
		);
	}


	/**
	 * 
	 */
	function add_release( $id, $platform, $region, $publisher, $date )
	{
		$date = $this->format_date_for_db($date);
		if( $this->has_error() ) return;
		
		$result = $this->query_database(
			"INSERT INTO `release` (`game-id`, `platform-id`, `region-id`, `company-id`, `release-date`) VALUES (?,?,?,?,?)",
			array($id, $platform, $region, $publisher, $date)
		);
	}
	

	/**
	 * 
	 */
	function update_release( $id, $platform, $region, $publisher, $date )
	{
		$date = $this->format_date_for_db($date);
		if( $this->has_error() ) return;
		
		$result = $this->query_database(
			"UPDATE `release` SET `company-id`=?, `release-date`=? WHERE `game-id`=? AND `platform-id`=? AND `region-id`=?",
			array($publisher, $date, $id, $platform, $region)
		);
	}


	/**
	 * 
	 */
	function delete_release( $id, $platform, $region )
	{
		$result = $this->query_database(
			"DELETE FROM `release` WHERE `game-id`=? AND `platform-id`=? AND `region-id`=?",
			array($id, $platform, $region)
		);
	}
	

	/**
	 * 
	 */
	function get_gameseries_list()
	{
		$result = $this->query_database(
			"SELECT `id`, `name` FROM `gameseries`",
			array()
		);
		if( $this->has_error() ) return;
		
		return $result->result_array();
	}
	

	/**
	 * 
	 */
	function get_company_list()
	{
		$result = $this->query_database(
			"SELECT `id`, `name` FROM `company`",
			array()
		);
		if( $this->has_error() ) return;
		
		return $result->result_array();
	}


	/**
	 * 
	 */
	function get_region_list()
	{
		$result = $this->query_database(
			"SELECT `id`, `name` FROM `region`",
			array()
		);
		if( $this->has_error() ) return;
		
		return $result->result_array();
	}
	

	/**
	 * 
	 */
	function get_platform_list()
	{
		$result = $this->query_database(
			"SELECT `id`, `name` FROM `platform`",
			array()
		);
		if( $this->has_error() ) return;
		
		return $result->result_array();
	}
	

	/**
	 * 
	 */
	function get_genre_list()
	{
		return array(
			'adventure' => 'Adventure',
			'action' => 'Action',
			'casino' => 'Casino',
			'fps' => 'First-Person Shooter',
			'mmorpg' => 'Massive Multiplayer Online RPG',
			'puzzle' => 'Puzzle',
			'rpg' => 'Role-Playing Game',
			'simulation' => 'Simulation',
			'sports' => 'Sports'
		);
	}
	
		
	/**
	 * format the date from yyyy-mm-dd to mm/dd/yyyy
	 */
	function format_date( $db_date )
	{
		switch(strtolower($db_date))
		{
			case('9999-12-31'):
				return 'TBD';
				break;
			
			case(null);
				return 'Unknown';
				break;
				
			default:
				$date_split = explode( '-', $db_date );
				return $date_split[1].'/'.$date_split[2].'/'.$date_split[0];
				break;
		}
	}
	

	/**
	 * format the date from mm/dd/yyy to yyyy-mm-dd
	 */
	function format_date_for_db( $date )
	{
		switch(strtolower($date))
		{
			case("tbd"):
			case("tba"):
			case(""):
				return '9999-12-31';
				break;
				
			default:
				$date_item = explode('/', $date);
				if( (count($date_item) !== 3) || (!is_numeric($date_item[0])) || (!is_numeric($date_item[1])) || (!is_numeric($date_item[2])) )
				{
					$this->set_error( 'The date is not valid.' );
					return;
				}
				return $date_item[2].'-'.$date_item[0].'-'.$date_item[1];
				break;
		}
	}
	
	function convert_genre_key( $genre )
	{
		$genres = $this->get_genre_list();
		
		return $genres[$genre];
	}

}

/* End of file game_model.php */
/* Location: ./application/models/game_model.php */