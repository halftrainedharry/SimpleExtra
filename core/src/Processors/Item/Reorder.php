<?php

namespace SimpleExtra\Processors\Item;

use MODX\Revolution\Processors\ModelProcessor;
use SimpleExtra\Model\Item;

class Reorder extends ModelProcessor
{
    public $classKey = Item::class;
    public $objectType = 'simpleextra.item';

    public function process()
    {
        $idItem = $this->getProperty('idItem');
        $oldIndex = $this->getProperty('oldIndex');
        $newIndex = $this->getProperty('newIndex');

        $items = $this->modx->newQuery($this->classKey);
        $items->where(
            [
                "id:!=" => $idItem,
                "position:>=" => min($oldIndex, $newIndex),
                "position:<=" => max($oldIndex, $newIndex),
            ]
        );

        $items->sortby('position', 'ASC');

        $itemsCollection = $this->modx->getCollection($this->classKey, $items);

        if (min($oldIndex, $newIndex) == $newIndex) {
            foreach ($itemsCollection as $item) {
                $item->set('position', $item->get('position') + 1);
                $item->save();
            }
        } else {
            foreach ($itemsCollection as $item) {
                $item->set('position', $item->get('position') - 1);
                $item->save();
            }
        }

        $itemObject = $this->modx->getObject($this->classKey, $idItem);
        $itemObject->set('position', $newIndex);
        $itemObject->save();

        return $this->success('', $itemObject);
    }
}