<?php
declare(strict_types=1);

namespace Qoliber\CaseStudyManager\Api\Data;

interface CaseStudySearchResultsInterface
{
    /**
     * Get items
     *
     * @return \Qoliber\CaseStudyManager\Api\Data\CaseStudyInterface[]
     */
    public function getItems(): array;

    /**
     * Set items
     *
     * @param \Qoliber\CaseStudyManager\Api\Data\CaseStudyInterface[] $items
     * @return $this
     */
    public function setItems(array $items): self;

    /**
     * Get total count
     *
     * @return int
     */
    public function getTotalCount(): int;

    /**
     * Set total count
     *
     * @param int $totalCount
     * @return $this
     */
    public function setTotalCount(int $totalCount): self;
}
