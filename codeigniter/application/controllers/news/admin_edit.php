<?php

/**
 * Admin_Edit
 *
 * @package     Database Project
 * @subpackage  controllers
 * @category    news
 * @author      Crystal Barton
 * @version     1.00
 */
class Admin_Edit extends MY_Controller
{

	var $table = 'news';
	var $page = 'edit';
	var $title = 'News/Reviews >> Edit Item';
	var $_item = array();

	
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
	 * Display the update interface for the news story.
	 */
	function id( $id = NULL )
	{		
		// Determine if the id given is valid.
		if( $id == NULL ) redirect( site_url($this->table.'/admin/menu') );
		if( !$this->is_valid_id($id) ) return;
		
		if( $this->input->post() )
		{
			// Process post data.
			$this->_process_post();

			$this->add_content( 'id', $this->input->post('id') );
			$this->_item = $this->input->post();
		}
		else
		{
			// Get the company's data.
			$this->_item = $this->table_model->get_news_for_admin_edit( $id );
			if( !$this->has_error() )
			{
				$this->load->model('newstag_model');
				$this->_item['newstag'] = $this->newstag_model->get_tags( $id );
				$this->has_error();
			}
		}

		// Get a list of news tags.
		if( (is_array($this->_item)) && ((!$this->input->post()) || ($this->post_processed_errored())) )
		{
			$this->_item['entries'] = $this->table_model->get_tag_list();
			$this->has_error();
		}
		
		// Store the item and set the page's title.
		$this->add_content( 'item', $this->_item );
		if(	isset($this->_item['name']) )
		{
			$this->title .= ' >> '.$this->_item['name'];
		}
		$this->add_content( 'error', $this->post_processed_errored() );
		
		// Add stylesheets and javascript files.
		$this->add_style( 'util/jquery.selector' );
		$this->add_style( 'util/jquery-ui' );
		$this->add_style( 'admin' );
		$this->add_script( 'util/jquery.selector' );
		$this->add_script( 'util/jquery-ui' );
		$this->add_script( 'news/admin' );
		
		// Show the edit item interface.
		$this->show_page( $this->table.'/'.$this->page, $this->title, TRUE );
	}
	

	/**
	 * Process the post data.
	 */
	function _process_post()
	{
		// Start the database transaction.
		$this->start_transaction();
		
		// Update the news story.
		$result = $this->table_model->update_news( 
			$this->input->post('id'),
			$this->input->post('date'),
			$this->input->post('author'),
		 	$this->input->post('title'),
			$this->input->post('synopsis'),
			$this->input->post('text'),
			$this->input->post('is_review'),
			$this->input->post('rating')
		);
		if( $this->has_error() ) return;

		// Store the company's id.
		$id = $this->input->post('id');
		$this->add_content( 'id', $id );

		// The company was successfully updated.
		$this->set_results( TRUE, 'The News Story "'.$this->input->post('title').'" has been updated.' );
		
		// Update the Tags information.
		if( $this->input->post('newstag') === FALSE )
		{
			$this->stop_transaction();
			return;
		}

		$this->load->model('newstag_model');
		
		foreach($this->input->post('newstag') as $tag)
		{
			switch( $tag['action'] )
			{
				case 'add':
					$this->newstag_model->add_tag( $this->input->post('id'), $tag['table'], $tag['table-id'] );
					if( !$this->has_error('newstag') )
					{
						$this->set_results( TRUE, "News Tag '".$tag['table']." => ".$tag['table-id']."' successfully added." );
					}
					break;
					
				case 'delete':
					$this->newstag_model->delete_tag( $this->input->post('id'), $tag['table'], $tag['table-id'] );
					if( !$this->has_error('newstag') )
					{
						$this->set_results( TRUE, "News Tag '".$tag['table']." => ".$tag['table-id']."' successfully deleted." );
					}
					break;
			}
		}
		
		// Stop the database transaction.
		$this->stop_transaction();
	}
}

/* End of file news/admin_edit.php */
/* Location: ./application/controllers/news/admin_edit.php */
