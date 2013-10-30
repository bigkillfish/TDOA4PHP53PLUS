CREATE TABLE `sys_function` (
  `FUNC_ID` int(11) NOT NULL DEFAULT '0',
  `MENU_ID` varchar(10) NOT NULL DEFAULT '0',
  `FUNC_NAME` varchar(100) NOT NULL DEFAULT '',
  `FUNC_CODE` varchar(300) NOT NULL,
  `FUNC_EXT` varchar(600) NOT NULL,
  `ACCESS_TYPE` int(11) DEFAULT NULL,
  `LANGUAGE_TYPE` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`FUNC_ID`),
  KEY `MENU_ID` (`MENU_ID`)
) ;