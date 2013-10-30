CREATE TABLE `sys_log` (
  `LOG_ID` int(11) NOT NULL AUTO_INCREMENT,
  `USER_ID` varchar(20) DEFAULT NULL,
  `TIME` datetime DEFAULT NULL,
  `IP` varchar(20) DEFAULT NULL,
  `TYPE` varchar(10) DEFAULT '1',
  `REMARK` mediumtext NOT NULL,
  PRIMARY KEY (`LOG_ID`),
  KEY `USER_ID` (`USER_ID`),
  KEY `TIME` (`TIME`),
  KEY `TYPE` (`TYPE`)
) ;
