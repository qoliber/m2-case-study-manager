<?php
/**
 * Created by Qoliber
 *
 * @category    Qoliber
 * @package     Qoliber_CaseStudyManager
 * @author      Jakub Winkler <jwinkler@qoliber.com>
 */

declare(strict_types=1);

namespace Qoliber\CaseStudyManager\Provider;

use Magento\Directory\Api\CountryInformationAcquirerInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Serialize\SerializerInterface;
use Qoliber\CaseStudyManager\Api\ConfigProviderInterface;

class ConfigProvider implements ConfigProviderInterface
{
    /** @var string */
    private const XML_PATH_MAGENTO_VERSIONS = 'qoliber_casestudy/settings/magento_versions';

    /** @var string */
    private const XML_PATH_FRONTEND_TYPES = 'qoliber_casestudy/settings/frontend_types';

    /** @var string */
    private const XML_PATH_VERTICAL_TYPES = 'qoliber_casestudy/settings/vertical_types';

    /** @var string */
    private const XML_PATH_REGIONAL_FOCUS = 'qoliber_casestudy/settings/regional_focus';

    /** @var string */
    private const XML_PATH_INTEGRATIONS = 'qoliber_casestudy/settings/integrations';

    /** @var string */
    private const XML_PATH_HOSTING_STACK = 'qoliber_casestudy/settings/hosting_stack';

    /**
     * @param \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
     * @param \Magento\Directory\Api\CountryInformationAcquirerInterface $countryInformationAcquirer
     * @param \Magento\Framework\Serialize\SerializerInterface $serializer
     */
    public function __construct(
        protected readonly ScopeConfigInterface $scopeConfig,
        protected readonly CountryInformationAcquirerInterface $countryInformationAcquirer,
        protected readonly SerializerInterface $serializer
    ) {
    }

    /**
     * Get configuration data for Case Study Manager
     *
     * @return mixed[]
     */
    public function getConfig(): array
    {
        return [
            [
                'magento_versions' => $this->extractTypeColumn(self::XML_PATH_MAGENTO_VERSIONS),
                'frontend_types' => $this->extractTypeColumn(self::XML_PATH_FRONTEND_TYPES),
                'vertical_types' => $this->extractTypeColumn(self::XML_PATH_VERTICAL_TYPES),
                'regional_focus' => $this->extractTypeColumn(self::XML_PATH_REGIONAL_FOCUS),
                'integrations' => $this->extractTypeColumn(self::XML_PATH_INTEGRATIONS),
                'hosting_stack' => $this->extractTypeColumn(self::XML_PATH_HOSTING_STACK),
                'country_ids' => $this->getAvailableCountries()
            ]
        ];
    }

    /**
     * Extract type column from configuration value
     *
     * @param string $path Configuration path
     * @return array<int, string>
     */
    private function extractTypeColumn(string $path): array
    {
        $value = $this->scopeConfig->getValue($path);
        if (!$value) {
            return [];
        }

        $decodedValue = $this->serializer->unserialize($value);
        if (!is_array($decodedValue)) {
            return [];
        }

        return array_values(array_column($decodedValue, 'type'));
    }

    /**
     * Get list of available countries
     *
     * @return array<int, array<string, string>>
     */
    private function getAvailableCountries(): array
    {
        $countries = [];
        foreach ($this->countryInformationAcquirer->getCountriesInfo() as $country) {
            $countries[] = [
                'id' => $country->getId(),
                'name' => $country->getFullNameLocale()
            ];
        }
        return $countries;
    }
}
