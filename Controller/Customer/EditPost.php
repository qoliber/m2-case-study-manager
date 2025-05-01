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
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\File\UploaderFactory;
use Magento\Framework\Filesystem;
use Magento\Framework\Message\ManagerInterface;
use Magento\Framework\Url;
use Qoliber\CaseStudyManager\Api\CaseStudyRepositoryInterface;
use Qoliber\CaseStudyManager\Model\CaseStudyFactory;

class EditPost implements HttpPostActionInterface
{
    /**
     * @param \Magento\Framework\Url $url
     * @param \Magento\Framework\App\ResponseInterface $response
     * @param \Magento\Framework\Message\ManagerInterface $messageManager
     * @param \Qoliber\CaseStudyManager\Api\CaseStudyRepositoryInterface $caseStudyRepository
     * @param \Qoliber\CaseStudyManager\Model\CaseStudyFactory $caseStudyFactory
     * @param \Magento\Framework\File\UploaderFactory $uploaderFactory
     * @param \Magento\Framework\Filesystem $filesystem
     * @param \Magento\Framework\App\RequestInterface $request
     * @param \Magento\Customer\Model\Session $customerSession
     */
    public function __construct(
        private readonly Url $url,
        private readonly ResponseInterface $response,
        private readonly ManagerInterface $messageManager,
        private readonly CaseStudyRepositoryInterface $caseStudyRepository,
        private readonly CaseStudyFactory $caseStudyFactory,
        private readonly UploaderFactory $uploaderFactory,
        private readonly Filesystem $filesystem,
        private readonly RequestInterface $request,
        private readonly Session $customerSession,
    ) {
    }

    /**
     * Execute Controller Action
     *
     * @return \Magento\Framework\App\ResponseInterface
     * @throws \Magento\Framework\Exception\SessionException
     */
    public function execute(): ResponseInterface
    {
        $this->response->setRedirect($this->url->getUrl('customer/account/login')); // @phpstan-ignore-line

        if ($this->customerSession->authenticate()) {
            $this->response->setRedirect($this->url->getUrl('casestudy/manage/')); // @phpstan-ignore-line

            try {
                $this->saveCaseStudy(
                    $this->getCustomerId(),
                    $this->request->getParams(),
                );
                $this->messageManager->addSuccessMessage(__('Your case study has been saved.')->render());
            } catch (LocalizedException $e) {
                $this->messageManager->addErrorMessage(
                    __('There was an error saving your case study: %1', $e->getMessage())->render()
                );
            } catch (\Throwable $e) {
                $this->messageManager->addErrorMessage(
                    __('There was an error saving your case study: %1', $e->getMessage())->render()
                );
            }
        }

        return $this->response;
    }

    /**
     * Get customer ID
     *
     * @return int
     */
    private function getCustomerId(): int
    {
        return (int) $this->customerSession->getCustomerId();
    }

    /**
     * Process image
     *
     * @return string|null
     * @throws \Exception
     */
    private function processImage(): ?string
    {
        $image = $this->request->getFiles()['image'] ?? null; // @phpstan-ignore-line

        if (isset($image) && $image['error'] !== UPLOAD_ERR_NO_FILE) {
            $uploader = $this->uploaderFactory->create(['fileId' => 'image']);
            $uploader->setAllowedExtensions(['jpg', 'jpeg', 'png', 'svg', 'webp']);
            $uploader->setAllowRenameFiles(true);
            $uploader->setFilesDispersion(false);

            $path = $this->filesystem
                ->getDirectoryRead(DirectoryList::MEDIA)
                ->getAbsolutePath('case_study');
            $uploader->save($path);

            return $uploader->getUploadedFileName();
        }

        return null;
    }

    /**
     * Save Case Study
     *
     * @param int $customerId
     * @param array<mixed> $params
     * @return void
     * @throws \Magento\Framework\Exception\LocalizedException
     * @throws \Exception
     */
    private function saveCaseStudy(int $customerId, array $params): void
    {
        $imagePath = $this->processImage();

        // Convert arrays to strings
        $params['extension_vendors'] = is_array($params['extension_vendors'] ?? null)
            ? implode(',', $params['extension_vendors'])
            : '';

        $params['integrations'] = is_array($params['integrations'] ?? null)
            ? implode(',', $params['integrations'])
            : '';

        // Strip HTML tags
        $params['summary'] = strip_tags($params['summary'] ?? '');
        $params['content'] = strip_tags($params['content'] ?? '');

        // Handle image
        if (!empty($params['remove_image'])) {
            $params['image'] = '';
        } else {
            $params['image'] = $imagePath ?? ($params['image'] ?? '');
        }

        $params['customer_id'] = $customerId;

        try {
            $caseStudy = !empty($params['entity_id'])
                ? $this->caseStudyRepository->getById((int)$params['entity_id'])
                : $this->caseStudyFactory->create()->getDataModel();

            $caseStudy->addData($params); // @phpstan-ignore-line
            $this->caseStudyRepository->save($caseStudy);
        } catch (\Exception $e) {
            throw new LocalizedException(__('Could not save the case study: %1', $e->getMessage()));
        }
    }
}
