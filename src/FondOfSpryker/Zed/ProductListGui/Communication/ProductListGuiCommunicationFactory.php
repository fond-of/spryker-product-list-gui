<?php

namespace FondOfSpryker\Zed\ProductListGui\Communication;

use FondOfSpryker\Zed\ProductListGui\Communication\Form\DataProvider\ProductListAggregateFormDataProvider;
use FondOfSpryker\Zed\ProductListGui\Communication\Form\ProductListAggregateFormType;
use FondOfSpryker\Zed\ProductListGui\Communication\Table\AssignedCustomerTable;
use FondOfSpryker\Zed\ProductListGui\Communication\Table\AvailableCustomerTable;
use FondOfSpryker\Zed\ProductListGui\Communication\Tabs\AssignedCustomerRelationTabs;
use FondOfSpryker\Zed\ProductListGui\Communication\Tabs\AvailableCustomerRelationTabs;
use FondOfSpryker\Zed\ProductListGui\Communication\Tabs\ProductListAggregationTabs;
use FondOfSpryker\Zed\ProductListGui\ProductListGuiDependencyProvider;
use Generated\Shared\Transfer\ProductListAggregateFormTransfer;
use Orm\Zed\Customer\Persistence\SpyCustomerQuery;
use Spryker\Zed\Gui\Communication\Tabs\TabsInterface;
use Spryker\Zed\ProductListGui\Communication\ProductListGuiCommunicationFactory as BaseProductListGuiCommunicationFactory;
use Symfony\Component\Form\FormInterface;

class ProductListGuiCommunicationFactory extends BaseProductListGuiCommunicationFactory
{
    /**
     * @param \Generated\Shared\Transfer\ProductListAggregateFormTransfer|null $productListAggregateFormTransfer
     * @param array $options
     *
     * @return \Symfony\Component\Form\FormInterface
     */
    public function getProductListAggregateForm(
        ?ProductListAggregateFormTransfer $productListAggregateFormTransfer = null,
        array $options = []
    ): FormInterface {
        return $this
            ->getFormFactory()
            ->create(
                ProductListAggregateFormType::class,
                $productListAggregateFormTransfer,
                $options
            );
    }

    /**
     * @return \FondOfSpryker\Zed\ProductListGui\Communication\Table\AvailableCustomerTable
     */
    public function createAvailableCustomerTable(): AvailableCustomerTable
    {
        return new AvailableCustomerTable($this->getCustomerPropelQuery());
    }

    /**
     * @return \FondOfSpryker\Zed\ProductListGui\Communication\Table\AssignedCustomerTable
     */
    public function createAssignedCustomerTable(): AssignedCustomerTable
    {
        return new AssignedCustomerTable($this->getCustomerPropelQuery());
    }

    /**
     * @return \Spryker\Zed\Gui\Communication\Tabs\TabsInterface
     */
    public function createAvailableCustomerRelationTabs(): TabsInterface
    {
        return new AvailableCustomerRelationTabs();
    }

    /**
     * @return \Spryker\Zed\Gui\Communication\Tabs\TabsInterface
     */
    public function createAssignedCustomerRelationTabs(): TabsInterface
    {
        return new AssignedCustomerRelationTabs();
    }

    /**
     * @return \Spryker\Zed\Gui\Communication\Tabs\TabsInterface
     */
    public function createProductListAggregationTabs(): TabsInterface
    {
        return new ProductListAggregationTabs();
    }

    /**
     * @return \Orm\Zed\Customer\Persistence\SpyCustomerQuery
     */
    public function getCustomerPropelQuery(): SpyCustomerQuery
    {
        return $this->getProvidedDependency(ProductListGuiDependencyProvider::PROPEL_QUERY_CUSTOMER);
    }

    /**
     * @return \Spryker\Zed\ProductListGui\Communication\Form\DataProvider\ProductListAggregateFormDataProvider
     */
    public function createProductListAggregateFormDataProvider()
    {
        return new ProductListAggregateFormDataProvider(
            $this->createProductListFormDataProvider(),
            $this->createProductListCategoryRelationFormDataProvider(),
            $this->getProductListOwnerTypeFormExpanderPlugins()
        );
    }
}
