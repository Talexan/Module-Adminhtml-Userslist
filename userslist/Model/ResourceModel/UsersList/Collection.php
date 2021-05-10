<?php

namespace Talexan\UsersList\Model\ResourceModel\UsersList;

use Talexan\UsersList\Model\Users as UsersModel;
use Talexan\UsersList\Model\ResourceModel\UsersList as UsersResource;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
use Magento\Framework\Data\Collection\EntityFactoryInterface;
use Magento\Framework\Data\Collection\Db\FetchStrategyInterface;
use Magento\Framework\Event\ManagerInterface;
use Magento\Framework\DB\Adapter\AdapterInterface;
use Psr\Log\LoggerInterface;

/**
 * Class Collection
 *
 * @package Talexan\UsersList\Model\ResourceModel\Users
 */
class Collection extends AbstractCollection
{
    /**
     * @var string
     */
    protected $_idFieldName = 'id';

    /**
     * Collection constructor.
     *
     * @param EntityFactoryInterface $entityFactory
     * @param LoggerInterface $logger
     * @param FetchStrategyInterface $fetchStrategy
     * @param ManagerInterface $eventManager
     * @param AdapterInterface|null $connection
     * @param AbstractDb|null $resource
     */
    public function __construct(
        EntityFactoryInterface $entityFactory,
        LoggerInterface $logger,
        FetchStrategyInterface $fetchStrategy,
        ManagerInterface $eventManager,
        AdapterInterface $connection = null,
        AbstractDb $resource = null
    ) {
        parent::__construct($entityFactory, $logger, $fetchStrategy, $eventManager, $connection, $resource);
    }

    /**
     * Class construct.
     */
    protected function _construct()
    {
        $this->_init(UsersModel::class, UsersResource::class);
    }
}