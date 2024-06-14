@push('css')
<style>
.dropdown-footer .btn {
        width: calc(100% - 20px); /* Adjust the width of buttons to match parent */
    }
</style>
@endpush
<nav class="main-header navbar navbar-expand navbar-primary navbar-dark border-bottom-0">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
    </ul>

    <!-- Right navbar links -->
    <!-- <ul class="navbar-nav ml-auto">
        <li class="nav-item">
            <a class="nav-link" href="#" 
                onclick="document.querySelector('#logout-form').submit()">
                <i class="fas fa-sign-out-alt"></i> Keluar
            </a>

            <form action="{{ route('logout') }}" method="post" id="logout-form">
                @csrf
            </form>
        </li>
    </ul> -->

    <ul class="navbar-nav ml-auto">
        <li class="nav-item dropdown user-menu">
            <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <img src="{{ url(auth()->user()->foto ?? '/img/user.jpg') }}" class="user-image img-profil rounded-circle" alt="User Image">
                <span>{{ auth()->user()->name }} - {{ auth()->user()->role }}</span>
            </a>
            <div class="dropdown-menu dropdown-menu-right">
                <!-- User image -->
                <div class="dropdown-item user-header text-center">
                    <img src="{{ url(auth()->user()->foto ?? '/img/user.jpg') }}" class="img-circle img-profil" alt="User Image" style="width: 80px; height: 80px;">
                    <h4 class="mt-2">{{ auth()->user()->name }} - <span class="text-sm badge badge-dark">{{ auth()->user()->role }}</span></h4>
                    <p>{{ auth()->user()->email }}</p>
                </div>
                <div class="dropdown-divider"></div>
                <!-- Menu Footer-->
                <div class="dropdown-footer d-flex justify-content-around">
                    <a href="{{ route('user.profil') }}" class="btn btn-outline-primary w-100 mb-2">Profil</a>
                    <a href="#" class="btn btn-outline-danger w-100" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Keluar</a>
                </div>
                <form action="{{ route('logout') }}" method="post" id="logout-form" class="d-none">
                    @csrf
                </form>
            </div>
        </li>
    </ul>
</nav>
@push('scripts')
<script>
    $(document).ready(function() {
        // Prevent dropdown menu from closing when clicked inside
        $('.dropdown-menu').on('click', function(event) {
            event.stopPropagation();
        });
    });
</script>
@endpush