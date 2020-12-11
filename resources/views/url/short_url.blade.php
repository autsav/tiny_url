@if (Route::has('login'))
                    @auth
                    <button>
        <a href="{{ url('/') }}"  class="text-sm text-gray-700 underline">Home</a>
        </button>
        <button>
        <a href="{{ url('/dashboard') }}"  class="text-sm text-gray-700 underline">Dashboard</a>
        </button>
        <button>
        <a href="{{ url('/logout') }}"  class="text-sm text-gray-700 underline">Logout</a>
        </button>
        @else
        <button>
        <a href="{{ url('/login') }}"  class="text-sm text-gray-700 underline">Login</a>
        </button>
        @endif
        @endif
<h1>Click the Link</h1>

<a href="{{ url('/short/' . $url->short_url) }}" target="_blank">http://127.0.0.1:8000/short/{{ $url->short_url }}</a>