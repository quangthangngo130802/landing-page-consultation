<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SGO Việt Nam</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

</head>

<body>

    <div class="">
        @include('frontend.partials.header')

        <main>
            @include('frontend.sections.hero-section')
            @include('frontend.sections.partners-section')
            @include('frontend.sections.challenges-section')
            @include('frontend.sections.solution-section')
            @include('frontend.sections.registration-section')
        </main>

        @include('frontend.partials.footer')
    </div>
    <button id="btnTop" title="Lên đầu trang" class="btn-scroll-top">
        <i class="fas fa-chevron-up" style="font-size: 13px;"></i>
    </button>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const menuBtn = document.querySelector('.mobile-menu-button');
            const navMenu = document.querySelector('.main-nav');
            const closeBtn = document.querySelector('.close-menu-button');

            menuBtn.addEventListener('click', function() {
                navMenu.classList.add('show');
            });

            closeBtn.addEventListener('click', function() {
                navMenu.classList.remove('show');
            });
        });
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const btnTop = document.getElementById("btnTop")

            // Function to toggle button visibility
            const toggleVisibility = () => {
                if (window.pageYOffset > 300) {
                    // Show button after scrolling 300px
                    btnTop.classList.add("show")
                } else {
                    btnTop.classList.remove("show")
                }
            }

            // Function to scroll to top
            const scrollToTop = () => {
                window.scrollTo({
                    top: 0,
                    behavior: "smooth", // Smooth scroll animation
                })
            }

            // Add scroll event listener
            window.addEventListener("scroll", toggleVisibility)

            // Add click event listener to the button
            btnTop.addEventListener("click", scrollToTop)

            // Initial check in case the page loads already scrolled
            toggleVisibility()
        })
    </script>




</body>

</html>
