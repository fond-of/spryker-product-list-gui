<?php

namespace FondOfSpryker\Zed\ProductListGui\Communication\Form\DataProvider;

use Generated\Shared\Transfer\ProductListCustomerRelationTransfer;
use Generated\Shared\Transfer\ProductListTransfer;
use Spryker\Zed\ProductListGui\Dependency\Facade\ProductListGuiToProductListFacadeInterface;

class ProductListCustomerRelationFormDataProvider
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
     * @return \Generated\Shared\Transfer\ProductListCustomerRelationTransfer
     */
    public function getData(?int $idProductList = null): ProductListCustomerRelationTransfer
    {
        $productListCustomerRelationTransfer = new ProductListCustomerRelationTransfer();

        if (!$idProductList) {
            return $productListCustomerRelationTransfer;
        }

        $productListTransfer = (new ProductListTransfer())->setIdProductList($idProductList);
        $productListCustomerRelationTransfer = $this->productListFacade
            ->getProductListById($productListTransfer)
            ->getProductListCustomerRelation();
        $productListCustomerRelationTransfer->setIdProductList($productListTransfer->getIdProductList());

        return $productListCustomerRelationTransfer;
    }
}
