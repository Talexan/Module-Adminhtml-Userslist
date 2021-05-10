<?php
namespace Talexan\UsersList\Controller\Adminhtml\User;

use Magento\Backend\Block\Widget\Context;
use Talexan\UsersList\Model\Repository\RepositoryInterface;
use Magento\Framework\Exception\NoSuchEntityException;

/**
 * Class GenericButton
 */
class GenericButton
{
    /**
     * @var Context
     */
    protected $context;

    /**
     * @var RepositoryInterface
     */
    protected $repository;

    /**
     * @param Context $context
     * @param RepositoryInterface $repository
     */
    public function __construct(
        Context $context,
        RepositoryInterface $repository
    ) {
        $this->context = $context;
        $this->repository = $repository;
    }

    /**
     * Return user ID
     *
     * @return int|null
     */
    public function getUserId()
    {
        try {
            return $this->repository->getById(
                $this->context->getRequest()->getParam('id')
            )->getId();
        } catch (NoSuchEntityException $e) {
        }
        return null;
    }

    /**
     * Generate url by route and parameters
     *
     * @param   string $route
     * @param   array $params
     * @return  string
     */
    public function getUrl($route = '', $params = [])
    {
        return $this->context->getUrlBuilder()->getUrl($route, $params);
    }
}
