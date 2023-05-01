DROP DATABASE IF EXISTS `php_simple_login`;
CREATE DATABASE IF NOT EXISTS `php_simple_login`;

USE `php_simple_login`;

DROP TABLE IF EXISTS `php_simple_login`.`users`;
CREATE TABLE `php_simple_login`.`users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(500) DEFAULT NULL,
  `full_name` varchar(100) DEFAULT NULL,
  `created_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `last_login_date` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

DELIMITER $$
DROP PROCEDURE IF EXISTS `php_simple_login`.`usp_authenticate_user`;
CREATE PROCEDURE `php_simple_login`.`usp_authenticate_user`(in vEmail varchar(100), vPassword varchar(500))
sp:BEGIN
	declare vId int default 0;
    declare vFullName varchar(100) default null;
    
	## Sanitize Values ##
    if (vEmail is null or vEmail = "") then
		select 0 as 'Result', 'Missing email address' as 'Msg';
        leave sp;
    end if;
    
    if (vPassword is null or vPassword = "") then
		select 0 as 'Result', 'Missing password' as 'Msg';
        leave sp;
    end if;
    
    select id, full_name
    into vId, vFullName
    from php_simple_login.users
    where email = vEmail and `password` = md5(vPassword)
    LIMIT 1;
    
    if (vId > 0) then
		select 1 as 'Result', vId as 'Id', vFullName as 'FullName';
        
        ## Update 'last_login_date' column ##
        update php_simple_login.users
        set last_login_date = current_timestamp()
        where id = vId;
        
        leave sp;
    else
		select 0 as 'Result', vId as 'Id', vFullName as 'FullName';
        leave sp;
    end if;
END$$
DELIMITER ;

DELIMITER $$
DROP PROCEDURE IF EXISTS `php_simple_login`.`usp_create_account`;
CREATE PROCEDURE `php_simple_login`.`usp_create_account`(in vUserName varchar(100), vEmail varchar(100), vPassword varchar(500))
sp:BEGIN
	declare vId int default 0;
    
	## Sanitize Values ##
    if (vUserName is null or vUserName = "") then
		select 0 as 'Result', 'Missing username' as 'Msg';
        leave sp;
    end if;
	
    if (vEmail is null or vEmail = "") then
		select 0 as 'Result', 'Missing email address' as 'Msg';
        leave sp;
    end if;
    
     if (vPassword is null or vPassword = "") then
		select 0 as 'Result', 'Missing password' as 'Msg';
        leave sp;
    end if;
    
    ## Checking if the vEmail already exists before creating a account. ##
    select id into vId
    from php_simple_login.users
    where email = vEmail;
    
    if (vId > 0) then
		select 0 as 'Result', 'This email address already exists' as 'Msg';
        leave sp;
    else
		insert into php_simple_login.users (email, `password`, full_name) values (vEmail, md5(vPassword), vUserName);
        select 1 as 'Result', 'Account Created' as 'Msg';
        leave sp;
    end if;
END$$
DELIMITER ;