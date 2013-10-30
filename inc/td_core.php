<?php
function login_check( $USERNAME, $PASSWORD, $KEY_DIGEST = "", $KEY_SN = "", $KEY_USER = "", $IS_FROMPDA = "" ){
    if(trim($PASSWORD)==''){
        $PASSWORD="";
    }
    global $ROOT_PATH;
    global $connection;
    global $ATTACH_PATH;
    global $ONLINE_REF_SEC;
    global $ONE_USER_MUL_LOGIN;
    global $MYOA_LOGIN_TIME_RANGE;

    // 用户名密码不相等,且密码不等于某些特殊内容
    if(!($USERNAME==$PASSWORD &&($PASSWORD=="[TDCORE_REGCHECK]"||$PASSWORD=="[TDCORE_ADDUSER]"||$PASSWORD=="[TDCORE_REGREG]"||$PASSWORD=="[TDCORE_OPTIONAL]"||$PASSWORD=="[TDCORE_VIEWUSER]"||$PASSWORD=="[TDCORE_REGCHECK_AUTO]"))){

        // 用户名不能为空，
        // TODO $KEY_USER可以删掉了。现在不用USB KEY
        if($USERNAME=="" && $KEY_USER==""){
            return "用户名不能为空!";
        }

        // 为毛要在这里session_start ?
        session_start();
        ob_start();

        // inc下没有login.php文件。
        // 不过可以自己建一个，自定义用户登录验证过程。
        if(file_exists("{$ROOT_PATH}/inc/login.php")){
            // TODO 自定义用户登录验证
            //include_once("inc/login.php");
            //return $LOGIN_RESULT;
        }
        // 只有管理员不受登录时间限制
        if($USERNAME != "admin" && !check_time_range($MYOA_LOGIN_TIME_RANGE)){
            return "当前时间禁止登录";
        }

        // key_ckeck.php包含两个函数
        // DigestComp($ClientDigest, $RandomData, $Password)
        // hexstr2array( $HexStr )
        include_once("inc/key_check.php");
        // utility_var 包含一个字符串
        // $KEY_TD_SIGN = "C2C238A0";
        include_once("inc/utility_var.php");

        // 得到用户的IP
        $USER_IP = get_client_ip();
        $PARA_ARRAY = get_sys_para( "SEC_PASS_FLAG,SEC_PASS_TIME,SEC_RETRY_BAN,SEC_RETRY_TIMES,SEC_BAN_TIME,SEC_USER_MEM,SEC_KEY_USER,LOGIN_KEY,SEC_ON_STATUS,SEC_INIT_PASS,LOGIN_SECURE_KEY,LOGIN_USE_DOMAIN,DOMAIN_SYNC_CONFIG,ONE_USER_MUL_LOGIN,IS_CPDA_BYIP,USE_DISCUZ" );
        while(list($PARA_NAME, $PARA_VALUE) = each($PARA_ARRAY)){
            $$PARA_NAME = $PARA_VALUE;
        }
        // SEC_RETRY_BAN 是否限制登录重试次数。
        // 若为1,则SEC_RETRY_TIMES为重试的最大次数。
        if($SEC_RETRY_BAN == "1"){
            $query = "SELECT count(*) from SYS_LOG where(TYPE='2' or TYPE='9' or TYPE='10') and USER_ID='".$USERNAME."' and IP='{$USER_IP}' and UNIX_TIMESTAMP('".date("Y-m-d H:i:s", time()).("')-UNIX_TIMESTAMP(TIME)<".$SEC_BAN_TIME."*60");
            $cursor = exequery($connection, $query);
            if($ROW = mysql_fetch_array($cursor)){
                $LOGIN_RETRY_COUNT = $ROW[0];
            }
            if($SEC_RETRY_TIMES <= $LOGIN_RETRY_COUNT){
                return "用户名或密码错误超过 ".$SEC_RETRY_TIMES." 次，请等待".$SEC_BAN_TIME."分钟后重试!";
            }
        }
        // 干嘛要修复sys_log表？有损坏吗？
        repair_table("SYS_LOG");
        // 用usb key 的用户从这里验证用户名
        if($LOGIN_KEY && $SEC_KEY_USER == "0"){
            return "系统不支持此登录方式。";
//            $query = "SELECT * from USER where USER_ID='".$KEY_USER."'";
//            $cursor = exequery($connection, $query);
//            if(!($ROW = mysql_fetch_array($cursor))){
//                $query = "SELECT * from USER where USER_ID='".$USERNAME."' or BYNAME='{$USERNAME}'";
//                $cursor = exequery($connection, $query);
//                if(!($ROW = mysql_fetch_array($cursor))){
//                    add_log(10, "USERNAME=".$USERNAME, $USERNAME);
//                    return "用户名或密码错误，注意大小写!1";
//                    //return "用户名或密码错误，注意大小写!";
//                }
//            }
//            if($USERNAME == ""){
//                $USERNAME = $KEY_USER;
//            }
        }else{
            // 非usb key 用户,即正常的用户名密码用户走这里
            $query = "SELECT * from USER where USER_ID='".$USERNAME."' or BYNAME='{$USERNAME}'";
            $cursor = exequery($connection, $query);
            if(!($ROW = mysql_fetch_array($cursor))){
                add_log(10, "USERNAME=".$USERNAME, $USERNAME);
                return "用户名或密码错误，注意大小写!2";
                //return "用户名或密码错误，注意大小写!";
            }
        }

        // 用户信息
        $UID = $ROW['UID'];
        $USER_ID = $ROW['USER_ID'];
        $BYNAME = $ROW['BYNAME'];
        $USER_NAME = $ROW['USER_NAME'];
        $BIND_IP = $ROW['BIND_IP'];
        $USEING_KEY = $ROW['USEING_KEY'];
        $SECURE_KEY_SN = $ROW['SECURE_KEY_SN'];
        $ON_STATUS = $ROW['ON_STATUS'];
        // 先验证用户名
        if($USERNAME!=$USER_ID &&$USERNAME!=$BYNAME ||$USERNAME==""){
            add_log(10, "USERNAME=".$USERNAME, $USERNAME);
            return "用户名或密码错误，注意大小写!3";
            //return "用户名或密码错误，注意大小写!";
        }

        $PWD = $ROW['PASSWORD'];
        $KEY_PASSWORD = md5($PWD);

        // 再判断用户有没有被禁止登录
        $NOT_LOGIN = $ROW['NOT_LOGIN'];
        if($NOT_LOGIN){
            return "用户".$USERNAME."被设定为禁止登录！";
        }

        // 域用户登录的标识
        $USER_GUID = "";

        // GUID，域用户才有。
        if($USER_GUID == ""){
            // 这里是验证密码的算法
            if(crypt($PASSWORD, $PWD)!= $PWD){
                // 给密码打个星号，然后记入日志。
                $ERROR_PWD = maskstr($PASSWORD, 2, 1);
                add_log(2, $ERROR_PWD, $USER_ID);
                return "用户名或密码错误，注意大小写!";
            }
        }else{
            // 这是域用户的，下面都用不上了。
            return "系统不支持域用户登录。";
        }

        // usb key 用户走这里,现在不支持。
        if($LOGIN_KEY && $USEING_KEY && substr($_SERVER['SCRIPT_NAME'], 0, 5)!= "/pda/"){
            return "系统不支持USB KEY用户登录。";
        }

        // 动态密码走这里,现在不支持
        if($LOGIN_SECURE_KEY == "1" && $SECURE_KEY_SN != ""){
            return "系统不支持动态密码登录。";
        }

        // 限制ip
        if ( $IS_FROMPDA != "1" && $USER_ID != "admin" && !check_ip( $USER_IP, "0", $USER_ID ) ){
            add_log( 9, "USERNAME=".$USERNAME, $USERNAME );
            return "您无权限从该IP(".$USER_IP.")登录!";
        }

        // 同上
        if ( $IS_FROMPDA == "1" && $USER_ID != "admin" && !check_ip( $USER_IP, "0", $USER_ID ) || $IS_CPDA_BYIP == "1" ){
            add_log( 9, "USERNAME=".$USERNAME, $USERNAME );
            return "您无权限从该IP(".$USER_IP.")登录!";
        }
        // 同上
        if ( !( $IS_FROMPDA != "1" ) && $BIND_IP != "" || $IS_FROMPDA == "1" && $IS_CPDA_BYIP == "1" && $BIND_IP != "" ){
            $NET_MATCH = FALSE;
            $IP_ARRAY = explode( ",", $BIND_IP );
            foreach ( $IP_ARRAY as $NETWORK ){
                if ( !netmatch( $NETWORK, $USER_IP ) ){
                    continue;
                }
                $NET_MATCH = TRUE;
                break;
            }
            if ( !$NET_MATCH ){
                return "用户".$USERNAME."不允许从该IP(".$USER_IP.")登录！";
            }
        }

        // 下面的限制要用。
        if ( !isset( $ONE_USER_MUL_LOGIN ) ){
            $ONE_USER_MUL_LOGIN = 1;
        }

        // 是否限制帐户多地登录。
        if ( $ONE_USER_MUL_LOGIN == 0 ){
            $query = "select * from USER_ONLINE where UID='".$UID."'";
            $cursor = exequery( $connection, $query );
            if ( $ROW1 = mysql_fetch_array( $cursor ) ){
                $TIME = $ROW1['TIME'];
                $SID = $ROW1['SID'];
                if ( time( ) < $TIME + $ONLINE_REF_SEC + 5 && dechex( crc32( $SID ) ) != $_COOKIE["SID_".$UID] ){
                    return "同一帐号已在其它地方登录";
                }
            }
        }

        global $LOGIN_UID;
        global $LOGIN_USER_ID;
        global $LOGIN_BYNAME;
        global $LOGIN_USER_NAME;
        global $LOGIN_USER_PRIV;
        global $LOGIN_USER_PRIV_OTHER;
        global $LOGIN_DEPT_ID;
        global $LOGIN_DEPT_ID_OTHER;
        global $LOGIN_AVATAR;
        global $LOGIN_THEME;
        global $LOGIN_FUNC_STR;
        global $LOGIN_NOT_VIEW_USER;
        global $LOGIN_ANOTHER;
        global $TD_USER_LIMIT;
        global $TD_IM_USER_LIMIT;
        global $TD_CORE_USER_LIMIT;
        global $TD_CORE_IM_USER_LIMIT;
        global $TD_OPTIONAL;
        global $TD_SN_INFO;
        $LOGIN_USER_PRIV = $ROW['USER_PRIV'];
        $USER_PRIV_OTHER = $ROW['USER_PRIV_OTHER'];
        $LOGIN_AVATAR = $ROW['AVATAR'];
        $LOGIN_DEPT_ID = $ROW['DEPT_ID'];
        $LOGIN_DEPT_ID_OTHER = $ROW['DEPT_ID_OTHER'];
        $LAST_PASS_TIME = $ROW['LAST_PASS_TIME'];
        $LOGIN_THEME = $ROW['THEME'];
        $LOGIN_NOT_VIEW_USER = $ROW['NOT_VIEW_USER'];
        $LAST_VISIT_TIME = $ROW['LAST_VISIT_TIME'];
        $LOGIN_USER_EMAIL = $ROW['EMAIL'];


        // 用户的权限
        if ( !find_id( $USER_PRIV_OTHER, $LOGIN_USER_PRIV ) ){
            $USER_PRIV_OTHER .= $LOGIN_USER_PRIV.",";
        }

        $LOGIN_FUNC_STR = "";
        $USER_PRIV_OTHER = td_trim( $USER_PRIV_OTHER );
        if ( $USER_PRIV_OTHER != "" ){
            $query1 = "SELECT FUNC_ID_STR from USER_PRIV where USER_PRIV in (".$USER_PRIV_OTHER.")";
            $cursor1 = exequery( $connection, $query1 );
            while ( $ROW = mysql_fetch_array( $cursor1 ) ){
                $FUNC_STR = $ROW['FUNC_ID_STR'];
                $MY_ARRAY = explode( ",", $FUNC_STR );
                $ARRAY_COUNT = sizeof( $MY_ARRAY );
                // 数组的最后一个是空的，所以去掉。
                if ( $MY_ARRAY[$ARRAY_COUNT - 1] == "" ){
                    --$ARRAY_COUNT;
                }

                for ( $I=0; $I<$ARRAY_COUNT; $I++){
                    if ( !find_id( $LOGIN_FUNC_STR, $MY_ARRAY[$I] ) ){
                        $LOGIN_FUNC_STR .= $MY_ARRAY[$I].",";
                    }
                }
            }
        }

        // 用户的界面theme
        if ( $LOGIN_THEME == "" ){
            $LOGIN_THEME = "1";
        }
        // 跟界面样式有关。
        $query = "SELECT * from INTERFACE";
        $cursor1 = exequery( $connection, $query );
        if ( $ROW = mysql_fetch_array( $cursor1 ) ){
            $THEME_SELECT = $ROW['THEME_SELECT'];
            $THEME = $ROW['THEME'];
            if ( $THEME_SELECT == "0" ){
                $LOGIN_THEME = $THEME;
            }
        }
        // 直接搞成9,因为只有这一个。
        $LOGIN_THEME = 9;

        // 用户信息写到session里。
        $LOGIN_UID = $UID;
        $LOGIN_USER_ID = $USER_ID;
        $LOGIN_BYNAME = $BYNAME;
        $LOGIN_USER_NAME = $USER_NAME;
        $LOGIN_ANOTHER = "0";
        $LOGIN_USER_PRIV_OTHER = $USER_PRIV_OTHER;
        session_register( "LOGIN_UID" );
        session_register( "LOGIN_USER_ID" );
        session_register( "LOGIN_BYNAME" );
        session_register( "LOGIN_USER_NAME" );
        session_register( "LOGIN_USER_PRIV" );
        session_register( "LOGIN_USER_PRIV_OTHER" );
        session_register( "LOGIN_DEPT_ID" );
        session_register( "LOGIN_DEPT_ID_OTHER" );
        session_register( "LOGIN_AVATAR" );
        session_register( "LOGIN_THEME" );
        session_register( "LOGIN_FUNC_STR" );
        session_register( "LOGIN_NOT_VIEW_USER" );
        session_register( "LOGIN_ANOTHER" );

        // 更新在线状态
        update_my_online_status( 1 );
        clear_online_status( );

        // 如果有站内信的文件，就发送站内位。
        if ( !file_exists( $ROOT_PATH."attachment/new_sms/".$LOGIN_UID.".sms" ) ){
            new_sms_remind( $LOGIN_UID, 0 );
        }

        // 更新user表里的最后登录时间
        if ( $SEC_ON_STATUS != "1" && $ON_STATUS != "1" ){
            $update_str .= ",ON_STATUS='1'";
        }
        $query = "update USER set LAST_VISIT_TIME='".date( "Y-m-d H:i:s" )."'".$update_str.( " where USER_ID='".$LOGIN_USER_ID."'" );
        exequery( $connection, $query );

        // 如果选了记录用户名，就写进cookie里。
        if ( $SEC_USER_MEM == 1 ){
            setcookie( "USER_NAME_COOKIE", $USERNAME, time( ) + 86400000 );
        }else{
            setcookie( "USER_NAME_COOKIE", "", time( ) + 86400000 );
        }
        // 这也是写cookie
        setcookie( "OA_USER_ID", $LOGIN_USER_ID );
        setcookie( "SID_".$UID, dechex( crc32( session_id( ) ) ), time( ) + 86400000, "/" );

        // 下面两段是让用户去修改密码。
        if ( $SEC_PASS_FLAG == "1" && $SEC_PASS_TIME * 24 * 3600 <= time( ) - strtotime( $LAST_PASS_TIME ) ){
            header( "location: /general/pass.php" );
            exit( );
        }
        if ( $SEC_INIT_PASS == "1" && ( $LAST_PASS_TIME == "" || $LAST_PASS_TIME == "0000-00-00 00:00:00" ) ){
            header( "location: /general/pass.php" );
            exit( );
        }

        add_log( 1, "", $LOGIN_USER_ID );
        // 站内信
        affair_sms( );
        $query = "SELECT SMS_ID from SMS where TO_ID='".$LOGIN_USER_ID."' and REMIND_FLAG='1' and REMIND_TIME<='".time( )."' limit 0,1";
        $cursor1 = exequery( $connection, $query );
        $SMS_COUNT = mysql_num_rows( $cursor1 );
        if ( $SMS_COUNT == 0 ){
            new_sms_remind( $LOGIN_UID, 0 );
        }

        // 如果有login_ok.php，就加载进来。这个文件应该是个显示“已登录”这种信息的。
        if ( file_exists( "{$ROOT_PATH}/inc/login_ok.php" ) ){
            include_once( "inc/login_ok.php" );
        }

        // 很久没用到了。
        global $DUTY_MACHINE;
        if ( $DUTY_MACHINE == 2 )
        {
            my_duty( );
        }
        // 登录提醒
        log_on_remind( );

        return "1";
    }

    // 下面都是些特殊的验证

    global $TD_CODE_INFO;
    global $TD_UNIT_INFO;
    global $TD_SN_INFO;
    global $TD_TRAIL_EXPIRE;
    global $TD_USER_LIMIT;
    global $TD_IM_USER_LIMIT;
    global $TD_ORG_LIMIT;
    global $TD_OPTIONAL;
    global $TD_CORE_USER_LIMIT;
    global $TD_CORE_IM_USER_LIMIT;
    global $DEFAULT_RSA_KEY;

    $TD_USER_LIMIT = $TD_CORE_USER_LIMIT;
    $TD_IM_USER_LIMIT = $TD_CORE_IM_USER_LIMIT;
    $TD_OPTIONAL = "";
    $TD_ORG_LIMIT = 999;

    // 取允许登录的用户总数
    if ( 0 < $TD_USER_LIMIT && $PASSWORD != "[TDCORE_REGCHECK]" && $PASSWORD != "[TDCORE_REGREG]" ){
        $query = "SELECT count(*) from USER where NOT_LOGIN!='1'";
        $cursor = exequery( $connection, $query );
        if ( $ROW = mysql_fetch_array( $cursor ) ){
            $USER_COUNT = $ROW[0];
        }
    }

    // 如果是添加用户，判断是否已达最大用户数。
    // TODO 删了吧。
    if ( $PASSWORD == "[TDCORE_ADDUSER]" && $TD_USER_LIMIT <= $USER_COUNT )
    {
        message( "提示", "已经达到系统的最大授权用户数(".$TD_USER_LIMIT.")，不能再增加允许登录OA用户" );
        button_back_new( );
        exit( );
    }
}

