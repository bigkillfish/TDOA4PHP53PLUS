<?php

function Message( $TITLE, $CONTENT, $STYLE = "", $BUTTONS = array( ) )
{
    $WIDTH = strlen( $CONTENT ) * 15 + 140;
    $WIDTH = 500 < $WIDTH ? 500 : $WIDTH;
    if ( $STYLE == "blank" )
    {
        $WIDTH -= 70;
    }
    if ( $STYLE == "" )
    {
        if ( $TITLE == _( "错误" ) )
        {
            $STYLE = "error";
        }
        else if ( $TITLE == _( "警告" ) )
        {
            $STYLE = "warning";
        }
        else if ( $TITLE == _( "停止" ) )
        {
            $STYLE = "stop";
        }
        else if ( $TITLE == _( "禁止" ) )
        {
            $STYLE = "forbidden";
        }
        else if ( $TITLE == _( "帮助" ) )
        {
            $STYLE = "help";
        }
        else
        {
            $STYLE = "info";
        }
    }
    echo "<table class=\"MessageBox\" align=\"center\" width=\"";
    echo $WIDTH;
    echo "\">\r\n";
    if ( $TITLE != "" )
    {
        echo "   <tr class=\"head\">\r\n      <td class=\"left\"></td>\r\n      <td class=\"center\">\r\n         <div class=\"title\">";
        echo $TITLE;
        echo "</div>\r\n      </td>\r\n      <td class=\"right\"></td>\r\n   </tr>\r\n";
    }
    else
    {
        echo "   <tr class=\"head-no-title\">\r\n      <td class=\"left\"></td>\r\n      <td class=\"center\">\r\n      </td>\r\n      <td class=\"right\"></td>\r\n   </tr>\r\n";
    }
    echo "   <tr class=\"msg\">\r\n      <td class=\"left\"></td>\r\n      <td class=\"center ";
    echo $STYLE;
    echo "\">\r\n         <div class=\"msg-content\">";
    echo $CONTENT;
    echo "</div>\r\n      </td>\r\n      <td class=\"right\"></td>\r\n   </tr>\r\n";
    if ( is_array( $BUTTONS ) && 0 < count( $BUTTONS ) )
    {
        echo "   <tr class=\"control\">\r\n      <td class=\"left\"></td>\r\n      <td class=\"center\">\r\n";
        foreach ( $BUTTONS as $BUTTON )
        {
            echo "<a class=\"BigBtn\" href=\"".( $BUTTON['href'] != "" ? str_replace( "\"", "\\\"", $BUTTON['href'] ) : "javascript:;" )."\"";
            if ( $BUTTON['click'] != "" )
            {
                echo " onclick=\"".str_replace( "\"", "\\\"", $BUTTON['click'] )."\"";
            }
            echo "><span>".$BUTTON['value']."</span></a>&nbsp;&nbsp;";
        }
        echo "      </td>\r\n      <td class=\"right\"></td>\r\n   </tr>\r\n";
    }
    echo "   <tr class=\"foot\">\r\n      <td class=\"left\"></td>\r\n      <td class=\"center\"></td>\r\n      <td class=\"right\"></td>\r\n   </tr>\r\n</table>\r\n";
}




function find_id( $STRING, $ID )
{
    $STRING = ltrim( $STRING, "," );
    if ( $ID == "" || $ID == "," )
    {
        return FALSE;
    }
    if ( substr( $STRING, -1 ) != "," )
    {
        $STRING .= ",";
    }
    if ( 0 < strpos( $STRING, ",".$ID."," ) )
    {
        return TRUE;
    }
    if ( strpos( $STRING, $ID."," ) === 0 )
    {
        return TRUE;
    }
    if ( !strstr( $ID, "," ) || $STRING == $ID )
    {
        return TRUE;
    }
    return FALSE;
}

function find_id_plus( $mixstr, $ID, $septor )
{
    if ( $ID == "" || $ID == "," )
    {
        return FALSE;
    }
    $arr_string = explode( $septor, $mixstr );
    $STRING = "";
    foreach ( $arr_string as $k => $v )
    {
        $v = ltrim( $v, "," );
        if ( substr( $v, -1 ) != "," )
        {
            $v .= ",";
        }
        $STRING .= $v;
    }
    if ( substr( $STRING, -1 ) != "," )
    {
        $STRING .= ",";
    }
    if ( 0 < strpos( $STRING, ",".$ID."," ) )
    {
        return TRUE;
    }
    if ( strpos( $STRING, $ID."," ) === 0 )
    {
        return TRUE;
    }
    if ( !strstr( $ID, "," ) || $STRING == $ID )
    {
        return TRUE;
    }
    return FALSE;
}

