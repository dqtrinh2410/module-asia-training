<?php
namespace AHT\CustomFormCheckout\Observer;

use Magento\Framework\Event\Observer as EventObserver;
use Magento\Framework\Event\ObserverInterface;
use Magento\Quote\Model\QuoteRepository;

class SaveDeliveryDateToOrderObserver implements ObserverInterface
{

    protected $_quoteRepository;
    protected $_logger;

    public function __construct(
        QuoteRepository $quoteRepository,
        \Psr\Log\LoggerInterface $logger
    ) {
        $this->_quoteRepository = $quoteRepository;
        $this->_logger = $logger;
    }

    public function execute(EventObserver $observer)
    {
        $order = $observer->getOrder();
        $quote = $this->_quoteRepository->get($order->getQuoteId());
        $order->setOrderByy($quote->getOrderByy());
        $this->_logger->debug(print_r($order->debug(), true));
        return $this;
    }
}