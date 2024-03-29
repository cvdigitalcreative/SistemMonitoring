<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class KepalaKantor extends CI_Controller {

	/**
	 * Index Page for this controller.
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
		$this->load->helper('download');

		// Load form validation library
		$this->load->library('form_validation');

		// Load session library
		$this->load->library('session');

		// Load database
		$this->load->model('laporan_database');
	}
	public function index()
	{
		if(isset($this->session->userdata['logged_in'])and $_SESSION['logged_in']['role']==='4')
			{
				 $data['data']=$this->laporan_database->get_all_laporan_by_status("2");
				$this->load->view('kepalakantor/kotakmasuk',$data);
			} else
			{
				redirect('Home', 'refresh');
			}
		
	}

	public function laporan()
	{
		if(isset($this->session->userdata['logged_in'])and $_SESSION['logged_in']['role']==='4')
			{
				$data['data']=$this->laporan_database->get_all_laporan();
				$this->load->view('kepalakantor/laporan',$data);
			} else
			{
				redirect('Home', 'refresh');
			}
		
	}

	public function update_status()
	{
		if(isset($this->session->userdata['logged_in'])and $_SESSION['logged_in']['role']==='4')
			{
				$id_laporan=$_POST['id'];
				if(isset($_POST['ditolak'])) {
				    $status="-99";
					$this->laporan_database->update_id_laporan($id_laporan,$status);
					redirect('kepalakantor', 'refresh');
				} else if (isset($_POST['diterima'])) {
				   $status="3";
					$this->laporan_database->update_id_laporan($id_laporan,$status);
					redirect('kepalakantor', 'refresh');
				} 
			} else
			{
				redirect('Home', 'refresh');
			}
		
		
	}

	public function download_laporan(){
		if(isset($this->session->userdata['logged_in'])and $_SESSION['logged_in']['role']==='4')
			{
				$path_laporan=$_POST['path_laporan'];
			
				force_download($path_laporan,NULL);
			} else
			{
				redirect('Home', 'refresh');
			}	
		
	}

	
	// Logout from admin page
	public function logout() {

		// Removing session data
		$sess_array = array(
		'username' => ''
		);
		$this->session->unset_userdata('logged_in', $sess_array);
		redirect('Home', 'refresh');
	}

}
