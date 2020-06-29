<?php

namespace FondOfSpryker\Zed\ProductListGui\Communication\Table;

use Orm\Zed\Customer\Persistence\SpyCustomerQuery;
use Orm\Zed\ProductList\Persistence\Map\SpyProductListCompanyTableMap;
use Spryker\Zed\PropelOrm\Business\Runtime\ActiveQuery\Criteria;

class AvailableCustomerTable extends AbstractCustomerTable
{
    protected const DEFAULT_URL = 'availableCustomerTable';
    protected const TABLE_IDENTIFIER = self::DEFAULT_URL;

    /**
     * @param \Orm\Zed\Customer\Persistence\SpyCustomerQuery $spyCustomerQuery
     *
     * @return \Orm\Zed\Customer\Persistence\SpyCustomerQuery
     */
    protected function filterQuery(SpyCustomerQuery $spyCustomerQuery): SpyCustomerQuery
    {
        if ($this->getIdProductList()) {
            if ($this->getIdProductList()) {
                $spyCustomerQuery
                    ->useSpyProductListCustomerQuery(SpyProductListCompanyTableMap::TABLE_NAME, Criteria::LEFT_JOIN)
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
        }

        return $spyCustomerQuery;
    }
}