// 注册时检查并获取注册信息
function get_reg_info( $REG_CODE, &$REG_INFO )
{
//    global $ROOT_PATH;
//    if ( strlen( $REG_CODE ) != 256 )
//    {
//        return _( "注册文件无效" );
//    }
//    $DAT = @file_get_contents( $ROOT_PATH."inc/tech.dat" );
//    if ( $DAT === FALSE )
//    {
//        return _( "读取数据文件错误" );
//    }
//    $DAT = td_authcode( $DAT, "DECODE", "b173b62a58d93b332c36116ff7df9d2b" );
//    if ( strlen( $DAT ) < 3000 )
//    {
//        return _( "数据文件无效" );
//    }
//    if ( !function_exists( "openssl_pkey_get_public" ) )
//    {
//        return _( "请联系管理员安装openssl扩展库" );
//    }
//    $KEY = openssl_pkey_get_public( $DAT );
//    if ( $KEY === FALSE )
//    {
//        return _( "解析数据文件失败" );
//    }
//    $REG_CODE = pack( "H*", $REG_CODE );
//    $RESULT = openssl_public_decrypt( $REG_CODE, $REG_INFO, $KEY );
//    if ( $RESULT === FALSE )
//    {
//        return _( "注册文件无效，请重新获取注册文件" );
//    }
    return TRUE;
}

