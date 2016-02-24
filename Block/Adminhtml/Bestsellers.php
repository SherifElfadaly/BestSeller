<?php


class Perceptive_BestSellers_Block_Adminhtml_Bestsellers extends Mage_Adminhtml_Block_Widget_Grid_Container{

	public function __construct()
	{

	$this->_controller = "adminhtml_bestsellers";
	$this->_blockGroup = "bestsellers";
	$this->_headerText = Mage::helper("bestsellers")->__("Bestsellers Manager");
	$this->_addButtonLabel = Mage::helper("bestsellers")->__("Add New Item");
	parent::__construct();
	$this->_removeButton('add');
	}

}