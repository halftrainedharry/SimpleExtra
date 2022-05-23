<?php
use MODX\Revolution\modManagerController;

class SimpleExtraHomeManagerController extends modManagerController
{
    public function checkPermissions()
    {
        return true;
    }

    public function process(array $scriptProperties = [])
    {
        return '<div id="simpleextra-panel-home-div"></div>';
    }

    public function getPageTitle()
    {
        return 'Simple Extra';
    }

    public function loadCustomCssJs()
    {
        $jsUrl = $this->modx->getOption('assets_url', null, MODX_ASSETS_URL) . 'components/simpleextra/js/';
        $this->addJavascript($jsUrl . 'simpleextra.js');
        $this->addJavascript($jsUrl . 'items.grid.js');
    }

    public function getTemplateFile()
    {
        return '';
    }
}