function check_id( $STRING, $ID, $FLAG = TRUE )
{
    $MY_ARRAY = explode( ",", $ID );
    $ARRAY_COUNT = sizeof( $MY_ARRAY );
    if ( $MY_ARRAY[$ARRAY_COUNT - 1] == "" )
    {
        --$ARRAY_COUNT;
    }
    $I = 0;
    for ( ; $I < $ARRAY_COUNT; ++$I )
    {
        if ( $FLAG )
        {
            if ( find_id( $STRING, $MY_ARRAY[$I] ) )
            {
                $ID_STR .= $MY_ARRAY[$I].",";
            }
        }
        else if ( !find_id( $STRING, $MY_ARRAY[$I] ) )
        {
            $ID_STR .= $MY_ARRAY[$I].",";
        }
    }
    return $ID_STR;
}

function update_my_online_status( $SID_UPD, $CLIENT = 0 )
{
    global $connection;
    global $LOGIN_UID;
    $query = "update USER_ONLINE set TIME='".time( )."',CLIENT='".$CLIENT."' ";
    if ( $SID_UPD )
    {
        $query .= ",SID='".session_id( )."' ";
    }
    $query .= " where UID='".$LOGIN_UID."'";
    exequery( $connection, $query );
    if ( mysql_affected_rows( ) == 0 )
    {
        $query = "insert into USER_ONLINE values('".$LOGIN_UID."','".time( )."','".session_id( )."','".$CLIENT."')";
        exequery( $connection, $query );
    }
}

function clear_online_status( )
{
    global $connection;
    global $ONLINE_REF_SEC;
    global $SYS_DEPARTMENT;
    if ( !is_array( $SYS_DEPARTMENT ) )
    {
        include_once( "inc/department.php" );
    }
    $query = "delete from USER_ONLINE where TIME<".( time( ) - $ONLINE_REF_SEC - 10 );
    $cursor = exequery( $connection, $query );
    $DEPT_ID_STR = "";
    $query = ( "select USER.UID,USER_ID,USER_NAME,DEPT_ID,DEPT_ID_OTHER,SEX,ON_STATUS,USER.USER_PRIV,PRIV_NO,CLIENT from USER,USER_ONLINE,USER_PRIV where USER_ONLINE.TIME>=".( time( ) - $ONLINE_REF_SEC - 10 ) )." and USER.UID=USER_ONLINE.UID and USER.USER_PRIV=USER_PRIV.USER_PRIV and USER.DEPT_ID!=0 order by PRIV_NO,USER_NO,USER_NAME";
    $cursor = exequery( $connection, $query );
    while ( $ROW = mysql_fetch_array( $cursor ) )
    {
        $UID = $ROW['UID'];
        $USER_ID = $ROW['USER_ID'];
        $USER_NAME = $ROW['USER_NAME'];
        $SEX = $ROW['SEX'];
        $ON_STATUS = $ROW['ON_STATUS'];
        $DEPT_ID = $ROW['DEPT_ID'];
        $DEPT_ID_OTHER = $ROW['DEPT_ID_OTHER'];
        $USER_PRIV = $ROW['USER_PRIV'];
        $PRIV_NO = $ROW['PRIV_NO'];
        $CLIENT = $ROW['CLIENT'];
        $SEX = $SEX == "" ? "0" : $SEX;
        $ON_STATUS = $ON_STATUS != "2" && $ON_STATUS != "3" ? "1" : $ON_STATUS;
        $USER_STR .= "   \"".$UID."\"=> array(\"USER_ID\" => \"".$USER_ID."\", \"USER_NAME\" => \"".$USER_NAME."\", \"DEPT_ID\" => \"".$DEPT_ID."\", \"DEPT_ID_OTHER\" => \"".$DEPT_ID_OTHER."\", \"SEX\" => \"".$SEX."\", \"ON_STATUS\" => \"".$ON_STATUS."\", \"USER_PRIV\" => \"".$USER_PRIV."\", \"PRIV_NO\" => \"".$PRIV_NO."\", \"CLIENT\" => \"".$CLIENT."\"),\n";
        $DEPT_ID_ALL = $DEPT_ID.",".$DEPT_ID_OTHER;
        $DEPT_ID_ARRAY = explode( ",", $DEPT_ID_ALL );
        $I = 0;
        for ( ; $I < count( $DEPT_ID_ARRAY ); ++$I )
        {
            $DEPT_ID = $DEPT_ID_ARRAY[$I];
            while ( $DEPT_ID == "" || !( 0 < $DEPT_ID ) && find_id( $DEPT_ID_STR, $DEPT_ID ) )
            {
                if ( !array_key_exists( $DEPT_ID, $SYS_DEPARTMENT ) )
                {
                    @include_once( "inc/utility_org.php" );
                    cache_department( );
                }
                $DEPT_ID_STR .= $DEPT_ID.",";
                $DEPT_ID = $SYS_DEPARTMENT[$DEPT_ID]['DEPT_PARENT'];
            }
        }
    }
    while ( list( $DEPT_ID, $DEPT ) = each( $SYS_DEPARTMENT ) )
    {
        if ( find_id( $DEPT_ID_STR, $DEPT_ID ) )
        {
            $DEPT_STR .= "   \"".$DEPT_ID."\"=> array(\"DEPT_NAME\" => \"".$DEPT['DEPT_NAME']."\", \"DEPT_PARENT\" => \"".$DEPT['DEPT_PARENT']."\", \"DEPT_LONG_NAME\" => \"".$DEPT['DEPT_LONG_NAME']."\", \"IS_ORG\" => \"".$DEPT['IS_ORG']."\"),\n";
        }
    }
    $USER_ARRAY = "\$SYS_ONLINE_USER = array(\n".$USER_STR.");";
    $DEPT_ARRAY = "\$SYS_ONLINE_DEPT = array(\n".$DEPT_STR.");";
    global $td_cache;
    global $SYS_ONLINE_USER;
    global $SYS_ONLINE_DEPT;
    eval( $USER_ARRAY );
    eval( $DEPT_ARRAY );
    include_once( "inc/cache/Cache.php" );
    $td_cache->set( "SYS_ONLINE_USER", $SYS_ONLINE_USER, $ONLINE_REF_SEC + 10 );
    $td_cache->set( "SYS_ONLINE_DEPT", $SYS_ONLINE_DEPT, $ONLINE_REF_SEC + 10 );
}

