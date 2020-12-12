<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/**
 * @author Marlom Marques
 * @version 1.0
 * @since 12/12/2020
 */
class Rate extends Model
{
    use HasFactory;

    /**
     * Tabela associada ao model.
     * @var string
     */
    protected $table = 'ratings';

    /**
     * Campos da tabela associada ao model.
     * @var array
     */
    protected $fillable = [
        'id',
        'id_book',
        'id_user',
        'value',
    ];

    /**
     * Metodo responsavel por buscar os dados de avaliação que satisfazem a condição.
     * @param id_book - Valor que condiciona a busca.
     * @return double|string - Media dos valores cadastrados caso exista.
     */
    static function getRatingWithIdBook($id_book) {
        $exits = DB::table('ratings') -> where('id_book', $id_book) -> exists();

        if ($exits) {
            $rate = DB::table('ratings') -> where('id_book', $id_book) -> avg('value');
            $rate = \number_format($rate, 1, '.', ' ');
            return $rate;

        } else {
            return 'not rated';

        }
    }

    /**
     * Metodo responsavel por atualizar o registro de um ranque.
     * @param id_user - Valor que condiciona qual registro sera afetado.
     * @param id_book - Valor que condiciona qual registro sera afetado.
     * @param data - Novos valores.
     * @return array - Dados do ranque atualizado.
     */
    static function editRateWithIdUserAndIdBook($id_user, $id_book, $data) {
        $exits = DB::table('ratings') 
            -> where('id_user', $id_user) -> where('id_book', $id_book) -> exists();

        if ($exits) {
            DB::table('ratings') 
                -> where('id_user', $id_user) -> where('id_book', $id_book) -> update($data);

            $rate = DB::table('ratings') 
                -> where('id_user', $id_user) -> where('id_book', $id_book) -> first();

            return $rate;

        } else {
            return array(['status' => 'not rated']);

        }
    }

    /**
     * Metodo responsavel por deletar um ranque do banco de dados.
     * @param id_user - Valor que condiciona qual registro sera afetado.
     * @param id_book - Valor que condiciona qual registro sera afetado.
     * @return array
     */
    static function deleteRateWithIdUserAndIdBook($id_user, $id_book) {
        $exits = DB::table('ratings')
            -> where('id_user', $id_user) -> where('id_book', $id_book) -> exists();

        if ($exits) {
            DB::table('ratings') -> where('id_user', $id_user) 
                -> where('id_book', $id_book) -> delete();

            return array(['status' => 'rate deleted']);

        } else {
            return array(['status' => 'not rated']);

        }
    }
}