// check reg info, 你也懂的。
function tdoa_check_reg()
{
    global $TD_SN_INFO,$TD_CODE_INFO,$TD_UNIT_INFO,$DEFAULT_RSA_KEY;
    return true;
}

// check sn， 你懂的.
function tdoa_check_sn()
{
    global $TD_SN_INFO;
    return TRUE;
}

// 获取软件版本号
function tdoa_sn_version( )
{
    global $TD_SN_INFO;
    if ( $TD_SN_INFO != "" )
    {
        //login_check( "[TDCORE_REGCHECK]", "[TDCORE_REGCHECK]" );
    }
    return strtoupper( substr( $TD_SN_INFO, 4, 1 ) );
}

// 返回使用了多久等信息
function tdoa_check_experience( ){
    // 记录一下谁调用了这个函数，方便以后分析。
    error_log('File ('.$_SERVER['REQUEST_URI'].') call function (tdoa_check_experience)');

    $REG_INFO = itask( array( "GET_REG_INFO" ) );
    if ( !$REG_INFO && !is_array( $REG_INFO ) && count( $REG_INFO ) == 0 )
    {
        return  0;
    }
    $REG_INFO = $REG_INFO[0];
    $REG_INFO = explode( "*", $REG_INFO );
    if ( count( $REG_INFO ) < 6 )
    {
        return  0;
    }
    $SN = $REG_INFO[1];
    $EXPIRED_DATE = $REG_INFO[5];
    if ( $SN != "TD20X-12345677-7890" )
    {
        return  0;
    }
    $EXPIRED_TIME = strtotime( $EXPIRED_DATE );
    if ( $EXPIRED_TIME === FALSE )
    {
        return  999999;
    }
    $DAYS_LEFT = floor( ( $EXPIRED_TIME - strtotime( date( "Y-m-d" ) ) ) / 86400 );
    if ( 0 < $DAYS_LEFT )
    {
        return  $DAYS_LEFT;
    }
    return 0;
}

