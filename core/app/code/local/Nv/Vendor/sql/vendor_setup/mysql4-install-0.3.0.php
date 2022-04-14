<?php

    $installer = $this;

    $installer->startSetup();

    $installer->run("

    -- DROP TABLE IF EXISTS {$this->getTable('vendor')};
    CREATE TABLE {$this->getTable('vendor')} (
      `vendorId` int(11) unsigned NOT NULL auto_increment,
      `firstName` varchar(255) NOT NULL,
      `lastName` varchar(255) NOT NULL,
      `email` varchar(255) NOT NULL,
      PRIMARY KEY (`vendorId`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

        ");

    $installer->endSetup();