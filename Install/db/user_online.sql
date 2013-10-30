CREATE TABLE `user_online` (
  `UID` int(11) NOT NULL DEFAULT '0',
  `TIME` int(11) NOT NULL DEFAULT '0',
  `SID` char(32) NOT NULL DEFAULT '',
  `CLIENT` tinyint(4) NOT NULL,
  PRIMARY KEY (`UID`),
  KEY `TIME` (`TIME`),
  KEY `SID` (`SID`)
) ;