// 生成mcode用的
function tdoa_mcode(){
    $M_CODE = md5( disk_total_space( dirname( __FILE__ ) ) );
    $M_CODE = hexdec( substr( $M_CODE, 0, 8 ) ) ^ hexdec( substr( $M_CODE, 8, 8 ) ) ^ hexdec( substr( $M_CODE, 16, 8 ) ) ^ hexdec( substr( $M_CODE, 24, 8 ) );
    return sprintf( "%08X", $M_CODE );
}

// 可选组件
// 返回一串字符有什么用？
function tdoa_optional( $OPT_NAME ){
    // 传进一个可选组件的缩写,返回对应的值.
    switch ( $OPT_NAME ){
        case "SMS" :
            $OPT_NAME = "1";
            break;
        case "ROLL" :
            $OPT_NAME = "6";
            break;
        case "TDEA" :
            $OPT_NAME = "8";
            break;
        case "TDFIS" :
            $OPT_NAME = "9";
            break;
        case "REPORT" :
            $OPT_NAME = "a";
            break;
        case "TDIM" :
            $OPT_NAME = "b";
    }
    global $TD_OPTIONAL;
    if(tdoa_check_reg() && strstr($TD_OPTIONAL, $OPT_NAME)){
        return 1;
    }else if(tdoa_check_reg() && $OPT_NAME=="OA_OPTION_LIST")    {
        for($I=0;$I<strlen($TD_OPTIONAL);$I++){
            switch(substr($TD_OPTIONAL,$I,1)){
                case "1" :
                    $OA_OPTION .= "手机短信，";
                    break;
                case "6" :
                    $OA_OPTION .= "公文档案一体化组件，";
                    break;
                case "8" :
                    $OA_OPTION .= "EA进销存，";
                    break;
                case "9" :
                    $OA_OPTION .= "财务管理，";
                    break;
                case "a" :
                    $OA_OPTION .= "报表，";
                    break;
                case "b" :
                    $OA_OPTION .= "即时通讯，";
            }
        }
        return trim( $OA_OPTION, "，" );
    }else{
        return 0;
    }
}

