<?php
namespace AHT\EnableDisableProduct\Controller\Index;

class Index extends \Magento\Framework\App\Action\Action
{
    protected $_product;
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Catalog\Model\Product $product
    ) {
        $this->_product = $product;
        parent::__construct($context);
    }

    public function execute()
    {
        $this->_product->load(2047);
        $this->_product->setStoreId(0);
        $stockItem = $this->_product->getExtensionAttributes();
    }
}