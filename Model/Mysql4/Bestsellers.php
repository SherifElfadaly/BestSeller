<?php
class Perceptive_BestSellers_Model_Mysql4_Bestsellers extends Mage_Core_Model_Mysql4_Abstract
{
    protected function _construct()
    {
        $this->_init("bestsellers/bestsellers", "best_sellers_id");
    }
}