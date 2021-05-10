<?php
namespace Talexan\UsersList\Model\Repository;

interface RepositoryInterface
{
   /**
     * Save User data
     *
     * @param Model $user
     * @return Model
     * @throws CouldNotSaveException
     */
    public function save($user);

    /**
     * Load User data by given Users Identity
     *
     * @param string $userId
     * @return Model
     * @throws NoSuchEntityException
     */
    public function getById($userId);

    /**
     * Delete User
     *
     * @param Model $user
     * @return bool
     * @throws CouldNotDeleteException
     */
    public function delete($user);

    /**
     * Delete User by given User Identity
     *
     * @param string $userId
     * @return bool
     * @throws CouldNotDeleteException
     * @throws NoSuchEntityException
     */
    public function deleteById($userId);
}
