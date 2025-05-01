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

use Qoliber\CaseStudyManager\Api\Data\OpenSearchQueryInterface;

interface CaseStudySearchServiceInterface
{
    /**
     * Search PSL profiles using OpenSearch
     *
     * @param \Qoliber\CaseStudyManager\Api\Data\OpenSearchQueryInterface $filters
     * @return mixed[]
     */
    public function search(OpenSearchQueryInterface $filters): array;
}
