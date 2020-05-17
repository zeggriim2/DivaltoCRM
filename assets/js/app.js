/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

//Les imports importants
import React, {useState} from 'react';
import ReactDom from "react-dom";

// any CSS you import will output into a single css file (app.css in this case)
import '../css/app.css';
import Navbar from './components/Navbar';
import HomePage from './pages/HomePage';
import { HashRouter, Switch, Route, withRouter } from "react-router-dom";
import CustomersPage from './pages/CustomersPage';
import InvoicesPage from './pages/InvoicesPage';
import LoginPage from './pages/LoginPage';
import AuthAPI from './services/authAPI';
import AuthContext from './contexts/AuthContext'
import PrivateRoute from './components/PrivateRoute'


// Need jQuery? Install it with "yarn add jquery", then uncomment to import it.
// import $ from 'jquery';

console.log('Hello world!!');

// On apporte de CSS personnalisé
// require("../css/app.css");
AuthAPI.setup();
//localhost:8000/#/

const App = () => {
    const [isAuthenticated, setIsAuthenticated] = useState(AuthAPI.isAuthenticated()); 

    const NavbarWithRouter = withRouter(Navbar);

    return  <AuthContext.Provider value={{
        isAuthenticated,
        setIsAuthenticated
    }}>
                <HashRouter> 
                    <NavbarWithRouter />
                    
                        <main className="container pt-5">
                            <Switch>
                                {/* Mettre les routes de plus spécifique ou plus simple */}

                                <Route path="/login"  
                                        component={LoginPage}
                                />
                                
                                <PrivateRoute path="/invoices" isAuthenticated={isAuthenticated} component={InvoicesPage} />
                                <PrivateRoute path="/customers" isAuthenticated={isAuthenticated} component={CustomersPage} />

                                <Route path="/" component={HomePage} />
                            </Switch>
                        </main>
                </HashRouter>
            </AuthContext.Provider>
}

const rootElement = document.querySelector('#app');
ReactDom.render(<App />, rootElement);