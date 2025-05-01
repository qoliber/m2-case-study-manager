<?php
declare(strict_types=1);

namespace Qoliber\CaseStudyManager\Model;

use Magento\Framework\Api\ExtensibleDataObjectConverter;
use Magento\Framework\Api\ExtensionAttribute\JoinProcessorInterface;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Qoliber\CaseStudyManager\Api\CaseStudyRepositoryInterface;
use Qoliber\CaseStudyManager\Api\Data\CaseStudyInterface;
use Qoliber\CaseStudyManager\Api\Data\CaseStudySearchResultsInterface;
use Qoliber\CaseStudyManager\Api\Data\CaseStudySearchResultsInterfaceFactory;
use Qoliber\CaseStudyManager\Model\ResourceModel\CaseStudy as ResourceModel;
use Qoliber\CaseStudyManager\Model\ResourceModel\CaseStudy\CollectionFactory;

class CaseStudyRepository implements CaseStudyRepositoryInterface
{
    /**
     * @param \Qoliber\CaseStudyManager\Model\ResourceModel\CaseStudy $resource
     * @param \Qoliber\CaseStudyManager\Model\CaseStudyFactory $caseStudyFactory
     * @param \Magento\Framework\Api\ExtensibleDataObjectConverter $extensibleDataObjectConverter
     */
    public function __construct(
        private readonly ResourceModel $resource,
        private readonly CaseStudyFactory $caseStudyFactory,
        private readonly ExtensibleDataObjectConverter $extensibleDataObjectConverter
    ) {
    }

    /**
     * Save a case study
     *
     * @param \Qoliber\CaseStudyManager\Api\Data\CaseStudyInterface $caseStudy
     * @return \Qoliber\CaseStudyManager\Api\Data\CaseStudyInterface
     * @throws \Magento\Framework\Exception\CouldNotSaveException
     */
    public function save(CaseStudyInterface $caseStudy): CaseStudyInterface
    {
        $caseStudyData = $this->extensibleDataObjectConverter->toNestedArray(
            $caseStudy,
            [],
            CaseStudyInterface::class
        );

        $caseStudyModel = $this->caseStudyFactory->create()->setData($caseStudyData);

        try {
            $this->resource->save($caseStudyModel);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__('Could not save the case study: %1', $exception->getMessage()));
        }

        return $caseStudyModel->getDataModel();
    }

    /**
     * Get case study by ID
     *
     * @param int $entityId
     * @return \Qoliber\CaseStudyManager\Api\Data\CaseStudyInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getById(int $entityId): CaseStudyInterface
    {
        $caseStudy = $this->caseStudyFactory->create();
        $this->resource->load($caseStudy, $entityId);

        if (!$caseStudy->getEntityId()) {
            throw new NoSuchEntityException(__('The case study with the "%1" ID doesn\'t exist.', $entityId));
        }

        return $caseStudy->getDataModel();
    }

    /**
     * Get case study by URL key
     *
     * @param string $urlKey
     * @return \Qoliber\CaseStudyManager\Api\Data\CaseStudyInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getByUrlKey(string $urlKey): CaseStudyInterface
    {
        $caseStudy = $this->caseStudyFactory->create();
        $this->resource->load($caseStudy, $urlKey, 'url_key');

        if (!$caseStudy->getEntityId()) {
            throw new NoSuchEntityException(__('The case study with the "%1" URL key doesn\'t exist.', $urlKey));
        }

        return $caseStudy->getDataModel();
    }

    /**
     * Delete case study
     *
     * @param \Qoliber\CaseStudyManager\Api\Data\CaseStudyInterface $caseStudy
     * @return bool
     * @throws \Magento\Framework\Exception\CouldNotDeleteException
     */
    public function delete(CaseStudyInterface $caseStudy): bool
    {
        try {
            $caseStudyModel = $this->caseStudyFactory->create();
            $this->resource->load($caseStudyModel, $caseStudy->getEntityId());
            $this->resource->delete($caseStudyModel);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__('Could not delete the case study: %1', $exception->getMessage()));
        }

        return true;
    }
}
