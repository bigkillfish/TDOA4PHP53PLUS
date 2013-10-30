<?php

function format_date( $STRING1 )
{
				$STRING1 = str_replace( "-0", "-", $STRING1 );
				$STR = strtok( $STRING1, "-" );
				$STRING2 = $STR._( "年" );
				$STR = strtok( "-" );
				$STRING2 .= $STR._( "月" );
				$STR = strtok( " " );
				$STRING2 .= $STR._( "日" );
				return $STRING2;
}

function format_date_short1( $STRING1 )
{
				$STRING1 = str_replace( "-0", "-", $STRING1 );
				$STR = strtok( $STRING1, "-" );
				$STRING2 = $STR._( "年" );
				$STR = strtok( "-" );
				$STRING2 .= $STR._( "月" );
				return $STRING2;
}

function format_date_short2( $STRING1 )
{
				$STRING1 = str_replace( "-0", "-", $STRING1 );
				$STR = strtok( $STRING1, "-" );
				$STR = strtok( "-" );
				$STRING2 .= $STR._( "月" );
				$STR = strtok( " " );
				$STRING2 .= $STR._( "日" );
				return $STRING2;
}

function format_date_short3( $STRING1 )
{
				$STRING1 = str_replace( "-0", "-", $STRING1 );
				$STR = strtok( $STRING1, "-" );
				$STRING2 .= $STR._( "年" );
				return $STRING2;
}

function format_date_number( $STRING1 )
{
				$STRING1 = str_replace( "-0", "-", $STRING1 );
				$STR = strtok( $STRING1, "-" );
				$STRING2 = $STR;
				$STR = strtok( "-" );
				$STRING2 .= strlen( $STR ) == 1 ? "0".$STR : $STR;
				$STR = strtok( " " );
				$STRING2 .= strlen( $STR ) == 1 ? "0".$STR : $STR;
				return $STRING2;
}

function get_week( $STRING )
{
				switch ( date( "w", strtotime( $STRING ) ) )
				{
								case 0 :
												return _( "星期日" );
								case 1 :
												return _( "星期一" );
								case 2 :
												return _( "星期二" );
								case 3 :
												return _( "星期三" );
								case 4 :
												return _( "星期四" );
								case 5 :
												return _( "星期五" );
								case 6 :
												return _( "星期六" );
				}
}

function format_money( $STR )
{
				if ( $STR == "" )
				{
								return "";
				}
				if ( $STR == ".00" )
				{
								return "0.00";
				}
				$TOK = strtok( $STR, "." );
				if ( strcmp( $STR, $TOK ) == "0" )
				{
								$STR .= ".00";
				}
				else
				{
								$TOK = strtok( "." );
								$I = 1;
								for ( ;	$I <= 2 - strlen( $TOK );	++$I	)
								{
												$STR .= "0";
								}
				}
				if ( substr( $STR, 0, 1 ) == "." )
				{
								$STR = "0".$STR;
				}
				return $STR;
}

function compare_date( $DATE1, $DATE2 )
{
				$STR = strtok( $DATE1, "-" );
				$YEAR1 = $STR;
				$STR = strtok( "-" );
				$MON1 = $STR;
				$STR = strtok( "-" );
				$DAY1 = $STR;
				$STR = strtok( $DATE2, "-" );
				$YEAR2 = $STR;
				$STR = strtok( "-" );
				$MON2 = $STR;
				$STR = strtok( "-" );
				$DAY2 = $STR;
				if ( $YEAR2 < $YEAR1 )
				{
								return 1;
				}
				if ( $YEAR1 < $YEAR2 )
				{
								return -1;
				}
				if ( $MON2 < $MON1 )
				{
								return 1;
				}
				if ( $MON1 < $MON2 )
				{
								return -1;
				}
				if ( $DAY2 < $DAY1 )
				{
								return 1;
				}
				if ( $DAY1 < $DAY2 )
				{
								return -1;
				}
				return 0;
}

function compare_time( $TIME1, $TIME2 )
{
				$STR = strtok( $TIME1, ":" );
				$HOUR1 = $STR;
				$STR = strtok( ":" );
				$MIN1 = $STR;
				$STR = strtok( ":" );
				$SEC1 = $STR;
				$STR = strtok( $TIME2, ":" );
				$HOUR2 = $STR;
				$STR = strtok( ":" );
				$MIN2 = $STR;
				$STR = strtok( ":" );
				$SEC2 = $STR;
				if ( $HOUR2 < $HOUR1 )
				{
								return 1;
				}
				if ( $HOUR1 < $HOUR2 )
				{
								return -1;
				}
				if ( $MIN2 < $MIN1 )
				{
								return 1;
				}
				if ( $MIN1 < $MIN2 )
				{
								return -1;
				}
				if ( $SEC2 < $SEC1 )
				{
								return 1;
				}
				if ( $SEC1 < $SEC2 )
				{
								return -1;
				}
				return 0;
}

function compare_date_time( $DATE_TIME1, $DATE_TIME2 )
{
				if ( $DATE_TIME1 == NULL || strlen( $DATE_TIME1 ) == 0 || $DATE_TIME2 == NULL || strlen( $DATE_TIME2 ) == 0 )
				{
								return -1;
				}
				$DATE_TIME1_ARRY = explode( " ", $DATE_TIME1 );
				$DATE_TIME2_ARRY = explode( " ", $DATE_TIME2 );
				if ( compare_date( $DATE_TIME1_ARRY[0], $DATE_TIME2_ARRY[0] ) == 1 )
				{
								return 1;
				}
				if ( compare_date( $DATE_TIME1_ARRY[0], $DATE_TIME2_ARRY[0] ) == 0 )
				{
								if ( compare_time( $DATE_TIME1_ARRY[1], $DATE_TIME2_ARRY[1] ) == 1 )
								{
												return 1;
								}
								if ( compare_time( $DATE_TIME1_ARRY[1], $DATE_TIME2_ARRY[1] ) == 0 )
								{
												return 0;
								}
								return -1;
				}
				return -1;
}

function is_chinese( &$str, $location )
{
				$ch = TRUE;
				$i = $location;
				while ( !( 160 < ord( $str[$i] ) ) || !( 0 <= $i ) )
				{
								$ch = !$ch;
								--$i;
				}
				if ( $i != $location )
				{
								$f_str = $ch ? 1 : -1;
								return $f_str;
				}
				$f_str = FALSE;
				return $f_str;
}

function csubstr( &$str, $start = 0, $long = 0, $ltor = TRUE, $cn_len = 2 )
{
				global $MYOA_CHARSET;
				$str = str_replace( array( "&amp;", "&quot;", "&lt;", "&gt;" ), array( "&", "\"", "<", ">" ), $str );
				if ( $long == 0 )
				{
								$long = strlen( $str );
				}
				if ( $ltor )
				{
								$str = cstrrev( $str );
				}
				if ( strtolower( $MYOA_CHARSET ) == "utf-8" )
				{
								$patten = "/[\x01-]|[�遌[�縘|郲�縘[�縘|[�颹[�縘[�縘|餥�縘[�縘[�縘|[�鱙[�縘[�縘[�縘/";
								preg_match_all( $patten, $str, $ar );
								$ar = $ar[0];
								if ( $cn_len == 1 )
								{
												$f_str = join( "", array_slice( $ar, $start, $start + $long ) );
												break;
								}
								else
								{
												$i = 0;
												for ( ;	$i < count( $ar );	++$i	)
												{
																if ( $long <= strlen( $f_str ) )
																{
																				if ( $start <= $fs )
																				{
																								$f_str .= $ar[$i];
																				}
																}
																$fs += strlen( $ar[$i] );
												}
								}
				}
				else
				{
								if ( $cn_len == 1 )
								{
												$i = 0;
												$fs = 0;
												for ( ;	$i < $start;	++$fs	)
												{
																$i += ord( $str[$fs] ) <= 160 ? 1 : 0.5;
												}
												$i = 0;
												$fe = $fs;
												for ( ;	$i < $long;	++$fe	)
												{
																$i += ord( $str[$fe] ) <= 160 ? 1 : 0.5;
												}
												$long = $fe - $fs;
								}
								else
								{
												$fs = is_chinese( $str, $start ) == 1 ? $start - 1 : $start;
												$fe = $long + $start - 1;
												$end = is_chinese( $str, $fe ) == -1 ? $fe - 1 : $fe;
												$long = $end - $fs + 1;
								}
								$f_str = substr( $str, $fs, $long );
				}
				if ( $ltor )
				{
								$f_str = cstrrev( $f_str );
				}
				$f_str = str_replace( array( "&", "\"", "<", ">" ), array( "&amp;", "&quot;", "&lt;", "&gt;" ), $f_str );
				return $f_str;
}

function is_ip( $IP )
{
				$IP_ARRAY = explode( ".", $IP );
				$IP_ARRAY_NUM = sizeof( $IP_ARRAY );
				if ( $IP_ARRAY_NUM != 4 )
				{
								return FALSE;
				}
				$I = 0;
				for ( ;	$I < $IP_ARRAY_NUM;	++$I	)
				{
								if ( !is_numeric( $IP_ARRAY[$I] ) || $IP_ARRAY[$I] < 0 || 255 < $IP_ARRAY[$I] )
								{
												return FALSE;
								}
								if ( !( $I == 3 ) || !( $IP_ARRAY[$I] == 255 ) )
								{
												return FALSE;
								}
				}
				return TRUE;
}

function check_ip( $USER_IP, $TYPE, $USER_ID )
{
				global $connection;
				$query = "select REMARK from IP_RULE where TYPE='3'";
				$cursor = exequery( $connection, $query );
				if ( $ROW = mysql_fetch_array( $cursor ) )
				{
								$FORBIDDEN_IP = $ROW['REMARK'];
								if ( find_id( $FORBIDDEN_IP, $USER_IP ) )
								{
												return FALSE;
								}
				}
				$query = "SELECT PARA_VALUE from SYS_PARA where PARA_NAME='IP_UNLIMITED_USER'";
				$cursor = exequery( $connection, $query );
				if ( $ROW = mysql_fetch_array( $cursor ) )
				{
								$IP_UNLIMITED_USER = $ROW['PARA_VALUE'];
				}
				if ( find_id( $IP_UNLIMITED_USER, $USER_ID ) )
				{
								return TRUE;
				}
				$query = "select * from IP_RULE where TYPE='".$TYPE."'";
				$cursor = exequery( $connection, $query );
				$RULE_COUNT = 0;
				if ( $TYPE == "2" )
				{
								$FLAG = 1;
				}
				else
				{
								$FLAG = 0;
				}
				do
				{
								if ( $ROW = mysql_fetch_array( $cursor ) )
								{
												++$RULE_COUNT;
												$BEGIN_IP = $ROW['BEGIN_IP'];
												$END_IP = $ROW['END_IP'];
								}
				} while ( !( ip2long( $BEGIN_IP ) <= ip2long( $USER_IP ) ) || !( ip2long( $USER_IP ) <= ip2long( $END_IP ) ) );
				if ( $TYPE == "0" || $TYPE == "1" )
				{
								$FLAG = 1;
				}
				else
				{
								$FLAG = 0;
				}
				if ( $RULE_COUNT == 0 || $FLAG == 1 )
				{
								return TRUE;
				}
				return FALSE;
}

function maskstr( $STR, $FIRST, $LAST )
{
				if ( !is_numeric( $FIRST ) || !is_numeric( $LAST ) )
				{
				}
				else if ( strlen( $STR ) <= $FIRST + $LAST )
				{
								return $STR;
				}
				else
				{
								$RETURN_STR = substr( $STR, 0, $FIRST );
								$I = 0;
								for ( ;	$I < strlen( substr( $STR, $FIRST, 0 - $LAST ) );	++$I	)
								{
												$RETURN_STR .= "*";
								}
								$RETURN_STR .= substr( $STR, 0 - $LAST );
								return $RETURN_STR;
				}
}

function add_log( $TYPE, $REMARK, $OPERATOR )
{
				global $connection;
				$CUR_TIME = date( "Y-m-d H:i:s", time( ) );
				$USER_IP = get_client_ip( );
				if ( $TYPE == 1 )
				{
								$query = "update USER set LAST_VISIT_IP='".$USER_IP."' where USER_ID='{$OPERATOR}'";
								exequery( $connection, $query );
				}
				else
				{
								if ( $TYPE == 3 || $TYPE == 4 || $TYPE == 5 )
								{
												include_once( "inc/itask/itask.php" );
												global $DEPT_PARENT;
												if ( $TYPE == 3 || $TYPE == 4 )
												{
																$result = itask( array( "SYSLOG_".$TYPE." ".$REMARK.",".$DEPT_PARENT ) );
												}
												$query = "SELECT DEPT_ID,DEPT_NAME,DEPT_PARENT from DEPARTMENT where DEPT_ID='".$REMARK."'";
												$cursor = exequery( $connection, $query );
												if ( $ROW = mysql_fetch_array( $cursor ) )
												{
																$DEPT_ID = $ROW['DEPT_ID'];
																$DEPT_NAME = $ROW['DEPT_NAME'];
																if ( $TYPE == 5 )
																{
																				$DEPT_PARENT = $ROW['DEPT_PARENT'];
																}
												}
												$REMARK = "{$DEPT_NAME},DEPT_ID={$DEPT_ID},DEPT_PARENT={$DEPT_PARENT}";
												if ( $result === FALSE )
												{
																message( _( "错误" ), itask_last_error( ) );
																button_back( );
																exit( );
												}
								}
								if ( $TYPE == 6 || $TYPE == 7 || $TYPE == 8 || $TYPE == 11 || $TYPE == 25 )
								{
												include_once( "inc/itask/itask.php" );
												global $DEPT_ID;
												global $NOT_LOGIN;
												if ( $TYPE == 6 || $TYPE == 7 || $TYPE == 25 )
												{
																$result = itask( array( "SYSLOG_".$TYPE." ".$REMARK.",".$DEPT_ID.",".$NOT_LOGIN ) );
												}
												$query = "SELECT USER_ID,USER_NAME,DEPT_ID from USER where find_in_set(USER_ID,'".$REMARK."')";
												$cursor = exequery( $connection, $query );
												$REMARK = "";
												while ( $ROW = mysql_fetch_array( $cursor ) )
												{
																$USER_ID = $ROW['USER_ID'];
																$USER_NAME = $ROW['USER_NAME'];
																$DEPT_ID1 = $ROW['DEPT_ID'];
																$query = "SELECT DEPT_NAME from DEPARTMENT where DEPT_ID='".$DEPT_ID1."'";
																$cursor1 = exequery( $connection, $query );
																if ( $ROW = mysql_fetch_array( $cursor1 ) )
																{
																				$DEPT_NAME = $ROW['DEPT_NAME'];
																}
																$REMARK .= "[".$DEPT_NAME."]{$USER_NAME},USER_ID={$USER_ID}<br>";
												}
												if ( $result === FALSE )
												{
																message( _( "错误" ), itask_last_error( ) );
																button_back( );
																exit( );
												}
								}
				}
				$REMARK = str_replace( "'", "\\'", $REMARK );
				$REMARK = str_replace( "\\\\'", "\\'", $REMARK );
				$query = "insert into SYS_LOG (USER_ID,TIME,IP,TYPE,REMARK) values ('".$OPERATOR."','{$CUR_TIME}','{$USER_IP}','{$TYPE}','{$REMARK}')";
				exequery( $connection, $query );
				if ( 21 < $TYPE && !find_id( "40,41,", $TYPE ) && get_code_name( $TYPE, "SYS_LOG" ) == "" )
				{
								$query1 = "INSERT INTO `SYS_CODE` ( `CODE_NO` , `CODE_NAME` , `CODE_ORDER` , `PARENT_NO` , `CODE_FLAG` ) VALUES ('".$TYPE."', '"._( "未知类型" )."', '99', 'SYS_LOG', '1');";
								exequery( $connection, $query1 );
				}
				return $query;
}

