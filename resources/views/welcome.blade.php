<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
        <style>
            html, body {
                background-color:  #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 150vh;
                margin: 0;
            }

            .popup-container{
                position: fixed;
                width: 600px;
                height: 420px;
                bottom: -100%;
                z-index: 2;
                left: 0;
                transition: .3s;
            }

            .popup-container.visible {
                bottom: 0;
            }

            .popup-container__content{
                display: flex;
            }

            .popup-container__newsletter {
                background: #202731;

                text-align: center;
                padding: 40px 24px 24px;
                flex-grow: 1;
                justify-items: center;
                justify-content: center;
                transition: .3s;
                color: white;
            }

            .popup-container__newsletter.change-color{
                background: #186236;
            }

            .popup-container__image{
                width: 264px;
                flex-shrink: 0;
                z-index: 0;
            }

            .text-input {
                width: 288px;
                height: 56px;
                border-radius: 2px;
                border: solid 1px #b1b8c3;
                background-color: transparent;
                margin-bottom: 10px;
                color: white;
            }

            input{
                padding-left: 10px;
                font-size: 1em;
            }

            .submit-btn{
                border: none;
                border-radius: 0;
                width: 300px;
                height: 56px;
                background-color: #f4f5f6;
                font-size: 16px;
                transition: .2s;
            }
            .submit-btn:hover{
                background-color: #186236;
                color: white;
            }
            .color{
                color:red;
            }

            .main-img{
                width: 100%;
            }

            .close {
                position: absolute;
                top: 15px;
                right: 6px;
                border: none;
                width: 48px;
                height: 48px;
                background: url('img/close-large.svg') no-repeat;
                z-index: 50;
                cursor: pointer;
            }
            .popup-container .open-mobile-popup {
                display: none;
            }

            @media (max-width: 767px){

                .popup-container__image {
                    display: none;
                }

                .popup-container {
                    left: 0;
                    bottom: -100%;
                    width: 100%;
                    max-width: 100%;
                    height: auto;
                }
                .popup-container.visible {
                    bottom: 0;
                }

                .close{
                    background: url('img/close.svg')  no-repeat;
                }

                .hide-element{
                    display: none;
                }

                .popup-container .open-mobile-popup {
                    display: block;
                    color: #fff;
                }
                .popup-container__newsletter{
                    display: flex;
                    flex-direction: column;
                    padding-top: 10px;
                    align-items: flex-start;
                }

                .close{
                    position: absolute;
                    top: 25px;
                    right: 4px;
                }
                .popup-container.open {
                    left: 16px;
                    bottom: -100%;
                    top: 40px;
                    width: 90%;
                    height: 300px;
                }
                .popup-container.hide{
                    top:-100%;
                }
                .popup-container.open .popup-container__newsletter {
                    align-items: center;
                }

                .popup-container.open .open-mobile-popup {
                    display: none;
                }

                popup-container.open .popup-container__newsletter form, .popup-container.open
                .popup-container__newsletter p, .popup-container.open .popup-container__newsletter span {
                    display: block;
                }
            }

        </style>
    </head>
    <body>
            <div class="popup-container">
                <div class="popup-container__content">
                     <button type="button" class="close"></button>
                   <div  class="popup-container__newsletter">
                        <h3>Join the ride!</h3>
                        <p class="hide-element">Subscribe to our newsletter and we will send you our latest news about offers, events and launches.</p>
                        <a href="#" class="open-mobile-popup">Subscribe to our newsletter.</a>
                        <form class="hide-element"  id="subscribeForm">
                            <input autofocus required class="text-input" name="email" type="email" placeholder="Your e-mail address"/>
                            <span id="error-email" class="color"></span>
                            <button class="submit-btn" type="submit">Subscribe</button>
                        </form>
                        <p class="hide-element">You can unsubscribe at anytime</p>
                  </div>
                  <div class="popup-container__image">
                    <img class="main-img" src='img/e-mail-sub-image@2x.png' />
                </div>
                </div>
            </div>
        <script src="http://code.jquery.com/jquery-3.3.1.min.js"></script>
        <script>
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
        </script>
       </body>
</html>


