<?php

namespace SimpleExtra\Processors\Item;

use MODX\Revolution\Processors\Model\CreateProcessor;
use SimpleExtra\Model\Item;

class Create extends CreateProcessor
{
    public $classKey = Item::class;
    public $objectType = 'simpleextra.item';

    public function beforeSave()
    {
        $name = $this->getProperty('name');
        if (empty($name)) {
            $this->addFieldError('name', 'Name can\'t be empty');
        }
        return parent::beforeSave();
    }
}