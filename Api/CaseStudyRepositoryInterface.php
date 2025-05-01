<?php
declare(strict_types=1);

namespace Qoliber\CaseStudyManager\Api;

use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Qoliber\CaseStudyManager\Api\Data\CaseStudyInterface;
use Qoliber\CaseStudyManager\Api\Data\CaseStudySearchResultsInterface;

interface CaseStudyRepositoryInterface
{
    /**
     * Save a case study
     *
     * @param \Qoliber\CaseStudyManager\Api\Data\CaseStudyInterface $caseStudy
     * @return \Qoliber\CaseStudyManager\Api\Data\CaseStudyInterface
     * @throws \Magento\Framework\Exception\CouldNotSaveException
     */
    public function save(CaseStudyInterface $caseStudy): CaseStudyInterface;

    /**
     * Get case study by ID
     *
     * @param int $entityId
     * @return \Qoliber\CaseStudyManager\Api\Data\CaseStudyInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getById(int $entityId): CaseStudyInterface;

    /**
     * Get case study by URL key
     *
     * @param string $urlKey
     * @return \Qoliber\CaseStudyManager\Api\Data\CaseStudyInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getByUrlKey(string $urlKey): CaseStudyInterface;

    /**
     * Delete case study
     *
     * @param \Qoliber\CaseStudyManager\Api\Data\CaseStudyInterface $caseStudy
     * @return bool
     * @throws \Magento\Framework\Exception\CouldNotDeleteException
     */
    public function delete(CaseStudyInterface $caseStudy): bool;
}
