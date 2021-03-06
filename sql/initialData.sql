CREATE TABLE `company` (
    `ID` int(8) unsigned NOT NULL AUTO_INCREMENT,
    `documentId` varchar(15) NOT NULL,
    `name` varchar(100) NOT NULL,
    `address` varchar(100) DEFAULT NULL,
    `phone` varchar(15) DEFAULT NULL,
    `email` varchar(40) DEFAULT NULL,
    `path` varchar(100) NOT NULL,
    `state` int(1) NOT NULL DEFAULT 1,
    PRIMARY KEY (`ID`),
    UNIQUE KEY `idx_company_documentId` (`documentId`),
    KEY `idx_company_state` (`state`),
    UNIQUE KEY `idx_company_path` (`path`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;


CREATE TABLE `users` (
    `ID` int(8) unsigned NOT NULL AUTO_INCREMENT,
    `companyId` int(8) NOT NULL,
    `username` varchar(20) NOT NULL,
    `pwd` varchar(25) NOT NULL,
    `isAdmin` int(1) NOT NULL,
    PRIMARY KEY (`ID`),
    UNIQUE KEY `idx_users_username` (`username`),
    KEY `idx_users_companyId` (`companyId`),
    KEY `idx_users_isAdmin` (`isAdmin`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;


CREATE TABLE `classifier` (
    `ID` int(8) unsigned NOT NULL AUTO_INCREMENT,
    `companyId` int(8) NOT NULL,
    `name` varchar(100) NOT NULL,
    `state` int(1) NOT NULL DEFAULT 1,
    PRIMARY KEY (`ID`),
    UNIQUE KEY `idx_classifier_companyId_name` (`companyId`,`name`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


CREATE TABLE `upload_file` (
    `ID` int(8) unsigned NOT NULL AUTO_INCREMENT,
    `user` int(8) NOT NULL,
    `companyId` int(8) NOT NULL,
    `classifierId` int(8),
    `source_name` varchar(100) NOT NULL,
    `type` varchar(100) DEFAULT NULL,
    `size` bigint(20) NOT NULL,
    `upload_date` datetime NOT NULL,
    `path` varchar(100) DEFAULT NULL,
    `state` int(1) NOT NULL DEFAULT 1,
    PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


INSERT INTO `company` (`documentId`, `name`, `address`, `phone`, `email`, `path`, `state`) VALUES ('9001013042', 'JM SALUD OCUPACIONAL', 'calle 54 No 31-99', '6575878', 'jm.saludocupacional@yahoo.com.ar', 'jmsaludocupacional', 1);

INSERT INTO `users`(`companyId`,`userName`,`pwd`,`isAdmin`) VALUES(1,'adminjm','Usuario1$',1);