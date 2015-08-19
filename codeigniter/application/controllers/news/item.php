<?php

/**
 * Item
 *
 * @package     Database Project
 * @subpackage  controllers
 * @category    news
 * @author      Crystal Barton
 * @version     1.00
 */
class Item extends MY_Controller
{

	var $table = 'news';
	var $page = 'item';
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
	 * Default page, redirects the menu.
	 */
	function index()
	{
		redirect( site_url($this->table.'/menu') );
	}
	

	/**
	 * Displays news story that matches the id.
	 */
	function id( $id = NULL )
	{
		// Determine if the id given is valid.
		if( $id == NULL ) redirect( site_url($this->table.'/menu') );
		if( !$this->is_valid_id( $id ) ) return;

		// Get the news story's information.
		$results = $this->table_model->get_news_for_item_view( $id );
		if( !$this->has_error() )
		{
			$this->add_content( 'item', $results );	
			$this->title .= ' >> '.$results['title'];
		}
		
		$this->add_style('frontend');
		
		// Show the view item interface.
		$this->show_page( $this->table.'/'.$this->page, $this->title );	}
}

/* End of file news/item.php */
/* Location: ./application/controllers/news/item.php */
