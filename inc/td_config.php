<?php
/**
 *系统默认配置文件
 */
$ROOT_PATH = getenv( "DOCUMENT_ROOT" );
if ( $ROOT_PATH == "" ){
    $ROOT_PATH = "d:/myoa/webroot/";
}
if ( substr( $ROOT_PATH, -1 ) != "/" ){
    $ROOT_PATH .= "/";
}
$ATTACH_PATH = $ROOT_PATH."attachment/";
$ATTACH_PATH2 = realpath( $ROOT_PATH."../" )."/attach/";
$ATTACH_BACKUP_PATH = $ATTACH_PATH2."bak/";
$BACKUP_PATH = realpath( $ROOT_PATH."../" )."/bak/";
$SMS_REF_SEC = 30;
$ONLINE_REF_SEC = 120;
$ATTACH_LOCK_REF_SEC = 180;
$OFFLINE_TIME_MIN = 0;
$STATUS_REF_SEC = 3600;
$SMS_REF_MAX = 3;
$SMS_CALLSOUND_INTERVAL = 3;
$FLOW_REMIND_TIME = 0;
$UPLOAD_FORBIDDEN_TYPE = "php,php3,php4,php5,phpt,jsp,asp,aspx,";
$UPLOAD_LIMIT = 1;
$UPLOAD_LIMIT_TYPE = "php,php3,php4,php5,";
$EDIT_LIMIT_TYPE = "php,php3,php4,php5,phpt,inc,jsp,asp,aspx,js,cgi,pl,";
$CORRECT_BUTTON = 1;
$IASK_YN = 1;
$ONE_USER_MUL_LOGIN = 1;
$ATTACH_UTF8 = 0;
$ATTACH_OFFICE_OPEN_IN_IE = 0;
$SMS_DELAY_PER_ROWS = 60;
$SMS_DELAY_SECONDS = 60;
$MYOA_CACHE_PATH = $ATTACH_PATH2."cache/";
$MYOA_LOGIN_TIME_RANGE = "00:00:00 ~ 23:59:59";
$MYOA_GAME_TIME_RANGE = "00:00:00 ~ 23:59:59";
$MYOA_IS_RECYCLE = 1;
$MYOA_IS_DEMO = 0;
$DUTY_MACHINE = 0;
$MYOA_TASK_ADDR = "127.0.0.1";
$MYOA_TASK_PORT = 2397;
$MYOA_TDIM_ADDR = "127.0.0.1";
$MYOA_TDIM_PORT = 1188;
$MYOA_MAIL_ADDR = "127.0.0.1";
$MYOA_MAIL_PORT = 2597;
$MYOA_INDEX_ADDR = "127.0.0.1";
$MYOA_INDEX_PORT = 2280;
$MYOA_INDEX_TOP_KEYS = 20;
$MYOA_IM_REMIND_ROWS = 60;
$MYOA_WEATHER_URL = "http://weather.tongda2000.com/weather.php?CITY_ID=";
$MYOA_USE_OS_BROWSER = 0;
$MYOA_SESS_DATA_SIZE = 5000;
$MYOA_MEMCACHED_HOST = "127.0.0.1";
$MYOA_MEMCACHED_IP = "11211";
$MYOA_SESS_SAVE_HANDLER = "user";
$MYOA_SESS_SAVE_PATH = "tcp://".$MYOA_MEMCACHED_HOST.":".$MYOA_MEMCACHED_IP."?persistent=0";
$MYOA_CACHE_DRIVER = "files";
$MYOA_CACHE_CONFIG = array( "cache_path" => $ATTACH_PATH2."cache/" );
$MYOA_ATTACH_SERVER_HTTP = "";
$MYOA_FASHION_THEME = "10,11,12,";
$MYSQL_SERVER = "localhost:3336";
$MYSQL_USER = "root";
$MYSQL_DB = "TD_OA";
$MYSQL_PASS = "myoa888";
$MYOA_IS_UN = 0;
$MYOA_ATTACH_NAME_FORMAT = $MYOA_IS_UN ? 1 : 0;
$MYOA_CHARSET = $MYOA_IS_UN ? "utf-8" : "gbk";
$MYOA_DB_CHARSET = $MYOA_IS_UN ? "utf8" : "gbk";
$MYOA_OS_CHARSET = "GBK";
$MYOA_MB_CHAR_LEN = $MYOA_IS_UN ? 3 : 2;
$MYOA_DEFAULT_LANG = "zh-CN";
$LANG_COOKIE = $MYOA_IS_UN && $_COOKIE['LANG_COOKIE'] != "" ? $_COOKIE['LANG_COOKIE'] : $MYOA_DEFAULT_LANG;
include( "inc/oa_config.php" );
$UPLOAD_FORBIDDEN_TYPE = strtolower( $UPLOAD_FORBIDDEN_TYPE );
$UPLOAD_LIMIT_TYPE = strtolower( $UPLOAD_LIMIT_TYPE );
$EDIT_LIMIT_TYPE = strtolower( $EDIT_LIMIT_TYPE );
if ( extension_loaded( "gettext" ) ){
    if ( !function_exists( "_" ) ){
        function _( $msg ){
            return $msg;
        }
    }
}
else
{
    putenv( "LANG=".$LANG_COOKIE );
    setlocale( LC_ALL, $LANG_COOKIE );
    $LANG_DOMAIN = $LANG_COOKIE;
    bindtextdomain( $LANG_DOMAIN, $ROOT_PATH."lang" );
    bind_textdomain_codeset( $LANG_DOMAIN, "UTF-8" );
    textdomain( $LANG_DOMAIN );
}

// END td_config.php
