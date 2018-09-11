<?php

namespace FondOfSpryker\Zed\ProductListGui\Communication\Form\DataProvider;

use Generated\Shared\Transfer\ProductListCompanyRelationTransfer;
use Generated\Shared\Transfer\ProductListTransfer;
use Spryker\Zed\ProductListGui\Dependency\Facade\ProductListGuiToProductListFacadeInterface;

class ProductListCompanyRelationFormDataProvider
{
    /**
     * @var \Spryker\Zed\ProductListGui\Dependency\Facade\ProductListGuiToProductListFacadeInterface
     */
    protected $productListFacade;

    /**
     * @param \Spryker\Zed\ProductListGui\Dependency\Facade\ProductListGuiToProductListFacadeInterface $productListFacade
     */
    public function __construct(
        ProductListGuiToProductListFacadeInterface $productListFacade
    ) {
        $this->productListFacade = $productListFacade;
    }

    /**
     * @param int|null $idProductList
     *
     * @return \Generated\Shared\Transfer\ProductListCompanyRelationTransfer
     */
    public function getData(?int $idProductList = null): ProductListCompanyRelationTransfer
    {
        $productListCompanyRelationTransfer = new ProductListCompanyRelationTransfer();

        if (!$idProductList) {
            return $productListCompanyRelationTransfer;
        }

        $productListTransfer = (new ProductListTransfer())->setIdProductList($idProductList);
        $productListCompanyRelationTransfer = $this->productListFacade
            ->getProductListById($productListTransfer)
            ->getProductListCompanyRelation();

        $productListCompanyRelationTransfer->setIdProductList($productListTransfer->getIdProductList());

        return $productListCompanyRelationTransfer;
    }
}
