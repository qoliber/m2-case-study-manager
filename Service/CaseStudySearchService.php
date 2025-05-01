<?php
/**
 * Created by Qoliber
 *
 * @category    Qoliber
 * @package     Qoliber_CaseStudyManager
 * @author      Jakub Winkler <jwinkler@qoliber.com>
 */

declare(strict_types=1);

namespace Qoliber\CaseStudyManager\Service;

use Magento\AdvancedSearch\Model\Client\ClientResolver;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Qoliber\CaseStudyManager\Api\CaseStudySearchServiceInterface;
use Qoliber\CaseStudyManager\Api\Data\OpenSearchQueryInterface;

class CaseStudySearchService implements CaseStudySearchServiceInterface
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
     * Search Case Studies in NoSQL database
     *
     * @param \Qoliber\CaseStudyManager\Api\Data\OpenSearchQueryInterface $filters
     * @return array|mixed[]
     */
    public function search(OpenSearchQueryInterface $filters): array
    {
        $client = $this->clientResolver->create();

        // @phpstan-ignore-next-line
        if ($client->indexExists($this->getIndexName())) {
            $must[] = ['match' => ['is_active' => 1]];

            $fields = [
                'country_id' => $filters->getCountryId(),
                'magento_version' => $filters->getMagentoVersion(),
                'frontend_type' => $filters->getFrontendType(),
                'vertical_types' => $filters->getVerticalTypes(),
                'customer_focus' => $filters->getCustomerFocus(),
                'regional_focus' => $filters->getRegionalFocus(),
            ];

            $nestedFilters = [
                'integrations' => [
                    'values' => $filters->getIntegrations(),
                    'field' => 'integrations.name',
                ],
                'extension_vendors' => [
                    'values' => $filters->getExtensionVendors(),
                    'field' => 'extension_vendors.vendor',
                ],
            ];

            foreach ($fields as $field => $value) {
                if (!empty($value)) {
                    $must[] = ['match' => [$field => $value]];
                }
            }

            foreach ($nestedFilters as $path => $config) {
                foreach ((array) $config['values'] as $value) {
                    if (!empty($value)) {
                        $must[] = [
                            'nested' => [
                                'path' => $path,
                                'query' => [
                                    'bool' => [
                                        'must' => [
                                            ['term' => [$config['field'] => $value]]
                                        ]
                                    ]
                                ]
                            ]
                        ];
                    }
                }
            }

            $searchParams = [
                'index' => $this->getIndexName(),
                'body' => [
                    'query' => [
                        'bool' => [
                            'must' => $must
                        ]
                    ]
                ]
            ];

            // @phpstan-ignore-next-line
            $response = $client->query($searchParams);

            return array_map(fn ($hit) => $hit['_source'], $response['hits']['hits']);
        }

        return [];
    }

    /**
     * Get Index Name
     *
     * @return mixed
     */
    public function getIndexName(): mixed
    {
        return $this->scopeConfig->getValue('qoliber_casestudy/opensearch/entity_index');
    }
}
