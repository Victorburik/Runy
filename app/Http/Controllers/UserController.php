<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use App\Jobs\SendNotificationJob;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }

    public function profile()
    {
        $user = Auth::user();
        return view('users.profile', compact('user'));
    }

    public function edit()
    {
        $user = Auth::user();
        return view('users.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
        ], [
            'email.unique' => 'E-mail já cadastrado.',
        ]);

        // Atualiza dados
        $user->name = $request->name;
        $user->email = $request->email;
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        // Se o e-mail mudou, resetar verificação
        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
            $user->save();
            $user->sendEmailVerificationNotification();
            $message = 'Perfil atualizado. Verifique seu novo e-mail.';
        } else {
            $user->save();
            $message = 'Perfil atualizado com sucesso!';
        }

        return redirect()->route('users.profile')->with('success', $message);
    }

    public function index()
    {
        $users = User::where('id', '!=', Auth::id())->get(['id', 'name', 'type', 'document']);
        return view('users.index', compact('users'));
    }

    public function destroy(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'password' => 'required|string',
        ]);

        // Verifica senha
        if (!Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages(['password' => 'Senha incorreta.']);
        }

        // Impede exclusão se houver transferências pendentes
        if ($user->sentTransfers()->where('status', 'pending')->exists() ||
            $user->receivedTransfers()->where('status', 'pending')->exists()) {
            throw ValidationException::withMessages(['password' => 'Não é possível excluir a conta com transferências pendentes.']);
        }

        // Notifica exclusão (opcional)
        SendNotificationJob::dispatch($user, null, 0, "Sua conta foi excluída.");

        // Exclui usuário (soft delete, se configurado)
        $user->delete();

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'Conta excluída com sucesso!');
    }
}