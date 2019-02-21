<?php
/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magento\Downloadable\Controller\Adminhtml\Index;
 
class Status extends \Magento\Customer\Controller\Adminhtml\Index
{
    /**
     * Customer compare grid
     *
     * @return \Magento\Framework\View\Result\Layout
     */
    public function execute()
    {
       
       
       $objectManager = \Magento\Framework\App\ObjectManager::getInstance(); // Instance of object manager
        $resource = $objectManager->get('Magento\Framework\App\ResourceConnection');
        $connection = $resource->getConnection();
        $tableName = $resource->getTableName('customer_entity'); //gives table name with prefix 

        $idval = $this->getRequest()->getPostValue('iddata');
        $statusval = $this->getRequest()->getPostValue('statusdata');

      

        $sql = "Update " . $tableName . " set status='".$statusval."' where entity_id =".$idval;
        

        $connection->query($sql);

        echo $statusval;
    }
 
 
}
