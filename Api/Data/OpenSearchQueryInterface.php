<?php
/**
 * Created by Qoliber
 *
 * @category    Qoliber
 * @package     Qoliber_CaseStudyManager
 * @author      Jakub Winkler <jwinkler@qoliber.com>
 */

declare(strict_types=1);

namespace Qoliber\CaseStudyManager\Api\Data;

interface OpenSearchQueryInterface
{
    /**
     * Get Magento version
     */
    public function getMagentoVersion(): ?string;

    /**
     * Set Magento version
     *
     * @param string $magentoVersion
     */
    public function setMagentoVersion(string $magentoVersion): OpenSearchQueryInterface;

    /**
     * Get a frontend type
     */
    public function getFrontendType(): ?string;

    /**
     * Set the frontend type
     *
     * @param string $frontendType
     */
    public function setFrontendType(string $frontendType): OpenSearchQueryInterface;

    /**
     * Get vertical types
     *
     * @return null|string
     */
    public function getVerticalTypes(): ?string;

    /**
     * Set vertical types
     *
     * @param string $verticalTypes
     */
    public function setVerticalTypes(string $verticalTypes): OpenSearchQueryInterface;
    /**
     * Get customer focus
     */
    public function getCustomerFocus(): ?string;

    /**
     * Set customer focus
     *
     * @param string $customerFocus
     */
    public function setCustomerFocus(string $customerFocus): OpenSearchQueryInterface;

    /**
     * Get regional focus
     */
    public function getRegionalFocus(): ?string;

    /**
     * Set regional focus
     *
     * @param string $regionalFocus
     */
    public function setRegionalFocus(string $regionalFocus): OpenSearchQueryInterface;

    /**
     * Get hosting stack
     */
    public function getHostingStack(): ?string;

    /**
     * Set hosting stack
     *
     * @param string $hostingStack
     */
    public function setHostingStack(string $hostingStack): OpenSearchQueryInterface;

    /**
     * Get country ID
     */
    public function getCountryId(): ?string;

    /**
     * Set country ID
     *
     * @param string $countryId
     */
    public function setCountryId(string $countryId): OpenSearchQueryInterface;

    /**
     * Get extension vendors
     *
     * @return string[]
     */
    public function getExtensionVendors(): array;

    /**
     * Set extension vendors
     *
     * @param string[] $extensionVendors
     */
    public function setExtensionVendors(array $extensionVendors): OpenSearchQueryInterface;

    /**
     * Get integrations
     *
     * @return string[]
     */
    public function getIntegrations(): array;

    /**
     * Set integrations
     *
     * @param string[] $integrations
     */
    public function setIntegrations(array $integrations): OpenSearchQueryInterface;

    /**
     * Get updated at timestamp
     */
    public function getUpdatedAt(): ?string;

    /**
     * Set updated at timestamp
     *
     * @param string $updatedAt
     */
    public function setUpdatedAt(string $updatedAt): OpenSearchQueryInterface;
}
