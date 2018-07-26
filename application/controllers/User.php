<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

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

		// Load form validation library
		$this->load->library('form_validation');

		// Load session library
		$this->load->library('session');

		// Load database
		$this->load->model('laporan_database');
	}
	public function index()
	{
		if(isset($this->session->userdata['logged_in'])and $_SESSION['logged_in']['role']==='1')
			{
				 $this->load->view('user/index');
			} else
			{
				redirect('Home', 'refresh');
			}
		
	}

	public function kirimlaporan()
	{
		if(isset($this->session->userdata['logged_in'])and $_SESSION['logged_in']['role']==='1')
			{
				 $this->load->view('user/kirimlaporan');
			} else
			{
				redirect('Home', 'refresh');
			}
		
	}

	public function terkirim()
	{
		if(isset($this->session->userdata['logged_in'])and $_SESSION['logged_in']['role']==='1')
			{
				$var = $this->session->userdata['logged_in'];
				$id_user=$var['id'];
				  $data['data']=$this->laporan_database->get_all_laporan_by_id_user($id_user);
				$this->load->view('user/terkirim',$data);
			} else
			{
				redirect('Home', 'refresh');
			}
		
	}

	public function kirimlaporan_to_database()
	{
		if(isset($this->session->userdata['logged_in'])and $_SESSION['logged_in']['role']==='1')
			{
				 
				$var = $this->session->userdata['logged_in'];
				
				$config['upload_path']          = 'gambar/'.$var['username'];
				if(!is_dir($config['upload_path'])) mkdir($config['upload_path'], 0777, TRUE);
				$config['allowed_types']        = 'gif|jpg|png|pdf';
				$config['max_size']             = 3000;
				

			
				$d=strtotime("+1 Months");
				$date_range=date("Y-m-d")." - ".date("Y-m-d", $d);
				$judullaporan=$this->input->post('judullaporan');
				$id_user=$var['id'];
				$upload_path=$config['upload_path']  ;
				$laporan_path="";
				$absen_path="";
				$photo_path="";
				$photo_2_path="";
			

				$this->load->library('upload', $config);

				if ( ! $this->upload->do_upload('laporan')){
					$data = array(
						'error_message' => $this->upload->display_errors()
						);
				
					$this->load->view('user/kirimlaporan', $data);
				}else{
					$laporan=$this->upload->data();
					$laporan_path=$laporan['file_name'] ;
					
				}

				if ( ! $this->upload->do_upload('absen')){
					$data = array(
						'error_message' => $this->upload->display_errors()
						);
				
					$this->load->view('user/kirimlaporan', $data);
				}else{
					$laporan=$this->upload->data();
					$absen_path=$laporan['file_name'] ;
					
				}

				if ( ! $this->upload->do_upload('photo')){
					$data = array(
						'error_message' => $this->upload->display_errors()
						);
				
					$this->load->view('user/kirimlaporan', $data);
				}else{
					$laporan=$this->upload->data();
					$photo_path=$laporan['file_name'] ;
					
				}

				if ( ! $this->upload->do_upload('photo2')){
					$data = array(
						'error_message' => $this->upload->display_errors()
						);
				
					$this->load->view('user/kirimlaporan', $data);
				}else{
					$laporan=$this->upload->data();
					$photo_2_path=$laporan['file_name'] ;
					
				}
				   $this->create_qr_code($date_range, $judullaporan,
				$id_user,
				$upload_path,
				$laporan_path,
				$absen_path,
				$photo_path,
				$photo_2_path);
			} else
			{
				redirect('Home', 'refresh');
			}


	}


    function create_qr_code($date_range, $judullaporan,
		$id_user,
		$upload_path,
		$laporan_path,
		$absen_path,
		$photo_path,
		$photo_2_path
		){
        if(isset($this->session->userdata['logged_in'])and $_SESSION['logged_in']['role']==='1')
			{
				 
		        $qr_code_path="";
		        $var = $this->session->userdata['logged_in'];
		        $username=$var['username'];
		        $this->load->library('ciqrcode'); //pemanggilan library QR CODE
		 
		        $config['cacheable']    = true; //boolean, the default is true
		        $config['cachedir']     = './assets/'; //string, the default is application/cache/
		        $config['errorlog']     = './assets/'; //string, the default is application/logs/
		        $config['imagedir']     = $upload_path."/"; //direktori penyimpanan qr code
		        $config['quality']      = true; //boolean, the default is true
		        $config['size']         = '1024'; //interger, the default is 1024
		        $config['black']        = array(224,255,255); // array, default is array(255,255,255)
		        $config['white']        = array(70,130,180); // array, default is array(0,0,0)
		        $this->ciqrcode->initialize($config);

		 		$get_last_id=$this->laporan_database->get_last_id();
		 		

		        $image_name=$get_last_id.'.png'; //buat name dari qr code sesuai dengan nim
		 
		        $params['data'] = base_url().'admindispora/terima_laporan/'.$get_last_id; //data yang akan di jadikan QR CODE
		        $params['level'] = 'H'; //H=High
		        $params['size'] = 10;
		        $params['savename'] = FCPATH.$config['imagedir'].$image_name; //simpan image QR CODE ke folder assets/images/
		       
		        $qr_code_path=  $image_name;
		        $this->ciqrcode->generate($params); // fungsi untuk generate QR CODE
		 

		        $this->laporan_database->simpan_laporan($username,$date_range, $judullaporan,
				$id_user,
				$upload_path,
				$laporan_path,
				$absen_path,
				$photo_path,
				$photo_2_path,
				$qr_code_path); //simpan ke database
		        $data = array(
						'error_message' => "Berhasil Kiriman"
						);
				
				$this->load->view('user/kirimlaporan', $data); //redirect ke mahasiswa usai simpan data
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