// 获取天气预报信息的。
function tdoa_weather( $WEATHER_CITY, $VIEW = "" )
{
    echo "weather";
}

// 获取使用限制的数据
function tdoa_user_limit(){
    global $TD_USER_LIMIT;
    global $TD_IM_USER_LIMIT;
    global $TD_ORG_LIMIT;
    global $TD_CORE_USER_LIMIT;
    global $TD_CORE_IM_USER_LIMIT;
    if ( tdoa_check_reg( ) )
    {
        return $TD_USER_LIMIT." ".$TD_IM_USER_LIMIT." ".$TD_ORG_LIMIT;
    }
    return $TD_CORE_USER_LIMIT." ".$TD_CORE_IM_USER_LIMIT." ".$TD_ORG_LIMIT;
    //return 0;
}

// 看上去像是某个功能的分页。
// 非utf-8的编码害死人啊!!!
function pages($P, $PAGE, $USERKEY){
    $PRE_I = $PAGE - 1;
    if($PAGE != 1)
    {
        $PBAR_STR .= "[&nbsp;<a href=\"muser.php?PAGE=1&USERKEY=".urlencode($USERKEY)."\">首页</a>&nbsp;]&nbsp;&nbsp;";
        $PBAR_STR .= "[&nbsp;<a href=\"muser.php?PAGE=".$PRE_I."&USERKEY=".urlencode($USERKEY)."\">上一页</a>&nbsp;]&nbsp;&nbsp;";
    }
    $SHOW_COUNT = 0;
    for($I = 1;$I <= $P;$I++)
    {
        if($I == $PAGE)
        {
            $SHOW_COUNT++;
            $PBAR_STR .= "&nbsp;".$I."&nbsp;&nbsp;&nbsp;";
        }
        else if($P - 10 < $PAGE && $P - 10 < $I)
        {
            $SHOW_COUNT++;
            if(10 < $SHOW_COUNT)
            {
                break;
            }
            $PBAR_STR .= "[&nbsp;<a href=\"muser.php?PAGE=".$I."&USERKEY=".urlencode($USERKEY)."\">".$I."</a>&nbsp;]&nbsp;&nbsp;";
        }
        else if($PAGE - 5 < $I)
        {
            $SHOW_COUNT++;
            if(10 < $SHOW_COUNT)
            {
                break;
            }
            $PBAR_STR .= "[&nbsp;<a href=\"muser.php?PAGE=".$I."&USERKEY=".urlencode($USERKEY)."\">".$I."</a>&nbsp;]&nbsp;&nbsp;";
        }
    }
    $NEXT_I = $PAGE + 1;
    if($PAGE < $P)
    {
        $PBAR_STR .= "[&nbsp;<a href=\"muser.php?PAGE=".$NEXT_I."&USERKEY=".urlencode($USERKEY)."\">下一页</a>&nbsp;]&nbsp;&nbsp;";
        $PBAR_STR .= "[&nbsp;<a href=\"muser.php?PAGE=".$P."&USERKEY=".urlencode($USERKEY)."\">末页</a>&nbsp;]&nbsp;&nbsp;";
    }
    return $PBAR_STR;
}

