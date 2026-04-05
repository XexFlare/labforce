
CREATE TABLE `tbl_manufacturer_results` (`contract_id` int(11) DEFAULT NULL, `moisture` varchar(10) DEFAULT NULL, `n` varchar(10) DEFAULT NULL, `p2o5` varchar(10) DEFAULT NULL, `k2o` varchar(10) DEFAULT NULL, `s` varchar(10) DEFAULT NULL, `b` varchar(10) DEFAULT NULL, `zn` varchar(10) DEFAULT NULL, `total` varchar(11) DEFAULT NULL, `time` timestamp NULL DEFAULT current_timestamp(), `doneBy` int(11) DEFAULT NULL, `filename` varchar(255) DEFAULT NULL);
CREATE TABLE `labforce`.`tbl_uploads` (`id` serial,`name` varchar(255),`location` varchar(255), PRIMARY KEY (id));
CREATE TABLE `labforce`.`tbl_physical_analysis` (`id` serial,`test_id` int,`first` float,`second` float,`third` float,`granule_size` float,`fines` float,`coating` boolean, PRIMARY KEY (id));
ALTER TABLE `labforce`.`tbl_contracts` ADD COLUMN `is_blend` boolean NULL DEFAULT '0' COMMENT '';
ALTER TABLE `labforce`.`tbl_contracts` ADD COLUMN `hidden` boolean NULL DEFAULT '0' COMMENT '';