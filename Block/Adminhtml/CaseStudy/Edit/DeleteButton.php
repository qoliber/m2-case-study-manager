<?php
/**
 * Created by Qoliber
 *
 * @category    Qoliber
 * @package     Qoliber_CaseStudyManager
 * @author      Jakub Winkler <jwinkler@qoliber.com>
 */

namespace Qoliber\CaseStudyManager\Block\Adminhtml\CaseStudy\Edit;

use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;
use Qoliber\CaseStudyManager\Block\Adminhtml\CaseStudy\Edit\GenericButton;

class DeleteButton extends GenericButton implements ButtonProviderInterface
{
    /**
     * Get button data
     *
     * @return array<mixed>
     */
    public function getButtonData(): array
    {
        $data = [];

        if ($this->getEntityId()) {
            $data = [
                'label' => __('Delete'),
                'class' => 'action-secondary',
                'on_click' => 'deleteConfirm(\''
                    . __('Are you sure you want to delete it?')
                    . '\', \'' . $this->getDeleteUrl() . '\')',
                'sort_order' => 20,
            ];
        }

        return $data;
    }

    /**
     * Get URL for delete button
     *
     * @return string
     */
    public function getDeleteUrl(): string
    {
        return $this->getUrl('*/*/delete', ['entity_id' => $this->getEntityId()]);
    }
}
