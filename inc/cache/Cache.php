<?php
class TD_Cache{

    public function TD_Cache( $config = NULL ){
        $this->_diver = new TD_Cache_Driver( $config );
    }

    public function get( $id ){
        return $this->_diver->get( $id );
    }

    public function set( $id, $data, $ttl = 60 ){
        return $this->_diver->set( $id, $data, $ttl );
    }

    public function delete( $id ){
        return $this->_diver->delete( $id );
    }

    public function clean( ){
        return $this->_diver->clean( );
    }

    public function get_metadata( $id ){
        return $this->_diver->get_metadata( $id );
    }

}

global $MYOA_CACHE_DRIVER;
if ( !isset( $MYOA_CACHE_DRIVER ) ){
    $MYOA_CACHE_DRIVER = "files";
}
include_once( "inc/td_config.php" );
include_once( "inc/cache/Cache_".$MYOA_CACHE_DRIVER.".php" );
global $td_cache;
global $MYOA_CACHE_CONFIG;
if ( !is_a( $td_cache, "TD_Cache" ) ){
    $td_cache = new TD_Cache( $MYOA_CACHE_CONFIG );
}

// END FILE