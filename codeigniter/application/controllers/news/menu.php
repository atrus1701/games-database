<?php

/**
 * Menu
 *
 * @package     Database Project
 * @subpackage  controllers
 * @category    news
 * @author      Crystal Barton
 * @version     1.00
 */
class menu extends MY_Controller
{

	var $table = 'news';
	var $page = 'list';
	var $title = 'News';
	

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
		// Get the news list from the database.
		$results = $this->table_model->get_list_for_menu();
		if( !$this->has_error() )
		{
			$this->add_content( 'list', $results );
		}
		
		$this->add_style('frontend');

		// show the news list.
		$this->show_page( $this->table.'/'.$this->page, $this->title );
	}	
}

/* End of file news/menu.php */
/* Location: ./application/controllers/news/menu.php */
