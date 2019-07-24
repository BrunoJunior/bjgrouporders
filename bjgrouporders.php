<?php
/** @noinspection PhpFullyQualifiedNameUsageInspection */
/** @noinspection PhpUndefinedClassInspection */
/**
 * 2019 BJ
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License (AFL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/afl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade PrestaShop to newer
 * versions in the future. If you wish to customize PrestaShop for your
 * needs please refer to http://www.prestashop.com for more information.
 *
 *  @author    BJ <perso@bdesprez.com>
 *  @copyright 2019 BJ
 *  @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
 */

if (!defined('_PS_VERSION_')) {
    exit;
}
// Autoload
require _PS_MODULE_DIR_ . 'bjgrouporders/autoload.php';
use bdesprez\psmodulefwk\MyModule;
use bdesprez\bjgrouporders\Configuration;
use bdesprez\psmodulefwk\TabInstaller;

/**
 *
 */
class BJGroupOrders extends MyModule
{

    /**
     * Constructeur
     * @throws PrestaShopException
     */
    public function __construct()
    {
        $this->version = '0.0.1';
        parent::__construct();
        $this->ps_versions_compliancy = array('min' => '1.7.0.0', 'max' => '1.7.99.99');
        $this->displayName = $this->l('BJ Customer groups orders');
        $this->description = $this->l('Listing of orders grouped by customer groups ');
        $this->tabs = (new TabInstaller($this, TabInstaller::PARENT_SELL_ORDERS))
            ->addController(AdminBjGroupOrderController::class, $this->l('Orders by group'))
            ->toPsTabs();
    }

    /**
     * Pas de conf
     * @return array|\bdesprez\psmodulefwk\conf\ModuleConfiguration[]
     */
    protected function getModuleConfigurations()
    {
        return [
            new Configuration($this)
        ];
    }
}
