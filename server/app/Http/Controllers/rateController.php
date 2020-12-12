<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rate;

/**
 * @author Marlom Marques
 * @version 1.0
 * @since 12/12/2020
 */
class rateController extends Controller
{
    /**
     * Metodo responsavel por cadastrar ranques no banco de dados.
     * @param request - Obtem os dados da requisição pelo metodo POST atraves da classe Request.
     * @return json - Dados do ranque que foi cadastrado.
     */
    public function create(Request $request) {
        $validated_data = $request -> validate([
            'id_user' => ['required', 'integer'],
            'id_book' => ['required', 'integer'],
            'value' => ['required'],
        ]);
            
        $post = $request -> post();
        $data = [
            'id_user' => $post['id_user'],
            'id_book' => $post['id_book'],
            'value' => $post['value'],
        ];

        $rate = Rate::create($data);

        return json_encode($rate);
    }

    /**
     * Metodo reponsavel por buscar e retornar o registro que satisfaz a condição.
     * @param id_book - Id do livro que condiciona a busca.
     * @return json - Dados resultantes da busca.
     */
    public function show($id_book) {
        $rate = Rate::getRatingWithIdBook($id_book);
        return $rate;
    }

    /**
     * Metodo responsavel por atualizar um registro.
     * @param request - Obtem os dados da requisição pelo metodo POST atraves da classe Request.
     * @return json - Dados do registro atualizado.
     */
    public function edit(Request $request) {
        $validated_data = $request -> validate([
            'id_user' => ['required', 'integer'],
            'id_book' => ['required', 'integer'],
            'value' => ['required'],
        ]);
            
        $post = $request -> post();
        $data = [
            'value' => $post['value'],
        ];

        $id_user = $post['id_user'];
        $id_book = $post['id_book'];

        $rate = Rate::editRateWithIdUserAndIdBook($id_user, $id_book, $data);
        return json_encode($rate);
    }

    /**
     * Metodo responsavel por deletar um registro.
     * @param id_user - Valor que condiciona qual registro sera afetado.
     * @param id_book - Valor que condiciona qual registro sera afetado.
     * @return json
     */
    public function destroy($id_user, $id_book) {
        $rate = Rate::deleteRateWithIdUserAndIdBook($id_user, $id_book);
        return json_encode($rate);
    }
}
