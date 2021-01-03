import React from 'react';
import { Link, useHistory } from 'react-router-dom';

import './style.css';

export default function Home() {
    const history = useHistory();
    
    if (localStorage.getItem('id') !== null) {
        history.push('/book');
        return 0
    }

    return (
        <div className='container-home'>
            <div>
                <span>Procurando um bom livro?</span>
                <span>Descubra sua proxima leitura.</span>
            </div>

            <Link to='/user' className='link'>
                <button>descubra</button>
            </Link>
        </div>
    );
}