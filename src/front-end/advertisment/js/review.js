
//Add Review


//comment
const submitReviewContainer = document.getElementById("add-review-container");
const submitReview = document.getElementById("add-review-submit");
const submitReviewComment = document.getElementById("add-review-input");
const submitReviewServiceId = document.getElementById("add-review-service-selection-container");

submitReview.addEventListener('click', () => {

    if (isValidUser())
        post_review(submitReviewComment.value, slider.value, '1', submitReviewServiceId.value);
});

//stars
const slider = document.getElementById("star-slider");
const stars = document.getElementsByClassName("star");

slider.addEventListener('input',() => {

    for (let i = 0; i < 5; i++)
        stars[i].classList.remove("star-selected");

    for (let i = 0; i < slider.value; i++)
        stars[i].classList.toggle("star-selected");
});
slider.value = slider.min;



function post_review(commentValue, starsValue, user_id, service_id) {

    fetch('api/reviews.php', {
        method: 'POST', // or 'GET' depending on your needs
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: new URLSearchParams({
            action: 'insertReview', 
            comment: commentValue,
            stars: starsValue,
            user: user_id,//!!!!!!!TODO!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
            service: service_id
        })
    })
    .then(response => response.json())
    .then(data => {
      // Handle the response from your PHP function here
      console.log('Success:', data);
    })
    .catch(error => {
      console.error('Error:', error);
    });
}

/*
 * isValidUser
 * Checks if user attempting to submit a review is a verified user
 * and if they are if they have already submit > 3 reviews
 */
function isValidUser() {

    return true;
}
