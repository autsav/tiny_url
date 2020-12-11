<div style="text-align: right;">
@if (Route::has('login'))
                    @auth
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
        
</div>


                    <h1>Short Url</h1>

                        <form action="{{ url('/short')}}" method="post">
                            {{ csrf_field() }}
                            <h4>Orginal URl:   <input type="text" name="original_url" placeholder="Enter Original URL" id="original_url" required/></h4>
                            <h4>Custom link(optional):<input type="text" name="custom_alias" placeholder="Enter Custom short url" id="custom_alias">
                            <h4>Expiration Date(optional):<input type="date" id="expiration_date" name="expiration_date">
                        </h4>

                            <br>
                            <button type="submit">Short URL</button>

                        </form>



