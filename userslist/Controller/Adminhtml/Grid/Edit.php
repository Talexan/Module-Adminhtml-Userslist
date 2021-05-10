<?php

namespace Talexan\UsersList\Controller\Adminhtml\Grid;

use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Backend\App\Action;

/**
 * Edit User record action.
 */
class Edit extends \Magento\Backend\App\Action implements HttpGetActionInterface
{
    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    const ADMIN_RESOURCE = 'Talexan_UsersList::acl_edit';

    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $resultPageFactory;

    /**
     * @var \Talexan\UsersList\Model\UsersFactory
     */
    protected $modelFactory;


    /**
     * @param Action\Context $context
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     * @param \Talexan\UsersList\Model\UsersFactory $modelFactory
     */
    public function __construct(
        Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Talexan\UsersList\Model\UsersFactory $modelFactory
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->modelFactory = $modelFactory;
        parent::__construct($context);
    }

    /**
     * Init actions
     *
     * @return \Magento\Backend\Model\View\Result\Page
     */
    protected function _initAction()
    {
        // load layout, 
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
        // set active menu and breadcrumbs
        $resultPage->setActiveMenu('Talexan_UsersList::users_listing')
        ->addBreadcrumb(
            __('System'),
            __('System')
        )->addBreadcrumb(
            __('Talexan'),
            __('Talexan')
        );
        return $resultPage;
    }

    /**
     * Edit User record
     *
     * @return \Magento\Backend\Model\View\Result\Page|\Magento\Backend\Model\View\Result\Redirect
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    public function execute()
    {
        // 1. Get ID and create model
        $id = $this->getRequest()->getParam('id');
        $model = $this->modelFactory->create();

        // 2. Initial checking
        if ($id) {
            $model->load($id);
            if (!$model->getId()) {
                $this->messageManager->addErrorMessage(__('This user no longer exists.'));
                /** \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
                $resultRedirect = $this->resultRedirectFactory->create();
                return $resultRedirect->setPath('*/*/');
            }
        }

        // 5. Build edit form
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->_initAction();
        $resultPage->addBreadcrumb(
           $id ? __('Edit User') : __('New User'),
           $id ? __('Edit User') : __('New User')
        );
        $resultPage->getConfig()->getTitle()
           ->prepend($model->getId() ? __('Edit User') : __('New User'));

        return $resultPage;
    }
}
