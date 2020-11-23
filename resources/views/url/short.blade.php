<h1>Short Url</h1>

<form action="{{ url('/short')}}" method="post">
    {{ csrf_field() }}
    <h4>Orginal URl:   <input type="text" name="original_url" placeholder="Enter Original URL" id="original_url" required/></h4>
     <h4>Custom link(Not Required):<input type="text" name="custom_alias" placeholder="Enter Custom short url" id="custom_alias">
</h4>
    <br>
    <button type="submit">Short URL</button>

</form>