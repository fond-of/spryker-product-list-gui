<?php

namespace FondOfSpryker\Zed\ProductListGui;

use Orm\Zed\Company\Persistence\SpyCompanyQuery;
use Orm\Zed\Customer\Persistence\SpyCustomerQuery;
use Spryker\Zed\Kernel\Container;
use Spryker\Zed\ProductListGui\ProductListGuiDependencyProvider as BaseProductListGuiDependencyProvider;

class ProductListGuiDependencyProvider extends BaseProductListGuiDependencyProvider
{
    const PROPEL_QUERY_CUSTOMER = 'PROPEL_QUERY_CUSTOMER';
    const PROPEL_QUERY_COMPANY = 'PROPEL_QUERY_COMPANY';

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    public function provideCommunicationLayerDependencies(Container $container): Container
    {
        $container = parent::provideCommunicationLayerDependencies($container);

        $container = $this->addCustomerPropelQuery($container);
        $container = $this->addCompanyPropelQuery($container);

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addCustomerPropelQuery(Container $container): Container
    {
        $container[static::PROPEL_QUERY_CUSTOMER] = function () {
            return SpyCustomerQuery::create();
        };

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addCompanyPropelQuery(Container $container): Container
    {
        $container[static::PROPEL_QUERY_COMPANY] = function () {
            return SpyCompanyQuery::create();
        };

        return $container;
    }
}
