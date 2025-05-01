<?php
/**
 * Created by Qoliber
 *
 * @category    Qoliber
 * @package     Qoliber_CaseStudyManager
 * @author      Jakub Winkler <jwinkler@qoliber.com>
 */

declare(strict_types=1);

namespace Qoliber\CaseStudyManager\Model\CaseStudy;

use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Ui\DataProvider\AbstractDataProvider;
use Psr\Log\LoggerInterface;
use Qoliber\CaseStudyManager\Helper\Data as CaseStudyManagerHelper;
use Qoliber\CaseStudyManager\Model\ResourceModel\CaseStudy\CollectionFactory;

class DataProvider extends AbstractDataProvider
{
    /**
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param \Qoliber\CaseStudyManager\Model\ResourceModel\CaseStudy\CollectionFactory $collectionFactory
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param \Psr\Log\LoggerInterface $logger
     * @param \Qoliber\CaseStudyManager\Helper\Data $helper
     * @param \Magento\Framework\App\Request\DataPersistorInterface $dataPersistor
     * @param array<mixed> $meta
     * @param array<mixed> $data
     */
    public function __construct(
        string $name,
        string $primaryFieldName,
        string $requestFieldName,
        CollectionFactory $collectionFactory,
        protected StoreManagerInterface $storeManager,
        protected LoggerInterface $logger,
        protected CaseStudyManagerHelper $helper,
        protected DataPersistorInterface $dataPersistor,
        array $meta = [],
        array $data = []
    ) {
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
        $this->collection = $collectionFactory->create();
    }

    /**
     * Get data
     *
     * @return array<mixed>
     */
    public function getData(): array
    {
        $data = parent::getData();
        $items = [];

        foreach ($data['items'] as $item) {
            $items[$item['entity_id']] = $item;

            if ($item['image'] !== null) {
                $items[$item['entity_id']]['image'] = [
                    [
                        'name' => $item['image'],
                        'url' => $this->helper->getImageUrl($item['image']),
                    ]
                ];
            }

            // Convert comma-separated strings to arrays
            if (!empty($item['extension_vendors'])) {
                $items[$item['entity_id']]['extension_vendors'] = array_filter(
                    explode(',', $item['extension_vendors'])
                );
            }

            if (!empty($item['integrations'])) {
                $items[$item['entity_id']]['integrations'] = array_filter(
                    explode(',', $item['integrations'])
                );
            }
        }

        $persistedData = $this->dataPersistor->get('casestudy');
        if (!empty($persistedData)) {
            $model = $this->collection->getNewEmptyItem();
            $model->setData($persistedData);
            $items[$model->getId()] = $model->getData();
            $this->dataPersistor->clear('casestudy');
        }

        return $items;
    }
}
