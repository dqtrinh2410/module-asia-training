<?php
namespace AHT\EnableDisableProduct\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\CatalogInventory\Api\StockRegistryInterface;

class ProductSaveAfterObserver implements ObserverInterface
{
    /**
     * @var \Magento\ConfigurableProduct\Model\Product\Type\ConfigurableFactory
     */
    protected $_configurableFactory;
    protected $_stockRegistry;

    public function __construct(StockRegistryInterface $stock)
    {
        $this->_stockRegistry = $stock;
    }

    public function execute(Observer $observer)
    {
        $product = $observer->getProduct();
        $productTypeId = $product->getTypeId();
        //var_dump($productTypeId);die();
        if (in_array($productTypeId, array("configurable", "grouped", "bundle"))) {
            if ($productTypeId == "configurable") {
                $childProducts = $product->getTypeInstance()->getUsedProducts($product);
                foreach ($childProducts as $child) {                 
                    $stockItem = $this->_stockRegistry->getStockItem($child->getId());
                    $qty = $stockItem->getQty();
                    $is_in_stock = $stockItem->getIsInStock();
                    if ($qty && $is_in_stock) {
                        $child->setStatus(1);
                        $child->getResource()->saveAttribute($child, 'status');
                    } elseif ($qty == 0) {
                        $child->setStatus(2);
                        $child->getResource()->saveAttribute($child, 'status');
                    }
                }
            }
        } else {
            $stockItem = $this->_stockRegistry->getStockItem($product->getId());
            $qty = $stockItem->getQty();
            $is_in_stock = $stockItem->getIsInStock();
            if ($qty && $is_in_stock) {
                $product->setStatus(1);
                $product->getResource()->saveAttribute($product, 'status');
            } elseif ($qty == 0) {
                $product->setStatus(2);
                $product->getResource()->saveAttribute($product, 'status');
            }
        }     
    }
}
