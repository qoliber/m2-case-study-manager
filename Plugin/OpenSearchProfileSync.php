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

use Magento\Framework\Exception\LocalizedException;
use Qoliber\CaseStudyManager\Api\CaseStudyRepositoryInterface;
use Qoliber\CaseStudyManager\Api\Data\CaseStudyInterface;
use Qoliber\CaseStudyManager\Model\OpenSearch\OpenSearchClient;

class OpenSearchProfileSync
{
    /**
     * @param \Qoliber\CaseStudyManager\Model\OpenSearch\OpenSearchClient $openSearchClient
     */
    public function __construct(
        private readonly OpenSearchClient $openSearchClient
    ) {
    }

    /**
     * After save plugin for case study repository
     *
     * @param \Qoliber\CaseStudyManager\Api\CaseStudyRepositoryInterface $subject
     * @param \Qoliber\CaseStudyManager\Api\Data\CaseStudyInterface $caseStudy
     * @return \Qoliber\CaseStudyManager\Api\Data\CaseStudyInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function afterSave(
        CaseStudyRepositoryInterface $subject,
        CaseStudyInterface $caseStudy
    ): CaseStudyInterface {
        try {
            $client = $this->openSearchClient->getClient();
            $indexName = $this->openSearchClient->getIndexName();

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

            $document = [
                'uuid' => $caseStudy->getUuid(),
                'position' => (int)$caseStudy->getPosition(),
                'is_active' => (int)$caseStudy->getIsActive(),
                'title' => $caseStudy->getTitle(),
                'url_key' => $caseStudy->getUrlKey(),
                'image' => $caseStudy->getImage(),
                'magento_version' => $caseStudy->getMagentoVersion(),
                'frontend_type' => $caseStudy->getFrontendType(),
                'vertical_types' => $caseStudy->getVerticalTypes(),
                'customer_focus' => $caseStudy->getCustomerFocus(),
                'regional_focus' => $caseStudy->getRegionalFocus(),
                'country_id' => $caseStudy->getCountryId(),
                'extension_vendors' => $vendors,
                'integrations' => $integrations,
                'hosting_stack' => $caseStudy->getHostingStack(),
                'content' => $caseStudy->getContent(),
                'summary' => $caseStudy->getSummary(),
                'screenshots_list' => $caseStudy->getScreenshotsList(),
                'updated_at' => $caseStudy->getUpdatedAt()
                    ? (new \DateTime($caseStudy->getUpdatedAt()))->format('Y-m-d\TH:i:sP')
                    : (new \DateTime())->format('Y-m-d\TH:i:sP')
            ];

            if ($caseStudy->getIsActive()) {
                $client->index([
                    'index' => $indexName,
                    'id' => $caseStudy->getUuid(),
                    'body' => $document
                ]);
            } else {
                try {
                    $client->delete([
                        'index' => $indexName,
                        'id' => $caseStudy->getUuid()
                    ]);
                } catch (\Exception $e) {
                    // Ignore if document doesn't exist
                    if (strpos($e->getMessage(), 'not_found') === false) {
                        throw $e;
                    }
                }
            }
        } catch (\Exception $e) {
            throw new LocalizedException(__('Could not save the case study: %1', $e->getMessage()));
        }

        return $caseStudy;
    }

    /**
     * After delete plugin for case study repository
     *
     * @param \Qoliber\CaseStudyManager\Api\CaseStudyRepositoryInterface $subject
     * @param \Qoliber\CaseStudyManager\Api\Data\CaseStudyInterface $caseStudy
     * @return \Qoliber\CaseStudyManager\Api\Data\CaseStudyInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function afterDelete(
        CaseStudyRepositoryInterface $subject,
        CaseStudyInterface $caseStudy
    ): CaseStudyInterface {
        try {
            $client = $this->openSearchClient->getClient();
            $indexName = $this->openSearchClient->getIndexName();

            try {
                $client->delete([
                    'index' => $indexName,
                    'id' => $caseStudy->getUuid()
                ]);
            } catch (\Exception $e) {
                // Ignore if document doesn't exist
                if (strpos($e->getMessage(), 'not_found') === false) {
                    throw $e;
                }
            }
        } catch (\Exception $e) {
            throw new LocalizedException(__('Could not delete the case study: %1', $e->getMessage()));
        }

        return $caseStudy;
    }
}
