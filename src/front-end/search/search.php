<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Advertisement Search</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen">
    <div class="container mx-auto p-4">
        <!-- Header Section -->
        <header class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Advertisement Search</h1>
            <section class="search-bar flex items-center space-x-2">
                <input
                    type="text"
                    id="search-term"
                    placeholder="Search..."
                    class="px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                />
                <button
                    id="search-button"
                    class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 transition duration-300"
                >
                    Search
                </button>
            </section>
        </header>

        <!-- Main Section -->
        <main class="flex gap-6">
            <!-- Sidebar (Filters) -->
            <aside class="w-64 bg-white p-4 rounded-lg shadow-md">
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
                    <div>
                        <label for="tags" class="block text-sm font-medium text-gray-700">Tags:</label>
                        <input
                            type="text"
                            id="tags"
                            placeholder="comma separated tags"
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                        />
                    </div>
                    <!-- Add more filters as needed -->
                </div>
            </aside>

            <!-- Main Content (Ad List + Pagination) -->
            <section class="flex-1 bg-white p-6 rounded-lg shadow-md">
                <section class="ad-list space-y-4" id="ad-list">
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
                        class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 transition duration-300"
                    >
                        Next
                    </button>
                </section>
            </section>
        </main>
    </div>

    <script src="js/search.js"></script>
</body>
</html>