<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Contact_model extends CI_Model {

	public function getContact(){
		$this->db->where('user_id', $this->session->userdata('user_id'));
		$query = $this->db->get('tbl_contacts');
		if($query->num_rows() > 0){
			return $query->result();
		}
		else{
			return false;
		}
	}

	public function getContactByID(){
		$whereClause = "user_id='".$this->session->userdata('user_id')."' AND contact_id='".$this->input->get('id')."'";
		$this->db->where($whereClause);
		$query = $this->db->get('tbl_contacts');
		if($query->num_rows() > 0){
			return $query->row();
		}
		else{
			return false;
		}
	}

	public function addUser(){
		$p = md5($this->input->post('password')); 
		$field = array(
			'user_name' 		=>$this->input->post('name'),
			'user_email' 		=>$this->input->post('email'),
			'user_password' 	=>$p,
		);
		$this->db->insert('tbl_users', $field);
		$insert_id = $this->db->insert_id();
		if($this->db->affected_rows() > 0){
			$this->session->set_userdata('user_id', $insert_id);
			return true;
		}
		else{
			return false;
		}
	}

	public function addContact(){
		$field = array(
			'contact_name' 			=>$this->input->post('con_name'),
			'contact_number' 		=>$this->input->post('con_mobile'),
			'contact_email' 		=>$this->input->post('con_email'),
			'contact_company' 		=>$this->input->post('con_comp'),
			'user_id'				=>$this->session->userdata('user_id')
		);
		$this->db->insert('tbl_contacts', $field);
		if($this->db->affected_rows() > 0){
			return true;
		}
		else{
			return false;
		}
	}

	public function updateContact(){
		$whereClause = "user_id='".$this->session->userdata('user_id')."' AND contact_id='".$this->input->post('con_id')."'";
		$field = array(
			'contact_name'  		=>$this->input->post('con_name'),
			'contact_email'			=>$this->input->post('con_email'),
			'contact_company'		=>$this->input->post('con_comp'),
			'contact_number'		=>$this->input->post('con_mobile')
		);
		$this->db->where($whereClause);
		$this->db->update('tbl_contacts', $field);
		if($this->db->affected_rows() > 0)
			return true;
		else
			return false;
	}

	public function deleteContact(){
		$id = $this->input->get('id');
		$this->db->where('contact_id', $id);
		$this->db->delete('tbl_contacts');
		if($this->db->affected_rows() > 0)
			return true;
		else
			return false;
	}

	public function isDuplicateEmail($email){
		$query = $this->db->query("SELECT user_id FROM tbl_users WHERE user_email='".$email."'");
		if($query->num_rows() > 0){
			return true;
		}
		else{
			return false;
		}
	}

	public function isDuplicateNumber($number){
		$query = $this->db->query("SELECT contact_id FROM tbl_contacts WHERE contact_number='".$number."' AND user_id='".$this->session->userdata('user_id')."'");
		if($query->num_rows() > 0){
			return true;
		}
		else{
			return false;
		}
	}

	public function validateUser(){
		$p = md5($this->input->post('password'));
		$email = $this->input->post('email');
		$query = $this->db->query("SELECT user_id FROM tbl_users WHERE user_email='".$email."' AND user_password='".$p."'");
		if($query->num_rows() > 0){
			$row = $query->row();
			$this->session->set_userdata('user_id', $row->user_id);
			return true;
		}
		else{
			return false;
		}
	}
}
