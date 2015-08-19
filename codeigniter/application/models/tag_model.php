<?php

/**
 * tag_model
 *
 * @package     Database Project
 * @subpackage  models
 * @category	tag
 * @author      Crystal Barton
 * @version     1.00
 */
class tag_model extends MY_Model
{

	/**
	 * Default Constructor.
	 *
	 * @access	public
	 */
	function __construct() { parent::__construct(); }


	/**
	 * Get a list of all tags for a table and id pair.
	 */
	function get_tags( $table, $id )
	{
		$result = $this->query_database(
			"SELECT `id`,`name` FROM `tag` WHERE `table`=? AND `table-id`=? ORDER BY `name`", 
			array($table, $id)
		);
		if( $this->has_error() ) return;

		return $result->result_array();
	}
	
	
	/**
	 * Search the tags for a match to a search phrase.
	 */
	function search_tags( $search )
	{
		$search = $this->convert_tag_to_alphanumeric($search);
		$result = $this->query_database(
			"SELECT `table`, `table-id` FROM `tag` WHERE `name` LIKE '%".$search."%'",
			array()
		);
		if( $this->has_error() ) return;

		return $result->result_array();
	}
		
	
	/**
	 * Add a tag with its associated table and id pair.
	 */
	function add_tag( $name, $table, $table_id )
	{
		$name = $this->convert_tag_to_alphanumeric($name);
		$result = $this->query_database(
			"INSERT INTO `tag` (`name`, `table`, `table-id`) VALUES (?,?,?)",
			array($name, $table, $table_id)
		);
	}


	/**
	 * Delete a tag.
	 */
	function delete_tag( $name, $table, $table_id )
	{
		$name = $this->convert_tag_to_alphanumeric($name);
		$result = $this->query_database(
			"DELETE FROM `tag` WHERE `name`=? AND `table`=? AND `table-id`=?",
			array($name, $table, $table_id)
		);
	}
	
	
	/**
	 * Delete all tags for table and id pair.
	 */
	function delete_tags( $table, $table_id )
	{
		$result = $this->query_database(
			"DELETE FROM `tag` WHERE `table`=? AND `table-id`=?",
			array( $table, $table_id )
		);
	}
	
	
	/**
	 * Delete all tags for table and id pair.
	 */
	function convert_tag_to_alphanumeric( $string )
	{
		return strtolower(preg_replace("/[^a-zA-Z0-9 ]/", "", $string));
	}	
}

/* End of file tag_model.php */
/* Location: ./application/models/tag_model.php */
