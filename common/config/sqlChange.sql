ALTER  TABLE video ADD  tag VARCHAR(256) DEFAULT '';
ALTER  TABLE video ADD  chapter VARCHAR(1024) DEFAULT '';
ALTER TABLE  video CHANGE  cover cover INT(11) DEFAULT 0
ALTER TABLE  video CHANGE album  album INT(11) DEFAULT 0;

CREATE TABLE `post` (
           `id` INT(11) NOT NULL AUTO_INCREMENT,
           `uid` INT(11) DEFAULT '0',
           `tag` VARCHAR(128) COLLATE utf8_bin DEFAULT NULL,
           `chapter` VARCHAR(256) COLLATE utf8_bin DEFAULT NULL,
           `status` TINYINT(4) DEFAULT '1',
           `create_time` INT(11) DEFAULT NULL,
           `title` VARCHAR(128) COLLATE utf8_bin DEFAULT '',
           `type`  TINYINT  DEFAULT 0,
           `content` TEXT COLLATE utf8_bin,
           PRIMARY KEY (`id`)
 )ENGINE=MYISAM AUTO_INCREMENT=10005 DEFAULT CHARSET=utf8 COLLATE=utf8_bin

#标签可以自定义   标签是灵活可变的
#目录是稳定 , 精简 的

ALTER  TABLE course  DROP COLUMN tag


ALTER TABLE  course ADD tag VARCHAR(548) DEFAULT '' COMMENT '标签',ADD chapter VARCHAR(548) DEFAULT ''  COMMENT '章节',ADD `point` VARCHAR(548) DEFAULT ''  COMMENT '知识点';

ALTER TABLE  course_lesson ADD tag VARCHAR(548) DEFAULT '' COMMENT '标签',ADD chapter VARCHAR(548) DEFAULT ''  COMMENT '章节',ADD `point` VARCHAR(548) DEFAULT ''  COMMENT '知识点';
ALTER TABLE `groups` ADD tag VARCHAR(548) DEFAULT '' COMMENT '标签',ADD chapter VARCHAR(548) DEFAULT ''  COMMENT '章节',ADD `point` VARCHAR(548) DEFAULT ''  COMMENT '知识点';

ALTER TABLE `question` ADD tag VARCHAR(548) DEFAULT '' COMMENT '标签',ADD chapter VARCHAR(548) DEFAULT ''  COMMENT '章节',ADD `point` VARCHAR(548) DEFAULT ''  COMMENT '知识点';
ALTER TABLE `article` ADD tag VARCHAR(548) DEFAULT '' COMMENT '标签',ADD chapter VARCHAR(548) DEFAULT ''  COMMENT '章节',ADD `point` VARCHAR(548) DEFAULT ''  COMMENT '知识点';
ALTER TABLE `article_category` ADD tag VARCHAR(548) DEFAULT '' COMMENT '标签',ADD chapter VARCHAR(548) DEFAULT ''  COMMENT '章节',ADD `point` VARCHAR(548) DEFAULT ''  COMMENT '知识点';

ALTER TABLE  file ADD tag VARCHAR(548) DEFAULT '' COMMENT '标签',
ADD chapter VARCHAR(548) DEFAULT ''  COMMENT '章节' , ADD path VARCHAR(256) DEFAULT ''  COMMENT '章节',
ADD `cotegory` VARCHAR(548) DEFAULT ''  COMMENT '类别';

ALTER TABLE  file_group ADD tag VARCHAR(548) DEFAULT '' COMMENT '标签',ADD chapter VARCHAR(548) DEFAULT ''  COMMENT '章节',ADD `cotegory` VARCHAR(548) DEFAULT ''  COMMENT '类别';



