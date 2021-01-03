import React, { useState } from 'react';
import { Link, useHistory } from 'react-router-dom';
import Api from '../../services/api';

import './style.css';

export default function Login() {
    const [email, setEmail] = useState('');
    const [password, setPassword] = useState('');
    const history = useHistory();

    if (localStorage.getItem('id') !== null) {
        history.push('/book');
        return 0
    }

    async function handleLogin(e) {
        e.preventDefault();

        if (email === '' || password === '') {
            alert('Todos os campos precisam ser preenchidos.');
            return 0
        }

        const data = {
            'email': email.toLowerCase(),
            'password': password,
        };

        const response = await Api.post('/user/login', data).then(response => response.data);

        setEmail('');
        setPassword('');

        if (response.status === 'Unknown User') {
            alert('Usuario desconhecido.');
            return 0
        }

        const user = response[0];
        
        localStorage.setItem('id', user.id);
        localStorage.setItem('name', user.name);
        localStorage.setItem('email', user.email);

        console.log(user);
        history.push('/book');
    }

    return (
        <div className='container-login'>
            <form onSubmit={handleLogin} className='form' id='form'>
                <div className='block'>
                    <label htmlFor='input_email'>E-mail:</label>
                    <input
                        value={email}
                        onChange={(e) => {setEmail(e.target.value)}}
                        className='input'
                        type='email'
                        id='input_email'
                        required />
                </div>
                <div className='block'>
                    <label htmlFor='input_password'>Senha:</label>
                    <input
                        value={password}
                        onChange={(e) => {setPassword(e.target.value)}}
                        className='input'
                        type='password'
                        id='input_password'
                        required />
                </div>
            </form>

            <button type='submit' form='form'>entrar</button>
            <Link to='/user/register' className='link'>
                <span>Ainda não tem conta?</span>
            </Link>
        </div>
    );
}