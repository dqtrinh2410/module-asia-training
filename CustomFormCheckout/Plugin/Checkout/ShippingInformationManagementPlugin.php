<?php
namespace AHT\CustomFormCheckout\Plugin\Checkout;

use Magento\Quote\Model\QuoteRepository;
use Magento\Checkout\Model\ShippingInformationManagement;
use Magento\Checkout\Api\Data\ShippingInformationInterface;

class ShippingInformationManagementPlugin
{
    /**
     * @var \Magento\Quote\Model\QuoteRepository $quoteRepository
     */
    protected $_quoteRepository;

    protected $_logger;

    public function __construct(QuoteRepository $quoteRepository,\Psr\Log\LoggerInterface $logger)
    {
        $this->_quoteRepository = $quoteRepository;
        $this->_logger = $logger;
    }

    /**
     * @param \Magento\Checkout\Model\ShippingInformationManagement $subject
     * @param $cartId
     * @param \Magento\Checkout\Api\Data\ShippingInformationInterface $addressInformation
     */
    public function beforeSaveAddressInformation(
        ShippingInformationManagement $subject,
        $cartId,
        ShippingInformationInterface $addressInformation
    ) {
        $extAttributes = $addressInformation->getExtensionAttributes();
        $orderBy = $extAttributes->getOrderByy();
        $quote = $this->_quoteRepository->getActive($cartId);
        $quote->setOrderByy($orderBy);
        // $this->_logger->debug(print_r($orderBy, true));
    }

}