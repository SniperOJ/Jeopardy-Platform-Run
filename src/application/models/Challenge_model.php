<?php

class Challenge_model extends CI_Model {
    public function __construct()
    {
        $this->load->database();
        $this->load->model('user_model');
    }

    /* 获取单个 chellenge 的详细信息 */
    // 这里只是没有选出 flag
    public function get_challenge_info($challenge_id, $user_id)
    {
        $query = $this->db
            ->select(array(
                'challenge_id',
                'name',
                'description',
                'score',
                'type',
                'online_time',
                'visit_times',
                'fixing',
                'resource',
                'document',
                'author_id',
            ))
            ->where('challenge_id',$challenge_id)
            ->get('challenges');
        if($query->num_rows() > 0){
            $challenge = $query->row_array();
            $challenge['solved_times'] = $this->get_challenge_solved_times($challenge_id);
            $challenge['submit_times'] = $this->get_challenge_submit_times($challenge_id);
            $challenge['is_solved'] = $this->is_solved_by_user_id($challenge['challenge_id'], $user_id);
            $challenge['author_name'] = $this->user_model->get_username_by_user_id($challenge['author_id']);
            $challenge['online_time'] = $this->formatTime($challenge['online_time']);
            return $challenge;
        }else{
            return NULL;
        }
    }

    // 这里选出了完整的信息
    public function get_challenge_info_full($challenge_id, $user_id)
    {
        $query = $this->db
            ->where('challenge_id',$challenge_id)
            ->get('challenges');
        if($query->num_rows() > 0){
            $challenge = $query->row_array();
            $challenge['solved_times'] = $this->get_challenge_solved_times($challenge_id);
            $challenge['submit_times'] = $this->get_challenge_submit_times($challenge_id);
            $challenge['is_solved'] = $this->is_solved_by_user_id($challenge['challenge_id'], $user_id);
            $challenge['author_name'] = $this->user_model->get_username_by_user_id($challenge['author_id']);
            $challenge['online_time'] = $this->formatTime($challenge['online_time']);
            return $challenge;
        }else{
            return NULL;
        }
    }

    /* 获取所有 challenges 的简要描述 */
    public function get_all_challenges($user_id)
    {
        $query = $this->db
            ->select(array(
                'challenge_id',
                'name',
                'description',
                'score',
                'type',
                'online_time',
                'visit_times',
                'fixing',
                'resource',
                'document',
                'author_id',
            ))
            ->where(array("fixing" => "0"))
            ->get("challenges");
        $challenges = $query->result_array();
        for ($i=0; $i < count($challenges); $i++) { 
            $challenges[$i]['solved_times'] = $this->get_challenge_solved_times($challenges[$i]['challenge_id']);
            $challenges[$i]['submit_times'] = $this->get_challenge_submit_times($challenges[$i]['challenge_id']);
            $challenges[$i]['is_solved'] = $this->is_solved_by_user_id($challenges[$i]['challenge_id'], $user_id);
            $challenges[$i]['author_name'] = $this->user_model->get_username_by_user_id($challenges[$i]['author_id']);
            $challenges[$i]['online_time'] = $this->formatTime($challenges[$i]['online_time']);
        }
        return $challenges;
    }

    /* 获取指定 challenge 是否被指定 user 解决 */
    public function is_solved_by_user_id($challenge_id, $user_id)
    {
        $query = $this->db->select('submit_time')
        ->where(array(
            "challenge_id" => $challenge_id,
            "user_id" => $user_id,
            "is_current" => "1"
        ))
        ->get('submit_log');
        return ($query->num_rows() > 0);
    }

    /* 获取 challenge 被解决的次数 */
    public function get_challenge_solved_times($challenge_id){
        $query = $this->db->select('submit_id')
        ->where(array(
            "is_current" => "1",
            "challenge_id" => $challenge_id,
        ))
        ->get('submit_log');
        $result = $query->num_rows();
        return $result;
    }

    /* 获取 challenge 被提交的次数 */
    public function get_challenge_submit_times($challenge_id){
        $query = $this->db->select('submit_id')
        ->where(array(
            "challenge_id" => $challenge_id,
        ))
        ->get('submit_log');
        $result = $query->num_rows();
        return $result;
    }

