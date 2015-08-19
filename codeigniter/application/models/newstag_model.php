<?php

/**
 * newstag_model
 *
 * @package     Database Project
 * @subpackage  models
 * @category	news tag
 * @author      Crystal Barton
 * @version     1.00
 */
class newstag_model extends MY_Model
{
	/**
	 * Default Constructor.
	 *
	 * @access	public
	 */
	function __construct() { parent::__construct(); }


	/**
	 * Get a list of all tags for a news story.
	 */
	function get_tags( $news_id )
	{
		$result = $this->query_database(
			"SELECT `table`, `table-id` FROM `newstag` WHERE `news-id`=?",
			array( $news_id )
		);
		if( $this->has_error() ) return;

		return $result->result_array();
	}


	/**
	 * Add a tag.
	 */
	function add_tag( $news_id, $table, $table_id )
	{
		$result = $this->query_database(
			"INSERT INTO `newstag` (`news-id`, `table`, `table-id`) VALUES (?,?,?)",
			array($news_id, $table, $table_id)
		);
	}
	

	/**
	 * Delete a tag.
	 */
	function delete_tag( $news_id, $table, $table_id )
	{
		$result = $this->query_database(
			"DELETE FROM `newstag` WHERE `news-id`=? AND `table`=? AND `table-id`=?",
			array( $news_id, $table, $table_id )
		);
	}


	/**
	 * Delete all the tags associated with a table and id pair.
	 */
	function delete_tags_by_table( $table, $table_id )
	{
		$result = $this->query_database(
			"DELETE FROM `newstag` WHERE `table`=? AND `table-id`=?", 
			array($table, $table_id)
		);
	}
	
	
	/**
	 * Delete all the tags associated with a news story.
	 */
	function delete_tags_by_news( $news_id )
	{
		$result = $this->query_database(
			"DELETE FROM `newstag` WHERE `news-id`=?", 
			array($news_id)
		);
	}
}

/* End of file newstag_model.php */
/* Location: ./application/models/newstag_model.php */
