<?php

// Autoloader
require_once _PS_MODULE_DIR_ . '/bjgrouporders/autoload.php';

use bdesprez\psmodulefwk\helpers\Conf;
use bdesprez\bjgrouporders\Configuration;
use bdesprez\psmodulefwk\helpers\LoggerFactory;

/**
 * @see AdminManufacturersController for multiple lists
 * Class AdminBjGroupOrderController
 */
class AdminBjGroupOrderController extends ModuleAdminController
{
    /**
     * Liste des groupes à afficher
     * @var array|mixed
     */
    private $groupIds = [];

    /**
     * @var array
     */
    private $statuses_array = [];

    public function __construct()
    {
        $this->bootstrap = true;
        $this->table = Order::$definition['table'];
        $this->identifier = Order::$definition['primary'];
        $this->className = Order::class;
        $this->lang = false;
        $this->deleted = false;
        $this->context = Context::getContext();

        $this->groupIds = Conf::getValeur(Configuration::GROUPS);
        $statuses = OrderState::getOrderStates((int)$this->context->language->id);
        foreach ($statuses as $status) {
            $this->statuses_array[$status['id_order_state']] = $status['name'];
        }

        $this->_select = '
		a.id_currency,
		CONCAT(c.`firstname`, \' \', c.`lastname`) AS `customer`,
		osl.`name` AS `osname`,
		os.`color`,
		IF(a.valid, 1, 0) badge_success,
		GROUP_CONCAT(od.`id_order_detail` separator \',\') AS `content`
		';

        $this->_join = '
		LEFT JOIN `'._DB_PREFIX_.'customer` c ON (c.`id_customer` = a.`id_customer`)
		LEFT JOIN `'._DB_PREFIX_.'customer_group` cg ON (c.`id_customer` = cg.`id_customer`)
		LEFT JOIN `'._DB_PREFIX_.'order_state` os ON (os.`id_order_state` = a.`current_state`)
		LEFT JOIN `'._DB_PREFIX_.'order_detail` od ON (od.`id_order` = a.`id_order`)
		LEFT JOIN `'._DB_PREFIX_.'order_state_lang` osl ON (os.`id_order_state` = osl.`id_order_state` AND osl.`id_lang` = '.(int)$this->context->language->id.')'
        ;
        $this->_group = 'GROUP BY a.`id_order`';
        $this->_orderBy = 'id_order';
        $this->_orderWay = 'DESC';
        if (empty($this->groupIds)) {
            $this->_where = ' AND 1 = 0';
        } else {
            $this->_where = ' AND cg.`id_group` = ' . (int) reset($this->groupIds);
        }

        parent::__construct();

        $this->fields_list = array(
            'reference' => array(
                'title' => $this->l('Reference'),
                'align' => 'center',
                'class' => 'fixed-width-md'
            ),
            'customer' => array(
                'title' => $this->l('Customer'),
                'align' => 'left'
            ),
            'content' => array(
                'title' => $this->l('Content'),
                'align' => 'left',
                'callback' => 'setOrderDetail'
            ),
            'total_paid_tax_incl' => array(
                'title' => $this->l('Total'),
                'align' => 'text-right',
                'type' => 'price',
                'currency' => true,
                'callback' => 'setOrderCurrency',
                'badge_success' => true
            ),
            'osname' => array(
                'title' => $this->l('Status'),
                'type' => 'select',
                'color' => 'color',
                'list' => $this->statuses_array,
                'order_key' => 'osname'
            ),
            'date_add' => array(
                'title' => $this->l('Date'),
                'align' => 'text-right',
                'type' => 'datetime'
            )
        );
    }

    /**
     * @param $echo
     * @param $tr
     * @return string
     * @throws PrestaShopDatabaseException
     * @throws PrestaShopException
     */
    public static function setOrderCurrency($echo, $tr)
    {
        $order = new Order($tr['id_order']);
        return Tools::displayPrice($echo, (int)$order->id_currency);
    }

    /**
     * @param $echo
     * @param $tr
     * @return string
     * @throws PrestaShopDatabaseException
     * @throws PrestaShopException
     */
    public static function setOrderDetail($echo, $tr)
    {
        $strTr = json_encode($tr);
        LoggerFactory::getLogger('bjgrouporders')->log("setOrderDetail({$echo},{$strTr})", 'Controller');
        $html = "";
        foreach (explode(',', $echo) as $idDetail) {
            $detail = new OrderDetail($idDetail);
            $html .= "<li>{$detail->product_quantity} x {$detail->product_name}</li>";
        }
        return "<ul>$html</ul>";
    }
}
