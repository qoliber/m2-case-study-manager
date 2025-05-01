<?php
/**
 * Created by Qoliber
 *
 * @category    Qoliber
 * @package     Qoliber_EventCalendar
 * @author      Jakub Winkler <jwinkler@qoliber.com>
 */

declare(strict_types=1);

namespace Qoliber\CaseStudyManager\Api\Data;

interface CaseStudySearchResultsInterface
{
    /**
     * Get items
     *
     * @return \Qoliber\CaseStudyManager\Api\Data\CaseStudyInterface[]
     */
    public function getItems();

    /**
     * Set items
     *
     * @param \Qoliber\CaseStudyManager\Api\Data\CaseStudyInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}
