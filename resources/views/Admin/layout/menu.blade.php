<div class="vertical-menu">

    <div class="h-100">

        <div class="user-wid text-center py-4">
            <div class="mt-3">
                <p class="d-block text-dark font-weight-medium font-size-18 mb-2">{{ Auth::user()->name ?? 'Guest' }}
                </p>
                <a href="{{ route('logout') }}" onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();">
                    {{ __('Logout') }}
                </a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </div>
        </div>

        <!--- Side menu -->
        <div id="sidebar-menu" style="overflow-y:auto;height:450px;padding-bottom:30px;">
            <!-- Left Menu Start -->
            <x-menu/>
        </div>
        <!-- Sidebar -->
    </div>
</div>
