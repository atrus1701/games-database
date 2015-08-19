<?php

/**
 * Admin_Add
 * Responsible for displaying and process the data entered into the
 * add interface for this table.
 *
 * @package     Database Project
 * @subpackage  controllers
 * @category    game
 * @author      Crystal Barton
 * @version     1.00
 */
class Admin_Add extends MY_Controller
{

	var $table = 'game';
	var $page = 'add';
	var $title = 'Game >> Add Item';
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
	 * Display the add interface for the game.
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
			$this->_item = $this->table_model->get_game_for_admin_add();
		}
		
		// Store the game and if there was an error.
		$this->add_content( 'item', $this->_item );
		$this->add_content( 'error', $this->post_processed_errored() );

		// Get the lists of information needed.
		if( (!$this->input->post()) || ($this->post_processed_errored()) )
		{
			$this->add_content( 'gameseries', $this->table_model->get_gameseries_list() );
			$this->add_content( 'companies', $this->table_model->get_company_list() );
			$this->add_content( 'regions', $this->table_model->get_region_list() );
			$this->add_content( 'platforms', $this->table_model->get_platform_list() );
			$this->add_content( 'genres', $this->table_model->get_genre_list() );
		}

		// Add stylesheets and javascript files.
		$this->add_style( 'util/jquery.selector' );
		$this->add_style( 'util/jquery.image-selector' );
		$this->add_style( 'util/jquery.tag-selector' );
		$this->add_style( 'util/jquery.combo-selector' );
		$this->add_style( 'admin' );
		$this->add_script( 'util/jquery.selector' );
		$this->add_script( 'util/jquery.image-selector' );
		$this->add_script( 'util/jquery.tag-selector' );
		$this->add_script( 'util/jquery.combo-selector' );
		$this->add_script( 'util/jquery.release-selector' );
		$this->add_script( 'game/admin' );
				
		// Show the add item interface.
		$this->show_page( $this->table.'/'.$this->page, $this->title, TRUE );
	}


	/**
	 * Attempts to add the new item into the database.
	 */
	function _process_post()
	{
		// Start the database transaction.
		$this->start_transaction();
		
		// Check if the game already exists.
		$already_exists = $this->table_model->game_exists(
			$this->input->post('name')
		);
		if( $this->has_error() ) return;

		// The game already exists.		
		if( $already_exists )
		{
			$this->set_results( FALSE, 'The Game "'.$this->input->post('name').'" already exists.' );
			return;
		}

		// Add the game.
		$result = $this->table_model->add_game( 
			$this->input->post('name'),
			$this->input->post('genre'),
			$this->input->post('synopsis'),
			$this->input->post('thumbnail'),
			$this->input->post('artwork'),
			$this->input->post('gallery-folder'),
			$this->input->post('gameseries-id')
		);
		if( $this->has_error() ) return;
		
		// Get the game id auto-generated by the game table.
		$id = $this->table_model->get_game_id( $this->input->post('name') );
		if( $this->has_error() ) return;
		$this->add_content( 'id', $id );

		// The game was successfully added.
		$this->set_results( TRUE, 'The Game "'.$this->input->post('name').'" has been added.' );
		
		// Create the gallery folder, if it does not exists already.
		if( !file_exists('./assets/images/game/gallery/'.$this->input->post('gallery-folder')) )
		{
			if( ! mkdir('./assets/images/game/gallery/'.$this->input->post('gallery-folder')) )
			{
				$this->set_results( FALSE, "Unable to create the gallery folder './assets/images/game/gallery/".$this->input->post('gallery-folder')."'");
				return;
			}
			else
			{
				$this->set_results( TRUE, "Created gallery folder.");
			}
		}
		
		// Add the game's developer information.
		if( is_array($this->input->post('developer')) )
		{
			$developers = &$this->input->post('developer');
			$count = count($developers);
			for( $i = 0; $i < $count; $i++ )
			{
				$developer = $developers[$i];
				
				switch( $developer['action'] )
				{
					case 'add':
						$result = $this->table_model->add_developer( $id, $developer['company-id'] );
						if( !$this->has_error() )
						{
							$this->set_results( TRUE, 'Developer '.$developer['company-id'].' was added.' );
						}
						break;
					
					case 'delete':
						$result = $this->table_model->delete_developer( $id, $developer['company-id'] );
						if( !$this->has_error() )
						{
							$this->set_results( TRUE, 'Developer '.$developer['company-id'].' was removed.' );
						}
						break;
				}
			}
		}
		
		// Add the game's release information.
		if( is_array($this->input->post('release')) )
		{
			$releases = &$this->input->post('release');
			$count = count($releases);
			for( $i = 0; $i < $count; $i++ )
			{
				$release = $releases[$i];
				
				switch( $release['action'] )
				{
					case 'add':
						$result = $this->table_model->add_release( $id, $release['platform-id'], $release['region-id'], $release['company-id'], $release['release-date'] );
						if( !$this->has_error() )
						{
							$this->set_results( TRUE, 'Release for platform '.$release['platform-id'].' in region '.$release['region-id'].' from publisher '.$release['company-id'].' was added.' );
						}
						break;
						
					case 'update':
						$result = $this->table_model->update_release( $id, $release['platform-id'], $release['region-id'], $release['company-id'], $release['release-date'] );
						if( !$this->has_error() )
						{
							$this->set_results( TRUE, 'Release for platform '.$release['platform-id'].' in region '.$release['region-id'].' from publisher '.$release['company-id'].' was updated.' );
						}
						break;
					
					case 'delete':
						$result = $this->table_model->delete_release( $id );
						if( !$this->has_error() )
						{
							$this->set_results( TRUE, 'Release Date for platform '.$release['platform-id'].' in region '.$release['region-id'].' from publisher '.$release['company-id'].' was removed.' );
						}
						break;
				}
			}
		}

		// Insert the Tags information.
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
					$this->tag_model->add_tag( $tag['name'], $this->table, $id );
					if( !$this->has_error('tag') )
					{
						$this->set_results( TRUE, "Tag '".$tag['name']."' successfully added." );
					}
					break;
					
				case 'delete':
					$this->tag_model->delete_tag( $tag['name'], $this->table, $id );
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

/* End of file game/admin_add.php */
/* Location: ./application/controllers/game/admin_add.php */