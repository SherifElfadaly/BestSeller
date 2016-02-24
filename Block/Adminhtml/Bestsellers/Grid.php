<?php

class Perceptive_BestSellers_Block_Adminhtml_Bestsellers_Grid extends Mage_Adminhtml_Block_Widget_Grid
{

	public function __construct()
	{
		parent::__construct();
		$this->setId("bestsellersGrid");
		$this->setDefaultSort("best_sellers_id");
		$this->setDefaultDir("DESC");
		$this->setSaveParametersInSession(true);
	}

	protected function _prepareCollection()
	{
		$collection = Mage::getModel("bestsellers/bestsellers")->getCollection();
		$collection->getSelect()->join(array('c'=>'catalog_product_entity'),'main_table.product_id = c.entity_id');
		
		$this->setCollection($collection);
		return parent::_prepareCollection();
	}
	protected function _prepareColumns()
	{
		$this->addColumn("best_sellers_id", array(
			"header" => Mage::helper("bestsellers")->__("ID"),
			"align" =>"right",
			"width" => "50px",
			"type" => "number",
			"index" => "best_sellers_id",
			));

		$this->addColumn("sku", array(
			"header" => Mage::helper("bestsellers")->__("Product"),
			"index" => "sku",
			));
		$this->addColumn("amount", array(
			"header" => Mage::helper("bestsellers")->__("Amount"),
			"index" => "amount",
			));
		$this->addColumn("category_ids", array(
			"header" => Mage::helper("bestsellers")->__("Category"),
			"index" => "category_ids",
			));
		$this->addExportType('*/*/exportCsv', Mage::helper('sales')->__('CSV')); 
		$this->addExportType('*/*/exportExcel', Mage::helper('sales')->__('Excel'));

		return parent::_prepareColumns();
	}

	public function getRowUrl($row)
	{
		return '#';
	}



	protected function _prepareMassaction()
	{
		$this->setMassactionIdField('best_sellers_id');
		$this->getMassactionBlock()->setFormFieldName('best_sellers_ids');
		$this->getMassactionBlock()->setUseSelectAll(true);
		$this->getMassactionBlock()->addItem('remove_bestsellers', array(
			'label'=> Mage::helper('bestsellers')->__('Remove Bestsellers'),
			'url'  => $this->getUrl('*/adminhtml_bestsellers/massRemove'),
			'confirm' => Mage::helper('bestsellers')->__('Are you sure?')
			));
		return $this;
	}


}