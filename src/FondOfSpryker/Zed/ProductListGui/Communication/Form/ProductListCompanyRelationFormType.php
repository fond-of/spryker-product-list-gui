<?php

namespace FondOfSpryker\Zed\ProductListGui\Communication\Form;

use Generated\Shared\Transfer\ProductListCompanyRelationTransfer;
use Spryker\Zed\Kernel\Communication\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * @method \FondOfSpryker\Zed\ProductListGui\Communication\ProductListGuiCommunicationFactory getFactory()
 */
class ProductListCompanyRelationFormType extends AbstractType
{
    public const FIELD_ID_PRODUCT_LIST = ProductListCompanyRelationTransfer::ID_PRODUCT_LIST;
    public const COMPANY_IDS = ProductListCompanyRelationTransfer::COMPANY_IDS;
    public const FIELD_FILE_UPLOAD = 'companies_upload';
    public const BLOCK_PREFIX = 'productListCompanyRelationTransfer';

    /**
     * @param \Symfony\Component\OptionsResolver\OptionsResolver $resolver
     *
     * @return void
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        parent::configureOptions($resolver);

        $resolver->setDefaults([
            'data_class' => ProductListCompanyRelationTransfer::class,
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
            ->addCompanyIdsField($builder);
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     *
     * @return $this
     */
    protected function addIdProductListField(FormBuilderInterface $builder)
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
    protected function addCompanyIdsField(FormBuilderInterface $builder)
    {
        $builder->add(static::COMPANY_IDS, HiddenType::class);

        return $this;
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     *
     * @return $this
     */
    protected function addUploadFileField(FormBuilderInterface $builder)
    {
        $builder->add(static::FIELD_FILE_UPLOAD, FileType::class, [
            'label' => 'Import Product List',
            'required' => false,
            'mapped' => false,
        ]);

        return $this;
    }
}
