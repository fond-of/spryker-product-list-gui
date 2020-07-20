<?php

namespace FondOfSpryker\Zed\ProductListGui\Communication\Table;

use Orm\Zed\Company\Persistence\SpyCompanyQuery;
use Orm\Zed\ProductList\Persistence\Map\SpyProductListCompanyTableMap;
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
                ->useSpyProductListCompanyQuery(SpyProductListCompanyTableMap::TABLE_NAME, Criteria::LEFT_JOIN)
                    ->filterByFkProductList(null, Criteria::ISNULL)
                ->endUse()
                ->addJoinCondition(
                    SpyProductListCompanyTableMap::TABLE_NAME,
                    sprintf(
                        '%s = %d',
                        SpyProductListCompanyTableMap::COL_FK_PRODUCT_LIST,
                        $this->getIdProductList()
                    )
                );
        }

        return $spyCompanyQuery;
    }
}
