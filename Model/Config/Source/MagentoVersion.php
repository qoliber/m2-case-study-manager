<?php
/**
 * Created by Qoliber
 *
 * @category    Qoliber
 * @package     Qoliber_CaseStudyManager
 * @author      Jakub Winkler <jwinkler@qoliber.com>
 */

declare(strict_types=1);

namespace Qoliber\CaseStudyManager\Model\Config\Source;

use Magento\Framework\Data\OptionSourceInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Serialize\Serializer\Json;

class MagentoVersion implements OptionSourceInterface
{
    /**
     * @param \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
     * @param \Magento\Framework\Serialize\Serializer\Json $json
     */
    public function __construct(
        private readonly ScopeConfigInterface $scopeConfig,
        private readonly Json $json
    ) {
    }

    /**
     * Get an option array
     *
     * @return array<mixed>
     */
    public function toOptionArray(): array
    {
        $options = [];
        $versions = $this->scopeConfig->getValue('qoliber_casestudy/settings/magento_versions');

        if ($versions) {
            $versions = $this->json->unserialize($versions);

            if (is_array($versions)) {
                foreach ($versions as $version) {
                    $options[] = [
                        'value' => $version['type'],
                        'label' => $version['type']
                    ];
                }
            }
        }

        return $options;
    }
}
