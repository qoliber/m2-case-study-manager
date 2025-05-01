<?php
/**
 * Created by Qoliber
 *
 * @category    Qoliber
 * @package     Qoliber_CaseStudyManager
 * @author      Jakub Winkler <jwinkler@qoliber.com>
 */

namespace Qoliber\CaseStudyManager\Ui\Component\Listing\Column;

use Psr\Log\LoggerInterface;
use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Ui\Component\Listing\Columns\Column;
use Magento\Framework\Exception\NoSuchEntityException;

class Thumbnail extends Column
{
    /** @var string */
    private const ALT_FIELD = 'name';

    /**
     * @param \Magento\Framework\View\Element\UiComponent\ContextInterface $context
     * @param \Magento\Framework\View\Element\UiComponentFactory $uiComponentFactory
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param \Psr\Log\LoggerInterface $logger
     * @param array<mixed> $components
     * @param array<mixed> $data
     */
    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        private readonly StoreManagerInterface $storeManager,
        private readonly LoggerInterface $logger,
        array $components = [],
        array $data = []
    ) {
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    /**
     * Prepare Data Source
     *
     * @param array<mixed> $dataSource
     * @return array<mixed>
     */
    public function prepareDataSource(array $dataSource): array
    {
        if (isset($dataSource['data']['items'])) {
            $fieldName = $this->getData('name');
            
            foreach ($dataSource['data']['items'] as & $item) {
                $url = '';
                if ($item[$fieldName] != '') {
                    try {
                        $url = $this->storeManager->getStore()->getBaseUrl(
                            UrlInterface::URL_TYPE_MEDIA
                        ) . 'qoliber_portfolio/' . $item[$fieldName];
                    } catch (NoSuchEntityException $e) {
                        $this->logger->debug($e->getMessage());
                    }
                }
                $item[$fieldName . '_src'] = $url;
                $item[$fieldName . '_orig_src'] = $url;
            }
        }

        return $dataSource;
    }

    /**
     * Get Alt
     *
     * @param array<mixed> $row
     * @return null|string
     */
    protected function getAlt(array $row): ?string
    {
        $altField = $this->getData('config/altField') ?: self::ALT_FIELD;

        return $row[$altField] ?? null;
    }
}
