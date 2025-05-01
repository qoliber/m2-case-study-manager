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
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\View\Result\PageFactory;
use Psr\Log\LoggerInterface;
use Qoliber\CaseStudyManager\Api\CaseStudyRepositoryInterface;
use Qoliber\CaseStudyManager\Helper\Data as CaseStudyManagerHelper;
use Qoliber\CaseStudyManager\Model\CaseStudy;
use Qoliber\CaseStudyManager\Model\CaseStudyFactory;

class Save extends Action
{
    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Qoliber\CaseStudyManager\Model\CaseStudyFactory $caseStudyFactory
     * @param \Qoliber\CaseStudyManager\Helper\Data $helper
     * @param \Qoliber\CaseStudyManager\Api\CaseStudyRepositoryInterface $caseStudyRepository
     * @param \Magento\Framework\App\Request\DataPersistorInterface $dataPersistor
     */
    public function __construct(
        protected Context $context,
        private readonly CaseStudyFactory $caseStudyFactory,
        private readonly CaseStudyManagerHelper $helper,
        private readonly CaseStudyRepositoryInterface $caseStudyRepository,
        private readonly DataPersistorInterface $dataPersistor
    ) {
        parent::__construct($context);
    }

    /**
     * Execute action
     *
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface
     */
    public function execute(): ResponseInterface|ResultInterface
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        $data = $this->getRequest()->getParams();

        if ($data) {
            $id = $this->getRequest()->getParam('entity_id');
            /** @var CaseStudy $caseStudyModel */
            $caseStudyModel = $this->caseStudyFactory->create();

            if ($id) {
                try {
                    $caseStudyModel = $this->caseStudyRepository->getById($id);
                } catch (LocalizedException $e) {
                    $this->messageManager->addErrorMessage(__('This case study no longer exists.'));
                    return $resultRedirect->setPath('*/*/');
                }
            }

            if (isset($data['image']) && is_array($data['image'])) {
                if (isset($data['image'][0]['name'])) {
                    $data['image'] = $data['image'][0]['name'];
                } else {
                    $data['image'] = '';
                }
            }

            if (isset($data['extension_vendors']) && is_array($data['extension_vendors'])) {
                $data['extension_vendors'] = implode(',', array_filter($data['extension_vendors']));
            }

            if (isset($data['integrations']) && is_array($data['integrations'])) {
                $data['integrations'] = implode(',', array_filter($data['integrations']));
            }

            $caseStudyModel->setData($data); // @phpstan-ignore-line

            try {
                // @phpstan-ignore-next-line
                $this->caseStudyRepository->save($caseStudyModel);
                $this->helper->cacheMaintenance();
                $this->messageManager->addSuccessMessage(__('You saved the case study.')->render());
                $this->dataPersistor->clear('casestudy');

                if ($this->getRequest()->getParam('back')) {
                    // @phpstan-ignore-next-line
                    return $resultRedirect->setPath('*/*/edit', ['entity_id' => $caseStudyModel->getId()]);
                }

                return $resultRedirect->setPath('*/*/');
            } catch (LocalizedException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addExceptionMessage(
                    $e,
                    __('Something went wrong while saving the case study. %1', $e->getMessage())->render()
                );
            }

            $this->dataPersistor->set('casestudy', $data);
            return $resultRedirect->setPath('*/*/edit', ['entity_id' => $id]);
        }

        return $resultRedirect->setPath('*/*/');
    }
}
