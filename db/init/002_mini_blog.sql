USE perfect_php;
CREATE TABLE `users`
(
    `id`         integer(11) NOT NULL AUTO_INCREMENT,
    `user_name`  varchar(20) NOT NULL,
    `password`   varchar(40) NOT NULL,
    `created_at` datetime    NOT NULL DEFAULT NOW(),
    PRIMARY KEY (`id`),
    UNIQUE KEY username_index (user_name)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4;

CREATE TABLE `followings`
(
    `user_id`      integer(11) NOT NULL,
    `following_id` integer(11) NOT NULL,
    PRIMARY KEY (`user_id`, `following_id`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4;

CREATE TABLE `statuses`
(
    `id`         integer(11) NOT NULL AUTO_INCREMENT,
    `user_id`    integer(11) NOT NULL,
    `body`       varchar(255),
    `created_at` datetime DEFAULT NOW(),
    PRIMARY KEY (`id`),
    INDEX user_id_index (user_id)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4;

ALTER TABLE followings
    ADD FOREIGN KEY (user_id) REFERENCES user (id);
ALTER TABLE followings
    ADD FOREIGN KEY (following_id) REFERENCES user (id);
ALTER TABLE statuses
    ADD FOREIGN KEY (user_id) REFERENCES user (id);