function affair_sms( )
{
				global $ROOT_PATH;
				include_once( "inc/utility_sms1.php" );
				global $connection;
				global $LOGIN_USER_ID;
				$CUR_DATE = date( "Y-m-d", time( ) );
				$CUR_TIME = date( "Y-m-d H:i:s", time( ) );
				$CUR_DATE_U = time( );
				$CUR_TIME_U = time( );
				$query = "SELECT * from AFFAIR where USER_ID='".$LOGIN_USER_ID."' and BEGIN_TIME <='{$CUR_TIME_U}' and (END_TIME>='{$CUR_TIME_U}' or END_TIME='0' ) and (LAST_REMIND<'{$CUR_DATE}' or LAST_REMIND='0000-00-00')";
				$cursor = exequery( $connection, $query );
				while ( $ROW = mysql_fetch_array( $cursor ) )
				{
								$AFF_ID = $ROW['AFF_ID'];
								$USER_ID = $ROW['USER_ID'];
								$TYPE = $ROW['TYPE'];
								$REMIND_DATE = $ROW['REMIND_DATE'];
								$REMIND_TIME = $ROW['REMIND_TIME'];
								$CONTENT = $ROW['CONTENT'];
								$SMS_REMIND = $ROW['SMS_REMIND'];
								$SMS2_REMIND = $ROW['SMS2_REMIND'];
								$SEND_TIME = date( "Y-m-d", time( ) )." ".$REMIND_TIME;
								$SMS_CONTENT = _( "日常事务提醒：" ).csubstr( $CONTENT, 0, 100 );
								$FLAG = 0;
								if ( $TYPE == "2" )
								{
												$FLAG = 1;
								}
								else if ( $TYPE == "3" && date( "w", time( ) ) == $REMIND_DATE )
								{
												$FLAG = 1;
								}
								else if ( $TYPE == "4" && date( "j", time( ) ) == $REMIND_DATE )
								{
												$FLAG = 1;
								}
								else if ( $TYPE == "5" )
								{
												$REMIND_ARR = explode( "-", $REMIND_DATE );
												$REMIND_DATE_MON = $REMIND_ARR[0];
												$REMIND_DATE_DAY = $REMIND_ARR[1];
												if ( date( "n", time( ) ) == $REMIND_DATE_MON && date( "j", time( ) ) == $REMIND_DATE_DAY )
												{
																$FLAG = 1;
												}
								}
								else if ( $TYPE == "6" && date( "w", time( ) ) != 0 && date( "w", time( ) ) != 6 )
								{
												$FLAG = 1;
								}
								if ( $FLAG == 1 && $SMS_REMIND == 1 )
								{
												send_sms( $SEND_TIME, $LOGIN_USER_ID, $LOGIN_USER_ID, 45, $SMS_CONTENT, "1:calendar/affair/note.php?AFF_ID=".$AFF_ID );
												$query = "update AFFAIR set LAST_REMIND='".$CUR_DATE."' where AFF_ID='{$AFF_ID}'";
												exequery( $connection, $query );
								}
								if ( !( $FLAG == 1 ) || !( $SMS2_REMIND == 1 ) )
								{
												$SMS_CONTENT2 = _( "OA周期性事务:" ).$CONTENT;
												send_mobile_sms_user( $SEND_TIME, $LOGIN_USER_ID, $LOGIN_USER_ID, $SMS2_CONTENT, 45 );
												$query = "update AFFAIR set LAST_REMIND='".$CUR_DATE."' where AFF_ID='{$AFF_ID}'";
												exequery( $connection, $query );
								}
				}
}

function get_code_name( $CODE_NO, $PARENT_NO )
{
				if ( $CODE_NO == "" || $PARENT_NO == "" )
				{
								return "";
				}
				global $connection;
				global $LANG_COOKIE;
				$POSTFIX = _( "，" );
				$query = "SELECT CODE_NAME,CODE_EXT from SYS_CODE where PARENT_NO='".$PARENT_NO."' and find_in_set(CODE_NO,'{$CODE_NO}')";
				$cursor = exequery( $connection, $query );
				while ( $ROW = mysql_fetch_array( $cursor ) )
				{
								$CODE_NAME = $ROW['CODE_NAME'];
								$CODE_EXT = unserialize( $ROW['CODE_EXT'] );
								if ( is_array( $CODE_EXT ) && $CODE_EXT[$LANG_COOKIE] != "" )
								{
												$CODE_NAME = $CODE_EXT[$LANG_COOKIE];
								}
								$CODE_NAME_STR .= $CODE_NAME.$POSTFIX;
				}
				return substr( $CODE_NAME_STR, 0, 0 - strlen( $POSTFIX ) );
}

function code_list( $PARENT_NO, $SELECTED = "", $TYPE = "D", $FIELD_NAME = "" )
{
				global $connection;
				global $LANG_COOKIE;
				$query = "select CODE_NO,CODE_NAME,CODE_EXT from SYS_CODE where PARENT_NO='".$PARENT_NO."' order by CODE_ORDER";
				$cursor = exequery( $connection, $query );
				while ( $ROW = mysql_fetch_array( $cursor ) )
				{
								$CODE_NO = $ROW['CODE_NO'];
								$CODE_NAME = $ROW['CODE_NAME'];
								$CODE_EXT = unserialize( $ROW['CODE_EXT'] );
								if ( is_array( $CODE_EXT ) && $CODE_EXT[$LANG_COOKIE] != "" )
								{
												$CODE_NAME = $CODE_EXT[$LANG_COOKIE];
								}
								if ( $TYPE == "D" )
								{
												$OPTION_STR .= "<option value=\"".$CODE_NO."\"";
												if ( $CODE_NO == $SELECTED )
												{
																$OPTION_STR .= " selected";
												}
												$OPTION_STR .= ">".$CODE_NAME."</option>\n";
								}
								else if ( $TYPE == "R" )
								{
												$OPTION_STR .= "<input type=\"radio\" name=\"".$FIELD_NAME."\" id=\"".$FIELD_NAME."_".$CODE_NO."\" value=\"".$CODE_NO."\"";
												if ( $CODE_NO == $SELECTED )
												{
																$OPTION_STR .= " checked";
												}
												$OPTION_STR .= "><label for=\"".$FIELD_NAME."_".$CODE_NO."\">".$CODE_NAME."</label>\n";
								}
								else if ( $TYPE == "C" )
								{
												$OPTION_STR .= "<input type=\"checkbox\" name=\"".$FIELD_NAME."_".$CODE_NO."\" id=\"".$FIELD_NAME."_".$CODE_NO."\" value=\"".$CODE_NO."\"";
												if ( find_id( $SELECTED, $CODE_NO ) )
												{
																$OPTION_STR .= " checked";
												}
												$OPTION_STR .= "><label for=\"".$FIELD_NAME."_".$CODE_NO."\">".$CODE_NAME."</label>\n";
								}
				}
				return $OPTION_STR;
}

function get_code_array( $PARENT_NO, $REVERSE = FALSE )
{
				$CODE_ARRAY = array( );
				if ( $PARENT_NO == "" )
				{
								return $CODE_ARRAY;
				}
				global $connection;
				global $LANG_COOKIE;
				$query = "select CODE_NO,CODE_NAME,CODE_EXT from SYS_CODE where PARENT_NO='".$PARENT_NO."' order by CODE_ORDER";
				$cursor = exequery( $connection, $query );
				while ( $ROW = mysql_fetch_array( $cursor ) )
				{
								$CODE_NO = $ROW['CODE_NO'];
								$CODE_NAME = $ROW['CODE_NAME'];
								$CODE_EXT = unserialize( $ROW['CODE_EXT'] );
								if ( is_array( $CODE_EXT ) && $CODE_EXT[$LANG_COOKIE] != "" )
								{
												$CODE_NAME = $CODE_EXT[$LANG_COOKIE];
								}
								if ( $REVERSE )
								{
												$CODE_ARRAY[$CODE_NO] = $CODE_NAME;
								}
								else
								{
												$CODE_ARRAY[$CODE_NAME] = $CODE_NO;
								}
				}
				return $CODE_ARRAY;
}

function sms_type_url( $SMS_TYPE, $CONTENT )
{
				switch ( $SMS_TYPE )
				{
								case "0" :
								case "23" :
												$URL = "/general/sms/remind_center/receive/";
												return $URL;
								case "1" :
												$URL = "/general/notify/show/";
												return $URL;
								case "2" :
												$URL = "/general/email/inbox/?BOX_ID=0";
												return $URL;
								case "3" :
												$URL = "/general/netmeeting/";
												return $URL;
								case "4" :
												$URL = "/general/salary/report/";
												return $URL;
								case "5" :
												$URL = "/general/calendar/";
												return $URL;
								case "6" :
												if ( strstr( $CONTENT, _( "提交" ) ) && strstr( $CONTENT, _( "申请" ) ) && strstr( $CONTENT, _( "请批示" ) ) )
												{
																$URL = "/general/attendance/manage/";
																return $URL;
												}
												$URL = "/general/attendance/personal/";
												return $URL;
								case "7" :
												$URL = "/general/workflow/list";
												return $URL;
								case "8" :
												$URL = "/general/meeting/manage/";
												return $URL;
								case "9" :
												if ( !strstr( $CONTENT, _( "提交" ) ) || !strstr( $CONTENT, _( "申请" ) ) || strstr( $CONTENT, _( "请批示" ) ) || strstr( $CONTENT, _( "部门领导" ) ) && strstr( $CONTENT, _( "批准了" ) ) )
												{
																$URL = "/general/vehicle/checkup/";
																return $URL;
												}
												if ( strstr( $CONTENT, _( "部门审批" ) ) )
												{
																$URL = "/general/vehicle/dept_manage/";
																return $URL;
												}
												$URL = "/general/vehicle/";
												return $URL;
								case "10" :
												$URL = "";
												return $URL;
								case "11" :
												$URL = "/general/vote/show/";
												return $URL;
								case "12" :
												$URL = "/general/work_plan/show/";
												return $URL;
								case "13" :
												$URL = "/general/diary/";
												return $URL;
								case "14" :
												$URL = "/general/news/show/";
												return $URL;
								case "15" :
												$URL = "/general/score/submit/";
												return $URL;
								case "16" :
												$URL = "/general/file_folder/index1.php";
												return $URL;
								case "17" :
												$URL = "/general/netdisk";
												return $URL;
								case "18" :
												$URL = "/general/bbs";
												return $URL;
								case "20" :
												$URL = "/general/file_folder?FILE_SORT=2&SORT_ID=0";
												return $URL;
								case "30" :
												$URL = "/general/training/manage/show";
												return $URL;
								case "31" :
												if ( strstr( $CONTENT, _( "批准了" ) ) || strstr( $CONTENT, _( "未批准" ) ) || strstr( $CONTENT, _( "撤销了" ) ) )
												{
																$URL = "/general/training/train/apply/";
																return $URL;
												}
												$URL = "/general/training/manage/apply_manage/";
												return $URL;
								case "32" :
												$URL = "/general/training/train/survey/";
												return $URL;
								case "33" :
												$URL = "/general/training/train/information/";
												return $URL;
								case "34" :
												$URL = "/general/training/train/assessment/";
												return $URL;
								case "35" :
												$URL = "/general/hrms/manage/";
												return $URL;
								case "72" :
												$URL = "/general/system/monitor/";
								default :
												return $URL;
				}
}

function avatar_path( $AVATAR, $SEX = "" )
{
				global $ROOT_PATH;
				include_once( "inc/utility_file.php" );
				$URL_ARRAY = attach_url_old( "avatar", $AVATAR );
				if ( strpos( $AVATAR, "." ) )
				{
								$AVATAR_PATH = $URL_ARRAY['view'];
								$AVATAR_FILE = attach_real_path( "avatar", $AVATAR );
				}
				else if ( $AVATAR != "" )
				{
								$AVATAR_PATH = "/images/avatar/".$AVATAR.".gif";
								$AVATAR_FILE = $ROOT_PATH.$AVATAR_PATH;
				}
				else
				{
								$AVATAR_PATH = "/images/avatar/avatar_".$SEX.".jpg";
								$AVATAR_FILE = $ROOT_PATH.$AVATAR_PATH;
				}
				if ( file_exists( $AVATAR_FILE ) )
				{
								return $AVATAR_PATH;
				}
				return "/images/avatar/avatar_0.jpg";
}

function photo_path( $USER_ID )
{
				global $ROOT_PATH;
				global $connection;
				global $MYOA_IS_UN;
				include_once( "inc/utility_file.php" );
				$query = "SELECT PHOTO,SEX from USER where USER_ID='".$USER_ID."'";
				$cursor = exequery( $connection, $query );
				if ( $ROW = mysql_fetch_array( $cursor ) )
				{
								$PHOTO = $ROW['PHOTO'];
								$SEX = $ROW['SEX'];
				}
				$URL_ARRAY = attach_url_old( "photo", $PHOTO );
				if ( strpos( $PHOTO, "." ) )
				{
								$PHOTO_PATH = $URL_ARRAY['view'];
								$PHOTO_FILE = attach_real_path( "photo", $PHOTO );
				}
				else if ( $MYOA_IS_UN )
				{
								$query = "select PHOTO_NAME from HR_STAFF_INFO where USER_ID='".$USER_ID."'";
								$cursor = exequery( $connection, $query );
								if ( $ROW = mysql_fetch_array( $cursor ) )
								{
												$PHOTO_NAME = $ROW['PHOTO_NAME'];
												$FB_STR1 = urldecode( $PHOTO_NAME );
												if ( strstr( $FB_STR1, "/" ) || strstr( $FB_STR1, "\\" ) )
												{
																exit( );
												}
												if ( strpos( $PHOTO_NAME, "." ) )
												{
																$URL_ARRAY = attach_url_old( "hrms_pic", $PHOTO_NAME );
																$PHOTO_PATH = $URL_ARRAY['view'];
																$PHOTO_FILE = attach_real_path( "hrms_pic", $PHOTO_NAME );
												}
								}
				}
				if ( file_exists( $PHOTO_FILE ) )
				{
								return $PHOTO_PATH;
				}
				return "/images/avatar/".$SEX.".png";
}

