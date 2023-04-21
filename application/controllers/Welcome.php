<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {
	function __construct(){
		parent :: __construct();
	}
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
	public function index()
	{
		if(!$this->session->has_userdata('admin_id')) 
			redirect(site_url('Welcome/login'));
		$this->load->view('index');

		// 	redirect(site_url('welcome/comments'));
	}
	function register(){
			$post = $this->input->post();
			if($post){
				$this->db->insert('admins',$post);
				redirect(site_url('Welcome/login'));
			}

			else
		$this->load->view('register');
	}
		function login(){
			$post = $this->input->post();
// print_r($post);
			if($post){
				$get = $this->login_model->login($post['username'],$post['password']);
				// echo $get->num_rows();
				// exit;
				if($get->num_rows()){
					$data = array(
					'admin_id'=>$get->row()->id,
					'admin_login'=>TRUE
					);
					$this->session->set_userdata($data);
					redirect(site_url('Admin/index'));
				}
				else{
					redirect(site_url('Welcome/login'));
				}
				echo $get;
			}
			else
				$this->load->view('login');

		}

}
