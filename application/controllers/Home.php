<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	/**
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function __construct() {	 
		parent::__construct();

		// Load form helper library
		$this->load->helper('form');

		// Load form validation library
		$this->load->library('form_validation');

		// Load session library
		$this->load->library('session');

		// Load database
		$this->load->model('login_database');
	}

	public function index()
	{
		if(isset($this->session->userdata['logged_in']))
			{
				 	if( $_SESSION['logged_in']['role']==='1'){
						redirect('User', 'refresh');
					}else if( $_SESSION['logged_in']['role']==='2'){
						redirect('AdminDispora', 'refresh');
					}else if( $_SESSION['logged_in']['role']==='3'){
						redirect('AdminKeuangan', 'refresh');
					}else if( $_SESSION['logged_in']['role']==='4'){
						redirect('KepalaKantor', 'refresh');
					}
			} else
			{
				$this->load->view('home/login');
			}
	}

	// Check for user login process
	public function user_login_process() {

		$this->form_validation->set_rules('username', 'Username', 'trim|required|xss_clean');
		$this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean');

		if ($this->form_validation->run() == FALSE) 
		{
			if(isset($this->session->userdata['logged_in']))
			{
				 redirect('User', 'refresh');
			} else
			{
				$this->load->view('home/login');
			}
		} else 
		{
			$data = array(
			'username' => $this->input->post('username'),
			'password' => $this->input->post('password')
			);
			$result = $this->login_database->login($data);
			if ($result == TRUE) 
			{

				$username = $this->input->post('username');
				$result = $this->login_database->read_user_information($username);
				if ($result != false) 
				{
					$session_data = array(
					'username' => $result[0]->username,
					'id' => $result[0]->id,
					'role' => $result[0]->role,
					);
					// Add user data in session
					$this->session->set_userdata('logged_in', $session_data);
						if( $result[0]->role==='1'){
						redirect('User', 'refresh');
					}else if( $result[0]->role==='2'){
						redirect('AdminDispora', 'refresh');
					}else if( $result[0]->role==='3'){
						redirect('AdminKeuangan', 'refresh');
					}else if( $result[0]->role==='4'){
						redirect('KepalaKantor', 'refresh');
					}
					
				}
			} else 
			{
				$data = array(
				'error_message' => 'Invalid Username or Password'
				);
				$this->load->view('home/login', $data);
			}
		}
	}


}
