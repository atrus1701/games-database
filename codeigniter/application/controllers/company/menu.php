<?php

/**
 * Menu
 *
 * @package     Database Project
 * @subpackage  controllers
 * @category    company
 * @author      Crystal Barton
 * @version     1.00
 */
class menu extends MY_Controller
{

	var $table = 'company';
	var $page = 'list';
	var $title = 'Companies';

	
	/**
	 * Default Constructor.
	 */
	function __construct()
	{ 
		parent::__construct();
		$this->load->model( $this->table.'_model', 'table_model' );
	}


	/**
	 * Display the frontend company list.
	 */
	function index()
	{
		// Get the company list from the database.
		$results = $this->table_model->get_list_for_menu();
		if( !$this->has_error() )
		{
			$this->add_content( 'list', $results );
		}
		
		$this->add_style('frontend');

		// show the company list.
		$this->show_page( $this->table.'/'.$this->page, $this->title );
	}
}

/* End of file company/menu.php */
/* Location: ./application/controllers/company/menu.php */
