<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Video extends CI_Driver_Library {

    protected $valid_drivers = array(
        'video_yinyuetai', 'video_qiyi', 'video_youku'
    );
    protected $_adapter;

    public function __construct($config = array()) {
        if (!empty($config)) {
            $this->_initialize($config);
        }
    }

    private function _initialize($config) {
        $this->_adapter = $config['adapter'];
    }

    public function encode_id($id) {
        if (is_numeric($id)) {
            return str_replace('=', '', base64_encode($id));
        } else {
            return $id;
        }
    }

    public function decode_id($id) {
        if (is_numeric($id)) {
            return $id;
        } else {
            return (int) base64_decode($id);
        }
    }

    public function get_player($vid) {
        return $this->{$this->_adapter}->get_player($vid);
    }

    public function __get($child) {
        return parent::__get($child);
    }

    public function build_play_url($id) {
        return '/mv/play/' . $this->encode_id($id);
    }

    public function build_tag_url($tag) {
        return '/search/tag/' . urlencode($tag);
    }

    public function build_artist_url($artist) {
        return '/search/artist/' . urlencode($artist);
    }
    
    public function build_search_mv_url($keyword){
        return '/search/mv/' . urlencode($keyword);
    }

    public function format_tags($tags){
        $tag_str = '';
        $tags = explode(',', $tags);
        foreach($tags as $tag){
            $tag_str .= '<a href="' . $this->build_tag_url($tag) . '" title="' . $tag . '">' . $tag . '</a> ';
        }        
        return $tag_str;
    }
    
    public function get_cover_url($source, $cover){
        if($source == 1){
            return 'http://img1.ihdmv.com' . $cover;
        }elseif($source == 2){
            return str_replace('www.qiyipic.com', 'img2.ihdmv.com', $cover);
        }
    }

}

/* End of file Video.php */
/* Location: ./application/libraries/Video/Video.php */