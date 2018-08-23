<?php

namespace FondOfSpryker\Zed\ProductListGui\Communication\Controller;

use Generated\Shared\Transfer\ProductListAggregateFormTransfer;
use Generated\Shared\Transfer\ProductListTransfer;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

trait ProductListGuiControllerTrait
{
    /**
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function availableCustomerTableAction(): JsonResponse
    {
        $availableCustomerTable = $this->getFactory()->createAvailableCustomerTable();

        return $this->jsonResponse(
            $availableCustomerTable->fetchData()
        );
    }

    /**
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function assignedCustomerTableAction(): JsonResponse
    {
        $assignedCustomerTable = $this->getFactory()->createAssignedCustomerTable();

        return $this->jsonResponse(
            $assignedCustomerTable->fetchData()
        );
    }

    /**
     * @param \Symfony\Component\Form\FormInterface $productListAggregateForm
     *
     * @return array
     */
    protected function prepareTemplateVariables(FormInterface $productListAggregateForm): array
    {
        $templateVariables = parent::prepareTemplateVariables($productListAggregateForm);

        $assignedCustomerRelationTabs = $this->getFactory()->createAssignedCustomerRelationTabs();
        $availableCustomerRelationTabs = $this->getFactory()->createAvailableCustomerRelationTabs();

        $availableCustomerTable = $this->getFactory()->createAvailableCustomerTable();
        $assignedCustomerTable = $this->getFactory()->createAssignedCustomerTable();

        return array_merge(
            $templateVariables,
            [
                'availableCustomerRelationTabs' => $availableCustomerRelationTabs->createView(),
                'assignedCustomerRelationTabs' => $assignedCustomerRelationTabs->createView(),
                'availableCustomerTable' => $availableCustomerTable->render(),
                'assignedCustomerTable' => $assignedCustomerTable->render(),
            ]
        );
    }

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @param \Symfony\Component\Form\FormInterface $aggregateForm
     *
     * @return \Generated\Shared\Transfer\ProductListTransfer|null
     */
    protected function handleProductListAggregateForm(
        Request $request,
        FormInterface $aggregateForm
    ): ?ProductListTransfer {
        $aggregateForm->handleRequest($request);

        if (!$aggregateForm->isSubmitted() || !$aggregateForm->isValid()) {
            return null;
        }

        /** @var \Generated\Shared\Transfer\ProductListAggregateFormTransfer $aggregateFormTransfer */
        $aggregateFormTransfer = $aggregateForm->getData();

        $productListTransfer = $aggregateFormTransfer->getProductList();
        $productListTransfer->setProductListCategoryRelation($aggregateFormTransfer->getProductListCategoryRelation());
        $productListTransfer->setProductListProductConcreteRelation(
            $aggregateFormTransfer->getProductListProductConcreteRelation()
        );

        $productListTransfer->setProductListCustomerRelation(
            $aggregateFormTransfer->getProductListCustomerRelation()
        );

        $productListTransfer->setProductListProductConcreteRelation(
            $this->getProductListProductConcreteRelationFromCsv(
                $productListTransfer->getProductListProductConcreteRelation(),
                $aggregateForm->get(ProductListAggregateFormTransfer::PRODUCT_LIST_PRODUCT_CONCRETE_RELATION)
            )
        );

        return $this->storeProductList($productListTransfer);
    }
}
