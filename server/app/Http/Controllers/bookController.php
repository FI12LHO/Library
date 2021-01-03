<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;

/**
 * @author Marlom Marques
 * @version 1.0
 * @since 12/12/2020
 */

class bookController extends Controller
{
    /**
     * Metodo responsavel por buscar, tratar e retornar a lista de livros cadastrados no banco de dados.
     * @param field - Campo que ordena a busca.
     * @return json - Lista de livros.
     */
    public function index($field = 'title') {
        $books = Book::getAllBooksOrderedByField($field);
        return json_encode($books);
    }

    /**
     * Metodo responsavel por cadastrar livros no banco de dados.
     * @param request - Obtem os dados da requisição pelo metodo POST atraves da classe Request.
     * @return json - Dados do livro que foi cadastrado.
     */
    public function create(Request $request) {
        $validated_data = $request -> validate([
            'id_user' => ['required', 'integer'],
            'title' => ['required', 'max:255'],
            'author' => ['required', 'max:255'],
            'publishing_company' => ['required', 'max:255'],
            'publishing_date' => ['required', 'max:255'],
            'num_pages' => ['required', 'integer'],
            'review' => ['required'],
        ]);
            
        $post = $request -> post();
        $data = [
            'id_user' => $post['id_user'],
            'title' => $post['title'],
            'author' => $post['author'],
            'publishing_company' => $post['publishing_company'],
            'publishing_date' => $post['publishing_date'],
            'num_pages' => $post['num_pages'],
            'review' => $post['review'],
        ];

        $book = Book::create($data);

        return json_encode($book);
    }

    /**
     * Metodo responsavel por buscar e retornar uma lista de livros correspondente ha condição.
     * @param id - Chave primaria do usuario que condiciona a busca.
     * @return json - Dados dos livros caso exista.
     */
    public function show($id) {
        $book = Book::getBookWithId($id);
        return json_encode($book);
    }

    public function showMyBooks($id) {
        $book = Book::getBooksWithIdUser($id);
        return json_encode($book);
    }

    /**
     * Metodo responsavel por atualizar os dados de um livro dentro do banco de dados.
     * @param request - Obtem os dados da requisição pelo metodo POST atraves da classe Request.
     * @param id - Chave primaria do livro que condiciona o registro afetado.
     * @return json - Dados do livro atualizado.
     */
    public function edit(Request $request, $id) {
        $validated_data = $request -> validate([
            'id_user' => ['required', 'integer'],
            'title' => ['required', 'max:255'],
            'author' => ['required', 'max:255'],
            'publishing_company' => ['required', 'max:255'],
            'publishing_date' => ['required', 'max:255'],
            'num_pages' => ['required', 'integer'],
            'review' => ['required'],
        ]);
            
        $post = $request -> post();
        $data = [
            'id_user' => $post['id_user'],
            'title' => $post['title'],
            'author' => $post['author'],
            'publishing_company' => $post['publishing_company'],
            'publishing_date' => $post['publishing_date'],
            'num_pages' => $post['num_pages'],
            'review' => $post['review'],
        ];

        $book = Book::editBookWithId($id, $data);

        return json_encode($book);
    }

    /**
     * Metodo responsavel por deletar o registro de um livro.
     * @param id - Chave primaria do livro que condiciona o registro afetado.
     * @return json
     */
    public function destroy(Request $request) {
        $validated_data = $request -> validate([
            'id_user' => ['required'],
            'id_book' => ['required'],
        ]);
        $post = $request -> post();

        $id_user = $post['id_user'];
        $id_book = $post['id_book'];

        $book = Book::deleteBookWithId($id_user, $id_book);
        return json_encode($book);
    }
}
