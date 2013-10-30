<?php
include_once( "inc/session.php" );
if(isset($_SESSION['LOGIN_UID']) && $_SESSION['LOGIN_UID']>0){
    header("Location: /general/");
}

// 登录的用户名，24小时后过期。
$LOGIN_COOKIE_UNAME = '';
if(isset($_COOKIE['LOGIN_COOKIE_UNAME'])){
    $LOGIN_COOKIE_UNAME = $_COOKIE['LOGIN_COOKIE_UNAME'];
}

?>
<!DOCTYPE html>
<html>
<head>
    <title><?php echo _("管理系统");?></title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" type="text/css" href="/templates/2010_02/index.css" />
    <script type='text/javascript' src='/js/jquery-1.9.1.min.js'></script>


    <script type="text/javascript">

        $(document).ready(function() {
            var lang = getCookie('i18n_COOKIE');
            $('.language').each(function(){
                if(lang==$(this).val()){
                    $(this).attr('checked','checked');
                }
            });

        });

        function CheckForm()
        {
            return true;
        }

        function getCookie(objName){//获取指定名称的cookie的值
            var arrStr = document.cookie.split("; ");
            for(var i = 0;i < arrStr.length;i ++){
                var temp = arrStr[i].split("=");
                if(temp[0] == objName) return unescape(temp[1]);
            }
        }


    </script>
</head>
<body onload="javascript:document.form1.UNAME.focus();" scroll="auto">

<form name="form1" method="post" action="logincheck.php" autocomplete="off" onsubmit="return CheckForm();">
    <div id="logo">
        <div id="form">
            <table width="500" style="margin-left: 15px;">
                <tr>
                    <td width="200">用户名：<input type="text" class="text" name="UNAME" maxlength="20" onmouseover="this.focus()" onfocus="this.select()" value="<?php echo $LOGIN_COOKIE_UNAME;?>"></td>
                    <td width="200">密&nbsp;&nbsp;码：<input type="password" class="text" name="PASSWORD" onmouseover="this.focus()" onfocus="this.select()" value=""></td>
                    <td><input type="submit" class="submit" title="<?php echo _("登录");?>" value="<?php echo _("登录");?>" /></td>
                </tr>
                <tr>
                    <td colspan="3" style=" padding: 12px 20px 0 0">
                        <input type="radio" name="language" value="zh_CN" checked id="chinese" class="language" />&nbsp;中文&nbsp;&nbsp;&nbsp;&nbsp;
                        <input type="radio" name="language" value="en_US" id="english" class="language" />&nbsp;English&nbsp;&nbsp;&nbsp;&nbsp;
                    </td>
                </tr>
            </table>
        </div>
        <div class="msg">

            <div></div>
            <div></div>
            <div></div>
        </div>
    </div>
</form>
</body>
</html>