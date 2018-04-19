@extends('admin.layouts.layout')

@section('content-head')
  <div class="main-bar">
    <div class="col-md-5 align-self-center">
      <h3></h3>
    </div>
    <div class="col-md-7 align-self-center">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin') }}">Dashboard</a></li>
        <li class="breadcrumb-item active">Inventaire</li>
      </ol>
    </div>
  </div>

@endsection

@section('content')
  <div class="row">
    <div class="col-lg-12">
      <div class="box inverse">
        <header>
          <div class="icons"><i class="fa fa-th-large"></i></div>
          <h5>Création d'un nouvel inventaire</h5>
          <div class="toolbar">
            <nav style="padding: 8px;">
              <a href="#" class="btn btn-info btn-xs" data-toggle="dropdown" title="Options"><i class="fa fa-bars"></i></a>
              <ul class="dropdown-menu">
                <li><a href="#" onclick="exportArticlesFunction()">export</a></li>
                <li><a data-toggle="modal" href="#modalAddInventaires">Import</a></li>
              </ul>
              <div class="btn-group">
                <a href="javascript:;" class="btn btn-default btn-xs collapse-box" title="Réduire"><i class="fa fa-minus"></i></a>
                <a href="javascript:;" class="btn btn-default btn-xs full-box" title="Pein écran"><i class="fa fa-expand"></i></a>
                <a href="javascript:;" class="btn btn-danger btn-xs close-box" title="Fermer"><i class="fa fa-times"></i></a>
              </div>
            </nav>
          </div>
        </header>
        <div id="div-2" class="body">
          <div class="row">
            <div class="col-md-12">
              <form id="formAddInventaire" method="POST" action="{{ route('addInventaire') }}">
                @csrf
                <input type="hidden" name="id_inventaire" id="id_inventaire">
                <div class="row">
                  <div class="col-md-4">
                    {{-- Article --}}
                    <div class="form-group has-feedback">
                      <label>Article</label>
                      <select class="form-control selectpicker show-tick" data-live-search="true" name="id_article" id="id_article">
                        <option value="null">NULL</option>
                        @foreach ($articles as $item)
                          <option value="{{ $item->id_article }}">{{ $item->code }} - {{ $item->designation }} ({{ $item->libelle_site }})</option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                  <div class="col-md-4">
                    {{-- Zone --}}
                    <div class="form-group has-feedback">
                      <label>Zone</label>
                      <select  class="form-control" name="id_zone" id="id_zone" required>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-4">
                    {{-- Date --}}
                    <div class="form-group has-feedback">
                      <label>Date</label>
                      <input type="date" class="form-control" placeholder="Date" name="date" value="{{ old('date') }}"  id="date" required>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-3">
                    {{-- Nombre de palettes --}}
                    <div class="form-group has-feedback">
                      <label>Nombre de palettes</label>
                      <input type="number" class="form-control" placeholder="palettes" onkeyup="calculateTotal();" onclick="calculateTotal();" value="{{ old('nombre_palettes')==null? 1 : old('nombre_palettes') }}"  id="nombre_palettes"  name="nombre_palettes" required>
                    </div>
                  </div>
                  <div class="col-md-3">
                    {{-- Nombre de pieces --}}
                    <div class="form-group has-feedback">
                      <label>Nombre de pieces</label>
                      <input type="number" class="form-control" placeholder="pieces" onkeyup="calculateTotal();" onclick="calculateTotal();" value="{{ old('nombre_pieces')==null? 0 : old('nombre_pieces') }}"  id="nombre_pieces"  name="nombre_pieces" required>
                    </div>
                  </div>
                  <div class="col-md-3">
                    {{-- Total --}}
                    <div class="form-group has-feedback">
                      <label>Total</label>
                      <input type="text" class="form-control" value=""  id="total"  name="total" disabled>
                    </div>
                  </div>
                </div>
                <div class="row" align="center">
                  <input type="submit" class="btn btn-primary" value="Ajouter" id="submitButton" onmouseover="populateZone()">
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script>
  function populateZone(){

    var zones = [];
    var selected_id_site = document.getElementById("id_article").value;
    //alert(selected_id_site);
    @foreach ($zones as $item)
    var zone = {id_zone: {{ $item->id_zone }}, libelle_zone: "{{ $item->libelle_zone }}",  id_site: {{ $item->id_site }},libelle_site: "{{ $item->libelle_site }}"  };
    zones.push(zone);
    @endforeach

    //console.log(zones);
    var s1 = document.getElementById("id_article");
    var s2 = document.getElementById("id_zone");
    s2.innerHTML = "";

    var myZones = [];
    for(var i = 0 ; i<zones.length ; i++){
      if( zones[i].id_site == selected_id_site){
        myZones.push(zones[i]);
        console.log(zones[i]);
      }
    }
    for(var i=0;i<myZones.length;i++){
      var newOption = document.createElement("option");
      newOption.value = myZones[i].id_zone;
      newOption.innerHTML = myZones[i].libelle_zone;
      console.log(newOption);
      s2.options.add(newOption);
    }


    //  for(var zone in zones){
    //console.log( zone);
    //}

    //if(s1.value == "")

    {{--  @foreach ($zones as $item)
    <option value="{{ $item->id_zone }}">{{ $item->libelle_zone }} ({{ $item->libelle_site }} ({{ $item->libelle_societe }}))</option>
    @endforeach
    --}}

  }
  function calculateTotal(){
    let palettes = document.getElementById("nombre_palettes").value;
    let pieces = document.getElementById("nombre_pieces").value;
    let total = 0;
    if(palettes == 0){
      total = pieces;
    }else{
      total = pieces * palettes;
    }
    //let unite = document.getElementById("id_article").value;
    //alert("unite: "+unite);
    document.getElementById("total").value = total;
    getUnite();

  }

  function getUnite(){
    var articles = [];
    @foreach ($articles as $item)
    var article = {
      id_article: {{ $item->id_article }},
      unite: "{{ $item->libelle_unite }}"
    };
    articles.push(article);
    @endforeach

    var x =" ";

    for(var i=0; i<articles.length;i++){
      if(document.getElementById("id_article").value == articles[i].id_article){
        document.getElementById("total").value = document.getElementById("total").value + " "+articles[i].unite;
        break;
      }
      //else{alert('not');}
      //  x+= articles[i].id_article_site+"-"+articles[i].unite;
    }
    //alert(x);
  }


