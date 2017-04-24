<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Home extends CI_Controller {
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
	
	public function __construct()
	{
	    parent::__construct();
	    $this->load->model('user_model');
	    $this->load->config('email');
	    $this->load->helper('string');
	    $this->load->library('email');
	    $this->load->library('session');
	    $this->load->helper('email');
	    $this->load->helper('url');
	}

	public function view()
	{
		var_dump($this->is_logined());
		if ($this->is_logined() == false){
			$this->load->view('/templates/header');
			$this->load->view('/slide_bar/header');
			$this->load->view('/slide_bar/content_visitor.php');
			$this->load->view('/slide_bar/footer');
			$this->load->view('/templates/footer');
			return;
		}

		if($this->is_admin() == false){
			$this->load->view('/templates/header');
			$this->load->view('/slide_bar/header');
			$this->load->view('/slide_bar/content_user.php');
			$this->load->view('/slide_bar/footer');
			$this->load->view('/templates/footer');
			return;
		}

		$this->load->view('/templates/header');
		$this->load->view('/slide_bar/header');
		$this->load->view('/slide_bar/content_admin.php');
		$this->load->view('/slide_bar/footer');
		$this->load->view('/templates/footer');
	}

	public function is_logined()
	{
	    if($this->session->user_id == NULL){
	        return false;
	    }else{
	        $session_alive_time = $this->session->session_alive_time;
	        if($this->is_overdue($session_alive_time)){
	            return false;
	        }else{
	            return true;
	        }
	    }
	}

	public function is_overdue($alive_time)
	{
	    return (time() > $alive_time);
	}

	public function is_admin()
	{
	    return ($this->session->usertype === 0);
	}
}