<?php

namespace Talexan\UsersList\Controller\Adminhtml\Grid;

use Magento\Framework\App\Action\HttpPostActionInterface;

/**
 * Delete User record action.
 */
class Delete extends \Magento\Backend\App\Action implements HttpPostActionInterface
{
    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    const ADMIN_RESOURCE = 'Talexan_UsersList::acl_delete';

    /**
     * Delete action
     *
     * @return \Magento\Backend\Model\View\Result\Redirect
     */
    public function execute()
    {
        // check if we know what should be deleted
        $id = $this->getRequest()->getParam('id');
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        
        if ($id) {
            try {
                // init model and delete
                $model = $this->_objectManager->create(\Talexan\UsersList\Model\Users::class);
                $model->load($id);
                
                $model->delete();
                
                // display success message
                $this->messageManager->addSuccessMessage(__('The user has been deleted.'));
                
                return $resultRedirect->setPath('*/*/');
            } catch (\Exception $e) {
                // display error message
                $this->messageManager->addErrorMessage($e->getMessage());
                // go back 
                return $resultRedirect->setPath('*/*/');
            }
        }
        
        // display error message
        $this->messageManager->addErrorMessage(__('We can\'t find a user to delete.'));
        
        // go to grid
        return $resultRedirect->setPath('*/*/');
    }
}
