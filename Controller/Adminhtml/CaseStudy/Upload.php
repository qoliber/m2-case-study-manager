<?php
/**
 * Created by Qoliber
 *
 * @category    Qoliber
 * @package     Qoliber_CaseStudyManager
 * @author      Jakub Winkler <jwinkler@qoliber.com>
 */

namespace Qoliber\CaseStudyManager\Controller\Adminhtml\CaseStudy;

use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\MediaStorage\Model\File\UploaderFactory;
use Magento\Backend\App\Action;
use Qoliber\CaseStudyManager\Helper\Data as CaseStudyManagerHelper;

class Upload extends Action
{
    /** @var string */
    public const CASESTUDY_DIRECTORY = 'case_study';

    /** @var string[] */
    public const FIELDS = [
        'image_path',
        'image_path_tablet',
        'image_path_mobile',
    ];

    /**
     * @var \Magento\MediaStorage\Model\File\UploaderFactory
     */
    protected UploaderFactory $fileUploaderFactory;

    /**
     * @var \Magento\Framework\App\Filesystem\DirectoryList
     */
    protected DirectoryList $directoryList;

    /**
     * @var \Qoliber\CaseStudyManager\Helper\Data
     */
    protected CaseStudyManagerHelper $helper;

    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\MediaStorage\Model\File\UploaderFactory $fileUploaderFactory
     * @param \Magento\Framework\App\Filesystem\DirectoryList $directory_list
     * @param \Qoliber\CaseStudyManager\Helper\Data $helper
     */
    public function __construct(
        Action\Context $context,
        UploaderFactory $fileUploaderFactory,
        DirectoryList $directory_list,
        CaseStudyManagerHelper $helper
    ) {
        $this->fileUploaderFactory = $fileUploaderFactory;
        $this->directoryList = $directory_list;
        $this->helper = $helper;

        parent::__construct($context);
    }

    /**
     * Upload action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute(): ResultInterface
    {
        try {
            $fileId = $this->getRequest()->getParam('param_name', false);
            /** @var \Magento\MediaStorage\Model\File\Uploader $uploader */
            $uploader = $this->fileUploaderFactory->create(['fileId' => $fileId]);
            $uploader->setFilesDispersion(false);
            $uploader->setFilenamesCaseSensitivity(false);
            $uploader->setAllowRenameFiles(true);
            $uploader->setAllowedExtensions(['jpg', 'jpeg', 'gif', 'png', 'svg']);
            $path = $this->directoryList->getPath('media') . DIRECTORY_SEPARATOR . self::CASESTUDY_DIRECTORY;
            $result = $uploader->save($path);
            $result['url'] = $this->helper->getImageUrl($result['file']);
        } catch (\Exception $e) {
            $result = ['error' => $e->getMessage(), 'errorCode' => $e->getCode()];
        }

        // @phpstan-ignore-next-line
        return $this->resultFactory->create(ResultFactory::TYPE_JSON)->setData($result);
    }
}
