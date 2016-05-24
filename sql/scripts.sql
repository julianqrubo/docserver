CREATE TABLE users ( 
    ID int(8) unsigned NOT NULL auto_increment,
    companyId int(8) NOT NULL,
    name varchar(30) NOT NULL,
    lastName varchar(30) NOT NULL,
    username varchar(20) NOT NULL,
    pwd varchar(25) NOT NULL,
    email varchar(40),
    phone varchar(15),
    isAdmin int(1) NOT NULL,
    PRIMARY KEY (ID) 
);

CREATE TABLE company ( 
    ID int(8) unsigned NOT NULL auto_increment,
    documentId bigint NOT NULL,
    name varchar(30) NOT NULL,
    address varchar(30),
    phone varchar(15),
    path varchar(30) NOT NULL,
    state int(1) not null default 1,
    PRIMARY KEY (ID) 
);

INSERT INTO `docserverjm`.`company` (`documentId`, `name`, `address`, `phone`, `path`) VALUES (91534697, 'nemesys', 'la casa de migue migue', '1234567', '/nemesys/data');

INSERT INTO `docserverjm`.`users`(`companyId`,`name`,`lastName`,`userName`,`pwd`,`email`,`phone`,`isAdmin`)VALUES(1,'julian','curubo','julian.curubo','adivinela','julian.curubo@nemesys.com','1234567',1);

alter table company add (state int(1) not null default 1);