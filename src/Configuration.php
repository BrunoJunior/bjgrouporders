<?php

namespace bdesprez\bjgrouporders;

use bdesprez\psmodulefwk\conf\ConfElement;
use bdesprez\psmodulefwk\conf\ModuleConfiguration;
use bdesprez\psmodulefwk\form\InputCheckbox;
use bdesprez\psmodulefwk\form\InputFormOptions;
use bdesprez\psmodulefwk\helpers\Conf;
use bdesprez\psmodulefwk\helpers\LoggerFactory;
use bdesprez\psmodulefwk\ILabeledKeys;
use Group;
use Language;
use PrestaShopModuleException;
use OrderState;

class Configuration extends ModuleConfiguration implements ILabeledKeys
{
    const GROUPS = 'BJGO_GROUPS';
    const STATUSES_DISPLAYED = 'BJGO_STATUSES_DISPLAYED';
    const AVAILABLE_STATUS = 'BJGO_AVAILABLE_STATUS';

    /**
     * Le nom de la configuration
     * Utiliser $this->l()
     * @return string
     */
    public function getName()
    {
        return $this->l('Configuration');
    }

    /**
     * Getting the label by the key
     * @param string $key
     * @return string
     */
    function getLabelByKey($key)
    {
        switch ($key) {
            case static::GROUPS:
                return $this->l('Visible groups in list');
            case static::STATUSES_DISPLAYED:
                return $this->l('Statuses displayed');
        }
        return $this->l('Unknown code!');
    }

    /**
     * @return array|ConfElement[]
     * @throws PrestaShopModuleException
     */
    protected function getElements()
    {
        $states = array_filter(OrderState::getOrderStates($this->module->getContext()->language->id), function ($row) {
            return (int) $row['id_order_state'] !== (int) Conf::getValeur(static::AVAILABLE_STATUS);
        });
        $groupsOptions = new InputFormOptions(Group::getGroups($this->module->getContext()->language->id), 'id_group', 'name');
        $statusesOptions = new InputFormOptions($states, 'id_order_state', 'name');
        return [
            new ConfElement(new InputCheckbox($this, static::GROUPS, $groupsOptions), []),
            new ConfElement(new InputCheckbox($this, static::STATUSES_DISPLAYED, $statusesOptions), [2, 3])
        ];
    }

    /**
     * Création automatique d'un statut de commande "Disponible"
     * @return mixed
     */
    protected function complementaryInstall()
    {
        $names = [];
        foreach (Language::getLanguages(true, false, true) as $langId) {
            $names[$langId] = 'Disponible';
        }
        $availableState = new OrderState();
        $availableState->send_email = false;
        $availableState->color = '#02d400';
        $availableState->logable = true;
        $availableState->name = $names ? $names : 'Disponible';
        $availableState->module_name = $this->getModule()->name;
        $ok = $availableState->save() ? 'O' : 'N';
        LoggerFactory::getLogger($this->getModule()->name)->log('Création état disponlible : ' . $ok . ' - ' . json_encode($availableState));
        return Conf::setValeur(static::AVAILABLE_STATUS, $availableState->id, true);
    }

    /**
     * Suppression du statut de commande "Disponible"
     * @return mixed
     */
    protected function complementaryUninstall()
    {
        (new OrderState(Conf::getValeur(static::AVAILABLE_STATUS)))->delete();
        return Conf::removeValeur(static::AVAILABLE_STATUS);
    }
}

