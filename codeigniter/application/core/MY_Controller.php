<?php

/**
 * MY Controller
 *
 * @package     Database Project
 * @subpackage  library
 * @category	controller
 * @author      Crystal Barton
 * @version     1.00
 */
class MY_Controller extends CI_Controller
{

	private $_data;
	private $_error;
	private $_in_transaction = FALSE;


	/**
	 * Default Contructor.
	 */
	function __construct() { parent::__construct(); $this->reset_data(); }


	/**
	 * Initializes / resets the page's data.
	 */
	function reset_data()
	{
		$this->_error = FALSE;
		
		$this->_data = array();
		$this->_data['title'] = '';
		$this->_data['scripts'] = array();
		$this->_data['styles'] = array();
		
		$this->_data['header'] = array();
		$this->_data['content'] = array();
		$this->_data['footer'] = array();
		
		$this->add_script( 'util/jquery-1.8.2' );
		$this->add_style( 'util/normalize_2.0.1' );
		$this->add_style( 'site' );
		$this->add_script( 'site' );
	}
	

	/**
	 * Adds style file to include on the html page.
	 *
	 * @param string|array $new_style 
	 *        Script or array of scripts to include in the page.
	 */
	function add_style( $new_style )
	{
		if(is_string($new_style))
		{
			array_push($this->_data['styles'], $new_style);
		}
		else if(is_array($new_style))
		{
			foreach($new_style as $style) {
				array_push($this->_data['styles'], $style);
			}
		}
	}
	
	
	/**
	 * Adds script file to include on the html page.
	 *
	 * @param string|array $new_script 
	 *        Script or array of scripts to include in the page.
	 */
	function add_script( $new_script )
	{
		if(is_string($new_script))
		{
			array_push($this->_data['scripts'], $new_script);
		}
		else if(is_array($new_script))
		{
			foreach($new_script as $script) {
				array_push($this->_data['scripts'], $script);
			}
		}
	}


	/**
	 * Adds data to data.
	 *
	 * @param The key of the data entry. If empty, then add value(s) to data.
	 * @param Value to add to data.
	 */
	function add_data( $key, $value )
	{
		if($key === '')
		{
			foreach($value as $k => $v) {
				$this->_data[$k] = $v;
			}
		}
		else
		{
			$this->_data[$key] = $value;
		}
	}
	
	
	/**
	 * Adds data to the content entry in data.
	 *
	 * @param The key of the content entry. If empty, then add value(s) to content.
	 * @param Value to add to the content entry.
	 */
	function add_content( $key, $value )
	{
		if($key === '')
		{
			foreach($value as $k => $v) {
				$this->_data['content'][$k] = $v;
			}
		}
		else
		{
			$this->_data['content'][$key] = $value;
		}
	}


	/**
	 * Displays the appropriate page with collected data.
	 *
	 * @param The folder the content page is located in.
	 * @param The name of the content page.
	 * @param The title of the page.
	 */
	function show_page( $page, $title, $admin_page = FALSE )
	{
		$this->add_data( 'page', $page );
		$this->_data['title'] = $title;

		$this->add_style( 'content/'.$page );
		$this->add_script( 'content/'.$page );

		if( $admin_page ) 
			$this->_data['header']['admin'] = TRUE;

		if( isset($this->table) )
			$this->_data['header']['table'] = $this->table;

		echo $this->condense( $this->load->view( 'page_view', $this->_data, TRUE ) );
	}
	
	
	/**
	 * 
	 *
	 * $param 
	 */
	function show_error_page( $message )
	{
		$this->reset_data();
		
		$this->add_data( 'page', 'error' );
		$this->_data['title'] = $message;
		
		$this->add_style( 'error' );
		$this->add_script( 'error' );

		$this->add_content( 'message', $message );
		
		echo $this->condense( $this->load->view( 'error_page_view', $this->_data, TRUE ) );
	}


	/**
	 * Condenses HTML to a continous string with no whitespace.
	 *
	 * @param Original HTML
	 * @return HTML with all whitespace removed.
	 */
	function condense( $html )
	{
		return preg_replace( array('@([\t])@'), array(' '), $html);
	}
	
	
	/**
	 * 
	 */
	function is_valid_id( $id )
	{
		if( !is_numeric($id) )
		{
			$this->set_results( FALSE, 'The ID given is not valid.' );				
			$this->show_page( $this->table.'/'.$this->page, $this->title.' >> Invalid Id' );
			return FALSE;
		}

		$results = $this->site_model->is_valid_id( $id, $this->table );
		if( $this->has_error() )
		{
			$this->show_page( $this->table.'/'.$this->page, $this->title.' >> Invalid Id' );
			return FALSE;
		}
		
		if( !$results )
		{
			$this->set_results( FALSE, 'The ID given is not valid.' );				
			$this->show_page( $this->table.'/'.$this->page, $this->title.' >> Invalid Id' );
			return FALSE;
		}
		
		return TRUE;
	}
	
	
	/**
	 * 
	 */
	function has_error( $model = 'table' )
	{
		$model .= '_model';
		
		if( $this->$model->has_error() )
		{
			$this->set_results( FALSE, $this->$model->get_error() );
			$this->$model->clear_error();
			return TRUE;
		}
		return FALSE;
	}


	/**
	 * 
	 */
	function post_processed_errored()
	{
		return $this->_error;
	}


	/**
	 * 
	 */
	function set_results( $success, $message, $ignore=FALSE )
	{
		if( $success === FALSE )
		{
			$this->_error = TRUE;
			if( $this->_in_transaction )
			{
				$this->db->trans_rollback();
				$this->_in_transaction = FALSE;
			}
			if( !$ignore )
				$this->_data['content']['results'] = array();
		}

		if( !isset($this->_data['content']['results']) )
			$this->_data['content']['results'] = array();
		
		$this->_data['content']['results'][] = array( 
			'success' => $success,
			'message' => $message 
		);
	}
	
	
	/**
	 * 
	 */
	function start_transaction()
	{
		$this->db->trans_start();
		$this->_in_transaction = TRUE;
	}
	

	/**
	 * 
	 */
	function stop_transaction()
	{
		if( $this->_in_transaction )
		{
			$this->db->trans_complete();
			$this->_in_transaction = FALSE;
		}
	}
}

/* End of file my_controller.php */
/* Location: ./application/libraries/my_controller.php */
