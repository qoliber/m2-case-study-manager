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

use Magento\Framework\Api\ExtensibleDataInterface;

interface CaseStudyInterface extends ExtensibleDataInterface
{
    /** @var string */
    public const ENTITY_ID = 'entity_id';

    /** @var string */
    public const POSITION = 'position';

    /** @var string */
    public const CUSTOMER_ID = 'customer_id';

    /** @var string */
    public const TITLE = 'title';

    /** @var string */
    public const MAGENTO_VERSION = 'magento_version';

    /** @var string */
    public const FRONTEND_TYPE = 'frontend_type';

    /** @var string */
    public const SUMMARY = 'summary';

    /** @var string */
    public const CONTENT = 'content';

    /** @var string */
    public const SCREENSHOTS_LIST = 'screenshots_list';

    /** @var string */
    public const STORE_URL = 'store_url';

    /** @var string */
    public const URL_KEY = 'url_key';

    /** @var string */
    public const IMAGE = 'image';

    /** @var string */
    public const IS_ACTIVE = 'is_active';

    /** @var string  */
    public const UUID = 'uuid';

    /** @var string */
    public const VERTICAL_TYPES = 'vertical_types';

    /** @var string */
    public const CUSTOMER_FOCUS = 'customer_focus';

    /** @var string */
    public const REGIONAL_FOCUS = 'regional_focus';

    /** @var string */
    public const COUNTRY_ID = 'country_id';

    /** @var string */
    public const EXTENSION_VENDORS = 'extension_vendors';

    /** @var string */
    public const INTEGRATIONS = 'integrations';

    /** @var string  */
    public const HOSTING_STACK = 'hosting_stack';

    /** @var string */
    public const UPDATED_AT = 'updated_at';

    /** @var string */
    public const ID = 'id';

    /** @var string */
    public const CREATED_AT = 'created_at';

    /**
     * Get entity ID
     *
     * @return int|null
     */
    public function getEntityId(): ?int;

    /**
     * Set entity ID
     *
     * @param int $entityId
     * @return $this
     */
    public function setEntityId($entityId): CaseStudyInterface;

    /**
     * Get Position
     *
     * @return int|null
     */
    public function getPosition(): ?int;

    /**
     * Set entity ID
     *
     * @param int|string $position
     * @return $this
     */
    public function setPosition(int|string $position): CaseStudyInterface;

    /**
     * Get customer ID
     *
     * @return int|null
     */
    public function getCustomerId(): ?int;

    /**
     * Set customer ID
     *
     * @param int $customerId
     * @return $this
     */
    public function setCustomerId(int $customerId): CaseStudyInterface;

    /**
     * Get title
     *
     * @return string|null
     */
    public function getTitle(): ?string;

    /**
     * Set title
     *
     * @param string $title
     * @return $this
     */
    public function setTitle(string $title): CaseStudyInterface;

    /**
     * Get Magento version
     *
     * @return string|null
     */
    public function getMagentoVersion(): ?string;

    /**
     * Set Magento version
     *
     * @param string $version
     * @return $this
     */
    public function setMagentoVersion(string $version): CaseStudyInterface;

    /**
     * Get frontend type
     *
     * @return string|null
     */
    public function getFrontendType(): ?string;

    /**
     * Set frontend type
     *
     * @param string $type
     * @return $this
     */
    public function setFrontendType(string $type): CaseStudyInterface;

    /**
     * Get summary
     *
     * @return string|null
     */
    public function getSummary(): ?string;

    /**
     * Set summary
     *
     * @param string $summary
     * @return $this
     */
    public function setSummary(string $summary): CaseStudyInterface;

    /**
     * Get content
     *
     * @return string|null
     */
    public function getContent(): ?string;

    /**
     * Set content
     *
     * @param string $content
     * @return $this
     */
    public function setContent(string $content): CaseStudyInterface;

    /**
     * Get Screenshots List
     *
     * @return string|null
     */
    public function getScreenshotsList(): ?string;

