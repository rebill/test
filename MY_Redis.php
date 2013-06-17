<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Redis {

    /**
     * CI
     *
     * CodeIgniter instance
     * @var 	object
     */
    private $_ci;    // CodeIgniter instance

    /**
     * Connection
     *
     * Socket handle to the Redis server
     * @var		handle
     */
    private $_redis;  // Connection handle


    /**
     * Constructor
     */
    public function __construct() {

        // Get a CI instance
        $this->_ci = & get_instance();

        // Load config
        $this->_ci->load->config('redis');
        
        // Connect to Redis
        $this->_redis = new Redis();        
        $this->_redis->pconnect($this->_ci->config->item('redis_host'), $this->_ci->config->item('redis_port'));
        $this->_redis->select($this->_ci->config->item('redis_db'));
    }
    
    public function update_views($table, $key, $views=1){
        $this->_redis->hIncrBy($table, $key, $views);
    }
    
    public function get_keys($table){
        return $this->_redis->hKeys($table);
    }
    
    public function get_all($table){
        return $this->_redis->hGetAll($table);
    }
    
    public function del_key($table, $key){
        return $this->_redis->hDel($table, $key);
    }

}