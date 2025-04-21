<?php
/**
 * SaaS Tenant Manager Module
 *
 * @author      Your Name
 * @copyright   Copyright (c) 2025
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

if (!defined('_PS_VERSION_')) {
    exit;
}

class SaasTenantManager extends Module
{
    public function __construct()
    {
        $this->name = 'saastenantmanager';
        $this->tab = 'administration';
        $this->version = '1.0.0';
        $this->author = 'Your Name';
        $this->need_instance = 0;
        $this->ps_versions_compliancy = [
            'min' => '8.0.0',
            'max' => _PS_VERSION_,
        ];
        $this->bootstrap = true;

        parent::__construct();

        $this->displayName = $this->l('SaaS Tenant Manager');
        $this->description = $this->l('Manage multiple tenants in a SaaS environment');
        $this->confirmUninstall = $this->l('Are you sure you want to uninstall?');
    }

    /**
     * Install the module
     *
     * @return bool
     */
    public function install()
    {
        return parent::install() &&
            $this->registerHook('displayBackOfficeHeader') &&
            $this->registerHook('actionAdminControllerSetMedia') &&
            $this->installDatabase();
    }

    /**
     * Uninstall the module
     *
     * @return bool
     */
    public function uninstall()
    {
        return parent::uninstall() &&
            $this->uninstallDatabase();
    }

    /**
     * Install database tables
     *
     * @return bool
     */
    private function installDatabase()
    {
        $sql = [];
        
        $sql[] = 'CREATE TABLE IF NOT EXISTS `' . _DB_PREFIX_ . 'saas_tenant` (
            `id_tenant` int(10) unsigned NOT NULL AUTO_INCREMENT,
            `name` varchar(255) NOT NULL,
            `domain` varchar(255) NOT NULL,
            `id_shop_group` int(10) unsigned NOT NULL,
            `active` tinyint(1) unsigned NOT NULL DEFAULT 1,
            `date_add` datetime NOT NULL,
            `date_upd` datetime NOT NULL,
            PRIMARY KEY (`id_tenant`)
        ) ENGINE=' . _MYSQL_ENGINE_ . ' DEFAULT CHARSET=utf8mb4;';
        
        $sql[] = 'CREATE TABLE IF NOT EXISTS `' . _DB_PREFIX_ . 'saas_tenant_subscription` (
            `id_subscription` int(10) unsigned NOT NULL AUTO_INCREMENT,
            `id_tenant` int(10) unsigned NOT NULL,
            `plan` varchar(255) NOT NULL,
            `price` decimal(20,6) NOT NULL DEFAULT 0,
            `billing_cycle` varchar(20) NOT NULL,
            `start_date` datetime NOT NULL,
            `end_date` datetime NOT NULL,
            `active` tinyint(1) unsigned NOT NULL DEFAULT 1,
            `date_add` datetime NOT NULL,
            `date_upd` datetime NOT NULL,
            PRIMARY KEY (`id_subscription`),
            KEY `id_tenant` (`id_tenant`)
        ) ENGINE=' . _MYSQL_ENGINE_ . ' DEFAULT CHARSET=utf8mb4;';

        foreach ($sql as $query) {
            if (!Db::getInstance()->execute($query)) {
                return false;
            }
        }

        return true;
    }

    /**
     * Uninstall database tables
     *
     * @return bool
     */
    private function uninstallDatabase()
    {
        $sql = [];
        
        $sql[] = 'DROP TABLE IF EXISTS `' . _DB_PREFIX_ . 'saas_tenant`';
        $sql[] = 'DROP TABLE IF EXISTS `' . _DB_PREFIX_ . 'saas_tenant_subscription`';

        foreach ($sql as $query) {
            if (!Db::getInstance()->execute($query)) {
                return false;
            }
        }

        return true;
    }

    /**
     * Module configuration page
     *
     * @return string
     */
    public function getContent()
    {
        $output = '';

        if (Tools::isSubmit('submit' . $this->name)) {
            // Process configuration form submission
            $output .= $this->postProcess();
        }

        // Display configuration form
        $output .= $this->renderForm();
        
        // Display tenant list
        $output .= $this->renderTenantList();

        return $output;
    }

    /**
     * Render configuration form
     *
     * @return string
     */
    protected function renderForm()
    {
        $helper = new HelperForm();

        $helper->show_toolbar = false;
        $helper->table = $this->table;
        $helper->module = $this;
        $helper->default_form_language = $this->context->language->id;
        $helper->allow_employee_form_lang = Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG', 0);

        $helper->identifier = $this->identifier;
        $helper->submit_action = 'submit' . $this->name;
        $helper->currentIndex = $this->context->link->getAdminLink('AdminModules', false)
            . '&configure=' . $this->name . '&tab_module=' . $this->tab . '&module_name=' . $this->name;
        $helper->token = Tools::getAdminTokenLite('AdminModules');

        $helper->tpl_vars = [
            'fields_value' => $this->getConfigFormValues(),
            'languages' => $this->context->controller->getLanguages(),
            'id_language' => $this->context->language->id,
        ];

        return $helper->generateForm([$this->getConfigForm()]);
    }

    /**
     * Configuration form structure
     *
     * @return array
     */
    protected function getConfigForm()
    {
        return [
            'form' => [
                'legend' => [
                    'title' => $this->l('Settings'),
                    'icon' => 'icon-cogs',
                ],
                'input' => [
                    [
                        'type' => 'switch',
                        'label' => $this->l('Enable automatic tenant creation'),
                        'name' => 'SAAS_AUTO_TENANT_CREATION',
                        'is_bool' => true,
                        'values' => [
                            [
                                'id' => 'active_on',
                                'value' => true,
                                'label' => $this->l('Enabled'),
                            ],
                            [
                                'id' => 'active_off',
                                'value' => false,
                                'label' => $this->l('Disabled'),
                            ],
                        ],
                        'desc' => $this->l('Automatically create shop groups and shops for new tenants'),
                    ],
                    [
                        'type' => 'text',
                        'label' => $this->l('Default domain pattern'),
                        'name' => 'SAAS_DEFAULT_DOMAIN_PATTERN',
                        'desc' => $this->l('Use {tenant} as a placeholder for the tenant name. Example: {tenant}.yourdomain.com'),
                    ],
                ],
                'submit' => [
                    'title' => $this->l('Save'),
                ],
            ],
        ];
    }

    /**
     * Get configuration form values
     *
     * @return array
     */
    protected function getConfigFormValues()
    {
        return [
            'SAAS_AUTO_TENANT_CREATION' => Configuration::get('SAAS_AUTO_TENANT_CREATION', false),
            'SAAS_DEFAULT_DOMAIN_PATTERN' => Configuration::get('SAAS_DEFAULT_DOMAIN_PATTERN', '{tenant}.yourdomain.com'),
        ];
    }

    /**
     * Process configuration form submission
     *
     * @return string
     */
    protected function postProcess()
    {
        $form_values = $this->getConfigFormValues();

        foreach (array_keys($form_values) as $key) {
            Configuration::updateValue($key, Tools::getValue($key));
        }

        return $this->displayConfirmation($this->l('Settings updated'));
    }

    /**
     * Render tenant list
     *
     * @return string
     */
    protected function renderTenantList()
    {
        // Get tenants from database
        $tenants = Db::getInstance()->executeS('
            SELECT t.*, sg.name as shop_group_name
            FROM `' . _DB_PREFIX_ . 'saas_tenant` t
            LEFT JOIN `' . _DB_PREFIX_ . 'shop_group` sg ON t.id_shop_group = sg.id_shop_group
            ORDER BY t.date_add DESC
        ');

        $this->context->smarty->assign([
            'tenants' => $tenants,
            'link' => $this->context->link,
        ]);

        return $this->display(__FILE__, 'views/templates/admin/tenant_list.tpl');
    }

    /**
     * Hook to add CSS/JS to back office header
     */
    public function hookDisplayBackOfficeHeader()
    {
        if (Tools::getValue('configure') == $this->name) {
            $this->context->controller->addCSS($this->_path . 'views/css/back.css');
            $this->context->controller->addJS($this->_path . 'views/js/back.js');
        }
    }

    /**
     * Hook for back office controller media
     */
    public function hookActionAdminControllerSetMedia()
    {
        // Add additional JS/CSS if needed
    }

    /**
     * Create a new tenant
     *
     * @param string $name Tenant name
     * @param string $domain Tenant domain
     * @return bool|int Tenant ID or false on failure
     */
    public function createTenant($name, $domain)
    {
        // Create shop group
        $shopGroup = new ShopGroup();
        $shopGroup->name = $name;
        $shopGroup->active = true;
        $shopGroup->share_customer = false;
        $shopGroup->share_stock = false;
        $shopGroup->share_order = false;
        
        if (!$shopGroup->add()) {
            return false;
        }

        // Create tenant record
        $result = Db::getInstance()->insert('saas_tenant', [
            'name' => pSQL($name),
            'domain' => pSQL($domain),
            'id_shop_group' => (int) $shopGroup->id,
            'active' => 1,
            'date_add' => date('Y-m-d H:i:s'),
            'date_upd' => date('Y-m-d H:i:s'),
        ]);

        if (!$result) {
            return false;
        }

        return Db::getInstance()->Insert_ID();
    }

    /**
     * Create a shop for a tenant
     *
     * @param int $idTenant Tenant ID
     * @param string $shopName Shop name
     * @param string $domain Shop domain
     * @return bool|int Shop ID or false on failure
     */
    public function createShopForTenant($idTenant, $shopName, $domain)
    {
        // Get tenant info
        $tenant = Db::getInstance()->getRow('
            SELECT * FROM `' . _DB_PREFIX_ . 'saas_tenant`
            WHERE id_tenant = ' . (int) $idTenant
        );

        if (!$tenant) {
            return false;
        }

        // Create shop
        $shop = new Shop();
        $shop->active = true;
        $shop->id_shop_group = (int) $tenant['id_shop_group'];
        $shop->name = $shopName;
        $shop->id_category = (int) Configuration::get('PS_HOME_CATEGORY');
        $shop->theme_name = _THEME_NAME_;
        
        if (!$shop->add()) {
            return false;
        }

        // Add shop URL
        $shopUrl = new ShopUrl();
        $shopUrl->id_shop = (int) $shop->id;
        $shopUrl->domain = $domain;
        $shopUrl->domain_ssl = $domain;
        $shopUrl->physical_uri = '/';
        $shopUrl->virtual_uri = '';
        $shopUrl->main = true;
        $shopUrl->active = true;
        
        if (!$shopUrl->add()) {
            return false;
        }

        return $shop->id;
    }
}
