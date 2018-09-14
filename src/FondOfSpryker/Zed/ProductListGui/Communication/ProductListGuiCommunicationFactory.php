<?php

namespace FondOfSpryker\Zed\ProductListGui\Communication;

use FondOfSpryker\Zed\ProductListGui\Communication\Form\DataProvider\ProductListAggregateFormDataProvider;
use FondOfSpryker\Zed\ProductListGui\Communication\Form\DataProvider\ProductListCompanyRelationFormDataProvider;
use FondOfSpryker\Zed\ProductListGui\Communication\Form\DataProvider\ProductListCustomerRelationFormDataProvider;
use FondOfSpryker\Zed\ProductListGui\Communication\Form\ProductListAggregateFormType;
use FondOfSpryker\Zed\ProductListGui\Communication\Table\AssignedCompanyTable;
use FondOfSpryker\Zed\ProductListGui\Communication\Table\AssignedCustomerTable;
use FondOfSpryker\Zed\ProductListGui\Communication\Table\AvailableCompanyTable;
use FondOfSpryker\Zed\ProductListGui\Communication\Table\AvailableCustomerTable;
use FondOfSpryker\Zed\ProductListGui\Communication\Tabs\AssignedCompanyRelationTabs;
use FondOfSpryker\Zed\ProductListGui\Communication\Tabs\AssignedCustomerRelationTabs;
use FondOfSpryker\Zed\ProductListGui\Communication\Tabs\AvailableCompanyRelationTabs;
use FondOfSpryker\Zed\ProductListGui\Communication\Tabs\AvailableCustomerRelationTabs;
use FondOfSpryker\Zed\ProductListGui\Communication\Tabs\ProductListAggregationTabs;
use FondOfSpryker\Zed\ProductListGui\ProductListGuiDependencyProvider;
use Generated\Shared\Transfer\ProductListAggregateFormTransfer;
use Orm\Zed\Company\Persistence\SpyCompanyQuery;
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
     * @return \FondOfSpryker\Zed\ProductListGui\Communication\Table\AvailableCompanyTable
     */
    public function createAvailableCompanyTable(): AvailableCompanyTable
    {
        return new AvailableCompanyTable($this->getCompanyPropelQuery());
    }

    /**
     * @return \FondOfSpryker\Zed\ProductListGui\Communication\Table\AssignedCustomerTable
     */
    public function createAssignedCustomerTable(): AssignedCustomerTable
    {
        return new AssignedCustomerTable($this->getCustomerPropelQuery());
    }

    /**
     * @return \FondOfSpryker\Zed\ProductListGui\Communication\Table\AssignedCompanyTable
     */
    public function createAssignedCompanyTable(): AssignedCompanyTable
    {
        return new AssignedCompanyTable($this->getCompanyPropelQuery());
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
    public function createAvailableCompanyRelationTabs(): TabsInterface
    {
        return new AvailableCompanyRelationTabs();
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
    public function createAssignedCompanyRelationTabs(): TabsInterface
    {
        return new AssignedCompanyRelationTabs();
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
     * @return \Orm\Zed\Company\Persistence\SpyCompanyQuery
     */
    public function getCompanyPropelQuery(): SpyCompanyQuery
    {
        return $this->getProvidedDependency(ProductListGuiDependencyProvider::PROPEL_QUERY_COMPANY);
    }

    /**
     * @return \FondOfSpryker\Zed\ProductListGui\Communication\Form\DataProvider\ProductListCustomerRelationFormDataProvider
     */
    public function createProductListCustomerRelationFormDataProvider(): ProductListCustomerRelationFormDataProvider
    {
        return new ProductListCustomerRelationFormDataProvider(
            $this->getProductListFacade()
        );
    }

    /**
     * @return \FondOfSpryker\Zed\ProductListGui\Communication\Form\DataProvider\ProductListCompanyRelationFormDataProvider
     */
    public function createProductListCompanyRelationFormDataProvider(): ProductListCompanyRelationFormDataProvider
    {
        return new ProductListCompanyRelationFormDataProvider(
            $this->getProductListFacade()
        );
    }

    /**
     * @return \Spryker\Zed\ProductListGui\Communication\Form\DataProvider\ProductListAggregateFormDataProvider
     */
    public function createProductListAggregateFormDataProvider()
    {
        return new ProductListAggregateFormDataProvider(
            $this->createProductListFormDataProvider(),
            $this->createProductListCategoryRelationFormDataProvider(),
            $this->createProductListCustomerRelationFormDataProvider(),
            $this->createProductListCompanyRelationFormDataProvider(),
            $this->getProductListOwnerTypeFormExpanderPlugins()
        );
    }
}
