<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Registered;
use Illuminate\Validation\ValidationException;

class UserRegister extends Component
{
    public $name, $document, $email, $password, $password_confirmation, $type;

    protected $rules = [
        'name' => 'required|string|max:255',
        'document' => 'required|string|max:18|unique:users,document',
        'email' => 'required|string|email|max:255|unique:users',
        'password' => 'required|string|min:8|confirmed',
        'type' => 'required|in:comum,lojista',
    ];

    public function register()
    {
        $this->validate();

        $cleanDocument = preg_replace('/[^0-9]/', '', $this->document);

        if ($this->type === 'comum') {
            if (strlen($cleanDocument) != 11 || !User::isValidCpf($cleanDocument)) {
                throw ValidationException::withMessages(['document' => 'CPF inválido.']);
            }
        } else {
            if (strlen($cleanDocument) != 14 || !User::isValidCnpj($cleanDocument)) {
                throw ValidationException::withMessages(['document' => 'CNPJ inválido.']);
            }
        }

        $user = User::create([
            'name' => $this->name,
            'document' => $this->document,
            'email' => $this->email,
            'password' => Hash::make($this->password),
            'type' => $this->type,
        ]);

        $user->wallet()->create(['balance' => 0]);

        event(new Registered($user));

        Auth::login($user);

        session()->flash('success', 'Cadastro realizado com sucesso!');
        return redirect()->route('verification.notice');
    }

    public function render()
    {

        return view('livewire.user-register');
    }
}
