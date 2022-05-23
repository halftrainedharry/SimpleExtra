<?php

namespace SimpleExtra\Processors\Item;

use MODX\Revolution\Processors\Model\RemoveProcessor;
use SimpleExtra\Model\Item;

class Remove extends RemoveProcessor
{
    public $classKey = Item::class;
    public $objectType = 'simpleextra.item';
}