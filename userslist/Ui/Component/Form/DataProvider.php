<?php
namespace Talexan\UsersList\Ui\Component\Form;

use Talexan\UsersList\Model\ResourceModel\UsersList\CollectionFactory as CollectionFactory;
use Magento\Ui\DataProvider\Modifier\PoolInterface as PoolInterface;
use Magento\Framework\App\RequestInterface as Request;
use Talexan\UsersList\Model\UsersFactory as ModelFactory; 

/**
 * DataProvider for user edit form ui.
 */
class DataProvider extends \Magento\Ui\DataProvider\ModifierPoolDataProvider
{
    /**
     * @var Magento\Framework\App\RequestInterface
     */
    protected $request;

    /**
     * @var Talexan\UsersList\Model\UsersFactory
     */
    protected $modelFactory;

    /**
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param array $meta
     * @param array $data
     * @param PoolInterface|null $pool
     * @param CollectionFactory $collection
     * @param Request $request
     * @param ModelFactory $modelfactory
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        array $meta = [],
        array $data = [],
        PoolInterface $pool = null,
        CollectionFactory $collection,
        Request $request,
        ModelFactory $modelFactory 
    ) {
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data, $pool);
        $this->collection = $collection->create();
        $this->request = $request;
        $this->modelFactory = $modelFactory;
    }

    /**
     * Get data
     *
     * @return array
     */
    public function getData()
    {        
        return $this->prepareData(parent::getData());
    }

     /**
     * Prepare form user data
     * @param array $data
     * @return array
     */

    public function prepareData($data){

        $id = $this->request->getParam('id');

        if($id){
            try {
                    $model = $this->modelFactory->create();
                    $model->load($id);
                    $user = $model->getData();        
            } catch (\Exception $e) {
                // display error message
                $this->messageManager->addErrorMessage($e->getMessage());
                return $data;
            }
            $data[$id] = $user;
        }

        return $data;
    }
}
