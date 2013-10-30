<?php

function itask( $cmd_array ){
    global $connection;
    if ( !is_array( $cmd_array ) )
    {
        return FALSE;
    }
    $result = array();
//    while ( list( $key, $value ) = each( &$cmd_array ) )
//    {
//        $pos = stripos( $value, " " );
//        $cmd = substr( $value, 0, $pos );
//        $para = substr( $value, $pos + 1 );
//        if ( $cmd == "LOG_6" || $cmd == "LOG_7" )
//        {
//            $para_array = explode( ",", $para );
//            $sql = "update USER set DEPT_ID='".$para_array[1]."',NOT_LOGIN='".$para_array[2]."' where USER_ID='".$para_array[0]."';";
//            $cursor = exequery( $connection, $sql );
//        }
//        else if ( $cmd == "LOG_3" || $cmd == "LOG_4" )
//        {
//            $para_array = explode( ",", $para );
//            $sql = "update DEPARTMENT set DEPT_PARENT='".$para_array[1]."' where DEPT_ID='".$para_array[0]."';";
//            $cursor = exequery( $connection, $sql );
//        }
//        else if ( $cmd == "FILE_SORT_UPD" )
//        {
//            $para_array = explode( "@^@", $para );
//            $sql = "update FILE_SORT set ".$para_array[1]." where SORT_ID='".$para_array[0]."';";
//            $cursor = exequery( $connection, $sql );
//        }
//        else if ( $cmd == "USER_PRIV_UPD" )
//        {
//            $para_array = explode( ",", $para );
//            $sql = "update USER_PRIV set PRIV_NO='".$para_array[1]."' where USER_PRIV='".$para_array[0]."';";
//            $cursor = exequery( $connection, $sql );
//        }
//        else if ( $cmd == "INTERFACE_UPD" )
//        {
//            $para_array = explode( ",", $para );
//            $sql = "update INTERFACE set IE_TITLE='".$para_array[0]."';";
//            $cursor = exequery( $connection, $sql );
//        }
//        else if ( $cmd == "RSA_KEYPAIR" )
//        {
//            $cursor = TRUE;
//        }
//        else if ( $cmd == "REGISTER" )
//        {
//            $cursor = TRUE;
//        }
//        else if ( $cmd == "RELOAD_ALL_TASK" || $cmd == "RELOAD_TASK" || $cmd == "RELOAD_EXTUSER" )
//        {
//            $cursor = TRUE;
//        }
//        else if ( $cmd == "TASK_FIND" )
//        {
//            $cursor = TRUE;
//        }
//        if ( $cursor === FALSE )
//        {
//            $result[$key] = _( "更新数据库错误(".$cmd.")" );
//        }
//    }
    return $result;
}

function itask_last_error( ){
    return "";
}

function itask_last_errno( ){
    return 0;
}

