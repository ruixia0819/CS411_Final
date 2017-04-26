CREATE TABLE IF NOT EXISTS `have_posts` (
    `post_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'auto incrementing user_id of each user, unique index',
    `poster_name` varchar(64) COLLATE utf8_unicode_ci NOT NULL COMMENT 'user''s name, unique',
    `time_stamp` varchar(64),
    `restaurant_name` varchar(64),
    `attenders` varchar(64),
    `message` varchar(64),
    `number`  INT, 
    `poster_email` varchar(64),
    `type` INT,
    
    PRIMARY KEY (`post_id`),
    
    FOREIGN KEY(poster_name)
    	REFERENCES users(user_name)
    	ON DELETE CASCADE
    	ON UPDATE CASCADE,
    FOREIGN KEY(restaurant_name)
    	REFERENCES restaurants(name)
    	ON DELETE CASCADE
    	ON UPDATE CASCADE 
)