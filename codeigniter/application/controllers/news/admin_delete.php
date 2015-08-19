<?php

/**
 * Admin_Delete
 *
 * @package     Database Project
 * @subpackage  controllers
 * @category    news
 * @author      Crystal Barton
 * @version     1.00
 */
class Admin_Delete extends MY_Controller
{

	var $table = 'news';
	var $page = 'delete';
	var $title = 'News/Reviews >> Delete Item';


	/**
	 * Default Constructor.
	 */
	function __construct()
	{ 
		parent::__construct();
		$this->load->model( $this->table.'_model', 'table_model' );
	}


	/**
	 * Default page, redirects to the admin menu.
	 */
	function index()
	{
		redirect( site_url($this->table.'/admin/menu') );
	}


	/**
	 * Display the delete interface for the news.
	 */
	function id( $id = NULL )
	{
		// Determine if the id given is valid.
		if( $id == NULL ) redirect( site_url($this->table.'/admin/menu') );
		if( !$this->is_valid_id($id) ) return;
			
		if( $this->input->post() )
		{
			// If canceling the delete, return to the menu.
			if( $this->input->post('action') === 'Cancel' )
				redirect(site_url($this->table.'/admin/menu'));
			
			// process the post data.
			$this->_process_post();
			$this->_item = $this->input->post();
		}
		else
		{
			// Get the item's data.
			$this->_item = $this->table_model->get_news_for_admin_edit( $id );
			$this->has_error();
		}

		// Store the item and set the page's title.
		$this->add_content( 'item', $this->_item );
		if(	isset($this->_item['name']) )
		{
			$this->title .= ' >> '.$this->_item['name'];
		}

		// Add the admin stylesheets.
		$this->add_style( 'admin' );
		$this->add_style( 'admin_delete' );
		
		// Show the delete item interface.
		$this->show_page( $this->table.'/'.$this->page, $this->title, TRUE );
	}


	/**
	 * 
	 */
	function _process_post()
	{
		// Start the database transaction.
		$this->start_transaction();
		
		// Delete the news story from table.
		$results = $this->table_model->delete_news(
			$this->input->post('id')
		);
		if( $this->has_error() ) return;
		
		// The item was deleted successfully.
		$this->set_results( TRUE, 'The news story "'.$this->input->post('name').'" has been deleted.' );
		
		// Stop the database transaction.
		$this->stop_transaction();
	}
}

/* End of file news/admin_delete.php */
/* Location: ./application/controllers/news/admin_delete.php */
