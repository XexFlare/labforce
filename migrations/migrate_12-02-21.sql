CREATE TABLE `tbl_blend_types` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;

INSERT INTO `tbl_blend_types` (`id`, `name`) VALUES
('1', 'Import'),
('2', 'Liwonde Factory'),
('3', 'Bindura Factory');
ALTER TABLE `tbl_contracts` ADD COLUMN `vessel` varchar(50) NULL COMMENT '';
ALTER TABLE `tbl_contracts` ADD COLUMN `blend_type_id` int(11) NULL COMMENT '';
ALTER TABLE `tbl_contracts` ADD COLUMN `supplier_id` int(11) NULL COMMENT '';
ALTER TABLE `tbl_contracts` ADD COLUMN `manufacturer_results_file` varchar(255) NULL COMMENT '';
ALTER TABLE `tbl_analysis` ADD COLUMN `exec_remarks` varchar(255) NULL COMMENT '';
DROP TABLE IF EXISTS `tbl_blend_types`;
