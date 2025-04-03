const selectedTags = [];

const tagButtons = document.getElementsByClassName('tag-button');
const tagView = document.getElementById('tagView');
const tagBox = document.getElementById("tagBox");

function updateTagView() {
    tagView.innerHTML = '';

    selectedTags.forEach((tag) => {
        const tagElement = document.createElement('span');
        tagElement.className = 'tag-view-item';

        tagElement.textContent = tag;
        const closeButton = document.createElement('span');
        closeButton.className = 'close-btn';
        closeButton.textContent = '×';
        closeButton.addEventListener('click', () => {
            selectingTags = true;
            const index = selectedTags.indexOf(tag);
            if (index !== -1) {
                selectedTags.splice(index, 1);
                updateTagView(); 
            }
        });

        tagElement.appendChild(closeButton);

        tagView.appendChild(tagElement);
    });
}


async function getTags() {
    await fetch("/api/tags.php?method=fetchAll", {
        method: 'GET',
        headers: { "Content-Type": "application/x-www-form-urlencoded" }
    })
    .then(result => result.json())
    .then(data => displayTags(data))
    .catch(error => console.log(error))
}

function displayTags(data) {
    tagBox.innerHTML = ''; // Clear existing content

    data.forEach(tagData => {
        const tag = document.createElement("div");
        tag.className = "tag-button inline-block mr-2 mb-2";

        tag.innerHTML = `
            <button class="bg-blue-400 hover:bg-blue-500 text-white font-semibold py-2 px-4 rounded-lg shadow-md transition duration-300 ease-in-out">
                ${tagData.Description}
            </button>
        `;

        tag.addEventListener('click', function () {
            const button = this.querySelector("button");

            const value = tagData.Description;

            const index = selectedTags.indexOf(value);
            selectingTags = true;

            if(index === -1){
                selectedTags.push(value);
                button.classList.remove('bg-blue-400');
                button.classList.remove('hover:bg-blue-500');
                button.classList.add('bg-blue-800');
            }
            else {
                selectedTags.splice(index, 1);
                button.classList.remove('bg-blue-800');
                button.classList.add('hover:bg-blue-500');
                button.classList.add('bg-blue-400');
            }

            updateTagView();
        });

        tagBox.append(tag);
    });
}

getTags();