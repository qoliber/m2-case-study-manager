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

class SaveButton extends GenericButton implements ButtonProviderInterface
{
    /**
     * Get the button data
     *
     * @return array<mixed>
     */
    public function getButtonData(): array
    {
        return [
            'label' => __('Save'),
            'class' => 'save primary',
            'data_attribute' => [
                'mage-init' => ['button' => ['event' => 'save']],
                'form-role' => 'save',
            ],
            'sort_order' => 30,
        ];
    }
}
