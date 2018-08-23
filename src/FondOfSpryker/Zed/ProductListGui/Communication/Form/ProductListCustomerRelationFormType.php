<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace FondOfSpryker\Zed\ProductListGui\Communication\Form;

use Generated\Shared\Transfer\ProductListCustomerRelationTransfer;

use Spryker\Zed\Kernel\Communication\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductListCustomerRelationFormType extends AbstractType
{
    public const FIELD_ID_PRODUCT_LIST = ProductListCustomerRelationTransfer::ID_PRODUCT_LIST;
    public const CUSTOMER_IDS = ProductListCustomerRelationTransfer::CUSTOMER_IDS;
    public const FIELD_FILE_UPLOAD = 'customers_upload';
    public const BLOCK_PREFIX = 'productListCustomerRelationTransfer';

    /**
     * @param \Symfony\Component\OptionsResolver\OptionsResolver $resolver
     *
     * @return void
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);

        $resolver->setDefaults([
            'data_class' => ProductListCustomerRelationTransfer::class,
            'label' => false,
        ]);
    }

    /**
     * @return string
     */
    public function getBlockPrefix(): string
    {
        return static::BLOCK_PREFIX;
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     * @param array $options
     *
     * @return void
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $this->addIdProductListField($builder)
            //->addUploadFileField($builder)
            ->addCustomerIdsField($builder);
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     *
     * @return $this
     */
    protected function addIdProductListField(FormBuilderInterface $builder): self
    {
        $builder->add(
            static::FIELD_ID_PRODUCT_LIST,
            HiddenType::class
        );

        return $this;
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     *
     * @return $this
     */
    protected function addCustomerIdsField(FormBuilderInterface $builder): self
    {
        $builder->add(static::CUSTOMER_IDS, HiddenType::class);

        return $this;
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     *
     * @return $this
     */
    protected function addUploadFileField(FormBuilderInterface $builder): self
    {
        $builder->add(static::FIELD_FILE_UPLOAD, FileType::class, [
            'label' => 'Import Product List',
            'required' => false,
            'mapped' => false,
        ]);

        return $this;
    }
}
