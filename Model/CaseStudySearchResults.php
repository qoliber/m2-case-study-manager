<?php
declare(strict_types=1);

namespace Qoliber\CaseStudyManager\Model;

use Magento\Framework\Api\SearchResults;
use Qoliber\CaseStudyManager\Api\Data\CaseStudyInterface;
use Qoliber\CaseStudyManager\Api\Data\CaseStudySearchResultsInterface;

class CaseStudySearchResults extends SearchResults implements CaseStudySearchResultsInterface
{
    /**
     * Get case studies list
     *
     * @return \Qoliber\CaseStudyManager\Api\Data\CaseStudyInterface[]
     */
    public function getItems(): array
    {
        return $this->_get(self::KEY_ITEMS) ?? [];
    }

    /**
     * Set case studies list
     *
     * @param \Qoliber\CaseStudyManager\Api\Data\CaseStudyInterface[] $items
     * @return $this
     */
    public function setItems(array $items): self
    {
        return $this->setData(self::KEY_ITEMS, $items);
    }
}
