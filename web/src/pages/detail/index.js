import React, { useState, useEffect } from 'react';
import { Link, useHistory, useParams } from 'react-router-dom';
import Api from '../../services/api';

import './style.css';

export default function Detail() {
    const { id } = useParams();
    const [rate, setRate] = useState(0);
    const [comment, setComment] = useState('');
    const [bookData, setBookData] = useState({});
    const [ratings, setRatings] = useState([]);
    const history = useHistory();

    useEffect(() => {
        getBookData();
        getRatings();
    }, []);

    if (localStorage.getItem('id') === null) {
        history.push('/');
        return 0
    }

    async function getBookData() {
        await Api.get(`book/show/${id}`).then(response => setBookData(response.data));
        console.log(bookData);
    }

    async function getRatings() {
        await Api.get(`rate/show/${id}`).then(response => setRatings(response.data));
    }

    function logoff() {
        localStorage.removeItem('id');
        localStorage.removeItem('name');
        localStorage.removeItem('email');

        history.push('/');
        return 0
    }

    async function handleSubmit(e) {
        e.preventDefault();

        if (comment === '') {
            alert('O valor da nota precisa ser justificado.');
            return 0
        }

        const data = {
            'id_book': id,
            'id_user': localStorage.getItem('id'),
            'comment': comment.toLowerCase(),
            'value': rate,
            'auhtor': localStorage.getItem('name'),
        };

        setRate(0);
        setComment('');

        await Api.post('rate/create', data);
    }

    function render(rate) {
        return (
            <div className='comment'>
                <div className='comment-header'>
                    <span>{rate.author}</span>
                    <span>{rate.updated_at}</span>
                </div>
                <p>{rate.comment}</p>
            </div>
        );
    }

    return (
        <div className='container-detail'>
            <div className='header'>
                <div className='block'>
                    <Link to='/book'>
                        <button>Voltar</button>
                    </Link>
                    <Link to='/book/galery'>
                        <button>meus livros</button>
                    </Link>
                    <button onClick={logoff}>sair</button>
                </div>
            </div>
            <div className='main'>
                <div className='book-content'>
                    <div className='block'>
                        <span className='tag'>Livro:</span>
                        <span className='value'>{bookData.title}</span>
                    </div>
                    <div className='block'>
                        <span className='tag'>Autor:</span>
                        <span className='value'>{bookData.author}</span>
                    </div>
                    <div className='block'>
                        <span className='tag'>Editora:</span>
                        <span className='value'>{bookData.publishing_company}</span>
                    </div>
                    <div className='block'>
                        <span className='tag'>Quant. Paginas:</span>
                        <span className='value'>{bookData.num_pages}</span>
                    </div>
                    <div className='block' id='block-description'>
                        <p className='description'>
                            {bookData.review}
                        </p>
                    </div>
                    <form onSubmit={handleSubmit} className='form-rank'>
                        <div className='block'>
                            <span className='title'>Já leu ou conhece esse livro?</span>
                            <label className='input_value' 
                                htmlFor='input_rate'>Dê sua nota de 1 a 5:</label>
                            <input type='number' id='input_rate'
                                value={rate} step="0.010" 
                                onChange={(e) => {setRate(e.target.value)}} 
                                min={0} max={5} required />
                        </div>
                        <div className='block'>
                            <label htmlFor='textarea'>Faça um comentario.</label>
                            <textarea value={comment}
                                onChange={(e) => {setComment(e.target.value)}}
                                required></textarea>
                        </div>
                        <div className='block'>
                            <button type='submit'>Votar</button>
                        </div>
                    </form>
                </div>
                <div className='comments-container'>
                    { ratings.map((rate) => render(rate)) }
                </div>
            </div>
        </div>
    );
}