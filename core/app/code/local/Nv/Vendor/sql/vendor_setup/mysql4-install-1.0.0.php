<?php
$installer = $this;
$installer->startSetup();
 
$installer->createEntityTables(
    $this->getTable('vendor/vendor_entity')
);
 
$installer->addEntityType('vendor',Array(
    'entity_model'          =>'vendor/vendor',
    'attribute_model'       =>'',
    'table'                 =>'vendor/vendor_entity',
    'increment_model'       =>'',
    'increment_per_store'   =>'0'
));
 
$installer->installEntities();
 
$installer->endSetup();