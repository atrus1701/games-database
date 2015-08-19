<?php

/**
 * company_model
 *
 * @package     Database Project
 * @subpackage  models
 * @category	search
 * @author      Crystal Barton
 * @version     1.00
 */
class search_model extends MY_Model
{

	/**
	 * Default Constructor.
	 */
	function __construct() { parent::__construct(); }

	function get_search_results( $search )
	{
		$search = strtolower(preg_replace("/[^a-zA-Z0-9 ]/", "", $search));

		if( strlen(trim($search)) < 2 )
		{
			$this->set_error("Please enter a longer search phrase.");
			return;
		}
		
		/*
		SELECT `table`, `table-id`, SUM(`exact_matches`) AS `exact_matches`, SUM(`partial_matches`) AS `partial_matches`, SUM(`word_matches`) AS `word_matches`
		FROM (
			SELECT `table`, `table-id`, COUNT(`name`) AS `exact_matches`, NULL AS `partial_matches`, NULL AS `word_matches`
			FROM `tag`
			WHERE `name`= 'final fantasy'
			GROUP BY `table`,`table-id`
			HAVING COUNT(`name`) > 0
			UNION
			# partial matches sql
			SELECT `table`, `table-id`, NULL AS `exact_matches`, COUNT(`name`) AS `partial_matches`, NULL AS `word_matches`
			FROM `tag`
			WHERE `name` LIKE '%final fantasy%'
			GROUP BY `table`,`table-id`
			HAVING COUNT(`name`) > 0
			UNION
			# word matches sql
			SELECT `table`, `table-id`, NULL AS `exact_matches`, NULL AS `partial_matches`, COUNT(`name`) AS `word_matches`
			FROM `tag`
			WHERE `name` LIKE '%final%'
			   OR `name` LIKE '%fantasy%'
			GROUP BY `table`,`table-id`
			HAVING COUNT(`name`) > 0
		) matches
		GROUP BY `table`, `table-id`
		ORDER BY `exact_matches` DESC,`partial_matches` DESC,`word_matches` DESC
		LIMIT 50;		
		*/
				
		$words = explode(' ', $search);

		$exact_match_query = "SELECT `table`, `table-id`, COUNT(`name`) AS `exact_matches`, NULL AS `partial_matches`, NULL AS `word_matches` FROM `tag` WHERE `name`='".$search."' GROUP BY `table`,`table-id` HAVING COUNT(`name`) > 0";		
		$partial_match_query = "SELECT `table`, `table-id`, NULL AS `exact_matches`, COUNT(`name`) AS `partial_matches`, NULL AS `word_matches` FROM `tag` WHERE `name` LIKE '%".$search."%' GROUP BY `table`,`table-id` HAVING COUNT(`name`) > 0";		
		$word_match_query = "SELECT `table`, `table-id`, NULL AS `exact_matches`, NULL AS `partial_matches`, COUNT(`name`) AS `word_matches` FROM `tag` WHERE `name` LIKE '%".$words[0]."%'";
		for( $i = 1; $i < count($words); $i++ )
		{
			if( count($words[$i]) > 1 )
			{
				$word_match_query .= " OR `name` LIKE '%".$words[$i]."%'";
			}
		}
		$word_match_query .= " GROUP BY `table`,`table-id` HAVING COUNT(`name`) > 0";
		
		$query = "SELECT `table`, `table-id`, SUM(`exact_matches`) AS `exact_matches`, SUM(`partial_matches`) AS `partial_matches`, SUM(`word_matches`) AS `word_matches` ".
				 "FROM ( ".
					$exact_match_query.
					" UNION ".
					$partial_match_query.
					" UNION ".
					$word_match_query.
				 " ) matches ".
				 "GROUP BY `table`, `table-id` ".
			     "ORDER BY `exact_matches` DESC,`partial_matches` DESC,`word_matches` DESC ".
			     "LIMIT 50";
		$result = $this->query_database(
			$query, array()
		);
		if( $this->has_error() ) return;

		$data = $result->result_array();
		
		for( $i = 0; $i < count($data); $i++ )
		{
			$result = $this->query_database(
				"SELECT `name` FROM `".$data[$i]['table']."` WHERE `id`=?",
				array($data[$i]['table-id'])
			);
			if( $this->has_error() ) return;
	
			$row = $result->row_array();
			$data[$i]['name'] = $row['name'];
		}		 

		return $data;
	}
}

/* End of file search_model.php */
/* Location: ./application/models/search_model.php */

