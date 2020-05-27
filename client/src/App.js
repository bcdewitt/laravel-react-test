import React, { useEffect, useState } from 'react';
import logo from './logo.svg';
import './App.css';

function App() {
  const PRODUCT_URL = `${process.env.REACT_APP_API_URL}/products`
  const [products, setProducts] = useState({
    loading: true,
    data: []
  })
  useEffect(() => {
    fetch(PRODUCT_URL).then(r => r.json()).then(d => {
      setProducts(Object.assign(d, { loading: false }))
    });
  }, [PRODUCT_URL]);

  return (
    <div className="App">
      <header className="App-header">
        <img src={logo} className="App-logo" alt="logo" />
        <p>
          Edit <code>src/App.js</code> and save to reload.
        </p>

        <a
          className="App-link"
          href="https://reactjs.org"
          target="_blank"
          rel="noopener noreferrer"
        >
          Learn React
        </a>

        <h1>
          Products
          {products.loading && ' (Loading...)'}
        </h1>

        <pre style={{textAlign: 'left'}}>{JSON.stringify(products, null, ' ')}</pre>
      </header>
    </div>
  );
}

export default App;
