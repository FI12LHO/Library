import React from 'react';
import { Route, Switch, BrowserRouter } from 'react-router-dom';

// Components
import AddBook from './pages/addBook';
import Detail from './pages/detail';
import Gallery from './pages/gallery';
import Home from './pages/home';
import Login from './pages/login';
import Main from './pages/main';
import Register from './pages/register';

export default function Routes() {
    return (
        <BrowserRouter>
            <Switch>
                <Route path='/' component={Home} exact />
                <Route path='/user' component={Login} exact />
                <Route path='/user/register' component={Register} />
                <Route path='/book' component={Main} exact />
                <Route path='/book/add' component={AddBook} />
                <Route path='/book/detail/:id' component={Detail} />
                <Route path='/book/gallery' component={Gallery} />
            </Switch>
        </BrowserRouter>
    );
}