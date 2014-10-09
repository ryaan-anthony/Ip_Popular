<?php

class Ip_Popular_Block_Product_List extends Mage_Catalog_Block_Product_List
{
    protected $_cacheKey = "Ip_Popular_Block_Product_List";
    protected $_productCollection;

    protected function _construct()
    {
        $this->addData(array(
            'cache_lifetime'=> false,
            'cache_tags'    => array(
                Mage_Core_Model_Store::CACHE_TAG,
                Mage_Cms_Model_Block::CACHE_TAG
            )
        ));
        parent::_construct();
    }

    protected function _getProductCollection()
    {
        if (is_null($this->_productCollection)) {
            $categoryId = 14;//@todo assign from config
            /* @var $this Mage_Catalog_Model_Category */
            $category = Mage::getModel('catalog/category')->load($categoryId);

            /* @var $layer Mage_Catalog_Model_Layer */
            $layer = $this->getLayer();

            if ($category->getId()) {
                $layer->setCurrentCategory($category);
                $this->addModelTags($category);
            }
            $this->_productCollection = $layer->getProductCollection();

            $this->prepareSortableFieldsByCategory($layer->getCurrentCategory());


        }

        return $this->_productCollection;
    }
    /**
     * Get cache key informative items
     *
     * @return array
     */
    public function getCacheKeyInfo()
    {
        return array(
            $this->_cacheKey,
            Mage::app()->getStore()->getId(),
            (int)Mage::app()->getStore()->isCurrentlySecure(),
            Mage::getDesign()->getPackageName(),
            Mage::getDesign()->getTheme('template')
        );
    }


    /**
     * Retrieve child block HTML, sorted by default
     *
     * @param   string $name
     * @param   boolean $useCache
     * @return  string
     */
    public function getChildHtml($name='', $useCache=true, $sorted=true)
    {
        return parent::getChildHtml($name, $useCache, $sorted);
    }
}