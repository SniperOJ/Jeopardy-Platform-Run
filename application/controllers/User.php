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
	}

	/* Check length */
	public function check_length($word, $min, $max)
	{
		$length = strlen($word);
		if ($length > $max || $length < $min){
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
		return $this->check_length($password, 6, 16);
	}

	public function check_college_name_length($college_name)
	{
		return $this->check_length($college_name, 3, 64);
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

	public function check_email($email)
	{
		return valid_email($email);
	}

	/* Check existed */
	public function do_check_username_existed($username)
	{
		return $this->user_model->is_username_existed($username);
	}

	public function do_check_email_existed($email)
	{
		return $this->user_model->is_email_existed($email);
	}

	/* Send email */
	public function send_email($subject, $content, $target)
	{
		$this->email->from('admin@sniperoj.cn', 'admin');
		$this->email->to($target);
		$this->email->subject($subject);
		$this->email->message($content);
		if($this->email->send()==1){ 
			return true;
		}else{ 
			return false;
		} 
	}

	public function send_active_code($active_code, $target)
	{
		$subject = '[No Reply] Sniper OJ Register Email';
		$content = "Thank you for registering this website!\nyou can activate your account by visiting the following link, which is valid for 2 hours.\nYour active code : http://www.sniperoj.cn/user/active/".$active_code."\n";
		return $this->send_email($subject, $content, $target);
	}

	public function send_reset_code($reset_code, $target)
	{
		$subject = '[No Reply] Sniper OJ Reset Password Email';
		$content = "you can reset your password by visiting the following link, which is valid for 2 hours.\nYour active code : http://www.sniperoj.cn/user/verify/".$active_code."\n";
		return $this->send_email($subject, $content, $target);
	}


	//TODO
	public function verify_captcha($captcha_content)
	{
		return true;
	}

	// TODO
	public function get_masked_email($email)
	{
		return $email;
	}



	/* Password */
	public function get_encrypted_password($password, $salt)
	{
		return md5(md5($password.$salt));
	}

	/* Salt */
	public function get_salt()
	{
		return random_string('alnum', 16);
	}

	public function get_active_code()
	{
		return random_string('alnum', 32);
	}

	/* Reset password */
	public function get_reset_code()
	{
		return random_string('alnum', 32);
	}

	public function check_email_existed()
	{
		$this->load->helper('form');
		$this->load->library('form_validation');

		$this->form_validation->set_rules('email', 'Email', 'trim|required');

		if ($this->form_validation->run() === FALSE)
		{
			die(json_encode(array(
				'status' => 0, 
				'message' => '请提交邮箱!',
			)));
		}
		else
		{
			$email = $this->input->post('email');
			/* 邮箱是否已经被注册 */
			if($this->do_check_email_existed($email) == true){
				die(json_encode(array(
					'status' => 0, 
					'message' => '该邮箱已被注册!',
				)));
			}else{
				die(json_encode(array(
					'status' => 1, 
					'message' => '恭喜!该邮箱可以使用!',
				)));
			}
		}
	}

	public function check_username_existed()
	{
		$this->load->helper('form');
		$this->load->library('form_validation');

		$this->form_validation->set_rules('username', 'Username', 'trim|required');

		if ($this->form_validation->run() === FALSE)
		{
			die(json_encode(array(
				'status' => 0, 
				'message' => '请提交用户名!',
			)));
		}
		else
		{
			$username = $this->input->post('username');
			/* 用户名称是否已经存在 */
			if($this->do_check_username_existed($username) == true){
				die(json_encode(array(
					'status' => 0, 
					'message' => '用户名已存在!',
				)));
			}else{
				die(json_encode(array(
					'status' => 1, 
					'message' => '恭喜!该用户名可以使用!',
				)));
			}
		}
	}

	public function register()
	{
		$this->load->helper('form');
		$this->load->library('form_validation');

		$this->form_validation->set_rules('username', 'Username', 'trim|required');
		$this->form_validation->set_rules('password', 'Password', 'trim|required');
		$this->form_validation->set_rules('email', 'Email', 'trim|required');
		$this->form_validation->set_rules('college', 'College', 'trim|required');
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
					'message' => '用户名长度必须大于等于4个字符小于等于16个字符!',
				)));
			}

			/* 用户名内容 */
			if($this->check_username_bad_chars($user_info['username']) == false){
				die(json_encode(array(
					'status' => 0, 
					'message' => '用户名只可以由数字和字母组成!请不要在用户名中使用特殊字符!',
				)));
			}

			/* 密码长度 */
			if($this->check_password_length($user_info['password']) == false){
				die(json_encode(array(
					'status' => 0, 
					'message' => '密码长度必须大于等于6个字符小于等于16个字符!',
				)));
			}

			/* 密码内容 */
			if($this->check_password_bad_chars($user_info['password']) == false){
				die(json_encode(array(
					'status' => 0, 
					'message' => '请不要在密码中包含特殊字符!',
				)));
			}

			/* 学校名称长度 */
			if($this->check_college_name_length($user_info['college']) == false){
				die(json_encode(array(
					'status' => 0, 
					'message' => '学校名称必须大于等于3个字符小于等于64个字符!',
				)));
			}

			/* 学校名称内容 */
			if($this->check_college_bad_chars($user_info['college']) == false){
				die(json_encode(array(
					'status' => 0, 
					'message' => '请不要在学校名称中包含特殊字符!',
				)));
			}

			/* Email是否合法 */
			if($this->check_email($user_info['email']) == false){
				die(json_encode(array(
					'status' => 0, 
					'message' => '请检查您的邮箱格式是否合法!',
				)));
			}

			/* 用户名称是否已经存在 */
			if($this->do_check_username_existed($user_info['username']) == true){
				die(json_encode(array(
					'status' => 0, 
					'message' => '用户名已存在!',
				)));
			}

			/* 邮箱是否已经被注册 */
			if($this->do_check_email_existed($user_info['email']) == true){
				die(json_encode(array(
					'status' => 0, 
					'message' => '该邮箱已被注册!',
				)));
			}

			/* 注册 */
			$user_info = $this->complete_user_info($user_info);

			/* 插入数据库 */
			if($this->user_model->register($user_info) == false){
				die(json_encode(array(
					'status' => 0, 
					'message' => '注册失败!请与管理员联系!',
				)));
			}

			/* 发送激活码 */
			if($this->send_active_code($user_info['active_code'], $user_info['email']) == false){
				die(json_encode(array(
					'status' => 0, 
					'message' => '激活码发送失败!请与管理员联系!',
				)));
			}

			echo json_encode(array(
				'status' => 1, 
				'message' => '注册成功!请登录您的邮箱('.$this->get_masked_email($user_info['email']).')并点击激活邮件中的激活链接来激活您的账号!',
			));
		}
	}

	/* 完善其他必要的用户信息 */
	public function complete_user_info($user_info)
	{
		$time = time();
		
		$user_info['salt'] = $this->get_salt();
		$user_info['password'] = $this->get_encrypted_password($user_info['password'], $user_info['salt']);

		$user_info['score'] = 0;

		$user_info['registe_time'] = $time;
		$user_info['registe_ip'] = $this->input->ip_address();
		
		$user_info['usertype'] = 0;

		$user_info['active_code'] = $this->get_active_code();
		$user_info['verified'] = 0;

		return $user_info;
	}





























	/* Important function */

	public function is_user_verified($user_id)
	{
		
	}

	/* Captcha */
	public function create_captcha()
	{
		
	}


	/* Status judge */
	public function is_logined()
	{

	}

	public function is_overdue($alive_time)
	{
		
	}


	public function login()
	{

	}

	public function do_login($username, $password)
	{
		
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
