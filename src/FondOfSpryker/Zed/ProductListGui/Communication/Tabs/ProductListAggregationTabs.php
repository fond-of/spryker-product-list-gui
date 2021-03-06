<?php

namespace FondOfSpryker\Zed\ProductListGui\Communication\Tabs;

use Generated\Shared\Transfer\TabItemTransfer;
use Generated\Shared\Transfer\TabsViewTransfer;
use Spryker\Zed\ProductListGui\Communication\Tabs\ProductListAggregationTabs as BaseProductListAggregationTabs;

class ProductListAggregationTabs extends BaseProductListAggregationTabs
{
    const CUSTOMERS_TAB_NAME = 'product_list_customer_relation';
    const CUSTOMERS_TAB_TITLE = 'Assign Customers';
    const CUSTOMERS_TAB_TEMPLATE = '@ProductListGui/_partials/_tabs/product-list-customer-relation.twig';

    const COMPANIES_TAB_NAME = 'product_list_company_relation';
    const COMPANIES_TAB_TITLE = 'Assign Companies';
    const COMPANIES_TAB_TEMPLATE = '@ProductListGui/_partials/_tabs/product-list-company-relation.twig';

    /**
     * @param \Generated\Shared\Transfer\TabsViewTransfer $tabsViewTransfer
     *
     * @return \Generated\Shared\Transfer\TabsViewTransfer
     */
    protected function build(TabsViewTransfer $tabsViewTransfer): TabsViewTransfer
    {
        $tabsViewTransfer = parent::build($tabsViewTransfer);

        $this->addProductListCustomerRelationTab($tabsViewTransfer);
        $this->addProductListCompanyRelationTab($tabsViewTransfer);

        return $tabsViewTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\TabsViewTransfer $tabsViewTransfer
     *
     * @return $this
     */
    protected function addProductListCustomerRelationTab(TabsViewTransfer $tabsViewTransfer): self
    {
        $tabItemTransfer = new TabItemTransfer();
        $tabItemTransfer
            ->setName(static::CUSTOMERS_TAB_NAME)
            ->setTitle(static::CUSTOMERS_TAB_TITLE)
            ->setTemplate(static::CUSTOMERS_TAB_TEMPLATE);

        $tabsViewTransfer->addTab($tabItemTransfer);

        return $this;
    }

    /**
     * @param \Generated\Shared\Transfer\TabsViewTransfer $tabsViewTransfer
     *
     * @return $this
     */
    protected function addProductListCompanyRelationTab(TabsViewTransfer $tabsViewTransfer): self
    {
        $tabItemTransfer = new TabItemTransfer();
        $tabItemTransfer
            ->setName(static::COMPANIES_TAB_NAME)
            ->setTitle(static::COMPANIES_TAB_TITLE)
            ->setTemplate(static::COMPANIES_TAB_TEMPLATE);

        $tabsViewTransfer->addTab($tabItemTransfer);

        return $this;
    }
}
