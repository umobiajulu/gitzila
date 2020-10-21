<!DOCTYPE html>
<html lang="en">
    
<!-- Mirrored from demo.serifly.com/cloudhub/html/home-light-header.html by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 02 Oct 2020 08:33:31 GMT -->
<head>
        <meta charset="UTF-8">
        <title>{{ env("APP_NAME") }} - Deploy on push</title>
        <meta name="description" content="{{ env('APP_NAME') }} deploys your web application whenever you push to a git repository">
        <meta name="keywords" content="html template, responsive, retina, cloud hosting, technology, startup">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
        <!-- Icons -->
        <link rel="apple-touch-icon-precomposed" href="/img/icons/apple-touch-icon.png">
        <link rel="icon" href="/img/icons/favicon.png">
        <!-- Stylesheets -->
        <link rel="stylesheet" href="/css/fontawesome.min.css">
        <link rel="stylesheet" href="/css/main.min.css">
        <livewire:styles>
    </head>
    <body class="footer-dark">
        <!-- Header -->
        <header id="header" class="header-dynamic header-light header-shadow-scroll">
            <div class="container">
                <a class="logo" href="{{ route('index') }}">
                    <img src="/img/logos/header.png" alt="">
                </a>
                <nav>
                    <ul class="nav-primary">
                        <li>
                            <a class="active" href="{{ route('index') }}">Home</a>
                        </li>
                        <li>
                            <a href="{{ route('login', 'bitbucket') }}">Bitbucket</a>
                        </li>
                        <li>
                            <a href="{{ route('login', 'github') }}">Github</a>
                        </li>
                        <li>
                            <a href="{{ route('login', 'gitlab') }}">Gitlab</a>
                        </li>
                    </ul>
                </nav>
            </div>
        </header>

        <!-- Content -->
        <section id="content">

            @yield('content')

        </section>
        <!-- Footer -->
        <footer id="footer">
            <section class="footer-secondary">
                <div class="container">
                    <p>
                        Copyright {{ \Carbon\Carbon::now()->format('Y') }} &copy; {{ env("APP_NAME") }} Cloud Services.</a> <a target="_blank" href="https://twitter.com/emitng"><i class="fab fa-twitter"></i></a>
                    </p>
                </div>
            </section>
        </footer>
        <!-- Scripts -->
        <script src="/js/jquery.min.js"></script>
        <script src="/js/headroom.min.js"></script>
        <script src="/js/js.cookie.min.js"></script>
        <script src="/js/imagesloaded.min.js"></script>
        <script src="/js/bricks.min.js"></script>
        <script src="/js/main.min.js"></script>
        <livewire:scripts>
    </body>

<!-- Mirrored from demo.serifly.com/cloudhub/html/home-light-header.html by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 02 Oct 2020 08:33:31 GMT -->
</html>