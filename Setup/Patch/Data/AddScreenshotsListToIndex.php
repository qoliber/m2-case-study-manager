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

class AddScreenshotsListToIndex implements DataPatchInterface
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
     * Apply a patch to add the 'screenshots_list' field to the case study entity index
     *
     * @return \Qoliber\CaseStudyManager\Setup\Patch\Data\AddScreenshotsListToIndex
     * @throws \Exception
     */
    public function apply(): AddScreenshotsListToIndex
    {
        try {
            /** @var \Magento\OpenSearch\Model\OpenSearch|null $client */
            $client = $this->clientResolver->create();

            if ($client === null) {
                return $this;
            }

            $indexName = $this->scopeConfig->getValue('qoliber_casestudy/opensearch/entity_index');

            $params = [
                'index' => $indexName,
                'body' => [
                    'properties' => [
                        'screenshots_list' => [
                            'type' => 'text',
                            'index' => false
                        ]
                    ]
                ]
            ];

            $client->getOpenSearchClient()->indices()->putMapping($params);
        } catch (\Exception $e) {
            throw new \Exception(
                __(
                    'Unable to add screenshots_list field to case study entity index: %1',
                    $e->getMessage()
                )->render(),
            );
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
        return [
            \Qoliber\CaseStudyManager\Setup\Patch\Data\CreateCaseStudyEntityIndex::class
        ];
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
