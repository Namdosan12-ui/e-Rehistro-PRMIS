// resources/js/components/Sidebar.jsx
import React from 'react';
import { FaTachometerAlt, FaUsers, FaUserMd, FaMicroscope, FaClipboardList, FaQueue, FaFileUpload } from 'react-icons/fa';

const Sidebar = () => {
    return (
        <div id="sidebar" className="bg-gray-800 text-white w-64 min-h-screen flex flex-col">
            <nav className="mt-10">
                <a href="/dashboard" className="flex items-center p-2 text-base font-normal text-white hover:bg-gray-700">
                    <FaTachometerAlt className="mr-3" />
                    <span className="nav-text">Dashboard</span>
                </a>
                <a href="/users" className="flex items-center p-2 text-base font-normal text-white hover:bg-gray-700">
                    <FaUsers className="mr-3" />
                    <span className="nav-text">Manage Users</span>
                </a>
                <a href="/patients" className="flex items-center p-2 text-base font-normal text-white hover:bg-gray-700">
                    <FaUserMd className="mr-3" />
                    <span className="nav-text">Manage Patients</span>
                </a>
                <a href="/laboratory_services" className="flex items-center p-2 text-base font-normal text-white hover:bg-gray-700">
                    <FaMicroscope className="mr-3" />
                    <span className="nav-text">Manage Services</span>
                </a>
                <a href="/transactions" className="flex items-center p-2 text-base font-normal text-white hover:bg-gray-700">
                    <FaClipboardList className="mr-3" />
                    <span className="nav-text">Manage Transactions</span>
                </a>
                <a href="/queue" className="flex items-center p-2 text-base font-normal text-white hover:bg-gray-700">
                    <FaQueue className="mr-3" />
                    <span className="nav-text">Queue</span>
                </a>
                <a href="/releasings" className="flex items-center p-2 text-base font-normal text-white hover:bg-gray-700">
                    <FaFileUpload className="mr-3" />
                    <span className="nav-text">Releasing</span>
                </a>
            </nav>
        </div>
    );
};

export default Sidebar;
