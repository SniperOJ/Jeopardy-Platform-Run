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
	public function is_email_existed($email)
	{
	    $query = $this->db->get_where('users', array('email' => $email));
	    return ($query->num_rows() > 0);
	}

	public function is_username_exist($username)
	{
	    $query = $this->db->get_where('users', array('username' => $username));
	    return ($query->num_rows() > 0);
	}

	/* All user */
	public function get_all_user_info($value='')
	{
		# code...
	}

	/* Create user */
	public function register($user_info)
	{
		return $this->db->insert('users', $data));
	}
}