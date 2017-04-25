<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Challenge extends CI_Controller {
    
    public function __construct()
    {
        parent::__construct();
        $this->load->model('challenge_model');
        $this->load->config('email');
        $this->load->helper('string');
        $this->load->library('email');
        $this->load->library('session');
        $this->load->helper('email');
        $this->load->helper('url');
    }


    public function is_overdue($alive_time)
    {
        return (time() > $alive_time);
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

    public function get_all_challenges()
    {
        if($this->is_logined() == false){
            die(json_encode(array(
                'status' => 0, 
                'message' => '请登录后再试!',
            )));
        }

        $user_id = $this->session->user_id;
        $challenges_data = $this->challenge_model->get_all_challenges($user_id);
        if(count($challenges_data) == 0){
            die(json_encode(array(
                'status' => 0, 
                'message' => '赛题不存在!',
            )));
        }else{
            echo json_encode(array(
                    'status' => 1, 
                    'message' => $challenges_data,
            ));
        }
    }

    public function get_challenge_info()
    {
        if($this->is_logined() == false){
            die(json_encode(array(
                'status' => 0, 
                'message' => '请登录后再试!',
            )));
        }
        $user_id = $this->session->user_id;
        $challenge_id = intval($this->uri->segment(3));
        $challenge_info = $this->challenge_model->get_challenge_info($challenge_id,$user_id);
        if($challenge_info === NULL){
            die(json_encode(array(
                'status' => 0, 
                'message' => '赛题不存在!',
            )));
        }else{
            echo json_encode(array(
                    'status' => 1, 
                    'message' => $challenge_info,
            ));
            // update visit times
            $this->update_visit_times($challenge_id);
        }
    }

    public function update_visit_times($challenge_id)
    {
        $this->challenge_model->update_visit_times($challenge_id);
    }

    public function get_type_challenges()
    {
        if($this->is_logined() == false){
            die(json_encode(array(
                'status' => 0, 
                'message' => '请登录后再试!',
            )));
        }
        $user_id = $this->session->user_id;
        $type = strval($this->uri->segment(3));
        $current_type = $this->complete_challenge_type($type);
        $challenges_data = $this->challenge_model->get_type_challenges($user_id, $current_type);
        if (count($challenges_data) == 0){
            die(json_encode(array(
                'status' => 0, 
                'message' => '赛题不存在!',
            )));
        }else{
            echo json_encode(array(
                    'status' => 1, 
                    'message' => $challenges_data,
            ));
        }
    }

    public function get_encrypted_flag($flag)
    {
        return md5($flag);
    }

    public function is_admin()
    {
        if($this->is_logined() && (intval($this->session->usertype) === 1)){
            return true;
        }
        return false;
    }

    public function complete_challenge_type($type)
    {
        switch ($type) {
            case 'web':
            case 'pwn':
            case 'misc':
            case 'stego':
            case 'crypto':
            case 'forensics':
                $current_type = $type;
                break;
            case 'all':
                $current_type = '*';
                break;
            default:
                $current_type = 'other';
                break;
        }
        return $current_type;
    }

    public function create_challenge()
    {
        if($this->is_logined() == false){
            die(json_encode(array(
                'status' => 0, 
                'message' => '请登录后再试!',
            )));
        }

        if($this->is_admin() == false){
            die(json_encode(array(
                'status' => 0, 
                'message' => '权限不足!',
            )));
        }

        $this->load->helper('form');
        $this->load->library('form_validation');

        $this->form_validation->set_rules('name', 'Name', 'trim|required');
        $this->form_validation->set_rules('description', 'Description', 'trim|required');
        $this->form_validation->set_rules('flag', 'Flag', 'trim|required');
        $this->form_validation->set_rules('score', 'Score', 'trim|required');
        $this->form_validation->set_rules('type', 'Type', 'trim|required');
        $this->form_validation->set_rules('fixing', 'Fixing', 'trim|required');

        if ($this->form_validation->run() == FALSE)
        {
            die(json_encode(array(
                'status' => 0, 
                'message' => '表单验证失败!',
            )));
        }

        $author_id = $this->session->user_id;
        $current_type = 
        $challenge_info = array(
            'name' => $this->input->post('name'),
            'description' => $this->input->post('description'),
            'flag' => $this->get_encrypted_flag($this->input->post('flag')),
            'score' => intval($this->input->post('score')),
            'type' => $this->complete_challenge_type($this->input->post('type')),
            'online_time' => time(),
            'visit_times' => 0,
            'fixing' => intval($this->input->post('fixing')),
            'resource' => $this->input->post('resource'),
            'document' => $this->input->post('document'),
            'author_id' => $author_id,
        );

        if($this->challenge_model->create_challenge($challenge_info) == false){
            die(json_encode(array(
                'status' => 0, 
                'message' => '创建赛题失败!请与管理员联系!',
            )));
        }

        echo json_encode(array(
            'status' => 1, 
            'message' => '创建赛题成功!',
        ));
    }


    public function delete_challenge()
    {
        if($this->is_logined() == false){
            die(json_encode(array(
                'status' => 0, 
                'message' => '请登录后再试!',
            )));
        }

        if($this->is_admin() == false){
            die(json_encode(array(
                'status' => 0, 
                'message' => '权限不足!',
            )));
        }

        $challenge_id = intval($this->uri->segment(3));

        if($this->challenge_model->delete_challenge($challenge_id) == false){
            die(json_encode(array(
                'status' => 0, 
                'message' => '删除赛题失败!请与管理员联系!',
            )));
        }

        echo json_encode(array(
            'status' => 1, 
            'message' => '删除赛题成功!',
        ));
    }

    public function fix_challenge()
    {
        if($this->is_logined() == false){
            die(json_encode(array(
                'status' => 0, 
                'message' => '请登录后再试!',
            )));
        }

        if($this->is_admin() == false){
            die(json_encode(array(
                'status' => 0, 
                'message' => '权限不足!',
            )));
        }

        $challenge_id = intval($this->uri->segment(3));

        if($this->challenge_model->is_challenge_existed($challenge_id) == false){
            die(json_encode(array(
                'status' => 0, 
                'message' => '赛题不存在!',
            )));
        }

        if($this->challenge_model->fix_challenge($challenge_id) == false){
            die(json_encode(array(
                'status' => 0, 
                'message' => '下线赛题失败!请与管理员联系!',
            )));
        }

        echo json_encode(array(
            'status' => 1, 
            'message' => '下线赛题成功!',
        ));
    }


    public function fixed_challenge($value='')
    {
        if($this->is_logined() == false){
            die(json_encode(array(
                'status' => 0, 
                'message' => '请登录后再试!',
            )));
        }

        if($this->is_admin() == false){
            die(json_encode(array(
                'status' => 0, 
                'message' => '权限不足!',
            )));
        }

        $challenge_id = intval($this->uri->segment(3));

        if($this->challenge_model->is_challenge_existed($challenge_id) == false){
            die(json_encode(array(
                'status' => 0, 
                'message' => '赛题不存在!',
            )));
        }

        if($this->challenge_model->fixed_challenge($challenge_id) == false){
            die(json_encode(array(
                'status' => 0, 
                'message' => '上线赛题失败!请与管理员联系!',
            )));
        }

        echo json_encode(array(
            'status' => 1, 
            'message' => '上线赛题成功!',
        ));
    }

    public function update_challenge()
    {
        if($this->is_logined() == false){
            die(json_encode(array(
                'status' => 0, 
                'message' => '请登录后再试!',
            )));
        }

        if($this->is_admin() == false){
            die(json_encode(array(
                'status' => 0, 
                'message' => '权限不足!',
            )));
        }

        $challenge_id = intval($this->input->post('challenge_id'));

        if($this->challenge_model->is_challenge_existed($challenge_id) == false){
            die(json_encode(array(
                'status' => 0, 
                'message' => '赛题不存在!',
            )));
        }

        $challenge_info = array();
        if(strlen($this->input->post('name')) > 0){
            $challenge_info['name'] = $this->input->post('name');
        }
        if(strlen($this->input->post('description')) > 0){
            $challenge_info['description'] = $this->input->post('description');
        }
        if(strlen($this->input->post('flag')) > 0){
            $challenge_info['flag'] = $this->get_encrypted_flag($this->input->post('flag'));
        }
        if(strlen($this->input->post('score')) > 0){
            $challenge_info['score'] = intval($this->input->post('score'));
        }
        if(strlen($this->input->post('type')) > 0){
            $challenge_info['type'] = $this->complete_challenge_type($this->input->post('type'));
        }
        if(strlen($this->input->post('resource')) > 0){
            $challenge_info['resource'] = $this->input->post('resource');
        }
        if(strlen($this->input->post('document')) > 0){
            $challenge_info['document'] = $this->input->post('document');
        }

        if($this->challenge_model->update_challenge($challenge_id, $challenge_info) == false){
            die(json_encode(array(
                'status' => 0, 
                'message' => '更新赛题失败!请与管理员联系!',
            )));
        }

        echo json_encode(array(
            'status' => 1, 
            'message' => '更新赛题成功!',
        ));
    }

    public function is_flag_current($current_flag, $flag)
    {
        return ($this->get_encrypted_flag($flag) === $current_flag);
    }

    public function submit()
    {
        if($this->is_logined() == false){
            die(json_encode(array(
                'status' => 0, 
                'message' => '请登录后再试!',
            )));
        }

        $this->load->helper('form');
        $this->load->library('form_validation');

        $this->form_validation->set_rules('challenge_id', 'Challenge ID', 'trim|required');
        $this->form_validation->set_rules('flag', 'Flag', 'trim|required');

        if ($this->form_validation->run() == FALSE)
        {
            die(json_encode(array(
                'status' => 0, 
                'message' => '表单验证失败!',
            )));
        }

        $challenge_id = intval($this->input->post('challenge_id'));
        $flag = $this->input->post('flag');

        if($this->challenge_model->is_challenge_existed($challenge_id) == false){
            die(json_encode(array(
                'status' => 0, 
                'message' => '赛题不存在!',
            )));
        }

        $user_id = $this->session->user_id;

        // 用户是不是已经做过这道题了
        if($this->challenge_model->is_solved_by_user_id($challenge_id, $user_id) == true){
            die(json_encode(array(
                'status' => 0, 
                'message' => '您已经解决了该题目!不需要重复提交!',
            )));
        }

        $challenge_info = $this->challenge_model->get_challenge_info_full($challenge_id, $user_id);

        $current_flag = $challenge_info['flag'];
        $is_current = $this->is_flag_current($current_flag, $flag);

        $submit_info = array(
            'challenge_id' => $challenge_id,
            'user_id' => $user_id,
            'flag' => $flag,
            'submit_time' => time(),
            'is_current' => $is_current,
        );

        $this->challenge_model->insert_submit_log($submit_info);


        if($is_current == false){
            die(json_encode(array(
                'status' => 0, 
                'message' => 'flag错误!',
            )));
        }

        echo json_encode(array(
            'status' => 1, 
            'message' => 'flag正确!',
        ));

        // update user score
        $user_score = $this->user_model->get_score($user_id);
        $this->user_model->set_score($user_id, $user_score + intval($challenge_info['score']));

    }

    public function progress(){
        if($this->is_logined()){
            $offset_time = 60 * 60 * 12; // 12 hours
            echo json_encode($this->challenge_model->get_progress($offset_time));
        }else{
            echo '';
        }
    }

}