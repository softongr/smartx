<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth')->group(function () {

    Route::middleware(['dynamic.permission'])->group(function () {

        /****************************************** PROFILE **********************************/
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
        /****************************************** END PROFILE **********************************/

        /****************************************** DASHBOARD **********************************/
        Route::get('/dashboard', App\Livewire\Dashboard\Index::class)->name('dashboard')->withPermission();
        /****************************************** END DASHBOARD **********************************/

        /****************************************** SUPPLIERS **********************************/
        Route::get('suppliers/index', App\Livewire\Suppliers\Index::class)->name('suppliers.index')->withPermission();
        Route::get('supplier/create',\App\Livewire\Suppliers\Form::class)->name('supplier.create')->withPermission();
        Route::get('supplier/{supplier}/edit',\App\Livewire\Suppliers\Form::class)->name('supplier.edit')->withPermission();
        Route::get('supplier/{supplier}/delete',\App\Livewire\Suppliers\Delete::class)->name('supplier.delete')->withPermission();
        Route::get('supplier/{supplier}/mapping',\App\Livewire\Suppliers\Mapping::class)->name('supplier.mapping')->withPermission();
        /****************************************** END SUPPLIERS **********************************/

        /****************************************** MONITORS **********************************/
        Route::get('monitors/active', App\Livewire\Monitors\Index::class)->name('monitors.index')->withPermission();
        /****************************************** END MONITORS **********************************/

        /****************************************** ROLES **********************************/
        Route::get('roles/index',\App\Livewire\Team\Roles\Index::class)->name('roles.index')->withPermission();
        Route::get('role/create',\App\Livewire\Team\Roles\Form::class)->name('role.create')->withPermission();
        Route::get('role/{role}/edit', \App\Livewire\Team\Roles\Form::class)->name('role.edit')->withPermission();
        Route::get('role/{role}/permissions', \App\Livewire\Team\Roles\GivePermission::class)->name('role.permissions')->withPermission();
        Route::get('role/{role}/delete', \App\Livewire\Team\Roles\Delete::class)->name('role.delete')->withPermission();
       /****************************************** END ROLES **********************************/

       /****************************************** EMPLOYEES **********************************/
        Route::get('employees/index',\App\Livewire\Team\Employees\Index::class)->name('employees.index')->withPermission();
        Route::get('employee/create',\App\Livewire\Team\Employees\Form::class)->name('employee.create')->withPermission();
        Route::get('employee/{employee}/edit',\App\Livewire\Team\Employees\Form::class)->name('employee.edit')->withPermission();
        Route::get('employee/{employee}/delete',\App\Livewire\Team\Employees\Form::class)->name('employee.delete')->withPermission();
        /****************************************** END EMPLOYEES **********************************/

        /****************************************** PERMISSIONS **********************************/
        Route::get('permissions/index',\App\Livewire\Team\Permissions\Index::class)->name('permissions.index')->withPermission();
        Route::get('permission/create',\App\Livewire\Team\Permissions\Form::class)->name('permission.create')->withPermission();
        Route::get('permission/{permission}/edit',\App\Livewire\Team\Permissions\Form::class)->name('permission.edit')->withPermission();
        /****************************************** END PERMISSIONS **********************************/

        /****************************************** rates **********************************/
        Route::get('rates/index', App\Livewire\Rates\Index::class)->name('rates.index')->withPermission();
        Route::get('rate/create', App\Livewire\Rates\Form::class)->name('rate.create')->withPermission();
        Route::get('rate/{rate}/edit', App\Livewire\Rates\Form::class)->name('rate.edit')->withPermission();
        Route::get('rate/{rate}/delete', App\Livewire\Rates\Delete::class)->name('rate.delete')->withPermission();
        /****************************************** END rates **********************************/

        /****************************************** SETTINGS **********************************/
        Route::get('settings/products', App\Livewire\Settings\Products\Index::class)->name('settings.products.index')->withPermission();
        Route::get('settings/openai',App\Livewire\Settings\OpenAi\Index::class)->name('settings.openai.index')->withPermission();
        Route::get('settings', \App\Livewire\Settings\Generally\Index::class)->name('settings')->withPermission();
        Route::get('settings/sms',App\Livewire\Settings\Sms\Index::class)->name('settings.sms.index')->withPermission();
        Route::get('settings/smtp',App\Livewire\Settings\Smtp\Index::class)->name('settings.smtp.index')->withPermission();
        Route::get('settings/api_token', App\Livewire\Settings\Api\Index::class)->name('settings.api_token.index')->withPermission();
        Route::get('settings/performance',App\Livewire\Settings\System\Index::class)->name('settings.performance.index')->withPermission();
        Route::get('settings/myaade' ,App\Livewire\Settings\myAade\Index::class)->name('settings.myaade.index')->withPermission();
        Route::get('settings/synchronization', App\Livewire\Settings\Synchronization\Index::class)->name('settings.synchronization.index');
        /*************************************** END SETTINGS *********************************/

        /****************************************** OPENAI **********************************/
        Route::get('openai/prompts/index', \App\Livewire\OpenAi\Prompts\Index::class)->name('openai.prompts.index')->withPermission();
        Route::get('openai/prompts/create', \App\Livewire\OpenAi\Prompts\Form::class)->name('openai.prompts.create')->withPermission();
        Route::get('openai/prompts/{prompt}/edit',App\Livewire\OpenAi\Prompts\Form::class)->name('openai.prompts.edit')->withPermission();
        Route::get('openai/prompts/{prompt}/delete',App\Livewire\OpenAi\Prompts\Delete::class)->name('openai.prompts.delete')->withPermission();
        Route::get('openai/mapper/product', \App\Livewire\OpenAi\Mapper\Product::class)->name('openai.mapper.product')->withPermission();
        Route::get('openai/mapper/category' , \App\Livewire\OpenAi\Mapper\Category::class)->name('openai.mapper.category')->withPermission();
        /****************************************** END OPENAI **********************************/

        /****************************************** MARKETPLACES **********************************/
        Route::get('marketplaces',App\Livewire\Marketplaces\Index::class)->name('marketplaces.index')->withPermission();
        Route::get('marketplace/create',App\Livewire\Marketplaces\Form::class)->name('marketplace.create')->withPermission();
        Route::get('marketplace/{marketplace}/edit',App\Livewire\Marketplaces\Form::class)->name('marketplace.edit')->withPermission();
        Route::get('marketplace/{marketplace}/delete',App\Livewire\Marketplaces\Delete::class)->name('marketplace.delete')->withPermission();
        Route::get('marketplace/{marketplace}/mapping', \App\Livewire\Marketplaces\Mapping::class)->name('marketplace.map')->withPermission();

        /****************************************** MARKETPLACES **********************************/

        /****************************************** USERS LOGS **********************************/
        Route::get('users/logs', App\Livewire\Team\Logs\Index::class)->name('users.logs')->withPermission();
        /****************************************** USERS LOGS **********************************/

        /****************************************** PRODUCTS **********************************/
        Route::get('products/index', \App\Livewire\Catalog\Products\Index::class)->name('products.index')->withPermission();
        Route::get('product/create', \App\Livewire\Catalog\Products\Form::class)->name('product.create')->withPermission();
        Route::get('product/{product}/edit', \App\Livewire\Catalog\Products\Form::class)->name('product.edit')->withPermission();
        Route::get('product/{product}/overview', \App\Livewire\Catalog\Products\Overview::class)->name('product.parser')->withPermission();
        /****************************************** USERS PRODUCTS **********************************/
        Route::get('synchronization',\App\Livewire\Synchronization\Index::class)->name('synchronization')->withPermission();
        Route::get('synchronization/logs',\App\Livewire\Synchronization\Logs\Index::class)->name('synchronization.logs.index')->withPermission();
        Route::get('synchronization/log/{id}/view',\App\Livewire\Synchronization\Logs\View::class)->name('synchronization.log.view')->withPermission();


        Route::get('/product/{id}/delete', \App\Livewire\Catalog\Products\Delete::class)->name('product.delete')->withPermission();


        Route::get('product/import/json', \App\Livewire\Catalog\Products\Data\Import::class)->name('products.import')->withPermission();


        Route::get('catalog/products/shops/{product}/to-monitor' , \App\Livewire\Catalog\Products\Monitors\Form::class)->name('product.shops.to-monitor')->withPermission();
        Route::get('shops',App\Livewire\Shop\Index::class)->name('shops.index')->withPermission();
        Route::get('sync/category' , \App\Livewire\Synchronization\Category::class)->name('sync.category')->withPermission();
        Route::get('settings/orders/phone', \App\Livewire\Settings\Orders\Phones\Index::class)->name('settings.ordersphone.index')->withPermission();
        Route::get('orders/phone/index', App\Livewire\Orders\Phone\Index::class)->name('ordersphone.index')->withPermission();
        Route::get('order/phone/create', App\Livewire\Orders\Phone\Form::class)->name('orderphone.create')->withPermission();
        Route::get('order/phone/{id}/edit', App\Livewire\Orders\Phone\Form::class)->name('orderphone.edit')->withPermission();





        Route::get('ecommerce/categories' , \App\Livewire\ECommerce\Categories\Index::class)->name('ecommerce.categories')->withPermission();
        Route::get('ecommerce/products' , \App\Livewire\ECommerce\Products\Index::class)->name('ecommerce.products')->withPermission();

    });
});

require __DIR__.'/auth.php';
