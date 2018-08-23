<?php

namespace FondOfSpryker\Zed\ProductListGui\Communication\Form\DataProvider;

use Generated\Shared\Transfer\ProductListAggregateFormTransfer;
use Spryker\Zed\ProductListGui\Communication\Form\DataProvider\ProductListAggregateFormDataProvider as BaseProductListAggregateFormDataProvider;

class ProductListAggregateFormDataProvider extends BaseProductListAggregateFormDataProvider
{
    /**
     * @param int|null $idProductList
     *
     * @return \Generated\Shared\Transfer\ProductListAggregateFormTransfer
     */
    public function getData(?int $idProductList = null): ProductListAggregateFormTransfer
    {
        $aggregateFormTransfer = parent::getData($idProductList);

        $assignedCustomerIds = [];
        $productListTransfer = $aggregateFormTransfer->getProductList();

        $productListCustomerRelationTransfer = $productListTransfer->getProductListCustomerRelation();

        if ($productListCustomerRelationTransfer && $productListCustomerRelationTransfer->getCustomerIds()) {
            foreach ($productListCustomerRelationTransfer->getCustomerIds() as $customerId) {
                $assignedCustomerIds[] = $customerId;
            }
        }

        $aggregateFormTransfer = $this->setAssignedCustomers($aggregateFormTransfer, $assignedCustomerIds);

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
}
