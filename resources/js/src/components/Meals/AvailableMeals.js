import Card from '../UI/Card';
import MealItem from './MealItem/MealItem';
import classes from './AvailableMeals.module.css';
import React, { useState, useEffect } from "react";
import SearchForm from '../Meals/MealItem/SearchForm';

const apiUrl = "http://127.0.0.1:8000/api/";
const AvailableMeals = () => {
    const [products, setProducts] = useState([]);

    useEffect(() => {
        getProducts();
    }, []);

    const getProducts = async () => {
        const response = await axios.get(apiUrl + 'products');
        setProducts(response.data.data);
    };
    console.log('products');
    console.log(products);
    const addToSearchHandler = async (searchQuery) => {
        const response = await axios.get(apiUrl + 'products/search/' + searchQuery);
        console.log(response.data.data);
        setProducts(response.data.data);
    };

    const mealsList = products.map((meal) => (
        <MealItem
            key={meal.id}
            id={meal.id}
            name={meal.name}
            description={meal.description}
            price={meal.price}
        />
    ));

    return (
        <section className={classes.meals}>
            <Card>
                <SearchForm onAddToSearch={addToSearchHandler} />
                <ul>{mealsList}</ul>
            </Card>
        </section>
    );
};

export default AvailableMeals;