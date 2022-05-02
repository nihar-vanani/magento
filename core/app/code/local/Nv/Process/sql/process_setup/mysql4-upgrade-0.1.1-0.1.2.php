<?php
$this->startSetup()->run("

ALTER TABLE {$this->getTable('process/process_column')}
    ADD COLUMN `sample_value` VARCHAR(128) DEFAULT '' NOT NULL AFTER `casting_type`;
")->endSetup();