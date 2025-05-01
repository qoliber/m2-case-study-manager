<?php
/**
 * Created by Qoliber
 *
 * @category    Qoliber
 * @package     Qoliber_CaseStudyManager
 * @author      Jakub Winkler <jwinkler@qoliber.com>
 */

declare(strict_types=1);

namespace Qoliber\CaseStudyManager\Model;

use Magento\Framework\Api\DataObjectHelper;
use Magento\Framework\Data\Collection\AbstractDb;
use Magento\Framework\Model\AbstractModel;
use Magento\Framework\Model\Context;
use Magento\Framework\Registry;
use Qoliber\CaseStudyManager\Api\Data\CaseStudyInterface;
use Qoliber\CaseStudyManager\Api\Data\CaseStudyInterfaceFactory;

class CaseStudy extends AbstractModel
{
    /**
     * @param \Magento\Framework\Model\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param \Magento\Framework\Api\DataObjectHelper $dataObjectHelper
     * @param \Qoliber\CaseStudyManager\Api\Data\CaseStudyInterfaceFactory $caseStudyDataFactory
     * @param \Qoliber\CaseStudyManager\Model\ResourceModel\CaseStudy $resource
     * @param \Magento\Framework\Data\Collection\AbstractDb|null $resourceCollection
     * @param mixed[] $data
     */
    public function __construct(
        Context $context,
        Registry $registry,
        private readonly DataObjectHelper $dataObjectHelper,
        private readonly CaseStudyInterfaceFactory $caseStudyDataFactory,
        ResourceModel\CaseStudy $resource,
        AbstractDb $resourceCollection = null,
        array $data = []
    ) {
        parent::__construct($context, $registry, $resource, $resourceCollection, $data);
    }

    /**
     * Get DataModel
     *
     * @return \Qoliber\CaseStudyManager\Api\Data\CaseStudyInterface
     */
    public function getDataModel(): CaseStudyInterface
    {
        $data = $this->getData();

        $dataObject = $this->caseStudyDataFactory->create();
        $this->dataObjectHelper->populateWithArray(
            $dataObject,
            $data,
            CaseStudyInterfaceFactory::class
        );

        return $dataObject;
    }
}