// 如果有人订阅了某人上线通知，那么这个函数就会在这个用户上线的时候发消息给订阅的人。
// 这个函数放这在文件里应该是因为这个文件会第一时间被执行，时效性比较好。
function log_on_remind( ){
    global $LOGIN_USER_ID;
    global $LOGIN_USER_NAME;
    global $LOGIN_DEPT_ID;
    global $connection;
    global $SYS_ONLINE_USER;
    $SMS_CONTENT = "";
    $TO_ID = "";
    $query = "select UID, USER_ID from USER where find_in_set('".$LOGIN_USER_ID."', CONCERN_USER)";
    $cursor = exequery( $connection, $query );
    while ( $ROW = mysql_fetch_array( $cursor ) )
    {
        $UID = $ROW['UID'];
        $USER_ID = $ROW['USER_ID'];
        if ( array_key_exists( $UID, $SYS_ONLINE_USER ) )
        {
            $TO_ID .= $USER_ID.",";
        }
    }
    $SMS_CONTENT = "{$LOGIN_USER_NAME}";
    if ( $LOGIN_DEPT_ID )
    {
        $LOGIN_DEPT_NAME = getdeptnamebyid( $LOGIN_DEPT_ID );
        if ( substr( $LOGIN_DEPT_NAME, strlen( $LOGIN_DEPT_NAME ) - 1, 1 ) == "," )
        {
            $LOGIN_DEPT_NAME = substr( $LOGIN_DEPT_NAME, 0, -1 );
        }
        $SMS_CONTENT .= "（".$LOGIN_DEPT_NAME."）";
    }
    $SMS_CONTENT .= "已经上线！";
    if ( $TO_ID != "" )
    {
        send_sms( "", $LOGIN_USER_ID, $TO_ID, 24, $SMS_CONTENT, "" );
    }
}

