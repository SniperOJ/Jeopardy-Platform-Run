<?php

class User_model extends CI_Model {
	public function __construct()
	{
		$this->load->database();
	}

	/* Signle user */
	private function get_user_info($$user_id)
	{
		# code...
	}

	private function set_user_info($user_id, $user_info)
	{
		# code...
	}

	/* Get user id */
	public function get_user_id_by_email($email)
	{
		# code...
	}

	public function get_user_id_by_username($username)
	{
		# code...
	}

	/* Existed */
	public function is_username_existed($username)
	{
		# code...
	}

	public function is_email_existed($email)
	{
		# code...
	}

	/* All user */
	public function get_all_user_info($value='')
	{
		# code...
	}

	/* Create user */
	public function register($user_info)
	{
		# code...
	}
}