let currentPage = 1;
const pageSize = 10; // Number of ads per page

document.getElementById('search-button').addEventListener('click', () => {
    currentPage = 1;
    fetchAdvertisements();
});
document.getElementById('search-term').addEventListener('keydown', (event) => {
    if(event.key == 'Enter'){
        currentPage = 1;
        fetchAdvertisements();
    }
});

document.getElementById('search-button').addEventListener('click', () => {
    currentPage = 1;
    fetchAdvertisements();
});


document.getElementById('prev-page').addEventListener('click', () => {
    if (currentPage > 1) {
        currentPage--;
        fetchAdvertisements();
    }
});

document.getElementById('next-page').addEventListener('click', () => {
    currentPage++;
    fetchAdvertisements();
});

async function fetchAdvertisements() {
    const searchTerm = document.getElementById('search-term').value.trim();
    const beforeDate = document.getElementById('before-date').value;
    const afterDate = document.getElementById('after-date').value;
    const tags = selectedTags;

    const params = {
        method: "filterAdvertisementList",
        searchTerm: searchTerm,
        beforeDate: beforeDate || "",
        afterDate: afterDate || "",
        tags: tags.length > 0 ? tags : null,
        page: currentPage,
        count: pageSize
    };

    const filteredParams = Object.fromEntries(Object.entries(params).filter(([_, v]) => v !== undefined));

    let urlParams = new URLSearchParams(filteredParams).toString();

    await fetch(`/api/advertisement.php?${urlParams}`, {
        method: 'GET',
        headers: { "Content-Type": "application/x-www-form-urlencoded" }
    })
        .then(async response => await response.json())
        .then(data => displayAdvertisements(data))
        .catch(error => console.error('Error fetching advertisements:', error));
}

function displayAdvertisements(data) {
    if(!data) { console.log(data); }
    const adList = document.getElementById('ad-list');
    adList.innerHTML = ''; 

    data.forEach(ad => {
        const tags = JSON.parse(ad.Label)['labels'];

        const adItem = document.createElement('div');
        adItem.className = 'ad-item bg-blue-200 shadow-md rounded-lg p-4 mb-4 flex flex-col items-center text-center max-w-sm mx-auto';
        adItem.innerHTML = `
            <embed src="${ad.ImagePath}" class="w-full h-48 object-cover rounded-t-lg" />
            <h3 class="text-xl text-orange-400 font-bold mt-2">${ad.Name}</h3>
            <p class="text-gray-600 mt-2">${ad.Description}</p>
            <p class="text-gray-600  mt-2">Tags: ${tags}</p>
        `;

        //Open ad page and submit relevant Ad_ID
        const form = document.createElement('form');
        form.method = 'POST'
        form.action = 'advertisment'

        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = 'Ad_ID';
        input.value = `${ad.Ad_ID}`;
        form.appendChild(input);

        adItem.appendChild(form);

        adItem.addEventListener('click',() => {
            form.submit();
        });
        adList.appendChild(adItem);
    });

    // Update pagination controls
    document.getElementById('prev-page').disabled = currentPage === 1;
    document.getElementById('next-page').disabled = !data.hasMore;
    document.getElementById('page-info').textContent = `Page ${currentPage}`;
}

// Optionally, call fetchAdvertisements on page load to show all ads initially
window.onload = fetchAdvertisements;
