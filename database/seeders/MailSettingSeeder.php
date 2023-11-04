<?php

namespace Database\Seeders;

use App\Models\Mailsetting;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class MailSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Mailsetting::create([
            'mail_transport'    =>'smtp',
            'mail_host'         =>'sandbox.smtp.mailtrap.io',
            'mail_port'         =>'2525',
            'mail_username'     =>'c9b9e7731309e8',
            'mail_password'     =>'********1819',
            'mail_encryption'   =>'tls',
            'mail_from'         =>'appemailtest12@gmail.com'
        ]);
    }
}
