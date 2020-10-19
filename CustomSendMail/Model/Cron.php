<?php
namespace AHT\CustomSendMail\Model;

use Magento\Customer\Model\ResourceModel\Customer\CollectionFactory;
use Magento\Framework\Mail\Template\TransportBuilder;
use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\Translate\Inline\StateInterface;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\Stdlib\DateTime\TimezoneInterface;
use Magento\Framework\Stdlib\DateTime\DateTime;

class Cron {

    protected $_logger;
    protected $_collectionCustomerFactory;
    protected $_timeZone;
    protected $_storeManager;
    protected $_currentDate;

    public function __construct(
        \Psr\Log\LoggerInterface $logger,
        CollectionFactory $collectionFactory,
        TimezoneInterface $timeZone,
        StoreManagerInterface $storeManager,
        DateTime $dateTime
    ) {
        $this->_logger = $logger;
        $this->_collectionCustomerFactory = $collectionFactory;
        $this->_timeZone = $timeZone;
        $this->_storeManager = $storeManager;
        $this->_currentDate = $dateTime;
    }

    public function sendMail() {
        $collection = $this->_collectionCustomerFactory->create();
        $this->_logger->debug(print_r($this->_currentDate->gmtDate('Y-m-d'), true));
    }
}