let currentPage = 1;
const pageSize = 10; // Number of ads per page

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
    const searchTerm = document.getElementById('search-term').value;
    const beforeDate = document.getElementById('before-date').value;
    const afterDate = document.getElementById('after-date').value;
    const tags = document.getElementById('tags').value.split(',').map(tag => tag.trim()).filter(tag => tag);

    const params = {
        method: "filterAdvertisementList",
        searchTerm: searchTerm,
        beforeDate: beforeDate || null,
        afterDate: afterDate || null,
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
        .then(response => response.json())
        .then(data => displayAdvertisements(data))
        .catch(error => console.error('Error fetching advertisements:', error));
}

function displayAdvertisements(data) {
    console.log(data);
    if(!data) { console.log(data); return; }
    const adList = document.getElementById('ad-list');
    adList.innerHTML = ''; // Clear previous results

    data.forEach(ad => {
        const adItem = document.createElement('div');
        adItem.className = 'ad-item';
        adItem.innerHTML = `
            <embed src="${ad.ImagePath}" >
            <h3>${ad.Name}</h3>
            <p>${ad.Description}</p>
            <p>Tags: ${ad.Label}</p>
        `;
        adList.appendChild(adItem);
    });

    // Update pagination controls
    document.getElementById('prev-page').disabled = currentPage === 1;
    document.getElementById('next-page').disabled = !data.hasMore;
    document.getElementById('page-info').textContent = `Page ${currentPage}`;
}

// Optionally, call fetchAdvertisements on page load to show all ads initially
window.onload = fetchAdvertisements;