// duty? 责任？任务？ 已经很久没用到了。忽略吧，骚年！
function my_duty( ){
    global $connection;
    global $LOGIN_USER_ID;
    $CUR_DATE = date( "Y-m-d" );
    $CUR_TIME = date( "Y-m-d H:i:s" );
    $query = "select * from ATTEND_DUTY where USER_ID='".$LOGIN_USER_ID."' and REGISTER_TYPE='1' and to_days(REGISTER_TIME)=to_days('{$CUR_DATE}')";
    $cursor = exequery( $connection, $query );
    if ( 0 < mysql_num_rows( $cursor ) )
    {
        return;
    }
    $USER_IP = get_client_ip( );
    if ( !check_ip( $USER_IP, "1", $LOGIN_USER_ID ) )
    {
        return;
    }
    $query = "select * from ATTEND_HOLIDAY where BEGIN_DATE <='".$CUR_DATE."' and END_DATE>='{$CUR_DATE}'";
    $cursor = exequery( $connection, $query );
    if ( 0 < mysql_num_rows( $cursor ) )
    {
        return;
    }
    $query = "select * from ATTEND_LEAVE where USER_ID='".$LOGIN_USER_ID."' and ALLOW='1' and LEAVE_DATE1<='{$CUR_TIME}' and LEAVE_DATE2>='{$CUR_TIME}'";
    $cursor = exequery( $connection, $query );
    if ( 0 < mysql_num_rows( $cursor ) )
    {
        return;
    }
    $query = "select * from USER where USER_ID='".$LOGIN_USER_ID."'";
    $cursor = exequery( $connection, $query );
    if ( $ROW = mysql_fetch_array( $cursor ) )
    {
        $DUTY_TYPE = $ROW['DUTY_TYPE'];
    }
    $query = "SELECT * from ATTEND_CONFIG where DUTY_TYPE=".$DUTY_TYPE;
    $cursor = exequery( $connection, $query );
    if ( $ROW = mysql_fetch_array( $cursor ) )
    {
        $DUTY_TIME = $ROW['DUTY_TIME1'];
        $DUTY_TYPE = $ROW['DUTY_TYPE1'];
    }
    $DUTY_INTERVAL_BEFORE = "DUTY_INTERVAL_BEFORE".$DUTY_TYPE;
    $DUTY_INTERVAL_AFTER = "DUTY_INTERVAL_AFTER".$DUTY_TYPE;
    $PARA_ARRAY = get_sys_para( "{$DUTY_INTERVAL_BEFORE},{$DUTY_INTERVAL_AFTER}" );
    while ( list( $PARA_NAME, $PARA_VALUE ) = each( $PARA_ARRAY ) )
    {
        $$PARA_NAME = $PARA_VALUE;
    }
    $REGISTER_TIME = $CUR_DATE." ".$DUTY_TIME;
    if ( $DUTY_INTERVAL_BEFORE1 * 60 < strtotime( $REGISTER_TIME ) - strtotime( $CUR_TIME ) || $DUTY_INTERVAL_AFTER1 * 60 < strtotime( $CUR_TIME ) - strtotime( $REGISTER_TIME ) )
    {
        return;
    }
    $query = "insert into ATTEND_DUTY(USER_ID,REGISTER_TYPE,REGISTER_TIME,REGISTER_IP,REMARK) values ('".$LOGIN_USER_ID."','1','{$CUR_TIME}','".$_SERVER['REMOTE_ADDR']."','')";
    exequery( $connection, $query );
}

