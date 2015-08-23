<?php

/**
 * MY Model
 *
 * @package     Database Project
 * @subpackage  library
 * @category	model
 * @author      Crystal Barton
 * @version     1.00
 */
class MY_Model extends CI_Model
{

	var $error_number = 0;
	var $error_message = NULL;


	/**
	 * Default Contructor.
	 */
	function __construct()
	{
		parent::__construct();
	}


	/**
	 * 
	 */
	function has_error()
	{
		if( $this->error_number === 0 ) 
			return FALSE;
		return TRUE;
	}
	
	
	/**
	 * 
	 */
	function get_error()
	{
		if( $this->error_number > 0 )
			return 'Database Error '.$this->error_number.': '.$this->error_message;
		else
			return $this->error_message;
	}

	
	/**
	 * 
	 */
	function set_error($message)
	{
		$this->error_number = -1;
		$this->error_message = $message;
	}
	
	
	/**
	 * 
	 */
	function query_database( $query, $array = array() )
	{
		$this->error = NULL;
		
		$result = $this->db->query($query,$array);
		
		if( $result === FALSE ) 
		{
			$this->error_number = $this->db->_error_number();
			$this->error_message = $this->db->_error_message();
			return FALSE;
		}
		
		return $result;
	}
	
	
	/**
	 * 
	 */
	function clear_error()
	{
		$this->error_number = 0;
		$this->error_message = null;
	}
}

/* End of file my_model.php */
/* Location: ./application/libraries/my_model.php */
