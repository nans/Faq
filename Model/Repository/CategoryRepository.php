<?php

namespace Nans\Faq\Model\Repository;

use Exception;
use Magento\Framework\Model\AbstractModel;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Exception\CouldNotDeleteException;
use Nans\Faq\Api\Repository\CategoryRepositoryInterface;
use Nans\Faq\Api\Data\CategoryInterface;
use Nans\Faq\Model\ResourceModel\Category as CategoryResource;
use Nans\Faq\Model\CategoryFactory;


class CategoryRepository implements CategoryRepositoryInterface
{
    /**
     * @var array
     */
    protected $_instances = [];

    /**
     * @var CategoryResource
     */
    protected $_resource;

    /**
     * @var CategoryFactory
     */
    protected $_factory;

    /**
     * @param CategoryResource $resource
     * @param CategoryFactory $factory
     */
    public function __construct(
        CategoryResource $resource,
        CategoryFactory $factory
    ) {
        $this->_resource = $resource;
        $this->_factory = $factory;
    }

    /**
     * @param CategoryInterface $category
     *
     * @return void
     * @throws CouldNotDeleteException
     * @throws NoSuchEntityException
     */
    public function delete(CategoryInterface $category)
    {
        /** @var CategoryInterface|AbstractModel $category */
        $id = $category->getId();
        if(!$id){
            throw new NoSuchEntityException();
        }

        try {
            unset($this->_instances[$id]);
            $this->_resource->delete($category);
        } catch (Exception $e) {
            throw new CouldNotDeleteException(__($e->getMessage()));
        }
        unset($this->_instances[$id]);
    }

    /**
     * @param int $id
     *
     * @return void
     * @throws NoSuchEntityException
     * @throws CouldNotDeleteException
     */
    public function deleteById(int $id)
    {
        $this->delete($this->getById($id));
    }

    /**
     * @param int $id
     *
     * @return CategoryInterface
     * @throws NoSuchEntityException
     */
    public function getById(int $id): CategoryInterface
    {
        if(!$id){
            throw new NoSuchEntityException();
        }

        if (!isset($this->_instances[$id])) {
            /** @var CategoryInterface|AbstractModel $category */
            $category = $this->_factory->create();
            $this->_resource->load($category, $id);
            if (!$category->getId()) {
                throw new NoSuchEntityException();
            }
            $this->_instances[$id] = $category;
        }
        return $this->_instances[$id];
    }

    /**
     * @param CategoryInterface $category
     *
     * @return CategoryInterface
     * @throws CouldNotSaveException
     */
    public function save(CategoryInterface $category): CategoryInterface
    {
        /** @var CategoryInterface|AbstractModel $category */
        try {
            $this->_resource->save($category);
        } catch (Exception $exception) {
            throw new CouldNotSaveException(__('Could not save the record: %1', $exception->getMessage()));
        }
        return $category;
    }

    /**
     * @param array $data
     *
     * @return CategoryInterface
     */
    public function create(array $data = []): CategoryInterface
    {
        return $this->_factory->create(['data' => $data]);
    }
}