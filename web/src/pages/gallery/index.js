import React, { useState, useEffect } from 'react';
import { Link, useHistory } from 'react-router-dom';
import Api from '../../services/api';

import './style.css';

export default function Gallery() {
    const id = localStorage.getItem('id');
    const [myBooks, setMyBooks] = useState(['']);
    const history = useHistory();

    useEffect(() => { getMyBooks(); }, [myBooks]);

    if (localStorage.getItem('id') === null) {
        history.push('/');
        return 0
    }

    function logoff() {
        localStorage.removeItem('id');
        localStorage.removeItem('name');
        localStorage.removeItem('email');

        history.push('/');
        return 0
    }

    async function getMyBooks() {
        await Api.get(`/book/show/my/${id}`).then((response) => setMyBooks(response.data));
    }

    function updateBook(id_book) {}

    async function deleteBook(id_book) {
        const data = {
            'id_user': localStorage.getItem('id'),
            'id_book': id_book,
        };

        await Api.post('/book/destroy', data).then(res => console.log(res.data));
    }

    function render(book) {
        return (
            <div className='book-content' key={book.id}>
                <div className='information'>
                    <div className='block'>
                        <span className='tag'>Livro:</span>
                        <span className='value'>{book.title}</span>
                    </div>
                    <div className='block'>
                        <span className='tag'>Autor:</span>
                        <span className='value'>{book.author}</span>
                    </div>
                </div>
                <div className='action'>
                    <button onClick={() => deleteBook(book.id)}>Excluir</button>
                </div>
            </div>
        );
    }

    return (
        <div className='container-gallery'>
            <div className='header'>
                <div className='block'>
                    <Link to='/book'>
                        <button>Voltar</button>
                    </Link>
                    <button onClick={logoff}>sair</button>
                </div>
            </div>
            <div className='main'>
                { myBooks.map((book) => render(book)) }
            </div>
        </div>
    );
}