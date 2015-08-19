<?php

/**
 * Admin_Menu
 *
 * @package     Database Project
 * @subpackage  controllers
 * @category    company
 * @author      Crystal Barton
 * @version     1.00
 */
class Admin_Menu extends MY_Controller
{

	var $table = 'company';
	var $page = 'menu';
	var $title = 'Company >> Admin Menu';


	/**
	 * Default Constructor.
	 */
	function __construct()
	{ 
		parent::__construct();
		$this->load->model( $this->table.'_model', 'table_model' );
	}


	/**
	 * Display the admin menu interface for the company.
	 */
	function index()
	{
		// Add the admin_list stylesheet.
		$this->add_style( 'admin_list' );
		
		// Get the company list from the database.
		$results = $this->table_model->get_list_for_admin_menu();
		if( !$this->has_error() )
		{
			$this->add_content( 'list', $results );
		}

		// Show the admin menu.
		$this->show_page( $this->table.'/'.$this->page, $this->title, TRUE );
	}
}

/* End of file company/admin_menu.php */
/* Location: ./application/controllers/company/admin_menu.php */
