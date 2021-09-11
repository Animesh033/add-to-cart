import React from 'react';
import ReactDOM from 'react-dom';
import Expenses from './Expenses/Expenses';
// const App = () => {
//   const products = [];
//   axios.get('http://127.0.0.1:8000/api/products').then(
//     (response) => {
//       products = response.data;
//       console.log(products);
//     },
//     (error) => {
//       console.log(error);
//     }
//   );
//   return (
//     <div>
//       <h2>Let's get started!</h2>
//       <Expenses items={products} />
//     </div>
//   );
// }
class App extends React.Component {
  constructor(props) {
    super(props);
    this.state = {
      products: [],
      errorMessage: ''
    };
  }
  // componentDidMount() {
  //   // Simple GET request using axios
  //   axios.get('http://127.0.0.1:8000/api/products')
  //     .then(response => this.setState({ products: response.data }));
  // }
  async componentDidMount() {
    // GET request using axios with async/await
    const response = await axios.get('http://127.0.0.1:8000/api/products');
    this.setState({ products: response.data.data })
    console.log(this.state.products);
  }

  render() {
    return (
      <div>
        <h2>Let's get started!</h2>
        {/* <Expenses items={this.state.products} /> */}
      </div>
    );
  }
}
export default App;

if (document.getElementById('root')) {
  ReactDOM.render(<App />, document.getElementById('root'));
}
