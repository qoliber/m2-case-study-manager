<?php
/**
 * Created by Qoliber
 *
 * @category    Qoliber
 * @package     Qoliber_CaseStudyManager
 * @author      Jakub Winkler <jwinkler@qoliber.com>
 */

declare(strict_types=1);

namespace Qoliber\CaseStudyManager\Model\Config\Source;

use Magento\Framework\Data\OptionSourceInterface;
use Magento\Customer\Model\ResourceModel\Customer\CollectionFactory;

class Customer implements OptionSourceInterface
{
    /**
     * @param \Magento\Customer\Model\ResourceModel\Customer\CollectionFactory $customerCollectionFactory
     */
    public function __construct(
        private readonly CollectionFactory $customerCollectionFactory
    ) {
    }

    /**
     * Get an option array
     *
     * @return array<mixed>
     */
    public function toOptionArray(): array
    {
        $options = [];
        $collection = $this->customerCollectionFactory->create();
        $collection->addAttributeToSelect(['email', 'firstname', 'lastname']);

        foreach ($collection as $customer) {
            $options[] = [
                'value' => $customer->getId(),
                'label' => sprintf(
                    '%s (%s)',
                    $customer->getEmail(),
                    $customer->getId()
                )
            ];
        }

        return $options;
    }
}
