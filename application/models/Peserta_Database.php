<?php
Class Peserta_Database extends CI_Model{

	public function get_all_peserta()
	{
		
		$hasil = $this->db->get('peserta');
		return $hasil;
	}

	public function simpan_peserta(
		$username,
		$password, 
		$nama,
		$tanggal_lahir,
		$tempat_tinggal,
		$tamatan,
		$waktu_dimulai,
		$waktu_berakhir
		)
	{
		$data = array(
			'username'=>$username,
			'password'=> md5($password)); 
		$this->db->insert('user',$data);
		$id=$this->db->insert_id();
		$peserta = array(
			'id'=>$id,
			'nama'=>$nama,
			'tanggal_lahir'=> $tanggal_lahir,
			'tempat_tinggal'=> $tempat_tinggal,
			'tamatan'=> $tamatan,
			'waktu_dimulai'=> $waktu_dimulai,
			'waktu_berakhir'=> $waktu_berakhir); 
		$this->db->insert('peserta',$peserta);
	}

}
?>