</script>

<hr>

<div class="row">
  <div class="col-md-12">
    {{-- *********************************** Inventaire ************************************* --}}
    <div class="box">
      <header class="dark">
        <div class="icons"><i class="fa fa-check"></i></div>
        <h5>Inventaire <span class="badge badge-info badge-pill" title="Nombre d'articles"> {{ $data->count() }}</span></h5>
        <div class="toolbar">
          <nav style="padding: 8px;">
            <a href="#" class="btn btn-info btn-xs" data-toggle="dropdown" title="Options"><i class="fa fa-bars"></i></a>
            <ul class="dropdown-menu">
              <li><a href="#" onclick="exportArticlesFunction()">export</a></li>
              <li><a data-toggle="modal" href="#modalAddArticles">Import</a></li>
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
        <!--div class="breadcrumb">
        Afficher/Masquer:
        <a class="toggle-vis" data-column="0">Code</a> -
        <a class="toggle-vis" data-column="1">Famille</a> -
        <a class="toggle-vis" data-column="2">Site</a> -
        <a class="toggle-vis" data-column="3">Unité</a>
      </div-->
      <div class="breadcrumb">
        <h4>Filtre</h4>
        <form id="formFilterArticles" method="POST" action="{{ route('articles') }}">
          @csrf
          <div class="row">
            <div class="col-lg-4">
              {{-- Site
              <div class="form-group has-feedback">
              <label>Site</label>
              <select  class="form-control" name="id_site" id="filter_id_site">
              <option value="null"></option>
              @foreach ($articles as $item)
              <option value="{{ $item->id_article }}" {{ isset($selected_id_site) && $selected_id_site == $item->id_site ? 'selected' : ''  }}>{{ $item->libelle }} ({{ $item->libelle_societe }})</option>
            @endforeach
          </select>
        </div>--}}
      </div>
      <div class="col-lg-4">
        {{-- Famille
        <div class="form-group has-feedback">
        <label>Famille</label>
        <select  class="form-control" name="id_famille" id="filter_id_famille">
        <option value="null"></option>
        @foreach ($zones as $item)
        <option value="{{ $item->id_famille }}" {{ isset($selected_id_famille) && $selected_id_famille == $item->id_famille ? 'selected' : ''  }}>{{ $item->libelle }}</option>
      @endforeach
    </select>
  </div>--}}
