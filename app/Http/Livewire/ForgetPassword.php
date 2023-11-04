<?php

namespace App\Http\Livewire;

use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Str;
use App\Mail\ForgetPasswordMail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class ForgetPassword extends Component
{
    public $email,$password,$lang;
    /* render the page */
    public function render()
    {
        return view('livewire.forget-password')->layout('layouts.login_layout');
    }
    /* login check */
    public function forget()
    {
        $this->validate([
            'email' => 'required|email'
        ]);
        $user=User::checkUserEmail($this->email);
        if ($user) {
            $user->remember_token= Str::random(30);
            $user->save();
            
            Mail::to($user->email)->send(new ForgetPasswordMail($user));
            session()->flash('message', 'Please check your email to reset your password.');
            return redirect()->back();

            // return redirect()->route('reset-password', ['token' => $user->remember_token]);
        }
        else{
            $this->addError('error','Ivalid Email. User dosent exsits.');
        }
    }

    public function login(){
        return redirect()->route('login');
    }
    /* process before render */
    public function mount()
    {
        $this->lang = getTranslation();
    }
}
