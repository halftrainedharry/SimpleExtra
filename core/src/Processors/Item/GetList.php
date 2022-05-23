<?php

namespace SimpleExtra\Processors\Item;

use MODX\Revolution\Processors\Model\GetListProcessor;
use SimpleExtra\Model\Item;
use xPDO\Om\xPDOQuery;

class GetList extends GetListProcessor
{
    public $classKey = Item::class;
    public $defaultSortField = 'name';
    public $defaultSortDirection = 'ASC';
    public $objectType = 'simpleextra.item';

    public function prepareQueryBeforeCount(xPDOQuery $c)
    {
        $query = $this->getProperty('query');
        if (!empty($query)){
            $c->where(
                [
                    'name:LIKE' => '%' . $query . '%',
                    'OR:description:LIKE' => '%' . $query . '%'
                ]
            );
        }
        return $c;
    }
}