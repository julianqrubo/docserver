CREATE TABLE company
(
   ID int PRIMARY KEY NOT NULL,
   documentId bigint NOT NULL,
   name varchar(30) NOT NULL,
   address varchar(30),
   phone varchar(15),
   path varchar(30) NOT NULL,
   state int DEFAULT 1 NOT NULL
)
;
CREATE UNIQUE INDEX PRIMARY ON company(ID)
;
CREATE UNIQUE INDEX idx_company_documentId ON company(documentId)
;


CREATE TABLE users
(
   ID int PRIMARY KEY NOT NULL,
   companyId int NOT NULL,
   name varchar(30) NOT NULL,
   lastName varchar(30) NOT NULL,
   username varchar(20) NOT NULL,
   pwd varchar(25) NOT NULL,
   email varchar(40),
   phone varchar(15),
   isAdmin int NOT NULL
)
;
CREATE UNIQUE INDEX PRIMARY ON users(ID)
;
CREATE UNIQUE INDEX idx_users_username ON users(username)
;


INSERT INTO `docserverjm`.`company` (`documentId`, `name`, `address`, `phone`, `path`) VALUES (91534697, 'nemesys', 'la casa de migue migue', '1234567', '/nemesys/data');

INSERT INTO `docserverjm`.`users`(`companyId`,`name`,`lastName`,`userName`,`pwd`,`email`,`phone`,`isAdmin`)VALUES(1,'julian','curubo','julian.curubo','adivinela','julian.curubo@nemesys.com','1234567',1);