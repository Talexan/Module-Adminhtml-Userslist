<?php
namespace Talexan\UsersList\Controller\Adminhtml\Grid;

use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;

/**
 * Index action.
 */
class Index extends \Magento\Backend\App\AbstractAction implements \Magento\Framework\App\Action\HttpGetActionInterface
{
    /**
     * @var PageFactory
     */
    protected $resultPageFactory;

    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    const ADMIN_RESOURCE = 'Talexan_UsersList::acl_listing';

    /**
     * @param Context $context
     * @param PageFactory $resultPageFactory
     */
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory
    ) {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
    }

    /**
     * Index action
     *
     * @return \Magento\Backend\Model\View\Result\Page
     */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        
        $resultPage = $this->resultPageFactory->create();
 
        $this->_setActiveMenu(
            'Talexan_UsersList::users_listing'
        )->_addBreadcrumb(
            __('System'),
            __('System')
        )->_addBreadcrumb(
            __('Talexan'),
            __('Talexan')
        )->_addBreadcrumb(
            __('UsersList'),
            __('UsersList')
        );
        
        $this->_view->getPage()->getConfig()->getTitle()->prepend(__('Talexan - Listing Of Users'));
        
        return $resultPage;
    }
}
