<?php
/**
 * Created by Qoliber
 *
 * @category    Qoliber
 * @package     Qoliber_CaseStudyManager
 * @author      Jakub Winkler <jwinkler@qoliber.com>
 */

declare(strict_types=1);

namespace Qoliber\CaseStudyManager\Api\Data;

/**
 * Case Study Config Interface
 */
interface ConfigInterface
{
    /**
     * Get Module Config
     *
     * @return mixed[]
     */
    public function getConfig(): array;
}
