<?php
function tdoa_ver_info( ){
    global $connection;
    global $VERSION_INFO;
    global $VERSION_EA;
    global $TD_SN_INFO;
    global $TD_CODE_INFO;
    global $TD_UNIT_INFO;
    global $TD_TRAIL_EXPIRE;
    global $TD_MYOA_VERSION;
    // 获取系统版本号信息
    $query = "select * from VERSION";
    $cursor = exequery( $connection, $query );
    if ( $ROW = mysql_fetch_array( $cursor ) )
    {
        $VERSION_INFO = $ROW['VER'];
        $VERSION_EA = $ROW['EA'];
        $TD_SN_INFO = $ROW['SN'];
        $TD_CODE_INFO = $ROW['CODE'];
        if ( $TD_SN_INFO == "" && $TD_CODE_INFO != "" )
        {
            $query = "update VERSION set CODE=''";
            exequery( $connection, $query );
        }
    }
    else
    {
        // 没有就插入一条记录
        $query = "insert into VERSION (VER,EA,SN,CODE) values ('".$TD_MYOA_VERSION."', '2.0.060101', '', '')";
        exequery( $connection, $query );
    }
    // 获取单位信息
    $query = "SELECT * from UNIT";
    $cursor = exequery( $connection, $query );
    if ( $ROW = mysql_fetch_array( $cursor ) )
    {
        $TD_UNIT_INFO = $ROW['UNIT_NAME'];
    }
    // 获取试用期信息
    $query = "SELECT PARA_VALUE from SYS_PARA where PARA_NAME='TRAIL_EXPRIE'";
    $cursor = exequery( $connection, $query );
    if ( $ROW = mysql_fetch_array( $cursor ) )
    {
        $TD_TRAIL_EXPIRE = $ROW['PARA_VALUE'];
    }
    // 为毛是1980年4月22日呢?
    // 如果是这个日期，就更新一下试用期,当前时间加上一年。776000应该是一年吧。
    if ( $TD_TRAIL_EXPIRE == "1980-04-22" )
    {
        $TD_TRAIL_EXPIRE = date( "Y-m-d", time( ) + 7776000 );
        $query = "update SYS_PARA set PARA_VALUE='".$TD_TRAIL_EXPIRE."'  where PARA_NAME='TRAIL_EXPRIE';";
        $cursor = exequery( $connection, $query );
    }
}

include_once( "inc/conn.php" );
include_once( "inc/rsa/rsa.php" );
include_once( "inc/itask/itask.php" );
// 在这里调用，注释掉就行了。
// 如果把上面的函数改改就可以无限期试用了。呵呵
//tdoa_ver_info( );

