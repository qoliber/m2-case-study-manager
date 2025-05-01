<?php
/**
 * Created by Qoliber
 *
 * @category    Qoliber
 * @package     Qoliber_CaseStudyManager
 * @author      Jakub Winkler <jwinkler@qoliber.com>
 */

namespace Qoliber\CaseStudyManager\Model\ResourceModel;

use Magento\Framework\Filter\TranslitUrl;
use Magento\Framework\Model\AbstractModel;
use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
use Magento\Framework\Model\ResourceModel\Db\Context;
use Qoliber\CaseStudyManager\Api\Data\CaseStudyInterface;
use Qoliber\CaseStudyManager\Model\Email\Sender;
use Ramsey\Uuid\Uuid;

class CaseStudy extends AbstractDb
{
    /**
     * @param \Magento\Framework\Filter\TranslitUrl $translitUrl
     * @param \Qoliber\CaseStudyManager\Model\Email\Sender $emailSender
     * @param \Magento\Framework\Model\ResourceModel\Db\Context $context
     * @param null|string $connectionName
     */
    public function __construct(
        private readonly TranslitUrl $translitUrl,
        private readonly Sender $emailSender,
        Context $context,
        ?string $connectionName = null
    ) {
        parent::__construct($context, $connectionName);
    }

    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct(): void
    {
        $this->_init('qoliber_casestudy_entity', 'entity_id');
    }

    /**
     * Perform actions before entity save
     *
     * @param \Magento\Framework\Model\AbstractModel $object
     * @return $this
     * @throws \Magento\Framework\Exception\AlreadyExistsException
     */
    public function save(AbstractModel $object): CaseStudy
    {
        $isNewObject = !$object->getId();

        if (!$object->getId() || $object->getData(CaseStudyInterface::UUID) == "") {
            $object->setData(CaseStudyInterface::UUID, Uuid::uuid4());
        }

        if (!$object->getData('url_key') && $object->getData('title')) {
            $object->setData('url_key', $this->translitUrl->filter($object->getData('title')));
        }

        parent::save($object);

        if ($isNewObject) {
            /** @var \Qoliber\CaseStudyManager\Model\CaseStudy $object */
            $this->emailSender->sendNewCaseStudyNotification($object->getDataModel());
        }

        return $this;
    }
}
