import React from 'react';
import ReactDOM from 'react-dom/client';
import Sidebar from './components/Sidebar';

if (document.getElementById('app')) {
    const root = ReactDOM.createRoot(document.getElementById('app'));
    root.render(<Sidebar />);
}