// session相关,必须存在。可做适当修改.
include_once("inc/session.php");
// 都是些通用函数
include_once("inc/utility_all.php");
// 这个文件里可以修改试用期
include_once("inc/oa_type.php");
// 这里放的是加密算法。不用动它。
include_once("inc/rsa/rsa.php");
// 用来连接定时任务服务器的,而这个服务器会定期检查系统的合法性。
include_once("inc/itask/itask.php");
// 维护在线用户信息的
include_once("inc/user_online.php");
// 组织机构相关的函数，还有一些取用户信息的函数。
include_once("inc/utility_org.php");
// 跟注册码有关的函数
include_once("inc/sn_reg.php");

$TD_MYOA_COMPANY_NAME = "";
$TD_MYOA_PRODUCT_NAME = "";
$TD_MYOA_WEB_SITE = "";
$TD_MYOA_WEB_SALE = "";
$TD_MYOA_WEB_AD = "";
$TD_MYOA_VERSION = "";
$TD_CORE_USER_LIMIT = 5000;
$TD_CORE_TIME_LIMIT = 3650;
$TD_CORE_IM_USER_LIMIT = 5000;
$report_bug_url="$TD_MYOA_WEB_SALE";
$Component_Opt="a123456789b";

function set_unit()
{
    global $connection,$TD_UNIT_INFO;
    $sql = "update UNIT set `UNIT_NAME`='My Company'";
    //exequery($connection,$sql);
    $TD_UNIT_INFO="My Company";
}

function set_sn()
{
    global $connection,$sn,$TD_SN_INFO;
    $sn=get_sn();
    $sql = "update VERSION set `SN`='{$sn}'";
    //exequery($connection,$sql);
    $TD_SN_INFO=$sn;
}

function set_code($code)
{
    global $connection,$TD_CODE_INFO;
    $sql = "update VERSION set `CODE`='{$code}'";
    //exequery($connection,$sql);
    $TD_CODE_INFO=$code;
}
// 单位名称没有，就先建一个进数据库。
// 第一次使用的时候执行。
if ($TD_UNIT_INFO=="")
{
    //set_unit();
}
// 这应该是第一次执行的时候往数据库里存版本信息用的.
if ($TD_SN_INFO=="")
{
    //set_sn();
    //$register_str="$TD_UNIT_INFO*$TD_SN_INFO*NL*NL*999*$Component_Opt";
    //$register_code=bin2hex(rsa_sign($register_str,$DEFAULT_RSA_KEY["private"],$DEFAULT_RSA_KEY["module"],$DEFAULT_RSA_KEY["size"]));
    //set_code("$register_code");
    //$TD_CODE_INFO=$register_code;
}
// $TD_OPTIONAL 是干什么用的?
if ($TD_OPTIONAL=="")
{
    $TD_OPTIONAL="$Component_Opt";
}
// 这个已经不知道是干什么用的了。
if ( $KEY == "yh" )
{
}
// 这个是用来检查正版的
// 先是随机性的。然后是对几个特点脚本来执行。
if ( rand( 0, 1000 ) <= 50 && !stristr( $SCRIPT_NAME, "expired.php" ) || !stristr( $SCRIPT_NAME, "reg.php" ) || !stristr( $SCRIPT_NAME, "reg_submit.php" ) )
{
    //login_check( "[TDCORE_REGCHECK_AUTO]", "[TDCORE_REGCHECK_AUTO]" );
}

// End file: td_core.php
// Location: myoa/webroot/inc/td_core.php