-- Database
CREATE DATABASE IF NOT EXISTS `docteur-libre` CHARACTER SET utf8 COLLATE utf8_unicode_ci;

USE `docteur-libre`;

-- User table
CREATE TABLE IF NOT EXISTS `user` (
	`user_id` INT NOT NULL AUTO_INCREMENT,
	`sex` CHAR(1) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
	`first_name` VARCHAR(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
    `last_name` VARCHAR(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
    `phone_number` VARCHAR(16) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
    `password` CHAR(60) NOT NULL,
	PRIMARY KEY (`user_id`)
);

-- Patient table
CREATE TABLE IF NOT EXISTS `patient` (
	`patient_id` INT NOT NULL,
    `email` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
	`date_of_birth` DATE NOT NULL,
	PRIMARY KEY (`patient_id`),
	FOREIGN KEY (`patient_id`) REFERENCES user(user_id)
);

-- Doctor table
CREATE TABLE IF NOT EXISTS `doctor` (
	`doctor_id` INT NOT NULL AUTO_INCREMENT,
    `address` VARCHAR(40) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
    `profession` VARCHAR(40) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
	PRIMARY KEY (`doctor_id`),
	FOREIGN KEY (`doctor_id`) REFERENCES user(user_id)
);

-- Appointment table
CREATE TABLE IF NOT EXISTS `appointment` (
	`patient_id` INT NOT NULL,
	`doctor_id` INT NOT NULL,
    `appointment time` DATETIME NOT NULL,
    `appointment_reason` TINYTEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
	PRIMARY KEY (`patient_id`,`doctor_id`),
	FOREIGN KEY (`patient_id`) REFERENCES patient(patient_id),
	FOREIGN KEY (`doctor_id`) REFERENCES doctor(doctor_id)
);
