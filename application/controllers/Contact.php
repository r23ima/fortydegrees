<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Contact extends CI_Controller {
	function __construct(){
		parent::__construct();
		$this->load->model('contact_model', 'cm');
	}

	function index(){
	/*	$this->load->library('pagination');
		$config['base_url'] = base_url().'ajaxcode/index';
		$config*/

		$this->load->view('contact/header');
		$this->load->view('contact/index');
		$this->load->view('contact/footer');
	}

	public function showAllContact(){
		$result = $this->cm->getContact();
		echo json_encode($result);
	}

	public function add(){
		$result = $this->cm->addContact();
		
		if($result){
			$msg['msg'] = "Contact Added Successfully";
			$msg['type'] = "200";
		}
		else{
			$msg['msg'] = "failed to add contact";
			$msg['type'] = "500";
		}
		echo json_encode($msg);
	}

	public function edit(){
		$result = $this->cm->updateContact();
		
		if($result){
			$msg['msg'] = "Contact Updated Successfully";
			$msg['type'] = "200";
		}
		else{
			$msg['msg'] = "failed to update contact";
			$msg['type'] = "500";
		}
		echo json_encode($msg);
	}

	public function delete(){
		$result =$this->cm->deleteContact();
		if($result){
			$msg['msg'] = "Contact Rcmoved Successfully";
			$msg['type'] = "200";
		}
		else{
			$msg['msg'] = "failed to rcmoved contact";
			$msg['type'] = "500";
		}
		echo json_encode($msg);
	}

	public function viewContact(){
		$result = $this->cm->getContactByID();
		echo json_encode($result);
	}

	public function validateUser(){
		$result = $this->cm->validateUser();
		if($result){
			$msg['msg'] = "Success";
			$msg['type'] = "200";
		}
		else{
			$msg['msg'] = "Invalid Credentials";
			$msg['type'] = "500";
		}
		echo json_encode($msg);
	}

	public function dashboard(){
		$this->load->view('contact/header');
		$this->load->view('contact/dashboard');
		$this->load->view('contact/footer');
	}

	public function registration(){
		$this->load->view('contact/header');
		$this->load->view('contact/registration');
		$this->load->view('contact/footer');
	}

	public function logout(){
		$_SESSION = array(); 
		session_unset(); 
		session_destroy(); 
		unset($_SESSION);
		$this->load->view('contact/header');
		$this->load->view('contact/index');
		$this->load->view('contact/footer');
	}

	public function registerUser(){
		if($this->cm->isDuplicateEmail($this->input->post('email'))){
			$msg['msg'] = "Email is already taken.";
			$msg['type'] = "400";
			echo json_encode($msg);
		}
		else{
			$result = $this->cm->addUser();
			if($result){
				$msg['msg'] = "User Added Successfully";
				$msg['type'] = "200";
			}
			else{
				$msg['msg'] = "failed to add user";
				$msg['type'] = "500";
			}
			echo json_encode($msg);
		}
	}
}
