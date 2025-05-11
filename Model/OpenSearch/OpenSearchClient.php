<?php
/**
 * Created by Qoliber
 *
 * @category    Qoliber
 * @package     Qoliber_CaseStudyManager
 * @author      Jakub Winkler <jwinkler@qoliber.com>
 */

declare(strict_types=1);

namespace Qoliber\CaseStudyManager\Model\OpenSearch;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Encryption\EncryptorInterface;
use Magento\Framework\Exception\LocalizedException;
use OpenSearch\Client;
use OpenSearch\ClientBuilder;

class OpenSearchClient
{
    /** @var string */
    private const CONFIG_PATH_HOSTNAME = 'qoliber_casestudy/opensearch/hostname';

    /** @var string */
    private const CONFIG_PATH_PORT = 'qoliber_casestudy/opensearch/port';

    /** @var string */
    private const CONFIG_PATH_INDEX_NAME = 'qoliber_casestudy/opensearch/index_name';

    /** @var string */
    private const CONFIG_PATH_ENABLE_AUTH = 'qoliber_casestudy/opensearch/enable_auth';

    /** @var string */
    private const CONFIG_PATH_USERNAME = 'qoliber_casestudy/opensearch/username';

    /** @var string  */
    private const CONFIG_PATH_PASSWORD = 'qoliber_casestudy/opensearch/password';

    /** @var string */
    private const CONFIG_PATH_USE_HTTPS = 'qoliber_casestudy/opensearch/use_https';

    /** @var \OpenSearch\Client|null  */
    private ?Client $client = null;

    /**
     * @param \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
     * @param \Magento\Framework\Encryption\EncryptorInterface $encryptor
     */
    public function __construct(
        private readonly ScopeConfigInterface $scopeConfig,
        private readonly EncryptorInterface $encryptor
    ) {
    }

    /**
     * Get OpenSearch client
     *
     * @return \OpenSearch\Client
     * @throws \OpenSearch\Common\Exceptions\RuntimeException
     */
    public function getClient(): Client
    {
        if ($this->client === null) {
            $protocol = $this->scopeConfig->isSetFlag(self::CONFIG_PATH_USE_HTTPS) ? 'https' : 'http';

            $hosts = [
                sprintf(
                    '%s://%s:%s',
                    $protocol,
                    $this->scopeConfig->getValue(self::CONFIG_PATH_HOSTNAME),
                    $this->scopeConfig->getValue(self::CONFIG_PATH_PORT)
                )
            ];

            $clientBuilder = ClientBuilder::create()->setHosts($hosts);

            if ($this->scopeConfig->isSetFlag(self::CONFIG_PATH_ENABLE_AUTH)) {
                $clientBuilder->setBasicAuthentication(
                    $this->scopeConfig->getValue(self::CONFIG_PATH_USERNAME),
                    $this->encryptor->decrypt($this->scopeConfig->getValue(self::CONFIG_PATH_PASSWORD))
                );
            }

            $this->client = $clientBuilder->build();
        }

        return $this->client;
    }

    /**
     * Get index name
     *
     * @return string
     */
    public function getIndexName(): string
    {
        return $this->scopeConfig->getValue(self::CONFIG_PATH_INDEX_NAME) ?? 'casestudy';
    }

    /**
     * Check OpenSearch connection and create index if it doesn't exist
     *
     * @throws \Exception
     */
    public function checkConnection(): void
    {
        $client = $this->getClient();
        $indexName = $this->getIndexName();

        if (!$client->indices()->exists(['index' => $indexName])) {
            try {
                $client->indices()->create([
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
                                'screenshots_list' => ['type' => 'text','index' => false],
                                'updated_at' => [
                                    'type' => 'date',
                                    'format' => 'strict_date_optional_time||epoch_millis'
                                ]
                            ]
                        ],
                        'settings' => [
                            'number_of_shards' => 1,
                            'number_of_replicas' => 1
                        ]
                    ]
                ]);
            } catch (\Exception $e) {
                throw new LocalizedException(
                    __('Failed to create index "%1": %2', $indexName, $e->getMessage())
                );
            }
        }
    }
}
