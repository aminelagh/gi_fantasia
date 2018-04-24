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
                      <select class="form-control selectpicker show-tick" data-live-search="true" name="id_article_site" id="id_article_site">
                        <option value="null">NULL</option>
                        @foreach ($articles as $item)
                          <option value="{{ $item->id_article_site }}">{{ $item->code }} - {{ $item->designation }} ({{ $item->libelle_site }})</option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                  <div class="col-md-4">
                    {{-- Zone --}}
                    <div class="form-group has-feedback">
                      <label>Zone</label>
                      <select  class="form-control" name="id_zone" id="id_zone" required></select>
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
                      <input type="text" class="form-control" value=""  id="total"  name="total" readonly>
                    </div>
                  </div>
                </div>
                <div class="row" align="center">
                  <input type="submit" class="btn btn-primary" value="Ajouter" id="submitButton">
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <hr>

  <div class="row">
    <div class="col-md-12">
      {{-- *********************************** Inventaire ************************************* --}}
      <div class="box">
        <header class="dark">
          <div class="icons"><i class="fa fa-check"></i></div>
          <h5>Inventaire <span class="badge badge-info badge-pill" title="Nombre d'inventaires"> {{ $data->count() }}</span></h5>
          <div class="toolbar">
            <nav style="padding: 8px;">
              <a href="#" class="btn btn-info btn-xs" data-toggle="dropdown" title="Options"><i class="fa fa-bars"></i></a>
              <ul class="dropdown-menu">
                <li><a href="#" onclick="exportInventairesFunction()">export</a></li>
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

          <div class="breadcrumb">
            <h4>Filtre</h4>
            <form id="formFilterInventaires" method="POST" action="{{ route('inventaires') }}">
              @csrf
              <div class="row">
                <div class="col-md-4">
                  {{-- Article --}}
                  <div class="form-group has-feedback">
                    <label>Article</label>
                    <select class="form-control selectpicker show-tick" data-live-search="true" name="id_article_site" id="filter_id_article_site">
                      <option value="null">Tous les articles</option>
                      @foreach ($articles as $item)
                        <option value="{{ $item->id_article_site }}" {{ isset($selected_id_article_site) && $selected_id_article_site == $item->id_article_site ? 'selected' : ''  }}>{{ $item->code }} - {{ $item->designation }} ({{ $item->libelle_site }})</option>
                      @endforeach
                    </select>
                  </div>
                </div>
                <div class="col-lg-4">
                  {{-- Zone --}}
                  <div class="form-group has-feedback">
                    <label>Zone</label>
                    <select  class="form-control" name="id_zone" id="filter_id_zone">
                      <option value="null">Toutes les zones</option>
                      @foreach ($zones as $item)
                        <option value="{{ $item->id_zone }}" {{ isset($selected_id_zone) && $selected_id_zone == $item->id_zone ? 'selected' : ''  }}>{{ $item->libelle_zone }}</option>
                      @endforeach
                    </select>
                  </div>
                </div>
                <div class="col-lg-2"></div>
                <div class="col-lg-2"><br>
                  <input type="submit" class="btn btn-primary" value="Filter" name="submitFiltre">
                </div>
              </div>
            </form>
          </div>

          <div class="breadcrumb">
            Afficher/Masquer:
            <a class="toggle-vis" data-column="0">Article</a> -
            <a class="toggle-vis" data-column="1">Zone</a> -
            <a class="toggle-vis" data-column="2">Date</a> -
            <a class="toggle-vis" data-column="3">Quantité</a> -
            <a class="toggle-vis" data-column="4">Créé par</a>
          </div>

          <table id="inventairesTable" class="display table table-hover table-striped table-bordered" cellspacing="0" width="100%">
            <thead><tr><th>Article</th><th>Zone</th><th>Date</th><th>Quantité</th><th>Créé par</th><th>Outils</th></tr></thead>
            <tfoot><tr><th>Article</th><th>Zone</th><th>Date</th><th>Quantité</th><th>Créé par</th><th></th></tr></tfoot>
            <tbody>
              @foreach($data as $item)
                <tr>
                  <td>{{ $item->code }} - {{ $item->designation }}</td>
                  <td>{{ $item->libelle_zone }}</td>
                  <td>{{ $item->date }}</td>
                  <td>{{ $item->nombre_palettes }}x{{ $item->nombre_pieces }}={{ $item->nombre_palettes*$item->nombre_pieces }} {{ $item->libelle_unite }}</td>
                  <td>{{ $item->created_by_nom }} {{ $item->created_by_prenom }}</td>
                  <td align="center">
                    <i class="fa fa-edit" data-placement="bottom" data-original-title="Modifier" data-toggle="tooltip"
                    onclick='updateInventaireFuntion({{ $item->id_inventaire }},{{ $item->id_article_site }},{{ $item->id_zone }},"{{ $item->date }}", {{ $item->nombre_palettes }}, {{ $item->nombre_pieces }} );' title="Modifier" ></i>
                    {{--<i class="fa fa-edit" data-toggle="modal" data-target="#modalUpdateArticle" onclick='updateArticleFunction({{ $item->id_article }},{{ $item->id_categorie }},{{ $item->id_zone }},{{ $item->id_unite }},"{{ $item->code }}","{{ $item->designation }}" );' title="Modifier" ></i> --}}
                    <i class="glyphicon glyphicon-trash" onclick="deleteInventaireFunction({{ $item->id_inventaire }},'{{ $item->designation }}','{{ $item->date }}');" data-placement="bottom" data-original-title="Supprimer" data-toggle="tooltip"></i>
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
  <form id="formExportInventaires" method="POST" action="{{ route('exportInventaires') }}" target="_blank">
    @csrf
    <input type="hidden" name="id_article_site" id="export_id_article">
    <input type="hidden" name="id_zone" id="export_id_zone">
  </form>

  <script>
  function exportInventairesFunction(){
    let id_article_site = document.getElementById("filter_id_article_site").value;
    let id_zone = document.getElementById("filter_id_zone").value;

    document.getElementById("export_id_article").value = id_article_site;
    document.getElementById("export_id_zone").value = id_zone;
    document.getElementById("formExportInventaires").submit();
  }
