// Star Rating
const starsWrapper = document.querySelector(".rate-stars-wrapper");

if (starsWrapper != null) {
    const starArr = starsWrapper.querySelectorAll(".star");

    const userRatedStar = starsWrapper.getAttribute("data-rated-star");

    var ratedStar = 0;
    if (userRatedStar != null)
        ratedStar = userRatedStar;

    for (let i = 0; i < ratedStar; i++)
        starArr[i].classList.add("yellow");

    starArr.forEach((star) => {
        let endStar = parseInt(star.getAttribute("data-star"));

        star.addEventListener("click", (e) => {
            ratedStar = endStar;
            document.querySelector('input[id="rate"]').value = ratedStar;
        });

        star.addEventListener("mouseover", () => {
            resetColor();
            for (let i = 0; i < endStar; i++)
                starArr[i].classList.add("yellow");
        });

        star.addEventListener("mouseout", () => {
            resetColor();
            if (ratedStar != 0)
                for (let i = 0; i < ratedStar; i++)
                    starArr[i].classList.add("yellow");
        });
    });

    function resetColor() {
        for (let i = 0; i < starArr.length; i++)
            starArr[i].classList.remove("yellow");
    }

}

