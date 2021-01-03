<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Models\Rate;

/**
 * @author Marlom Marques
 * @version 1.0
 * @since 12/12/2020
 */
class Book extends Model
{
    use HasFactory;

    /**
     * Tabela associada ao model.
     * @var string
     */
    protected $table = 'books';

    /**
     * Campos da tabela associada ao model.
     * @var array
     */
    protected $fillable = [
        'id_user',
        'title',
        'author',
        'publishing_company',
        'publishing_date',
        'num_pages',
        'review',
    ];

    /**
     * Metodo responsavel por buscar os livros dentro do banco de dados ordenados por coluna.
     * @param field - Campo que ordena a busca.
     * @return array - Lista decrescente de livros ordenados por coluna.
     */
    static function getAllBooksOrderedByField($field) {
        $tmp_array = DB::table('books') -> orderByDesc($field) -> get();
        $books = [];

        foreach ($tmp_array as $book) {
            $rate = Rate::getAvgRatingWithIdBook($book -> id);

            $new_array = [
                'id_book' => $book -> id,
                'id_user' => $book -> id_user,
                'title' => $book -> title,
                'author' => $book -> author,
                'publishing_company' => $book -> publishing_company,
                'publishing_date' => $book -> publishing_date,
                'num_pages' => $book -> num_pages,
                'review' => $book -> review,
                'rate' => $rate,
            ];

            $books[] = $new_array;
        }

        return $books; 
    }

    /**
     * Metodo responsavel por buscar e retornar um livro.
     * @param id - Valor que condiciona a busca.
     * @return array - Dados dos livros caso exista.
     */
    static function getBookWithId($id) {
        $exits = DB::table('books') -> where('id', $id) -> exists();

        if ($exits) {
            $book = DB::table('books') -> where('id', $id) -> first();
            return $book;

        } else {
            return array(['status' => 'book not found']);

        }
    }

    /**
     * Metodo responsavel por buscar e retornar lista de livros.
     * @param id - Valor que condiciona a busca.
     * @return array - Dados dos livros caso exista.
     */
    static function getBooksWithIdUser($id) {
        $book = DB::table('books') -> where('id_user', $id) -> get();
        return $book;
    }

    /**
     * Metodo responsavel por atualizar o registro de um livro.
     * @param id - Valor que condiciona qual registro sera afetado.
     * @param data - Novos valores.
     * @return array - Dados do livro atualizado.
     */
    static function editBookWithId($id, $data) {
        $exits = DB::table('books') -> where('id', $id) -> exists();

        if ($exits) {
            DB::table('books') -> where('id', $id) -> update($data);
            $book = DB::table('books') -> where('id', $id) -> first();
            return $book;

        } else {
            return array(['status' => 'book not found']);

        }
    }

    /**
     * Metodo responsavel por deletar um livro do banco de dados.
     * @param id - Valor que condiciona qual registro sera afetado.
     * @return array
     */
    static function deleteBookWithId($id, $id_book) {
        $exits = DB::table('books') -> where('id_user', $id) -> where('id', $id_book) -> exists();

        if ($exits) {
            DB::table('books') -> where('id', $id_book) -> where('id_user', $id) -> delete();
            return array(['status' => 'book deleted']);

        } else {
            return array(['status' => 'book not found']);

        }
    }
}