function cache_menu( )
{
    $LANG_ARRAY = get_lang_array( );
    $CACHE_ARRAY = array( );
    global $connection;
    global $ROOT_PATH;
    $query = "SELECT * from SYS_MENU order by MENU_ID";
    $cursor = exequery( $connection, $query );
    while ( $ROW = mysql_fetch_array( $cursor ) )
    {
        $MENU_NAME = str_replace( array( "\"", "\\", "'" ), array( "", "/", "" ), $ROW['MENU_NAME'] );
        $IMAGE = str_replace( array( "\"", "\\", "'" ), array( "", "/", "" ), $ROW['IMAGE'] );
        $MENU_EXT = unserialize( $ROW['MENU_EXT'] );
        reset( $LANG_ARRAY );
        foreach ( $LANG_ARRAY as $LANG => $VALUE )
        {
            if ( is_array( $MENU_EXT ) && $MENU_EXT[$LANG] != "" )
            {
                $MENU_NAME_SHOW = $MENU_EXT[$LANG];
            }
            else
            {
                $MENU_NAME_SHOW = $MENU_NAME;
            }
            $CACHE_ARRAY[$LANG]['cache2'] .= "   \"m".$ROW['MENU_ID']."\" => array(\"MENU_ID\" => \"".$ROW['MENU_ID']."\", \"FUNC_NAME\" => \"".$MENU_NAME_SHOW."\", \"IMAGE\" => \"".$ROW['IMAGE']."\"),\n";
            $CACHE_ARRAY[$LANG]['cache3'] .= "func_array[\"m".$ROW['MENU_ID']."\"]=[\"".$MENU_NAME_SHOW."\",\"".$IMAGE."\"];\n";
        }
        $query = "SELECT * from SYS_FUNCTION where MENU_ID like '".$ROW['MENU_ID']."%' order by MENU_ID";
        $cursor1 = exequery( $connection, $query );
        while ( $ROW = mysql_fetch_array( $cursor1 ) )
        {
            $FUNC_NAME = str_replace( array( "\"", "\\", "'" ), array( "", "/", "" ), $ROW['FUNC_NAME'] );
            $FUNC_CODE = str_replace( array( "\"", "\\", "'" ), array( "", "/", "" ), $ROW['FUNC_CODE'] );
            $FUNC_EXT = unserialize( $ROW['FUNC_EXT'] );
            $OPEN_WINDOW = substr( $FUNC_CODE, 0, 2 ) == "1:" ? 1 : 0;
            $FUNC_CODE = substr( $FUNC_CODE, 0, 2 ) == "1:" ? substr( $FUNC_CODE, 2 ) : $FUNC_CODE;
            if ( 10000 <= $ROW['FUNC_ID'] && $ROW['FUNC_ID'] <= 20000 )
            {
                $IMAGE = "fis";
            }
            else if ( stristr( $FUNC_CODE, "http://" ) )
            {
                $IMAGE = "menu_url";
            }
            else if ( stristr( $FUNC_CODE, "file://" ) )
            {
                $IMAGE = "winexe";
            }
            else if ( stristr( $FUNC_CODE, "/" ) )
            {
                $IMAGE = substr( $FUNC_CODE, 0, strpos( $FUNC_CODE, "/" ) );
            }
            else
            {
                $IMAGE = $FUNC_CODE;
            }
            reset( $LANG_ARRAY );
            foreach ( $LANG_ARRAY as $LANG => $VALUE )
            {
                if ( is_array( $FUNC_EXT ) && $FUNC_EXT[$LANG] != "" )
                {
                    $FUNC_NAME_SHOW = $FUNC_EXT[$LANG];
                }
                else
                {
                    $FUNC_NAME_SHOW = $FUNC_NAME;
                }
                $CACHE_ARRAY[$LANG]['cache1'] .= "   \"".$ROW['FUNC_ID']."\" => \"".$FUNC_CODE."\",\n";
                $CACHE_ARRAY[$LANG]['cache2'] .= "   \"".$ROW['FUNC_ID']."\" => array(\"FUNC_ID\" => \"".$ROW['FUNC_ID']."\", \"MENU_ID\" => \"".$ROW['MENU_ID']."\", \"FUNC_NAME\" => \"".$FUNC_NAME_SHOW."\", \"FUNC_CODE\" => \"".$FUNC_CODE."\", \"IMAGE\" => \"".$IMAGE."\"";
                $CACHE_ARRAY[$LANG]['cache3'] .= "func_array[\"f".$ROW['FUNC_ID']."\"]=[\"".$FUNC_NAME_SHOW."\",\"".$FUNC_CODE."\",\"".$IMAGE."\"";
                if ( $OPEN_WINDOW )
                {
                    $CACHE_ARRAY[$LANG]['cache2'] .= ", \"OPEN_WINDOW\" => ".$OPEN_WINDOW;
                    $CACHE_ARRAY[$LANG]['cache3'] .= ",\"".$OPEN_WINDOW."\"";
                }
                $CACHE_ARRAY[$LANG]['cache2'] .= "),\n";
                $CACHE_ARRAY[$LANG]['cache3'] .= "];\n";
            }
        }
    }
    global $td_cache;
    include_once( "inc/cache/Cache.php" );
    foreach ( $CACHE_ARRAY as $LANG => $VALUE )
    {
        $name1 = "SYS_FUNCTION_".bin2hex( $LANG );
        $name2 = "SYS_FUNCTION_ALL_".bin2hex( $LANG );
        $cache1 = "\$".$name1." = array(\n".substr( $CACHE_ARRAY[$LANG]['cache1'], 0, -2 )."\n);";
        $cache2 = "\$".$name2." = array(\n".substr( $CACHE_ARRAY[$LANG]['cache2'], 0, -2 )."\n);";
        eval( $cache1 );
        eval( $cache2 );
        $td_cache->set( $name1, $$name1, 0 );
        $td_cache->set( $name2, $$name2, 0 );
        $cache3 = "var func_array=[];\n".$CACHE_ARRAY[$LANG]['cache3'];
        $cache_file3 = $ROOT_PATH."inc/sys_function_".bin2hex( $LANG ).".js";
        if ( file_exists( $cache_file3 ) && !is_writable( $cache_file3 ) )
        {
            file_put_contents( $cache_file3, $cache3 );
        }
    }
}