CREATE TABLE `point` (
          `id` INT(11) NOT NULL AUTO_INCREMENT,
          `uid` INT(11) DEFAULT '0',
          `category` VARCHAR(128) COLLATE utf8_bin DEFAULT NULL,
          `chapter` VARCHAR(128) COLLATE utf8_bin DEFAULT NULL,
          `status` TINYINT(4) DEFAULT '1',
          `createTime` INT(11) DEFAULT NULL,
          `cover` INT(11) DEFAULT '0',
          `title` VARCHAR(128) COLLATE utf8_bin DEFAULT '',
          `desc` TEXT COLLATE utf8_bin,
          PRIMARY KEY (`id`)
        ) ENGINE=MYISAM AUTO_INCREMENT=10000 DEFAULT CHARSET=utf8 COLLATE=utf8_bin


 ALTER TABLE  POINT ADD  updatedTime  INT DEFAULT 0  , ADD  updateUid   INT DEFAULT 0;
  ALTER TABLE  POINT  CHANGE  STATUS  STATUS TINYINT DEFAULT 1;
  ALTER TABLE  POINT  CHANGE  cover  cover VARCHAR(256) DEFAULT '';

  CREATE TABLE `video` (
          `id` INT(11) NOT NULL AUTO_INCREMENT,
          `uid` INT(11) DEFAULT '0',
          `category` VARCHAR(128) COLLATE utf8_bin DEFAULT NULL,
          `chapter` VARCHAR(128) COLLATE utf8_bin DEFAULT NULL,
          `status` TINYINT(4) DEFAULT '1',
          `createdTime` INT(11) DEFAULT NULL,
          `cover` VARCHAR(256) COLLATE utf8_bin DEFAULT '',
          `title` VARCHAR(128) COLLATE utf8_bin DEFAULT '',
          `desc` TEXT COLLATE utf8_bin,
          `content` VARCHAR(128) DEFAULT '',
          `updatedTime` INT(11) DEFAULT '0',
          `updateUid` INT(11) DEFAULT '0',
          `up`  INT(11) DEFAULT 0,
          `pv`  INT(11) DEFAULT 0,
          `file_id` INT DEFAULT 0,
          PRIMARY KEY (`id`)
        ) ENGINE=MYISAM AUTO_INCREMENT=1000 DEFAULT CHARSET=utf8 COLLATE=utf8_bin ;

          CREATE TABLE `material` (
          `id` INT(11) NOT NULL AUTO_INCREMENT,
          `uid` INT(11) DEFAULT '0',
          `category` VARCHAR(128) COLLATE utf8_bin DEFAULT NULL,
          `chapter` VARCHAR(128) COLLATE utf8_bin DEFAULT NULL,
          `status` TINYINT(4) DEFAULT '1',
          `createdTime` INT(11) DEFAULT NULL,
          `cover` VARCHAR(256) COLLATE utf8_bin DEFAULT '',
          `title` VARCHAR(128) COLLATE utf8_bin DEFAULT '',
          `desc` TEXT COLLATE utf8_bin,
          `content` VARCHAR(128) DEFAULT '',
          `updatedTime` INT(11) DEFAULT '0',
          `updateUid` INT(11) DEFAULT '0',
          `up`  INT(11) DEFAULT 0,
          `pv`  INT(11) DEFAULT 0,
          `file_id` INT DEFAULT 0,
          PRIMARY KEY (`id`)
        ) ENGINE=MYISAM AUTO_INCREMENT=1000 DEFAULT CHARSET=utf8 COLLATE=utf8_bin ;



CREATE TABLE `auth_rule`
(
   `name`                 VARCHAR(64) NOT NULL,
   `data`                 TEXT,
   `created_at`           INTEGER,
   `updated_at`           INTEGER,
    PRIMARY KEY (`name`)
) ENGINE INNODB;

CREATE TABLE `auth_item`
(
   `name`                 VARCHAR(64) NOT NULL,
   `type`                 INTEGER NOT NULL,
   `description`          TEXT,
   `rule_name`            VARCHAR(64),
   `data`                 TEXT,
   `created_at`           INTEGER,
   `updated_at`           INTEGER,
   `level`     TINYINT,
   PRIMARY KEY (`name`),
   FOREIGN KEY (`rule_name`) REFERENCES `auth_rule` (`name`) ON DELETE SET NULL ON UPDATE CASCADE,
   KEY `type` (`type`)
) ENGINE INNODB;


CREATE TABLE `auth_item_child`
(
   `parent`               VARCHAR(64) NOT NULL,
   `child`                VARCHAR(64) NOT NULL,
   PRIMARY KEY (`parent`, `child`),
   FOREIGN KEY (`parent`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
   FOREIGN KEY (`child`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE INNODB;

CREATE TABLE `auth_assignment`
(
   `item_name`            VARCHAR(64) NOT NULL,
   `user_id`              VARCHAR(64) NOT NULL,
   `created_at`           INTEGER,
   PRIMARY KEY (`item_name`, `user_id`),
   FOREIGN KEY (`item_name`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE INNODB;

CREATE TABLE `t_menu` (
          `id` INT(11) NOT NULL AUTO_INCREMENT,
          `menuname` VARCHAR(32) COLLATE utf8_unicode_ci NOT NULL,
          `parentid` SMALLINT(6) NOT NULL DEFAULT '0',
          `route` VARCHAR(32) COLLATE utf8_unicode_ci NOT NULL,
          `menuicon` VARCHAR(16) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'icon-book',
          `level` SMALLINT(6) NOT NULL DEFAULT '1',
          `seq` INT(11) DEFAULT NULL,
          PRIMARY KEY (`id`)
        ) ENGINE=INNODB AUTO_INCREMENT=46 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci

ALTER TABLE `edu`.`article` ADD COLUMN `editor_type` ENUM('ueditor','markdown') DEFAULT 'ueditor'  NULL COMMENT '编辑器类型' AFTER `desc`, ADD COLUMN `markdown` TEXT NULL COMMENT 'markdown原始文本' AFTER `editor_type`;

ALTER TABLE  material  ADD   'type'  TINYINT  DEFAULT  1
ALTER TABLE  chapter   ADD  pdfpages VARCHAR(128) DEFAULT ''

ALTER TABLE `edu`.`chapter` ADD COLUMN `offset` SMALLINT NULL COMMENT '页面偏移' AFTER `pdfpages`;