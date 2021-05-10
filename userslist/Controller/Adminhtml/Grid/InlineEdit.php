<?php
namespace Talexan\UsersList\Controller\Adminhtml\Grid;

use Magento\Backend\App\Action\Context;
use Talexan\UsersList\Model\Repository\RepositoryInterface;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\Controller\Result\JsonFactory;

/**
 * Inline edit controller
 *
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class InlineEdit extends \Magento\Backend\App\Action implements HttpPostActionInterface
{
    /**
     * Authorization level of a basic admin session
     */
    const ADMIN_RESOURCE = 'Talexan_UsersList::acl_save';

    /**
     * @var \Magento\Framework\Controller\Result\JsonFactory
     */
    protected $jsonFactory;

    /**
     * @var \Talexan\UsersList\Model\Repository\ReposirotyInterface
     */
    protected $repository;


    /**
     * @param Context $context
     * @param JsonFactory $jsonFactory
     * @param RepositoryInterface $repository
     */
    public function __construct(
        Context $context,
        JsonFactory $jsonFactory,
        RepositoryInterface $repository
    ) {
        parent::__construct($context);
        $this->jsonFactory = $jsonFactory;
        $this->repository = $repository;
    }

    /**
     * Process the request
     *
     * @return \Magento\Framework\Controller\ResultInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function execute()
    {
        /** @var \Magento\Framework\Controller\Result\Json $resultJson */
        $resultJson = $this->jsonFactory->create();
        $error = false;
        $messages = [];

        $postItems = $this->getRequest()->getParam('items', []);
        if (!($this->getRequest()->getParam('isAjax') && count($postItems))) {
            return $resultJson->setData(
                [
                    'messages' => [__('Please correct the data sent.')],
                    'error' => true,
                ]
            );
        }

        foreach (array_keys($postItems) as $userId) {
            try {
                $user = $this->repository->getById($userId);
                $userData = $postItems[$userId];
                $this->validatePost($userData, $user, $error, $messages);
                $this->setUserData($user, $userData);
                $this->repository->save($user);
            } catch (\Magento\Framework\Exception\LocalizedException $e) {
                $messages[] = $this->getErrorWithUserId($user, $e->getMessage());
                $error = true;
            } catch (\RuntimeException $e) {
                $messages[] = $this->getErrorWithUserId($user, $e->getMessage());
                $error = true;
            } catch (\Exception $e) {
                $messages[] = $this->getErrorWithUserId(
                    $user,
                    __('Something went wrong while saving the user.')
                );
                $error = true;
            }
        }

        return $resultJson->setData(
            [
                'messages' => $messages,
                'error' => $error
            ]
        );
    }

    /**
     * Validate post data
     *
     * @param array $userData
     * @param \Talexan\UsersList\Model\Users $user
     * @param bool $error
     * @param array $messages
     * @return void
     */
    protected function validatePost(array $userData, \Talexan\UsersList\Model\Users $user, &$error, array &$messages)
    {
        if (!$this->validateRequireEntry($userData)) {
            $error = true;
            foreach ($this->messageManager->getMessages(true)->getItems() as $error) {
                $messages[] = $this->getErrorWithUserId($user, $error->getText());
            }
        }
    }

    /**
     * Check if required fields is not empty
     *
     * @param array $data
     * @return bool
     */
    protected function validateRequireEntry(array $data)
    {
        $requiredFields = [
            'fname' => __('First Name'),
            'lname' => __('Last Name'),
            'email' => __('E-mail')
        ];
        $errorNo = true;
        foreach ($data as $field => $value) {
            if (in_array($field, array_keys($requiredFields)) && $value == '') {
                $errorNo = false;
                $this->messageManager->addErrorMessage(
                    __('To apply changes you should fill in hidden required "%1" field', $requiredFields[$field])
                );
            }
        }
        return $errorNo;
    }

    /**
     * Add user id to error message
     *
     * @param Model $user
     * @param string $errorText
     * @return string
     */
    protected function getErrorWithUserId($user, $errorText)
    {
        return '[User ID: ' . $user->getId() . '] ' . $errorText;
    }

    /**
     * Set user data
     *
     * @param \Talexan\UsersList\Model\Users $user
     * @param array $userData
     * @return $this
     */
    public function setUserData(\Talexan\UsersList\Model\Users $user, array $userData)
    {
        $user->setData($userData);
        return $this;
    }
}
