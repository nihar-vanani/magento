<?php

$installer = $this;

$installer->startSetup();

$installer->addAttribute(Nv_Vendor_Model_Resource_Vendor::ENTITY, 'firstname', array(
	'group' => 'General',
	'input' => 'text',
	'type' => 'varchar',
	'label' => 'firstname',
	'backend' => '',
	'visible' => 1,
	'required' => 0,
	'user_defined' => 1,
	'searchable' => 1,
	'filterable' => 0,
	'comparable' => 1,
	'visible_on_front' => 1,
	'visible_in_advanced_search' => 0,
	'is_html_allowed_on_front' => 1,
	'global' => 1,

));

$installer->addAttribute(Nv_Vendor_Model_Resource_Vendor::ENTITY, 'lastname', array(
	'group' => 'General',
	'input' => 'text',
	'type' => 'varchar',
	'label' => 'lastname',
	'backend' => '',
	'visible' => 1,
	'required' => 0,
	'user_defined' => 1,
	'searchable' => 1,
	'filterable' => 0,
	'comparable' => 1,
	'visible_on_front' => 1,
	'visible_in_advanced_search' => 0,
	'is_html_allowed_on_front' => 1,
	'global' => 1,
));
$installer->endSetup();
