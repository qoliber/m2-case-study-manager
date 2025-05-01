<?php
/**
 * Created by Qoliber
 *
 * @category    Qoliber
 * @package     Qoliber_CaseStudyManager
 * @author      Jakub Winkler <jwinkler@qoliber.com>
 */

namespace Qoliber\CaseStudyManager\Block\Adminhtml\CaseStudy\Edit;

use Magento\Backend\Block\Widget\Context;
use Magento\Framework\App\Request\Http;
use Magento\Framework\UrlInterface;

class GenericButton
{
    /**
     * @var \Magento\Framework\UrlInterface
     */
    protected UrlInterface $urlBuilder;

    /**
     * @var \Magento\Framework\App\Request\Http
     */
    protected Http $request;

    /**
     * @param \Magento\Backend\Block\Widget\Context $context
     * @param \Magento\Framework\App\Request\Http $request
     */
    public function __construct(Context $context, Http $request)
    {
        $this->urlBuilder = $context->getUrlBuilder();
        $this->request = $request;
    }

    /**
     * Return the entity ID
     *
     * @return int
     */
    public function getEntityId(): int
    {
        return (int) $this->request->getParam('entity_id');
    }

    /**
     * Generate url by route and parameters
     *
     * @param   string $route
     * @param   array<mixed> $params
     * @return  string
     */
    public function getUrl($route = '', $params = []): string
    {
        return $this->urlBuilder->getUrl($route, $params);
    }
}