    /* 获取指定类型的 challenge */
    public function get_type_challenges($user_id, $type)
    {
        $query = $this->db
            ->select(array(
                'challenge_id',
                'name',
                'description',
                'score',
                'type',
                'online_time',
                'visit_times',
                'fixing',
                'resource',
                'document',
                'author_id',
            ))
            ->where(array(
                "fixing" => "0",
                "type" => $type,
            ))
            ->get("challenges");
        $challenges = $query->result_array();
        for ($i=0; $i < count($challenges); $i++) { 
            $challenges[$i]['solved_times'] = $this->get_challenge_solved_times($challenges[$i]['challenge_id']);
            $challenges[$i]['submit_times'] = $this->get_challenge_submit_times($challenges[$i]['challenge_id']);
            $challenges[$i]['is_solved'] = $this->is_solved_by_user_id($challenges[$i]['challenge_id'], $user_id);
            $challenges[$i]['author_name'] = $this->user_model->get_username_by_user_id($challenges[$i]['author_id']);
            $challenges[$i]['online_time'] = $this->formatTime($challenges[$i]['online_time']);
        }
        return $challenges;
    }

    public function get_visit_times($challenge_id)
    {
        $query = $this->db->get_where('challenges', array('challenge_id' => $challenge_id));
        $result = $query->row_array();
        return $result['visit_times'];
    }

    public function set_visit_times($challenge_id, $visit_times)
    {
        $this->db->set(array('visit_times' => $visit_times));
        $this->db->where('challenge_id', $challenge_id);
        $this->db->update('challenges');
    }

    /* 更新点击量 */
    public function update_visit_times($challenge_id)
    {
        $visit_times = intval($this->get_visit_times($challenge_id));
        $this->set_visit_times($challenge_id, $visit_times+1);
    }

    /* 人性化显示时间 */
    function formatTime($time){       
        $rtime = date("Y年m月d日 H:i",$time);       
        $htime = date("H:i",$time);             
        $time = time() - $time;         
        if ($time < 60){           
            $str = '刚刚';       
        }elseif($time < 60 * 60){           
            $min = floor($time/60);           
            $str = $min.'分钟前';       
        }elseif($time < 60 * 60 * 24){           
            $h = floor($time/(60*60));           
            $str = $h.'小时前 ';       
        }elseif($time < 60 * 60 * 24 * 3){           
            $d = floor($time/(60*60*24));           
            if($d==1){  
                $str = '昨天 '.$htime;
            }else{  
                $str = '前天 '.$htime;       
            }  
        }else{           
            $str = $rtime;       
        }       
        return $str;
    }

    public function get_challenge_name($challenge_id)
    {
        $query = $this->db->get_where('challenges', array('challenge_id' => $challenge_id));
        $result = $query->row_array();
        return $result['name'];
    }

    /* 获取战况 */
    public function get_progress($offset_time){
        $query = $this->db->select(array('challenge_id', 'user_id', 'submit_time'))
        ->where(array(
            'is_current' => '1',
            'submit_time > ' => time() - $offset_time,
        ))
        ->get('submit_log');
        $result = $query->result_array();
        for ($i=0; $i < count($result); $i++) { 
            $result[$i]['submit_time'] = $this->formatTime($result[$i]['submit_time']);
            $user_id = $result[$i]['user_id'];
            $challenge_id = $result[$i]['challenge_id'];
            $username = $this->user_model->get_username_by_user_id($user_id);
            $challenge_name = $this->get_challenge_name($challenge_id);
            $result[$i]['username'] = $username;
            $result[$i]['challenge_name'] = $challenge_name;
        }
        return $result;
    }

    /* 获取第 n 血 */
    public function get_number_blood($challenge_id, $number)
    {
        // TODO
    }

    public function get_all_challenge_number()
    {
        $query = $this->db
            ->where('fixing', 0)
            ->get('challenges');
        return $query->num_rows();
    }

    public function get_type_challenge_number($type)
    {
        $query = $this->db
            ->where(array(
                'fixing' => 0,
                'type' => $type,
            ))
            ->get('challenges');
        return $query->num_rows();
    }

    public function create_challenge($challenge_info)
    {
        return $this->db->insert('challenges', $challenge_info);
    }

    public function delete_challenge($challenge_id)
    {
        return $this->db->where('challenge_id', $challenge_id)->delete('challenges');
    }

    public function fix_challenge($challenge_id)
    {
        return $this->db->set('fixing', 1)->where('challenge_id', $challenge_id)->update('challenges');
    }

    public function fixed_challenge($challenge_id)
    {
        return $this->db->set('fixing', 0)->where('challenge_id', $challenge_id)->update('challenges');
    }

    public function is_challenge_existed($challenge_id)
    {
        $query = $this->db
            ->where(array(
                'challenge_id' => $challenge_id,
            ))
            ->get('challenges');
        return ($query->num_rows() > 0);
    }

    public function update_challenge($challenge_id, $challenge_info)
    {
        return $this->db->set($challenge_info)->where('challenge_id', $challenge_id)->update('challenges');
    }

    public function insert_submit_log($submit_info)
    {
        $this->db->insert('submit_log', $submit_info);
    }
}