CREATE TABLE `user_priv` (
  `USER_PRIV` int(11) NOT NULL AUTO_INCREMENT,
  `PRIV_NAME` varchar(200) NOT NULL DEFAULT '',
  `PRIV_NO` int(11) NOT NULL DEFAULT '0',
  `FUNC_ID_STR` text NOT NULL,
  PRIMARY KEY (`USER_PRIV`),
  KEY `PRIV_NO` (`PRIV_NO`)
) ;