function avatar_size( $AVATAR )
{
				global $ROOT_PATH;
				global $connection;
				global $AVATAR_WIDTH;
				global $AVATAR_HEIGHT;
				include_once( "inc/utility_file.php" );
				$AVATAR_PATH = strpos( $AVATAR, "." ) ? attach_real_path( "avatar", $AVATAR ) : $ROOT_PATH.( "/images/avatar/".$AVATAR.".gif" );
				if ( file_exists( $AVATAR_PATH ) )
				{
								$AVATAR_PATH = $ROOT_PATH."/images/avatar/avatar_0.jpg";
				}
				if ( !$AVATAR_WIDTH || !$AVATAR_HEIGHT )
				{
								$query = "SELECT AVATAR_WIDTH,AVATAR_HEIGHT from INTERFACE";
								$cursor = exequery( $connection, $query );
								if ( $ROW = mysql_fetch_array( $cursor ) )
								{
												$AVATAR_WIDTH = $ROW['AVATAR_WIDTH'];
												$AVATAR_HEIGHT = $ROW['AVATAR_HEIGHT'];
								}
				}
				$IMG_ATTR = @getimagesize( @$AVATAR_PATH );
				if ( $AVATAR_WIDTH < $IMG_ATTR[0] )
				{
								$IMG_ATTR[0] = $AVATAR_WIDTH;
				}
				if ( $AVATAR_HEIGHT < $IMG_ATTR[1] )
				{
								$IMG_ATTR[1] = $AVATAR_HEIGHT;
				}
				if ( $IMG_ATTR[0] < 15 )
				{
								$IMG_ATTR[0] = 15;
				}
				if ( $IMG_ATTR[1] < 15 )
				{
								$IMG_ATTR[1] = 15;
				}
				return "width=\"".$IMG_ATTR['0']."\" height=\"{$IMG_ATTR['1']}\"";
}

function format_cvs( $STR )
{
				$STR = str_replace( "\"", "", $STR );
				$STR = str_replace( "\n", "", $STR );
				$STR = str_replace( "\r", "", $STR );
				$STR = str_replace( "'", "\\'", $STR );
				if ( strpos( $STR, "," ) === FALSE )
				{
								return $STR;
				}
				$STR = "\"".$STR."\"";
				return $STR;
}

function keyed_str( $TXT, $ENCRYPT_KEY )
{
				$ENCRYPT_KEY = md5( $ENCRYPT_KEY );
				$CTR = 0;
				$TMP = "";
				$I = 0;
				for ( ;	$I < strlen( $TXT );	++$I	)
				{
								if ( $CTR == strlen( $ENCRYPT_KEY ) )
								{
												$CTR = 0;
								}
								$TMP .= substr( $TXT, $I, 1 ) ^ substr( $ENCRYPT_KEY, $CTR, 1 );
								++$CTR;
				}
				return $TMP;
}

function encrypt_str( $TXT, $KEY )
{
				srand(  1000000 );
				$ENCRYPT_KEY = md5( rand( 0, 32000 ) );
				$CTR = 0;
				$TMP = "";
				$I = 0;
				for ( ;	$I < strlen( $TXT );	++$I	)
				{
								if ( $CTR == strlen( $ENCRYPT_KEY ) )
								{
												$CTR = 0;
								}
								$TMP .= substr( $ENCRYPT_KEY, $CTR, 1 ).( substr( $TXT, $I, 1 ) ^ substr( $ENCRYPT_KEY, $CTR, 1 ) );
								++$CTR;
				}
				return keyed_str( $TMP, $KEY );
}

function decrypt_str( $TXT, $KEY )
{
				$TXT = keyed_str( $TXT, $KEY );
				$TMP = "";
				$I = 0;
				for ( ;	$I < strlen( $TXT );	++$I	)
				{
								$MD5 = substr( $TXT, $I, 1 );
								++$I;
								$TMP .= substr( $TXT, $I, 1 ) ^ $MD5;
				}
				return $TMP;
}

function dept_name( $DEPT_ID, $LONG_NAME = FALSE )
{
				global $SYS_DEPARTMENT;
				include_once( "inc/department.php" );
				if ( !is_array( $SYS_DEPARTMENT ) || !array_key_exists( $DEPT_ID, $SYS_DEPARTMENT ) )
				{
								include_once( "inc/utility_org.php" );
								cache_department( );
								include( "inc/department.php" );
				}
				if ( $LONG_NAME )
				{
								return $SYS_DEPARTMENT[$DEPT_ID]['DEPT_LONG_NAME'];
				}
				return $SYS_DEPARTMENT[$DEPT_ID]['DEPT_NAME'];
}

function dept_long_name( $DEPT_ID )
{
				return dept_name( $DEPT_ID, TRUE );
}

function child_in_toid( $TO_ID, $DEPT_ID )
{
				global $connection;
				$query = "SELECT DEPT_ID from DEPARTMENT where DEPT_PARENT='".$DEPT_ID."'";
				$cursor = exequery( $connection, $query );
				do
				{
								if ( $ROW = mysql_fetch_array( $cursor ) )
								{
												$DEPT_ID = $ROW['DEPT_ID'];
												if ( find_id( $TO_ID, $DEPT_ID ) )
												{
																return TRUE;
												}
								}
				} while ( !child_in_toid( $TO_ID, $DEPT_ID ) );
				return TRUE;
				return FALSE;
}

function sms_remind( $SMS_TYPE, $SMS_CHECKED = "" )
{
				global $connection;
				global $LOGIN_USER_ID;
				$query = "select * from SYS_PARA where PARA_NAME='SMS_REMIND'";
				$cursor = exequery( $connection, $query );
				if ( $ROW = mysql_fetch_array( $cursor ) )
				{
								$PARA_VALUE = $ROW['PARA_VALUE'];
				}
				$REMIND_ARRAY = explode( "|", $PARA_VALUE );
				$SMS_REMIND = $REMIND_ARRAY[0];
				$SMS2_REMIND = $REMIND_ARRAY[1];
				$SMS3_REMIND = $REMIND_ARRAY[2];
				if ( find_id( $SMS3_REMIND, $SMS_TYPE ) )
				{
								echo "<input type=\"checkbox\" name=\"SMS_REMIND\" id=\"SMS_REMIND\"";
								if ( $SMS_CHECKED == "1" || find_id( $SMS_REMIND, $SMS_TYPE ) )
								{
												echo " checked";
								}
								echo "><label for=\"SMS_REMIND\">"._( "发送事务提醒消息" )."</label>&nbsp;&nbsp;";
				}
				$query = "select * from SMS2_PRIV";
				$cursor = exequery( $connection, $query );
				if ( $ROW = mysql_fetch_array( $cursor ) )
				{
								$TYPE_PRIV = $ROW['TYPE_PRIV'];
								$SMS2_REMIND_PRIV = $ROW['SMS2_REMIND_PRIV'];
				}
				if ( find_id( $TYPE_PRIV, $SMS_TYPE ) && find_id( $SMS2_REMIND_PRIV, $LOGIN_USER_ID ) )
				{
								echo "<input type=\"checkbox\" name=\"SMS2_REMIND\" id=\"SMS2_REMIND\"";
								if ( find_id( $SMS2_REMIND, $SMS_TYPE ) )
								{
												echo " checked";
								}
								echo "><label for=\"SMS2_REMIND\">"._( "发送手机短信提醒" )."</label>";
				}
}

function sms_select_remind( $SMS_TYPE, $SMS_CHECKED = "" )
{
				global $connection;
				$query = "select * from SYS_PARA where PARA_NAME='SMS_REMIND'";
				$cursor = exequery( $connection, $query );
				if ( $ROW = mysql_fetch_array( $cursor ) )
				{
								$PARA_VALUE = $ROW['PARA_VALUE'];
				}
				$REMIND_ARRAY = explode( "|", $PARA_VALUE );
				$SMS3_REMIND = $REMIND_ARRAY[2];
				if ( find_id( $SMS3_REMIND, $SMS_TYPE ) )
				{
								return "<input type=\"radio\" name=\"SMS_SELECT_REMIND\" id=\"SMS_SELECT_REMIND0\" value=\"0\" onclick=\"document.getElementById('SMS_SELECT_REMIND_SPAN').style.display='';\"".( $SMS_CHECKED != "1" ? " checked" : "" )."><label for=\"SMS_SELECT_REMIND0\">手动选择被提醒人员</label>\r\n      <input type=\"radio\" name=\"SMS_SELECT_REMIND\" id=\"SMS_SELECT_REMIND1\" value=\"1\" onclick=\"document.getElementById('SMS_SELECT_REMIND_SPAN').style.display='none';\"".( $SMS_CHECKED == "1" ? " checked" : "" )."><label for=\"SMS_SELECT_REMIND1\">提醒全部有权限人员</label><br>\r\n      <span id=\"SMS_SELECT_REMIND_SPAN\">\r\n      <textarea cols=40 name=\"SMS_SELECT_REMIND_TO_NAME\" rows=\"2\" class=\"BigStatic\" wrap=\"yes\" readonly></textarea>\r\n      <input type=\"hidden\" name=\"SMS_SELECT_REMIND_TO_ID\" value=\"\">\r\n      <a href=\"javascript:;\" class=\"orgAdd\" onClick=\"SelectUser('','SMS_SELECT_REMIND_TO_ID', 'SMS_SELECT_REMIND_TO_NAME')\">添加</a>\r\n      <a href=\"javascript:;\" class=\"orgClear\" onClick=\"ClearUser('SMS_SELECT_REMIND_TO_ID', 'SMS_SELECT_REMIND_TO_NAME')\">清空</a></span>";
				}
				return "";
}

function sms2_select_remind( $SMS_TYPE, $SMS_CHECKED = "" )
{
				global $connection;
				global $LOGIN_USER_ID;
				$query = "select * from SMS2_PRIV";
				$cursor = exequery( $connection, $query );
				if ( $ROW = mysql_fetch_array( $cursor ) )
				{
								$TYPE_PRIV = $ROW['TYPE_PRIV'];
								$SMS2_REMIND_PRIV = $ROW['SMS2_REMIND_PRIV'];
				}
				if ( find_id( $TYPE_PRIV, $SMS_TYPE ) && find_id( $SMS2_REMIND_PRIV, $LOGIN_USER_ID ) )
				{
								return "<input type=\"radio\" name=\"SMS2_SELECT_REMIND\" id=\"SMS2_SELECT_REMIND0\" value=\"0\" onclick=\"document.getElementById('SMS2_SELECT_REMIND_SPAN').style.display='';\"".( $SMS_CHECKED != "1" ? " checked" : "" )."><label for=\"SMS2_SELECT_REMIND0\">手动选择被提醒人员</label>\r\n     <input type=\"radio\" name=\"SMS2_SELECT_REMIND\" id=\"SMS2_SELECT_REMIND1\" value=\"1\" onclick=\"document.getElementById('SMS2_SELECT_REMIND_SPAN').style.display='none';\"".( $SMS_CHECKED == "1" ? " checked" : "" )."><label for=\"SMS2_SELECT_REMIND1\">提醒全部有权限人员</label><br>\r\n     <span id=\"SMS2_SELECT_REMIND_SPAN\">\r\n     <textarea cols=40 name=\"SMS2_SELECT_REMIND_TO_NAME\" rows=\"2\" class=\"BigStatic\" wrap=\"yes\" readonly></textarea>\r\n     <input type=\"hidden\" name=\"SMS2_SELECT_REMIND_TO_ID\" value=\"\">\r\n     <a href=\"javascript:;\" class=\"orgAdd\" onClick=\"SelectUser('','SMS2_SELECT_REMIND_TO_ID', 'SMS2_SELECT_REMIND_TO_NAME')\">添加</a>\r\n     <a href=\"javascript:;\" class=\"orgClear\" onClick=\"ClearUser('SMS2_SELECT_REMIND_TO_ID', 'SMS2_SELECT_REMIND_TO_NAME')\">清空</a></span>";
				}
}

function page_bar( $current_start_item, $total_items, $page_size = 10, $var_name = "start", $script_href = NULL, $direct_print = FALSE )
{
				if ( $current_start_item < 0 || $total_items < $current_start_item )
				{
								$current_start_item = 0;
				}
				if ( $script_href == NULL )
				{
								$script_href = $_SERVER['PHP_SELF'];
				}
				if ( $_SERVER['QUERY_STRING'] != "" )
				{
								$script_href .= "?".$_SERVER['QUERY_STRING'];
				}
				$script_href = preg_replace( "/^(.+)(\\?|&)TOTAL_ITEMS=[^&]+&?(.*)$/i", "$1$2$3", $script_href );
				$script_href = preg_replace( "/^(.+)(\\?|&)PAGE_SIZE=[^&]+&?(.*)$/i", "$1$2$3", $script_href );
				$script_href = preg_replace( "/^(.+)(\\?|&)".$var_name."=[^&]+&?(.*)$/i", "$1$2$3", $script_href );
				if ( substr( $script_href, -1 ) == "&" || substr( $script_href, -1 ) == "?" )
				{
								$script_href = substr( $script_href, 0, -1 );
				}
				$hyphen = strstr( $script_href, "?" ) === FALSE ? "?" : "&";
				$num_pages = ceil( $total_items / $page_size );
				$cur_page = ceil( $current_start_item / $page_size ) + 1;
				$result_str .= "<script>function goto_page(){var page_no=parseInt(document.getElementById('page_no').value);if(isNaN(page_no)||page_no<1||page_no>".$num_pages."){alert(\"".sprintf( _( "页数必须为1-%s" ), $num_pages )."\");return;}window.location=\"".$script_href.$hyphen.$var_name."=\"+(page_no-1)*".$page_size."+\"&TOTAL_ITEMS=".$total_items."&PAGE_SIZE=".$page_size."\";} function input_page_no(){if(event.keyCode==13) goto_page();if(event.keyCode<47||event.keyCode>57) event.returnValue=false;}</script>";
				$result_str .= "<div id=\"pageArea\" class=\"pageArea\">\n".sprintf( _( "第%s页" ), "<span id=\"pageNumber\" class=\"pageNumber\">".$cur_page."/".$num_pages."</span>" );
				if ( $cur_page <= 1 )
				{
								$result_str .= "<a href=\"javascript:;\" id=\"pageFirst\" class=\"pageFirstDisable\" title=\""._( "首页" )."\"></a>\r\n  <a href=\"javascript:;\" id=\"pagePrevious\" class=\"pagePreviousDisable\" title=\""._( "上一页" )."\"></a>";
				}
				else
				{
								$result_str .= "<a href=\"".$script_href.$hyphen.$var_name."=0&TOTAL_ITEMS=".$total_items."&PAGE_SIZE=".$page_size."\" id=\"pageFirst\" class=\"pageFirst\" title=\""._( "首页" )."\"></a>\r\n  <a href=\"".$script_href.$hyphen.$var_name."=".( $current_start_item - $page_size )."&TOTAL_ITEMS=".$total_items."&PAGE_SIZE=".$page_size."\" id=\"pagePrevious\" class=\"pagePrevious\" title=\""._( "上一页" )."\"></a>";
				}
				if ( $num_pages <= $cur_page )
				{
								$result_str .= "<a href=\"javascript:;\" id=\"pageNext\" class=\"pageNextDisable\" title=\""._( "下一页" )."\"></a>\r\n  <a href=\"javascript:;\" id=\"pageLast\" class=\"pageLastDisable\" title=\""._( "末页" )."\"></a>";
				}
				else
				{
								$result_str .= "<a href=\"".$script_href.$hyphen.$var_name."=".( $current_start_item + $page_size )."&TOTAL_ITEMS=".$total_items."&PAGE_SIZE=".$page_size."\" id=\"pageNext\" class=\"pageNext\" title=\""._( "下一页" )."\"></a>\r\n  <a href=\"".$script_href.$hyphen.$var_name."=".( 0 < $total_items % $page_size ? $total_items - $total_items % $page_size : $total_items - $page_size )."&TOTAL_ITEMS=".$total_items."&PAGE_SIZE=".$page_size."\" id=\"pageLast\" class=\"pageLast\" title=\""._( "末页" )."\"></a>";
				}
				$result_str .= sprintf( _( "转到 第 %s 页 " ), "<input type=\"text\" size=\"3\" class=\"SmallInput\" name=\"page_no\" id=\"page_no\" onkeypress=\"input_page_no()\" style='text-align:center;'>" )."<a href=\"javascript:goto_page();\" id=\"pageGoto\" class=\"pageGoto\" title=\""._( "转到" )."\"></a>";
				$result_str .= "</div>";
				if ( $direct_print )
				{
								echo $result_str;
				}
				else
				{
								return $result_str;
				}
}

