<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Permission;

class PermissionControllSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('permissions')->insert([

            ['slug'=>'products_list','name'=>'View','category'=>'products','step'=>'1','list'=>1],  
            ['slug'=>'add_product','name'=>'Create','category'=>'products','step'=>'2','list'=>1], 
            ['slug'=>'edit_product','name'=>'Edit','category'=>'products','step'=>'3','list'=>1],
            ['slug'=>'delete_product','name'=>'Delete','category'=>'products','step'=>'1','list'=>1], 

            ['slug'=>'categories_list','name'=>'View','category'=>'Category','step'=>'1','list'=>2],  
            ['slug'=>'add_category','name'=>'Create','category'=>'Category','step'=>'2','list'=>2], 
            ['slug'=>'edit_category','name'=>'Edit','category'=>'Category','step'=>'3','list'=>2],
            ['slug'=>'delete_category','name'=>'Delete','category'=>'Category','step'=>'4','list'=>2],

            ['slug'=>'suppliers_list','name'=>'View','category'=>'Supplier','step'=>'1','list'=>3],  
            ['slug'=>'add_supplier','name'=>'Create','category'=>'Supplier','step'=>'2','list'=>3], 
            ['slug'=>'edit_supplier','name'=>'Edit','category'=>'Supplier','step'=>'3','list'=>3],
            ['slug'=>'delete_supplier','name'=>'Delete','category'=>'Supplier','step'=>'4','list'=>3],

            ['slug'=>'add_lead','name'=>'Create','category'=>'Leads','step'=>'1','list'=>4],
            ['slug'=>'edit_lead','name'=>'Edit','category'=>'Leads','step'=>'2','list'=>4],
            ['slug'=>'delete_lead','name'=>'Delete','category'=>'Leads','step'=>'3','list'=>4],
            ['slug'=>'leads_list','name'=>'View','category'=>'Leads','step'=>'4','list'=>4],
            ['slug'=>'contactleads_list','name'=>'View','category'=>'Leads','step'=>'5','list'=>4],
            ['slug'=>'quoteleads_list','name'=>'View','category'=>'Leads','step'=>'6','list'=>4],
            ['slug'=>'productleads_list','name'=>'View','category'=>'Leads','step'=>'7','list'=>4],

            ['slug'=>'customers_list','name'=>'View','category'=>'customers','step'=>'1','list'=>5],
            ['slug'=>'add_customer','name'=>'Create','category'=>'customers','step'=>'2','list'=>5],
            ['slug'=>'edit_customer','name'=>'Edit','category'=>'customers','step'=>'3','list'=>5],
            ['slug'=>'delete_customer','name'=>'Delete','category'=>'customers','step'=>'4','list'=>5],

            ['slug'=>'add_appointment','name'=>'Create','category'=>'Appointment','step'=>'1','list'=>6], 
            ['slug'=>'edit_appointment','name'=>'Edit','category'=>'Appointment','step'=>'2','list'=>6],
            ['slug'=>'delete_appointment','name'=>'Delete','category'=>'Appointment','step'=>'3','list'=>6],
            ['slug'=>'appointment_list','name'=>'View','category'=>'Appointment','step'=>'4','list'=>6],  
            
            
            ['slug'=>'add_quotation','name'=>'Create','category'=>'Quotation','step'=>'1','list'=>7], 
            ['slug'=>'edit_quotation','name'=>'Edit','category'=>'Quotation','step'=>'2','list'=>7],
            ['slug'=>'delete_quotation','name'=>'Delete','category'=>'Quotation','step'=>'3','list'=>7],
            ['slug'=>'quotation_list','name'=>'View','category'=>'Quotation','step'=>'4','list'=>7],  

            ['slug'=>'add_invoice','name'=>'Create','category'=>'Invoice','step'=>'1','list'=>8], 
            ['slug'=>'edit_invoice','name'=>'Edit','category'=>'Invoice','step'=>'2','list'=>8],
            ['slug'=>'delete_invoice','name'=>'Delete','category'=>'Invoice','step'=>'3','list'=>8],
            ['slug'=>'invoice_list','name'=>'View','category'=>'Invoice','step'=>'4','list'=>8],


            // ['slug'=>'addons_list','name'=>'View','category'=>'Addons','step'=>'1','list'=>5],  
            // ['slug'=>'add_addon','name'=>'Create','category'=>'Addons','step'=>'2','list'=>5], 
            // ['slug'=>'edit_addon','name'=>'Edit','category'=>'Addons','step'=>'3','list'=>5],
            // ['slug'=>'delete_addon','name'=>'Delete','category'=>'Addons','step'=>'4','list'=>5],

           
            
            // ['slug'=>'tables_list','name'=>'View','category'=>'Table','step'=>'1','list'=>7],  
            // ['slug'=>'add_table','name'=>'Create','category'=>'Table','step'=>'2','list'=>7], 
            // ['slug'=>'edit_table','name'=>'Edit','category'=>'Table','step'=>'3','list'=>7],
            // ['slug'=>'delete_table','name'=>'Delete','category'=>'Table','step'=>'4','list'=>7],

            ['slug'=>'staffs_list','name'=>'View','category'=>'Staff','step'=>'1','list'=>9],  
            ['slug'=>'add_staff','name'=>'Create','category'=>'Staff','step'=>'2','list'=>9], 
            ['slug'=>'edit_staff','name'=>'Edit','category'=>'Staff','step'=>'3','list'=>9],
            ['slug'=>'delete_staff','name'=>'Delete','category'=>'Staff','step'=>'4','list'=>9],

            ['slug'=>'sales_report','name'=>'Sales Report','category'=>'Reports','step'=>'1','list'=>10],
            ['slug'=>'day_wise_sales_report','name'=>'Day Wise Sales Report','category'=>'Reports','step'=>'2','list'=>10],
            ['slug'=>'item_wise_sales_report','name'=>'Item Wise Sales Report','category'=>'Reports','step'=>'3','list'=>10],
            ['slug'=>'customer_report','name'=>'Customer Report','category'=>'Reports','step'=>'4','list'=>10],
            ['slug'=>'stock_report','name'=>'Stock Report','category'=>'Reports','step'=>'5','list'=>10],
            ['slug'=>'low_stock_report','name'=>'Low Stock Report','category'=>'Reports','step'=>'6','list'=>10],

            ['slug'=>'translations_list','name'=>'View','category'=>'Translation','step'=>'1','list'=>11],  
            ['slug'=>'add_translation','name'=>'Create','category'=>'Translation','step'=>'2','list'=>11], 
            ['slug'=>'edit_translation','name'=>'Edit','category'=>'Translation','step'=>'3','list'=>11],
            ['slug'=>'delete_translation','name'=>'Delete','category'=>'Translation','step'=>'4','list'=>11],

            ['slug'=>'account_settings','name'=>'Account Settings','category'=>'Settings','step'=>'1','list'=>12],  
            ['slug'=>'app_settings','name'=>'App Settings','category'=>'Settings','step'=>'2','list'=>12], 
            ['slug'=>'mail_settings','name'=>'Mail Settings','category'=>'Settings','step'=>'3','list'=>12], 

            

            
            ['slug'=>'invoices_list','name'=>'View','category'=>'Invoices','step'=>'1','list'=>13],    

            ['slug'=>'inventory_list','name'=>'View','category'=>'Invetory','step'=>'1','list'=>14],  
                   ]);
    }
}
