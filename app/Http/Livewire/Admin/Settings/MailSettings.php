<?php

namespace App\Http\Livewire\Admin\Settings;

use Image;
use Livewire\Component;
use App\Models\Mailsetting;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Artisan;

class MailSettings extends Component
{
    use WithFileUploads;
    public $settings,$mail_transport,$mail_host,$mail_port,$mail_username,$mail_password,$mail_encryption,$mail_from,$lang;
    /* render the page */
    public function render()
    {
        return view('livewire.admin.settings.mail-settings');
    }
    /* process before render */
    public function mount()
    {
        $this->settings = Mailsetting::latest()->first();
        $this->mail_transport = $this->settings->mail_transport;
        $this->mail_host = $this->settings->mail_host;
        $this->mail_port = $this->settings->mail_port;
        $this->mail_username = $this->settings->mail_username;
        $this->mail_password = $this->settings->mail_password;
        $this->mail_encryption = $this->settings->mail_encryption;
        $this->mail_from = $this->settings->mail_from;
        $this->lang = getTranslation();
        if(!Auth::user()->can('mail_settings'))
        {
            abort(404);
        }
    }
    /* save app settings */
    public function save()
    {
        $this->validate([
            'mail_transport'  => 'required',
            'mail_host' => 'required',
            'mail_port' => 'required',
            'mail_username' => 'required',
            'mail_password' => 'required',
            'mail_encryption' => 'required',
            'mail_from' => 'required|email'
        ]);
        $this->settings->mail_transport = $this->mail_transport;
        $this->settings->mail_host = $this->mail_host;
        $this->settings->mail_port = $this->mail_port;
        $this->settings->mail_username = $this->mail_username;
        $this->settings->mail_password = $this->mail_password;
        $this->settings->mail_encryption = $this->mail_encryption;
        $this->settings->mail_from = $this->mail_from;
        $this->settings->save();
        Artisan::call('config:clear');
        Artisan::call('config:cache');
        $this->dispatchBrowserEvent(
            'alert', ['type' => 'success', 'message' => 'Settings have been saved..']);
    }
}
