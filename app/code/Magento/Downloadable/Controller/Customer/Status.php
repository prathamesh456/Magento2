<?php
/**
 *
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

// @codingStandardsIgnoreFile

namespace Magento\Downloadable\Controller\Customer;

use Magento\Framework\App\RequestInterface;

class Status extends \Magento\Framework\App\Action\Action
{
    /**
     * @var \Magento\Customer\Model\Session
     */
    protected $_customerSession;
    protected $_logger;

    /**
     * @param \Magento\Framework\App\Action\Context $context
     * @param \Magento\Customer\Model\Session $customerSession
     */
    public function __construct(\Magento\Framework\App\Action\Context $context, \Magento\Customer\Model\Session $customerSession,\Psr\Log\LoggerInterface $logger)
    {
        $this->_logger = $logger;
        $this->_customerSession = $customerSession;
        parent::__construct($context);
    }

    /**
     * Check customer authentication
     *
     * @param RequestInterface $request
     * @return \Magento\Framework\App\ResponseInterface
     */
    public function dispatch(RequestInterface $request)
    {
        $loginUrl = $this->_objectManager->get(\Magento\Customer\Model\Url::class)->getLoginUrl();

        if (!$this->_customerSession->authenticate($loginUrl)) {
            $this->_actionFlag->set('', self::FLAG_NO_DISPATCH, true);
        }
        return parent::dispatch($request);
    }

    /**
     * Display downloadable links bought by customer
     *
     * @return void
     */
    public function execute()
    {
       //echo "inside status function";
       // $objectManager = \Magento\Framework\App\ObjectManager::getInstance();


        $objectManager = \Magento\Framework\App\ObjectManager::getInstance(); // Instance of object manager
        $resource = $objectManager->get('Magento\Framework\App\ResourceConnection');
        $connection = $resource->getConnection();
        $tableName = $resource->getTableName('customer_entity'); //gives table name with prefix 


       $statusval = $this->getRequest()->getPostValue('statusdata');

       $customerSession = $this->_objectManager->get('Magento\Customer\Model\Session');
       //echo "Customer Entity ID : ";
       $customer_entity_id = $customerSession->getCustomer()->getId(); // prints customer's entity_id
       $customer_status = $customerSession->getCustomer()->getStatus();
       $customerSession->getCustomer()->setStatus('test');
       $customerSession->getCustomer()->save();
       $customerSession->getCustomer()->setMiddlename('AnandNew');
       $customerSession->getCustomer()->save();

       //Update Data into table
       $sql = "Update " . $tableName . " set status='".$statusval."' where entity_id =".$customer_entity_id;
       
       $this->_logger->info($sql);
       $this->_logger->debug($sql);

       $connection->query($sql);

       //$this->_logger->addDebug($statusval);

       //$this->_logger->info($statusval);
       //$this->_logger->debug($statusval);

       $this->_logger->info($customer_entity_id);
       $this->_logger->debug($customer_entity_id);


       echo $statusval;

       //print_r(get_class_methods());
    }
}
