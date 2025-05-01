<?php
/**
 * Created by Qoliber
 *
 * @category    Qoliber
 * @package     Qoliber_CaseStudyManager
 * @author      Jakub Winkler <jwinkler@qoliber.com>
 */

namespace Qoliber\CaseStudyManager\Ui\Component\Listing\Column;

use Magento\Ui\Component\Listing\Columns\Column;

class Status extends Column
{
    /**
     * Prepare Data Source
     *
     * @param array<mixed> $dataSource
     *
     * @return array<mixed>
     */
    public function prepareDataSource(array $dataSource): array
    {
        if (isset($dataSource['data']['items'])) {
            $pattern = '<span style="font-weight: 600; color: %s">%s</span>';
            foreach ($dataSource['data']['items'] as &$item) {
                $item['is_active'] = ($item['is_active']) ?
                    sprintf($pattern, 'green', 'Yes') :
                    sprintf($pattern, 'red', 'No');
            }
        }

        return $dataSource;
    }
}
