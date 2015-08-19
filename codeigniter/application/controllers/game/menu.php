<?php

/**
 * Menu
 *
 * @package     Database Project
 * @subpackage  controllers
 * @category    game
 * @author      Crystal Barton
 * @version     1.00
 */
class menu extends MY_Controller
{

	var $table = 'game';
	var $page = 'list';
	var $title = 'Game >> List';
	
	
	/**
	 * Default Constructor.
	 */
	function __construct()
	{ 
		parent::__construct();
		$this->load->model( $this->table.'_model', 'table_model' );
	}


	/**
	 * Display the frontend game list.
	 */
	function index()
	{
		// Get the game list from the database.
		$results = $this->table_model->get_list_for_menu();
		if( !$this->has_error() )
		{
			$this->add_content( 'list', $results );
		}
		
		$this->add_style('frontend');

		// show the game list.
		$this->show_page( $this->table.'/'.$this->page, $this->title );
	}
}

/* End of file game/menu.php */
/* Location: ./application/controllers/game/menu.php */
