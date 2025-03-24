//MORE TEST STUFF DONT MIND ME

function move() {
    console.log("clicked");

    const heading = document.getElementsByTagName("h1");

    heading[0].addEventListener('animationend', () => {
        heading[0].classList.remove('up-down');
    }, { once: true });

    heading[0].classList.add('up-down');
}