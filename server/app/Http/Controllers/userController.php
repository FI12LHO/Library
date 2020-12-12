<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

/**
 * @author Marlom Marques
 * @version 1.0
 * @since 12/12/2020
 */
class userController extends Controller
{
    /**
     * Metodo responsavel por buscar no banco de dados um registro correspondente a requisição
     * @param request - Obtem os dados da requisição pelo metodo POST atraves da classe Request.
     * @return json - Dados do usuario caso exista
     */
    public function login(Request $request) {
        // Validando os dados recebidos da requisição
        $validated_data = $request -> validate([
            'email' => ['required', 'max:255'],
            'password' => ['required', 'max:255'],
        ]);
        
        $post = $request -> post();
        $email = $post['email'];
        $password = $post['password'];

        // Buscando um registro correspondente atraves do metodo find do model User
        $user = User::signInWithEmailAndPassword($email, $password);
        
        return json_encode($user);
    }

    /**
     * Metodo responsavel pelo cadastrado de usuarios dentro do banco de dados
     * @param request - Obtem os dados da requisição pelo metodo POST atraves da classe Request.
     * @return json - Dados do usuario que foi cadastrado
     */
    public function register(Request $request) {
        // Validando os dados recebidos da requisição
        $validated_data = $request -> validate([
            'name' => ['required', 'max:255'],
            'email' => ['required', 'max:255'],
            'password' => ['required', 'max:255'],
        ]);

        $post = $request -> post();
        $data = [
            'name' => $post['name'],
            'email' => $post['email'],
            'password' => $post['password'],
        ];

        // Criando um novo registro atraves do metodo create do model User
        $user = User::create($data);
        
        return json_encode($user);
    }
}
