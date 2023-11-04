<?php

namespace App\Providers;

use Config;
use App\Models\Mailsetting;

use App\Models\MasterSetting;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
        $setting = new MasterSetting();
        $settings = $setting->siteData();
        $mail_setting= Mailsetting::first();
        if($mail_setting){
            $data=[
                'driver'     => $mail_setting->mail_transport,
                'host'       => $mail_setting->mail_host,
                'port'       => $mail_setting->mail_port,
                'encryption' => $mail_setting->mail_encryption,
                'username'   => $mail_setting->mail_username,
                'password'   => $mail_setting->mail_password,
                'from'       =>[
                    'address'=> $mail_setting->mail_from,
                    'name'   =>$settings['store_name'] ?? 'Laravel'
                ]
            ];

            Config::set('mail',$data);
        }
    }
}
