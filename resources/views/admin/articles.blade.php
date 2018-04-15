@extends('admin.layouts.layout')

@section('content-head')
  <div class="main-bar">
    <div class="col-md-5 align-self-center">
      <h3></h3>
    </div>
    <div class="col-md-7 align-self-center">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin') }}">Dashboard</a></li>
        <li class="breadcrumb-item active">Articles</li>
      </ol>
    </div>
  </div>

@endsection

@section('content')
  <div class="row col-lg-12">
    <div class="box inverse">
      <header>
        <div class="icons"><i class="fa fa-th-large"></i></div>
        <h5>Création d'un nouvel article</h5>
        <div class="toolbar">
          <nav style="padding: 8px;">
            <a href="javascript:;" class="btn btn-default btn-xs collapse-box"><i class="fa fa-minus"></i></a>
            <a href="javascript:;" class="btn btn-default btn-xs full-box"><i class="fa fa-expand"></i></a>
            <a href="javascript:;" class="btn btn-danger btn-xs close-box"><i class="fa fa-times"></i></a>
          </nav>
        </div>
      </header>
      <div id="div-2" class="body">
        <div class="row col-md-12">
          <form id="formAddArticle" method="POST" action="{{ route('addArticle') }}">
            @csrf
            <input type="hidden" name="id_article" id="id_article">
            <div class="row">
              <div class="col-lg-4">
                {{-- Categorie --}}
                <div class="form-group has-feedback">
                  <label>Catégorie</label>
                  <select  class="form-control" name="id_categorie" id="id_categorie">
                    @foreach ($categories as $item)
                      <option value="{{ $item->id_categorie }}">{{ $item->libelle }} ({{ $item->libelle_famille }})</option>
                    @endforeach
                  </select>
                </div>
              </div>
              <div class="col-lg-4">
                {{-- Zone --}}
                <div class="form-group has-feedback">
                  <label>Zone</label>
                  <select  class="form-control" name="id_zone" id="id_zone">
                    @foreach ($zones as $item)
                      <option value="{{ $item->id_zone }}">{{ $item->libelle }}</option>
                    @endforeach
                  </select>
                </div>
              </div>
              <div class="col-lg-4">
                {{-- Unité --}}
                <div class="form-group has-feedback">
                  <label>Unité</label>
                  <select  class="form-control" name="id_unite" id="id_unite">
                    @foreach ($unites as $item)
                      <option value="{{ $item->id_unite }}">{{ $item->libelle }}</option>
                    @endforeach
                  </select>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-5">
                {{-- Code --}}
                <div class="form-group has-feedback">
                  <label>Code</label>
                  <input type="text" class="form-control" placeholder="Code" name="code" value="{{ old('code') }}"  id="code" required>
                </div>
              </div>
              <div class="col-md-7">
                {{-- Designation --}}
                <div class="form-group has-feedback">
                  <label>Designation</label>
                  <input type="text" class="form-control" placeholder="Designation" value="{{ old('designation') }}"  id="designation"  name="designation" required>
                </div>
              </div>
            </div>
            <div class="row" align="center">
              <button type="submit" class="btn btn-primary">Ajouter</button>
            </div>
          </form>
        </div>


      </div>
    </div>

  </div>

  <hr>

  <div class="row">
    <div class="col-md-12">
      {{-- *********************************** Articles ************************************* --}}
      <div class="box">
        <header class="dark">
          <div class="icons"><i class="fa fa-check"></i></div>
          <h5>Articles <span class="badge badge-info badge-pill" title="Nombre d'utilisateurs"> {{ $articles->count() }}</span></h5>
          <!-- .toolbar -->
          <div class="toolbar">
            <nav style="padding: 8px;">
              <a href="#" class="btn btn-info btn-xs" data-toggle="dropdown" title="Options"><i class="fa fa-bars"></i></a>
              <ul class="dropdown-menu">
                <!--li><a data-toggle="modal" data-original-title="Help" data-placement="bottom" class="btn btn-default btn-sm" href="#modalAddArticle">Ajouter un nouvel Article</a></li-->
                <li><a href="#">print</a></li>
              </ul>
              <div class="btn-group">
                <a href="javascript:;" class="btn btn-default btn-xs collapse-box" title="Réduire"><i class="fa fa-minus"></i></a>
                <a href="javascript:;" class="btn btn-default btn-xs full-box" title="Pein écran"><i class="fa fa-expand"></i></a>
                <a href="javascript:;" class="btn btn-danger btn-xs close-box" title="Fermer"><i class="fa fa-times"></i></a>
              </div>
            </nav>
          </div>
        </header>
        <div id="collapse" class="body">
          <table id="articlesTable" class="display table table-hover table-striped table-bordered" cellspacing="0" width="100%">
            <thead><tr><th>Code</th><th>Catégorie</th><th>Zone</th><th>Designation</th><th>Unité</th><th>Outils</th></tr></thead>
            <tbody>
              @foreach($articles as $item)
                <tr>
                  <td>{{ $item->code }}</td>
                  <td>{{ $item->libelle_categorie }}</td>
                  <td>{{ $item->libelle_zone }}</td>
                  <td>{{ $item->designation }}</td>
                  <td>{{ $item->libelle_unite }}</td>
                  <td>
                    <i class="fa fa-edit" data-placement="bottom" data-original-title="Modifier" data-toggle="tooltip" onclick='updateArticleFunction({{ $item->id_article }},{{ $item->id_categorie }},{{ $item->id_zone }},{{ $item->id_unite }},"{{ $item->code }}","{{ $item->designation }}" );' title="Modifier" ></i>
                    {{--<i class="fa fa-edit" data-toggle="modal" data-target="#modalUpdateArticle" onclick='updateArticleFunction({{ $item->id_article }},{{ $item->id_categorie }},{{ $item->id_zone }},{{ $item->id_unite }},"{{ $item->code }}","{{ $item->designation }}" );' title="Modifier" ></i> --}}
                    <i class="glyphicon glyphicon-trash" onclick="deleteArticleFunction({{ $item->id_article }},'{{ $item->designation }}');" data-placement="bottom" data-original-title="Supprimer" data-toggle="tooltip"></i>
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
      {{-- *********************************** Articles ************************************* --}}
    </div>

  </div>

  <hr>
  <div class="row">
    <div class="col-md-12">
      {{-- *********************************** Zones ************************************* --}

      <table class="articlesHere endless-pagination" data-next-page="{{ $articles->nextPageUrl() }}" border="1" cellspacing="0">
      <thead>  <tr><th>id</th><th>ip</th><th>type</th><th>created_at</th></tr></thead>
      @foreach($articles as $post)
      <tr><td>{{ $post->id }}</td><td>{{ $post->ip }}</td><td>{{ $post->type }}</td><td>{{ $post->created_at }}</td></tr>
    @endforeach
    {{-- {!! $posts->render() !!} --}
    <tfoot><tr><th colspan="4">    <button class="btn btn-default" onclick="loadMore()">LoadMore</button></th></tr></tfoot>
  </table>

  {{-- *********************************** articles ************************************* --}}
</div>
</div>

@endsection

@section('modals')

  {{--  @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@  --}}
  {{--  @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@       Articles      @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@  --}}
  <div class="CRUD Articles">
    <form id="formDeleteArticle" method="POST" action="{{ route('deleteArticle') }}">
      @csrf
      <input type="hidden" id="delete_id_article" name="id_article" />
    </form>
    <script>
    function deleteArticleFunction(id_article, designation){
      var go = confirm('Vos êtes sur le point d\'effacer l\'article: "'+designation+'".\n voulez-vous continuer?');
      if(go){
        document.getElementById("delete_id_article").value = id_article;
        document.getElementById("formDeleteArticle").submit();
      }
    }
    function updateArticleFunction(id_article,id_categorie, id_zone, id_unite, code, designation){
      document.getElementById("formAddArticle").action = "{{ route('updateArticle') }}";
      document.getElementById("id_article").value = id_article;
      document.getElementById("id_categorie").value = id_categorie;
      document.getElementById("id_zone").value = id_zone;
      document.getElementById("id_unite").value = id_unite;
      document.getElementById("code").value = code;
      document.getElementById("designation").value = designation;
    }
    </script>

    {{-- *****************************    update Article    ************************************************* --}}
    <div class="modal fade" id="modalUpdateArticle" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      {{-- Form update Article --}}
      <form method="POST" action="{{ route('updateArticle') }}">
        @csrf
        <input type="hidden" name="id_zone" id="update_id_zone">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              <h4 class="modal-title">Modification de la zone</h4>
            </div>
            <div class="modal-body">
              <div class="row">
                <div class="col-md-4">
                  {{-- Site --}}
                  <div class="form-group has-feedback">
                    <label>Site</label>
                    <select  class="form-control" name="id_site" id="update_id_site_zone">
                      @foreach ($zones as $item)
                        <option value="{{ $item->id_zone }}">{{ $item->libelle }}</option>
                      @endforeach
                    </select>
                  </div>
                </div>
                <div class="col-md-8">
                  {{-- Libelle --}}
                  <div class="form-group has-feedback">
                    <label>Zone</label>
                    <input type="text" class="form-control" placeholder="Libelle" name="libelle" id="update_libelle_zone" required>
                  </div>
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary">Modifier</button>
            </div>

          </div>
        </div>

      </form>
    </div>
  </div>
  {{--  @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@       Articles      @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@  --}}
  {{--  @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@  --}}
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

  $('#articlesTable').DataTable({
    dom: '<lf<Bt>ip>',
    buttons: [
      'copy', 'csv', 'excel', 'pdf', 'print',
    ],
    lengthMenu: [
      [ 5, 10, 25, 50, -1 ],
      [ '5', '10', '25', '50', 'Tout' ]
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
