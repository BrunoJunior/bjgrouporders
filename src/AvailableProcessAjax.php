<?php

namespace bdesprez\bjgrouporders;

use bdesprez\psmodulefwk\ajax\AjaxException;
use bdesprez\psmodulefwk\ajax\ModuleProcessAjax;
use bdesprez\psmodulefwk\helpers\Conf;
use Context;
use Order;
use PrestaShopDatabaseException;
use PrestaShopException;
use Tools;

class AvailableProcessAjax extends ModuleProcessAjax
{

    /**
     * @return array
     * @throws AjaxException
     * @throws PrestaShopDatabaseException
     * @throws PrestaShopException
     */
    protected function execute()
    {
        $order = new Order(Tools::getValue('order_id'));
        $order->setCurrentState(Conf::getValeur(Configuration::AVAILABLE_STATUS), Context::getContext()->employee->id);
        return ['message' => sprintf($this->l("The order %s is now available !"), $order->reference)];
    }
}