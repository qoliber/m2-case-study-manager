<?php
/**
 * Created by Qoliber
 *
 * @category    Qoliber
 * @package     Qoliber_CaseStudyManager
 * @author      Jakub Winkler <jwinkler@qoliber.com>
 */

declare(strict_types=1);

namespace Qoliber\CaseStudyManager\Model;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Serialize\SerializerInterface;

class Config
{
    /** @var string */
    private const XML_PATH_VERTICAL_TYPES = 'qoliber_casestudy/settings/vertical_types';

    /** @var string */
    private const XML_PATH_MAGENTO_VERSIONS = 'qoliber_casestudy/settings/magento_versions';

    /** @var string */
    private const XML_PATH_FRONTEND_TYPES = 'qoliber_casestudy/settings/frontend_types';

    /** @var string */
    private const XML_PATH_CUSTOMER_FOCUS = 'qoliber_casestudy/settings/customer_focus';

    /** @var string */
    private const XML_PATH_REGIONAL_FOCUS = 'qoliber_casestudy/settings/regional_focus';

    /** @var string */
    private const XML_PATH_EXTENSION_VENDORS = 'qoliber_casestudy/settings/extension_vendors';

    /** @var string */
    private const XML_PATH_INTEGRATIONS = 'qoliber_casestudy/settings/integrations';

    /** @var string */
    private const XML_PATH_HOSTING_STACK = 'qoliber_casestudy/settings/hosting_stack';

    /** @var \Magento\Framework\App\Config\ScopeConfigInterface */
    protected ScopeConfigInterface $scopeConfig;

    /** @var \Magento\Framework\Serialize\SerializerInterface */
    private SerializerInterface $serializer;

    /**
     * @param \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
     * @param SerializerInterface $serializer
     */
    public function __construct(
        ScopeConfigInterface $scopeConfig,
        SerializerInterface $serializer
    ) {
        $this->scopeConfig = $scopeConfig;
        $this->serializer = $serializer;
    }

    /**
     * Check if module is enabled
     *
     * @return bool
     */
    public function isEnabled(): bool
    {
        return $this->scopeConfig->isSetFlag('qoliber_casestudy_manager/settings/enabled');
    }

    /**
     * Get case study section title
     *
     * @return string|null
     */
    public function getCaseStudyManagerTitle(): ?string
    {
        return $this->scopeConfig->getValue('qoliber_casestudy_manager/settings/title');
    }

    /**
     * Get case study section description
     *
     * @return string|null
     */
    public function getCaseStudyManagerDescription(): ?string
    {
        return $this->scopeConfig->getValue('qoliber_casestudy_manager/settings/description');
    }

    /**
     * Get vertical types from config
     *
     * @return array<mixed>
     */
    public function getVerticalTypes(): array
    {
        return $this->getConfigValue(self::XML_PATH_VERTICAL_TYPES);
    }

    /**
     * Get customer focus from config
     *
     * @return array<mixed>
     */
    public function getCustomerFocus(): array
    {
        return $this->getConfigValue(self::XML_PATH_CUSTOMER_FOCUS);
    }

    /**
     * Get regional focus from config
     *
     * @return array<mixed>
     */
    public function getRegionalFocus(): array
    {
        return $this->getConfigValue(self::XML_PATH_REGIONAL_FOCUS);
    }

    /**
     * Get extension vendors from config
     *
     * @return array<mixed>
     */
    public function getExtensionVendors(): array
    {
        return $this->getConfigValue(self::XML_PATH_EXTENSION_VENDORS);
    }

    /**
     * Get integrations from config
     *
     * @return array<mixed>
     */
    public function getIntegrations(): array
    {
        return $this->getConfigValue(self::XML_PATH_INTEGRATIONS);
    }

    /**
     * Get hosting stack from config
     *
     * @return array<mixed>
     */
    public function getHostingStack(): array
    {
        return $this->getConfigValue(self::XML_PATH_HOSTING_STACK);
    }

    /**
     * Get Magento versions from config
     *
     * @return array<mixed>
     */
    public function getMagentoVersions(): array
    {
        return $this->getConfigValue(self::XML_PATH_MAGENTO_VERSIONS);
    }

    /**
     * Get frontend types from config
     *
     * @return array<mixed>
     */
    public function getFrontendTypes(): array
    {
        return $this->getConfigValue(self::XML_PATH_FRONTEND_TYPES);
    }

    /**
     * Get config value
     *
     * @param string $path
     * @return array<mixed>
     */
    private function getConfigValue(string $path): array
    {
        $value = $this->scopeConfig->getValue($path);

        if (empty($value)) {
            return [];
        }

        try {
            $result = $this->serializer->unserialize($value);
            return is_array($result) ? $result : [];
        } catch (\InvalidArgumentException|\UnexpectedValueException $e) {
            return [];
        }
    }
}
