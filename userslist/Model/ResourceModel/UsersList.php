<?php
namespace Talexan\UsersList\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

/**
 * Talexan users list mysql resource
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class UsersList extends AbstractDb
{
    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('talexan_userslist_table', 'id');
    }
}
