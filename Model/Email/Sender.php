<?php
/**
 * Created by Qoliber
 *
 * @category    Qoliber
 * @package     Qoliber_CaseStudyManager
 * @author      Jakub Winkler <jwinkler@qoliber.com>
 */

declare(strict_types=1);

namespace Qoliber\CaseStudyManager\Model\Email;

use Magento\Framework\App\Area;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Mail\Template\TransportBuilder;
use Magento\Framework\Translate\Inline\StateInterface;
use Magento\Store\Model\Store;
use Qoliber\CaseStudyManager\Api\Data\CaseStudyInterface;
use Magento\Customer\Api\CustomerRepositoryInterface;
use Psr\Log\LoggerInterface;

class Sender
{
    private const XML_PATH_EMAIL_TEMPLATE_FIELD = 'qoliber_casestudy/settings/email_template';
    private const XML_PATH_EMAIL_RECIPIENT = 'qoliber_casestudy/settings/marketing_team_email';

    /**
     * @param \Magento\Framework\Mail\Template\TransportBuilder $transportBuilder
     * @param \Magento\Framework\Translate\Inline\StateInterface $inlineTranslation
     * @param \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
     * @param \Magento\Customer\Api\CustomerRepositoryInterface $customerRepository
     * @param \Psr\Log\LoggerInterface $logger
     */
    public function __construct(
        private readonly TransportBuilder $transportBuilder,
        private readonly StateInterface $inlineTranslation,
        private readonly ScopeConfigInterface $scopeConfig,
        private readonly CustomerRepositoryInterface $customerRepository,
        private readonly LoggerInterface $logger
    ) {
    }

    /**
     * Send notification about new case study
     *
     * @param \Qoliber\CaseStudyManager\Api\Data\CaseStudyInterface $caseStudy
     * @return void
     */
    public function sendNewCaseStudyNotification(CaseStudyInterface $caseStudy): void
    {
        try {
            if ($caseStudy->getCustomerId()) {
                $customer = $this->customerRepository->getById($caseStudy->getCustomerId());
                $recipientEmail = $this->scopeConfig->getValue(self::XML_PATH_EMAIL_RECIPIENT);
                $emailTemplate = $this->scopeConfig->getValue(self::XML_PATH_EMAIL_TEMPLATE_FIELD);

                if (!$recipientEmail || !$emailTemplate) {
                    return;
                }

                $this->inlineTranslation->suspend();

                $transport = $this->transportBuilder
                    ->setTemplateIdentifier($emailTemplate)
                    ->setTemplateOptions([
                        'area' => Area::AREA_FRONTEND,
                        'store' => Store::DEFAULT_STORE_ID
                    ])
                    ->setTemplateVars([
                        'case_study' => $caseStudy,
                        'customer_email' => $customer->getEmail()
                    ])
                    ->setFromByScope('general')
                    ->addTo($recipientEmail)
                    ->getTransport();

                $transport->sendMessage();
                $this->inlineTranslation->resume();
            }
        } catch (\Exception $e) {
            $this->logger->error('Error sending case study notification email: ' . $e->getMessage());
        }
    }
}
