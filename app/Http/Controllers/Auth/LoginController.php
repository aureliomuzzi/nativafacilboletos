<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\Models\User;

class LoginController extends Controller
{
    /*
    |----------------------------------------------------------------------
    | Login Controller
    |----------------------------------------------------------------------
    |
    | Esse controller lida com a autenticação dos usuários para a aplicação,
    | redirecionando-os após o login. O controlador usa o trait
    | AuthenticatesUsers para fornecer funcionalidades convenientes.
    |
    */

    use AuthenticatesUsers;

    /**
     * Onde redirecionar os usuários após o login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Cria uma nova instância do controlador.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }

    /**
     * Sobrescreve o método username() para usar cnpj_cpf no login
     *
     * @return string
     */
    public function username()
    {
        return 'cnpj_cpf'; // Substitui email por cnpj_cpf
    }

    /**
     * Método de login.
     * Sobrescreve a validação de login para verificar CPF ou CNPJ.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function login(Request $request)
    {
        // Validação do CNPJ/CPF
        $request->validate([
            'cnpj_cpf' => 'required|string|cpf_cnpj', // Validação customizada de CPF ou CNPJ
            'password' => 'required|string|min:8',
        ]);

        // Tenta localizar o usuário pelo cnpj_cpf
        $user = User::where('cnpj_cpf', $request->cnpj_cpf)->first();

        if (!$user || !\Hash::check($request->password, $user->password)) {
            return back()->withErrors(['cnpj_cpf' => 'As credenciais informadas são inválidas.']);
        }

        \Auth::login($user); // Realiza o login

        return redirect()->intended($this->redirectTo); // Redireciona após login
    }
}
