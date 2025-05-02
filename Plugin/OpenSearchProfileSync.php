<?php
/**
 * Created by Qoliber
 *
 * @category    Qoliber
 * @package     Qoliber_CaseStudyManager
 * @author      Jakub Winkler <jwinkler@qoliber.com>
 */

declare(strict_types=1);

namespace Qoliber\CaseStudyManager\Plugin;

use Magento\AdvancedSearch\Model\Client\ClientResolver;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Qoliber\CaseStudyManager\Api\CaseStudyRepositoryInterface;
use Qoliber\CaseStudyManager\Api\Data\CaseStudyInterface;

class OpenSearchProfileSync
{
    /**
     * @param \Magento\AdvancedSearch\Model\Client\ClientResolver $clientResolver
     * @param \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
     */
    public function __construct(
        private readonly ClientResolver $clientResolver,
        private readonly ScopeConfigInterface $scopeConfig,
    ) {
    }

    /**
     * After Plugin for CaseStudyRepositoryInterface::save
     *
     * @param \Qoliber\CaseStudyManager\Api\CaseStudyRepositoryInterface $subject
     * @param \Qoliber\CaseStudyManager\Api\Data\CaseStudyInterface $caseStudy
     * @return \Qoliber\CaseStudyManager\Api\Data\CaseStudyInterface
     * @throws \Exception
     */
    public function afterSave(
        CaseStudyRepositoryInterface $subject,
        CaseStudyInterface $caseStudy
    ): CaseStudyInterface {
        if ($caseStudy->getCustomerId() && $caseStudy->getEntityId()) {
            /** @var \Magento\OpenSearch\Model\OpenSearch $client */
            $client = $this->clientResolver->create();
            $vendors = [];
            $integrations = [];

            foreach (explode(',', $caseStudy->getExtensionVendors() ?? '') as $vendor) {
                $vendors[] = [
                    'vendor' => $vendor
                ];
            }

            foreach (explode(',', $caseStudy->getIntegrations() ?? '') as $integration) {
                $integrations[] = [
                    'name' => $integration
                ];
            }

            $data = [
                'title' => $caseStudy->getTitle(),
                'url_key' => $caseStudy->getUrlKey(),
                'uuid' => $caseStudy->getUuid(),
                'position' => $caseStudy->getPosition(),
                'content' => $caseStudy->getContent(),
                'screenshots_list' => $caseStudy->getScreenshotsList(),
                'summary' => $caseStudy->getSummary(),
                'is_active' => (int) $caseStudy->getIsActive(),
                'image' => $caseStudy->getImage(),
                'magento_version' => $caseStudy->getMagentoVersion(),
                'frontend_type' => $caseStudy->getFrontendType(),
                'vertical_types' => $caseStudy->getVerticalTypes(),
                'customer_focus' => $caseStudy->getCustomerFocus(),
                'regional_focus' => $caseStudy->getRegionalFocus(),
                'hosting_stack' => $caseStudy->getHostingStack(),
                'country_id' => $caseStudy->getCountryId(),
                'extension_vendors' => $vendors,
                'integrations' => $integrations,
                // @phpstan-ignore-next-line
                'updated_at' => $caseStudy->getUpdatedAt()
                    ? (new \DateTime($caseStudy->getUpdatedAt()))->format('Y-m-d\TH:i:sP')
                    : (new \DateTime())->format('Y-m-d\TH:i:sP'),
            ];

            $client->getOpenSearchClient()->index([
                'index' => $this->scopeConfig->getValue('qoliber_casestudy/opensearch/entity_index'),
                'id' => (string)$caseStudy->getEntityId(),
                'body' => $data
            ]);
        }

        return $caseStudy;
    }
}
