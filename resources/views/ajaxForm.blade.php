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
  <hr>
  <div class="row" align="center">

    <form id="ajaxForm" method="POST" action="/ajaxForm" class="ajax1">
      @csrf
      Nom: <input type="text" name="nom" value=""><br>
      Prenom: <input type="text" name="prenom" value=""><br>
      <input type="submit" name="submit" type="button" value="Submit">
      <button class="btn btn-default" onclick="submitForm()">Submit</button>
    </form>
  </div>
  <hr>


@endsection

@section('modals')
@endsection

@section('scripts')

  <script>
  $('form.ajax1').on('submit',function(){
    var that = $(this),
    url=that.attr('action'),    ///ajaxForm
    method=that.attr('method'), //post
    data = {};
    that.find('[name]').each(function(index, value){
      //alert('==> '+value.value);
      var that = $(this),
      name = that.attr('name'),
      value = that.val();
      data[name]=value;
    });

    $.ajax({
      url: url,
      type: method,
      data: data,
      success: function(response){
        console.log(response);
      },
    });
    return false;
  });

/*
  function submitForm(){
    alert('aa');
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


  $(function () {
    $('form').bind('submit', function () {
      e.preventDefault();
      alert('aa');
      $.ajax({
        type: 'post',
        url: 'ajaxSubmit',
        data: $('form').serialize(),
        success: function () {
          alert('form was submitted');
        }
      });
      return false;
    });
  });*/
</script>



@endsection