function get_lang_array( )
{
    global $ROOT_PATH;
    global $MYOA_IS_UN;
    $LANG_ARRAY = array(
        "zh-CN" => _( "简体中文" )
    );
    $LANG_FILE = $ROOT_PATH."lang/language.ini";
    if ( $MYOA_IS_UN != 1 || !file_exists( $LANG_FILE ) )
    {
        return $LANG_ARRAY;
    }
    $ARRAY = parse_ini_file( $LANG_FILE );
    foreach ( $ARRAY as $LANG => $LANG_DESC )
    {
        $LANG = trim( $LANG );
        $LANG_DESC = trim( $LANG_DESC );
        if ( !array_key_exists( $LANG, $LANG_ARRAY ) )
        {
            $LANG_ARRAY[$LANG] = $LANG_DESC;
        }
    }
    return $LANG_ARRAY;
}

function iask( $FUNC, $IASK_SMALL = 0 )
{
    global $IASK_YN;
    if ( !$IASK_YN )
    {
        return;
    }
    if ( $IASK_SMALL )
    {
        $IMG_STR = "iask_small.png";
    }
    else
    {
        $IMG_STR = "iask.png";
    }
    return "<span class=\"small\" style=\"cursor:hand;\" title=\""._( "点击打开操作提示与技巧窗口" )."\" onclick=\"javascript:window.open('/module/iask?FUNC=".$FUNC."','iask','top=0,left=0,width=600,height=500,status=1,toolbar=no,menubar=no,location=no,scrollbars=yes,resizable=yes')\">&nbsp;<img src=\"/images/".$IMG_STR."\" align=\"absmiddle\"></span>";
}

