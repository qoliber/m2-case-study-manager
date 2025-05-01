<?php
declare(strict_types=1);

namespace Qoliber\CaseStudyManager\Model\Data;

use Magento\Framework\Model\AbstractModel;
use Qoliber\CaseStudyManager\Api\Data\CaseStudyInterface;

class CaseStudy extends AbstractModel implements CaseStudyInterface
{
    /**
     * Get entity ID
     *
     * @return int|null
     */
    public function getEntityId(): ?int
    {
        return $this->getData(self::ENTITY_ID) ? (int) $this->getData(self::ENTITY_ID) : null;
    }

    /**
     * Set entity ID
     *
     * @param int $entityId
     * @return $this
     */
    public function setEntityId($entityId): CaseStudyInterface
    {
        return $this->setData(self::ENTITY_ID, $entityId);
    }

    /**
     * Get Position
     *
     * @return int|null
     */
    public function getPosition(): ?int
    {
        return $this->getData(self::POSITION) ? (int) $this->getData(self::POSITION) : null;
    }

    /**
     * Set entity ID
     *
     * @param int|string $position
     * @return $this
     */
    public function setPosition(int|string $position): CaseStudyInterface
    {
        return $this->setData(self::POSITION, $position);
    }

    /**
     * Get customer ID
     *
     * @return int|null
     */
    public function getCustomerId(): ?int
    {
        return $this->getData(self::CUSTOMER_ID) ? (int) $this->getData(self::CUSTOMER_ID) : null;
    }

    /**
     * Set customer ID
     *
     * @param int $customerId
     * @return \Qoliber\CaseStudyManager\Api\Data\CaseStudyInterface
     */
    public function setCustomerId(int $customerId): CaseStudyInterface
    {
        $this->setData(self::CUSTOMER_ID, $customerId);
        return $this;
    }

    /**
     * Get title
     *
     * @return string|null
     */
    public function getTitle(): ?string
    {
        return $this->getData(self::TITLE);
    }

    /**
     * Set title
     *
     * @param string $title
     * @return \Qoliber\CaseStudyManager\Api\Data\CaseStudyInterface
     */
    public function setTitle(string $title): CaseStudyInterface
    {
        $this->setData(self::TITLE, $title);
        return $this;
    }

    /**
     * Get Magento version
     *
     * @return string|null
     */
    public function getMagentoVersion(): ?string
    {
        return $this->getData(self::MAGENTO_VERSION);
    }

    /**
     * Set Magento version
     *
     * @param string $version
     * @return \Qoliber\CaseStudyManager\Api\Data\CaseStudyInterface
     */
    public function setMagentoVersion(string $version): CaseStudyInterface
    {
        $this->setData(self::MAGENTO_VERSION, $version);
        return $this;
    }

    /**
     * Get frontend type
     *
     * @return string|null
     */
    public function getFrontendType(): ?string
    {
        return $this->getData(self::FRONTEND_TYPE);
    }

    /**
     * Set frontend type
     *
     * @param string $type
     * @return \Qoliber\CaseStudyManager\Api\Data\CaseStudyInterface
     */
    public function setFrontendType(string $type): CaseStudyInterface
    {
        $this->setData(self::FRONTEND_TYPE, $type);
        return $this;
    }

    /**
     * Get summary
     *
     * @return string|null
     */
    public function getSummary(): ?string
    {
        return $this->getData(self::SUMMARY);
    }

    /**
     * Set summary
     *
     * @param string $summary
     * @return \Qoliber\CaseStudyManager\Api\Data\CaseStudyInterface
     */
    public function setSummary(string $summary): CaseStudyInterface
    {
        $this->setData(self::SUMMARY, $summary);
        return $this;
    }

    /**
     * Get content
     *
     * @return string|null
     */
    public function getContent(): ?string
    {
        return $this->getData(self::CONTENT);
    }

    /**
     * Set content
     *
     * @param string $content
     * @return \Qoliber\CaseStudyManager\Api\Data\CaseStudyInterface
     */
    public function setContent(string $content): CaseStudyInterface
    {
        return $this->setData(self::CONTENT, $content);
    }

    /**
     * Get store URL
     *
     * @return string|null
     */
    public function getStoreUrl(): ?string
    {
        return $this->getData(self::STORE_URL);
    }

    /**
     * Set store URL
     *
     * @param string $url
     * @return \Qoliber\CaseStudyManager\Api\Data\CaseStudyInterface
     */
    public function setStoreUrl(string $url): CaseStudyInterface
    {
        return $this->setData(self::STORE_URL, $url);
    }

    /**
     * Get URL key
     *
     * @return string|null
     */
    public function getUrlKey(): ?string
    {
        return $this->getData(self::URL_KEY);
    }

    /**
     * Set URL key
     *
     * @param string $urlKey
     * @return \Qoliber\CaseStudyManager\Api\Data\CaseStudyInterface
     */
    public function setUrlKey(string $urlKey): CaseStudyInterface
    {
        return $this->setData(self::URL_KEY, $urlKey);
    }

    /**
     * Get image
     *
     * @return string|null
     */
    public function getImage(): ?string
    {
        return $this->getData(self::IMAGE);
    }

    /**
     * Set image
     *
     * @param string $image
     * @return \Qoliber\CaseStudyManager\Api\Data\CaseStudyInterface
     */
    public function setImage(string $image): CaseStudyInterface
    {
        return $this->setData(self::IMAGE, $image);
    }

    /**
     * Get is active
     *
     * @return bool|null
     */
    public function getIsActive(): ?bool
    {
        return $this->getData(self::IS_ACTIVE) ? (bool) $this->getData(self::IS_ACTIVE) : null;
    }

