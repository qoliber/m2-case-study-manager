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
use Qoliber\CaseStudyManager\Model\Config;

class VerticalType implements OptionSourceInterface
{
    /**
     * @param \Qoliber\CaseStudyManager\Model\Config $config
     */
    public function __construct(
        private readonly Config $config
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
        $types = $this->config->getVerticalTypes();

        foreach ($types as $type) {
            $options[] = [
                'value' => $type['type'],
                'label' => __($type['type'])->render(),
            ];
        }

        return $options;
    }
}
