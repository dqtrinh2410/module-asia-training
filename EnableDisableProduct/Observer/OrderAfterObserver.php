<?php
namespace AHT\EnableDisableProduct\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\CatalogInventory\Api\StockRegistryInterface;
use Magento\Catalog\Model\Product;

class OrderAfterObserver implements ObserverInterface
{
    /**
     * @var \Magento\CatalogInventory\Api\StockRegistryInterface
     */
    protected $_stockRegistry;

    /**
     * @var \Magento\Catalog\Model\Product
     */
    protected $_product;

    public function __construct(StockRegistryInterface $stockRegistry, Product $product)
    {
        $this->_stockRegistry = $stockRegistry;
        $this->_product = $product;
    }

    public function execute(Observer $observer)
    {
        $order = $observer->getOrder();
        $itemCollection = $order->getItemsCollection();
        foreach($itemCollection as $item) {
            $productType = $item->getProductType();
            if (in_array($productType, ["simple", "virtual"])) {
                $this->_product->load($item->getProductId());
                $stockItem = $this->_stockRegistry->getStockItem($item->getProductId());
                $qty = $stockItem->getQty() - floatval($item->getQtyOrdered());
                if (!$qty) {
                    $this->_product->setStatus(2);                   
                    $this->_product->getResource()->saveAttribute($this->_product, 'status');
                }
            }
        }
    }
}