    /**
     * Set is active
     *
     * @param bool $isActive
     * @return \Qoliber\CaseStudyManager\Api\Data\CaseStudyInterface
     */
    public function setIsActive(bool $isActive): CaseStudyInterface
    {
        return $this->setData(self::IS_ACTIVE, $isActive);
    }

    /**
     * Get UUID
     *
     * @return string|null
     */
    public function getUuid(): ?string
    {
        return $this->getData(self::UUID);
    }

    /**
     * Set UUID
     *
     * @param string $uuid
     * @return \Qoliber\CaseStudyManager\Api\Data\CaseStudyInterface
     */
    public function setUuid(string $uuid): CaseStudyInterface
    {
        return $this->setData(self::UUID, $uuid);
    }

    /**
     * Get URL
     *
     * @return string
     */
    public function getUrl(): string
    {
        $urlKey = (string) $this->getUrlKey();
        return '/casestudy/' . $urlKey;
    }

    /**
     * Get image URL
     *
     * @return string
     */
    public function getImageUrl(): string
    {
        $image = (string) $this->getImage();
        return '/media/casestudy/' . $image;
    }

    /**
     * Get vertical types
     *
     * @return string|null
     */
    public function getVerticalTypes(): ?string
    {
        return $this->getData(self::VERTICAL_TYPES);
    }

    /**
     * Set vertical types
     *
     * @param string $types
     * @return \Qoliber\CaseStudyManager\Api\Data\CaseStudyInterface
     */
    public function setVerticalTypes(string $types): CaseStudyInterface
    {
        return $this->setData(self::VERTICAL_TYPES, $types);
    }

    /**
     * Get customer focus
     *
     * @return string|null
     */
    public function getCustomerFocus(): ?string
    {
        return $this->getData(self::CUSTOMER_FOCUS);
    }

    /**
     * Set customer focus
     *
     * @param string $focus
     * @return \Qoliber\CaseStudyManager\Api\Data\CaseStudyInterface
     */
    public function setCustomerFocus(string $focus): CaseStudyInterface
    {
        return $this->setData(self::CUSTOMER_FOCUS, $focus);
    }

    /**
     * Get regional focus
     *
     * @return string|null
     */
    public function getRegionalFocus(): ?string
    {
        return $this->getData(self::REGIONAL_FOCUS);
    }

    /**
     * Set regional focus
     *
     * @param string $focus
     * @return \Qoliber\CaseStudyManager\Api\Data\CaseStudyInterface
     */
    public function setRegionalFocus(string $focus): CaseStudyInterface
    {
        return $this->setData(self::REGIONAL_FOCUS, $focus);
    }

    /**
     * Get country ID
     *
     * @return string|null
     */
    public function getCountryId(): ?string
    {
        return $this->getData(self::COUNTRY_ID);
    }

    /**
     * Set country ID
     *
     * @param string $countryId
     * @return \Qoliber\CaseStudyManager\Api\Data\CaseStudyInterface
     */
    public function setCountryId(string $countryId): CaseStudyInterface
    {
        return $this->setData(self::COUNTRY_ID, $countryId);
    }

    /**
     * Get extension vendors
     *
     * @return string|null
     */
    public function getExtensionVendors(): ?string
    {
        return $this->getData(self::EXTENSION_VENDORS);
    }

    /**
     * Set extension vendors
     *
     * @param string $vendors
     * @return \Qoliber\CaseStudyManager\Api\Data\CaseStudyInterface
     */
    public function setExtensionVendors(string $vendors): CaseStudyInterface
    {
        return $this->setData(self::EXTENSION_VENDORS, $vendors);
    }

    /**
     * Get integrations
     *
     * @return string|null
     */
    public function getIntegrations(): ?string
    {
        return $this->getData(self::INTEGRATIONS);
    }

    /**
     * Set integrations
     *
     * @param string $integrations
     * @return \Qoliber\CaseStudyManager\Api\Data\CaseStudyInterface
     */
    public function setIntegrations(string $integrations): CaseStudyInterface
    {
        return $this->setData(self::INTEGRATIONS, $integrations);
    }

    /**
     * Get hosting stack
     *
     * @return string|null
     */
    public function getHostingStack(): ?string
    {
        return $this->getData(self::HOSTING_STACK);
    }

    /**
     * Set Hosting Stack
     *
     * @param string $stack
     * @return \Qoliber\CaseStudyManager\Api\Data\CaseStudyInterface
     */
    public function setHostingStack(string $stack): CaseStudyInterface
    {
        return $this->setData(self::HOSTING_STACK, $stack);
    }

    /**
     * Get updated at
     *
     * @return string|null
     */
    public function getUpdatedAt(): ?string
    {
        return $this->getData(self::UPDATED_AT);
    }

    /**
     * Set updated at
     *
     * @param string $updatedAt
     * @return $this
     */
    public function setUpdatedAt(string $updatedAt): CaseStudyInterface
    {
        return $this->setData(self::UPDATED_AT, $updatedAt);
    }

    /**
     * Get Created At
     *
     * @return string
     */
    public function getCreatedAt(): string
    {
        return $this->getData(self::CREATED_AT);
    }

    /**
     * Set Created At
     *
     * @param string $createdAt
     * @return \Qoliber\CaseStudyManager\Api\Data\CaseStudyInterface
     */
    public function setCreatedAt(string $createdAt): CaseStudyInterface
    {
        return $this->setData(self::CREATED_AT, $createdAt);
    }
}
