/**
    收集的一些 SQL 语句
*/
EXPLAIN SELECT products.category, products.assigned_user_id, COUNT( products.id ) AS opp_count
FROM products
RIGHT JOIN orders ON orders.productid = products.id
WHERE 1
GROUP BY products.category, products.assigned_user_id

CREATE TABLE `test` (
`tid` INT( 11 ) NOT NULL AUTO_INCREMENT PRIMARY KEY COMMENT 'test id',
`uid` INT( 11 ) NOT NULL COMMENT 'user id',
`name` VARCHAR( 32 ) NOT NULL COMMENT 'user name',
INDEX ( `uid` , `name` )
) ENGINE = MYISAM ;

/**
    规划数据表结构
*/
SELECT *
FROM `products`
PROCEDURE ANALYSE ( ); 

/**
    检查表
*/
CHECK TABLE tbl_name [, tbl_name] ... [option] ...
 
option = {QUICK | FAST | MEDIUM | EXTENDED | CHANGED}


/**
    用于分析和存储表的关键字分布。在分析期间，使用一个读取锁定对表进行锁定。这对于MyISAM, BDB和InnoDB表有作用。对于MyISAM表，本语句与使用myisamchk -a相当
*/
ANALYZE [LOCAL | NO_WRITE_TO_BINLOG] TABLE tbl_name;

/**
    REPAIR TABLE用于修复被破坏的表。默认情况下，REPAIR TABLE与myisamchk --recover tbl_name具有相同的效果。REPAIR TABLE对MyISAM和ARCHIVE表起作用。
*/
REPAIR [LOCAL | NO_WRITE_TO_BINLOG] TABLE
    tbl_name [, tbl_name] ... [QUICK] [EXTENDED] [USE_FRM]

DISTINCT

/**
    如果您已经删除了表的一大部分，或者如果您已经对含有可变长度行的表（含有VARCHAR, BLOB或TEXT列的表）进行了很多更改，则应使用OPTIMIZE TABLE。被删除的记录被保持在链接清单中，后续的INSERT操作会重新使用旧的记录位置。您可以使用OPTIMIZE TABLE来重新利用未使用的空间，并整理数据文件的碎片。
*/
OPTIMIZE [LOCAL | NO_WRITE_TO_BINLOG] TABLE tbl_name [, tbl_name] ...

GRANT SELECT , INSERT , UPDATE , DELETE , CREATE , DROP , INDEX , ALTER , CREATE TEMPORARY TABLES , LOCK TABLES , CREATE VIEW , SHOW VIEW , CREATE ROUTINE, ALTER ROUTINE, EXECUTE ON `statistics` . * TO 'test'@'localhost';

/**
    重新载入权限表
*/
FLUSH PRIVILEGES ;

/**
    新建用户
*/
CREATE USER 'test'@'localhost' IDENTIFIED BY '****';
GRANT USAGE ON * . * TO 'test'@'localhost' IDENTIFIED BY '****' WITH MAX_QUERIES_PER_HOUR 0 MAX_CONNECTIONS_PER_HOUR 0 MAX_UPDATES_PER_HOUR 0 MAX_USER_CONNECTIONS 0 ;

/**
    授权
*/
GRANT SELECT , INSERT , UPDATE , DELETE , CREATE , DROP , INDEX , ALTER , CREATE TEMPORARY TABLES , LOCK TABLES , CREATE VIEW , SHOW VIEW , CREATE ROUTINE, ALTER ROUTINE, EXECUTE ON `test` . * TO 'test'@'localhost';

/**
    增加字段
*/
ALTER TABLE `crontab` ADD `exec_time` INT( 11 ) NOT NULL COMMENT 'When does this command execute.';

/**
    修改字段
*/
ALTER TABLE `crontab` CHANGE `user_name` `user_name` VARCHAR( 32 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'user name' 
ALTER TABLE `crontab` CHANGE `cmd` `cmd` VARCHAR( 128 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'which command will be executed.'

/**
    添加索引
*/
 ALTER TABLE `crontab` ADD INDEX ( `cmd` )

/**
    删除索引    
*/
ALTER TABLE `crontab` DROP INDEX `cmd`

/**
    回收权限
*/
DROP USER 'root'@'127.0.0.1';
DROP DATABASE IF EXISTS `root`;
DROP USER 'root'@'hy0kl.org';

/**
    更改登陆主机
*/
CREATE USER 'test'@'%' IDENTIFIED BY PASSWORD '*94BDCEBE19083CE2A1F959FD02F964C7AF4CFC29';

GRANT USAGE ON * . * TO 'test'@'%' IDENTIFIED BY PASSWORD '*94BDCEBE19083CE2A1F959FD02F964C7AF4CFC29' WITH MAX_QUERIES_PER_HOUR 0 MAX_CONNECTIONS_PER_HOUR 0 MAX_UPDATES_PER_HOUR 0 MAX_USER_CONNECTIONS 0 ;

GRANT SELECT ,
INSERT ,
UPDATE ,
DELETE ,
CREATE ,
DROP ,
INDEX ,
ALTER ,
CREATE TEMPORARY TABLES ,
LOCK TABLES ,
CREATE VIEW ,
SHOW VIEW ,
CREATE ROUTINE,
ALTER ROUTINE,
EXECUTE ON `test` . * TO 'test'@'%';