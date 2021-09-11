import React from 'react';

import ExpenseItem from './ExpenseItem';
import Card from '../UI/Card';
import './Expenses.css';

const Expenses = (props) => {
  return (
    <Card className="expenses">
      <ExpenseItem
        title={props.items[0].name}
        amount={props.items[0].description}
        date={props.items[0].image_url}
      />
      <ExpenseItem
        title={props.items[1].name}
        amount={props.items[1].description}
        date={props.items[1].image_url}
      />
      <ExpenseItem
        title={props.items[2].name}
        amount={props.items[2].description}
        date={props.items[2].image_url}
      />
      <ExpenseItem
        title={props.items[3].name}
        amount={props.items[3].description}
        date={props.items[3].image_url}
      />
    </Card>
  );
}

export default Expenses;