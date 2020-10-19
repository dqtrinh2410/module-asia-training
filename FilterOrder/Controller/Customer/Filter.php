<?php
namespace AHT\FilterOrder\Controller\Customer;

use Magento\Framework\Controller\ResultFactory;

class Filter extends \Magento\Framework\App\Action\Action
{
    protected $_resultJsonFactory;
    protected $_resultFactory;

    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory,
        \Magento\Framework\Controller\ResultFactory $resultFactory
    ) {
        $this->_resultJsonFactory = $resultJsonFactory;
        $this->_resultFactory = $resultFactory;
        parent::__construct($context);
    }

    public function execute()
    {
        $data = $this->getRequest()->getParams('status');
        echo json_encode($data);
        exit;
    }
}