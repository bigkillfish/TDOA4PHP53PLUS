<?php

class TD_Cache_Driver{

    private $_memcached = NULL;
    protected $_memcache_conf = array(
        "default" => array(
            "default_host" => "127.0.0.1",
            "default_port" => 11211,
            "default_persistent" => FALSE,
            "default_weight" => 1
        )
    );

    public function TD_Cache_Driver( $config = NULL ){
        if ( is_array( $config ) ){
            foreach ( $config as $name => $conf ){
                $this->_memcache_conf[$name] = $conf;
            }
        }
//        ( );
        $this->_memcached = new Memcache( );
        foreach ( $this->_memcache_conf as $name => $cache_server ){
            if ( !array_key_exists( "hostname", $cache_server ) ){
                $cache_server['hostname'] = $this->_memcache_conf[$name]['default_host'];
            }
            if ( !array_key_exists( "port", $cache_server ) ){
                $cache_server['port'] = $this->_memcache_conf[$name]['default_port'];
            }
            if ( !array_key_exists( "persistent", $cache_server ) ){
                $cache_server['persistent'] = $this->_memcache_conf[$name]['default_persistent'];
            }
            if ( !array_key_exists( "weight", $cache_server ) ){
                $cache_server['weight'] = $this->_memcache_conf[$name]['default_weight'];
            }
            $this->_memcached->addServer( $cache_server['hostname'], $cache_server['port'], $cache_server['persistent'], $cache_server['weight'] );
        }
    }

    public function get( $id ){
        $data = $this->_memcached->get( $id );
        if ( is_array( $data ) ){
            return $data[0];
        }
        return FALSE;
    }

    public function set( $id, $data, $ttl = 60 ){
        return $this->_memcached->set( $id, array(
            $data,
            time( ),
            $ttl
        ), 0, $ttl );
    }

    public function delete( $id ){
        return $this->_memcached->delete( $id );
    }

    public function clean( ){
        return $this->_memcached->flush( );
    }

    public function get_metadata( $id ){
        $stored = $this->_memcached->get( $id );
        if ( count( $stored ) !== 3 ){
            return FALSE;
        }
        list( $data, $time, $ttl ) = $stored;
        return array(
            "expire" => $time + $ttl,
            "mtime" => $time,
            "data" => $data
        );
    }

}

?>
