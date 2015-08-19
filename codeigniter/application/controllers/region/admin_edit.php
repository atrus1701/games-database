<?php

/**
 * Admin_Edit
 *
 * @package     Database Project
 * @subpackage  controllers
 * @category    region
 * @author      Crystal Barton
 * @version     1.00
 */
class Admin_Edit extends MY_Controller
{

	var $table = 'region';
	var $page = 'edit';
	var $title = 'region >> Edit Item';
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
	 * Display the update interface for the region.
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
			// Get the region's data.
			$this->_item = $this->table_model->get_region_for_admin_edit( $id );
			if( !$this->has_error() )
			{
				$this->load->model('tag_model');
				$this->_item['tag'] = $this->tag_model->get_tags( $this->table, $id );
				$this->has_error();
			}
		}

		// Store the item and set the page's title.
		$this->add_content( 'item', $this->_item );
		if(	isset($this->_item['name']) )
		{
			$this->title .= ' >> '.$this->_item['name'];
		}
		$this->add_content( 'error', $this->post_processed_errored() );
		
		// Add stylesheets and javascript files.
		$this->add_style( 'util/jquery.image-selector' );
		$this->add_style( 'admin' );
		$this->add_script( 'util/jquery.image-selector' );
		$this->add_script( 'region/admin' );
		
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
		
		// Update the region.
		$result = $this->table_model->update_region(
			$this->input->post('id'),
			$this->input->post('name'),
		 	$this->input->post('icon')
		);
		if( $this->has_error() ) return;

		// Store the region's id.
		$id = $this->input->post('id');
		$this->add_content( 'id', $id );

		// The region was successfully updated.
		$this->set_results( TRUE, 'The Region "'.$this->input->post('name').'" has been updated.' );
		
		// Update the Tags information.
		if( !is_array($this->input->post('tag')) )
		{
			$this->stop_transaction();
			return;
		}

		$this->load->model('tag_model');
		
		foreach($this->input->post('tag') as $tag)
		{
			switch( $tag['action'] )
			{
				case 'add':
					$this->tag_model->add_tag( $tag['name'], $this->table, $this->input->post('id') );
					if( !$this->has_error('tag') )
					{
						$this->set_results( TRUE, "Tag '".$tag['name']."' successfully added." );
					}
					break;
					
				case 'delete':
					$this->tag_model->delete_tag( $tag['name'], $this->table, $this->input->post('id') );
					if( !$this->has_error('tag') )
					{
						$this->set_results( TRUE, "Tag '".$tag['name']."' successfully deleted." );
					}
					break;
			}
		}
		
		// Stop the database transaction.
		$this->stop_transaction();
	}
}

/* End of file region/admin_edit.php */
/* Location: ./application/controllers/region/admin_edit.php */
