<?php

namespace FondOfSpryker\Zed\ProductListGui\Communication\Form\DataProvider;

use Generated\Shared\Transfer\ProductListAggregateFormTransfer;
use Spryker\Zed\ProductListGui\Communication\Form\DataProvider\ProductListAggregateFormDataProvider as BaseProductListAggregateFormDataProvider;
use Spryker\Zed\ProductListGui\Communication\Form\DataProvider\ProductListCategoryRelationFormDataProvider;
use Spryker\Zed\ProductListGui\Communication\Form\DataProvider\ProductListFormDataProvider;

class ProductListAggregateFormDataProvider extends BaseProductListAggregateFormDataProvider
{
    /**
     * @var \FondOfSpryker\Zed\ProductListGui\Communication\Form\DataProvider\ProductListCustomerRelationFormDataProvider
     */
    protected $productListCustomerRelationFormDataProvider;

    /**
     * @var \FondOfSpryker\Zed\ProductListGui\Communication\Form\DataProvider\ProductListCompanyRelationFormDataProvider
     */
    protected $productListCompanyRelationFormDataProvider;

    /**
     * @param \Spryker\Zed\ProductListGui\Communication\Form\DataProvider\ProductListFormDataProvider $productListFormDataProvider
     * @param \Spryker\Zed\ProductListGui\Communication\Form\DataProvider\ProductListCategoryRelationFormDataProvider $productListCategoryRelationFormDataProvider
     * @param \FondOfSpryker\Zed\ProductListGui\Communication\Form\DataProvider\ProductListCustomerRelationFormDataProvider $productListCustomerRelationFormDataProvider
     * @param \FondOfSpryker\Zed\ProductListGui\Communication\Form\DataProvider\ProductListCompanyRelationFormDataProvider $productListCompanyRelationFormDataProvider
     * @param \Spryker\Zed\ProductListGuiExtension\Dependency\Plugin\ProductListOwnerTypeFormExpanderPluginInterface[] $productListOwnerTypeFormExpanderPlugins
     */
    public function __construct(
        ProductListFormDataProvider $productListFormDataProvider,
        ProductListCategoryRelationFormDataProvider $productListCategoryRelationFormDataProvider,
        ProductListCustomerRelationFormDataProvider $productListCustomerRelationFormDataProvider,
        ProductListCompanyRelationFormDataProvider $productListCompanyRelationFormDataProvider,
        array $productListOwnerTypeFormExpanderPlugins = []
    ) {
        parent::__construct(
            $productListFormDataProvider,
            $productListCategoryRelationFormDataProvider,
            $productListOwnerTypeFormExpanderPlugins
        );

        $this->productListCustomerRelationFormDataProvider = $productListCustomerRelationFormDataProvider;
        $this->productListCompanyRelationFormDataProvider = $productListCompanyRelationFormDataProvider;
    }

    /**
     * @param int|null $idProductList
     *
     * @return \Generated\Shared\Transfer\ProductListAggregateFormTransfer
     */
    public function getData(?int $idProductList = null): ProductListAggregateFormTransfer
    {
        $aggregateFormTransfer = parent::getData($idProductList);

        $assignedCustomerIds = [];
        $productListCustomerRelationTransfer = $this->productListCustomerRelationFormDataProvider->getData($idProductList);

        if ($productListCustomerRelationTransfer->getCustomerIds()) {
            foreach ($productListCustomerRelationTransfer->getCustomerIds() as $customerId) {
                $assignedCustomerIds[] = $customerId;
            }
        }

        $aggregateFormTransfer = $this->setAssignedCustomers($aggregateFormTransfer, $assignedCustomerIds);

        $assignedCompanyIds = [];
        $productListCompanyRelationTransfer = $this->productListCompanyRelationFormDataProvider->getData($idProductList);

        if ($productListCompanyRelationTransfer->getCompanyIds()) {
            foreach ($productListCompanyRelationTransfer->getCompanyIds() as $companyId) {
                $assignedCompanyIds[] = $companyId;
            }
        }

        $aggregateFormTransfer = $this->setAssignedCompanies($aggregateFormTransfer, $assignedCompanyIds);

        return $aggregateFormTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\ProductListAggregateFormTransfer $aggregateFormTransfer
     * @param int[] $assignedCustomerIds
     *
     * @return \Generated\Shared\Transfer\ProductListAggregateFormTransfer
     */
    protected function setAssignedCustomers(
        ProductListAggregateFormTransfer $aggregateFormTransfer,
        array $assignedCustomerIds
    ): ProductListAggregateFormTransfer {
        $aggregateFormTransfer->setAssignedCustomerIds(implode(',', $assignedCustomerIds));

        return $aggregateFormTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\ProductListAggregateFormTransfer $aggregateFormTransfer
     * @param int[] $assignedCompanyIds
     *
     * @return \Generated\Shared\Transfer\ProductListAggregateFormTransfer
     */
    protected function setAssignedCompanies(
        ProductListAggregateFormTransfer $aggregateFormTransfer,
        array $assignedCompanyIds
    ): ProductListAggregateFormTransfer {
        $aggregateFormTransfer->setAssignedCompanyIds(implode(',', $assignedCompanyIds));

        return $aggregateFormTransfer;
    }
}
