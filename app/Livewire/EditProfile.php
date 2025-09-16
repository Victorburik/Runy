<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class EditProfile extends Component
{
    public $name, $email, $password, $password_confirmation;

    public function mount()
    {
        $user = Auth::user();
        $this->name = $user->name;
        $this->email = $user->email;
    }

    protected $rules = [
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255',
        'password' => 'nullable|string|min:8|confirmed',
    ];

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function submit()
    {
        $this->validate();

        $user = Auth::user();

        if ($this->email !== $user->email && User::where('email', $this->email)->exists()) {
            $this->addError('email', 'E-mail já cadastrado.');
            return;
        }

        $user->name = $this->name;
        $user->email = $this->email;
        if ($this->password) {
            $user->password = Hash::make($this->password);
        }

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
            $user->save();
            $user->sendEmailVerificationNotification();
            session()->flash('success', 'Perfil atualizado. Verifique seu novo e-mail.');
        } else {
            $user->save();
            session()->flash('success', 'Perfil atualizado com sucesso!');
        }

        return redirect()->route('users.profile');
    }

    public function render()
    {
        return view('livewire.edit-profile');
    }
}