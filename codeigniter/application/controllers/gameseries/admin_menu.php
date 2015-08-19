<?php

/**
 * Admin_Menu
 *
 * @package     Database Project
 * @subpackage  controllers
 * @category    gameseries
 * @author      Crystal Barton
 * @version     1.00
 */
class Admin_Menu extends MY_Controller
{

	var $table = 'gameseries';
	var $page = 'menu';
	var $title = 'Game Series >> Admin Menu';


	/**
	 * Default Constructor.
	 */
	function __construct()
	{ 
		parent::__construct();
		$this->load->model( $this->table.'_model', 'table_model' );
	}


	/**
	 * Display the admin menu interface for the game series.
	 */
	function index()
	{
		// Add the admin_list stylesheet.
		$this->add_style( 'admin_list' );
		
		// Get the game series list from the database.
		$results = $this->table_model->get_list_for_admin_menu();
		if( !$this->has_error() )
		{
			$this->add_content( 'list', $results );
		}

		// Show the admin menu.
		$this->show_page( $this->table.'/'.$this->page, $this->title, TRUE );

	}
}

/* End of file gameseries/admin_menu.php */
/* Location: ./application/controllers/gameseries/admin_menu.php */
