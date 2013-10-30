<?php

function itask( $cmd_array )
{
    // eg: array(1) { [0]=> string(27) "SYSLOG_7 sunty@scpc.cc,19,0" }
    //var_dump($cmd_array);exit;
//    global $MYOA_TASK_ADDR;
//    global $MYOA_TASK_PORT;
//    global $MYOA_CHARSET;
//    $socket = socket_create( AF_INET, SOCK_DGRAM, SOL_UDP );
//    socket_set_option( $socket, SOL_SOCKET, SO_SNDTIMEO, array( "sec" => 10, "usec" => 0 ) );
//    socket_set_option( $socket, SOL_SOCKET, SO_RCVTIMEO, array( "sec" => 10, "usec" => 0 ) );
//    if ( @socket_connect( $socket, $MYOA_TASK_ADDR, $MYOA_TASK_PORT ) )
//    {
//    }
//    if ( !is_array( $cmd_array ) )
//    {
//        return FALSE;
//    }
//    $result = array( );
//    while ( list( $key, $cmd ) = each( &$cmd_array ) )
//    {
//        $bytes = @socket_write( $socket, $cmd, @strlen( $cmd ) );
//        if ( $bytes === FALSE )
//        {
//            return FALSE;
//        }
//        $data = @socket_read( $socket, 2048 );
//        if ( $data === FALSE )
//        {
//            return FALSE;
//        }
//        if ( strtoupper( bin2hex( substr( $data, 0, 3 ) ) ) == "EFBBBF" )
//        {
//            $result[$key] = iconv( "utf-8", $MYOA_CHARSET, substr( $data, 3 ) );
//        }
//        else
//        {
//            $result[$key] = iconv( "gbk", $MYOA_CHARSET, $data );
//        }
//    }
//    @socket_close( $socket );
    $result = '+OK';
    return $result;
}

function itask_last_error( )
{
    global $MYOA_OS_CHARSET;
    global $MYOA_CHARSET;
    $err_no = socket_last_error( );
    if ( $err_no == 10061 )
    {
        return _( "服务未启动或设置不正确" );
    }
    return iconv( 'gbk', $MYOA_CHARSET, socket_strerror( $err_no ) );
//    return socket_strerror( $err_no );
}

function itask_last_errno( )
{
    return socket_last_error( );
}

function imtask( $cmd )
{
    global $MYOA_TDIM_ADDR;
    global $MYOA_TDIM_PORT;
    $socket = socket_create( AF_INET, SOCK_DGRAM, SOL_UDP );
    $bytes = @socket_sendto( $socket, $cmd, @strlen( $cmd ), 0, $MYOA_TDIM_ADDR, $MYOA_TDIM_PORT );
    if ( $bytes === FALSE )
    {
        return FALSE;
    }
    @socket_close( $socket );
    return TRUE;
}

function imailtask( $cmd )
{
    global $MYOA_MAIL_ADDR;
    global $MYOA_MAIL_PORT;
    $socket = socket_create( AF_INET, SOCK_DGRAM, SOL_UDP );
    socket_set_option( $socket, SOL_SOCKET, SO_SNDTIMEO, array( "sec" => 10, "usec" => 0 ) );
    socket_set_option( $socket, SOL_SOCKET, SO_RCVTIMEO, array( "sec" => 10, "usec" => 0 ) );
    if ( !@socket_connect( $socket, $MYOA_MAIL_ADDR, $MYOA_MAIL_PORT ) )
    {
        return FALSE;
    }
    $bytes = @socket_write( $socket, $cmd, @strlen( $cmd ) );
    if ( $bytes === FALSE )
    {
        return FALSE;
    }
    $data = @socket_read( $socket, 1024 );
    if ( $data === FALSE )
    {
        return FALSE;
    }
    @socket_close( $socket );
    return $data;
}

function iIndexTask( $cmd )
{
    global $MYOA_INDEX_ADDR;
    global $MYOA_INDEX_PORT;
    $socket = socket_create( AF_INET, SOCK_DGRAM, SOL_UDP );
    socket_set_option( $socket, SOL_SOCKET, SO_SNDTIMEO, array( "sec" => 10, "usec" => 0 ) );
    socket_set_option( $socket, SOL_SOCKET, SO_RCVTIMEO, array( "sec" => 10, "usec" => 0 ) );
    if ( !@socket_connect( $socket, $MYOA_INDEX_ADDR, $MYOA_INDEX_PORT ) )
    {
        return FALSE;
    }
    $bytes = @socket_write( $socket, $cmd, @strlen( $cmd ) );
    if ( $bytes === FALSE )
    {
        return FALSE;
    }
    $data = "";
    while ( $read = @socket_read( $socket, 8092, PHP_BINARY_READ ) )
    {
        $data .= $read;
        if ( !( strlen( $read ) < 8092 ) )
        {
            continue;
        }
        break;
    }
    if ( $read === FALSE )
    {
        return FALSE;
    }
    @socket_close( $socket );
    return $data;
}


// file end