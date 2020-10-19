<?php
namespace AHT\FilterOrder\Block\Order;

use Magento\Framework\App\ObjectManager;
use Magento\Sales\Model\ResourceModel\Order\CollectionFactoryInterface;
use Magento\Sales\Model\ResourceModel\Order\Status\CollectionFactory as StatusCollectionFactory;

class History extends \Magento\Sales\Block\Order\History
{
    protected $_template = 'AHT_FilterOrder::order/view/history.phtml';
    protected $orderCollectionFactory;
    protected $orders;
    protected $orderStatus = 'pending';
    protected $_customerSession;
    protected $_orderConfig;
    protected $_statusCollectionFactory;
    protected $_storeManager;

    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Sales\Model\ResourceModel\Order\CollectionFactory $orderCollectionFactory,
        \Magento\Customer\Model\Session $customerSession,
        \Magento\Sales\Model\Order\Config $orderConfig,
        StatusCollectionFactory $statusCollectionFactory,
        array $data = []
    ) {
        $this->_orderCollectionFactory = $orderCollectionFactory;
        $this->_customerSession = $customerSession;
        $this->_orderConfig = $orderConfig;
        $this->_statusCollectionFactory = $statusCollectionFactory;
        parent::__construct($context, $orderCollectionFactory, $customerSession, $orderConfig, $data);
    }

    private function getOrderCollectionFactory()
    {
        if ($this->orderCollectionFactory === null) {
            $this->orderCollectionFactory = ObjectManager::getInstance()->get(CollectionFactoryInterface::class);
        }
        return $this->orderCollectionFactory;
    }

    /**
     * Get customer orders
     *
     * @return bool|\Magento\Sales\Model\ResourceModel\Order\Collection
     */
    public function getOrders()
    {       
        if (!($customerId = $this->_customerSession->getCustomerId())) {
            return false;
        }

        $paramStatus = $this->getRequest()->getParam('status');
        
        if (!$this->orders) {
            if($paramStatus) {
                $this->orders = $this->getOrderCollectionFactory()->create($customerId)->addFieldToSelect(
                    '*'
                )->addFieldToFilter(
                    'status',
                    $paramStatus
                )->setOrder(
                    'created_at',
                    'desc'
                );
            } else {
                $this->orders = $this->getOrderCollectionFactory()->create($customerId)->addFieldToSelect(
                    '*'
                )->addFieldToFilter(
                    'status',
                    $this->orderStatus
                )->setOrder(
                    'created_at',
                    'desc'
                );
            }
            
        }
        return $this->orders;
    }

    public function getStatusCollection() {
        return $this->_statusCollectionFactory->create();
    }

    public function getParam() {
        return $this->getRequest()->getParam('status');
    }

    public function getBaseUrl() {
        // die($this->_storeManager->getStore()->getBaseUrl());
        return $this->_storeManager->getStore()->getBaseUrl();
    }
}