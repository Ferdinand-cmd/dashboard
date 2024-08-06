<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">
    <style>
        /* Include your custom CSS here */
        :root {
            --header-height: 3rem;
            --nav-width: 68px;
            --first-color: #4723D9;
            --first-color-light: #AFA5D9;
            --white-color: #F7F6FB;
            --body-font: 'Nunito', sans-serif;
            --normal-font-size: 1rem;
            --z-fixed: 100;
        }
        *, ::before, ::after {
            box-sizing: border-box;
        }
        body {
            position: relative;
            margin: 0;
            padding: 0;
            font-family: var(--body-font);
            font-size: var(--normal-font-size);
            transition: .5s;
        }
        a {
            text-decoration: none;
        }
        .header {
            display: none; /* Hide header since it's not needed */
        }
        .l-navbar {
            position: fixed;
            top: 0;
            left: -30%;
            width: var(--nav-width);
            height: 100vh;
            background-color: var(--first-color);
            padding: .5rem 1rem 0 0;
            transition: .5s;
            z-index: var(--z-fixed);
        }
        .nav {
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            overflow: hidden;
        }
        .nav_logo {
            display: flex;
            align-items: center;
            margin-bottom: 2rem;
            padding: .5rem 0 .5rem 1.5rem;
        }
        .nav_logo-icon {
            font-size: 1.5rem;
            color: var(--white-color);
        }
        .nav_logo-name {
            color: var(--white-color);
            font-weight: 700;
            margin-left: 0.5rem;
        }
        .nav_list {
            flex: 1;
        }
        .nav_link {
            display: grid;
            grid-template-columns: max-content max-content;
            align-items: center;
            column-gap: 1rem;
            padding: .5rem 0 .5rem 1.5rem;
            color: var(--first-color-light);
            margin-bottom: 1.5rem;
            transition: .3s;
            position: relative;
        }
        .nav_link:hover {
            color: var(--white-color);
        }
        .nav_icon {
            font-size: 1.25rem;
        }
        .active {
            color: var(--white-color);
        }
        .active::before {
            content: '';
            position: absolute;
            left: 0;
            width: 2px;
            height: 32px;
            background-color: var(--white-color);
        }
        .height-100 {
            height: 100vh;
        }
        @media screen and (min-width: 768px) {
            body {
                margin: 0;
                padding-left: calc(var(--nav-width) + 2rem);
            }
            .l-navbar {
                left: 0;
                padding: 1rem 1rem 0 0;
            }
            .show {
                width: calc(var(--nav-width) + 156px);
            }
            .body-pd {
                padding-left: calc(var(--nav-width) + 188px);
            }
        }
    </style>
</head>
<body id="body-pd">
    <div class="l-navbar" id="nav-bar">
        <nav class="nav">
            <a href="#" class="nav_logo">
                <i class='bx bx-menu nav_logo-icon' id="header-toggle"></i>
                <span class="nav_logo-name">Close</span>
            </a>
            <div class="nav_list">
                <a href="{{ url('/home') }}" class="nav_link @if(request()->is('home')) active @endif">
                    <i class='bx bx-grid-alt nav_icon'></i>
                    <span class="nav_name">Dashboard</span>
                </a>
                <a href="{{ url('/log') }}" class="nav_link @if(request()->is('log')) active @endif">
                    <i class='bx bx-folder nav_icon'></i>
                    <span class="nav_name">Logs</span>
                </a>
                <a href="{{ url('/user-management') }}" class="nav_link @if(request()->is('user-management')) active @endif">
                    <i class='bx bx-user nav_icon'></i>
                    <span class="nav_name">Users Management</span>
                </a>
            </div>
            <a href="#" class="nav_link">
                <i class='bx bx-log-out nav_icon'></i>
                <span class="nav_name">SignOut</span>
            </a>
        </nav>
    </div>
    <header class="header" id="header">
        <div class="header_img">
            <img src="https://i.imgur.com/hczKIze.jpg" alt="">
        </div>
    </header>
    <br>
    @yield('content')
    <script>
        document.addEventListener("DOMContentLoaded", function(event) {
            const showNavbar = (toggleId, navId, bodyId, headerId) => {
                const toggle = document.getElementById(toggleId),
                    nav = document.getElementById(navId),
                    bodypd = document.getElementById(bodyId),
                    headerpd = document.getElementById(headerId);

                if (toggle && nav && bodypd && headerpd) {
                    toggle.addEventListener('click', () => {
                        nav.classList.toggle('show');
                        toggle.classList.toggle('bx-x');
                        bodypd.classList.toggle('body-pd');
                        headerpd.classList.toggle('body-pd');
                    });
                }
            }

            showNavbar('header-toggle', 'nav-bar', 'body-pd', 'header');

            const linkColor = document.querySelectorAll('.nav_link');

            function colorLink() {
                if (linkColor) {
                    linkColor.forEach(l => l.classList.remove('active'));
                    this.classList.add('active');
                }
            }
            linkColor.forEach(l => l.addEventListener('click', colorLink));
        });
    </script>
</body>
</html>
