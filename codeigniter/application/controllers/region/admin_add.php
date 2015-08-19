<?php

/**
 * Admin_Add
 * Responsible for displaying and process the data entered into the
 * add interface for this table.
 *
 * @package     Database Project
 * @subpackage  controllers
 * @category    region
 * @author      Crystal Barton
 * @version     1.00
 */
class Admin_Add extends MY_Controller
{

	var $table = 'region';
	var $page = 'add';
	var $title = 'Region >> Add Item';
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
	 * Display the add interface for the region.
	 */
	function index()
	{
		if( $this->input->post() )
		{
			// Process the post data.
			$this->_process_post();
			$this->_item = $this->input->post();
		}
		else
		{
			// Get the item's data.
			$this->_item = $this->table_model->get_region_for_admin_add();
		}
		
		// Store the game and if there was an error.
		$this->add_content( 'item', $this->_item );
		$this->add_content( 'error', $this->post_processed_errored() );
		
		// Add stylesheets and javascript files.
		$this->add_style( 'util/jquery.image-selector' );
		$this->add_style( 'admin' );
		$this->add_script( 'util/jquery.image-selector' );
		$this->add_script( 'region/admin' );
		
		// Show the add item interface.
		$this->show_page( $this->table.'/'.$this->page, $this->title, TRUE );
	}


	/**
	 * Attempts to add the new region into the database.
	 */
	function _process_post()
	{
		// Start the database transaction.
		$this->start_transaction();
		
		// Check if the item already exists.
		$already_exists = $this->table_model->region_exists(
			$this->input->post('name')
		);
		if( $this->has_error() ) return;
		
		// The region already exists.
		if( $already_exists )
		{
			$this->set_results( FALSE, 'The Region "'.$this->input->post('name') . '" already exists.' );
			return;
		}

		// Add the region.
		$result = $this->table_model->add_region(
			$this->input->post('name'),
		 	$this->input->post('icon')
		);
		if( $this->has_error() ) return;
		
		// Get the region id auto-generated by the region table.
		$id = $this->table_model->get_region_id(
			$this->input->post('name')
		);
		if( $this->has_error() ) return;
		$this->add_content( 'id', $id );
		
		// The region was successfully added.
		$this->set_results( TRUE, 'The Region "'.$this->input->post('name').'" has been added.' );
		
		// Stop the database transaction.
		$this->stop_transaction();
	}
}

/* End of file region/admin_add.php */
/* Location: ./application/controllers/region/admin_add.php */