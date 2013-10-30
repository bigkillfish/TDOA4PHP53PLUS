<?php
//-- 网页根目录配置(Apache:自动获取) --
$ROOT_PATH=getenv("DOCUMENT_ROOT");

if($ROOT_PATH=="")
    $ROOT_PATH="d:/myoa/webroot/";

//-- 网页根目录配置(IIS:手工配置) --
//$ROOT_PATH="d:/myoa/webroot/";

if(substr($ROOT_PATH,-1)!="/")
    $ROOT_PATH.="/";

//-- 附件路径配置(Windows) --
$ATTACH_PATH=$ROOT_PATH."attachment/";
$ATTACH_PATH2=realpath($ROOT_PATH."../")."/attach/";

//-- 附件备份路径 --
$ATTACH_BACKUP_PATH = $ATTACH_PATH2."bak/";

//-- 附件路径配置(Unix/Linux) --
//$ATTACH_PATH="/myoa/attachment/";
//$ATTACH_PATH2="/myoa/attach/";

//-- 数据库热备份路径 --
$BACKUP_PATH=realpath($ROOT_PATH."../")."/bak/";

//-- 短信刷新时间，单位秒 --
$SMS_REF_SEC=30;

//-- 在线状态刷新时间，单位秒 --
$ONLINE_REF_SEC=120;

//-- 在线编辑Office文档锁定间隔时间，单位秒 --
$ATTACH_LOCK_REF_SEC=180;

//-- 空闲强制自动离线时间，单位分钟，0为不限制 --
$OFFLINE_TIME_MIN=0;

//-- 状态栏自动刷新时间，单位秒 --
$STATUS_REF_SEC=3600;

//-- 短信最多声音提醒次数，0为不限制 --
$SMS_REF_MAX=3;

//-- 短信声音提醒间隔，单位分钟 --
$SMS_CALLSOUND_INTERVAL=3;

//-- 工作流催办监控周期,可能会产生大量内部提醒短信，0表示关闭此功能。单位分钟--
$FLOW_REMIND_TIME=0;

//-- 上传附件类型限制 --
$UPLOAD_LIMIT = 1;        //0 不限制；1 不允许上传下边定义的后缀名的附件；2 只允许上传下边定义的后缀名的附件
$UPLOAD_LIMIT_TYPE="php,php3,php4,php5,";

//-- 网络硬盘不允许编辑的文本文件类型 --
$EDIT_LIMIT_TYPE="php,php3,php4,php5,phpt,inc,jsp,asp,aspx,js,cgi,pl,";

//-- 第1-2套界面主题是否使用按钮的样式效果 --
$CORRECT_BUTTON = 1;//参数1改为0表示使用普通效果

//-- 是否显示提示与技巧按钮 --
$IASK_YN = 1;    //1 显示; 0 不显示;

//-- 是否允许多人用同一帐号同时登录 --
$ONE_USER_MUL_LOGIN = 1;       //1 允许; 0 禁止;

//-- 是否附件名采用UTF-8编码 --
$ATTACH_UTF8=0;

//-- 设置为 1，Office文档下载时点“打开”按钮时，在浏览器中打开，关闭时会提示保存。
//-- 设置为 0，则调用本地Office打开，关闭时可能不会提示保存 --
$ATTACH_OFFICE_OPEN_IN_IE=0;

//-- 短信延时提醒间隔条数，每60条短信延时60秒提醒
$SMS_DELAY_PER_ROWS = 60;
//-- 短信延时提醒间隔时间，单位秒
$SMS_DELAY_SECONDS = 60;

//-- 系统缓存目录 --
$MYOA_CACHE_PATH = $ATTACH_PATH2."cache/";

//-- 允许登录系统的时间段 -- 多个时间段用英文逗号隔开，一个时间段的两个时间点用波浪号(~)隔开
$MYOA_LOGIN_TIME_RANGE = "00:00:00 ~ 23:59:59";

//-- 允许玩附件程序下的游戏的时间段 -- 多个时间段用英文逗号隔开，一个时间段的两个时间点用波浪号(~)隔开
$MYOA_GAME_TIME_RANGE = "00:00:00 ~ 23:59:59";

//-- 是否启用公共文件柜和网络硬盘附件删除的回收站功能，1为启用，0为不启用；
//-- 启用后，公共文件柜和网络硬盘中被删除的附件将在attach\recycle中留存
$MYOA_IS_RECYCLE = 1;

//-- 是否是演示版，1 是，0 不是。如果设置为演示版，则一部分功能不能使用，如修改密码
$MYOA_IS_DEMO = 0;

//-- 考勤设置,0表示手动考勤，1表示使用考勤机，2表示自动上班登记
$DUTY_MACHINE = 0;

//连接OfficeTask服务的地址和端口
$MYOA_TASK_ADDR = "127.0.0.1";
$MYOA_TASK_PORT = 2397;

//连接即时通讯服务的地址和端口
$MYOA_TDIM_ADDR = "127.0.0.1";
$MYOA_TDIM_PORT = 1188;

//连接邮件服务的地址和端口
$MYOA_MAIL_ADDR = "127.0.0.1";
$MYOA_MAIL_PORT = 2597;

//连接索引服务的地址和端口
$MYOA_INDEX_ADDR = "127.0.0.1";
$MYOA_INDEX_PORT = 2287;

//-- 内部短信即时提醒的人数，0为不启用即时提醒
$MYOA_IM_REMIND_ROWS = 60;

//-- 使用OA精灵时打开OA菜单是否使用操作系统默认浏览器，0 OA精灵浏览器，1 操作系统默认浏览器
$MYOA_USE_OS_BROWSER = 0;

//memcached server的IP和端口
$MYOA_MEMCACHED_HOST = '127.0.0.1';
$MYOA_MEMCACHED_PORT = '11911';

//-- session处理机制，支持 files,user,memcache 四种方式，为memcache时需设置MYOA_SESS_SAVE_PATH为memcache的地址
$MYOA_SESS_SAVE_HANDLER = 'memcache';
$MYOA_SESS_SAVE_PATH = $MYOA_MEMCACHED_HOST.':'.$MYOA_MEMCACHED_PORT;

//-- 数据缓存方式，默认为memcache
$MYOA_CACHE_DRIVER = 'memcache';
$MYOA_CACHE_CONFIG = array(
    'default' => array(
        'default_host' => $MYOA_MEMCACHED_HOST,
        'default_port' => $MYOA_MEMCACHED_PORT,
        'default_persistent' => true,
        'default_weight' => 1
    )
);

//-- MYOA数据库配置 --
$MYSQL_SERVER="localhost:3306";
$MYSQL_USER="root";
$MYSQL_DB="TDOA";
$MYSQL_PASS="123456";

// END oa_config.php