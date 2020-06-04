<?php

namespace FondOfSpryker\Zed\ProductListGui\Communication\Table;

use Orm\Zed\Company\Persistence\Map\SpyCompanyTableMap;
use Orm\Zed\Company\Persistence\SpyCompanyQuery;
use Spryker\Service\UtilText\Model\Url\Url;
use Spryker\Zed\Gui\Communication\Table\AbstractTable;
use Spryker\Zed\Gui\Communication\Table\TableConfiguration;
use Spryker\Zed\ProductListGui\Communication\Controller\ProductListAbstractController;

abstract class AbstractCompanyTable extends AbstractTable
{
    protected const DEFAULT_URL = 'table';
    protected const TABLE_IDENTIFIER = 'table';

    protected const COLUMN_ID = SpyCompanyTableMap::COL_ID_COMPANY;
    protected const COLUMN_NAME = SpyCompanyTableMap::COL_NAME;
    protected const COLUMN_ACTION = 'action';

    /**
     * @var \Orm\Zed\Company\Persistence\SpyCompanyQuery
     */
    protected $spyCompanyQuery;

    /**
     * @param \Orm\Zed\Company\Persistence\SpyCompanyQuery $spyCompanyQuery
     */
    public function __construct(SpyCompanyQuery $spyCompanyQuery)
    {
        $this->spyCompanyQuery = $spyCompanyQuery;
        $this->defaultUrl = static::DEFAULT_URL;
        $this->setTableIdentifier(static::TABLE_IDENTIFIER);
    }

    /**
     * @param \Spryker\Zed\Gui\Communication\Table\TableConfiguration $config
     *
     * @return \Spryker\Zed\Gui\Communication\Table\TableConfiguration
     */
    protected function configure(TableConfiguration $config): TableConfiguration
    {
        $config->setHeader([
            static::COLUMN_ID => 'ID',
            static::COLUMN_NAME => 'Name',
            static::COLUMN_ACTION => 'Selected',
        ]);

        $config->setSearchable([
            static::COLUMN_ID,
            static::COLUMN_NAME,
        ]);

        $config->setSortable([
            static::COLUMN_ID,
            static::COLUMN_NAME,
        ]);

        $config->addRawColumn(self::COLUMN_ACTION);
        $config->setUrl($this->getTableUrl($config));

        return $config;
    }

    /**
     * @param \Spryker\Zed\Gui\Communication\Table\TableConfiguration $config
     *
     * @return string
     */
    protected function getTableUrl(TableConfiguration $config): string
    {
        $tableUrl = $config->getUrl() ?? $this->defaultUrl;

        if ($this->getIdProductList()) {
            $tableUrl = Url::generate($tableUrl, [ProductListAbstractController::URL_PARAM_ID_PRODUCT_LIST => $this->getIdProductList()]);
        }

        return $tableUrl;
    }

    /**
     * @param \Spryker\Zed\Gui\Communication\Table\TableConfiguration $config
     *
     * @return array
     */
    protected function prepareData(TableConfiguration $config)
    {
        $spyCompanyQuery = $this->buildQuery();
        $queryResults = $this->runQuery($spyCompanyQuery, $config);
        $results = [];

        foreach ($queryResults as $companyData) {
            $results[] = $this->buildDataRow($companyData);
        }

        unset($queryResults);

        return $results;
    }

    /**
     * @param string[] $company
     *
     * @return string[]
     */
    protected function buildDataRow(array $company): array
    {
        return [
            static::COLUMN_ID => $company[SpyCompanyTableMap::COL_ID_COMPANY],
            static::COLUMN_NAME => $company[SpyCompanyTableMap::COL_NAME],
            static::COLUMN_ACTION => sprintf(
                '<input class="%s-all-companies-checkbox" type="checkbox"  value="%d">',
                static::TABLE_IDENTIFIER,
                $company[SpyCompanyTableMap::COL_ID_COMPANY]
            ),
        ];
    }

    /**
     * @return \Orm\Zed\Company\Persistence\SpyCompanyQuery
     */
    protected function buildQuery(): SpyCompanyQuery
    {
        $this->spyCompanyQuery
            ->select(
                [
                    SpyCompanyTableMap::COL_ID_COMPANY,
                    SpyCompanyTableMap::COL_NAME,
                ]
            );

        return $this->filterQuery($this->spyCompanyQuery);
    }

    /**
     * @return int
     */
    protected function getIdProductList(): int
    {
        return $this->request->query->getInt(ProductListAbstractController::URL_PARAM_ID_PRODUCT_LIST, 0);
    }

    /**
     * @param \Orm\Zed\Company\Persistence\SpyCompanyQuery $spyCompanyQuery
     *
     * @return \Orm\Zed\Company\Persistence\SpyCompanyQuery
     */
    abstract protected function filterQuery(SpyCompanyQuery $spyCompanyQuery): SpyCompanyQuery;
}