</script>
{{-- ************************** Export To Excel Forms ***************************************** --}}
{{-- ****************************************************************************************** --}}


{{--  @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@  --}}
{{--  @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@       Inventaires      @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@  --}}
<div class="CRUD Inventaires">
  <form id="formDeleteArticle" method="POST" action="{{ route('deleteArticle') }}">
    @csrf
    <input type="hidden" id="delete_id_article" name="id_article" />
    <input type="hidden" id="delete_id_article_site" name="id_article_site" />
  </form>
  <script>
  function deleteInventaireFunction(id_article,id_article_site, designation){
    var go = confirm('Vos êtes sur le point d\'effacer l\'article: "'+designation+'".\n voulez-vous continuer?');
    if(go){
      document.getElementById("delete_id_article").value = id_article;
      document.getElementById("delete_id_article_site").value = id_article;
      document.getElementById("formDeleteArticle").submit();
    }
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
  $('#id_article_site').on('changed.bs.select', function (e) {
    calculateTotal();
    populateZone();
  });

  function updateInventaireFuntion(id_inventaire,id_article_site,id_zone, date, nombre_palettes, nombre_pieces){
    document.getElementById("formAddInventaire").action = "{{ route('updateInventaire') }}";
    document.getElementById("submitButton").value = "Modifier";
    document.getElementById("id_inventaire").value = id_inventaire;
    document.getElementById("id_article_site").value = id_article_site;

    document.getElementById("date").value = date;
    document.getElementById("nombre_palettes").value = nombre_palettes;
    document.getElementById("nombre_pieces").value = nombre_pieces;
    $('.show-tick').selectpicker('refresh');
    calculateTotal();
    populateZone();
    document.getElementById("id_zone").value = id_zone;
  }

  function populateZone(){
    //liste des zones
    var zones = [];
    @foreach ($zones as $item)
    var zone = {
      id_zone: {{ $item->id_zone }},
      libelle_zone: "{{ $item->libelle_zone }}",
      id_site: {{ $item->id_site }},
      libelle_site: "{{ $item->libelle_site }}"
    };
    zones.push(zone);
    @endforeach
    //--------------------

    //liste des articles
    var article_sites = [];
    @foreach ($articles as $item)
    var item = {
      id_article_site: {{ $item->id_article_site }},
      id_article: {{ $item->id_article }},
      id_site: {{ $item->id_site }}
    };
    article_sites.push(item);
    @endforeach
    //--------------------

    var s1 = document.getElementById("id_article_site");
    var s2 = document.getElementById("id_zone");
    var selected_id_article_site = s1.value;

    s2.innerHTML = "";

    //get the selected id_site from id_article_site
    var selected_id_site = 0;
    for(var i = 0 ; i<article_sites.length ; i++){
      if( article_sites[i].id_article_site == selected_id_article_site){
        selected_id_site =  article_sites[i].id_site;
        break;
      }
    }

    //get zones from the selected id_site
    var myZones = [];
    for(var i = 0 ; i<zones.length ; i++){
      if( zones[i].id_site == selected_id_site){
        myZones.push(zones[i]);
      }
    }

    //fill the select option list with zones
    for(var i=0;i<myZones.length;i++){
      var newOption = document.createElement("option");
      newOption.value = myZones[i].id_zone;
      newOption.innerHTML = myZones[i].libelle_zone;
      s2.options.add(newOption);
    }
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
    var article_sites = [];
    @foreach ($articles as $item)
    var item = {
      id_article_site: {{ $item->id_article_site }},
      unite: "{{ $item->libelle_unite }}"
    };
    article_sites.push(item);
    @endforeach

    var selected_id_article_site = document.getElementById("id_article_site").value;

    for(var i=0; i<article_sites.length;i++){
      if(selected_id_article_site == article_sites[i].id_article_site){
        document.getElementById("total").value = document.getElementById("total").value + " "+article_sites[i].unite;
        break;
      }
    }
  }

  $(document).ready(function () {

    $('#inventairesTable tfoot th').each(function () {
      var title = $(this).text();
      if (title == "Article" ) {
        $(this).html('<input type="text" size="6" class="form-control input-sm" placeholder="' + title + '" title="Rechercher par ' + title + '" onfocus="this.placeholder= \'\';" />');
      }
      else if (title == "Zone" || title == "Date") {
        $(this).html('<input type="text" size="8" class="form-control input-sm" placeholder="' + title + '" title="Rechercher par ' + title + '" onfocus="this.placeholder= \'\';" />');
      }
      else if (title == "Quantité") {
        $(this).html('<input type="text" size="12" class="form-control input-sm" placeholder="' + title + '" title="Rechercher par ' + title + '" onfocus="this.placeholder= \'\';" />');
      }
      else if (title == "Créé par" || title == "Sexe") {
        $(this).html('<input type="text" size="5" class="form-control input-sm" placeholder="' + title + '" title="Rechercher par ' + title + '" onfocus="this.placeholder= \'\';" />');
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
        { targets: 0, width: "", type: "string", visible: true, searchable: true, orderable: true},       //article
        { targets: 1, width: "10%", type: "string", visible: true, searchable: true, orderable: true},    //zone
        { targets: 2, width: "10%", type: "string", visible: true, searchable: true, orderable: true},    //date
        { targets: 3, width: "", type: "string", visible: true, searchable: true, orderable: true},    //quantite
        { targets: 4, width: "10%", type: "string", visible: true, searchable: true, orderable: true},    //cree par
        { targets: 5, width: "05%", type: "string", visible: true, searchable: false, orderable: false},  //outils
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
  /*
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
}*/

</script>


@endsection
