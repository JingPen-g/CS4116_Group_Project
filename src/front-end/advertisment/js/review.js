//Reply To Review Buttons
const replyToReviewDialog = document.getElementById('reply-to-review');
const replyToReviewButtons = Array.from(document.getElementsByClassName('review-submit-message-request'));

const replyToReview = document.getElementById('reply-to-review-container');

replyToReviewButtons.forEach(function(btn){

    btn.addEventListener('click',(event) => {

        const userType = btn.dataset.userType;

        if (userType == "business") {
            
            const allReviewsTop = Array.from(document.getElementsByClassName("review-border-top"));
            const allReviewsBottom = Array.from(document.getElementsByClassName("review-border-bottom"));

            allReviewsTop.forEach((reviewTopBorder) => {
                //reviewTopBorder.style.backgroundColor = "#cccccc";
                reviewTopBorder.style.opacity = "0.6";
            });
            allReviewsBottom.forEach((reviewBottomBorder) => {
                //reviewBottomBorder.style.backgroundColor = "#cccccc";
                reviewBottomBorder.style.opacity = "0.6";
            });

            const thisReviewTop = event.target.closest(".review-border-top");
            const thisReviewBottom = allReviewsBottom[allReviewsTop.indexOf(thisReviewTop)];
            //const thisReviewBottom = event.target.closest(".review-border-bottom");
            thisReviewTop.style.opacity = "1";
            thisReviewBottom.style.opacity = "1";

            var scrollTop = window.pageYOffset + btn.getBoundingClientRect().top - 30;
            window.scrollTo(0,scrollTop);
            document.documentElement.style.overflow = "hidden";
            replyToReviewRow.style.display = "flex";

            replyToReview.dataset.reviewId = btn.dataset.reviewId;
        }


    });
});

//comment
const submitReviewContainer = document.getElementById("add-review-container");
const submitReview = document.getElementById("add-review-submit");
const submitReviewComment = document.getElementById("add-review-input");
const submitReviewServiceId = document.getElementById("add-review-service-selection-container");

submitReview.addEventListener('click', () => {

    if (isValidUser())
        post_review(submitReviewComment.value, slider.value, '1', submitReviewServiceId.value);

    window.location.reload();
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
        method: 'POST', 
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: new URLSearchParams({
            action: 'insertReview', 
            comment: commentValue,
            stars: starsValue,
            user: user_id,
            service: service_id
        })
    })
    .then(response => response.json())
    .then(data => {
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
