<?php
/**
 * 说明：
 * 加载td_core.php会自动启动session.
 * 因为td.core.php里加载了session.php,session.php自动启动session.
 * td_core.php里有查询语句，所以conn.php要放在td_core.php的前面。
 * 而session.php里又加载了conn.php.
 * 这是个问题！！！
 */
include_once( "inc/conn.php" ); // 这里是数据库连接
include_once( "inc/td_core.php" ); // 这里登录验证函数
include_once( "inc/utility.php" ); // 这里是工具函数

// 用户选择系统语言之后保存语言参数。
if ( $_POST['language'] != "" ){
    // TODO 删掉这句兼容旧版的内容。
    setcookie( "LANG_COOKIE", $_POST['language'], time( ) + 86400000, "/" ); // 为了兼容旧版.
    // 目前以这个为准。
    setcookie( "i18n_COOKIE", $_POST['language'], time( ) + 86400000, "/" );
}else{
    // 默认为中文
    setcookie( "i18n_COOKIE", 'zh_CN', time( ) + 86400000, "/" );
}
// 语言环境的session变量.
$_SESSION['locale'] = $_POST['language'];

// 把用户名写到cookie里，登录时记住用户名。
if(isset($_POST['UNAME'])&& trim($_POST['UNAME'])!=''){
    setcookie( "LOGIN_COOKIE_UNAME", $_POST['UNAME'], time( ) + 3600*24*7, "/" ); // 24*7小时后过期
}

ob_start();

echo "<html><head><title>";
echo _( "系统登录" );
echo "</title><meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\"><link rel=\"stylesheet\" type=\"text/css\" href=\"/theme/9/style.css\"></head><body class=\"bodycolor\" topmargin=\"5\">";

if ( $_POST['UNAME'] != "" ){
    // 这里很蛋疼的把用户名统一搞成小写。
    $USERNAME = strtolower($_POST['UNAME']);
}
$USERNAME = trim( $USERNAME );
$PASSWORD = $_POST['PASSWORD'];

$KEY_DIGEST=0;
$KEY_SN=0;
$KEY_USER=0;

// 登录验证
// TODO 使用USB KEY登录。
$LOGIN_MSG = login_check( $USERNAME, $PASSWORD, $KEY_DIGEST, $KEY_SN, $KEY_USER );

// 返回1才是登录成功
if ( $LOGIN_MSG != "1" ){
    message(
        _( "错误" ),
        $LOGIN_MSG,
        "error",
        array(
            array(
                "value" => _( "重新登录" ),
                "href" => "/"
            )
        )
    );
    if ( $USERNAME == "admin" ){
        echo "<br><div class=small1 align=center>"._("忘记了admin密码？请联系系统管理员。")."</div>";
    }
    exit( );
}

// 直接设为0
$UI = 0;
setcookie( "UI_COOKIE", $UI, time( ) + 86400000 );

echo "<script>function goto_oa(){window.location.href=\"general\";}";
echo "goto_oa();";
echo "</script><div class=big1>";
echo _( "正在进入系统，请稍候..." );
echo "</div></body></html>";


// End file logincheck.php
// Location: webroot/logincheck.php