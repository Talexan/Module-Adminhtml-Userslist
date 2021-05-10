<?php
namespace Talexan\UsersList\Controller\Adminhtml\Grid;

use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Backend\App\Action;
use Talexan\UsersList\Model\UsersFactory as ModelFactory;
use \Talexan\UsersList\Model\Repository\RepositoryInterface as Repository;
use Magento\Framework\Exception\LocalizedException;

/**
 * Save User action.
 *
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class Save extends \Magento\Backend\App\Action implements HttpPostActionInterface
{
    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    const ADMIN_RESOURCE = 'Talexan_UsersList::acl_save';

    /**
     * @var \Talexan\UsersList\Model\Users
     */
    protected $modelFactory;

     /**
     * @var \Talexan\UsersList\Model\Repository\RepositoryInterface
     */
    private $repository;


    /**
     * @param Action\Context $context
     * @param ModelFactory
     * @param Repository $repository
     */
    public function __construct(
        Action\Context $context,
        ModelFactory $modelFactory,
        Repository $repository
    ) {
        $this->modelFactory = $modelFactory;
        $this->repository = $repository;
        parent::__construct($context);
    }

    /**
     * Save action
     *
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $data = $this->getRequest()->getPostValue();
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        if ($data) {
            
            /** @var \Talexan\UsersList\Model\Users $model */
            $model = $this->modelFactory->create();

            $id = $this->getRequest()->getParam('id');
            if ($id) {
                try {
                    $model = $this->repository->getById($id);
                } catch (LocalizedException $e) {
                    $this->messageManager->addErrorMessage(__('This user no longer exists.'));
                    return $resultRedirect->setPath('*/*/');
                }
            }
            else
                $data['id']=null; // this is new user

            $model->setData($data);

            try {
                $this->repository->save($model);
                $this->messageManager->addSuccessMessage(__('You saved the user.'));
                return $this->processResultRedirect($model, $resultRedirect);
            } catch (LocalizedException $e) {
                $this->messageManager->addExceptionMessage($e->getPrevious() ?: $e);
            } catch (\Throwable $e) {
                $this->messageManager->addExceptionMessage($e, __('Something went wrong while saving the user.'));
            }

            return $resultRedirect->setPath('*/*/edit', ['id' => $this->getRequest()->getParam('id')]);
        }
        return $resultRedirect->setPath('*/*/');
    }

    /**
     * Process result redirect
     *
     * @param \Talexan\UsersList\Model\Users $model
     * @param \Magento\Backend\Model\View\Result\Redirect $resultRedirect
     * @param array $data
     * @return \Magento\Backend\Model\View\Result\Redirect
     * @throws LocalizedException
     */
    private function processResultRedirect($model, $resultRedirect)
    {
        if ($this->getRequest()->getParam('back', false) === 'new') {
            return $resultRedirect->setPath(
                '*/*/edit',
                ['id' => null]
            );
        }
        if ($this->getRequest()->getParam('back')) {
            return $resultRedirect->setPath('*/*/edit', [
                'id' => $model->getData('id')]);
        }
        return $resultRedirect->setPath('*/*/');
    }
}
