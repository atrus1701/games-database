<?php

/**
 * File Upload
 *
 * @package     Database Project
 * @subpackage  controllers
 * @category    file upload
 * @author      Crystal Barton
 * @version     1.00
 */
class admin_menu extends MY_Controller
{	
	var $title = 'File Upload';

	/**
	 * Default Constructor.
	 */
	function __construct()
	{ 
		parent::__construct();
	}

	/**
	 * Default page which will list all items in the table. 
	 */
	function index()
	{
		//
		// Processes the search post data.
		//
		if( $this->input->post() )
		{
			$this->_process_post();
		}
		
		$this->add_style( 'admin' );
		$this->add_script( 'file_upload/admin' );

		//
		// Show the search results.
		//
		$this->show_page( 'file_upload', $this->title, TRUE );
	}
	
	function _process_post()
	{
		$folder = './assets/images/';
		switch( $this->input->post('upload-folder') )
		{
			case('game-gallery'):
				$folder .= 'game/gallery/'.$this->input->post('gallery-folder').'/';
				break;
				
			case('game-thumbnail'):
				$folder .= 'game/thumbnail/';
				break;
				
			case('game-artwork'):
				$folder .= 'game/artwork/';
				break;
				
			case('gameseries-thumbnail'):
				$folder .= 'gameseries/thumbnail/';
				break;
				
			case('gameseries-artwork'):
				$folder .= 'gameseries/artwork/';
				break;
				
			case('platform-icon'):
				$folder .= 'platform/icon/';
				break;
				
			case('platform-thumbnail'):
				$folder .= 'platform/thumbnail/';
				break;
				
			case('platform-artwork'):
				$folder .= 'platform/artwork/';
				break;
				
			case('region-icon'):
				$folder .= 'region/icon/';
				break;
				
			case('company-artwork'):
				$folder .= 'company/artwork/';
				break;
		}

		$this->set_results( TRUE, "Uploading to folder '".$folder."'", TRUE );

		for( $i = 0; $i < count($_FILES['files']['name']); $i++ )
		{
			if( $_FILES['files']['error'][$i] > 0 )
			{
				$this->set_results( FALSE, "Error uploading '".$_FILES['files']['name'][$i]."': Error Number ".$_FILES['files']['error'][$i], TRUE );
			}
			else
			{
				if( file_exists($folder.$_FILES['files']['name'][$i]) )
				{
					$this->set_results( FALSE, "Error uploading '".$_FILES['files']['name'][$i]."': File already exists.", TRUE );
				}
				else
				{
					move_uploaded_file($_FILES['files']['tmp_name'][$i], $folder.$_FILES['files']['name'][$i]);
					$this->set_results( TRUE, "File uploaded '".$_FILES['files']['name'][$i]."'", TRUE );
				}
			}
		}
	}
}

/* End of file search_results.php */
/* Location: ./application/controllers/search_results.php */
