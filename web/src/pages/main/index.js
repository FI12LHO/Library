import React, { useState, useEffect } from 'react';
import { Link, useHistory } from 'react-router-dom';
import Api from '../../services/api';

import ArrowUp from '../../assets/arrow-up.svg';
import ArrowDown from '../../assets/arrow-down.svg';
import './style.css';

export default function Main() {
    const [filter, setFilter] = useState('title');
    const [books, setBooks] = useState([]);
    const history = useHistory();

    useEffect(() => {
        Api.get(`/book/${filter}`).then((response) => {setBooks(response.data)});
    }, [books]);

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

    function renderBook(book) {
        return (
            <div className='book-content' key={book.id}>
                <div className='block'>
                    <span className='tag'>Livro:</span>
                    <span className='value'>{book.title}</span>
                </div>
                <div className='block'>
                    <span className='tag'>Autor:</span>
                    <span className='value'>{book.author}</span>
                </div>
                <div className='block'>
                    <span className='tag'>Editora:</span>
                    <span className='value'>{book.publishing_company}</span>
                </div>
                <div className='block'>
                    <span className='tag'>Nota:</span>
                    <span className='value'>{book.rate}</span>
                </div>
                <Link to={`/book/detail/${book.id_book}`} className='link'>
                    <button>mais</button>
                </Link>
            </div>
        );
    }

    return (
        <div className='container-main'>
            <div className='header'>
                <div className='block'>
                    <Link to='/book/add'>
                        <button>Adicionar<br />livro</button>
                    </Link>
                    <Link to='/book/gallery'>
                        <button>meus livros</button>
                    </Link>
                    <button onClick={logoff}>sair</button>
                </div>
            </div>
            <div className='main'>
                <div className='filter-container'>
                    <div className='filter' onClick={() => {setFilter('title');}}>
                        <label>Titulo</label>
                        <img src={(filter === 'title') ? ArrowUp : ArrowDown} 
                            alt='' className='image-filter' />
                    </div>
                    <div className='filter' onClick={() => {setFilter('author');}}>
                        <label>Autor</label>
                        <img src={(filter === 'author') ? ArrowUp : ArrowDown} 
                            alt='' className='image-filter' />
                    </div>
                    <div className='filter' onClick={() => {setFilter('publishing_company');}}>
                        <label>Editora</label>
                        <img src={(filter === 'publishing_company') ? ArrowUp : ArrowDown} 
                            alt='' className='image-filter' />
                    </div>
                </div>
                {books.map((book) => { return renderBook(book) })}
            </div>
        </div>
    );
}