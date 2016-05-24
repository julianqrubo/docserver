CREATE TABLE users ( 
    ID int(8) unsigned NOT NULL auto_increment,
    companyId int(8) unsigned NOT NULL,
    name varchar(30),
    lastName varchar(30),
    username varchar(20),
    pwd varchar(25),
    email varchar(40),
    phone varchar(15),
    isAdmin int(1),
    PRIMARY KEY (ID) 
);

CREATE TABLE company ( 
    ID int(8) unsigned NOT NULL auto_increment,
    documentId bigint NOT NULL,
    name varchar(30),
    address varchar(30),
    phone varchar(15),
    path varchar(30),
    state int(1) not null default 1,
    PRIMARY KEY (ID) 
);

INSERT INTO `docserverjm`.`company` (`documentId`, `name`, `address`, `phone`, `path`) VALUES (91534697, 'nemesys', 'la casa de migue migue', '1234567', '/nemesys/data');

INSERT INTO `docserverjm`.`users`(`companyId`,`name`,`lastName`,`username`,`pwd`,`email`,`phone`,`isAdmin`)VALUES(1,'julian','curubo','julian.curubo','adivinela','julian.curubo@nemesys.com','1234567',1);

alter table company add (state int(1) not null default 1);