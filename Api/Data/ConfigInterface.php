<?php
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
