<?php

/**
 * Search Results
 *
 * @package     Database Project
 * @subpackage  controllers
 * @category    search
 * @author      Crystal Barton
 * @version     1.00
 */
class search extends MY_Controller
{	
	var $title = 'Search Results';

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
		// Processes the search post data.
		//
		if( $this->input->post() )
		{
			$this->_process_post();
		}
		
		//
		// Show the search results.
		//
		$this->show_page( 'search', $this->title );
	}
	
	function _process_post()
	{
		$this->load->model('search_model');
		$results = $this->search_model->get_search_results($this->input->post('search'));
		if( $this->has_error('search') ) return;
		
		$this->add_content( 'search_results', $results );
	}
	
}

/* End of file search_results.php */
/* Location: ./application/controllers/search_results.php */
