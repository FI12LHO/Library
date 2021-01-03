import React, { useState } from 'react';
import { useHistory } from 'react-router-dom';
import Api from '../../services/api';

import './style.css';

export default function AddBook() {
    const [title, setTitle] = useState('');
    const [author, setAuthor] = useState('');
    const [publishingCompany, setPublishingCompany] = useState('');
    const [publishingDate, setPublishingDate] = useState('');
    const [numPages, setNumPages] = useState(0);
    const [review, setReview] = useState('');
    const history = useHistory();

    async function handleSubmit(e) {
        e.preventDefault();

        if (title === '' 
            || author === '' 
            || publishingCompany === '' 
            || publishingDate === ''
            || numPages === 0
            || review === '' ) {
            alert('Todos os campos precisam ser preenchidos.');
            return 0
        }

        const data = {
            'id_user': localStorage.getItem('id'),
            'title': title.toLowerCase(),
            'author': author.toLowerCase(),
            'num_pages': numPages.toLowerCase(),
            'publishing_company': publishingCompany.toLowerCase(),
            'publishing_date': publishingDate.toLowerCase(),
            'review': review.toLowerCase(),
        };

        await Api.post('/book/create', data).then(response => response.data);

        setTitle('');
        setAuthor('');
        setPublishingCompany('');
        setPublishingDate('');
        setNumPages('');
        setReview('');

        history.push('/book');
    }

    return (
        <div className='container-addBook'>
            <form onSubmit={handleSubmit} className='form' id='form'>
                <div className='block'>
                    <label htmlFor='input_author'>Autor:</label>
                    <input
                        value={author}
                        onChange={(e) => {setAuthor(e.target.value)}}
                        className='input'
                        type='text'
                        id='input_author'
                        required />
                </div>
                <div className='block'>
                    <label htmlFor='input_title'>Title:</label>
                    <input
                        value={title}
                        onChange={(e) => {setTitle(e.target.value)}}
                        className='input'
                        type='text'
                        id='input_title'
                        required />
                </div>
                <div className='block'>
                    <label htmlFor='input_num_pages'>Quantidade de Paginas:</label>
                    <input
                        value={numPages}
                        onChange={(e) => {setNumPages(e.target.value)}}
                        className='input'
                        type='number'
                        min='0'
                        id='input_num_pages'
                        required />
                </div>
                <div className='block'>
                    <label htmlFor='input_publishing_company'>Editora:</label>
                    <input
                        value={publishingCompany}
                        onChange={(e) => {setPublishingCompany(e.target.value)}}
                        className='input'
                        type='text'
                        id='input_publishing_company'
                        required />
                </div>
                <div className='block'>
                    <label htmlFor='input_publishing_date'>Date:</label>
                    <input
                        value={publishingDate}
                        onChange={(e) => {setPublishingDate(e.target.value)}}
                        className='input'
                        type='date'
                        id='input_publishing_date'
                        required />
                </div>
                <div className='block'>
                    <label htmlFor='textarea_review'>Sinopse:</label>
                    <textarea
                        value={review}
                        onChange={(e) => {setReview(e.target.value)}}
                        id='textarea_review'
                        required></textarea>
                </div>
            </form>

            <button type='submit' form='form'>Adicionar</button>
        </div>
    );
}