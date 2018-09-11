<?php

namespace FondOfSpryker\Zed\ProductListGui\Communication\Table;

use Orm\Zed\Company\Persistence\SpyCompanyQuery;

class AssignedCompanyTable extends AbstractCompanyTable
{
    protected const DEFAULT_URL = 'assignedCompanyTable';
    protected const TABLE_IDENTIFIER = self::DEFAULT_URL;

    /**
     * @param \Orm\Zed\Company\Persistence\SpyCompanyQuery $spyCompanyQuery
     *
     * @return \Orm\Zed\Company\Persistence\SpyCompanyQuery
     */
    protected function filterQuery(SpyCompanyQuery $spyCompanyQuery): SpyCompanyQuery
    {
        $spyCompanyQuery
            ->useSpyProductListCompanyQuery()
                ->filterByFkProductList($this->getIdProductList())
            ->endUse();

        return $spyCompanyQuery;
    }
}
