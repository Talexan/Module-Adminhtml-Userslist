<?php
namespace Talexan\UsersList\Model\Repository\UsersRepository;

use Talexan\UsersList\Model\ResourceModel\UsersList as ResourceModel;
use Talexan\UsersList\Model\Users as Model;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;

/**
 * Users repository
 *
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class Users implements \Talexan\UsersList\Model\Repository\RepositoryInterface
{
    /**
     * @var ResourceModel
     */
    protected $resource;

    /**
     * @var Model
     */
    protected $model;

    /**
     * @param ResourceModel $resource
     * @param Model $model
     * @SuppressWarnings(PHPMD.ExcessiveParameterList)
     */
    public function __construct(
        ResourceModel $resource,
        Model $model
    ) {
        $this->resource = $resource;
        $this->model = $model;
    }

    /**
     * Save User data
     *
     * @param Model $user
     * @return Model
     * @throws CouldNotSaveException
     */
    public function save($user)
    {
        try {
            $this->resource->save($user);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(
                __('Could not save the user: %1', $exception->getMessage()),
                $exception
            );
        }
        return $user;
    }

    /**
     * Load User data by given Users Identity
     *
     * @param string $userId
     * @return Model
     * @throws NoSuchEntityException
     */
    public function getById($userId)
    {
        $user = $this->model;
        $user->load($userId);
        if (!$user->getId()) {
            throw new NoSuchEntityException(__('The User with the "%1" ID doesn\'t exist.', $userId));
        }

        return $user;
    }

    /**
     * Delete User
     *
     * @param Model $user
     * @return bool
     * @throws CouldNotDeleteException
     */
    public function delete($user)
    {
        try {
            $this->resource->delete($user);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(
                __('Could not delete the user: %1', $exception->getMessage())
            );
        }
        return true;
    }

    /**
     * Delete User by given User Identity
     *
     * @param string $userId
     * @return bool
     * @throws CouldNotDeleteException
     * @throws NoSuchEntityException
     */
    public function deleteById($userId)
    {
        return $this->delete($this->getById($userId));
    }
}
