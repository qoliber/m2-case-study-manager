<?php
/**
 * Created by Qoliber
 *
 * @category    Qoliber
 * @package     Qoliber_CaseStudyManager
 * @author      Jakub Winkler <jwinkler@qoliber.com>
 */

declare(strict_types=1);

namespace Qoliber\CaseStudyManager\Block\System\Config;

use Magento\Backend\Block\Widget\Button;
use Magento\Config\Block\System\Config\Form\Field;
use Magento\Framework\Data\Form\Element\AbstractElement;

class CheckConnection extends Field
{
    /**
     * Remove scope label
     *
     * @param \Magento\Framework\Data\Form\Element\AbstractElement $element
     * @return string
     */
    public function render(AbstractElement $element): string
    {
        $element->unsScope()->unsCanUseWebsiteValue()->unsCanUseDefaultValue();
        return parent::render($element);
    }

    /**
     * Return element html
     *
     * @param \Magento\Framework\Data\Form\Element\AbstractElement $element
     * @return string
     */
    protected function _getElementHtml(AbstractElement $element): string
    {
        // @phpstan-ignore-next-line
        $this->setTemplate('Qoliber_CaseStudyManager::system/config/check-connection.phtml');

        return $this->toHtml();
    }

    /**
     * Return ajax url for button
     *
     * @return string
     */
    public function getAjaxUrl(): string
    {
        return $this->getUrl('casestudy/system_config/checkconnection');
    }

    /**
     * Generate button html
     *
     * @return string
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getButtonHtml(): string
    {
        // @phpstan-ignore-next-line
        $button = $this->getLayout()->createBlock(
            Button::class
        )->setData([
            'id' => 'check_connection_button',
            'label' => __('Check Connection'),
        ]);

        return $button->toHtml();
    }
}
