<header class="main-header">

    <!-- Logo -->
    <a href="/" class="logo">
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg"><b>Currency App</b></span>
    </a>

    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top" role="navigation">
        <!-- Navbar Right Menu -->
        <div class="navbar-menu currency-menu">
            <ul class="nav navbar-nav">
                <!-- Messages: style can be found in dropdown.less-->
                <li>
                    <a href="{{ route('currency::list') }}">Currency List</a>
                </li>
                <li>
                    <a href="{{ route('currency::about') }}">About</a>
                </li>
            </ul>
        </div>

    </nav>
</header>
