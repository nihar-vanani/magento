<?php 

class Nv_Product_Model_Observer extends Mage_Core_Model_Abstract{
	
	public function callMe(Varien_Event_Observer $observer)
	{
		/*echo "Hii, This is me.";
		echo "<pre>";
		$product = $observer->getEvent()->getProduct();
		print_r($product);
		die();*/
	}

	public function callNihar(Varien_Event_Observer $observer)
	{
		/*echo "Hii, This is Nihar.";
		die();
		echo "<pre>";
		$product = $observer->getEvent()->getProduct();
		print_r($product);*/
	}


}