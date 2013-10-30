<?php
function sess_open( $save_path, $session_name )
{
    return TRUE;
}

function sess_close( )
{
    return TRUE;
}

function sess_read( $id )
{
    global $connection;
    global $MYSQL_DB;
    $query = "select SESS_DATA from ".$MYSQL_DB.".SESSION where SESS_ID='{$id}' and SESS_EXPIRES>=".time( );
    $cursor = exequery( $connection, $query );
    if ( $ROW = mysql_fetch_array( $cursor ) )
    {
        return $ROW['SESS_DATA'];
    }
    return "";
}

function sess_write( $id, $sess_data )
{
    global $connection;
    global $MYSQL_DB;
    global $MYOA_SESS_DATA_SIZE;
    $maxlifetime = intval( ini_get( "session.gc_maxlifetime" ) );
    $maxlifetime = 0 < $maxlifetime ? $maxlifetime : 36000;
    $sess_data = mysql_escape_string( $sess_data );
    $sess_data_size = strlen( $sess_data );
    if ( $MYOA_SESS_DATA_SIZE < $sess_data_size )
    {
        $sess_data_max_size = strtolower( ini_get( "default_charset" ) ) == "utf-8" ? 21800 : 32700;
        if ( $sess_data_max_size < $sess_data_size )
        {
            $sess_data_size = $sess_data_max_size;
        }
        $query = "select SESS_DATA from ".$MYSQL_DB.".SESSION limit 0,1";
        $cursor = exequery( $connection, $query );
        $field_size = mysql_field_len( $cursor, 0 );
        $field_size = strtolower( ini_get( "default_charset" ) ) == "utf-8" ? floor( $field_size / 3 ) : floor( $field_size / 2 );
        if ( $field_size < $sess_data_size )
        {
            $query = "alter table ".$MYSQL_DB.".SESSION change SESS_DATA SESS_DATA varchar(".$sess_data_size.") not null;";
            exequery( $connection, $query );
        }
    }
    $query = "select 1 from ".$MYSQL_DB.".SESSION where SESS_ID='{$id}'";
    $cursor = exequery( $connection, $query );
    if ( $ROW = mysql_fetch_array( $cursor ) )
    {
        $query = "update ".$MYSQL_DB.".SESSION set SESS_EXPIRES='".( time( ) + $maxlifetime ).( "',SESS_DATA='".$sess_data."' where SESS_ID='{$id}';" );
        return exequery( $connection, $query );
    }
    $query = "insert into ".$MYSQL_DB.".SESSION (SESS_ID,SESS_EXPIRES,SESS_DATA) values ('{$id}','".( time( ) + $maxlifetime ).( "','".$sess_data."');" );
    return exequery( $connection, $query );
}

function sess_destroy( $id )
{
    global $connection;
    global $MYSQL_DB;
    $query = "delete from ".$MYSQL_DB.".SESSION where SESS_ID='{$id}'";
    return exequery( $connection, $query );
}

function sess_gc( $maxlifetime )
{
    global $connection;
    global $MYSQL_DB;
    $query = "delete from ".$MYSQL_DB.".SESSION where SESS_EXPIRES<".time( );
    return exequery( $connection, $query );
}

include_once( "inc/conn.php" );
// 设置缓存方法
if ( $MYOA_SESS_SAVE_HANDLER == "user" && session_module_name( ) != "user" ){
    session_module_name( "user" );
    session_set_save_handler( "sess_open", "sess_close", "sess_read", "sess_write", "sess_destroy", "sess_gc" );
}else if ( $MYOA_SESS_SAVE_HANDLER == "memcache" && session_module_name( ) != "memcache" ){
    session_module_name( "memcache" );
    session_save_path( $MYOA_SESS_SAVE_PATH );
}

if ( stristr( $_SERVER["PHP_SELF"], "export" ) || stristr( $_SERVER["PHP_SELF"], "excel" ) || stristr( $_SERVER["PHP_SELF"], "word" ) || stristr( $_SERVER["PHP_SELF"], "attach.php" ) || stristr( $_SERVER["PHP_SELF"], "download.php" ) || stristr( $_SERVER["PHP_SELF"], "down.php" ) )
{
    session_cache_limiter( "private, must-revalidate" );
}
// session_start 移到这里。在其它文件中只要include session.php，就可以启动session.
// 一般来说，程序只会include auth.php，而auth.php已经include了session.php。所以移到这里比较清楚一点。
session_start( );

// END FILE
// LOCATION: /webroot/inc/session.php