function get_page_size( $MODULE, $DEFAULT_SIZE = 10 )
{
				$PARA_ARRAY = get_sys_para( "PAGE_BAR_SIZE" );
				$PAGE_SIZE_ARRAY = unserialize( $PARA_ARRAY['PAGE_BAR_SIZE'] );
				$PAGE_SIZE = intval( $PAGE_SIZE_ARRAY[$MODULE] );
				$PAGE_SIZE = 0 < $PAGE_SIZE ? $PAGE_SIZE : $DEFAULT_SIZE;
				return $PAGE_SIZE;
}

function get_font_size( $MODULE, $DEFAULT_SIZE = 10 )
{
				$PARA_ARRAY = get_sys_para( "HTML_FONT_SIZE" );
				$FONT_SIZE_ARRAY = unserialize( $PARA_ARRAY['HTML_FONT_SIZE'] );
				$FONT_SIZE = intval( $FONT_SIZE_ARRAY[$MODULE] );
				$FONT_SIZE = 0 < $FONT_SIZE ? $FONT_SIZE : $DEFAULT_SIZE;
				return $FONT_SIZE;
}

function send_mail( $FROM, $TO, $SUBJECT, $BODY, $SMTP_SERVER, $SMTP_USER, $SMTP_PASS, $SMTP_AUTH = TRUE, $FROM_NAME = "", $REPLY_TO = "", $CC = "", $BCC = "", $ATTACHMENT = "", $IS_HTML = TRUE, $SMTP_PORT = 25, $SMTPSecure = "" )
{
				global $ATTACH_PATH2;
				global $LANG_COOKIE;
				global $MYOA_CHARSET;
				include_once( "inc/phpmailer/class.phpmailer.php" );
				include_once( "inc/utility_file.php" );
				$mail = new PHPMailer( );
				$mail->CharSet = $MYOA_CHARSET;
				$mail->SetLanguage( $LANG_COOKIE );
				$mail->IsSMTP( );
				$mail->Host = $SMTP_SERVER;
				$mail->Port = $SMTP_PORT;
				$mail->SMTPAuth = $SMTP_AUTH;
				$mail->SMTPSecure = $SMTPSecure;
				$mail->Username = $SMTP_USER;
				$mail->Password = $SMTP_PASS;
				$mail->From = $FROM;
				$mail->FromName = $FROM_NAME;
				$mail->AddReplyTo( $FROM, $FROM_NAME );
				$mail->WordWrap = 50;
				$mail->IsHTML( $IS_HTML );
				$mail->Subject = $SUBJECT;
				$mail->Body = $BODY;
				$mail->AltBody = strip_tags( $BODY );
				$TOK = strtok( $TO, "," );
				while ( $TOK != "" )
				{
								$mail->AddAddress( $TOK );
								$TOK = strtok( "," );
				}
				$TOK = strtok( $CC, "," );
				while ( $TOK != "" )
				{
								$mail->AddCC( $TOK );
								$TOK = strtok( "," );
				}
				$TOK = strtok( $BCC, "," );
				while ( $TOK != "" )
				{
								$mail->AddBCC( $TOK );
								$TOK = strtok( "," );
				}
				$TOK = strtok( $ATTACHMENT, "*" );
				while ( $TOK != "" )
				{
								$FILENAME = substr( $TOK, strrpos( $TOK, "/" ) + 1 );
								if ( strtolower( substr( $TOK, 0, strlen( $ATTACH_PATH2 ) + strlen( attach_sub_dir( ) ) ) ) == strtolower( $ATTACH_PATH2 ).attach_sub_dir( ) )
								{
												$FILENAME = substr( $FILENAME, strpos( $FILENAME, "." ) + 1 );
								}
								$mail->AddAttachment( $TOK, $FILENAME );
								$TOK = strtok( "*" );
				}
				if ( $mail->Send( ) )
				{
								return TRUE;
				}
				return $mail->ErrorInfo;
}

function send_email( $LOGIN_USER_ID, $FORM_EMAIL, $TO_EMAIL_STR, $EMAIL_CONTENT, $MAIL_TITLE )
{
				global $connection;
				global $LOGIN_USER_NAME;
				$query = "SELECT * from WEBMAIL where EMAIL='".$FORM_EMAIL."' and USER_ID='{$LOGIN_USER_ID}'";
				$cursor = exequery( $connection, $query );
				if ( $ROW = mysql_fetch_array( $cursor ) )
				{
								$POP_SERVER = $ROW['POP_SERVER'];
								$SMTP_SERVER = $ROW['SMTP_SERVER'];
								$LOGIN_TYPE = $ROW['LOGIN_TYPE'];
								$SMTP_PASS = $ROW['SMTP_PASS'];
								$SMTP_PORT = $ROW['SMTP_PORT'];
								$SMTP_SSL = $ROW['SMTP_SSL'] == "1" ? "ssl" : "";
								$EMAIL_PASS = $ROW['EMAIL_PASS'];
								$EMAIL_PASS = td_authcode( $EMAIL_PASS, "DECODE" );
				}
				return send_mail( $FORM_EMAIL, $TO_EMAIL_STR, $MAIL_TITLE, $EMAIL_CONTENT, $SMTP_SERVER, $FORM_EMAIL, $EMAIL_PASS, TRUE, $LOGIN_USER_NAME, "", "", "", "", TRUE, $SMTP_PORT, $SMTP_SSL );
}

function unescape( $str )
{
				$str = rawurldecode( $str );
				$count = preg_match_all( "/(?:%u.{4})|&#x.{4};|&#\\d+;|.+/U", $str, $r );
				if ( $count )
				{
								return $str;
				}
				$ar = $r[0];
				foreach ( $ar as $k => $v )
				{
								if ( substr( $v, 0, 2 ) == "%u" )
								{
												$ar[$k] = iconv( "UCS-2", ini_get( "default_charset" ), pack( "H4", substr( $v, -4 ) ) );
								}
								else if ( substr( $v, 0, 3 ) == "&#x" )
								{
												$ar[$k] = iconv( "UCS-2", ini_get( "default_charset" ), pack( "H4", substr( $v, 3, -1 ) ) );
								}
								else if ( substr( $v, 0, 2 ) == "&#" )
								{
												$ar[$k] = iconv( "UCS-2", ini_get( "default_charset" ), pack( "n", substr( $v, 2, -1 ) ) );
								}
				}
				return str_replace( "\\\\", "\\", join( "", $ar ) );
}

function flow_sort_tree( $SORT_ID, $SORT_CHOOSE )
{
				include_once( "inc/utility_org.php" );
				global $connection;
				global $DEEP_COUNT;
				global $LOGIN_USER_PRIV;
				global $LOGIN_DEPT_ID;
				global $LOGIN_USER_PRIV_OTHER;
				$query = "SELECT * from FLOW_SORT where SORT_PARENT=".$SORT_ID." order by SORT_NO";
				$cursor = exequery( $connection, $query );
				$OPTION_TEXT = "";
				$DEEP_COUNT1 = $DEEP_COUNT;
				$DEEP_COUNT .= "│";
				$COUNT = 0;
				while ( $ROW = mysql_fetch_array( $cursor ) )
				{
								++$COUNT;
								$SORT_ID = $ROW['SORT_ID'];
								$SORT_NAME = $ROW['SORT_NAME'];
								$SORT_PARENT = $ROW['SORT_PARENT'];
								$HAVE_CHILD = $ROW['HAVE_CHILD'];
								$DEPT_ID = $ROW['DEPT_ID'];
								if ( $LOGIN_USER_PRIV != 1 && !find_id( $LOGIN_USER_PRIV_OTHER, 1 ) && $DEPT_ID != $LOGIN_DEPT_ID && $DEPT_ID != 0 && !is_dept_parent( $LOGIN_DEPT_ID, $DEPT_ID ) )
								{
								}
								else
								{
												$SORT_NAME = htmlspecialchars( $SORT_NAME );
												$POSTFIX = _( "　" );
												if ( $COUNT == mysql_num_rows( $cursor ) )
												{
																$DEEP_COUNT = substr( $DEEP_COUNT, 0, 0 - strlen( $POSTFIX ) ).$POSTFIX;
												}
												if ( $HAVE_CHILD == 1 )
												{
																$OPTION_TEXT_CHILD = flow_sort_tree( $SORT_ID, $SORT_CHOOSE );
												}
												$OPTION_TEXT .= "<option ";
												if ( $SORT_ID == $SORT_CHOOSE )
												{
																$OPTION_TEXT .= "selected ";
												}
												if ( $COUNT == mysql_num_rows( $cursor ) )
												{
																$OPTION_TEXT .= "value=".$SORT_ID.">".$DEEP_COUNT1."└".$SORT_NAME."</option>\n";
												}
												else
												{
																$OPTION_TEXT .= "value=".$SORT_ID.">".$DEEP_COUNT1."├".$SORT_NAME."</option>\n";
												}
												if ( !( $HAVE_CHILD != 0 ) || !( $OPTION_TEXT_CHILD != "" ) )
												{
																$OPTION_TEXT .= $OPTION_TEXT_CHILD;
												}
								}
				}
				$DEEP_COUNT = $DEEP_COUNT1;
				return $OPTION_TEXT;
}

function form_sort_tree( $SORT_ID, $SORT_CHOOSE )
{
				include_once( "inc/utility_org.php" );
				global $connection;
				global $DEEP_COUNT;
				global $LOGIN_USER_PRIV;
				global $LOGIN_DEPT_ID;
				global $LOGIN_USER_PRIV_OTHER;
				$query = "SELECT * from FORM_SORT where SORT_PARENT=".$SORT_ID." order by SORT_NO";
				$cursor = exequery( $connection, $query );
				$OPTION_TEXT = "";
				$DEEP_COUNT1 = $DEEP_COUNT;
				$DEEP_COUNT .= "│";
				$COUNT = 0;
				while ( $ROW = mysql_fetch_array( $cursor ) )
				{
								++$COUNT;
								$SORT_ID = $ROW['SORT_ID'];
								$SORT_NAME = $ROW['SORT_NAME'];
								$SORT_PARENT = $ROW['SORT_PARENT'];
								$HAVE_CHILD = $ROW['HAVE_CHILD'];
								$DEPT_ID = $ROW['DEPT_ID'];
								if ( $LOGIN_USER_PRIV != 1 && !find_id( $LOGIN_USER_PRIV_OTHER, 1 ) && $DEPT_ID != $LOGIN_DEPT_ID && $DEPT_ID != 0 && !is_dept_parent( $LOGIN_DEPT_ID, $DEPT_ID ) )
								{
								}
								else
								{
												$SORT_NAME = htmlspecialchars( $SORT_NAME );
												$POSTFIX = _( "　" );
												if ( $COUNT == mysql_num_rows( $cursor ) )
												{
																$DEEP_COUNT = substr( $DEEP_COUNT, 0, 0 - strlen( $POSTFIX ) ).$POSTFIX;
												}
												if ( $HAVE_CHILD == 1 )
												{
																$OPTION_TEXT_CHILD = form_sort_tree( $SORT_ID, $SORT_CHOOSE );
												}
												echo $SORT_ID." ".$SORT_CHOOSE."<br />";
												$OPTION_TEXT .= "<option ";
												if ( $SORT_ID == $SORT_CHOOSE )
												{
																$OPTION_TEXT .= "selected ";
												}
												if ( $COUNT == mysql_num_rows( $cursor ) )
												{
																$OPTION_TEXT .= "value=".$SORT_ID.">".$DEEP_COUNT1."└".$SORT_NAME."</option>\n";
												}
												else
												{
																$OPTION_TEXT .= "value=".$SORT_ID.">".$DEEP_COUNT1."├".$SORT_NAME."</option>\n";
												}
												if ( !( $HAVE_CHILD != 0 ) || !( $OPTION_TEXT_CHILD != "" ) )
												{
																$OPTION_TEXT .= $OPTION_TEXT_CHILD;
												}
								}
				}
				$DEEP_COUNT = $DEEP_COUNT1;
				return $OPTION_TEXT;
}

function check_priv( $PRIV_STR )
{
				global $LOGIN_DEPT_ID;
				global $LOGIN_USER_PRIV;
				global $LOGIN_USER_ID;
				global $LOGIN_USER_PRIV_OTHER;
				$PRIV_ARRAY = explode( "|", $PRIV_STR );
				if ( $PRIV_ARRAY[0] == "ALL_DEPT" || find_id( $PRIV_ARRAY[0], $LOGIN_DEPT_ID ) || check_dept_other_priv( $PRIV_ARRAY[0] ) || find_id( $PRIV_ARRAY[1], $LOGIN_USER_PRIV ) || check_id( $PRIV_ARRAY[1], $LOGIN_USER_PRIV_OTHER, 1 ) != "" || find_id( $PRIV_ARRAY[2], $LOGIN_USER_ID ) )
				{
								return TRUE;
				}
				return FALSE;
}

