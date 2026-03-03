<div class="logout-section mt-auto border-top border-secondary">
    <a href="{{ route('logout') }}" class="nav-link text-danger mt-3" 
       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
        <i class="fa-solid fa-right-from-bracket me-2"></i> Logout
    </a>
    {{-- Perbaikan action form logout --}}
    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
        @csrf
    </form>
</div>