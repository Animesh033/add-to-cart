import { useRef, useState } from 'react';

import Input from '../../UI/Input';
import classes from './MealItemForm.module.css';

const SearchForm = (props) => {
    const searchInputRef = useRef();

    const submitSearchHandler = (event) => {
        event.preventDefault();
        const searchQuery = searchInputRef.current.value || null;
        props.onAddToSearch(searchQuery);
    };

    return (
        <form className={classes.form} onSubmit={submitSearchHandler}>
            <Input
                ref={searchInputRef}
                input={{
                    id: 'search_' + props.id,
                    type: 'string',
                    defaultValue: '',
                }}
            />
            <button>Search</button>
        </form>
    );
};

export default SearchForm;