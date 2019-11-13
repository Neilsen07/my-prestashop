<?php

if (!defined('_PS_VERSION_')) {
    exit;
}

use PrestaShop\PrestaShop\Core\Module\WidgetInterface;

class MyModule extends Module implements WidgetInterface
{

    public function __construct()
    {
        $this->name = 'mymodule';
        $this->tab = 'front_office_features';
        $this->version = '1.0.0';
        $this->author = 'Neilsen Arnachellum';
        $this->need_instance = 0;
        $this->ps_versions_compliancy = [
            'min' => '1.7',
            'max' => _PS_VERSION_
        ];
        $this->bootstrap = true;

        parent::__construct();

        $this->displayName = $this->l('My Module Udemy');
        $this->description = $this->l('A module created for the purpose of learning prestashop 1.7');

        $this->confirmUnistall = $this->l('Are you sure you want to uninstall?');

        if (!Configuration::get('MYMODULE_NAME')) {
            $this->warning = $this->l('No name provided');
        }
    }

    /**
     *
     *
     */

    public function install()
    {
        /*
         * Check that the Multistore feature is enabled, and if so, set the current context
         * to all shops on this installation of Prestashop.
         */

        if (Shop::isFeatureActive()) {
            Shop::setContext(Shop::CONTEXT_ALL);
        }

        /**
         * Check that the module parent class is installed.
         * Check that the module can be attached to the leftColum hook.
         * Check that the module can be attached to the header hook.
         * Create the MYMODULE_NAME configuration setting its value to "my friend"
         */
        if (!parent::install() ||
            !$this->registerHook('leftColumn') ||
            !$this->registerHook('header') ||
            !Configuration::updateValue('MYMODULE_NAME', 'my friend')
        ) {
            return false;
        }
        return true;
    }

    public function getContent(){

        if(Tools::getAllValues('configuration')) {
            if (
                Configuration::updateValue('MYMODULE_NAME', "Hello, am updated from the GetContent method"))
                echo "All went well";
            else
                echo "something went wrong";
        }

        return $this->display(__FILE__, 'dashboard.tpl');
       // return "Hello, am getting updated from the GetContent method";

    }

    public function uninstall()
    {
        if (!parent::uninstall() ||
            !Configuration::deleteByName('MYMODULE_NAME')
        ) {
            return false;
        }
        return true;
    }

    public function hookHeader($params)
    {
      /*  print_r($params);*/
       // return "Hello from " . Configuration::get('MYMODULE_NAME');
    }

    public function renderWidget($hookName, array $configuration)
    {
        return "Hello from " . Configuration::get('MYMODULE_NAME');
    }

    public function getWidgetVariables($hookName, array $configuration)
    {
        // TODO: Implement getWidgetVariables() method.
    }
}