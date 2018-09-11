<?php

namespace FondOfSpryker\Zed\ProductListGui\Communication\Tabs;

use Generated\Shared\Transfer\TabItemTransfer;
use Generated\Shared\Transfer\TabsViewTransfer;
use Spryker\Zed\Gui\Communication\Tabs\AbstractTabs;

class AssignedCompanyRelationTabs extends AbstractTabs
{
    const ASSIGNED_COMPANY_TAB_NAME = 'assigned_company';
    const ASSIGNED_COMPANY_TAB_TITLE = 'Companies in this list';
    const ASSIGNED_COMPANY_TAB_TEMPLATE = '@ProductListGui/_partials/_tables/assigned-company-table.twig';

    const DEASSIGNED_COMPANY_TAB_NAME = 'deassignment_company';
    const DEASSIGNED_COMPANY_TAB_TITLE = 'Companies to be deassigned';
    const DEASSIGNED_COMPANY_TAB_TEMPLATE = '@ProductListGui/_partials/_tables/deassignment-company-table.twig';

    /**
     * @param \Generated\Shared\Transfer\TabsViewTransfer $tabsViewTransfer
     *
     * @return \Generated\Shared\Transfer\TabsViewTransfer
     */
    protected function build(TabsViewTransfer $tabsViewTransfer)
    {
        $this->addAssignedCompanyTab($tabsViewTransfer)
            ->addDeassignmentCompanyTab($tabsViewTransfer);

        $tabsViewTransfer->setIsNavigable(false);

        return $tabsViewTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\TabsViewTransfer $tabsViewTransfer
     *
     * @return $this
     */
    protected function addAssignedCompanyTab(TabsViewTransfer $tabsViewTransfer): self
    {
        $tabItemTransfer = new TabItemTransfer();
        $tabItemTransfer
            ->setName(static::ASSIGNED_COMPANY_TAB_NAME)
            ->setTitle(static::ASSIGNED_COMPANY_TAB_TITLE)
            ->setTemplate(static::ASSIGNED_COMPANY_TAB_TEMPLATE);

        $tabsViewTransfer->addTab($tabItemTransfer);

        return $this;
    }

    /**
     * @param \Generated\Shared\Transfer\TabsViewTransfer $tabsViewTransfer
     *
     * @return $this
     */
    protected function addDeassignmentCompanyTab(TabsViewTransfer $tabsViewTransfer): self
    {
        $tabItemTransfer = new TabItemTransfer();
        $tabItemTransfer
            ->setName(static::DEASSIGNED_COMPANY_TAB_NAME)
            ->setTitle(static::DEASSIGNED_COMPANY_TAB_TITLE)
            ->setTemplate(static::DEASSIGNED_COMPANY_TAB_TEMPLATE);

        $tabsViewTransfer->addTab($tabItemTransfer);

        return $this;
    }
}
