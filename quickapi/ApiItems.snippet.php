<?php
use SimpleExtra\Model\Item;

if ($method === 'GET') {
    $c = $modx->newQuery(Item::class);
    $c->sortby('id', 'DESC');
    $items = $modx->getCollection(Item::class, $c);
    $items_arr = [];
    foreach($items as $item) {
        $item_arr = $item->toArray();
        $items_arr[] = $item_arr;
    }
    $quickapi->setResponse(true, ['results' => $items_arr, 'total' => count($items)]);
} elseif ($method === 'POST') {
    if (!isset($body['name']) || !isset($body['description'])) {
        $quickapi->setResponse(false, [], "Missing data", 200);
        return;
    }
    
    $item = $modx->newObject(Item::class);
    $item->set('name', trim($body['name']));
    $item->set('description', trim($body['description']));
    
    if ($item->save()) {
        $quickapi->setResponse(true, ['object' => $item->toArray()]);
    } else {
        $quickapi->setResponse(false, [], "Item couldn't be created", 200);
    }
} elseif ($method === 'PUT') {
    if (!isset($body['id']) || intval($body['id']) == 0) {
        $quickapi->setResponse(false, [], "id not specified!", 200);
        return;
    }
    
    $item = $modx->getObject(Item::class, intval($body['id']));
    if ($item) {
        if (isset($body['name'])) {
            $item->set('name', trim($body['name']));
        }
        if (isset($body['description'])) {
            $item->set('description', trim($body['description']));
        }
        
        if ($item->save()) {
            $quickapi->setResponse(true, ['object' => $item->toArray()]);
        } else {
            $quickapi->setResponse(false, [], "Item couldn't be saved", 200);
        }
    } else {
        $quickapi->setResponse(false, [], "Item not found", 200);
    }
} elseif ($method === 'DELETE') {
    if (count($path) == 0 || intval($path[0]) == 0) {
        $quickapi->setResponse(false, [], "id not specified!", 400);
        return;
    }
    
    $item = $modx->getObject(Item::class, intval($path[0]));
    if ($item) {
        if ($item->remove()) {
            $quickapi->setResponse(true, []);
        } else {
            $quickapi->setResponse(false, [], "Item couldn't be removed", 200);
        }
    } else {
        $quickapi->setResponse(false, [], "Item not found", 200);
    }
} else {
    $quickapi->setResponse(false, [], "", 403);
}