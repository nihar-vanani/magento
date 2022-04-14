<?php

    $installer = $this;

    $installer->startSetup();

    $installer->run("

    -- DROP TABLE IF EXISTS {$this->getTable('salesman')};
    CREATE TABLE {$this->getTable('salesman')} (
      `salesmanId` int(11) unsigned NOT NULL auto_increment,
      `firstName` varchar(256) NOT NULL,
      `lastName` varchar(256) NOT NULL,
      `email` varchar(128) NOT NULL,
      `mobile` int(11) DEFAULT NULL,
      `percentage` decimal(4,2) NOT NULL,
      `status` tinyint(1) NOT NULL DEFAULT 1,
      `createdAt` datetime DEFAULT NULL,
      `updatedAt` datetime DEFAULT NULL,
      PRIMARY KEY (`salesmanId`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
        ");

    $installer->endSetup();