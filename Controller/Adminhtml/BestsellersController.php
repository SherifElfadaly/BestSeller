<?php

class Perceptive_BestSellers_Adminhtml_BestsellersController extends Mage_Adminhtml_Controller_Action
{
		protected function _initAction()
		{
				$this->loadLayout()->_setActiveMenu("bestsellers/bestsellers")->_addBreadcrumb(Mage::helper("adminhtml")->__("Bestsellers  Manager"),Mage::helper("adminhtml")->__("Bestsellers Manager"));
				return $this;
		}
		public function indexAction() 
		{
			    $this->_title($this->__("BestSellers"));
			    $this->_title($this->__("Manager Bestsellers"));

				$this->_initAction();
				$this->renderLayout();
		}
		public function editAction()
		{			    
			    $this->_title($this->__("BestSellers"));
				$this->_title($this->__("Bestsellers"));
			    $this->_title($this->__("Edit Item"));
				
				$id = $this->getRequest()->getParam("id");
				$model = Mage::getModel("bestsellers/bestsellers")->load($id);
				if ($model->getId()) {
					Mage::register("bestsellers_data", $model);
					$this->loadLayout();
					$this->_setActiveMenu("bestsellers/bestsellers");
					$this->_addBreadcrumb(Mage::helper("adminhtml")->__("Bestsellers Manager"), Mage::helper("adminhtml")->__("Bestsellers Manager"));
					$this->_addBreadcrumb(Mage::helper("adminhtml")->__("Bestsellers Description"), Mage::helper("adminhtml")->__("Bestsellers Description"));
					$this->getLayout()->getBlock("head")->setCanLoadExtJs(true);
					$this->_addContent($this->getLayout()->createBlock("bestsellers/adminhtml_bestsellers_edit"))->_addLeft($this->getLayout()->createBlock("bestsellers/adminhtml_bestsellers_edit_tabs"));
					$this->renderLayout();
				} 
				else {
					Mage::getSingleton("adminhtml/session")->addError(Mage::helper("bestsellers")->__("Item does not exist."));
					$this->_redirect("*/*/");
				}
		}

		public function newAction()
		{

		$this->_title($this->__("BestSellers"));
		$this->_title($this->__("Bestsellers"));
		$this->_title($this->__("New Item"));

        $id   = $this->getRequest()->getParam("id");
		$model  = Mage::getModel("bestsellers/bestsellers")->load($id);

		$data = Mage::getSingleton("adminhtml/session")->getFormData(true);
		if (!empty($data)) {
			$model->setData($data);
		}

		Mage::register("bestsellers_data", $model);

		$this->loadLayout();
		$this->_setActiveMenu("bestsellers/bestsellers");

		$this->getLayout()->getBlock("head")->setCanLoadExtJs(true);

		$this->_addBreadcrumb(Mage::helper("adminhtml")->__("Bestsellers Manager"), Mage::helper("adminhtml")->__("Bestsellers Manager"));
		$this->_addBreadcrumb(Mage::helper("adminhtml")->__("Bestsellers Description"), Mage::helper("adminhtml")->__("Bestsellers Description"));


		$this->_addContent($this->getLayout()->createBlock("bestsellers/adminhtml_bestsellers_edit"))->_addLeft($this->getLayout()->createBlock("bestsellers/adminhtml_bestsellers_edit_tabs"));

		$this->renderLayout();

		}
		public function saveAction()
		{

			$post_data=$this->getRequest()->getPost();


				if ($post_data) {

					try {

						

						$model = Mage::getModel("bestsellers/bestsellers")
						->addData($post_data)
						->setId($this->getRequest()->getParam("id"))
						->save();

						Mage::getSingleton("adminhtml/session")->addSuccess(Mage::helper("adminhtml")->__("Bestsellers was successfully saved"));
						Mage::getSingleton("adminhtml/session")->setBestsellersData(false);

						if ($this->getRequest()->getParam("back")) {
							$this->_redirect("*/*/edit", array("id" => $model->getId()));
							return;
						}
						$this->_redirect("*/*/");
						return;
					} 
					catch (Exception $e) {
						Mage::getSingleton("adminhtml/session")->addError($e->getMessage());
						Mage::getSingleton("adminhtml/session")->setBestsellersData($this->getRequest()->getPost());
						$this->_redirect("*/*/edit", array("id" => $this->getRequest()->getParam("id")));
					return;
					}

				}
				$this->_redirect("*/*/");
		}



		public function deleteAction()
		{
				if( $this->getRequest()->getParam("id") > 0 ) {
					try {
						$model = Mage::getModel("bestsellers/bestsellers");
						$model->setId($this->getRequest()->getParam("id"))->delete();
						Mage::getSingleton("adminhtml/session")->addSuccess(Mage::helper("adminhtml")->__("Item was successfully deleted"));
						$this->_redirect("*/*/");
					} 
					catch (Exception $e) {
						Mage::getSingleton("adminhtml/session")->addError($e->getMessage());
						$this->_redirect("*/*/edit", array("id" => $this->getRequest()->getParam("id")));
					}
				}
				$this->_redirect("*/*/");
		}

		
		public function massRemoveAction()
		{
			try {
				$ids = $this->getRequest()->getPost('best_sellers_ids', array());
				foreach ($ids as $id) {
                      $model = Mage::getModel("bestsellers/bestsellers");
					  $model->setId($id)->delete();
				}
				Mage::getSingleton("adminhtml/session")->addSuccess(Mage::helper("adminhtml")->__("Item(s) was successfully removed"));
			}
			catch (Exception $e) {
				Mage::getSingleton("adminhtml/session")->addError($e->getMessage());
			}
			$this->_redirect('*/*/');
		}
			
		/**
		 * Export order grid to CSV format
		 */
		public function exportCsvAction()
		{
			$fileName   = 'bestsellers.csv';
			$grid       = $this->getLayout()->createBlock('bestsellers/adminhtml_bestsellers_grid');
			$this->_prepareDownloadResponse($fileName, $grid->getCsvFile());
		} 
		/**
		 *  Export order grid to Excel XML format
		 */
		public function exportExcelAction()
		{
			$fileName   = 'bestsellers.xml';
			$grid       = $this->getLayout()->createBlock('bestsellers/adminhtml_bestsellers_grid');
			$this->_prepareDownloadResponse($fileName, $grid->getExcelFile($fileName));
		}
}
