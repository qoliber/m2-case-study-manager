<?php
/**
 * Created by Qoliber
 *
 * @category    Qoliber
 * @package     Qoliber_CaseStudyManager
 * @author      Jakub Winkler <jwinkler@qoliber.com>
 */

namespace Qoliber\CaseStudyManager\Controller\Adminhtml\CaseStudy;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\View\Result\PageFactory;
use Qoliber\CaseStudyManager\Helper\Data as CaseStudyManagerHelper;
use Qoliber\CaseStudyManager\Model\CaseStudy;
use Qoliber\CaseStudyManager\Model\CaseStudyFactory;
use Qoliber\CaseStudyManager\Model\ResourceModel\CaseStudy as CaseStudyResource;

class Delete extends Action
{
    /**
     * @var \Qoliber\CaseStudyManager\Model\CaseStudyFactory
     */
    protected CaseStudyFactory $CaseStudyFactory;

    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected PageFactory $resultPageFactory;

    /**
     * @var \Qoliber\CaseStudyManager\Helper\Data
     */
    protected CaseStudyManagerHelper $helper;

    /**
     * @var \Qoliber\CaseStudyManager\Model\ResourceModel\CaseStudy
     */
    private CaseStudyResource $resource;

    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     * @param \Qoliber\CaseStudyManager\Model\CaseStudyFactory $CaseStudyFactory
     * @param \Qoliber\CaseStudyManager\Helper\Data $helper
     * @param \Qoliber\CaseStudyManager\Model\ResourceModel\CaseStudy $resource
     */
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory,
        CaseStudyFactory $CaseStudyFactory,
        CaseStudyManagerHelper $helper,
        CaseStudyResource $resource
    ) {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
        $this->CaseStudyFactory = $CaseStudyFactory;
        $this->helper = $helper;
        $this->resource = $resource;
    }

    /**
     * Delete action
     *
     * @return \Magento\Framework\App\ResponseInterface
     */
    public function execute(): ResponseInterface
    {
        $entityId = $this->getRequest()->getParam('entity_id');

        if ($entityId) {
            try {
                /** @var CaseStudy $CaseStudyModel */
                $CaseStudyModel = $this->CaseStudyFactory->create();
                $this->resource->load($CaseStudyModel, $entityId);
                $CaseStudyCopy = clone $CaseStudyModel;
                $this->resource->delete($CaseStudyModel);
                $this->helper->deleteImage($CaseStudyCopy->getImage());
                $this->helper->cacheMaintenance();
                $this->messageManager->addSuccessMessage(
                    __('The Qoliber CaseStudyManager has been deleted successfully')->render()
                );

                return $this->_redirect('*/*/');
            } catch (\Exception $e) {
                $this->messageManager->addErrorMessage($e->getMessage());

                return $this->_redirect('*/*/edit', ['entity_id' => $entityId]);
            }
        }

        $this->messageManager->addErrorMessage(__('This Case Study doesn\'t exist')->render());

        return $this->_redirect('*/*/');
    }
}
