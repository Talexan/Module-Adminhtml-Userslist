<?php

namespace Talexan\UsersList\Model;

use Talexan\UsersList\Model\ResourceModel\UsersList as UsersResource;
use Magento\Framework\Model\AbstractModel;
use \Magento\Framework\DataObject\IdentityInterface;

/**
 * Class UsersListing
 *
 * @package Talexan\UsersList\Model
 */
class Users extends AbstractModel implements IdentityInterface
{
    const CACHE_TAG = 'talexan_userslist_userslisting';

    /**
     * class construct
     */
    protected function _construct() 
    {
        $this->_init(UsersResource::class);
    }

        /**
         * Get identity
         * Implements IdentityInterface
         * @return string[] 
         */
        public function getIdentities() 
        {   
            return [self::CACHE_TAG . '_' . $this->getId()];
        }

        /**
         * Get default values
         * Implements IdentityInterface
         * @return [] 
         */
        public function getDefaultValues()
	    {
		    $values = [];

		    return $values;
	    }
}