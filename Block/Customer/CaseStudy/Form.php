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
use Magento\Framework\View\Element\Template\Context;
use Magento\Customer\Model\Session;
use Magento\Directory\Model\Config\Source\Country;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\UrlInterface;
use Magento\Store\Model\StoreManagerInterface;
use Qoliber\CaseStudyManager\Api\CaseStudyRepositoryInterface;
use Qoliber\CaseStudyManager\Api\Data\CaseStudyInterface;
use Qoliber\CaseStudyManager\Model\ResourceModel\CaseStudy\CollectionFactory;
use Qoliber\CaseStudyManager\Model\CaseStudyFactory;
use Qoliber\CaseStudyManager\Model\Config;
use Magento\Framework\Exception\NoSuchEntityException;

class Form extends Template
{
    /**
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param \Magento\Framework\App\RequestInterface $request
     * @param \Qoliber\CaseStudyManager\Api\CaseStudyRepositoryInterface $caseStudyRepository
     * @param \Qoliber\CaseStudyManager\Model\CaseStudyFactory $caseStudyFactory
     * @param \Magento\Customer\Model\Session $customerSession
     * @param \Magento\Directory\Model\Config\Source\Country $countrySource
     * @param \Qoliber\CaseStudyManager\Model\ResourceModel\CaseStudy\CollectionFactory $collectionFactory
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param \Qoliber\CaseStudyManager\Model\Config $config
     * @param array<mixed> $data
     */
    public function __construct(
        protected Context $context,
        private readonly RequestInterface $request,
        private readonly CaseStudyRepositoryInterface $caseStudyRepository,
        private readonly CaseStudyFactory $caseStudyFactory,
        private readonly Session $customerSession,
        private readonly Country $countrySource,
        private readonly CollectionFactory $collectionFactory,
        private readonly StoreManagerInterface $storeManager,
        private readonly Config $config,
        array $data = []
    ) {
        parent::__construct($context, $data);
    }

    /**
     * Get a case study model
     *
     * @return \Qoliber\CaseStudyManager\Api\Data\CaseStudyInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getCaseStudy(): CaseStudyInterface
    {
        try {
            $id = (int) $this->request->getParam('id');

            if ($id) {
                $caseStudy = $this->caseStudyRepository->getById($id);

                if ($caseStudy->getExtensionVendors()) {
                    $caseStudy->setData( // @phpstan-ignore-line
                        'extension_vendors_array',
                        explode(',', $caseStudy->getExtensionVendors())
                    );
                }

                if ($caseStudy->getIntegrations()) {
                    $caseStudy->setData( // @phpstan-ignore-line
                        'integrations_array',
                        explode(',', $caseStudy->getIntegrations())
                    );
                }

                return $caseStudy;
            }
        } catch (NoSuchEntityException $e) {
            throw new NoSuchEntityException(__('Case study not found'));
        }

        return $this->caseStudyFactory->create()->getDataModel();
    }

    /**
     * Get a case studies collection
     *
     * @return \Qoliber\CaseStudyManager\Model\ResourceModel\CaseStudy\Collection
     */
    public function getCaseStudies(): \Qoliber\CaseStudyManager\Model\ResourceModel\CaseStudy\Collection
    {
        $collection = $this->collectionFactory->create();
        $collection->addFieldToFilter('customer_id', (string) $this->getCustomerId());
        $collection->setOrder('position', 'ASC');

        return $collection;
    }

    /**
     * Get form action URL
     */
    public function getFormAction(): string
    {
        return $this->getUrl('*/customer/editPost');
    }

    /**
     * Get customer ID from session
     */
    public function getCustomerId(): int
    {
        return (int) $this->customerSession->getCustomerId();
    }

    /**
     * Get country options
     *
     * @return array<mixed>
     */
    public function getCountryOptions(): array
    {
        return $this->countrySource->toOptionArray();
    }

    /**
     * Get Magento versions from config
     *
     * @return string[]
     */
    public function getMagentoVersions(): array
    {
        return array_column($this->config->getMagentoVersions(), 'type');
    }

    /**
     * Get frontend types from config
     *
     * @return string[]
     */
    public function getFrontendTypes(): array
    {
        return array_column($this->config->getFrontendTypes(), 'type');
    }

    /**
     * Get extension vendors from config
     *
     * @return string[]
     */
    public function getExtensionVendors(): array
    {
        return array_column($this->config->getExtensionVendors(), 'type');
    }

    /**
     * Get integrations from config
     *
     * @return string[]
     */
    public function getIntegrations(): array
    {
        return array_column($this->config->getIntegrations(), 'type');
    }

    /**
     * Get hosting stacks from config
     *
     * @return string[]
     */
    public function getHostingStacks(): array
    {
        return array_column($this->config->getHostingStack(), 'type');
    }

    /**
     * Get vertical types from config
     *
     * @return string[]
     */
    public function getVerticalTypes(): array
    {
        return array_column($this->config->getVerticalTypes(), 'type');
    }

    /**
     * Get edit URL
     *
     * @param int $id
     * @return string
     */
    public function getEditUrl(int $id): string
    {
        return $this->getUrl('casestudy/customer/edit', ['id' => $id]);
    }

    /**
     * Get new URL
     *
     * @return string
     */
    public function getNewUrl(): string
    {
        return $this->getUrl('casestudy/customer/edit');
    }

    /**
     * Get back URL
     */
    public function getBackUrl(): string
    {
        return $this->getUrl('*/manage/');
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
        $mediaBaseUrl = $this->storeManager->getStore()->getBaseUrl(UrlInterface::URL_TYPE_MEDIA);

        if ($image) {
            return sprintf(
                '%s/%s/%s',
                $mediaBaseUrl,
                'case_study',
                $image
            );
        }

        return null;
    }
}
