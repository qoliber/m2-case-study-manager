<?php
/**
 * Created by Qoliber
 *
 * @category    Qoliber
 * @package     Qoliber_CaseStudyManager
 * @author      Jakub Winkler <jwinkler@qoliber.com>
 */

declare(strict_types=1);

namespace Qoliber\CaseStudyManager\Controller\Customer;

use Magento\Customer\Model\Session;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Message\ManagerInterface;
use Magento\Framework\View\Result\Page;
use Qoliber\CaseStudyManager\Api\CaseStudyRepositoryInterface;

class Edit implements HttpGetActionInterface
{
    /**
     * @param \Magento\Framework\Controller\ResultFactory $resultFactory
     * @param \Magento\Customer\Model\Session $customerSession
     * @param \Magento\Framework\App\RequestInterface $request
     * @param \Qoliber\CaseStudyManager\Api\CaseStudyRepositoryInterface $caseStudyRepository
     * @param \Magento\Framework\Message\ManagerInterface $messageManager
     */
    public function __construct(
        private readonly ResultFactory $resultFactory,
        private readonly Session $customerSession,
        private readonly RequestInterface $request,
        private readonly CaseStudyRepositoryInterface $caseStudyRepository,
        private readonly ManagerInterface $messageManager
    ) {
    }

    /**
     * Execute action based on a request and return result
     *
     * @return ResultInterface
     */
    public function execute(): ResultInterface
    {
        if (!$this->customerSession->isLoggedIn()) {
            $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
            $resultRedirect->setPath('customer/account/login'); // @phpstan-ignore-line
            return $resultRedirect;
        }

        try {
            $id = (int) $this->request->getParam('id');
            if ($id) {
                $caseStudy = $this->caseStudyRepository->getById($id);
                if ($caseStudy->getCustomerId() !== (int) $this->customerSession->getCustomerId()) {
                    throw new LocalizedException(__('You are not authorized to edit this case study.'));
                }
            }
        } catch (NoSuchEntityException $e) {
            $this->messageManager->addErrorMessage(__('This case study no longer exists.')->render());
            $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
            $resultRedirect->setPath('*/manage/'); // @phpstan-ignore-line

            return $resultRedirect;
        } catch (LocalizedException $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
            $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
            $resultRedirect->setPath('*/manage/'); // @phpstan-ignore-line

            return $resultRedirect;
        }

        /** @var Page $resultPage */
        $resultPage = $this->resultFactory->create(ResultFactory::TYPE_PAGE);
        $resultPage->getConfig()->getTitle()->set(__('Edit Case Study')->render());

        return $resultPage;
    }
}
