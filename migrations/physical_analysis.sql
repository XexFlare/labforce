ALTER TABLE `tbl_manufacturer_results` ADD COLUMN `pH` float NULL COMMENT '';
ALTER TABLE `tbl_fertilizer_limits` ADD COLUMN `pH` float NULL COMMENT '';
ALTER TABLE `tbl_analysis` ADD COLUMN `pH` float NULL COMMENT '';

CREATE TABLE `physical_analysis` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `test_id` int DEFAULT NULL,
  `mean_particle_size` float DEFAULT NULL,
  `fine_particles` float DEFAULT NULL,
  `coarse_particles` float DEFAULT NULL,
  `mean_range` float DEFAULT NULL,
  `gsi` float DEFAULT NULL,
  `avg_shear_strength` float DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
);
