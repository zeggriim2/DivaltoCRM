/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

//Les imports importants
import React from 'react';
import ReactDom from "react-dom";

// any CSS you import will output into a single css file (app.css in this case)
import '../css/app.css';
import Navbar from './components/Navbar';
import HomePage from './pages/HomePage';
import { HashRouter, Switch, Route } from "react-router-dom";
import CustomersPage from './pages/CustomersPage';
import CustomersPageWithPagination from './pages/CustomersPageWithPagination';
import InvoicesPage from './pages/InvoicesPage';


// Need jQuery? Install it with "yarn add jquery", then uncomment to import it.
// import $ from 'jquery';

console.log('Hello world!!');

//localhost:8000/#/

const App = () => {
    return <HashRouter> 
        <Navbar />
            <main className="container pt-5">
                <Switch>
                    {/* Mettre les routes de plus spécifique ou plus simple */}

                    <Route path="/customers" component={CustomersPage} />
                    <Route path="/invoices" component={InvoicesPage} />
                    <Route path="/" component={HomePage} />
                </Switch>
            </main>
    </HashRouter>
}

const rootElement = document.querySelector('#app');
ReactDom.render(<App />, rootElement);