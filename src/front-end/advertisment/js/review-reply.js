const replyToReviewButton = document.getElementById('reply-to-review-submit-button');
const replyToReviewInput = document.getElementById('reply-to-review-text-input');
const replyToReviewErrorMessage = document.getElementById('reply-to-review-error');
const replyToReviewRow = document.getElementById('reply-to-review-container');
const replyToReviewClose = document.getElementById('close-reply-review');
const replyToReviewCloseSecond = document.getElementById('close-reply-review-second');

const replyToReviewTitle = document.getElementById('reply-to-review-title');



replyToReviewCloseSecond.style = "position: fixed;display: none;";
replyToReviewCloseSecond.disabled = true;
replyToReviewCloseSecond.opacity = "0";

replyToReviewRow.style = "display: none";

//Text Input
replyToReviewInput.addEventListener('input',() => {

    const maxLength = 255;
    if (replyToReviewInput.value.length >= maxLength) {
        replyToReviewErrorMessage.textContent = "Max response length reached";
    } else {
        replyToReviewErrorMessage.textContent = '\u00A0';
    }

});

//Submit button
replyToReviewButton.addEventListener('click',() => {

    document.documentElement.style.overflow = "visible";
    replyToReviewRow.style = "display: none";
        
    fetch('api/reviews.php', {
        method: 'POST', 
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: new URLSearchParams({
            action: 'insertResponseToReview', 
            response: replyToReviewInput.value,
            reviewId: replyToReviewRow.dataset.reviewId
        })
    })
    .then(response => response.json())
    .then(data => {
      console.log('Success:', data);
    })
    .catch(error => {
      console.error('Error:', error);
    });

    const allReviewsTop = Array.from(document.getElementsByClassName("review-border-top"));
    const allReviewsBottom = Array.from(document.getElementsByClassName("review-border-bottom"));

    allReviewsTop.forEach((reviewTopBorder) => {
        reviewTopBorder.style.opacity = "1";
    });
    allReviewsBottom.forEach((reviewBottomBorder) => {
        reviewBottomBorder.style.opacity = "1";
    });
});

replyToReviewClose.addEventListener('click', () => {

    document.documentElement.style.overflow = "visible";
    replyToReviewRow.style = "display: none";

    const allReviewsTop = Array.from(document.getElementsByClassName("review-border-top"));
    const allReviewsBottom = Array.from(document.getElementsByClassName("review-border-bottom"));

    allReviewsTop.forEach((reviewTopBorder) => {
        reviewTopBorder.style.opacity = "1";
    });
    allReviewsBottom.forEach((reviewBottomBorder) => {
        reviewBottomBorder.style.opacity = "1";
    });

});

replyToReviewCloseSecond.addEventListener('click', () => {


    document.documentElement.style.overflow = "visible";
    replyToReviewRow.style = "display: none";

    const allReviewsTop = Array.from(document.getElementsByClassName("review-border-top"));
    const allReviewsBottom = Array.from(document.getElementsByClassName("review-border-bottom"));

    allReviewsTop.forEach((reviewTopBorder) => {
        reviewTopBorder.style.opacity = "1";
    });
    allReviewsBottom.forEach((reviewBottomBorder) => {
        reviewBottomBorder.style.opacity = "1";
    });

});

window.addEventListener('resize', function() {
    console.log("window width: " + window.innerWidth);
    console.log("window heigth: " + window.innerHeight);

    if (window.innerHeight <= 320) {
        replyToReviewCloseSecond.style = "position: relative;display: flex;";
        replyToReviewCloseSecond.disabled = false;
        replyToReviewCloseSecond.opacity = "1";

        replyToReviewClose.style = "position: fixed;display: none;";
        replyToReviewClose.disabled = true;
        replyToReviewClose.opacity = "0";

        replyToReviewTitle.style.display = "none";

    } else {

        replyToReviewCloseSecond.style = "position: fixed;display: none;";
        replyToReviewCloseSecond.disabled = true;
        replyToReviewCloseSecond.opacity = "0";

        replyToReviewClose.style = "position: relative;display: flex;";
        replyToReviewClose.disabled = false;
        replyToReviewClose.opacity = "1";

        replyToReviewTitle.style.display = "flex";
    }
});
window.dispatchEvent(new Event('resize'));
