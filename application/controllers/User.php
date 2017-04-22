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

	/* Check length */
	public function check_length($word, $min, $max)
	{
		$length = strlen($word);
		if ($length > $max_length || $length < $min_length){
			return false;
		}
		return true;
	}

	public function check_username_length($username)
	{
		return $this->check_length($username, 4, 16);
	}

	public function check_password_length($password)
	{
		return $this->check_length($username, 6, 16);
	}

	public function check_college_name_length($college_name)
	{
		return $this->check_length($username, 1, 64);
	}


	/* Check bad chars */
	public function check_bad_chars($word, $bad_chars)
	{
		$default_bad_chars = '';
		$default_bad_chars .= $bad_chars;
		for ($i=0; $i < strlen($word); $i++) { 
			for ($j=0; $j < strlen($default_bad_chars); $j++) { 
				if ($word[$i] == $bad_chars[$j]){
					return false;
				}
			}
		}
		return true;
	}

	public function check_username_bad_chars($username)
	{
		return $this->check_bad_chars($username, '`~!@#$%^&*()_+-=[]\\{}|:";\'<>?,./');
	}

	public function check_password_bad_chars($password)
	{
		return $this->check_bad_chars($password, '');
	}

	public function check_college_bad_chars($college_name)
	{
		return $this->check_bad_chars($college_name, '`~!@#$%^&*()_+-=[]\\{}|:";\'<>?,./');
	}

	public function check_email()
	{
		return valid_email($email);
	}

	/* Check existed */
	public function check_username_existed($username)
	{
		return $this->user_model->is_username_existed($username);
	}

	public function check_email_existed($email)
	{
		return $this->user_model->is_email_existed($email);
	}






	public function is_user_verified($user_id)
	{
		
	}

	/* Captcha */
	public function create_captcha()
	{
		
	}

	public function verify_captcha($captcha_content)
	{
		
	}



	/* Send email */
	public function send_email($content, $target)
	{
		
	}

	public function send_active_code($active_code, $target)
	{
		
	}

	public function send_reset_code($reset_code, $target)
	{
		
	}



	/* Status judge */
	public function is_logined()
	{

	}

	public function is_overdue($alive_time)
	{
		
	}


	/* Password */
	public function get_encrypted_password($password, $salt)
	{
		return md5(md5($passord.$salt));
	}

	/* Salt */
	public function get_salt()
	{
		
	}

	/* Reset password */
	public function get_reset_code()
	{
		
	}

	/* Important function */

	public function login()
	{

	}

	public function do_login($username, $password)
	{
		
	}

	public function register()
	{
		$this->load->helper('form');
		$this->load->library('form_validation');

		$this->form_validation->set_rules('username', 'Username', 'trim|required');
		$this->form_validation->set_rules('password', 'Password', 'trim|required');
		$this->form_validation->set_rules('email', 'Email', 'trim|required');
		$this->form_validation->set_rules('captcha', 'Captcha', 'trim|required');

		if ($this->form_validation->run() === FALSE)
		{
			die(json_encode(array(
				'status' => 0, 
				'message' => '表单验证失败!',
			)));
		}
		else
		{
			/* 获取 POST 数据 */
			$captcha = $this->input->post('captcha');
			$user_info = array(
				'username' => $this->input->post('username'), 
				'password' => $this->input->post('password'), 
				'email' => $this->input->post('email'), 
				'college' => $this->input->post('college'), 
			);

			/* 验证码 */
			if($this->verify_captcha($captcha) == false){
				die(json_encode(array(
					'status' => 0, 
					'message' => '验证码错误!',
				)));
			}

			/* 用户名长度 */
			if($this->check_username_length($user_info['username']) == false){
				die(json_encode(array(
					'status' => 0, 
					'message' => '!',
				)));
			}

			/* 用户名内容 */
			if($this->check_username_bad_chars($user_info['username']) == false){
				die(json_encode(array(
					'status' => 0, 
					'message' => '!',
				)));
			}

			/* 密码长度 */
			if($this->check_password_length($user_info['password']) == false){
				die(json_encode(array(
					'status' => 0, 
					'message' => '!',
				)));
			}

			/* 密码内容 */
			if($this->check_password_bad_chars($user_info['password']) == false){
				die(json_encode(array(
					'status' => 0, 
					'message' => '!',
				)));
			}

			/* 学校名称长度 */
			if($this->check_college_name_length($user_info['college']) == false){
				die(json_encode(array(
					'status' => 0, 
					'message' => '!',
				)));
			}

			/* 学校名称内容 */
			if($this->check_college_bad_chars($user_info['college']) == false){
				die(json_encode(array(
					'status' => 0, 
					'message' => '!',
				)));
			}

			/* Email是否合法 */
			if($this->check_email($user_info['email']) == false){
				die(json_encode(array(
					'status' => 0, 
					'message' => '!',
				)));
			}

			/* 用户名称是否已经存在 */
			if($this->check_username_existed($user_info['username']) == true){
				die(json_encode(array(
					'status' => 0, 
					'message' => '!',
				)));
			}

			/* 邮箱是否已经被注册 */
			if($this->check_email_existed($user_info['email']) == true){
				die(json_encode(array(
					'status' => 0, 
					'message' => '!',
				)));
			}

			/* 注册 */
			$this->do_register($user_info);
		}
	}

	public function do_register($user_info)
	{
		$this->user_model->register($user_info);
	}


	public function active()
	{
		
	}

	public function do_active($active_code)
	{
		
	}

	public function do_reset($user_id, $new_password)
	{

	}

	public function reset()
	{
		
	}
}
