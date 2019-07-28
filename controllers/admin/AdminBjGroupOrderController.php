<?php

// Autoloader
require_once _PS_MODULE_DIR_ . '/bjgrouporders/autoload.php';

use bdesprez\bjgrouporders\AvailableProcessAjax;
use bdesprez\psmodulefwk\helpers\Conf;
use bdesprez\bjgrouporders\Configuration;
use PrestaShop\PrestaShop\Core\Localization\Exception\LocalizationException;

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
     * Liste des status à afficher
     * @var array|mixed
     */
    private $statusId = [];

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
        $this->filter = false;
        $this->row_hover = false;
        $this->list_simple_header = true;
        $this->list_no_link = true;

        $this->groupIds = Conf::getValeur(Configuration::GROUPS);
        $this->statusId = Conf::getValeur(Configuration::STATUSES_DISPLAYED);
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

        $this->addRowAction('available');
    }

    private function setWhere($groupId)
    {
        if (empty($this->statusId) ) {
            $this->_where = ' AND 1 = 0';
        } else {
            $this->_where = ' AND cg.`id_group` = ' .
                (int) $groupId .
                ' AND os.`id_order_state` IN(' .
                implode(',', $this->statusId)
                . ')';
        }
    }

    public function initListGroups()
    {
        foreach ($this->groupIds as $groupId) {
            $this->list_id = "orders_$groupId";
            $this->toolbar_title = (new Group($groupId))->name;
            $this->context->smarty->assign('title_list', $this->toolbar_title);
            $this->setWhere($groupId);
            $this->content .= parent::renderList();
        }
    }

    public function renderList()
    {
        $this->initListGroups();
    }

    /**
     * @param $echo
     * @param $tr
     * @return string
     * @throws PrestaShopDatabaseException
     * @throws PrestaShopException
     * @throws LocalizationException
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
        $html = "";
        foreach (explode(',', $echo) as $idDetail) {
            $detail = new OrderDetail($idDetail);
            $html .= "<li>{$detail->product_quantity} x {$detail->product_name}</li>";
        }
        return "<ul>$html</ul>";
    }

    /**
     * @return mixed
     */
    public function ajaxProcessAction()
    {
        if (Tools::getValue('my_action') === 'setAvailable') {
            (new AvailableProcessAjax($this->module))->process();
        }
    }



    /**
     * @param null $token
     * @param int $id
     * @return string
     * @throws PrestaShopException
     * @throws SmartyException
     */
    public function displayAvailableLink($token = null, $id)
    {
        $tpl = $this->context->smarty->createTemplate($this->getTemplatePath() . 'setavailable.tpl', $this->context->smarty);
        $tpl->assign([
            'label' => 'Available',
            'action' => 'setAvailable',
            'url' => $this->context->link->getAdminLink($this->controller_name, true, [], ['order id' => $id])
        ]);
        return $tpl->fetch();
    }
}
