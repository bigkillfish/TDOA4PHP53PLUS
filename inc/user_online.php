<?php
/**
 * 用来维护在线用户信息
 */
global $td_cache;
global $SYS_ONLINE_USER;
global $SYS_ONLINE_DEPT;
if ( is_array( $SYS_ONLINE_USER ) ){
}
if ( !is_array( $SYS_ONLINE_DEPT ) ){
    include_once( "inc/cache/Cache.php" );
    $SYS_ONLINE_USER = $td_cache->get( "SYS_ONLINE_USER" );
    $SYS_ONLINE_DEPT = $td_cache->get( "SYS_ONLINE_DEPT" );
    if ( is_array( $SYS_ONLINE_USER ) ){
    }
    if ( !is_array( $SYS_ONLINE_DEPT ) ){
        include_once( "inc/utility.php" );
        clear_online_status( );
    }
}

