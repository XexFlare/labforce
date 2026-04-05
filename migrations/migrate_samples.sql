CREATE TABLE `tbl_sample_techs` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `business_unit` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
)
CREATE TABLE `tbl_samples` (
  `id` int NOT NULL AUTO_INCREMENT,
  `contract_id` int DEFAULT NULL,
  `sample_number` varchar(30) DEFAULT NULL,
  `color` varchar(30) DEFAULT NULL,
  `size` varchar(30) DEFAULT NULL,
  `expected_analysis_time` datetime DEFAULT NULL,
  `taken_by` int DEFAULT NULL,
  `delivered_to` int DEFAULT NULL,
  `delivery_time` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
)
ALTER TABLE `labforce`.`tbl_batches` ADD COLUMN `sample_id` int NULL COMMENT '';