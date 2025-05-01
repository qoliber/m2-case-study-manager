<?php
declare(strict_types=1);

namespace Qoliber\CaseStudyManager\Block\System\Config;

use Magento\Config\Block\System\Config\Form\Field\FieldArray\AbstractFieldArray;

class RegionalFocus extends AbstractFieldArray
{
    /**
     * Prepare to render the new field by adding all the needed columns
     */
    protected function _prepareToRender(): void
    {
        $this->addColumn('type', ['label' => __('Type')->render(), 'class' => 'required-entry']);
        $this->_addAfter = false;
        $this->_addButtonLabel = __('Add Regional Focus')->render();
    }
}
