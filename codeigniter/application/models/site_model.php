<?php

/**
 * site_model
 *
 * @package     Database Project
 * @subpackage  models
 * @category	site
 * @author      Crystal Barton
 * @version     1.00
 */
class site_model extends MY_Model
{
	/**
	 * Constructor.
	 */
	function __construct() { parent::__construct(); }


	/**
	 * Determine is the id is valid.
	 */
	function is_valid_id( $id, $table )
	{
		if( !is_numeric($id) )
			return FALSE;
		
		$result = $this->query_database("SELECT 1 FROM ".$table." WHERE id=? LIMIT 1", array($id));
		if( $this->has_error() ) return;
		
		if( $result->num_rows() > 0 )
			return TRUE;
			
		return FALSE;
	}
}

/* End of file site_model.php */
/* Location: ./application/models/site_model.php */
