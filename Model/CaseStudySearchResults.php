<?php
/**
 * Created by Qoliber
 *
 * @category    Qoliber
 * @package     Qoliber_EventCalendar
 * @author      Jakub Winkler <jwinkler@qoliber.com>
 */

declare(strict_types=1);

namespace Qoliber\CaseStudyManager\Model;

use Magento\Framework\Api\SearchResults;
use Qoliber\CaseStudyManager\Api\Data\CaseStudySearchResultsInterface;

class CaseStudySearchResults extends SearchResults implements CaseStudySearchResultsInterface
{

}