function check_dept_other_priv( $PRIV_STR )
{
				global $LOGIN_DEPT_ID_OTHER;
				if ( $LOGIN_DEPT_ID_OTHER == "" )
				{
								return FALSE;
				}
				$ID_ARRAY = explode( ",", $LOGIN_DEPT_ID_OTHER );
				$I = 0;
				for ( ;	$I < count( $ID_ARRAY );	++$I	)
				{
								if ( $ID_ARRAY[$I] == "" || !find_id( $PRIV_STR, $ID_ARRAY[$I] ) )
								{
												return TRUE;
								}
				}
				return FALSE;
}

function CSV2Array( $content, $title = array( ), $delimiter = ",", $enclosure = "\"", $optional = 1 )
{
				$content = trim( $content );
				$content = str_replace( "\r", "", $content );
				$csv_array = array( );
				$expr_line = "/\\n(?=(?:[^".$enclosure."]*".$enclosure."[^".$enclosure."]*".$enclosure.")*(?![^".$enclosure."]*".$enclosure."))/";
				$expr_field = "/".$delimiter."(?=(?:[^".$enclosure."]*".$enclosure."[^".$enclosure."]*".$enclosure.")*(?![^".$enclosure."]*".$enclosure."))/";
				$lines = preg_split( $expr_line, trim( $content ) );
				foreach ( $lines as $line )
				{
								$fields = preg_split( $expr_field, trim( $line ) );
								$csv_array[] = preg_replace( array( "/\"(.*)\"$/s", "/\"\"/s", "/\\<\\?/s" ), array( "$1", "\"", "&lt;?_(" ), $fields );
				}
				if ( !is_array( $title ) || count( $title ) == 0 || count( $csv_array ) == 0 )
				{
								return $csv_array;
				}
				$field_map = array( );
				while ( list( $key, $value ) = each( $title ) )
				{
								if ( ( $index = array_search( $key, $csv_array[0] ) ) !== FALSE )
								{
												$field_map[$value] = $index;
								}
				}
				$lines = array( );
				$i = 1;
				for ( ;	$i < count( $csv_array );	++$i	)
				{
								$line = array( );
								reset( $field_map );
								while ( list( $key, $value ) = each( $field_map ) )
								{
												$line[$key] = $csv_array[$i][$value];
								}
								$lines[] = $line;
				}
				return $lines;
}

function add_sys_para( $PARA_ARRAY )
{
				global $connection;
				$PARA_VALUE = each( $PARA_ARRAY )[1];
				$PARA_NAME = each( $PARA_ARRAY )[0];
				while ( each( $PARA_ARRAY ) )
				{
								$query = "SELECT * from SYS_PARA where PARA_NAME='".$PARA_NAME."'";
								$cursor = exequery( $connection, $query );
								if ( mysql_num_rows( $cursor ) <= 0 )
								{
												$query = "insert into SYS_PARA (PARA_NAME, PARA_VALUE) values('".$PARA_NAME."', '{$PARA_VALUE}')";
												exequery( $connection, $query );
								}
				}
}

function get_sys_para( $PARA_NAME_STR )
{
				global $connection;
				$PARA_ARRAY = array( );
				$query = "SELECT * from SYS_PARA where find_in_set(PARA_NAME, '".$PARA_NAME_STR."')";
				$cursor = exequery( $connection, $query );
				while ( $ROW = mysql_fetch_array( $cursor ) )
				{
								$PARA_ARRAY[$ROW['PARA_NAME']] = $ROW['PARA_VALUE'];
				}
				return $PARA_ARRAY;
}

function set_sys_para( $PARA_ARRAY )
{
				global $connection;
				$PARA_VALUE = each( $PARA_ARRAY )[1];
				$PARA_NAME = each( $PARA_ARRAY )[0];
				while ( each( $PARA_ARRAY ) )
				{
								$query = "update SYS_PARA set PARA_VALUE='".$PARA_VALUE."' where PARA_NAME='{$PARA_NAME}'";
								exequery( $connection, $query );
				}
}

function add_sys_code( $CODE_ARRAY )
{
				global $connection;
				if ( !is_array( $CODE_ARRAY ) || sizeof( $CODE_ARRAY ) < 1 )
				{
				}
				else
				{
								foreach ( $CODE_ARRAY as $FLAG => $SYS_CODE )
								{
												if ( $SYS_CODE['PARENT_NO'] == "" )
												{
																$query = "SELECT 1 from SYS_CODE where CODE_NO='".$SYS_CODE['CODE_NO']."'";
																$cursor = exequery( $connection, $query );
																if ( 0 < mysql_num_rows( $cursor ) )
																{
																				$FLAG = FALSE;
																}
												}
												if ( $FLAG )
												{
																$query = "insert into SYS_CODE (`CODE_NO`, `CODE_NAME`, `CODE_ORDER`, `PARENT_NO`, `CODE_FLAG`, `CODE_EXT`) values('".$SYS_CODE['CODE_NO']."', '".$SYS_CODE['CODE_NAME']."', '".$SYS_CODE['CODE_ORDER']."', '".$SYS_CODE['PARENT_NO']."', '".$SYS_CODE['CODE_FLAG']."', '".mysql_escape_string( $SYS_CODE['CODE_EXT'] )."')";
																exequery( $connection, $query );
												}
								}
				}
}

function menu_arrow( $DIRECTION = "DOWN" )
{
}

function netMatch( $network, $ip )
{
				$network = trim( $network );
				$ip = trim( $ip );
				$d = strpos( $network, "-" );
				if ( $d === FALSE )
				{
								$ip_arr = explode( "/", $network );
								if ( preg_match( "@\\d*\\.\\d*\\.\\d*\\.\\d*@", $ip_arr[0], $matches ) )
								{
												$ip_arr .= 0;
								}
								$network_long = ip2long( $ip_arr[0] );
								$x = ip2long( $ip_arr[1] );
								$mask = long2ip( $x ) == $ip_arr[1] ? $x : -1 << 32 - $ip_arr[1];
								$ip_long = ip2long( $ip );
								return ( $ip_long & $mask ) == ( $network_long & $mask );
				}
				$from = ip2long( trim( substr( $network, 0, $d ) ) );
				$to = ip2long( trim( substr( $network, $d + 1 ) ) );
				$ip = ip2long( $ip );
				return $ip <= $to;
}

function cal_level_desc( $level = "" )
{
				switch ( $level )
				{
								case "1" :
												return _( "重要/紧急" );
								case "2" :
												return _( "重要/不紧急" );
								case "3" :
												return _( "不重要/紧急" );
								case "4" :
												return _( "不重要/不紧急" );
								default :
												return _( "未指定" );
				}
}

function cal_color_desc( $color = "" )
{
				switch ( $color )
				{
								case "1" :
												return _( "红色类别" );
								case "2" :
												return _( "黄色类别" );
								case "3" :
												return _( "绿色类别" );
								case "4" :
												return _( "橙色类别" );
								case "5" :
												return _( "蓝色类别" );
								case "6" :
												return _( "紫色类别" );
								default :
												return _( "未指定" );
				}
}

function censor( $message, $module )
{
				global $SYS_CENSOR_WORDS;
				global $SYS_CENSOR_MODULE;
				require_once( "inc/censor_words.php" );
				if ( array_key_exists( $module, $SYS_CENSOR_MODULE ) )
				{
								return $message;
				}
				if ( $SYS_CENSOR_WORDS['banned'] && preg_match( $SYS_CENSOR_WORDS['banned'], $message ) )
				{
								if ( $SYS_CENSOR_MODULE[$module]['BANNED_HINT'] )
								{
												message( _( "禁止" ), $SYS_CENSOR_MODULE[$module]['BANNED_HINT'] );
								}
								return "BANNED";
				}
				if ( $SYS_CENSOR_WORDS['mod'] && preg_match( $SYS_CENSOR_WORDS['mod'], $message ) )
				{
								include_once( "inc/utility_sms1.php" );
								if ( $SYS_CENSOR_MODULE[$module]['MOD_HINT'] )
								{
												message( "", $SYS_CENSOR_MODULE[$module]['MOD_HINT'] );
								}
								if ( $SYS_CENSOR_MODULE[$module]['SMS_REMIND'] )
								{
												send_sms( "", "admin", $SYS_CENSOR_MODULE[$module]['CHECK_USER'], "22", sprintf( _( "有新的 %s 需要您审核" ), $SYS_CENSOR_MODULE[$module]['MODULE_NAME'] ), "system/censor_check" );
								}
								if ( $SYS_CENSOR_MODULE[$module]['SMS2_REMIND'] )
								{
												send_mobile_sms_user( "", "admin", $SYS_CENSOR_MODULE[$module]['CHECK_USER'], sprintf( _( "有新的 %s 需要您审核" ), $SYS_CENSOR_MODULE[$module]['MODULE_NAME'] ), "22" );
								}
								return "MOD";
				}
				if ( $SYS_CENSOR_MODULE[$module]['FILTER_HINT'] )
				{
								message( "", $SYS_CENSOR_MODULE[$module]['FILTER_HINT'] );
				}
				if ( empty( $SYS_CENSOR_WORDS['filter'] ) )
				{
								return $message;
				}
				return preg_replace( $SYS_CENSOR_WORDS['filter']['find'], $SYS_CENSOR_WORDS['filter']['replace'], $message );
}

function censor_highlight( $message )
{
				global $SYS_CENSOR_HIGHLIGHT;
				require_once( "inc/censor_words.php" );
				if ( is_array( $SYS_CENSOR_HIGHLIGHT['filter'] ) )
				{
								$message = preg_replace( $SYS_CENSOR_HIGHLIGHT['filter'], "<span style=\"color:#0000FF;background: #FFFF00;text-decoration: underline;\" title=_(\"过滤词汇\")>\\1</span>", $message );
				}
				if ( is_array( $SYS_CENSOR_HIGHLIGHT['banned'] ) )
				{
								$message = preg_replace( $SYS_CENSOR_HIGHLIGHT['banned'], "<span style=\"color:#FF0000;background: #FFFF00;text-decoration: underline;\" title=_(\"禁止词汇\")>\\1</span>", $message );
				}
				if ( is_array( $SYS_CENSOR_HIGHLIGHT['mod'] ) )
				{
								$message = preg_replace( $SYS_CENSOR_HIGHLIGHT['mod'], "<span style=\"color:#000000;background: #FFFF00;text-decoration: underline;\" title=_(\"审核词汇\")>\\1</span>", $message );
				}
				return $message;
}

function cache_censor_words( )
{
				global $connection;
				$banned = $mod = array( );
				$data = array( "filter" => array( ), "banned" => "", "mod" => "" );
				$highlight = array( "filter" => array( ), "banned" => array( ), "mod" => array( ) );
				$query = "select * from CENSOR_WORDS";
				$cursor = exequery( $connection, $query );
				while ( $ROW = mysql_fetch_array( $cursor ) )
				{
								$ROW['FIND'] = preg_replace( "/\\\\{(\\d+)\\\\}/", ".{0,\\1}", preg_quote( $ROW['FIND'], "/" ) );
								switch ( $ROW['REPLACEMENT'] )
								{
												case "{BANNED}" :
																$banned[] = $ROW['FIND'];
																$highlight['banned'][] = "&(".$ROW['FIND'].")&iU";
																break;
												case "{MOD}" :
																$mod[] = $ROW['FIND'];
																$highlight['mod'][] = "&(".$ROW['FIND'].")&iU";
																break;
												default :
																$data['filter']['find'][] = "/".$ROW['FIND']."/i";
																$data['filter']['replace'][] = $ROW['REPLACEMENT'];
																$highlight['filter'][] = "&(".$ROW['FIND'].")&iU";
								}
				}
				if ( $banned )
				{
								$data['banned'] = "/(".implode( "|", $banned ).")/i";
				}
				if ( $mod )
				{
								$data['mod'] = "/(".implode( "|", $mod ).")/i";
				}
				global $td_cache;
				global $SYS_CENSOR_WORDS;
				global $SYS_CENSOR_HIGHLIGHT;
				$SYS_CENSOR_WORDS = $data;
				$SYS_CENSOR_HIGHLIGHT = $highlight;
				$SYS_CENSOR_CACHE = array( "SYS_CENSOR_WORDS" => $SYS_CENSOR_WORDS, "SYS_CENSOR_HIGHLIGHT" => $SYS_CENSOR_HIGHLIGHT );
				include_once( "inc/cache/Cache.php" );
				$td_cache->set( "SYS_CENSOR_CACHE", $SYS_CENSOR_CACHE, 0 );
}

function cache_censor_module( )
{
				global $connection;
				$module = array( );
				$query = "select * from CENSOR_MODULE where USE_FLAG='1'";
				$cursor = exequery( $connection, $query );
				while ( $ROW = mysql_fetch_array( $cursor ) )
				{
								$MODULE_CODE = $ROW['MODULE_CODE'];
								$module[$MODULE_CODE]['MODULE_NAME'] = get_code_name( $MODULE_CODE, "CENSOR_MODULE" );
								$module[$MODULE_CODE]['CHECK_USER'] = $ROW['CHECK_USER'];
								$module[$MODULE_CODE]['SMS_REMIND'] = $ROW['SMS_REMIND'];
								$module[$MODULE_CODE]['SMS2_REMIND'] = $ROW['SMS2_REMIND'];
								$module[$MODULE_CODE]['BANNED_HINT'] = $ROW['BANNED_HINT'];
								$module[$MODULE_CODE]['MOD_HINT'] = $ROW['MOD_HINT'];
								$module[$MODULE_CODE]['FILTER_HINT'] = $ROW['FILTER_HINT'];
				}
				global $td_cache;
				global $SYS_CENSOR_MODULE;
				$SYS_CENSOR_MODULE = $module;
				include_once( "inc/cache/Cache.php" );
				$td_cache->set( "SYS_CENSOR_MODULE", $SYS_CENSOR_MODULE, 0 );
}

function censor_data( $MODULE_CODE, $CONTENT )
{
				global $connection;
				$CONTENT = serialize( $CONTENT );
				$query = "insert into CENSOR_DATA(MODULE_CODE,CENSOR_FLAG,CONTENT) values ('".$MODULE_CODE."','0','{$CONTENT}')";
				exequery( $connection, $query );
}

