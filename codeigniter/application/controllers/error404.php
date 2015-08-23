<?php

/**
 * Error 404
 *
 * @package     Database Project
 * @subpackage  controllers
 * @category    error
 * @author      Crystal Barton
 * @version     1.00
 */
class error404 extends MY_Controller
{	
	var $title = 'Not Found';

	/**
	 * Default Constructor.
	 */
	function __construct()
	{ 
		parent::__construct();
	}

	/**
	 * Default page which will list all items in the table. 
	 */
	function index()
	{
		//
		// Show the 404 page.
		//
		$this->show_page( '404', $this->title, FALSE );
	}
}

/* End of file search_results.php */
/* Location: ./application/controllers/search_results.php */
