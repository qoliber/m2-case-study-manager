<?php
/**
 * Created by Qoliber
 *
 * @category    Qoliber
 * @package     Qoliber_CaseStudyManager
 * @author      Jakub Winkler <jwinkler@qoliber.com>
 */

declare(strict_types=1);

namespace Qoliber\CaseStudyManager\Block\Customer\CaseStudy;

use Magento\Framework\View\Element\Template;
use Qoliber\CaseStudyManager\Model\ResourceModel\CaseStudy\Collection;
use Qoliber\CaseStudyManager\Model\ResourceModel\CaseStudy\CollectionFactory;
use Magento\Customer\Model\Session;
use Magento\Framework\View\Element\Template\Context;
use Magento\Framework\UrlInterface;

class ListCaseStudy extends Template
{
    /**
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param \Qoliber\CaseStudyManager\Model\ResourceModel\CaseStudy\CollectionFactory $collectionFactory
     * @param \Magento\Customer\Model\Session $customerSession
     * @param mixed[] $data
     */
    public function __construct(
        protected Context $context,
        private readonly CollectionFactory $collectionFactory,
        private readonly Session $customerSession,
        array $data = []
    ) {
        parent::__construct($context, $data);
    }

    /**
     * Get Case Studies
     *
     * @return \Qoliber\CaseStudyManager\Model\ResourceModel\CaseStudy\Collection
     */
    public function getCaseStudies(): Collection
    {
        $collection = $this->collectionFactory->create();
        $collection->addFieldToFilter('customer_id', (string) $this->customerSession->getCustomerId());
        $collection->setOrder('position', 'ASC');

        return $collection;
    }

    /**
     * Get New Url
     *
     * @return string
     */
    public function getNewUrl(): string
    {
        return $this->getUrl('casestudy/customer/edit');
    }

    /**
     * Get Edit Url
     *
     * @param int $id
     * @return string
     */
    public function getEditUrl(int $id): string
    {
        return $this->getUrl('casestudy/customer/edit', ['id' => $id]);
    }

    /**
     * Get image URL
     *
     * @param string|null $image
     * @return string|null
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getImageUrl(?string $image): ?string
    {
        if ($image) {
            return sprintf(
                '%s/%s/%s',
                $this->_storeManager->getStore()->getBaseUrl(UrlInterface::URL_TYPE_MEDIA),
                'case_study',
                $image
            );
        }

        return null;
    }
}
