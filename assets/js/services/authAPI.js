import axios from "axios";
import jwtDecode from "jwt-decode";


/**
 * Déconnexion (suppression du token du localStorage et sur Axios)
 */
function logout(){
    window.localStorage.removeItem("authToken");
    delete axios.defaults.headers["Authorization"];
}

/**
 * Requete HTTP d'authentification et stockage du token dans le storage et sur Axios
 * @param {object} credentials 
 */
function authenticate(credentials){
    return axios
        .post("http://localhost:8000/api/login_check", credentials)
        .then(response => response.data.token)
        .then(token => {
            console.log(token)
            // Je stocke le token dans mon localStorage
            window.localStorage.setItem("authToken", token)

            // On prévient Axios qu'on a maintenant un header par défaut sur toutes nos futures requête HTTP
            setAxiosToken(token)
        });
}


/**
 * Positionne le token JWT sur Axios
 * @param {strin} token Le token JWT
 */
function setAxiosToken(token){
    axios.defaults.headers["Authorization"] = "Bearer " + token
}

/**
 * Mise en place lors du chargement de l'application
 */
function setup() {
    // 1 . Voir si  on a  un token
    const token = window.localStorage.getItem("authToken")
    // 2 . Si le token est encore valide
    if (token){
        const {exp: expiration} = jwtDecode(token);
        if (expiration*1000 > new Date().getTime()){
            //On prévient Axios qu'on a maintenant un header par défaut sur toutes nos futures requête HTTP
            setAxiosToken(token)
        }
    }
}

/**
 * Permet de savoir si on est authentifié ou pas
 * @returns boolean
 */
function isAuthenticated(){
    // 1 . Voir si  on a  un token
    const token = window.localStorage.getItem("authToken")

    // 2 . Si le token est encore valide
    if (token){
        const {exp: expiration} = jwtDecode(token);
        if (expiration*1000 > new Date().getTime()){
            return true
        }
        return false
    }
    return false
}



export default  {
    authenticate,
    logout,
    setup,
    isAuthenticated

};