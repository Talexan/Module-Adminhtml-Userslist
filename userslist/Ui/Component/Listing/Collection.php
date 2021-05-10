<?php
namespace Talexan\UsersList\Ui\Component\Listing;

use Magento\Framework\View\Element\UiComponent\DataProvider\SearchResult;

class Collection extends SearchResult
{

      protected function _initSelect()
      {
          $this->addFilterToMap('id', 'main_table.id');
          parent::_initSelect();
      }
}
