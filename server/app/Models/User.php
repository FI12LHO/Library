<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use Illuminate\Support\Facades\DB;

/**
 * @author Marlom Marques
 * @version 1.0
 * @since 12/12/2020
 */
class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * Campos da tabela associada ao model.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * Metodo responsavel por buscar e retornar os dados de um usuario segunda a condicao.
     * @param email - Valor do campo email que condiciona a busca.
     * @param password - Valor do campo password que condiciona a busca.
     * @return JSON - Dados do usuario caso exista.
     */

    static function signInWithEmailAndPassword($email, $password) {
        $exist = DB::table('users') 
            -> where('email', $email) -> where('password', $password) 
            -> exists();

        if ($exist) {
            $data = DB::table('users') 
            -> where('email', $email) -> where('password', $password) -> get();
            return $data;

        } else {
            return array('status' => 'Unknown User');
        }
    }
}
