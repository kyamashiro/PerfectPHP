CREATE DATABASE perfect_php DEFAULT CHARACTER SET utf8mb4;
USE perfect_php;
CREATE TABLE `posts`
(
    `id`         integer(11)  NOT NULL AUTO_INCREMENT,
    `name`       varchar(256) NOT NULL,
    `comment`    varchar(256) NOT NULL,
    `created_at` datetime     NOT NULL DEFAULT NOW(),
    PRIMARY KEY (`id`)
) ENGINE = InnoDB
  AUTO_INCREMENT = 1
  DEFAULT CHARSET = utf8mb4;