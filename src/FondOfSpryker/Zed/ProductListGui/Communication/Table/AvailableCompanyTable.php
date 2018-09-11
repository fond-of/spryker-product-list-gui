<?php

namespace FondOfSpryker\Zed\ProductListGui\Communication\Table;

use Orm\Zed\Company\Persistence\SpyCompanyQuery;
use Spryker\Zed\PropelOrm\Business\Runtime\ActiveQuery\Criteria;

class AvailableCompanyTable extends AbstractCompanyTable
{
    protected const DEFAULT_URL = 'availableCompanyTable';
    protected const TABLE_IDENTIFIER = self::DEFAULT_URL;

    /**
     * @param \Orm\Zed\Company\Persistence\SpyCompanyQuery $spyCompanyQuery
     *
     * @return \Orm\Zed\Company\Persistence\SpyCompanyQuery
     */
    protected function filterQuery(SpyCompanyQuery $spyCompanyQuery): SpyCompanyQuery
    {
        if ($this->getIdProductList()) {
            $spyCompanyQuery
                ->useSpyProductListCompanyQuery(null, Criteria::LEFT_JOIN)
                    ->filterByFkProductList($this->getIdProductList(), Criteria::NOT_IN)
                    ->_or()
                    ->filterByFkProductList(null, Criteria::ISNULL)
                ->endUse()
                ->distinct();
        }

        return $spyCompanyQuery;
    }
}
