ALTER TABLE `tbl_samples` ADD `collection_time` datetime DEFAULT current_timestamp();
ALTER TABLE `tbl_samples` ADD `vehicle_number` varchar(50) DEFAULT NULL;
ALTER TABLE `tbl_samples` ADD `sample_id` varchar(50) DEFAULT NULL;
ALTER TABLE `tbl_samples` ADD `arf_doc` varchar(255) DEFAULT NULL;