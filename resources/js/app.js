document.addEventListener('DOMContentLoaded', function () {
    const closeButton = document.querySelector(".close");
    const subscribeForm = document.querySelector('#subscribeForm');
    const openMobilePopup = document.querySelector(".open-mobile-popup");
    const errorMessage = "You have already subscribed to our newsletter.";

    //when the DOM loads
    setTimeout(() => {
        document.querySelector(".popup-container").classList.add("visible");
    },1000)

    const closePopUp = (delay) => {
        setTimeout(() => {
            document.querySelector(".popup-container").classList.remove("visible");
            document.querySelector(".popup-container").classList.add("hide");
        },delay)
    }

    closeButton.addEventListener("click",function(){
        closePopUp(0);
    });

    openMobilePopup.addEventListener("click", function (event) {
        event.preventDefault();
        document.querySelector(".popup-container").classList.add('open');
        document.querySelector("#subscribeForm").classList.remove('hide-element');
    })

    subscribeForm.addEventListener('submit', function (event) {
        event.preventDefault();
        const formData = new FormData(this);
        fetch('http://127.0.0.1:8000/api/subscribe', {
            method: 'POST',
            body: formData
        })
            .then(function (response) {
                return response.json();
            })
            .then(function (txt) {
                console.log(txt);
                if(txt.errors)
                {
                    document.querySelector('#error-email').innerHTML = errorMessage;
                    closePopUp(2000);
                }
                else
                {
                    document.querySelector(".popup-container__newsletter").classList.add("change-color");
                    $(".popup-container__newsletter")
                        .html(
                            "<div style='display: flex; flex-direction: column; justify-content: center; justify-items: center; padding-top: 40px'>" +
                            "<img src='img/gfx-clap-success.svg'/> " +
                            "<strong> Subscribed</strong>  " +
                            "<p style='text-align: center' >Thanks for joining in!</p>" +
                            "</div>");

                    closePopUp(2000);
                }
            })
    })
})
