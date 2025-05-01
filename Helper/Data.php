<?php
/**
 * Created by Qoliber
 *
 * @category Qoliber
 * @package Qoliber_CaseStudyManager
 * @author Jakub Winkler <jwinkler@qoliber.com>
 */

namespace Qoliber\CaseStudyManager\Helper;

use Magento\CacheInvalidate\Model\PurgeCache;
use Magento\Cms\Api\Data\PageInterface;
use Magento\Cms\Api\Data\PageSearchResultsInterface;
use Magento\Cms\Model\Page;
use Magento\Framework\App\CacheInterface;
use Magento\PageCache\Model\Cache\Type;
use Magento\Store\Model\ScopeInterface;
use Psr\Log\LoggerInterface;
use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Magento\Framework\UrlInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Filesystem;
use Magento\Framework\Filesystem\Driver\File;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\Exception\FileSystemException;
use Magento\Store\Model\StoreManagerInterface;

class Data extends AbstractHelper
{
    /** @var string */
    protected const PORTFOLIO_STATUS_XPATH = 'qoliber_portfolio/settings/enabled';

    /** @var string  */
    protected const AUTOMATICALLY_CLEAR_VARNISH_XPATH = 'qoliber_portfolio/settings/cache';

    /** @var string  */
    protected const CASESTUDY_DIRECTORY = 'case_study';

    /**
     * @var \Psr\Log\LoggerInterface
     */
    protected LoggerInterface $logger;

    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected StoreManagerInterface $storeManager;

    /**
     * @var \Magento\Framework\Filesystem
     */
    protected Filesystem $filesystem;

    /**
     * @var \Magento\Framework\Filesystem\Driver\File
     */
    protected File $file;

    /**
     * @var \Magento\CacheInvalidate\Model\PurgeCache
     */
    protected PurgeCache $purgeCache;

    /**
     * @var \Magento\PageCache\Model\Cache\Type
     */
    protected Type $fullPage;

    /**
     * @var \Magento\Framework\App\CacheInterface
     */
    protected CacheInterface $cache;

    /**
     * @var \Magento\Cms\Api\PageRepositoryInterface
     */
    protected $pageRepositoryInterface;

    /**
     * @var \Magento\Framework\Api\SearchCriteriaBuilder
     */
    protected $searchCriteriaBuilder;

    /**
     * @param \Magento\Cms\Api\PageRepositoryInterface $pageRepositoryInterface
     * @param \Magento\Framework\Api\SearchCriteriaBuilder $searchCriteriaBuilder
     * @param \Magento\Framework\App\CacheInterface $cache
     * @param \Magento\Framework\App\Helper\Context $context
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param \Magento\Framework\Filesystem $filesystem
     * @param \Magento\Framework\Filesystem\Driver\File $file
     * @param \Magento\CacheInvalidate\Model\PurgeCache $purgeCache
     * @param \Psr\Log\LoggerInterface $logger
     * @param \Magento\PageCache\Model\Cache\Type $fullPage
     */
    public function __construct(
        \Magento\Cms\Api\PageRepositoryInterface $pageRepositoryInterface,
        \Magento\Framework\Api\SearchCriteriaBuilder $searchCriteriaBuilder,
        CacheInterface $cache,
        Context $context,
        StoreManagerInterface $storeManager,
        Filesystem $filesystem,
        File $file,
        PurgeCache $purgeCache,
        LoggerInterface $logger,
        Type $fullPage
    ) {
        $this->pageRepositoryInterface = $pageRepositoryInterface;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->cache = $cache;
        $this->storeManager = $storeManager;
        $this->filesystem = $filesystem;
        $this->file = $file;
        $this->purgeCache = $purgeCache;
        $this->logger = $logger;
        $this->fullPage = $fullPage;
        parent::__construct($context);
    }

    /**
     * Check if portfolio are enabled
     *
     * @return bool
     */
    public function getIsEnabled(): bool
    {
        return $this->scopeConfig->isSetFlag(self::PORTFOLIO_STATUS_XPATH, 'stores');
    }

    /**
     * Get image URL
     *
     * @param null|string $image
     * @return string
     */
    public function getImageUrl(?string $image): string
    {
        $imageUrl = '';

        try {
            $mediaUrl = $this->storeManager
                ->getStore()
                ->getBaseUrl(UrlInterface::URL_TYPE_MEDIA);
            $imageUrl = $mediaUrl . self::CASESTUDY_DIRECTORY . DIRECTORY_SEPARATOR . $image;
        } catch (NoSuchEntityException $e) {
            $this->_logger->debug($e->getMessage());
        }

        return $imageUrl;
    }

    /**
     * Get image path
     *
     * @param string $image
     * @return string
     */
    public function getImage(string $image): string
    {
        $mediaDirectory = $this->filesystem->getDirectoryRead(DirectoryList::MEDIA)->getAbsolutePath();
        return $mediaDirectory. self::CASESTUDY_DIRECTORY . DIRECTORY_SEPARATOR . $image;
    }

    /**
     * Clears or invalidates cache
     */
    public function cacheMaintenance(): void
    {
        $cacheTags = [];

        $pageIdentifier = $this->scopeConfig->getValue(
            'web/default/cms_home_page',
            ScopeInterface::SCOPE_STORE
        );

        if ($pageIdentifier) {
            $searchCriteria = $this->searchCriteriaBuilder->addFilter('identifier', $pageIdentifier, 'eq')->create();
            /** @var PageSearchResultsInterface $pages */
            $pages = $this->pageRepositoryInterface->getList($searchCriteria)->getItems();

            /** @var PageInterface $page */
            // @phpstan-ignore-next-line
            foreach ($pages as $page) {
                $cacheTags[] = Page::CACHE_TAG . '_' . $page->getId();
            }

            $this->cache->clean(
                $cacheTags
            );

            if ($this->isVarnishEnabled() && $this->checkIfVarnishShouldByAutomaticallyCleared()) {
                $this->purgeCache->sendPurgeRequest(implode('|', array_unique($cacheTags)));
            }
        }
    }

    /**
     * Delete image
     *
     * @param string $imageName
     */
    public function deleteImage(string $imageName): void
    {
        $imagePath = $this->getImage($imageName);

        try {
            if ($this->file->isExists($imagePath)) {
                $this->file->deleteFile($imagePath);
            }
        } catch (FileSystemException $e) {
            $this->logger->debug($e->getMessage());
        }
    }

    /**
     * Check if Varnish is enabled
     *
     * @return boolean
     */
    protected function isVarnishEnabled(): bool
    {
        return $this->scopeConfig->getValue(
            'system/full_page_cache/caching_application',
            ScopeInterface::SCOPE_STORE
        ) == 2;
    }

    /**
     * Check if Varnish should be automatically cleared
     *
     * @return bool
     */
    protected function checkIfVarnishShouldByAutomaticallyCleared(): bool
    {
        return $this->scopeConfig->isSetFlag(self::AUTOMATICALLY_CLEAR_VARNISH_XPATH, ScopeInterface::SCOPE_STORE);
    }
}
