<?php

include __DIR__ . '/../global/get-nav.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Advertisement Search</title>
    <link rel="stylesheet"
href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css"
integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1"
crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="/css/search.css">
    <link rel="stylesheet" href="../front-end/global/css/nav.css">
    
    <style>

        @font-face {                                                                                                                                                                                                   
            font-family: 'custom-font';
            src: url('../../fonts/myFont.ttf') format('truetype');
        }

        h1, h2 {
            z-index: 1;
            font-size: 8rem;
        }
        h3 {
            font-size: 2rem;
        }

        html, body {
            background-color: #f0e3d9;
            overflow-x: hidden;
            font-family: custom-font, sans-serif !important;
            color: #bb5320;

        }
        .custom-scrollbar::-webkit-scrollbar {
            display: none; /* Completely hides the scrollbar */
        }

        /* Hide scrollbar for IE, Edge, and Firefox */
        .custom-scrollbar {
            -ms-overflow-style: none; /* Hides scrollbar in IE and Edge */
            scrollbar-width: none; /* Hides scrollbar in Firefox */
        }

        .selected {
            background-color: ;
        }


        #tagView {
            display: flex;
            flex-wrap: wrap; 
            gap: 0.5rem;
        }

        .tag-view-item {
            background-color: #1e293b;
            color: white; 
            padding: 0.25rem 0.75rem; 
            border-radius: 9999px; 
            font-size: 0.875rem; 
            display: flex;
            align-items: center;
            gap: 0.5rem;
            cursor: pointer;
            transition: background-color 0.2s ease;
        }

        .tag-view-item:hover {
            background-color: #171f2a; 
        }

        
        .tag-view-item .close-btn {
            font-size: 1rem;
            line-height: 1;
            cursor: pointer;
            opacity: 0.7;
            transition: opacity 0.2s ease;
        }

        .tag-view-item .close-btn:hover {
            opacity: 1; 
        }

        .tag-container{
            width: 80%;
            padding: 10px;
            background-color: #a3cae7 ;
            border-radius: 25px;
            margin: 10px 10px 10px 10px;
            border: 3px solid black;
            box-shadow: 10px 10px #4c4949 ;
            z-index: 1;
        }

        .tag-container:hover {
            box-shadow: 10px 10px white;
            cursor: pointer;
        }

        .tag-container-selected >button{
            background-color: #348acb ;
            box-shadow: 10px 10px white;

        }

        .ad-item > .ad-item-description { 
            height: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center !important;
        }

        .ad-item > .ad-item-tags { 
            height: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: end !important;
        }

        button {
            cursor: pointer;
        }

        .pointer {
            cursor: pointer;
        }

        .tag-height {
            max-height: 450px;
        }

    </style>
</head>
<body class="min-h-screen">
<?php get_nav() ?>
    <!-- Header Section 
    <nav>
        <ul style="display: flex;list-style:none;">

            <li><a class="text-lg" href="#">FurSure</a></li>
            <li style="flex:1;text-align:center;"><a href="search" class=""></span> Search</a></li>
            <li style="flex:1;text-align:end;max-width: max-content"><a href="register"><span class="glyphicon glyphicon-user"></span> Sign Up</a></li>
            <li style="flex:1;text-align:end;max-width: max-content;margin-left: 20px"><a href="login"><span class="glyphicon glyphicon-user"></span> Login</a></li>

        </ul>
    </nav>-->

    <div class="container mx-auto p-4">

        <!-- Main Section -->
        <main class="flex gap-6">
            <!-- Sidebar (Filters) -->
            <aside class="w-64 bg-orange-200 p-4 rounded-lg shadow-md">
                <h2 class="text-lg font-semibold text-gray-800 mb-4">Filters</h2>
                <div class="space-y-4">
                    <div>
                        <label for="before-date" class="block text-sm font-medium text-gray-700">Before Date:</label>
                        <input
                            type="date"
                            id="before-date"
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                        />
                    </div>
                    <div>
                        <label for="after-date" class="block text-sm font-medium text-gray-700">After Date:</label>
                        <input
                            type="date"
                            id="after-date"
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                        />
                    </div>
                    <h1 class = "block text-lg font-medium text-gray-900">Tags:</h1>
                    <div class="w-full max-w-md mx-auto mt-8">
                        <div class="w-[225px] tag-height bg-orange-400 flex flex-col border border-orange-400 rounded-lg shadow-lg overflow-y-auto p-4 space-y-2 custom-scrollbar" id="tagBox" style="height: 1200px">
                            <!-- Tags will be dynamically inserted here -->
                        </div>
                    </div>
                    <div id="tagView" class="mt-4 flex flex-wrap gap-2"></div>
                </div>
            </aside>

            <!-- Main Content (Ad List + Pagination) -->
            <section class="flex-1 bg-orange-200 p-6 rounded-lg shadow-md">

                <!-- Search Bar -->
                <section class="search-bar flex space-x-2 p-4">
                    <input
                        type="text"
                        id="search-term"
                        placeholder="Search..."
                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                    />
                    <button
                        id="search-button"
                        class="px-4 py-2 bg-blue-400 text-white rounded-md hover:bg-blue-600 transition duration-300 "
                    >
                        Search
                    </button>
                </section>

                <section class="ad-list grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6" id="ad-list">
                    <!-- Placeholder for dynamically inserted ads -->
                </section>

                <!-- Pagination -->
                <section class="pagination mt-6 flex justify-between items-center">
                    <button
                        id="prev-page"
                        class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 transition duration-300 disabled:opacity-50"
                        disabled
                    >
                        Previous
                    </button>
                    <span id="page-info" class="text-gray-700">Page 1</span>
                    <button
                        id="next-page"
                        class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 cursor-pointer transition duration-300 disabled:opacity-50"
                    >
                        Next
                    </button>
                </section>
            </section>
        </main>
    </div>

    
    <script src="js/search.js"></script>
    <script src="js/tags.js"></script>
</body>
</html>
