{*
* SaaS Tenant Manager Module
*
* @author      Your Name
* @copyright   Copyright (c) 2025
* @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
*}

<div class="panel">
    <div class="panel-heading">
        <i class="icon-list"></i> {l s='Tenants' mod='saastenantmanager'}
        <span class="panel-heading-action">
            <a class="list-toolbar-btn" href="{$link->getAdminLink('AdminModules')}&configure=saastenantmanager&addTenant=1">
                <i class="process-icon-new"></i> {l s='Add new tenant' mod='saastenantmanager'}
            </a>
        </span>
    </div>
    
    {if isset($tenants) && $tenants|count > 0}
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th><span class="title_box">{l s='ID' mod='saastenantmanager'}</span></th>
                        <th><span class="title_box">{l s='Name' mod='saastenantmanager'}</span></th>
                        <th><span class="title_box">{l s='Domain' mod='saastenantmanager'}</span></th>
                        <th><span class="title_box">{l s='Shop Group' mod='saastenantmanager'}</span></th>
                        <th><span class="title_box">{l s='Status' mod='saastenantmanager'}</span></th>
                        <th><span class="title_box">{l s='Created' mod='saastenantmanager'}</span></th>
                        <th><span class="title_box">{l s='Actions' mod='saastenantmanager'}</span></th>
                    </tr>
                </thead>
                <tbody>
                    {foreach from=$tenants item=tenant}
                        <tr>
                            <td>{$tenant.id_tenant|escape:'html':'UTF-8'}</td>
                            <td>{$tenant.name|escape:'html':'UTF-8'}</td>
                            <td><a href="http://{$tenant.domain|escape:'html':'UTF-8'}" target="_blank">{$tenant.domain|escape:'html':'UTF-8'}</a></td>
                            <td>{$tenant.shop_group_name|escape:'html':'UTF-8'}</td>
                            <td>
                                {if $tenant.active}
                                    <span class="badge badge-success">{l s='Active' mod='saastenantmanager'}</span>
                                {else}
                                    <span class="badge badge-danger">{l s='Inactive' mod='saastenantmanager'}</span>
                                {/if}
                            </td>
                            <td>{$tenant.date_add|escape:'html':'UTF-8'}</td>
                            <td>
                                <div class="btn-group">
                                    <a class="btn btn-default" href="{$link->getAdminLink('AdminModules')}&configure=saastenantmanager&editTenant=1&id_tenant={$tenant.id_tenant|intval}">
                                        <i class="icon-edit"></i> {l s='Edit' mod='saastenantmanager'}
                                    </a>
                                    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                                        <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a href="{$link->getAdminLink('AdminModules')}&configure=saastenantmanager&addShop=1&id_tenant={$tenant.id_tenant|intval}">
                                                <i class="icon-plus"></i> {l s='Add shop' mod='saastenantmanager'}
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{$link->getAdminLink('AdminModules')}&configure=saastenantmanager&viewSubscription=1&id_tenant={$tenant.id_tenant|intval}">
                                                <i class="icon-credit-card"></i> {l s='Subscription' mod='saastenantmanager'}
                                            </a>
                                        </li>
                                        <li class="divider"></li>
                                        <li>
                                            <a href="{$link->getAdminLink('AdminModules')}&configure=saastenantmanager&deleteTenant=1&id_tenant={$tenant.id_tenant|intval}" onclick="return confirm('{l s='Are you sure you want to delete this tenant?' mod='saastenantmanager' js=1}');">
                                                <i class="icon-trash"></i> {l s='Delete' mod='saastenantmanager'}
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    {/foreach}
                </tbody>
            </table>
        </div>
    {else}
        <div class="alert alert-info">
            {l s='No tenants found. Click "Add new tenant" to create your first tenant.' mod='saastenantmanager'}
        </div>
    {/if}
</div>

<div class="panel">
    <div class="panel-heading">
        <i class="icon-info-circle"></i> {l s='SaaS Tenant Manager Information' mod='saastenantmanager'}
    </div>
    <div class="alert alert-info">
        <p>
            <strong>{l s='What is a tenant?' mod='saastenantmanager'}</strong><br>
            {l s='In a SaaS (Software as a Service) environment, a tenant represents a customer or organization using your PrestaShop platform. Each tenant has their own isolated environment with separate shops, products, customers, and orders.' mod='saastenantmanager'}
        </p>
        <p>
            <strong>{l s='How does multi-tenancy work in PrestaShop?' mod='saastenantmanager'}</strong><br>
            {l s='This module leverages PrestaShop\'s multi-store feature to create isolated environments for each tenant. Each tenant gets their own shop group with separate shops, domains, and data.' mod='saastenantmanager'}
        </p>
        <p>
            <strong>{l s='Getting started:' mod='saastenantmanager'}</strong><br>
            {l s='1. Make sure the Multistore feature is enabled in Advanced Parameters > Multistore.' mod='saastenantmanager'}<br>
            {l s='2. Configure this module\'s settings above.' mod='saastenantmanager'}<br>
            {l s='3. Create your first tenant by clicking "Add new tenant".' mod='saastenantmanager'}<br>
            {l s='4. Add shops to your tenant and configure their domains.' mod='saastenantmanager'}
        </p>
    </div>
</div>