</div>
<div class="col-lg-2"></div>
<div class="col-lg-2"><br>
  <input type="submit" class="btn btn-primary" value="Filter" name="submitFiltre">
</div>
</div>
</form>
</div>
<table id="inventairesTable" class="display table table-hover table-striped table-bordered" cellspacing="0" width="100%">
  <thead><tr><th>Article</th><th>Site</th><th>Zone</th><th>Quantité</th><th>Unité</th><th>Outils</th></tr></thead>
  <tfoot><tr><th>Code</th><th>Famille</th><th>Site</th><th>Designation</th><th>Unité</th><th></th></tr></tfoot>
  <tbody>
    @foreach($data as $item)
      <tr>
        <td>{{ $item->code }} {{ $item->designation }}</td>
        <td>{{ $item->libelle_famille }}</td>
        <td>{{ $item->libelle_site }}</td>
        <td>{{ $item->designation }}</td>
        <td>{{ $item->libelle_unite }}</td>
        <td align="center">
          <i class="fa fa-edit" data-placement="bottom" data-original-title="Modifier" data-toggle="tooltip"
          onclick='updateArticleFunction({{ $item->id_article }},{{ $item->id_article_site }},{{ $item->id_famille }},{{ $item->id_site }},{{ $item->id_unite }},"{{ $item->code }}","{{ $item->designation }}" );' title="Modifier" ></i>
          {{--<i class="fa fa-edit" data-toggle="modal" data-target="#modalUpdateArticle" onclick='updateArticleFunction({{ $item->id_article }},{{ $item->id_categorie }},{{ $item->id_zone }},{{ $item->id_unite }},"{{ $item->code }}","{{ $item->designation }}" );' title="Modifier" ></i> --}}
          <i class="glyphicon glyphicon-trash" onclick="deleteArticleFunction({{ $item->id_article }},{{ $item->id_article_site }},'{{ $item->designation }}');" data-placement="bottom" data-original-title="Supprimer" data-toggle="tooltip"></i>
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

  {{-- ****************************************************************************************** --}}
  {{-- ************************** Export To Excel Forms ***************************************** --}}
  <form id="formExportArticles" method="POST" action="{{ route('exportArticles') }}" target="_blank">
    @csrf
    <input type="hidden" name="id_famille" id="export_id_famille">
    <input type="hidden" name="id_site" id="export_id_site">
  </form>

  <script>
  function exportArticlesFunction(){
    let id_site = document.getElementById("filter_id_site").value;
    let id_famille = document.getElementById("filter_id_famille").value;

    document.getElementById("export_id_site").value = id_site;
    document.getElementById("export_id_famille").value = id_famille;
    document.getElementById("formExportArticles").submit();
  }
</script>
{{-- ************************** Export To Excel Forms ***************************************** --}}
{{-- ****************************************************************************************** --}}


