<?php
class MyControllerItems extends \MODX\Revolution\Rest\modRestController {
    public $classKey = 'SimpleExtra\\Model\\Item';
    public $defaultSortField = 'id';
    public $defaultSortDirection = 'DESC';
    public $classAlias = 'Item';

    public $defaultLimit = 0;
    public $searchFields = ['name', 'description'];
    public $postRequiredFields = ['name', 'description'];

    public function verifyAuthentication()
    {
        if ($this->request->method == 'get') {
            return true;
        }

        if (!$this->modx->user || $this->modx->user->id < 1) {
            return false;
        }

        if (!$this->modx->user->hasSessionContext('web')) {
            return false;
        }

        if (!$this->modx->user->isMember('apiuser')) {
            return false;
        }

        return true;
    }
}