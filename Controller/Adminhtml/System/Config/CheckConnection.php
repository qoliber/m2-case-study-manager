<?php
/**
 * Created by Qoliber
 *
 * @category    Qoliber
 * @package     Qoliber_CaseStudyManager
 * @author      Jakub Winkler <jwinkler@qoliber.com>
 */

declare(strict_types=1);

namespace Qoliber\CaseStudyManager\Controller\Adminhtml\System\Config;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Controller\Result\Json;
use Magento\Framework\Controller\Result\JsonFactory;
use Qoliber\CaseStudyManager\Model\OpenSearch\OpenSearchClient;

class CheckConnection extends Action
{
    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory
     * @param \Qoliber\CaseStudyManager\Model\OpenSearch\OpenSearchClient $openSearchClient
     */
    public function __construct(
        Context $context,
        private readonly JsonFactory $resultJsonFactory,
        private readonly OpenSearchClient $openSearchClient
    ) {
        parent::__construct($context);
    }

    /**
     * Check OpenSearch connection
     *
     * @return \Magento\Framework\Controller\Result\Json
     */
    public function execute(): Json
    {
        $result = $this->resultJsonFactory->create();

        try {
            $this->openSearchClient->checkConnection();
            return $result->setData([
                'success' => true,
                'message' => __('Connection successful!')
            ]);
        } catch (\Exception $e) {
            return $result->setData([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    /**
     * Check admin permissions
     *
     * @return bool
     */
    protected function _isAllowed(): bool
    {
        return $this->_authorization->isAllowed('Qoliber_CaseStudyManager::config');
    }
}
