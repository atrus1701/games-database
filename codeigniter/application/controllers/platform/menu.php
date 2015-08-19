<?php

/**
 * Menu
 *
 * @package     Database Project
 * @subpackage  controllers
 * @category    platform
 * @author      Crystal Barton
 * @version     1.00
 */
class menu extends MY_Controller
{

	var $table = 'platform';
	var $page = 'list';
	var $title = 'Platforms';
	

	/**
	 * Default Constructor.
	 */
	function __construct()
	{ 
		parent::__construct();
		$this->load->model( $this->table.'_model', 'table_model' );
	}


	/**
	 * Default page which will list all items in the table. 
	 */
	function index()
	{
		// Get the platform list from the database.
		$results = $this->table_model->get_list_for_menu();
		if( !$this->has_error() )
		{
			$this->add_content( 'list', $results );
		}

		$this->add_style('frontend');

		// show the platform list.
		$this->show_page( $this->table.'/'.$this->page, $this->title );
	}
}

/* End of file platform/menu.php */
/* Location: ./application/controllers/platform/menu.php */
