<?php
Class Laporan_Database extends CI_Model{

	public function get_all_laporan()
	{
		
		$hasil = $this->db->get('laporan');
		return $hasil;
	}

	public function get_all_laporan_by_id_user($id_user)
	{
		
		$this->db->select('*');
		$this->db->from('laporan');
		$this->db->where('id_user', $id_user);
		$hasil = $this->db->get();
		return $hasil;
	}

	public function get_all_laporan_by_status($status)
	{
		
		$this->db->select('*');
		$this->db->from('laporan');
		$this->db->where('status', $status);
		$hasil = $this->db->get();
		return $hasil;
	}

	public function get_laporan_by_id($id_laporan)
	{
		$this->db->select('*');
		$this->db->from('laporan');
		$this->db->where('id_laporan', $id_laporan);
		$this->db->where('status', "0");
		$hasil = $this->db->get();
		return $hasil;
	}
	public function simpan_laporan($username,$date_range, $judullaporan,
		$id_user,
		$upload_path,
		$laporan_path,
		$absen_path,
		$photo_path,
		$photo_2_path,
		$qr_code_path)
	{
		$data = array(
			'username'=>$username,
			'date_range'=> $date_range,
			'judullaporan'=> $judullaporan,
			'id_user'=> $id_user,
			'upload_path'=> $upload_path,
			'laporan_path'=> $laporan_path,
			'absen_path'=> $absen_path,
			'photo_path'=> $photo_path,
			'photo_2_path'=> $photo_2_path,
			'qr_code_path'=> $qr_code_path); 
		$this->db->insert('laporan',$data);
	}

	public function get_last_id(){
		$this->db->select("id_laporan");
		$this->db->from("laporan");
		$this->db->limit(1);
		$this->db->order_by('id_laporan',"DESC");
		$query = $this->db->get();
		$lastid =$query->row()->id_laporan;
		
		
		return $lastid+1;
	}

	public function update_id_laporan($id_laporan,$status){
		$this->db->set('status', $status);
		$this->db->where('id_laporan', $id_laporan);
		$this->db->update('laporan');
	}
}
?>