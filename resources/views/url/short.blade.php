<h1>Short Url</h1>

<form action="{{ url('/short')}}" method="post">
    {{ csrf_field() }}

    <input type="text" name="url" id="url">
    <br>
    <button type="submit">Short URL</button>

</form>