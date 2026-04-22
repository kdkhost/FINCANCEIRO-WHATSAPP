import React from 'react';
import ReactDOM from 'react-dom/client';
import './bootstrap';

function App() {
    return null;
}

const root = document.getElementById('react-root');

if (root) {
    ReactDOM.createRoot(root).render(
        <React.StrictMode>
            <App />
        </React.StrictMode>,
    );
}
