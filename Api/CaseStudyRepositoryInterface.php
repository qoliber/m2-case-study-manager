<?php
/**
 * Created by Qoliber
 *
 * @category    Qoliber
 * @package     Qoliber_CaseStudyManager
 * @author      Jakub Winkler <jwinkler@qoliber.com>
 */

declare(strict_types=1);

namespace Qoliber\CaseStudyManager\Api;

use Qoliber\CaseStudyManager\Api\Data\CaseStudyInterface;

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
