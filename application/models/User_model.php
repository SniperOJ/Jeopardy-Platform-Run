<?php

class User_model extends CI_Model {
	public function __construct()
	{
		$this->load->database();
	}

	/* Signle user */
	public function get_user_info($user_id)
	{
		$query = $this->db
			->where('user_id',$user_id)
			->get('users');
		return $query->row_array();
	}

	public function is_user_actived($user_id)
	{
		$query = $this->db
			->where('user_id', $user_id)
			->get('users');
		$result = $query->row_array();
		return (intval($result['actived']) == 1);
	}

	/* Get user id */
	public function get_user_id_by_email($email)
	{
		$query = $this->db
			->where('email', $email)
			->get('users');
		$result = $query->row_array();
		return intval($result['user_id']);
	}

	public function get_user_id_by_username($username)
	{
		$query = $this->db
			->where('username', $username)
			->get('users');
		$result = $query->row_array();
		return intval($result['user_id']);
	}

	public function get_user_id_by_active_code($active_code)
	{
		$query = $this->db
			->where('active_code', $active_code)
			->get('users');
		$result = $query->row_array();
		return intval($result['user_id']);
	}

	/* Existed */
	public function is_email_existed($email)
	{
	    $query = $this->db->get_where('users', array('email' => $email));
	    return ($query->num_rows() > 0);
	}

	public function is_active_code_existed($active_code)
	{
	    $query = $this->db->get_where('users', array('active_code' => $active_code));
	    return ($query->num_rows() > 0);
	}


	public function is_username_existed($username)
	{
	    $query = $this->db->get_where('users', array('username' => $username));
	    return ($query->num_rows() > 0);
	}

	/* All user */
	public function get_all_user_info($value='')
	{
		$query = $this->db
			->get('users');
		return $query->row_array();
	}

	/* Create user */
	public function register($user_info)
	{
		return $this->db->insert('users', $user_info);
	}

	public function active_user($user_id)
	{
		return $this->db->set('actived', '1')->where('user_id', $user_id)->update('users');
	}
}