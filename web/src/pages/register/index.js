import React, { useState } from 'react';
import { Link, useHistory } from 'react-router-dom';
import Api from '../../services/api';

import './style.css';

export default function Register() {
    const [name, setName] = useState('');
    const [email, setEmail] = useState('');
    const [password, setPassword] = useState('');
    const [confirm, setConfirm] = useState('');
    const history = useHistory();

    if (localStorage.getItem('id') !== null) {
        history.push('/book');
        return 0
    }

    async function handleRegister(e) {
        e.preventDefault();

        if (name === '' || email === '' || password === '' || confirm === '') {
            alert('Todos os campos precisam ser preenchidos.');
            return 0
        }

        if (password.length < 6) {
            alert('A senha precisa ser um pouco maior (min 6 caracteres).');
            return 0
        }

        if (password !== confirm) {
            alert('As senhas não são iguais.');
            return 0
        }

        const data = {
            'name': name.toLowerCase(),
            'email': email.toLowerCase(),
            'password': password,
        };

        await Api.post('/user/register', data).then(response => response.data);

        setName('');
        setEmail('');
        setPassword('');
        setConfirm('');

        history.push('/user');
    }

    return (
        <div className='container-register'>
            <form onSubmit={handleRegister} className='form' id='form'>
                <div className='block'>
                    <label htmlFor='input_name'>Nome:</label>
                    <input
                        value={name}
                        onChange={(e) => {setName(e.target.value)}}
                        className='input'
                        type='text'
                        id='input_name'
                        required />
                </div>
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
                <div className='block'>
                    <label htmlFor='input_confirm'>Confirme a senha:</label>
                    <input
                        value={confirm}
                        onChange={(e) => {setConfirm(e.target.value)}}
                        className='input'
                        type='password'
                        id='input_confirm'
                        required />
                </div>
            </form>

            <button type='submit' form='form'>Cadastrar</button>
            <Link to='/user' className='link'>
                <span>Ja tem conta?</span>
            </Link>
        </div>
    );
}