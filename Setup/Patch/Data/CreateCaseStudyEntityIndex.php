<?php
/**
 * Created by Qoliber
 *
 * @category    Qoliber
 * @package     Qoliber_CaseStudyManager
 * @author      Jakub Winkler <jwinkler@qoliber.com>
 */

declare(strict_types=1);

namespace Qoliber\CaseStudyManager\Setup\Patch\Data;

use Magento\AdvancedSearch\Model\Client\ClientResolver;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;

class CreateCaseStudyEntityIndex implements DataPatchInterface
{
    /**
     * @param \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
     * @param \Magento\AdvancedSearch\Model\Client\ClientResolver $clientResolver
     */
    public function __construct(
        private readonly ScopeConfigInterface $scopeConfig,
        private readonly ClientResolver $clientResolver,
    ) {
    }

    /**
     * Apply a patch to create a case study entity index in OpenSearch
     *
     * @return \Qoliber\CaseStudyManager\Setup\Patch\Data\CreateCaseStudyEntityIndex
     */
    public function apply(): CreateCaseStudyEntityIndex
    {
        try {
            /** @var \Magento\OpenSearch\Model\OpenSearch|null $client */
            $client = $this->clientResolver->create();

            if ($client === null) {
                return $this;
            }

            $indexName = $this->scopeConfig->getValue('qoliber_casestudy/opensearch/entity_index');
            $params = ['index' => $indexName];

            if ($client->getOpenSearchClient()->indices()->exists($params)) {
                return $this;
            }

            $client->getOpenSearchClient()->indices()->create([
                'index' => $indexName,
                'body' => [
                    'mappings' => [
                        'properties' => [
                            'uuid' => ['type' => 'text'],
                            'position' => ['type' => 'integer'],
                            'is_active' => ['type' => 'integer', 'index' => true],
                            'title' => ['type' => 'text', 'index' => false],
                            'url_key' => ['type' => 'text', 'index' => true],
                            'image' => ['type' => 'text', 'index' => false],
                            'magento_version' => [
                                'type' => 'keyword'
                            ],
                            'frontend_type' => [
                                'type' => 'keyword'
                            ],
                            'vertical_types' => [
                                'type' => 'keyword'
                            ],
                            'customer_focus' => [
                                'type' => 'keyword'
                            ],
                            'regional_focus' => [
                                'type' => 'keyword'
                            ],
                            'country_id' => [
                                'type' => 'keyword'
                            ],
                            'extension_vendors' => [
                                'type' => 'nested',
                                'properties' => [
                                    'vendor' => ['type' => 'keyword']
                                ]
                            ],
                            'integrations' => [
                                'type' => 'nested',
                                'properties' => [
                                    'name' => ['type' => 'keyword']
                                ]
                            ],
                            'hosting_stack' => [
                                'type' => 'keyword'
                            ],
                            'content' => ['type' => 'text', 'index' => false],
                            'summary' => ['type' => 'text', 'index' => false],
                            'updated_at' => [
                                'type' => 'date',
                                'format' => 'strict_date_optional_time||epoch_millis'
                            ]
                        ]
                    ]
                ]
            ]);
        } catch (\Exception $e) {
            return $this;
        }

        return $this;
    }

    /**
     * Get patch dependencies
     *
     * @return string[]
     */
    public static function getDependencies(): array
    {
        return [];
    }

    /**
     * Get patch aliases
     *
     * @return string[]
     */
    public function getAliases(): array
    {
        return [];
    }
}
