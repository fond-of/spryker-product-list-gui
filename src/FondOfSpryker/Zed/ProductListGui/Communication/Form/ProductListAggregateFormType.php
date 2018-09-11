<?php

namespace FondOfSpryker\Zed\ProductListGui\Communication\Form;

use Generated\Shared\Transfer\ProductListAggregateFormTransfer;
use Spryker\Zed\ProductListGui\Communication\Form\ProductListAggregateFormType as BaseProductListAggregateFormType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

/**
 * @method \FondOfSpryker\Zed\ProductListGui\Communication\ProductListGuiCommunicationFactory getFactory()
 */
class ProductListAggregateFormType extends BaseProductListAggregateFormType
{
    public const FIELD_ASSIGNED_CUSTOMER_IDS = ProductListAggregateFormTransfer::ASSIGNED_CUSTOMER_IDS;
    public const FIELD_CUSTOMER_IDS_TO_BE_ASSIGNED = ProductListAggregateFormTransfer::CUSTOMER_IDS_TO_BE_ASSIGNED;
    public const FIELD_CUSTOMER_IDS_TO_BE_DEASSIGNED = ProductListAggregateFormTransfer::CUSTOMER_IDS_TO_BE_DE_ASSIGNED;

    public const FIELD_ASSIGNED_COMPANY_IDS = ProductListAggregateFormTransfer::ASSIGNED_COMPANY_IDS;
    public const FIELD_COMPANY_IDS_TO_BE_ASSIGNED = ProductListAggregateFormTransfer::COMPANY_IDS_TO_BE_ASSIGNED;
    public const FIELD_COMPANY_IDS_TO_BE_DEASSIGNED = ProductListAggregateFormTransfer::COMPANY_IDS_TO_BE_DE_ASSIGNED;

