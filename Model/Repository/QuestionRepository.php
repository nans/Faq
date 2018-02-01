<?php

namespace Nans\Faq\Model\Repository;

use Nans\Faq\Api\Data\QuestionInterface;
use Nans\Faq\Api\Repository\QuestionRepositoryInterface;
use Nans\Faq\Model\ResourceModel\Question as ResourceQuestion;
use Nans\Faq\Model\QuestionFactory;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Exception\CouldNotDeleteException;
use Exception;

class QuestionRepository implements QuestionRepositoryInterface
{
    /**
     * @var array
     */
    protected $_instances = [];

    /**
     * @var ResourceQuestion
     */
    protected $_resource;

    /**
     * @var QuestionFactory
     */
    protected $_factory;

    /**
     * Factory constructor
     * @param ResourceQuestion $resource,
     * @param QuestionFactory $questionFactory
     */
    public function __construct(
        ResourceQuestion $resource,
        QuestionFactory $questionFactory
    ) {
        $this->_resource = $resource;
        $this->_factory = $questionFactory;
    }

    /**
     * @param QuestionInterface $question
     *
     * @return void
     * @throws CouldNotDeleteException
     * @throws NoSuchEntityException
     */
    public function delete(QuestionInterface $question)
    {
        /** @var QuestionInterface|\Magento\Framework\Model\AbstractModel $question */
        $id = $question->getId();
        if(!$id){
            throw new NoSuchEntityException();
        }

        try {
            unset($this->_instances[$id]);
            $this->_resource->delete($question);
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
     * @return QuestionInterface
     * @throws NoSuchEntityException
     */
    public function getById(int $id): QuestionInterface
    {
        if(!$id){
            throw new NoSuchEntityException();
        }

        if (!isset($this->_instances[$id])) {
            /** @var QuestionInterface|\Magento\Framework\Model\AbstractModel $question */
            $question = $this->_factory->create();
            $this->_resource->load($question, $id);
            if (!$question->getId()) {
                throw new NoSuchEntityException();
            }
            $this->_instances[$id] = $question;
        }
        return $this->_instances[$id];
    }

    /**
     * @param QuestionInterface $question
     *
     * @return QuestionInterface
     * @throws CouldNotSaveException
     */
    public function save(QuestionInterface $question): QuestionInterface
    {
        /** @var QuestionInterface|\Magento\Framework\Model\AbstractModel $question */
        try {
            $this->_resource->save($question);
        } catch (Exception $exception) {
            throw new CouldNotSaveException(__(
                'Could not save the record: %1',
                $exception->getMessage()
            ));
        }
        return $question;
    }

    /**
     * @param array $data
     *
     * @return QuestionInterface
     */
    public function create(array $data = []): QuestionInterface
    {
        return $this->_factory->create(['data' => $data]);
    }
}