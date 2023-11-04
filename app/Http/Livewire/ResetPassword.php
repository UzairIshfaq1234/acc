<?php

namespace App\Http\Livewire;

use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ResetPassword extends Component
{
    public $token,$password,$password_confirmation,$lang;
    /* render the page */
    public function render()
    {
        return view('livewire.reset-password')->layout('layouts.login_layout');
    }
    /* process before render */
    public function mount($token)
    {
        $this->lang = getTranslation();
        $user=User::checkUserToken($token);
        if($user){
            $this->token=$token;
        }else{
            abort(404);
        }
    }
    /* reset */
    public function resetpassword()
    {
        $this->validate([
            'password'  => 'required|confirmed'
        ]);

        $user=User::checkUserToken($this->token);
        $user->password=Hash::make($this->password);
        $user->save();
        session()->flash('message', 'Password Reset.');
        return redirect()->route('login');
    }
}