    /**
     * Set Screenshots List
     *
     * @param string $screenshotsList
     * @return $this
     */
    public function setScreenshotsList(string $screenshotsList): CaseStudyInterface;

    /**
     * Get store URL
     *
     * @return string|null
     */
    public function getStoreUrl(): ?string;

    /**
     * Set store URL
     *
     * @param string $url
     * @return $this
     */
    public function setStoreUrl(string $url): CaseStudyInterface;

    /**
     * Get URL key
     *
     * @return string|null
     */
    public function getUrlKey(): ?string;

    /**
     * Set URL key
     *
     * @param string $urlKey
     * @return $this
     */
    public function setUrlKey(string $urlKey): CaseStudyInterface;

    /**
     * Get image
     *
     * @return string|null
     */
    public function getImage(): ?string;

    /**
     * Set image
     *
     * @param string $image
     * @return $this
     */
    public function setImage(string $image): CaseStudyInterface;

    /**
     * Get is active
     *
     * @return bool|null
     */
    public function getIsActive(): ?bool;

    /**
     * Set is active
     *
     * @param bool $isActive
     * @return $this
     */
    public function setIsActive(bool $isActive): CaseStudyInterface;

    /**
     * Get UUID
     *
     * @return string|null
     */
    public function getUuid(): ?string;

    /**
     * Set UUID
     *
     * @param string $uuid
     * @return $this
     */
    public function setUuid(string $uuid): CaseStudyInterface;

    /**
     * Get URL
     *
     * @return string
     */
    public function getUrl(): string;

    /**
     * Get image URL
     *
     * @return string
     */
    public function getImageUrl(): string;

    /**
     * Get vertical types
     *
     * @return string|null
     */
    public function getVerticalTypes(): ?string;

    /**
     * Set vertical types
     *
     * @param string $types
     * @return $this
     */
    public function setVerticalTypes(string $types): CaseStudyInterface;

    /**
     * Get customer focus
     *
     * @return string|null
     */
    public function getCustomerFocus(): ?string;

    /**
     * Set customer focus
     *
     * @param string $focus
     * @return $this
     */
    public function setCustomerFocus(string $focus): CaseStudyInterface;

    /**
     * Get regional focus
     *
     * @return string|null
     */
    public function getRegionalFocus(): ?string;

    /**
     * Set regional focus
     *
     * @param string $focus
     * @return $this
     */
    public function setRegionalFocus(string $focus): CaseStudyInterface;

    /**
     * Get country ID
     *
     * @return string|null
     */
    public function getCountryId(): ?string;

    /**
     * Set country ID
     *
     * @param string $countryId
     * @return $this
     */
    public function setCountryId(string $countryId): CaseStudyInterface;

    /**
     * Get extension vendors
     *
     * @return string|null
     */
    public function getExtensionVendors(): ?string;

    /**
     * Set extension vendors
     *
     * @param string $vendors
     * @return $this
     */
    public function setExtensionVendors(string $vendors): CaseStudyInterface;

    /**
     * Get integrations
     *
     * @return string|null
     */
    public function getIntegrations(): ?string;

    /**
     * Set integrations
     *
     * @param string $integrations
     * @return $this
     */
    public function setIntegrations(string $integrations): CaseStudyInterface;

    /**
     * Get hosting stack
     *
     * @return string|null
     */
    public function getHostingStack(): ?string;

    /**
     * Set hosting stack
     *
     * @param string $stack
     * @return $this
     */
    public function setHostingStack(string $stack): CaseStudyInterface;

    /**
     * Get updated at
     *
     * @return string|null
     */
    public function getUpdatedAt(): ?string;

    /**
     * Set updated at
     *
     * @param string $updatedAt
     * @return $this
     */
    public function setUpdatedAt(string $updatedAt): CaseStudyInterface;

    /**
     * Get creation time
     *
     * @return null|string
     */
    public function getCreatedAt(): ?string;

    /**
     * Set creation time
     *
     * @param string $createdAt
     * @return $this
     */
    public function setCreatedAt(string $createdAt): self;
}
