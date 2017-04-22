<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class User extends CI_Controller {
	
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
		$this->load->language("error");
	}


	/* Status judge */
	public function is_logined()
	{
		# code...
	}

	public function is_overdue($alive_time)
	{
		# code...
	}

	/* Check form item */
	public function check_bad_chars($word, $bad_chars)
	{
		# code...
	}

	public function check_username_bad_chars($username)
	{
		# code...
	}

	public function check_username_length($username)
	{
		# code...
	}

	public function check_password_bad_chars($password)
	{
		
	}

	public function check_password_length($password)
	{
		# code...
	}

	public function check_college_name($college_name)
	{
		# code...
	}

	public function check_email()
	{
		# code...
	}

	public function is_user_verified($user_id)
	{
		# code...
	}

	/* Captcha */
	public function create_captcha()
	{
		# code...
	}

	public function verify_captcha($captcha_id)
	{
		# code...
	}

	/* Is Existed */
	public function check_username_existed($username)
	{
		# code...
	}

	public function check_email_existed($value='')
	{
		# code...
	}

	/* Send email */
	public function send_email($content, $target)
	{
		# code...
	}

	public function send_active_code($active_code, $target)
	{
		# code...
	}

	public function send_reset_code($reset_code, $target)
	{
		# code...
	}

	/* Password */
	public function get_encrypted_password($password, $salt)
	{
		
	}

	/* Salt */
	public function get_salt()
	{
		
	}

	/* Reset password */
	public function get_reset_code()
	{
		# code...
	}

	/* Important function */
	public function login()
	{

	}

	public function register(')
	{
		# code...
	}

	public function active()
	{
		# code...
	}

	public function reset()
	{
		# code...
	}
}
