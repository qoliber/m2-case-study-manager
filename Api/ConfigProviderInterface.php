<?php
/**
 * Created by Qoliber
 *
 * @category    Qoliber
 * @package     Qoliber_CaseStudyManager
 * @author      Jakub Winkler <jwinkler@qoliber.com>
 */

declare(strict_types=1);

namespace Qoliber\CaseStudyManager\Api;

interface ConfigProviderInterface
{
    /**
     * Get module configuration
     *
     * @return mixed[]
     */
    public function getConfig(): array;
}