function arrayeval( $array, $level = 0 )
{
				if ( is_array( $array ) )
				{
								return "'".$array."'";
				}
				if ( is_array( $array ) && function_exists( "var_export" ) )
				{
								return var_export( $array, TRUE );
				}
				$space = "";
				$i = 0;
				for ( ;	$i <= $level;	++$i	)
				{
								$space .= "\t";
				}
				$evaluate = "Array\n".$space."(\n";
				$comma = $space;
				if ( is_array( $array ) )
				{
								foreach ( $array as $key => $val )
								{
												$key = is_string( $key ) ? "'".addcslashes( $key, "'\\" )."'" : $key;
												$val = !is_array( $val ) && ( !preg_match( "/^\\-?[1-9]\\d*$/", $val ) || 12 < strlen( $val ) ) ? "'".addcslashes( $val, "'\\" )."'" : $val;
												if ( is_array( $val ) )
												{
																$evaluate .= "{$comma}{$key} => ".arrayeval( $val, $level + 1 );
												}
												else
												{
																$evaluate .= "{$comma}{$key} => {$val}";
												}
												$comma = ",\n".$space;
								}
				}
				$evaluate .= "\n".$space.")";
				return $evaluate;
}

function dept_other_sql( $FIELD = "TO_ID" )
{
				global $LOGIN_DEPT_ID_OTHER;
				if ( $LOGIN_DEPT_ID_OTHER == "" )
				{
								return "";
				}
				$ID_ARRAY = explode( ",", $LOGIN_DEPT_ID_OTHER );
				$I = 0;
				for ( ;	$I < count( $ID_ARRAY );	++$I	)
				{
								if ( $ID_ARRAY[$I] == "" )
								{
												$SQL_STR .= " or find_in_set('".$ID_ARRAY[$I]."', ".$FIELD.") ";
								}
				}
				return $SQL_STR;
}

function priv_other_sql( $FIELD = "PRIV_ID" )
{
				global $LOGIN_USER_PRIV_OTHER;
				if ( $LOGIN_USER_PRIV_OTHER == "" )
				{
								return "";
				}
				$ID_ARRAY = explode( ",", $LOGIN_USER_PRIV_OTHER );
				$I = 0;
				for ( ;	$I < count( $ID_ARRAY );	++$I	)
				{
								if ( $ID_ARRAY[$I] == "" )
								{
												$SQL_STR .= " or find_in_set('".$ID_ARRAY[$I]."', ".$FIELD.") ";
								}
				}
				return $SQL_STR;
}

function online_level( $ONLINE )
{
				$ONLINE_HOURS = floor( intval( $ONLINE ) / 3600 );
				$ONLINE_MINS = floor( intval( $ONLINE ) % 3600 / 60 );
				$ONLINE_LEVEL = floor( sqrt( floor( $ONLINE_HOURS / 8 ) + 4 ) - 2 );
				$LEVEL_CROWN = floor( $ONLINE_LEVEL / 64 );
				$LEVEL_SUN = floor( $ONLINE_LEVEL % 64 / 16 );
				$LEVEL_MOON = floor( $ONLINE_LEVEL % 16 / 4 );
				$LEVEL_STAR = $ONLINE_LEVEL % 4;
				$RETURN_STR .= str_repeat( "<img src=\"/images/time_crown.gif\" align=\"absMiddle\" />", $LEVEL_CROWN );
				$RETURN_STR .= str_repeat( "<img src=\"/images/time_sun.gif\" align=\"absMiddle\" />", $LEVEL_SUN );
				$RETURN_STR .= str_repeat( "<img src=\"/images/time_moon.gif\" align=\"absMiddle\" />", $LEVEL_MOON );
				$RETURN_STR .= str_repeat( "<img src=\"/images/time_star.gif\" align=\"absMiddle\" />", $LEVEL_STAR );
				return "<span title=\"在线时长：".$ONLINE_HOURS."小时 ".$ONLINE_MINS."分钟  等级：".$ONLINE_LEVEL."\">".$RETURN_STR."</span>";
}

function check_time_range( $RANGE, $TIME = "" )
{
				$RANGE = str_replace( array( "，", "-" ), array( ",", "~" ), $RANGE );
				$TIME = td_trim( $TIME );
				$RANGE = td_trim( $RANGE );
				if ( $RANGE == "" )
				{
								return TRUE;
				}
				$DATE = date( "Y-m-d" );
				if ( $TIME == "" )
				{
								$TIME = date( "H:i:s" );
				}
				$RANGE_ARRAY = explode( ",", $RANGE );
				$I = 0;
				for ( ;	$I < count( $RANGE_ARRAY );	++$I	)
				{
								$RANGE_I = explode( "~", $RANGE_ARRAY[$I] );
								if ( count( $RANGE_I ) != 2 || !( strtotime( $DATE." ".td_trim( $RANGE_I[0] ) ) <= strtotime( $DATE." ".$TIME ) ) || !( strtotime( $DATE." ".$TIME ) <= strtotime( $DATE." ".td_trim( $RANGE_I[1] ) ) ) )
								{
												return TRUE;
								}
				}
				return FALSE;
}

function get_ldap_option( $config )
{
				$dc_array = explode( ".", $config['DOMAIN_NAME'] );
				$base_dn = "DC=".implode( ",DC=", $dc_array );
				return array( "account_suffix" => "@".$config['DOMAIN_NAME'], "base_dn" => $base_dn, "domain_controllers" => array( $config['DOMAIN_CONTROLLERS'] ) );
}

function get_ou_array( $string, $separator = "," )
{
				$array = array( );
				$count = 0;
				$i = 0;
				for ( ;	$i < strlen( $string );	++$i	)
				{
								if ( $string[$i] == $separator && $string[$i - 1] != "\\" )
								{
												++$count;
								}
								else
								{
												$array .= $count;
								}
				}
				$i = 0;
				for ( ;	$i < count( $array );	++$i	)
				{
								if ( stristr( $array[$i], "=" ) )
								{
												$array[$i] = substr( $array[$i], strpos( $array[$i], "=" ) + 1 );
								}
				}
				return $array;
}

function bin2guid( $bin )
{
				$hex_guid = bin2hex( $bin );
				$hex_guid_to_guid_str = "";
				$k = 1;
				for ( ;	$k <= 4;	++$k	)
				{
								$hex_guid_to_guid_str .= substr( $hex_guid, 8 - 2 * $k, 2 );
				}
				$hex_guid_to_guid_str .= "-";
				$k = 1;
				for ( ;	$k <= 2;	++$k	)
				{
								$hex_guid_to_guid_str .= substr( $hex_guid, 12 - 2 * $k, 2 );
				}
				$hex_guid_to_guid_str .= "-";
				$k = 1;
				for ( ;	$k <= 2;	++$k	)
				{
								$hex_guid_to_guid_str .= substr( $hex_guid, 16 - 2 * $k, 2 );
				}
				$hex_guid_to_guid_str .= "-".substr( $hex_guid, 16, 4 );
				$hex_guid_to_guid_str .= "-".substr( $hex_guid, 20 );
				return strtoupper( $hex_guid_to_guid_str );
}

function get_org_array( $folder_list, $base_dn )
{
				$charset = strtolower( ini_get( "default_charset" ) );
				$charset = $charset == "gb2312" ? "gbk" : $charset;
				$org_dn_array = array( );
				$org_guid_array = array( );
				$i = 0;
				for ( ;	$i < $folder_list['count'];	++$i	)
				{
								$dn = $folder_list[$i]['dn'];
								if ( substr( $dn, 0, 22 ) == "OU=Domain Controllers," )
								{
												$org_dn_array[] = iconv( "utf-8", $charset, $dn );
												$org_guid_array[] = bin2guid( $folder_list[$i]['objectguid'][0] );
								}
				}
				$org_dn_new_array = array( );
				$i = 0;
				for ( ;	$i < count( $org_dn_array );	++$i	)
				{
								$string = substr( $org_dn_array[$i], 0, 0 - strlen( $base_dn ) );
								$array = get_ou_array( $string );
								$array = array_reverse( $array );
								$org_dn_new_array[$i] = implode( ",", $array );
				}
				asort( $org_dn_new_array );
				$org_array = array( );
				$tmp_array = array( );

if ( list( $key, $value ) = each( $org_dn_new_array ) )
{
				$array = get_ou_array( $value );
				$j = 0;
    for($i=1;$j < count( $array );$i++){
        $parent = $j == 0 ? -1 : array_search( ( ( ( ( $j - 1 )."_" ).$parent )."_" ).$array[$j - 1], $tmp_array );
												if ( in_array( $j."_".$parent."_".$array[$j], $tmp_array ) )
												{
																$org_array[] = array( "name" => $array[$j], "level" => $j, "parent" => $parent, "islast" => 1, "line" => "", "dn" => $org_dn_array[$key], "guid" => $org_guid_array[$key] );
																$tmp_array[] = $j."_".$parent."_".$array[$j];
												}
    }
//				do
//				{
//								for ( ;	$j < count( $array );	do
//	{
//	++$j,	} while ( 1 )	)
//								{
//												$parent = $j == 0 ? -1 : array_search( ( ( ( ( $j - 1 )."_" ).$parent )."_" ).$array[$j - 1], $tmp_array );
//												if ( in_array( $j."_".$parent."_".$array[$j], $tmp_array ) )
//												{
//																$org_array[] = array( "name" => $array[$j], "level" => $j, "parent" => $parent, "islast" => 1, "line" => "", "dn" => $org_dn_array[$key], "guid" => $org_guid_array[$key] );
//																$tmp_array[] = $j."_".$parent."_".$array[$j];
//												}
//								} while ( 1 );
//				}
				$i = 0;
				for ( ;	$i < count( $org_array );	++$i	)
				{
								$j = $i + 1;
								for ( ;	$j < count( $org_array );	++$j	)
								{
												if ( $org_array[$j]['level'] < $org_array[$i]['level'] )
												{
																if ( $org_array[$i]['level'] == $org_array[$j]['level'] )
																{
																				$org_array[$i]['islast'] = 0;
																}
												}
								}
								$org_array[$i]['line'] = $org_array[$i]['islast'] ? "└" : "├";
								$parent = $org_array[$i]['parent'];
								do
								{
												if ( 0 <= $parent )
												{
																$org_array[$i]['line'] = ( $org_array[$parent]['islast'] ? _( "　" ) : "│" ).$org_array[$i]['line'];
																$parent = $org_array[$parent]['parent'];
												}
								} while ( 1 );
				}
				return $org_array;
}
}

function copy_table( $TABLE_SRC, $TABLE_DEST = "", $COPY_DATA = TRUE, $TRUNCATE_SRC = FALSE )
{
				global $connection;
				global $MYSQL_DB;
				if ( $TABLE_DEST == "" )
				{
								$TABLE_DEST = $TABLE_SRC."_".date( "Ymd" );
				}
				$query = "show tables from ".$MYSQL_DB." like '".$TABLE_DEST."'";
				$cursor = exequery( $connection, $query );
				if ( 0 < mysql_num_rows( $cursor ) )
				{
								return sprintf( _( "表 %s 已存在" ), $TABLE_DEST );
				}
				$query = "create table `".$TABLE_DEST."` like `".$TABLE_SRC."`;";
				if ( exequery( $connection, $query ) === FALSE )
				{
								return sprintf( _( "创建表 %s 失败" ), $TABLE_DEST );
				}
				if ( $COPY_DATA )
				{
								$query = "insert into `".$TABLE_DEST."` select * from `".$TABLE_SRC."`;";
								exequery( $connection, $query );
								if ( mysql_affected_rows( ) <= 0 )
								{
												return _( "复制表数据错误" );
								}
				}
				if ( $TRUNCATE_SRC )
				{
								$query = "truncate table `".$TABLE_SRC."`";
								exequery( $connection, $query );
				}
				return TRUE;
}

function backup_tables( $TABLENAME )
{
				$TABLENAME = td_trim( $TABLENAME );
				if ( $TABLENAME == "" )
				{
								return FALSE;
				}
				global $connection;
				global $MYSQL_DB;
				global $BACKUP_PATH;
				$query = "SHOW VARIABLES like 'datadir'";
				$cursor = exequery( $connection, $query );
				if ( $ROW = mysql_fetch_array( $cursor ) )
				{
								$DATA_BASE_DIR = $ROW['Value'];
				}
				if ( $DATA_BASE_DIR == "" )
				{
								$DATA_BASE_DIR = "D:/MYOA/data5/";
				}
				$FILE_ARRAY = array( );
				$DATA_DIR = $DATA_BASE_DIR."/".$MYSQL_DB;
				$TABLE_ARRAY = explode( ",", $TABLENAME );
				foreach ( $TABLE_ARRAY as $TABLE )
				{
								if ( $TABLE == "" )
								{
												$FRM = $TABLE.".frm";
												$MYD = $TABLE.".MYD";
												$MYI = $TABLE.".MYI";
												if ( !file_exists( $DATA_DIR."/".$FRM ) || !file_exists( $DATA_DIR."/".$MYD ) || !file_exists( $DATA_DIR."/".$MYI ) )
												{
																return FALSE;
												}
												$LOCK_CMD .= $TABLE." write,";
												$FILE_ARRAY[] = $FRM;
												$FILE_ARRAY[] = $MYD;
												$FILE_ARRAY[] = $MYI;
								}
				}
				if ( count( $FILE_ARRAY ) == 0 )
				{
								return FALSE;
				}
				$BACKUP_DIR_SINGLE = str_replace( "//", "/", $BACKUP_PATH );
				if ( ( !file_exists( $BACKUP_DIR_SINGLE ) || !is_dir( $BACKUP_DIR_SINGLE ) ) && !mkdir( $BACKUP_DIR_SINGLE ) )
				{
								return FALSE;
				}
				$BACKUP_DIR_SINGLE .= "/".$MYSQL_DB."_CLEAN_".date( "YmdHis", time( ) );
				$BACKUP_DIR_SINGLE = str_replace( "//", "/", $BACKUP_DIR_SINGLE );
				if ( ( !file_exists( $BACKUP_DIR_SINGLE ) || !is_dir( $BACKUP_DIR_SINGLE ) ) && !mkdir( $BACKUP_DIR_SINGLE ) )
				{
								return FALSE;
				}
				$query = "FLUSH TABLES ".$TABLENAME;
				exequery( $connection, $query );
				$query = "LOCK TABLES ".td_trim( $LOCK_CMD );
				exequery( $connection, $query );
				$I = 0;
				for ( ;	$I < count( $FILE_ARRAY );	++$I	)
				{
								if ( @copy( @$DATA_DIR."/".@$FILE_ARRAY[$I], @$BACKUP_DIR_SINGLE."/".@$FILE_ARRAY[$I] ) )
								{
												return FALSE;
								}
				}
				$query = "UNLOCK TABLES";
				exequery( $connection, $query );
				return TRUE;
}

