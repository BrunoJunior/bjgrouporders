<?php

namespace bdesprez\bjgrouporders;

use bdesprez\psmodulefwk\conf\ConfElement;
use bdesprez\psmodulefwk\conf\ModuleConfiguration;
use bdesprez\psmodulefwk\form\InputCheckbox;
use bdesprez\psmodulefwk\form\InputForm;
use bdesprez\psmodulefwk\helpers\Conf;
use bdesprez\psmodulefwk\ILabeledKeys;
use Group;
use HelperForm;
use Tools;

class Configuration extends ModuleConfiguration implements ILabeledKeys
{
    const GROUPS = '_BJGO_GROUPS_';

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
        }
        return $this->l('Unknown code!');
    }

    /**
     * Quels sont les éléments de configuration ?
     * @return array|ConfElement[]
     */
    protected function getSimpleConfElements()
    {
        return [];
    }

    /**
     * Init
     * @return bool
     */
    protected function complementaryInstall()
    {
        return Conf::setValeur(static::GROUPS, '[]', true);
    }

    /**
     * Suppression conf
     * @return bool
     */
    protected function complementaryUninstall()
    {
        return Conf::removeValeur(static::GROUPS);
    }

    /**
     * Inputs
     * @return array|InputForm[]
     */
    protected function getInputs()
    {
        return array_merge(parent::getInputs(), [
            InputCheckbox::getInstance($this, static::GROUPS, Group::getGroups($this->module->getContext()->language->id), 'id_group', 'name')
        ]);
    }

    protected function complementarySubmitTreatment()
    {
        $sentValue = Tools::getValue(static::GROUPS, []);
        Conf::setValeur(static::GROUPS, Tools::jsonEncode($sentValue), true);
        return '';
    }

    public function fillForm(HelperForm $form)
    {
        parent::fillForm($form);
        $form->fields_value[static::GROUPS] = Tools::jsonDecode(Conf::getValeur(static::GROUPS));
    }
}

