<?php
/**
 * Created by Qoliber
 *
 * @category    Qoliber
 * @package     Qoliber_CaseStudyManager
 * @author      Jakub Winkler <jwinkler@qoliber.com>
 */

declare(strict_types=1);

namespace Qoliber\CaseStudyManager\Model\Data;

use Qoliber\CaseStudyManager\Api\Data\OpenSearchQueryInterface;

class OpenSearchQuery implements OpenSearchQueryInterface
{
    /**
     * @param string|null $magentoVersion Magento version for filtering
     * @param string|null $frontendType Frontend type (e.g., luma, blank)
     * @param string|null $verticalTypes Vertical types for filtering
     * @param string|null $customerFocus Customer focus type
     * @param string|null $regionalFocus Regional focus type
     * @param string|null $hostingStack Hosting stack type
     * @param string|null $countryId Country identifier
     * @param string[] $extensionVendors Extension vendors list
     * @param string[] $integrations Integrations list
     * @param string|null $updatedAt Last update timestamp
     */
    public function __construct(
        private ?string $magentoVersion = null,
        private ?string $frontendType = null,
        private ?string $verticalTypes = null,
        private ?string $customerFocus = null,
        private ?string $regionalFocus = null,
        private ?string $hostingStack = null,
        private ?string $countryId = null,
        private array $extensionVendors = [],
        private array $integrations = [],
        private ?string $updatedAt = null
    ) {
    }

    /**
     * Get Magento version
     *
     * @return string|null
     */
    public function getMagentoVersion(): ?string
    {
        return $this->magentoVersion;
    }

    /**
     * Set Magento version
     *
     * @param string $magentoVersion
     * @return self
     */
    public function setMagentoVersion(string $magentoVersion): OpenSearchQueryInterface
    {
        $this->magentoVersion = $magentoVersion;

        return $this;
    }

    /**
     * Get frontend type
     *
     * @return string|null
     */
    public function getFrontendType(): ?string
    {
        return $this->frontendType;
    }

    /**
     * Set frontend type
     *
     * @param string $frontendType
     * @return self
     */
    public function setFrontendType(string $frontendType): OpenSearchQueryInterface
    {
        $this->frontendType = $frontendType;

        return $this;
    }

    /**
     * Get vertical types
     *
     * @return string|null
     */
    public function getVerticalTypes(): ?string
    {
        return $this->verticalTypes;
    }

    /**
     * Set vertical types
     *
     * @param string $verticalTypes
     * @return self
     */
    public function setVerticalTypes(string $verticalTypes): OpenSearchQueryInterface
    {
        $this->verticalTypes = $verticalTypes;

        return $this;
    }

    /**
     * Get customer focus
     *
     * @return string|null
     */
    public function getCustomerFocus(): ?string
    {
        return $this->customerFocus;
    }

    /**
     * Set customer focus
     *
     * @param string $customerFocus
     * @return self
     */
    public function setCustomerFocus(string $customerFocus): OpenSearchQueryInterface
    {
        $this->customerFocus = $customerFocus;

        return $this;
    }

    /**
     * Get regional focus
     *
     * @return string|null
     */
    public function getRegionalFocus(): ?string
    {
        return $this->regionalFocus;
    }

    /**
     * Set regional focus
     *
     * @param string $regionalFocus
     * @return self
     */
    public function setRegionalFocus(string $regionalFocus): OpenSearchQueryInterface
    {
        $this->regionalFocus = $regionalFocus;

        return $this;
    }

    /**
     * Get hosting stack
     *
     * @return string|null
     */
    public function getHostingStack(): ?string
    {
        return $this->hostingStack;
    }

    /**
     * Set hosting stack
     *
     * @param string $hostingStack
     * @return self
     */
    public function setHostingStack(string $hostingStack): OpenSearchQueryInterface
    {
        $this->hostingStack = $hostingStack;

        return $this;
    }

    /**
     * Get country ID
     *
     * @return string|null
     */
    public function getCountryId(): ?string
    {
        return $this->countryId;
    }

    /**
     * Set country ID
     *
     * @param string $countryId
     * @return self
     */
    public function setCountryId(string $countryId): OpenSearchQueryInterface
    {
        $this->countryId = $countryId;

        return $this;
    }

    /**
     * Get extension vendors
     *
     * @return string[]
     */
    public function getExtensionVendors(): array
    {
        return $this->extensionVendors;
    }

    /**
     * Set extension vendors
     *
     * @param string[] $extensionVendors
     * @return self
     */
    public function setExtensionVendors(array $extensionVendors): OpenSearchQueryInterface
    {
        $this->extensionVendors = $extensionVendors;

        return $this;
    }

    /**
     * Get integrations
     *
     * @return string[]
     */
    public function getIntegrations(): array
    {
        return $this->integrations;
    }

    /**
     * Set integrations
     *
     * @param string[] $integrations
     * @return self
     */
    public function setIntegrations(array $integrations): OpenSearchQueryInterface
    {
        $this->integrations = $integrations;

        return $this;
    }

    /**
     * Get updated at timestamp
     *
     * @return string|null
     */
    public function getUpdatedAt(): ?string
    {
        return $this->updatedAt;
    }

    /**
     * Set updated at timestamp
     *
     * @param string $updatedAt
     * @return self
     */
    public function setUpdatedAt(string $updatedAt): OpenSearchQueryInterface
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }
}
