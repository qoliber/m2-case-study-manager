<?php
/**
 * Created by Qoliber
 *
 * @category    Qoliber
 * @package     Qoliber_CaseStudyManager
 * @author      Jakub Winkler <jwinkler@qoliber.com>
 */

declare(strict_types=1);

namespace Qoliber\CaseStudyManager\Controller\Adminhtml\CaseStudy;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\View\Result\Page;

class Edit extends Action
{
    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected PageFactory $resultPageFactory;

    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     */
    public function __construct(Context $context, PageFactory $resultPageFactory)
    {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
    }

    /**
     * Execute action
     *
     * @return \Magento\Framework\View\Result\Page
     */
    public function execute(): Page
    {
        $resultPage = $this->resultPageFactory->create();

        /** @var string $title */
        $title = ($this->getRequest()->getParam('entity_id')) ?
            __('Edit Case Study (ID: ' . $this->getRequest()->getParam('entity_id') . ')')->render() :
            __('Add a new Qoliber CaseStudyManager')->render();
        $resultPage->getConfig()->getTitle()->prepend($title);

        return $resultPage;
    }
}