    /**
     * @param \Symfony\Component\OptionsResolver\OptionsResolver $resolver
     *
     * @return void
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        parent::configureOptions($resolver);

        if (count($this->getFactory()->getProductListOwnerTypeFormExpanderPlugins()) > 0) {
            return;
        }

        $resolver->remove(static::OPTION_OWNER_TYPE);
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     * @param array $options
     *
     * @return void
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $this->addAssignedCustomerIdsField($builder)
            ->addCustomerIdsToBeAssignedField($builder)
            ->addCustomerIdsToBeDeassignedField($builder)
            ->addProductListCustomerRelationSubForm($builder)
            ->addAssignedCompanyIdsField($builder)
            ->addCompanyIdsToBeAssignedField($builder)
            ->addCompanyIdsToBeDeassignedField($builder)
            ->addProductListCompanyRelationSubForm($builder);

        parent::buildForm($builder, $options);
    }

    /**
     * @param \Symfony\Component\Form\FormEvent $formEvent
     *
     * @return void
     */
    public function onPreSubmit(FormEvent $formEvent): void
    {
        parent::onPreSubmit($formEvent);

        $data = $formEvent->getData();

        $assignedCustomerIds = $data[static::FIELD_ASSIGNED_CUSTOMER_IDS]
            ? preg_split('/,/', $data[static::FIELD_ASSIGNED_CUSTOMER_IDS], null, PREG_SPLIT_NO_EMPTY)
            : [];
        $customerIdsToBeAssigned = $data[static::FIELD_CUSTOMER_IDS_TO_BE_ASSIGNED]
            ? preg_split('/,/', $data[static::FIELD_CUSTOMER_IDS_TO_BE_ASSIGNED], null, PREG_SPLIT_NO_EMPTY)
            : [];
        $customerIdsToBeDeassigned = $data[static::FIELD_CUSTOMER_IDS_TO_BE_DEASSIGNED]
            ? preg_split('/,/', $data[static::FIELD_CUSTOMER_IDS_TO_BE_DEASSIGNED], null, PREG_SPLIT_NO_EMPTY)
            : [];

        $assignedCustomerIds = array_unique(array_merge($assignedCustomerIds, $customerIdsToBeAssigned));
        $assignedCustomerIds = array_diff($assignedCustomerIds, $customerIdsToBeDeassigned);
        $data[ProductListAggregateFormTransfer::PRODUCT_LIST_CUSTOMER_RELATION][ProductListCustomerRelationFormType::CUSTOMER_IDS] = $assignedCustomerIds;

        $assignedCompanyIds = $data[static::FIELD_ASSIGNED_COMPANY_IDS]
            ? preg_split('/,/', $data[static::FIELD_ASSIGNED_COMPANY_IDS], null, PREG_SPLIT_NO_EMPTY)
            : [];
        $companyIdsToBeAssigned = $data[static::FIELD_COMPANY_IDS_TO_BE_ASSIGNED]
            ? preg_split('/,/', $data[static::FIELD_COMPANY_IDS_TO_BE_ASSIGNED], null, PREG_SPLIT_NO_EMPTY)
            : [];
        $companyIdsToBeDeassigned = $data[static::FIELD_COMPANY_IDS_TO_BE_DEASSIGNED]
            ? preg_split('/,/', $data[static::FIELD_COMPANY_IDS_TO_BE_DEASSIGNED], null, PREG_SPLIT_NO_EMPTY)
            : [];

        $assignedCompanyIds = array_unique(array_merge($assignedCompanyIds, $companyIdsToBeAssigned));
        $assignedCompanyIds = array_diff($assignedCompanyIds, $companyIdsToBeDeassigned);
        $data[ProductListAggregateFormTransfer::PRODUCT_LIST_COMPANY_RELATION][ProductListCompanyRelationFormType::COMPANY_IDS] = $assignedCompanyIds;

        $formEvent->setData($data);
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     * @param array $options
     *
     * @return $this
     */
    protected function addOwnerTypeField($builder, $options): parent
    {
        if (!$this->canAddOwnerTypeField()) {
            return $this;
        }

        $builder->add(ProductListAggregateFormTransfer::OWNER_TYPE, ChoiceType::class, [
            'label' => 'Owner Type',
            'required' => true,
            'choices' => $options[static::OPTION_OWNER_TYPE],
            'constraints' => [
                new NotBlank(),
            ],
        ]);

        return $this;
    }

    /**
     * @return bool
     */
    protected function canAddOwnerTypeField(): bool
    {
        return count($this->getFactory()->getProductListOwnerTypeFormExpanderPlugins()) > 0;
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     *
     * @return $this
     */
    protected function addAssignedCustomerIdsField(FormBuilderInterface $builder): self
    {
        $builder->add(
            static::FIELD_ASSIGNED_CUSTOMER_IDS,
            HiddenType::class
        );

        return $this;
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     *
     * @return $this
     */
    protected function addCustomerIdsToBeAssignedField(FormBuilderInterface $builder): self
    {
        $builder->add(
            static::FIELD_CUSTOMER_IDS_TO_BE_ASSIGNED,
            HiddenType::class
        );

        return $this;
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     *
     * @return $this
     */
    protected function addCustomerIdsToBeDeassignedField(FormBuilderInterface $builder): self
    {
        $builder->add(
            static::FIELD_CUSTOMER_IDS_TO_BE_DEASSIGNED,
            HiddenType::class
        );

        return $this;
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     *
     * @return $this
     */
    protected function addProductListCustomerRelationSubForm(FormBuilderInterface $builder): self
    {
        $builder->add(
            ProductListAggregateFormTransfer::PRODUCT_LIST_CUSTOMER_RELATION,
            ProductListCustomerRelationFormType::class
        );

        return $this;
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     *
     * @return $this
     */
    protected function addAssignedCompanyIdsField(FormBuilderInterface $builder): self
    {
        $builder->add(
            static::FIELD_ASSIGNED_COMPANY_IDS,
            HiddenType::class
        );

        return $this;
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     *
     * @return $this
     */
    protected function addCompanyIdsToBeAssignedField(FormBuilderInterface $builder): self
    {
        $builder->add(
            static::FIELD_COMPANY_IDS_TO_BE_ASSIGNED,
            HiddenType::class
        );

        return $this;
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     *
     * @return $this
     */
    protected function addCompanyIdsToBeDeassignedField(FormBuilderInterface $builder): self
    {
        $builder->add(
            static::FIELD_COMPANY_IDS_TO_BE_DEASSIGNED,
            HiddenType::class
        );

        return $this;
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     *
     * @return $this
     */
    protected function addProductListCompanyRelationSubForm(FormBuilderInterface $builder): self
    {
        $builder->add(
            ProductListAggregateFormTransfer::PRODUCT_LIST_COMPANY_RELATION,
            ProductListCompanyRelationFormType::class
        );

        return $this;
    }
}
