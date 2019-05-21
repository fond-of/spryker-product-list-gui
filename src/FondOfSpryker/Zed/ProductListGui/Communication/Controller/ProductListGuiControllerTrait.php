<?php

namespace FondOfSpryker\Zed\ProductListGui\Communication\Controller;

use Generated\Shared\Transfer\ProductListTransfer;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * @method \FondOfSpryker\Zed\ProductListGui\Communication\ProductListGuiCommunicationFactory getFactory()
 */
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
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function availableCompanyTableAction(): JsonResponse
    {
        $availableCompanyTable = $this->getFactory()->createAvailableCompanyTable();

        return $this->jsonResponse(
            $availableCompanyTable->fetchData()
        );
    }

    /**
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function assignedCompanyTableAction(): JsonResponse
    {
        $assignedCompanyTable = $this->getFactory()->createAssignedCompanyTable();

        return $this->jsonResponse(
            $assignedCompanyTable->fetchData()
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

        $assignedCompanyRelationTabs = $this->getFactory()->createAssignedCompanyRelationTabs();
        $availableCompanyRelationTabs = $this->getFactory()->createAvailableCompanyRelationTabs();

        $availableCompanyTable = $this->getFactory()->createAvailableCompanyTable();
        $assignedCompanyTable = $this->getFactory()->createAssignedCompanyTable();

        return array_merge(
            $templateVariables,
            [
                'availableCustomerRelationTabs' => $availableCustomerRelationTabs->createView(),
                'assignedCustomerRelationTabs' => $assignedCustomerRelationTabs->createView(),
                'availableCustomerTable' => $availableCustomerTable->render(),
                'assignedCustomerTable' => $assignedCustomerTable->render(),
                'availableCompanyRelationTabs' => $availableCompanyRelationTabs->createView(),
                'assignedCompanyRelationTabs' => $assignedCompanyRelationTabs->createView(),
                'availableCompanyTable' => $availableCompanyTable->render(),
                'assignedCompanyTable' => $assignedCompanyTable->render(),
            ]
        );
    }

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @param \Symfony\Component\Form\FormInterface $aggregateForm
     *
     * @return \Generated\Shared\Transfer\ProductListTransfer|null
     */
    protected function findProductListTransfer(
        Request $request,
        FormInterface $aggregateForm
    ): ?ProductListTransfer {
        $productListTransfer = parent::findProductListTransfer($request, $aggregateForm);

        if ($productListTransfer === null) {
            return $productListTransfer;
        }

        /** @var \Generated\Shared\Transfer\ProductListAggregateFormTransfer $aggregateFormTransfer */
        $aggregateFormTransfer = $aggregateForm->getData();

        $productListTransfer->setProductListCustomerRelation(
            $aggregateFormTransfer->getProductListCustomerRelation()
        );

        $productListTransfer->setProductListCompanyRelation(
            $aggregateFormTransfer->getProductListCompanyRelation()
        );

        return $productListTransfer;
    }
}
