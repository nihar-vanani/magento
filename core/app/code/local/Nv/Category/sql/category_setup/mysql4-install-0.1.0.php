<?php

    $installer = $this;

    $installer->startSetup();

    $installer->run("

    -- DROP TABLE IF EXISTS {$this->getTable('category')};
    CREATE TABLE {$this->getTable('category')} (
      `categoryId` int(11) NOT NULL auto_increment,
      `parentId` int(11) DEFAULT NULL,
      `name` varchar(256) NOT NULL,
      `path` varchar(1024) NOT NULL,
      `status` tinyint(1) NOT NULL DEFAULT 1,
      `createdAt` datetime DEFAULT NULL,
      `updatedAt` datetime DEFAULT NULL,
      PRIMARY KEY (`categoryId`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
        ");

    $installer->endSetup();