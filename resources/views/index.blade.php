@extends('layouts.app')

@section('content')
    <!-- Content Row -->
    <section class="content-row content-row-color content-row-clouds">
        <div class="content-slider animate-container-slide" data-nav="true" data-rotation="5">
            <a class="slide" data-title="Cloud Hosting" href="javascript:void(0)">
                <div class="container">
                    <header class="content-header content-header-large content-header-uppercase">
                        <h1>
                            <mark>Deploy</mark> on push
                        </h1>
                        <p>
                            automatically deploy web applications to virtual private server whenever you push to a git repository
                        </p>
                    </header>
                    <img src="uploads/server-shared.png" alt="">
                </div>
            </a>
        </div>
    </section>
    
    <!-- Content Row -->
    <section class="content-row" id="features">
        <div class="container">
            <header class="content-header">
                <h2>
                    Free Cloud Platform
                </h2>
                <p>
                    Deploy your service infrastructure with our fully redundant, high performance cloud platform and benefit from its high reliability, security and enterprise feature set.<br>
                </p>
            </header>
            <div class="column-row align-center-bottom text-align-center">
                <div class="column-33">
                    <i class="fab fa-bitbucket icon-feature"></i>
                    <h3>
                        BitBucket
                    </h3>
                    <p>
                        Automatically deploy all your apps on bitbucket when you push to each repository. Login with your bitbucket account to proceed
                    </p>
                    <p>
                        <a href="{{ route('login', 'bitbucket') }}">login with bitbucket<i class="fas fa-angle-right icon-right"></i></a>
                    </p>
                </div>
                <div class="column-33">
                    <i class="fab fa-github icon-feature"></i>
                    <h3>
                        GitHub
                    </h3>
                    <p>
                        Automatically deploy all your apps on github when you push to each repository. Login with your github account to proceed
                    </p>
                    <p>
                        <a href="{{ route('login', 'github') }}">login with github<i class="fas fa-angle-right icon-right"></i></a>
                    </p>
                </div>
                <div class="column-33">
                    <i class="fab fa-gitlab icon-feature"></i>
                    <h3>
                        GitLab
                    </h3>
                    <p>
                        Automatically deploy all your apps on gitlab when you push to each repository. Login with your gitlab account to proceed
                    </p>
                    <p>
                        <a href="{{ route('login', 'gitlab') }}">login with gitlab<i class="fas fa-angle-right icon-right"></i></a>
                    </p>
                </div>
            </div>
        </div>
    </section>
@endsection