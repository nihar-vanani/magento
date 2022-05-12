<?php
$this->startSetup()->run("

ALTER TABLE {$this->getTable('product/product')}
    ADD COLUMN `category_id` int(11) unsigned NULL AFTER `productId`;
")->endSetup();