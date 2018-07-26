<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AdminDispora extends CI_Controller {

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
		// Load database
		$this->load->model('Peserta_Database');
	}

	public function index()
	{
		if(isset($this->session->userdata['logged_in'])and $_SESSION['logged_in']['role']==='2')
			{
				
				$data['data']=$this->laporan_database->get_all_laporan_by_status("0");
				$this->load->view('admin/dispora/kotakmasuk',$data);
				
			} else
			{
				redirect('Home', 'refresh');
			}
	}

	public function laporan()
	{
		if(isset($this->session->userdata['logged_in'])and $_SESSION['logged_in']['role']==='2')
			{
				
				$data['data']=$this->laporan_database->get_all_laporan();
				$this->load->view('admin/dispora/laporan',$data);
				
			} else
			{
				redirect('Home', 'refresh');
			}
		
	}

	public function profile_peserta()
	{
		if(isset($this->session->userdata['logged_in'])and $_SESSION['logged_in']['role']==='2')
			{
				
				$data['data']=$this->Peserta_Database->get_all_peserta();
				$this->load->view('admin/dispora/profile_peserta',$data);
				
			} else
			{
				redirect('Home', 'refresh');
			}
		
	}

	public function terima_laporan(){	
		if(isset($this->session->userdata['logged_in'])and $_SESSION['logged_in']['role']==='2')
			{
				$id_laporan=basename(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
				$data['data']=$this->laporan_database->get_laporan_by_id($id_laporan);
				
				$this->load->view('admin/dispora/index',$data);
				
				
			} else
			{
				redirect('Home', 'refresh');
			}
		
	}

	public function register_profile(){	
		if(isset($this->session->userdata['logged_in'])and $_SESSION['logged_in']['role']==='2')
			{

				$this->load->view('admin/dispora/registerprofile');
				
				
			} else
			{
				redirect('Home', 'refresh');
			}
		
	}

	public function register_profile_to_database()
	{
		if(isset($this->session->userdata['logged_in'])and $_SESSION['logged_in']['role']==='2')
			{
				$username=$this->input->post('username');
				$password=$this->input->post('password');
				$nama=$this->input->post('nama');
				$tanggal_lahir=$this->input->post('tanggal_lahir');
				$tempat_tinggal=$this->input->post('tempat_tinggal');
				$tamatan=$this->input->post('tamatan');
				$waktu_dimulai=$this->input->post('waktu_dimulai');
				$waktu_berakhir=$this->input->post('waktu_berakhir');

				$id_pegawai=$this->Peserta_Database->simpan_peserta(
		$username,
		$password, 
		$nama,
		$tanggal_lahir,
		$tempat_tinggal,
		$tamatan,
		$waktu_dimulai,
		$waktu_berakhir
		);
					$data= array(
						'error_message' => "Berhasil Kiriman",
						);
				$this->load->view('admin/dispora/registerprofile',$data);
				
			} else
			{
				redirect('Home', 'refresh');
			}
	}
	
	
	public function update_status()
	{
		if(isset($this->session->userdata['logged_in'])and $_SESSION['logged_in']['role']==='2')
			{
				
				
				$id_laporan=$_POST['id'];
				if(isset($_POST['ditolak'])) {
				    $status="-99";
					$this->laporan_database->update_id_laporan($id_laporan,$status);
					redirect('AdminDispora', 'refresh');
				} else if (isset($_POST['diterima'])) {
				   $status="1";
					$this->laporan_database->update_id_laporan($id_laporan,$status);
					redirect('AdminDispora', 'refresh');
				} 
				
			} else
			{
				redirect('Home', 'refresh');
			}
	}

	public function download_laporan(){	
		if(isset($this->session->userdata['logged_in'])and $_SESSION['logged_in']['role']==='2')
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
