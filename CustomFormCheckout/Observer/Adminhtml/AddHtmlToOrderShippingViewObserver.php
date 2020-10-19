<?php
namespace AHT\CustomFormCheckout\Observer\Adminhtml;

use Magento\Framework\Event\Observer as EventObserver;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\View\Element\Template;

class AddHtmlToOrderShippingViewObserver implements ObserverInterface
{

    /**
     * @var \Magento\Framework\View\Element\Template;
     */
    protected $_block;

    public function __construct(Template $block)
    {
        $this->_block = $block;
    }

    public function execute(EventObserver $observer)
    {
        if($observer->getElementName() == 'order_shipping_view') {
            $orderShippingViewBlock = $observer->getLayout()->getBlock($observer->getElementName());
            $order = $orderShippingViewBlock->getOrder();
            $orderByBlock = $this->_block;
            $orderByBlock->setOrderByy($order->getOrderByy());
            $orderByBlock->setTemplate('AHT_CustomFormCheckout::order_info_shipping_info.phtml');
            
            $html = $observer->getTransport()->getOutput() . $orderByBlock->toHtml();
            $observer->getTransport()->setOutput($html);          
        }
    }
}