{{--  @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@  --}}
{{--  @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@       Articles      @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@  --}}
<div class="CRUD Articles">
  <form id="formDeleteArticle" method="POST" action="{{ route('deleteArticle') }}">
    @csrf
    <input type="hidden" id="delete_id_article" name="id_article" />
    <input type="hidden" id="delete_id_article_site" name="id_article_site" />
  </form>
  <script>
  function deleteArticleFunction(id_article,id_article_site, designation){
    var go = confirm('Vos êtes sur le point d\'effacer l\'article: "'+designation+'".\n voulez-vous continuer?');
    if(go){
      document.getElementById("delete_id_article").value = id_article;
      document.getElementById("delete_id_article_site").value = id_article;
      document.getElementById("formDeleteArticle").submit();
    }
  }
  function updateArticleFunction(id_article,id_article_site,id_famille, id_site, id_unite, code, designation){
    document.getElementById("formAddArticle").action = "{{ route('updateArticle') }}";
    document.getElementById("submitButton").value = "Modifier";
    document.getElementById("id_article").value = id_article;
    document.getElementById("id_site").value = id_site;
    document.getElementById("id_article_site").value = id_article_site;
    document.getElementById("id_famille").value = id_famille;
    document.getElementById("id_unite").value = id_unite;
    document.getElementById("code").value = code;
    document.getElementById("designation").value = designation;
  }
  </script>


</div>

{{--  @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@  --}}
{{--  @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@       Articles      @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@  --}}
<div class="modal fade" id="modalAddArticles" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  {{-- Form upload File --}}
  <form method="POST" action="{{ route('addArticles') }}" enctype="multipart/form-data">
    @csrf
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title">Chargement des articles</h4>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-md-7">
              {{-- Libelle --}}
              <div class="form-group has-feedback">
                <label>Fichier</label>
                <input type="file" class="form-control" placeholder="Votre Fichier" name="file" required>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Ajouter</button>
        </div>
      </div>
    </div>
  </form>
</div>
{{--  @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@       Articles      @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@  --}}
{{--  @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@  --}}
@endsection

@section('styles')
  <!--link rel="stylesheet" href="assets/datatables/dataTables/css/jquery.dataTables.min.css"-->
  <link rel="stylesheet" href="public/assets/datatables/datatables.min.css">
  <link rel="stylesheet" href="public/assets/datatables/dataTables/css/dataTables.bootstrap.min.css">
  <link rel="stylesheet" href="public/assets/datatables/dataTables/css/dataTables.semanticui.min.css">
  <link rel="stylesheet" href="public/assets/datatables/dataTables/css/dataTables.jqueryui.min.css">
  <link rel="stylesheet" href="public/assets/datatables/dataTables/css/dataTables.foundation.min.css">
  <link rel="stylesheet" href="public/assets/datatables/dataTables/css/dataTables.jqueryui.min.css">
  <link rel="stylesheet" href="public/assets/datatables/dataTables/css/dataTables.jqueryui.min.css">
  <link rel="stylesheet" href="public/assets/datatables/Buttons/css/buttons.bootstrap.min.css">
@endsection

