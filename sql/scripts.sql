CREATE TABLE `company` (
  `ID` int(8) unsigned NOT NULL AUTO_INCREMENT,
  `documentId` bigint(20) NOT NULL,
  `name` varchar(30) NOT NULL,
  `address` varchar(30) DEFAULT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `path` varchar(30) NOT NULL,
  `state` int(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`ID`),
  UNIQUE KEY `idx_company_documentId` (`documentId`),
  KEY `idx_company_state` (`state`)
) ENGINE=InnoDB AUTO_INCREMENT=69 DEFAULT CHARSET=latin1;
SELECT * FROM docserverjm.users;


CREATE TABLE `users` (
  `ID` int(8) unsigned NOT NULL AUTO_INCREMENT,
  `companyId` int(8) NOT NULL,
  `name` varchar(30) NOT NULL,
  `lastName` varchar(30) NOT NULL,
  `username` varchar(20) NOT NULL,
  `pwd` varchar(25) NOT NULL,
  `email` varchar(40) DEFAULT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `isAdmin` int(1) NOT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `idx_users_username` (`username`),
  KEY `idx_users_companyId` (`companyId`),
  KEY `idx_users_isAdmin` (`isAdmin`)
) ENGINE=InnoDB AUTO_INCREMENT=48 DEFAULT CHARSET=latin1;


INSERT INTO `docserverjm`.`company` (`documentId`, `name`, `address`, `phone`, `path`) VALUES (91534697, 'nemesys', 'la casa de migue migue', '1234567', '/nemesys/data');

INSERT INTO `docserverjm`.`users`(`companyId`,`name`,`lastName`,`userName`,`pwd`,`email`,`phone`,`isAdmin`)VALUES(1,'julian','curubo','julian.curubo','adivinela','julian.curubo@nemesys.com','1234567',1);