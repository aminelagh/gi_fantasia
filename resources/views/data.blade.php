<!DOCTYPE html>
<html lang="en-US">
<head>
  <meta charset="utf-8">
  <title>Ajax Powered Blog</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"/>
  <script src="https://code.jquery.com/jquery-1.12.0.min.js"></script>

</head>
<body>

  <div class="container">


    <table class="articlesHere endless-pagination" data-next-page="{{ $articles->nextPageUrl() }}" border="1" cellspacing="0">
      <thead>  <tr><th>id</th><th>ip</th><th>type</th><th>created_at</th></tr></thead>
      @foreach($articles as $post)
        <tr><td>{{ $post->id }}</td><td>{{ $post->ip }}</td><td>{{ $post->type }}</td><td>{{ $post->created_at }}</td></tr>
      @endforeach
      {{-- {!! $posts->render() !!} --}}
      <tfoot><tr><th colspan="4">    <button class="btn btn-default" onclick="loadMore()">LoadMore</button></th></tr></tfoot>
    </table>




    <script>
    function loadMore(){
      var page = $('.endless-pagination').data('next-page');
      if(page !== null) {
        $.get(page, function(data){
          $('.articlesHere').append(data.articles);
          $('.endless-pagination').data('next-page', data.next_page);
        });
      }
      else{
        alert('No more Data');
      }
    }

    </script>


  </div>

</body>
</html>
