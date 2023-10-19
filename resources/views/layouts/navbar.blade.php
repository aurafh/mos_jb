<div class="container">
    <nav class="navbar navbar-expand-lg bg-body-teritary">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <img src="/assets/logo.png" alt="Logo" width="70" class="d-inline-block align-text-top">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    @if ($user = Auth::user())
                        @if ($user->role == 'superadmin')
                            <li class="nav-item">
                                <a class="nav-link active" aria-current="page" href="/inventory">Inventori</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="/sales">Sales</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="/purchase">Purchase</a>
                            </li>
                        @endif

                        @if ($user->role == 'sales')
                            <li class="nav-item">
                                <a class="nav-link active" href="/sales">Sales</a>
                            </li>
                        @endif

                        @if ($user->role == 'purchase')
                            <li class="nav-item">
                                <a class="nav-link active" href="/purchase">Purchase</a>
                            </li>
                        @endif

                        @if ($user->role == 'manager')
                            <li class="nav-item">
                                <a class="nav-link active" href="/sales">Sales</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link active" href="/purchase">Purchase</a>
                            </li>
                        @endif

                        <li>
                            <button type="submit" class="nav-link logout">Logout</button>
                        </li>
                </ul>
                @endif
            </div>
        </div>
    </nav>
</div>
