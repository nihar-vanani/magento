<?php
$this->startSetup()->run("

ALTER TABLE {$this->getTable('process/process_column')}
    ADD COLUMN `sort_order` decimal(5,2) unsigned NOT NULL default '999.00' AFTER `casting_type`;
")->endSetup();