<?php

/**
 * news_model
 *
 * @package     Database Project
 * @subpackage  models
 * @category	news
 * @author      Crystal Barton
 * @version     1.00
 */
class news_model extends MY_Model
{

	/**
	 * Default Constructor.
	 */
	function __construct() { parent::__construct(); }


	/**
	 * Check to determine if the news story already exists.
	 */
	function news_exists( $title )
	{
		$result = $this->query_database(
			"SELECT 1 FROM `news` WHERE `title`=? LIMIT 1", 
			array($title)
		);
		if( $this->has_error() ) return;
		
		if( $result->num_rows() > 0 )
			return TRUE;

		return FALSE;
	}
	
	
	/**
	 * Get the id of the news story.
	 */
	function get_news_id( $title )
	{
		$result = $this->query_database(
			"SELECT `id` FROM `news` WHERE `title`=?",
			array($title)
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
	 * Get a list of all news stories to be used when displaying the admin menu.
	 */
	function get_list_for_admin_menu()
	{
		$result = $this->query_database(
			"SELECT `id`, `date`, `author`, `title` FROM `news` ORDER BY `date` DESC"
		);
		if( $this->has_error() ) return;

		$results = $result->result_array();
		for( $i = 0; $i < count($results); $i++ )
		{
			$results[$i]['date'] = $this->format_date($results[$i]['date']);
		}
		return $results;
	}	
	
	
	/**
	 * Get the default information for adding news story.
	 */
	function get_news_for_admin_add()
	{
		return array(
			'id' => -1,
			'date' => date("m/d/Y", mktime(0,0,0,date("m"),date("d"),date("Y"))),
			'author' => '',
			'title' => '',
			'synopsis' => '',
			'text' => '',
			'rating' => NULL,
			'newstag'=> array()
		);
	}
	
	
	/**
	 * Get the needed info for the admin edit interface.
	 */
	function get_news_for_admin_edit( $id )
	{
		$result = $this->query_database(
			"SELECT `id`, `title`, `date`, `author`, `synopsis`, `text`, `rating` FROM `news` WHERE `id`=? LIMIT 1",
			array($id)
		);
		if( $this->has_error() ) return;

		$data = array();
		if( $result->num_rows() > 0 )
		{
			$row = $result->row_array();
			$row['date'] = $this->format_date( $row['date'] );
			return $row;
		}
			
		return FALSE;
	}


	/**
	 * Get the needed info for the admin delete interface.
	 */
	function get_game_for_admin_delete( $id )
	{
		$result = $this->query_database(
			"SELECT `id`, `title` FROM `news` WHERE `id`=? LIMIT 1",
			array( $id )
		);
		if( $this->has_error() ) return;
		
		if( $result->num_rows() > 0 )
			return $result->row_array();			
	}
	
	
	/**
	 * Adds a new news story to the table.
	 */
	function add_news( $date, $author, $title, $synopsis, $text, $is_review, $rating )
	{
		$date = $this->format_date_for_db( $date );
		if( $this->has_error() ) return;
		
		if( ($is_review === FALSE) || (!is_numeric($rating)) ) 
			$rating = NULL;
		
		$result = $this->query_database(
			"INSERT INTO `news` (`date`, `author`, `title`, `synopsis`, `text`, `rating`) VALUES (?,?,?,?,?,?)", 
			array($date, $author, $title, $synopsis, $text, $rating)
		);
	}
	
	
	/**
	 * Updates an existing news story in the table.
	 */
	function update_news( $id, $date, $author, $title, $synopsis, $text, $is_review, $rating )
	{
		$date = $this->format_date_for_db( $date );
		if( $this->has_error() ) return;
		
		if( ($is_review === FALSE) || (!is_numeric($rating)) ) 
			$rating = NULL;
		
		$result = $this->query_database(
			"UPDATE `news` SET `date`=?, `author`=?, `title`=?, `synopsis`=?, `text`=?, `rating`=? WHERE `id`=?", 
			array( $date, $author, $title, $synopsis, $text, $rating, $id)
		);
	}
	
	
	/**
	 * Delete the news story and all associated information from the tables.
	 */
	function delete_news( $id )
	{
		$result = $this->query_database(
			"DELETE FROM `news` WHERE `id`=?",
			array($id)
		);
	}
		
	
	/**
	 * Get list of all possible tag values for the news story.
	 */
	function get_tag_list()
	{
		$tables = array( 'game', 'gameseries', 'company', 'platform' );
		
		$tag_list = array();
		foreach($tables as $table)
		{
			$result = $this->query_database("SELECT `id`, `name` FROM ".$table);
			if( $this->has_error() ) return;
			
			$tag_list[$table] = $result->result_array();
		}
		
		return $tag_list;
	}


	/**
	 * Determines if the news story is a review.
	 */
	function is_review( $id )
	{
		$result = $this->query_database(
			"SELECT `rating` FROM `news` WHERE `id`=? LIMIT 1", 
			array($id)
		);
		if( $this->has_error() ) return;
		
		if( $result->num_rows() > 0 )
		{
			$row = $result->row_array();
			if( is_numeric($row['rating']) )
				return TRUE;
		}

		return FALSE;
	}
	
		
	/**
	 * format the date from yyyy-mm-dd to mm/dd/yyyy
	 */
	function format_date( $db_date )
	{
		$date_split = explode( '-', $db_date );
		return $date_split[1].'/'.$date_split[2].'/'.$date_split[0];
	}
	

	/**
	 * format the date from mm/dd/yyy to yyyy-mm-dd
	 */
	function format_date_for_db( $date )
	{
		$date_item = explode('/', $date);
		if( (count($date_item) !== 3) || (!is_numeric($date_item[0])) || (!is_numeric($date_item[1])) || (!is_numeric($date_item[2])) )
		{
			$this->set_error( 'The date is not valid.' );
			return;
		}
		return $date_item[2].'-'.$date_item[0].'-'.$date_item[1];
	}
	

	/**
	 * Get a list of all news stories to be used when displaying the frontend menu.
	 */
	function get_list_for_menu()
	{
		$result = $this->query_database(
			"SELECT `id`, `date`, `author`, `title`, `synopsis`, `rating` FROM `news` ORDER BY `date` DESC"
		);
		if( $this->has_error() ) return;

		$results = $result->result_array();
		for( $i = 0; $i < count($results); $i++ )
		{
			$results[$i]['date'] = $this->format_date($results[$i]['date']);
		}
		return $results;
	}
	
		
	/**
	 * Get the needed info to display the news story to the user.
	 */
	function get_news_for_item_view( $id )
	{
		$result = $this->query_database(
			"SELECT `id`, `title`, `date`, `author`, `text`, `rating` FROM `news` WHERE `id`=? LIMIT 1",
			array($id)
		);
		if( $this->has_error() ) return;

		if( $result->num_rows() == 0 )
			return array();

		$data = $result->row_array();
		$data['date'] = $this->format_date( $data['date'] );

		$result = $this->query_database(
			"SELECT `table`, `table-id` FROM `newstag` WHERE `news-id`=?",
			array( $id )
		);
		
		$data['tags'] = $result->result_array();
		
		for( $i = 0; $i < count($data['tags']); $i++ )
		{
			$result = $this->query_database(
				"SELECT `name` FROM `".$data['tags'][$i]['table']."` WHERE `id`=?",
				array($data['tags'][$i]['table-id'])
			);
			if( $this->has_error() ) return;
	
			$row = $result->row_array();
			$data['tags'][$i]['name'] = $row['name'];
		}		 

		return $data;
	}
}

/* End of file news_model.php */
/* Location: ./application/models/news_model.php */
