alter table exam_schedule add status varchar(20) DEFAULT NULL;
alter table exam_answer modify answer_time varchar(20) DEFAULT NULL;
alter table exam_session add time_taken int DEFAULT 0;

CREATE TABLE `tailoring` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT 0,
  `name` varchar(50) DEFAULT NULL,
  `phone_number` varchar(20) DEFAULT NULL,
  `address_1` varchar(100) DEFAULT NULL,
  `address_2` varchar(100) DEFAULT NULL,
  `taluk` varchar(50) DEFAULT NULL,
  `district` varchar(50) DEFAULT NULL,
  `pin_code` varchar(20) DEFAULT NULL,
  `aadhar_number` varchar(50) DEFAULT NULL,
  `profile_image` varchar(100) DEFAULT NULL,
  `status` varchar(11) DEFAULT NULL,
  `payment_status` varchar(20) DEFAULT NULL,
  `reason` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4;


ALTER TABLE `users` ADD `tailoring_user` int DEFAULT 0;
ALTER TABLE `users` ADD `tailoring_ins_name` varchar(60) DEFAULT NULL;
ALTER TABLE `users` ADD `tailoring_ins_location` varchar(60) DEFAULT NULL;
ALTER TABLE `tailoring` ADD `significant` varchar(20) DEFAULT NULL After name;
ALTER TABLE `tailoring` ADD `father_or_hus_name` varchar(60) DEFAULT NULL After significant;

ALTER TABLE `tailoring` ADD `course_name` varchar(200) DEFAULT NULL After name;
ALTER TABLE `tailoring` ADD `date` date DEFAULT NULL;
ALTER TABLE `users` ADD `tailoring_ins_signature` varchar(50) DEFAULT NULL;
ALTER TABLE `users` ADD `tailoring_ins_agreement` varchar(50) DEFAULT NULL;

CREATE TABLE `payment` (
  `id`  int NOT NULL AUTO_INCREMENT,
  `from_id` int DEFAULT 0,
  `to_id` int DEFAULT 0,
  `amount` decimal(10,2) DEFAULT 0,
  `iscommission` tinyint(4) DEFAULT 0,
  `customer_id` int(11) DEFAULT NULL,
  `service_id` int(11) DEFAULT NULL,
  `pay_id` int(11) DEFAULT NULL,
  `service_status` varchar(20) DEFAULT NULL,
  `message` varchar(100) DEFAULT NULL,
  `ad_info` varchar(100) DEFAULT NULL,
  `ad_info2` varchar(100) DEFAULT NULL,
  `paid_image` varchar(100) DEFAULT NULL,
  `time` varchar(100) DEFAULT NULL,
  `paydate` varchar(50) DEFAULT NULL,
  `log_id` int(11) DEFAULT NULL,
  `k_status` int(11) DEFAULT 1,
  `service_entity` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1;

alter table exam_answer modify answer_time varchar(20) DEFAULT NULL;



CREATE TABLE `assigned_department` (
  `id`  int NOT NULL AUTO_INCREMENT,
  `institute_id` int DEFAULT 0,
  `department_id` int DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB;
ALTER TABLE `department` ADD `edutype_id` INT(10) NULL DEFAULT NULL AFTER `id`;

alter table exam_answer modify answer_time varchar(20) DEFAULT NULL; 
alter table practice_exam_answer modify answer_time varchar(20) DEFAULT NULL; 
