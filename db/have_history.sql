CREATE TABLE IF NOT EXISTS `have_histroy` (
    `his_id` int(11) NOT NULL AUTO_INCREMENT
    `user_name` varchar(64) COLLATE utf8_unicode_ci NOT NULL COMMENT 'user''s name, unique',
    `date` varchar(64),
    `restaurant_name` varchar(64),
    `attitude` INT,
    `phone` INT, 
    PRIMARY KEY (`his_id`),
    
    FOREIGN KEY(user_name)
    	REFERENCES users(user_name)
    	ON DELETE CASCADE
    	ON UPDATE CASCADE,
    FOREIGN KEY(restaurant_name)
    	REFERENCES restaurants(name)
    	ON DELETE CASCADE
    	ON UPDATE CASCADE 
)


INSERT INTO `have_histroy` VALUES('ruixia0819','4/16/2017/5','xxxx',0);
SELECT * FROM `have_histroy` WHERE `user_name`='ruixia0819'