function repair_table( $TABLENAME )
{
				global $connection;
				$query = "check TABLE ".$TABLENAME;
				$cursor = exequery( $connection, $query );
				if ( $ROW = mysql_fetch_array( $cursor ) )
				{
								$Msg_text = $ROW['Msg_text'];
								if ( stristr( $Msg_text, "ok" ) )
								{
												return 1;
								}
								$query = "repair TABLE ".$TABLENAME;
								$cursor = exequery( $connection, $query );
								if ( $ROW = mysql_fetch_array( $cursor ) )
								{
												$Msg_text = $ROW['Msg_text'];
								}
								if ( stristr( $Msg_text, "ok" ) )
								{
												return 1;
								}
								return 0;
				}
				return 0;
}

function table_exists( $tableName, $database = "" )
{
				global $connection;
				$tableName = trim( $tableName );
				if ( $tableName == "" )
				{
								return FALSE;
				}
				if ( $database == "" )
				{
								$sql = "SHOW TABLES LIKE '".$tableName."'";
				}
				else
				{
								$sql = "SHOW TABLES FROM ".$database." LIKE '{$tableName}'";
				}
				$cursor = exequery( $connection, $sql );
				if ( 0 < mysql_num_rows( $cursor ) )
				{
								return TRUE;
				}
				return FALSE;
}

function field_exists( $tableName, $fieldName )
{
				global $connection;
				$tableName = trim( $tableName );
				$fieldName = trim( $fieldName );
				if ( $tableName == "" || $fieldName == "" )
				{
								return FALSE;
				}
				if ( table_exists( $tableName ) )
				{
								return FALSE;
				}
				$sql = "SHOW COLUMNS FROM ".$tableName." LIKE '{$fieldName}'";
				$cursor = exequery( $connection, $sql );
				if ( 0 < mysql_num_rows( $cursor ) )
				{
								return TRUE;
				}
				return FALSE;
}

function index_exists( $tableName, $indexName )
{
				global $connection;
				$tableName = trim( $tableName );
				$indexName = trim( $indexName );
				if ( $tableName == "" || $indexName == "" )
				{
								return FALSE;
				}
				if ( table_exists( $tableName ) )
				{
								return FALSE;
				}
				$sql = "SHOW INDEX FROM ".$tableName;
				$cursor = exequery( $connection, $sql );
				do
				{
								if ( $ROW = mysql_fetch_array( $cursor ) )
								{
								}
				} while ( !( $ROW['Key_name'] == $indexName ) );
				return TRUE;
				return FALSE;
}

function sys_menu_exists( $menu )
{
				if ( is_array( $menu ) )
				{
								return FALSE;
				}
				$where_str = "";
				if ( $menu['mid'] != "" )
				{
								$where_str = " and MENU_ID='".$menu['mid']."'";
				}
				if ( $menu['name'] != "" )
				{
								$where_str = " and MENU_NAME='".$menu['name']."'";
				}
				if ( $menu['image'] != "" )
				{
								$where_str = " and IMAGE='".$menu['image']."'";
				}
				if ( $where_str == "" )
				{
								return FALSE;
				}
				global $connection;
				$query = "select MENU_ID from SYS_MENU where 1=1 ".$where_str;
				$cursor = exequery( $connection, $query );
				if ( 0 < mysql_num_rows( $cursor ) )
				{
								return TRUE;
				}
				return FALSE;
}

function sys_func_exists( $menu )
{
				if ( is_array( $menu ) )
				{
								return FALSE;
				}
				$where_str = "";
				if ( $menu['fid'] != "" )
				{
								$where_str = " and FUNC_ID='".$menu['fid']."'";
				}
				if ( $menu['mid'] != "" )
				{
								$where_str = " and MENU_ID='".$menu['mid']."'";
				}
				if ( $menu['name'] != "" )
				{
								$where_str = " and FUNC_NAME='".$menu['name']."'";
				}
				if ( $menu['code'] != "" )
				{
								$where_str = " and FUNC_CODE='".$menu['code']."'";
				}
				if ( $where_str == "" )
				{
								return FALSE;
				}
				global $connection;
				$query = "select FUNC_ID from SYS_FUNCTION where 1=1 ".$where_str;
				$cursor = exequery( $connection, $query );
				if ( 0 < mysql_num_rows( $cursor ) )
				{
								return TRUE;
				}
				return FALSE;
}

function sys_code_exists( $CODE_NO, $PARENT_NO )
{
				return get_code_name( $CODE_NO, $PARENT_NO ) != "";
}

function add_templates( $ARRAY )
{
				global $ROOT_PATH;
				$INI_FILE = $ROOT_PATH."templates/template.ini";
				if ( !file_exists( $INI_FILE ) || !is_writable( $INI_FILE ) || !is_array( $ARRAY ) )
				{
								return FALSE;
				}
				$TEMPLATES_ARRAY = parse_ini_file( $INI_FILE );
				$TEMPLATES_DATA = trim( file_get_contents( $INI_FILE ) );
				if ( $TEMPLATES_DATA != "" )
				{
								$TEMPLATES_DATA .= "\r\n";
				}
				$VALUE = each( $ARRAY )[1];
				$KEY = each( $ARRAY )[0];
				while ( each( $ARRAY ) )
				{
								if ( array_key_exists( $KEY, $TEMPLATES_ARRAY ) )
								{
												$TEMPLATES_DATA .= $KEY."=".$VALUE."\r\n";
								}
				}
				file_put_contents( $INI_FILE, $TEMPLATES_DATA );
				return TRUE;
}

function get_hrms_code_name( $CODE_NO, $PARENT_NO )
{
				if ( $CODE_NO == "" || $PARENT_NO == "" )
				{
								return "";
				}
				global $connection;
				$POSTFIX = _( "，" );
				$query = "SELECT CODE_NAME from HR_CODE where PARENT_NO='".$PARENT_NO."' and find_in_set(CODE_NO,'{$CODE_NO}')";
				$cursor = exequery( $connection, $query );
				while ( $ROW = mysql_fetch_array( $cursor ) )
				{
								$CODE_NAME .= $ROW['CODE_NAME'].$POSTFIX;
				}
				return substr( $CODE_NAME, 0, 0 - strlen( $POSTFIX ) );
}

function hrms_code_list( $PARENT_NO, $SELECTED = "", $TYPE = "D", $FIELD_NAME = "" )
{
				if ( $PARENT_NO == "" )
				{
				}
				else
				{
								global $connection;
								$query = "select CODE_NO,CODE_NAME from HR_CODE where PARENT_NO='".$PARENT_NO."' order by CODE_ORDER";
								$cursor = exequery( $connection, $query );
								while ( $ROW = mysql_fetch_array( $cursor ) )
								{
												$CODE_NO = $ROW['CODE_NO'];
												$CODE_NAME = $ROW['CODE_NAME'];
												if ( $TYPE == "D" )
												{
																$OPTION_STR .= "<option value=\"".$CODE_NO."\"";
																if ( $CODE_NO == $SELECTED )
																{
																				$OPTION_STR .= " selected";
																}
																$OPTION_STR .= ">".$CODE_NAME."</option>\n";
												}
												else if ( $TYPE == "R" )
												{
																$OPTION_STR .= "<input type=\"radio\" name=\"".$FIELD_NAME."\" id=\"".$FIELD_NAME."_".$CODE_NO."\" value=\"".$CODE_NO."\"";
																if ( $CODE_NO == $SELECTED )
																{
																				$OPTION_STR .= " checked";
																}
																$OPTION_STR .= "><label for=\"".$FIELD_NAME."_".$CODE_NO."\">".$CODE_NAME."</label>\n";
												}
												else if ( $TYPE == "C" )
												{
																$OPTION_STR .= "<input type=\"checkbox\" name=\"".$FIELD_NAME."_".$CODE_NO."\" id=\"".$FIELD_NAME."_".$CODE_NO."\" value=\"".$CODE_NO."\"";
																if ( find_id( $SELECTED, $CODE_NO ) )
																{
																				$OPTION_STR .= " checked";
																}
																$OPTION_STR .= "><label for=\"".$FIELD_NAME."_".$CODE_NO."\">".$CODE_NAME."</label>\n";
												}
								}
								return $OPTION_STR;
				}
}

function hr_priv( $CUR_STAFF_FIELD )
{
				global $connection;
				global $LOGIN_USER_ID;
				global $LOGIN_USER_PRIV;
				$query = "SELECT DEPT_ID from HR_MANAGER where find_in_set('".$LOGIN_USER_ID."',DEPT_HR_MANAGER)";
				$cursor = exequery( $connection, $query );
				while ( $ROW = mysql_fetch_array( $cursor ) )
				{
								$DEPT_ID_STR .= $ROW['DEPT_ID'].",";
				}
				if ( substr( $DEPT_ID_STR, -1 ) == "," )
				{
								$DEPT_ID_STR = substr( $DEPT_ID_STR, 0, -1 );
				}
				$query = "SELECT USER_ID from USER where find_in_set(DEPT_ID,'".$DEPT_ID_STR."')";
				$cursor = exequery( $connection, $query );
				while ( $ROW = mysql_fetch_array( $cursor ) )
				{
								$USER_ID_STR .= $ROW['USER_ID'].",";
				}
				if ( substr( $USER_ID_STR, -1 ) == "," )
				{
								$USER_ID_STR = substr( $USER_ID_STR, 0, -1 );
				}
				if ( $LOGIN_USER_PRIV == "1" )
				{
								return $PRIV_WHERE_STR = " 1=1 ";
				}
				if ( $CUR_STAFF_FIELD != "" )
				{
								return $PRIV_WHERE_STR = " (CREATE_USER_ID='".$LOGIN_USER_ID."' or find_in_set(".$CUR_STAFF_FIELD.( ",'".$USER_ID_STR."')) " );
				}
				return $PRIV_WHERE_STR = " (CREATE_USER_ID='".$LOGIN_USER_ID."' or find_in_set(CREATE_DEPT_ID,'{$DEPT_ID_STR}')) ";
}

function array_to_json( $array )
{
				if ( is_array( $array ) )
				{
								return FALSE;
				}
				$associative = count( array_diff( array_keys( $array ), array_keys( array_keys( $array ) ) ) );
				if ( $associative )
				{
								$construct = array( );
								foreach ( $array as $key => $value )
								{
												if ( is_numeric( $key ) )
												{
																$key = "key_".$key;
												}
												$key = "\"".addslashes( $key )."\"";
												if ( is_array( $value ) )
												{
																$value = array_to_json( $value );
												}
												else if ( !is_numeric( $value ) || is_string( $value ) )
												{
																$value = "\"".str_replace( array( "\"", "\n", "\r" ), array( "\\\"", "", "" ), $value )."\"";
												}
												$construct[] = "{$key}: {$value}";
								}
								$result = "{ ".implode( ", ", $construct )." }";
								return $result;
				}
				$construct = array( );
				foreach ( $array as $value )
				{
								if ( is_array( $value ) )
								{
												$value = array_to_json( $value );
								}
								else if ( !is_numeric( $value ) || is_string( $value ) )
								{
												$value = "\"".str_replace( array( "\"", "\n", "\r" ), array( "\\\"", "", "" ), $value )."\"";
								}
								$construct[] = $value;
				}
				$result = "[ ".implode( ", ", $construct )." ]";
				return $result;
}

function td_authcode( $string, $operation = "", $key = "", $expiry = 0 )
{
				$ckey_length = 4;
				$key = md5( $key ? $key : "53c1fb88217737c98daf47e664f3180e" );
				$keya = md5( substr( $key, 0, 16 ) );
				$keyb = md5( substr( $key, 16, 16 ) );
				$keyc = $ckey_length ? $operation == "DECODE" ? substr( $string, 0, $ckey_length ) : substr( md5( microtime( ) ), 0 - $ckey_length ) : "";
				$cryptkey = $keya.md5( $keya.$keyc );
				$key_length = strlen( $cryptkey );
				$string = $operation == "DECODE" ? base64_decode( substr( $string, $ckey_length ) ) : sprintf( "%010d", $expiry ? $expiry + time( ) : 0 ).substr( md5( $string.$keyb ), 0, 16 ).$string;
				$string_length = strlen( $string );
				$result = "";
				$box = range( 0, 255 );
				$rndkey = array( );
				$i = 0;
				for ( ;	$i <= 255;	++$i	)
				{
								$rndkey[$i] = ord( $cryptkey[$i % $key_length] );
				}
				$j = $i = 0;
				for ( ;	$i < 256;	++$i	)
				{
								$j = ( $j + $box[$i] + $rndkey[$i] ) % 256;
								$tmp = $box[$i];
								$box[$i] = $box[$j];
								$box[$j] = $tmp;
				}
				$a = $j = $i = 0;
				for ( ;	$i < $string_length;	++$i	)
				{
								$a = ( $a + 1 ) % 256;
								$j = ( $j + $box[$a] ) % 256;
								$tmp = $box[$a];
								$box[$a] = $box[$j];
								$box[$j] = $tmp;
								$result .= chr( ord( $string[$i] ) ^ $box[( $box[$a] + $box[$j] ) % 256] );
				}
				if ( $operation == "DECODE" )
				{
								if ( ( substr( $result, 0, 10 ) == 0 || 0 < substr( $result, 0, 10 ) - time( ) ) && substr( $result, 10, 16 ) == substr( md5( substr( $result, 26 ).$keyb ), 0, 16 ) )
								{
												return substr( $result, 26 );
								}
								return "";
				}
				return $keyc.str_replace( "=", "", base64_encode( $result ) );
}

function proxy_mail( $ACTION, $BODY_ID, $PRIORITY = "0" )
{
				include_once( "inc/itask/itask.php" );
				$PRIORITY = trim( $PRIORITY );
				$PRIORITY = $PRIORITY == "" ? "0" : $PRIORITY;
				$cmd = $ACTION.$PRIORITY.$BODY_ID;
				$cmd = sprintf( "%04d", strlen( $cmd ) + 4 ).$cmd;
				return imailtask( $cmd );
}

function check_email( $EMAIL )
{
				$VALID_EMAIL = "";
				$INVALID_EMAIL = "";
				$EMAIL = str_replace( ";", ",", $EMAIL );
				$EMAIL_ARRAY = explode( ",", $EMAIL );
				foreach ( $EMAIL_ARRAY as $EMAIL )
				{
								$EMAIL = td_trim( $EMAIL );
								if ( $EMAIL == "" || !strstr( $EMAIL, "@" ) || !strstr( substr( $EMAIL, strpos( $EMAIL, "@" ) ), "." ) )
								{
												if ( $EMAIL != "" )
												{
																$INVALID_EMAIL .= $EMAIL.",";
												}
								}
								else
								{
												$VALID_EMAIL .= $EMAIL.",";
								}
				}
				return array( td_trim( $VALID_EMAIL ), td_trim( $INVALID_EMAIL ) );
}

