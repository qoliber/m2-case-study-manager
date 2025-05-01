<?php
declare(strict_types=1);

namespace Qoliber\CaseStudyManager\Block\System\Config;

use Magento\Config\Block\System\Config\Form\Field\FieldArray\AbstractFieldArray;

class FrontendType extends AbstractFieldArray
{
    /**
     * Prepare to render
     *
     * @return void
     */
    protected function _prepareToRender(): void
    {
        $this->addColumn('type', [
            'label' => __('Type')->render(),
            'class' => 'required-entry'
        ]);
        $this->_addAfter = false;
        $this->_addButtonLabel = __('Add Type')->render();
    }
}
