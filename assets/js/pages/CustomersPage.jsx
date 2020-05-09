import React, { useEffect, useState } from 'react';
import Pagination from '../components/Pagination';
import CustomerAPI from '../services/customerAPI';

const CustomersPage = (props) => {

    const [customers, setCustomer] = useState([]);
    const [currentPage, setCurrentPage] = useState(1);
    const [search, setSearch] = useState("")

    // Permet d'aller récupérer les customers
    const fetchCustomers = async () => {
        try{
            const data = await CustomerAPI.findAll()
            setCustomer(data);
            CustomerAPI.findAll()
        }catch(error){
            console.log(error.response)
        }
    }

    //Au chargement du composant, on va chercher les customers
    useEffect(() => {
        fetchCustomers();
    }, [])


    // Gestion de la suppréssion d'un customer
    const handleDelete = async id => {

        const originalCustomers = [...customers];

        // 1. L'approche optimiste
        setCustomer(customers.filter(customer => customer.id !== id))

        //2 . L'approche pessimiste
        try{
            await CustomerAPI.delete(id)
        }catch(error){
            setCustomer(originalCustomers);
        }
        // Deuxieme facon de faire une requete (traitement de promesse)
        // CustomerAPI.delete(id)
        //     .then(response => console.log("ok"))
        //     .catch(error => {
        //         setCustomer(originalCustomers);
        //         console.log(error.response);
        //     });
    };

    // Gestion du changement de page
    const handlePageChange = page => {
        setCurrentPage(page);
    }

    // Gestion de la recherche
    const handleSearch = ({currentTarget}) => {
        setSearch(currentTarget.value);
        setCurrentPage(1);
    }

    //Nombre d'item par page
    const itemsPerPage = 20;

    // filtrage des customers en fonction de la recherche
    const filteredCustomers = customers.filter(
        c => 
            c.firstName.toLowerCase().includes(search.toLowerCase()) || 
            c.lastName.toLowerCase().includes(search.toLowerCase()) ||
            c.email.toLowerCase().includes(search.toLowerCase()) ||
            (c.company && c.company.toLowerCase().includes(search.toLowerCase()))
    )

    //Pagination des données
    const paginatedCustomers = Pagination.getDate(
        filteredCustomers, 
        currentPage, 
        itemsPerPage
    );

    return ( 
    <>
        <h1>Liste des clients</h1>

        <div className="form-group">
            <input type="text" onChange={handleSearch} value={search} className="form-control" placeholder="Rechercher ..."/>
        </div>

        <table className="table table-hover">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Client</th>
                    <th>Email</th>
                    <th>Entreprise</th>
                    <th className="text-center">Factures</th>
                    <th className="text-center">Montant total</th>
                    <th />
                </tr>
            </thead>
            <tbody>
                {paginatedCustomers.map(customer => <tr key={customer.id}>
                    <td>{customer.id}</td>
                    <td>
                        <a href="#">{customer.firstName} {customer.lastName}</a>
                    </td>
                    <td>{customer.email}</td>
                    <td>{customer.company}</td>
                    <td className="text-center ">
                        <span className="badge badge-primary">{customer.invoices.length}</span>
                    </td>
                    <td className="text-center ">{customer.totalAmount.toLocaleString()} €</td>
                    <td>
                        <button 
                        onClick={() => handleDelete(customer.id)}
                        disabled={customer.invoices.length > 0} 
                        className="btn btn-sm btn-danger">
                            Supprimer
                        </button>
                    </td>
                </tr>)}                
            </tbody>
        </table>

        { itemsPerPage < filteredCustomers.length && (<Pagination 
            currentPage={currentPage} 
            itemsPerPage={itemsPerPage} 
            length={filteredCustomers.length} 
            onPageChanged={handlePageChange} 
        />
        )} 
    </> 
    );
}

export default CustomersPage;