function ParseMailAddress( $MAIL )
{
				$RESULT = array( );
				$ARRAY = explode( ";", $MAIL );
				$I = 0;
				for ( ;	$I < count( $ARRAY );	++$I	)
				{
								$MAIL_DESC = trim( $ARRAY[$I] );
								$POS = strrpos( $MAIL_DESC, " " );
								if ( $POS !== FALSE )
								{
												$NAME = substr( $MAIL_DESC, 0, $POS );
												$EMAIL = substr( $MAIL_DESC, $POS + 1 );
								}
								else
								{
												$NAME = "";
												$EMAIL = $MAIL_DESC;
								}
								$NAME = trim( trim( $NAME ), "\":'" );
								$EMAIL = trim( trim( $EMAIL ), "<>" );
								$RESULT[] = array( $NAME, $EMAIL );
				}
				return $RESULT;
}

function FormatMailAddress( $ARRAY )
{
				$RESULT = "";
				$I = 0;
				for ( ;	$I < count( $ARRAY );	++$I	)
				{
								if ( $ARRAY[$I][0] == "" )
								{
												$RESULT .= $ARRAY[$I][1].",";
								}
								else
								{
												$RESULT .= $ARRAY[$I][0]."<".$ARRAY[$I][1].">,";
								}
				}
				return td_trim( $RESULT );
}

function FormatMailDisplay( $ARRAY )
{
				$RESULT = "";
				$I = 0;
				for ( ;	$I < count( $ARRAY );	++$I	)
				{
								if ( $ARRAY[$I][0] == "" )
								{
												$RESULT .= $ARRAY[$I][1]."; ";
								}
								else
								{
												$RESULT .= "<span title=\"".$ARRAY[$I][1]."\">".$ARRAY[$I][0]."</span>; ";
								}
				}
				return td_trim( $RESULT );
}

function cstr_replace( $needle, $string, $haystack )
{
				$len_haystack = strlen( $haystack );
				$len_needle = strlen( $needle );
				$result = "";
				$cursor = 0;
				while ( $cursor < $len_haystack )
				{
								$head = substr( $haystack, $cursor, 1 );
								$tail = substr( $haystack, $cursor + 1, 1 );
								if ( hexdec( "0x81" ) <= ord( $head ) && hexdec( "0x40" ) <= ord( $tail ) )
								{
												if ( substr( $haystack, $cursor, $len_needle ) == $needle )
												{
																$result .= $string;
																$cursor += $len_needle;
												}
												else
												{
																$result .= $head.$tail;
																$cursor += 2;
												}
								}
								else if ( substr( $haystack, $cursor, $len_needle ) == $needle )
								{
												$result .= $string;
												$cursor += $len_needle;
								}
								else
								{
												$result .= $head;
												++$cursor;
								}
				}
				return $result;
}

function td_iconv( $data, $charset_from, $charset_to )
{
				if ( strtolower( $charset_from ) == "gb2312" )
				{
								$charset_from = "gbk";
				}
				if ( is_array( $data ) )
				{
								foreach ( $data as $k => $v )
								{
												$data[$k] = iconv( $charset_from, $charset_to, $v );
								}
								return $data;
				}
				$data = iconv( $charset_from, $charset_to, $data );
				return $data;
}

function iconv2os( $DATA )
{
				global $MYOA_CHARSET;
				global $MYOA_OS_CHARSET;
				return td_iconv( $DATA, $MYOA_CHARSET, $MYOA_OS_CHARSET );
}

function iconv2oa( $DATA )
{
				global $MYOA_CHARSET;
				global $MYOA_OS_CHARSET;
				return td_iconv( $DATA, $MYOA_OS_CHARSET, $MYOA_CHARSET );
}

function timeintval( $j, $l = "cn", $f = "Y-m-d" )
{
				if ( $l == "" )
				{
								$l = "cn";
				}
				$lang = array( "en" => array( " secs ago", " mins ago", " hours ago", " days ago" ), "cn" => array( _( "秒钟前" ), _( "分钟前" ), _( "小时前" ), _( "天前" ) ) );
				include_once( "inc/check_type.php" );
				if ( is_date_time( $j ) )
				{
								$j = strtotime( $j );
				}
				if ( is_numeric( $j ) )
				{
								$i = time( ) - $j;
								switch ( $i )
								{
												case $i < 60 :
																$str = $i.$lang[$l][0];
																return $str;
												case $i < 3600 :
																$str = round( $i / 60 ).$lang[$l][1];
																return $str;
												case $i < 86400 :
																$str = round( $i / 3600 ).$lang[$l][2];
																return $str;
												case $i < 604800 :
																$str = round( $i / 86400 ).$lang[$l][3];
																return $str;
												case 604800 < $i :
																$str = date( $f, $j );
										default:
                                            return $str;
                                }



				}
}

function send_birth_card( )
{
				global $connection;
				global $LOGIN_USER_ID;
				global $MYOA_IS_UN;
				if ( $MYOA_IS_UN == 1 )
				{
				}
				else
				{
								$query = "select count(*) from HR_CARD_MODULE where find_in_set('".$LOGIN_USER_ID."',SUIT_USERS)";
								$cursor = exequery( $connection, $query );
								if ( $ROW = mysql_fetch_array( $cursor ) )
								{
												$CARD_COUNT = $ROW[0];
								}
								if ( $CARD_COUNT == 0 )
								{
												return FALSE;
								}
								$ON_DATE = date( "m-d" );
								$ON_YEAR = date( "Y" );
								$query = "select BIRTHDAY,IS_LUNAR from USER where USER_ID='".$LOGIN_USER_ID."'";
								$cursor = exequery( $connection, $query );
								if ( $ROW = mysql_fetch_array( $cursor ) )
								{
												$BIRTHDAY = $ROW['BIRTHDAY'];
												$IS_LUNAR = $ROW['IS_LUNAR'];
								}
								$query = "select STAFF_BIRTH,BIRTH_REMIND_DATE from HR_STAFF_INFO where USER_ID='".$LOGIN_USER_ID."'";
								$cursor = exequery( $connection, $query );
								if ( $ROW = mysql_fetch_array( $cursor ) )
								{
												$STAFF_BIRTH = $ROW['STAFF_BIRTH'];
												$BIRTH_REMIND_DATE = $ROW['BIRTH_REMIND_DATE'];
								}
								else
								{
												$query = "insert into HR_STAFF_INFO(CREATE_USER_ID,CREATE_DEPT_ID,USER_ID,STAFF_NAME,DEPT_ID) values('".$LOGIN_USER_ID."','{$LOGIN_DEPT_ID}','{$LOGIN_USER_ID}','{$LOGIN_USER_NAME}','{$LOGIN_DEPT_ID}')";
												exequery( $connection, $query );
								}
								if ( $BIRTHDAY == "" || $BIRTHDAY == "0000-00-00" )
								{
												if ( $STAFF_BIRTH != "" && $STAFF_BIRTH != "0000-00-00" && $BIRTH_REMIND_DATE != $ON_YEAR && substr( $STAFF_BIRTH, 5, 5 ) == $ON_DATE )
												{
																send_card_email( );
												}
								}
								else
								{
												if ( $IS_LUNAR == 1 )
												{
																include_once( "general/calendar/date_change.php" );
																$CUR_DATE = strtotime( date( "Y-m-d", time( ) ) );
																$lunar = new Lunar( );
																$CUR_DATE_LUNAR = $lunar->convertSolarToLunar( $CUR_DATE );
																if ( $CUR_DATE_LUNAR[4] < 10 )
																{
																				$CUR_DATE_LUNAR[4] = "0".$CUR_DATE_LUNAR[4];
																}
																if ( $CUR_DATE_LUNAR[5] < 10 )
																{
																				$CUR_DATE_LUNAR[5] = "0".$CUR_DATE_LUNAR[5];
																}
																$CUR_DATE_LUNAR1 = $CUR_DATE_LUNAR[0]."-".$CUR_DATE_LUNAR[4]."-".$CUR_DATE_LUNAR[5];
																send_card_email( );
												}
												else
												{
																if ( $BIRTH_REMIND_DATE != $ON_YEAR && substr( $BIRTHDAY, 5, 5 ) == substr( $CUR_DATE_LUNAR1, 5, 5 ) && $BIRTH_REMIND_DATE != $ON_YEAR && substr( $BIRTHDAY, 5, 5 ) == $ON_DATE )
																{
																				send_card_email( );
																}
												}
								}
				}
}

function send_card_email( )
{
				global $connection;
				global $LOGIN_USER_ID;
				include_once( "inc/utility_file.php" );
				$query = "select ATTACH,GREETING from HR_CARD_MODULE where find_in_set('".$LOGIN_USER_ID."',SUIT_USERS) order by MODULE_ID desc limit 1";
				$cursor = exequery( $connection, $query );
				if ( $ROW = mysql_fetch_array( $cursor ) )
				{
								$GREETING = $ROW['GREETING'];
								$ATTACH = $ROW['ATTACH'];
								$ATTACH_ARRAY = explode( ",", $ATTACH );
								$ATTACH_ID = $ATTACH_ARRAY[0];
								$ATTACH_NAME = $ATTACH_ARRAY[1];
								$ATTACHMENT_ID_STR = copy_attach( $ATTACH_ID, $ATTACH_NAME, "hr", "email" );
								$CUR_TIME = time( );
								$SUBJECT = _( "生日快乐!!!" );
								$MEDIA_URL = attach_url( $ATTACHMENT_ID_STR, $ATTACH_NAME, "email" );
								$MEDIA_URL = $MEDIA_URL['down']."&DIRECT_VIEW=1";
								$CONTENT = _( "问候语：" ).$GREETING."<br />";
								$CONTENT .= "<iframe width=420 height=330 frameborder=0 align=center scrolling=no src=\"".$MEDIA_URL."\"></iframe>";
								$COMPRESS_CONTENT = bin2hex( gzcompress( $CONTENT ) );
								$query = "insert into EMAIL_BODY (FROM_ID,TO_ID2,SUBJECT,CONTENT,SEND_FLAG,SEND_TIME,ATTACHMENT_ID,ATTACHMENT_NAME,COMPRESS_CONTENT) values ('admin','".$LOGIN_USER_ID."','{$SUBJECT}','{$CONTENT}','1','".strtotime( $CUR_TIME ).( "','".$ATTACHMENT_ID_STR."','{$ATTACH_NAME}',0x{$COMPRESS_CONTENT})" );
								exequery( $connection, $query );
								$ROW_ID = mysql_insert_id( );
								$query = "insert into EMAIL (TO_ID,READ_FLAG,DELETE_FLAG,BOX_ID,BODY_ID,RECEIPT) values ('".$LOGIN_USER_ID."','0','0','0','{$ROW_ID}','0')";
								exequery( $connection, $query );
								$CUR_YEAR = date( "Y" );
								$query = "update HR_STAFF_INFO set BIRTH_REMIND_DATE='".$CUR_YEAR."' where USER_ID='{$LOGIN_USER_ID}'";
								exequery( $connection, $query );
				}
}

function getChnprefix( $s, $ssize = "" )
{
				global $mb;
				include_once( "inc/mb.php" );
				$size = 0;
				$name_prefix = "";
				while ( $size < strlen( $s ) )
				{
								$idx = "";
								$name_prefix_chn == "";
								if ( 128 <= ord( $s[$size] ) )
								{
												$name_prefix_chn = substr( $s, $size, 2 );
												reset( $mb );
												foreach ( $mb as $key => $t )
												{
																if ( strpos( $t, $name_prefix_chn ) )
																{
																				$idx = strtolower( $key );
																				$name_prefix .= $idx;
																}
												}
												$name_prefix .= "*";
												$size += 2;
								}
								else
								{
												$idx = $s[$size];
												$name_prefix .= $idx."*";
												$size += 1;
								}
				}
				if ( $ssize != "" )
				{
								$rs = array( );
								$rs['size'] = $size;
								$rs['name_prefix'] = $name_prefix;
								return $rs;
				}
				return $name_prefix;
}

function get_client_type( $CLIENT )
{
				if ( $CLIENT == "0" )
				{
								return _( "浏览器" );
				}
				if ( $CLIENT == "1" )
				{
								return _( "手机浏览器" );
				}
				if ( $CLIENT == "2" )
				{
								return _( "OA精灵" );
				}
				if ( $CLIENT == "5" )
				{
								return _( "iPhone客户端" );
				}
				if ( $CLIENT == "6" )
				{
								return _( "Android客户端" );
				}
				return "";
}

function weekintval( $timestamp )
{
				$tmp = $diff = "";
				include_once( "inc/check_type.php" );
				if ( is_date_time( $timestamp ) )
				{
								$timestamp = strtotime( $timestamp );
				}
				$diff = round( ( $timestamp - time( ) ) / 86400 );
				if ( 0 < $diff )
				{
								if ( $diff == 1 )
								{
												$tmp = _( "明天" );
												return $tmp;
								}
								if ( $diff == 2 )
								{
												$tmp = _( "后天" );
												return $tmp;
								}
								if ( 2 < $diff && date( "W", $timestamp ) == date( "W", time( ) ) )
								{
												$tmp = _( "本周" ).str_replace( array( "0", "1", "2", "3", "4", "5", "6" ), array( _( "日" ), _( "一" ), _( "二" ), _( "三" ), _( "四" ), _( "五" ), _( "六" ) ), date( "w", $timestamp ) );
												return $tmp;
								}
								if ( $diff <= 7 )
								{
												$tmp = _( "下周" ).str_replace( array( "0", "1", "2", "3", "4", "5", "6" ), array( _( "日" ), _( "一" ), _( "二" ), _( "三" ), _( "四" ), _( "五" ), _( "六" ) ), date( "w", $timestamp ) );
												return $tmp;
								}
								$tmp = date( "Y-m-d", $timestamp );
								return $tmp;
				}
				if ( $diff < 0 )
				{
								if ( $diff == -1 )
								{
												$tmp = _( "昨天" );
												return $tmp;
								}
								if ( $diff == -2 )
								{
												$tmp = _( "前天" );
												return $tmp;
								}
								if ( $diff < -2 && date( "W", $timestamp ) == date( "W", time( ) ) )
								{
												$tmp = _( "本周" ).str_replace( array( "0", "1", "2", "3", "4", "5", "6" ), array( _( "日" ), _( "一" ), _( "二" ), _( "三" ), _( "四" ), _( "五" ), _( "六" ) ), date( "w", $timestamp ) );
												return $tmp;
								}
								if ( -7 <= $diff )
								{
												$tmp = _( "上周" ).str_replace( array( "0", "1", "2", "3", "4", "5", "6" ), array( _( "日" ), _( "一" ), _( "二" ), _( "三" ), _( "四" ), _( "五" ), _( "六" ) ), date( "w", $timestamp ) );
												return $tmp;
								}
								$tmp = date( "Y-m-d", $timestamp );
								return $tmp;
				}
				$tmp = _( "今天" );
				return $tmp;
}

include_once( "inc/conn.php" );
include_once( "inc/utility.php" );
?>
