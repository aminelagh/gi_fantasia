@extends('admin.layouts.layout')

@section('content-head')
  <div class="main-bar">
    <div class="col-md-5 align-self-center">
      <h3></h3>
    </div>
    <div class="col-md-7 align-self-center">
      <ol class="breadcrumb">
        <li class="breadcrumb-item active"><a href="{{ route('admin') }}">Dashboard</a></li>
        <!--li class="breadcrumb-item active">Dashboard</li-->
      </ol>
    </div>
  </div>

@endsection

@section('content')

  <div class="row">
    <div class="col-md-12">
      {{-- *********************************** Zones ************************************* --}}


      <table class="articlesHere endless-pagination" data-next-page="{{ $articles->nextPageUrl() }}" border="1" cellspacing="0">
        <thead>  <tr><th>id</th><th>ip</th><th>type</th><th>created_at</th></tr></thead>
        @foreach($articles as $post)
          <tr><td>{{ $post->id }}</td><td>{{ $post->ip }}</td><td>{{ $post->type }}</td><td>{{ $post->created_at }}</td></tr>
        @endforeach
        {{-- {!! $posts->render() !!} --}}
        <tfoot><tr><th colspan="4">    <button class="btn btn-default" onclick="loadMore()">LoadMore</button></th></tr></tfoot>
      </table>

      {{-- *********************************** articles ************************************* --}}
    </div>
  </div>

@endsection

@section('modals')


@endsection

@section('styles')
  <!--link rel="stylesheet" href="assets/datatables/dataTables/css/jquery.dataTables.min.css"-->
  <link rel="stylesheet" href="assets/datatables/datatables.min.css">
  <link rel="stylesheet" href="assets/datatables/dataTables/css/dataTables.bootstrap.min.css">
  <link rel="stylesheet" href="assets/datatables/dataTables/css/dataTables.semanticui.min.css">
  <link rel="stylesheet" href="assets/datatables/dataTables/css/dataTables.jqueryui.min.css">

  <link rel="stylesheet" href="assets/datatables/dataTables/css/dataTables.foundation.min.css">
  <link rel="stylesheet" href="assets/datatables/dataTables/css/dataTables.jqueryui.min.css">
  <link rel="stylesheet" href="assets/datatables/dataTables/css/dataTables.jqueryui.min.css">

  <link rel="stylesheet" href="assets/datatables/Buttons/css/buttons.bootstrap.min.css">
@endsection

@section('scripts')
  <script src="assets/datatables/datatables.min.js"></script>
  <script src="assets/datatables/dataTables/js/jquery.dataTables.min.js"></script>
  <script src="assets/datatables/dataTables/js/dataTables.bootstrap.min.js"></script>
  <script src="assets/datatables/dataTables/js/dataTables.jqueryui.min.js"></script>
  <script src="assets/datatables/dataTables/js/dataTables.semanticui.min.js"></script>

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



  $('#zonesTable').DataTable({
    dom: '<lf<Bt>ip>',
      buttons: [
      'copy', 'csv', 'excel', 'pdf', 'print',
      ],
      lengthMenu: [
      [ 50, 10, 25, 50, -1 ],
      [ '50', '10', '25', '50', 'Tout' ]
      ],
      columnDefs: [
      { targets:-1, visible: true, orderable: true, searchable: false},
      { targets: 0, visible: true, type: "string"},
      { targets: 1, visible: true},
      ],
      //order: [[ 0, "asc" ]],
    });

  </script>


@endsection