function new_sms_remind( $UID, $REMIND = 1, $TYPE = 0 )
{
    global $ATTACH_PATH;
    if ( !file_exists( $ATTACH_PATH."new_sms" ) )
    {
        mkdir( $ATTACH_PATH."new_sms", 448 );
    }
    $SMS_FILE = $ATTACH_PATH."new_sms/".$UID.".sms";
    if ( !file_exists( $SMS_FILE ) )
    {
        file_put_contents( $SMS_FILE, "00" );
    }
    $fp = fopen( $SMS_FILE, "r+" );
    if ( $fp )
    {
        $DATA = fread( $fp, 2 );
        $REMIND_1 = intval( substr( $DATA, 0, 1 ) );
        $REMIND_2 = intval( substr( $DATA, 1, 1 ) );
        if ( $TYPE == 0 )
        {
            $DATA_NEW = sprintf( "%d%d", $REMIND, $REMIND_2 );
        }
        else
        {
            $DATA_NEW = sprintf( "%d%d", $REMIND_1, $REMIND );
        }
        if ( $DATA != $DATA_NEW )
        {
            fseek( $fp, 0 );
            fwrite( $fp, $DATA_NEW );
        }
        fclose( $fp );
    }
    return $DATA_NEW;
}

function td_trim( $STR, $charlist = " ,\t\n\r\x00\x0B" )
{
    return trim( $STR, $charlist );
}

function is_default_charset( $str )
{
    $str_utf8 = iconv( ini_get( "default_charset" ), "utf-8", $str );
    $str_default = iconv( "utf-8", ini_get( "default_charset" ), $str_utf8 );
    return $str_default == $str;
}

function get_attachment_filename( $filename )
{
    global $MYOA_CHARSET;
    global $MYOA_IS_UN;
    $filename_utf8 = iconv( $MYOA_CHARSET, "utf-8", $filename );
    $filename_encoded = str_replace( "+", "%20", urlencode( $filename_utf8 ) );
    if ( preg_match( "/MSIE/", $_SERVER['HTTP_USER_AGENT'] ) )
    {
        if ( $MYOA_IS_UN )
        {
            return "filename=\"".$filename_encoded."\"";
        }
        return "filename=\"".$filename."\"";
    }
    if ( preg_match( "/Firefox/", $_SERVER['HTTP_USER_AGENT'] ) )
    {
        return "filename*=\"utf8''".$filename_utf8."\"";
    }
    return "filename=\"".$filename_utf8."\"";
}

function get_client_ip( )
{
    $ip = $_SERVER['REMOTE_ADDR'];
    if ( isset( $_SERVER['HTTP_CLIENT_IP'] ) && preg_match( "/^([0-9]{1,3}\\.){3}[0-9]{1,3}\$/", $_SERVER['HTTP_CLIENT_IP'] ) )
    {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
        return $ip;
    }
    if ( isset( $_SERVER['HTTP_X_FORWARDED_FOR'] ) && preg_match_all( "#\\d{1,3}\\.\\d{1,3}\\.\\d{1,3}\\.\\d{1,3}#s", $_SERVER['HTTP_X_FORWARDED_FOR'], $matches ) )
    {
        foreach ( $matches[0] as $xip )
        {
            if ( !( $xip != "127.0.0.1" ) )
            {
                continue;
            }
            $ip = $xip;
            break;
        }
    }
    return $ip;
}


?>
