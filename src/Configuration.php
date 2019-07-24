<?php

namespace bdesprez\bjgrouporders;

use bdesprez\psmodulefwk\conf\ConfElement;
use bdesprez\psmodulefwk\conf\ModuleConfiguration;
use bdesprez\psmodulefwk\form\InputCheckbox;
use bdesprez\psmodulefwk\form\InputFormOptions;
use bdesprez\psmodulefwk\ILabeledKeys;
use Group;
use PrestaShopModuleException;

class Configuration extends ModuleConfiguration implements ILabeledKeys
{
    const GROUPS = 'BJGO_GROUPS';

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
     * @return array|ConfElement[]
     * @throws PrestaShopModuleException
     */
    protected function getElements()
    {
        $groupsOptions = new InputFormOptions(Group::getGroups($this->module->getContext()->language->id), 'id_group', 'name');
        return [
            new ConfElement(new InputCheckbox($this, static::GROUPS, $groupsOptions), [])
        ];
    }
}