@section('scripts')
  <script src="public/assets/datatables/datatables.min.js"></script>
  <script src="public/assets/datatables/dataTables/js/jquery.dataTables.min.js"></script>
  <script src="public/assets/datatables/dataTables/js/dataTables.bootstrap.min.js"></script>
  <script src="public/assets/datatables/dataTables/js/dataTables.jqueryui.min.js"></script>
  <script src="public/assets/datatables/dataTables/js/dataTables.semanticui.min.js"></script>

  <script>
  $('#id_article').on('changed.bs.select', function (e) {
    calculateTotal();
    populateZone();
  });

  $(document).ready(function () {
    // Setup - add a text input to each footer cell
    $('#articlesTable tfoot th').each(function () {
      var title = $(this).text();
      if (title == "Reference" || title == "Code") {
        $(this).html('<input type="text" size="6" class="form-control input-sm" placeholder="' + title + '" title="Rechercher par ' + title + '" onfocus="this.placeholder= \'\';" />');
      }
      else if (title == "Categorie" || title == "Fournisseur" || title == "Marque") {
        $(this).html('<input type="text" size="8" class="form-control input-sm" placeholder="' + title + '" title="Rechercher par ' + title + '" onfocus="this.placeholder= \'\';" />');
      }
      else if (title == "Designation") {
        $(this).html('<input type="text" size="15" class="form-control input-sm" placeholder="' + title + '" title="Rechercher par ' + title + '" onfocus="this.placeholder= \'\';" />');
      }
      else if (title == "Couleur" || title == "Sexe") {
        $(this).html('<input type="text" size="5" class="form-control input-sm" placeholder="' + title + '" title="Rechercher par ' + title + '" onfocus="this.placeholder= \'\';" />');
      }
      else if (title == "Prix") {
        $(this).html('<input type="text" size="4" class="form-control input-sm" placeholder="' + title + '" title="Rechercher par ' + title + '" onfocus="this.placeholder= \'\';"/>');
      }
      else if (title != "") {
        $(this).html('<input type="text" size="8" class="form-control input-sm" placeholder="' + title + '" title="Rechercher par ' + title + '" onfocus="this.placeholder= \'\';" />');
      }
    });

    var table = $('#inventairesTable').DataTable({
      dom: '<lf<Bt>ip>',
      lengthMenu: [
        [ 10, 25, 50, -1 ],
        [ '10', '25', '50', 'Tout' ]
      ],
      searching: true,
      paging: true,
      //"autoWidth": true,
      info: false,
      stateSave: false,
      columnDefs: [
        { targets: 0, width: "10%", type: "string", visible: true, searchable: true, orderable: true},
        { targets: 1, width: "10%", type: "string", visible: true, searchable: true, orderable: true},
        { targets: 2, width: "10%", type: "string", visible: true, searchable: true, orderable: true},
        { targets: 3, /*width: "10%",*/ type: "string", visible: true, searchable: true, orderable: true},
        { targets: 4, width: "10%", type: "string", visible: true, searchable: true, orderable: true},
        { targets: 5, width: "05%", type: "string", visible: true, searchable: false, orderable: false},
      ],
    });

    $('a.toggle-vis').on('click', function (e) {
      e.preventDefault();
      var column = table.column($(this).attr('data-column'));
      column.visible(!column.visible());
    });

    table.columns().every(function () {
      var that = this;
      $('input', this.footer()).on('keyup change', function () {
        if (that.search() !== this.value) {
          that.search(this.value).draw();
        }
      });
    });

  });

  $('#articlesTablea').DataTable({
    dom: '<lf<Bt>ip>',
    buttons: [
      'copy', 'csv', 'excel', 'pdf', 'print',
    ],
    lengthMenu: [
      [ 5, 10, 25, 50, -1 ],
      [ '5', '10', '25', '50', 'Tout' ]
    ],
    columnDefs: [
      //{ targets:-1, width: "04%", visible: true, orderable: true, searchable: false},
      { targets: 0, width: "10%", type: "string", visible: true, searchable: false, orderable: true},
      { targets: 1, width: "10%", type: "string", visible: true, searchable: false, orderable: true},
      { targets: 2, width: "10%", type: "string", visible: true, searchable: false, orderable: true},
      { targets: 3, /*width: "10%",*/ type: "string", visible: true, searchable: false, orderable: true},
      { targets: 4, width: "10%", type: "string", visible: true, searchable: false, orderable: true},
      { targets: 5, width: "05%", type: "string", visible: true, searchable: false, orderable: true},
    ],
    //order: [[ 0, "asc" ]],
  });

  $('a.toggle-vis').on('click', function (e) {
    e.preventDefault();
    var column = table.column($(this).attr('data-column'));
    column.visible(!column.visible());
  });

  table.columns().every(function () {
    var that = this;
    $('input', this.footer()).on('keyup change', function () {
      if (that.search() !== this.value) {
        that.search(this.value).draw();
      }
    });
  });

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


@endsection
