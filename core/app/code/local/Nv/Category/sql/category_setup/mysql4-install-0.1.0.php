<?php

    $installer = $this;

    $installer->startSetup();

    $installer->run("

    -- DROP TABLE IF EXISTS {$this->getTable('category')};
    CREATE TABLE {$this->getTable('category')} (
      `category_id` int(11) NOT NULL auto_increment,
      `parent_id` int(11) DEFAULT NULL,
      `name` varchar(256) NOT NULL,
      `path` varchar(1024) NOT NULL,
      `status` tinyint(1) NOT NULL DEFAULT 1,
      `created_at` datetime DEFAULT NULL,
      `updated_at` datetime DEFAULT NULL,
      PRIMARY KEY (`category_id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
        ");

    $installer->endSetup();