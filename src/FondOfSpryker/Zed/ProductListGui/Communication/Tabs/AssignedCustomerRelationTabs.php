<?php

namespace FondOfSpryker\Zed\ProductListGui\Communication\Tabs;

use Generated\Shared\Transfer\TabItemTransfer;
use Generated\Shared\Transfer\TabsViewTransfer;
use Spryker\Zed\Gui\Communication\Tabs\AbstractTabs;

class AssignedCustomerRelationTabs extends AbstractTabs
{
    protected const ASSIGNED_CUSTOMER_TAB_NAME = 'assigned_customer';
    protected const ASSIGNED_CUSTOMER_TAB_TITLE = 'Customers in this list';
    protected const ASSIGNED_CUSTOMER_TAB_TEMPLATE = '@ProductListGui/_partials/_tables/assigned-customer-table.twig';

    protected const DEASSIGNED_CUSTOMER_TAB_NAME = 'deassignment_customer';
    protected const DEASSIGNED_CUSTOMER_TAB_TITLE = 'Customers to be deassigned';
    protected const DEASSIGNED_CUSTOMER_TAB_TEMPLATE = '@ProductListGui/_partials/_tables/deassignment-customer-table.twig';

    /**
     * @param \Generated\Shared\Transfer\TabsViewTransfer $tabsViewTransfer
     *
     * @return \Generated\Shared\Transfer\TabsViewTransfer
     */
    protected function build(TabsViewTransfer $tabsViewTransfer): TabsViewTransfer
    {
        $this->addAssignedCustomerTab($tabsViewTransfer)
            ->addDeassignmentCustomerTab($tabsViewTransfer);

        $tabsViewTransfer->setIsNavigable(false);

        return $tabsViewTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\TabsViewTransfer $tabsViewTransfer
     *
     * @return $this
     */
    protected function addAssignedCustomerTab(TabsViewTransfer $tabsViewTransfer)
    {
        $tabItemTransfer = new TabItemTransfer();
        $tabItemTransfer
            ->setName(static::ASSIGNED_CUSTOMER_TAB_NAME)
            ->setTitle(static::ASSIGNED_CUSTOMER_TAB_TITLE)
            ->setTemplate(static::ASSIGNED_CUSTOMER_TAB_TEMPLATE);

        $tabsViewTransfer->addTab($tabItemTransfer);

        return $this;
    }

    /**
     * @param \Generated\Shared\Transfer\TabsViewTransfer $tabsViewTransfer
     *
     * @return $this
     */
    protected function addDeassignmentCustomerTab(TabsViewTransfer $tabsViewTransfer)
    {
        $tabItemTransfer = new TabItemTransfer();
        $tabItemTransfer
            ->setName(static::DEASSIGNED_CUSTOMER_TAB_NAME)
            ->setTitle(static::DEASSIGNED_CUSTOMER_TAB_TITLE)
            ->setTemplate(static::DEASSIGNED_CUSTOMER_TAB_TEMPLATE);

        $tabsViewTransfer->addTab($tabItemTransfer);

        return $this;
    }
}
