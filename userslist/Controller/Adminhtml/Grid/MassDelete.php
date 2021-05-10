<?php

namespace Talexan\Userslist\Controller\Adminhtml\Grid;

use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Backend\App\Action\Context;
use Magento\Ui\Component\MassAction\Filter;
use Talexan\UsersList\Model\ResourceModel\UsersList\Collection;

/**
 * Class MassDelete
 */
class MassDelete extends \Magento\Backend\App\Action implements HttpPostActionInterface
{
    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    const ADMIN_RESOURCE = 'Talexan_UsersList::acl_delete';

    /**
     * @var Filter
     */
    protected $filter;

    /**
     * @var Collection
     */
    protected $collection;

    /**
     * @param Context $context
     * @param Filter $filter
     * @param Collection $collection
     */
    public function __construct(Context $context, Filter $filter, Collection $collection)
    {
        $this->filter = $filter;
        $this->collection = $collection;
        parent::__construct($context);
    }

    /**
     * Execute action
     *
     * @return \Magento\Backend\Model\View\Result\Redirect
     * @throws \Magento\Framework\Exception\LocalizedException|\Exception
     */
    public function execute()
    {
        $collection = $this->filter->getCollection($this->collection);
        $collectionSize = $collection->getSize();

        foreach ($collection as $user) {
            $user->delete();
        }

        $this->messageManager->addSuccessMessage(__('A total of %1 record(s) have been deleted.', $collectionSize));

        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        
        return $resultRedirect->setPath('*/*/');
    }
}
