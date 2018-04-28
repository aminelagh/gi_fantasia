@extends('ouvrier.layouts.layout')

@section('content-head')
  <div class="main-bar">
    <div class="col-md-5 align-self-center">
      <h3></h3>
    </div>
    <div class="col-md-7 align-self-center">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('ouvrier') }}">Dashboard</a></li>
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
              <form id="formAddInventaire" method="POST" action="{{ route('o.addInventaire') }}">
                @csrf
                <div class="row">
                  <div class="col-md-4 col-lg-offset-2">
                    {{-- Article --}}
                    <div class="form-group has-feedback">
                      <label>Article</label>
                      <select class="form-control selectpicker show-tick" data-live-search="true" name="id_article_site" id="id_article_site">
                        <option value="null">Choisissez un article</option>
                        @foreach ($articles as $item)
                          <option value="{{ $item->id_article_site }}">{{ $item->code }} - {{ $item->designation }}</option>
                        @endforeach
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
                      <input disabled type="number" class="form-control" placeholder="palettes" onkeyup="calculateTotal();" onclick="calculateTotal();" value="{{ old('nombre_palettes')==null? 1 : old('nombre_palettes') }}"  id="nombre_palettes"  name="nombre_palettes" required>
                    </div>
                  </div>
                  <div class="col-md-3">
                    {{-- Nombre de pieces --}}
                    <div class="form-group has-feedback">
                      <label>Nombre de pieces</label>
                      <input disabled type="number" class="form-control" placeholder="pieces" onkeyup="calculateTotal();" onclick="calculateTotal();" value="{{ old('nombre_pieces')==null? 0 : old('nombre_pieces') }}"  id="nombre_pieces"  name="nombre_pieces" required>
                    </div>
                  </div>
                  <div class="col-md-3">
                    {{-- Largeur --}}
                    <div class="form-group has-feedback">
                      <label>Largeur</label>
                      <input disabled type="number" class="form-control" placeholder="pieces" onkeyup="calculateTotal();" onclick="calculateTotal();" value="{{ old('largeur')==null? 0 : old('largeur') }}" min="1" id="largeur"  name="largeur" required>
                    </div>
                  </div>
                  <div class="col-md-3">
                    {{-- Longueur  --}}
                    <div class="form-group has-feedback">
                      <label>Longueur</label>
                      <input disabled type="number" class="form-control" placeholder="pieces" onkeyup="calculateTotal();" onclick="calculateTotal();" value="{{ old('longueur')==null? 0 : old('longueur') }}" min="1" id="longueur"  name="longueur" required>
                    </div>
                  </div>
                  <div class="col-md-3">
                    {{-- Hauteur --}}
                    <div class="form-group has-feedback">
                      <label>Hauteur</label>
                      <input disabled type="number" class="form-control" placeholder="pieces" onkeyup="calculateTotal();" onclick="calculateTotal();" value="{{ old('hauteur')==null? 0 : old('hauteur') }}" min="1" id="hauteur"  name="hauteur" required>
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
                  <input type="submit" class="btn btn-primary" value="Ajouter">
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
            <form id="formFilterInventaires" method="POST" action="{{ route('ouvrier') }}">
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
                <div class="col-lg-2"></div>
                <div class="col-lg-2"><br>
                  <input type="submit" class="btn btn-primary" value="Filter" name="submitFiltre">
                </div>
              </div>
            </form>
          </div>

          <div class="breadcrumb">
            Afficher/Masquer:
            <a class="toggle-vis" data-column="1">Article</a> -
            <a class="toggle-vis" data-column="2">Zone</a> -
            <a class="toggle-vis" data-column="3">Date</a> -
            <a class="toggle-vis" data-column="9">Quantité</a>
          </div>

          <table id="inventairesTable"  class="display table table-hover table-striped table-bordered" style="width:100%">
            <thead>
              <tr><th></th><th>Article</th><th>Zone</th><th>Date</th>
                <th>Longueur</th><th>Largeur</th><th>Hauteur</th><th>palettes</th><th>Pieces</th><th>Quantité</th>
                <th>Créé par</th><th>le</th>
                <th>Modifié par</th><th>le</th>
                <th>validé par</th><th>le</th>
                <th>Outils</th></tr>
              </thead>
              <tfoot>
                <tr><th></th><th>Article</th><th>Zone</th><th>Date</th>
                  <th>Longueur</th><th>Largeur</th><th>Hauteur</th><th>palettes</th><th>Pieces</th><th>Quantité</th>
                  <th>Créé par</th><th>le</th>
                  <th>Modifié par</th><th>le</th>
                  <th>validé par</th><th>le</th>
                  <th></th></tr>
                </tfoot>
                <tbody>
                  @foreach($data as $item)
                    <tr>
                      <td></td>
                      <td>{{ $item->code }} - {{ $item->designation }}</td>
                      <td>{{ $item->libelle_zone }}</td>
                      <td>{{ $item->date }}</td>
                      <td>{{ $item->longueur }}</td>
                      <td>{{ $item->largeur }}</td>
                      <td>{{ $item->hauteur }} </td>
                      <td>{{ $item->nombre_palettes }} </td>
                      <td>{{ $item->nombre_pieces }} </td>
                      <td>{{ $item->longueur * $item->largeur * $item->hauteur * $item->nombre_palettes * $item->nombre_pieces }} {{ $item->libelle_unite }}</td>
                      <td>{{ $item->created_by_nom }} {{ $item->created_by_prenom }}</td><td>{{ $item->created_at }}</td>
                      <td>{{ $item->updated_by_nom }} {{ $item->updated_by_prenom }}</td><td>{{ $item->updated_at }}</td>
                      <td>{{ $item->validated_by_nom }} {{ $item->validated_by_prenom }}</td><td>{{ $item->validated_at }}</td>
                      <td align="center">
                        <i class="fa fa-edit" data-placement="bottom" data-original-title="Modifier" data-target="#modalUpdateInventaire" data-toggle="modal"
                        onclick='updateInventaireFuntion({{ $item->id_inventaire }},{{ $item->id_article_site }},{{ $item->id_zone }},"{{ $item->date }}",{{ $item->nombre_palettes }},{{ $item->nombre_pieces }},{{ $item->longueur }},{{ $item->largeur }},{{ $item->hauteur }} );' title="Modifier" ></i>
                        {{--<i class="fa fa-edit" data-toggle="modal" data-target="#modalUpdateArticle" onclick='updateArticleFunction({{ $item->id_article }},{{ $item->id_categorie }},{{ $item->id_zone }},{{ $item->id_unite }},"{{ $item->code }}","{{ $item->designation }}" );' title="Modifier" ></i> --}}
                        <i class="glyphicon glyphicon-trash" onclick="deleteInventaireFunction({{ $item->id_inventaire }},'{{ $item->code }}','{{ $item->designation }}','{{ $item->date }}');" data-placement="bottom" data-original-title="Supprimer" data-toggle="tooltip"></i>
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
  <form id="formExportInventaires" method="POST" action="{{ route('o.exportInventaires') }}" target="_blank">
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
  <form id="formDeleteInventaire" method="POST" action="{{ route('o.deleteInventaire') }}">
    @csrf
    <input type="hidden" id="delete_id_inventaire" name="id_inventaire" />
  </form>
  <script>
  function deleteInventaireFunction(id_inventaire,code,designation,date){
    var go = confirm('Vos êtes sur le point d\'effacer l\'inventaire: "'+code+' - '+designation+' '+date+'".\n voulez-vous continuer?');
    if(go){
      document.getElementById("delete_id_inventaire").value = id_inventaire;
      document.getElementById("formDeleteInventaire").submit();
    }
  }

  function updateInventaireFuntion(id_inventaire,id_article_site, id_zone, date, nombre_palettes, nombre_pieces, longueur, largeur, hauteur){

    document.getElementById("update_id_inventaire").value = id_inventaire;
    document.getElementById("update_id_article_site").value = id_article_site;
    $('.show-tick').selectpicker('refresh');
    document.getElementById("update_date").value = date;

    document.getElementById("update_nombre_palettes").value = nombre_palettes;
    document.getElementById("update_nombre_pieces").value = nombre_pieces;

    document.getElementById("update_longueur").value = longueur;
    document.getElementById("update_largeur").value = largeur;
    document.getElementById("update_hauteur").value = hauteur;
    $('.show-tick').selectpicker('refresh');
    update_calculateTotal();
  }

  function update_calculateTotal(){
    document.getElementById("update_largeur").readOnly = false;
    document.getElementById("update_longueur").readOnly = false;
    document.getElementById("update_hauteur").readOnly = false;
    //get unite
    var articles = [];
    @foreach ($articles as $item)
    var article = {
      id_article_site: {{ $item->id_article_site }},
      id_unite: {{ $item->id_unite }},
      libelle_unite: "{{ $item->libelle_unite }}"
    };
    articles.push(article);
    @endforeach
    //--------------------
    var selected_id_article_site = document.getElementById("update_id_article_site").value;

    //var id_unite = 0;
    //var libelle_unite = " ";
    //write unite
    for(var i=0; i<articles.length;i++){
      if(selected_id_article_site == articles[i].id_article_site){

        var id_unite = articles[i].id_unite;
        var libelle_unite = articles[i].libelle_unite;

        var palettes = document.getElementById("update_nombre_palettes").value;
        var pieces = document.getElementById("update_nombre_pieces").value;

        var largeur = document.getElementById("update_largeur").value;
        var longueur = document.getElementById("update_longueur").value;
        var hauteur = document.getElementById("update_hauteur").value;

        if( libelle_unite=="KG" || libelle_unite=="UN" || libelle_unite=="MI"){
          document.getElementById("update_largeur").value = 1;  document.getElementById("update_largeur").readOnly = true;
          document.getElementById("update_longueur").value = 1; document.getElementById("update_longueur").readOnly = true;
          document.getElementById("update_hauteur").value = 1;  document.getElementById("update_hauteur").readOnly = true;
        }
        else if( libelle_unite=="M2"){
          document.getElementById("update_largeur").readOnly = false;
          document.getElementById("update_longueur").readOnly = false;
          document.getElementById("update_hauteur").value = 1;  document.getElementById("update_hauteur").readOnly = true;
        }
        else if( libelle_unite=="M3"){
          document.getElementById("update_largeur").readOnly = false;
          document.getElementById("update_longueur").readOnly = false;
          document.getElementById("update_hauteur").readOnly = false;
        }
        var total = 0;
        var dimm = largeur * longueur * hauteur;
        if(palettes == 0){
          total = pieces * dimm;
        }else{
          total = pieces * palettes * dimm;
        }
        document.getElementById("update_total").value = total + " "+articles[i].libelle_unite;
        break;
      }
    }
    //document.getElementById("total").value = total;
  }

  </script>
</div>

{{--  @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@  --}}
{{--  @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@       inventaire      @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@  --}}
<div class="modal fade lg" id="modalUpdateInventaire" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  {{-- Form upload File --}}
  <form method="POST" action="{{ route('o.updateInventaire') }}">
    @csrf
    <input type="hidden" name="id_inventaire" id="update_id_inventaire">

    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title">Modification de l'inventaire</h4>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-md-4">
              {{-- Article --}}
              <div class="form-group has-feedback">
                <label>Article</label>
                <select class="form-control selectpicker show-tick" data-live-search="true" name="id_article_site" id="update_id_article_site">
                  @foreach ($articles as $item)
                    <option value="{{ $item->id_article_site }}">{{ $item->code }} - {{ $item->designation }} ({{ $item->libelle_site }})</option>
                  @endforeach
                </select>
              </div>
            </div>
            <div class="col-md-4">
              {{-- Date --}}
              <div class="form-group has-feedback">
                <label>Date</label>
                <input type="date" class="form-control" placeholder="Date" name="date" id="update_date" required>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-4">
              {{-- Nombre de palettes --}}
              <div class="form-group has-feedback">
                <label>Nombre de palettes</label>
                <input type="number" class="form-control" placeholder="palettes" onkeyup="update_calculateTotal();" onclick="update_calculateTotal();" min="1" id="update_nombre_palettes"  name="nombre_palettes" required>
              </div>
            </div>
            <div class="col-md-4">
              {{-- Nombre de pieces --}}
              <div class="form-group has-feedback">
                <label>Nombre de pieces</label>
                <input type="number" class="form-control" placeholder="pieces" onkeyup="update_calculateTotal();" onclick="update_calculateTotal();"  id="update_nombre_pieces"  name="nombre_pieces" required>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-3">
              {{-- Largeur --}}
              <div class="form-group has-feedback">
                <label>Largeur</label>
                <input type="number" class="form-control" placeholder="pieces" onkeyup="update_calculateTotal();" onclick="update_calculateTotal();" min="1" id="update_largeur"  name="largeur" required>
              </div>
            </div>
            <div class="col-md-3">
              {{-- Longueur  --}}
              <div class="form-group has-feedback">
                <label>Longueur</label>
                <input type="number" class="form-control" placeholder="pieces" onkeyup="update_calculateTotal();" onclick="update_calculateTotal();" min="1" id="update_longueur"  name="longueur" required>
              </div>
            </div>
            <div class="col-md-3">
              {{-- Hauteur --}}
              <div class="form-group has-feedback">
                <label>Hauteur</label>
                <input type="number" class="form-control" placeholder="pieces" onkeyup="update_calculateTotal();" onclick="update_calculateTotal();" min="1" id="update_hauteur"  name="hauteur" required>
              </div>
            </div>
            <div class="col-md-3">
              {{-- Total --}}
              <div class="form-group has-feedback">
                <label>Total</label>
                <input type="text" class="form-control" value=""  id="update_total"  name="total" readonly>
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
{{--  @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@       inventaire      @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@  --}}
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
    document.getElementById("nombre_palettes").disabled = false;
    document.getElementById("nombre_pieces").disabled = false;
    document.getElementById("largeur").disabled = false;
    document.getElementById("longueur").disabled = false;
    document.getElementById("hauteur").disabled = false;
  });

  $('#update_id_article_site').on('changed.bs.select', function (e) {
    update_calculateTotal();
  });

  function calculateTotal(){
    document.getElementById("largeur").readOnly = false;
    document.getElementById("longueur").readOnly = false;
    document.getElementById("hauteur").readOnly = false;
    //get unite
    var articles = [];
    @foreach ($articles as $item)
    var article = {
      id_article_site: {{ $item->id_article_site }},
      id_unite: {{ $item->id_unite }},
      libelle_unite: "{{ $item->libelle_unite }}"
    };
    articles.push(article);
    @endforeach
    //--------------------
    var selected_id_article_site = document.getElementById("id_article_site").value;

    //var id_unite = 0;
    //var libelle_unite = " ";
    //write unite
    for(var i=0; i<articles.length;i++){
      if(selected_id_article_site == articles[i].id_article_site){

        var id_unite = articles[i].id_unite;
        var libelle_unite = articles[i].libelle_unite;

        var palettes = document.getElementById("nombre_palettes").value;
        var pieces = document.getElementById("nombre_pieces").value;

        var largeur = document.getElementById("largeur").value;
        var longueur = document.getElementById("longueur").value;
        var hauteur = document.getElementById("hauteur").value;

        if( libelle_unite=="KG" || libelle_unite=="UN" || libelle_unite=="MI"){
          document.getElementById("largeur").value = 1;  document.getElementById("largeur").readOnly = true;
          document.getElementById("longueur").value = 1; document.getElementById("longueur").readOnly = true;
          document.getElementById("hauteur").value = 1;  document.getElementById("hauteur").readOnly = true;
        }
        else if( libelle_unite=="M2"){
          document.getElementById("largeur").readOnly = false;
          document.getElementById("longueur").readOnly = false;
          document.getElementById("hauteur").value = 1;  document.getElementById("hauteur").readOnly = true;
        }
        else if( libelle_unite=="M3"){
          document.getElementById("largeur").readOnly = false;
          document.getElementById("longueur").readOnly = false;
          document.getElementById("hauteur").readOnly = false;
        }
        var total = 0;
        var dimm = largeur * longueur * hauteur;
        if(palettes == 0){
          total = pieces * dimm;
        }else{
          total = pieces * palettes * dimm;
        }
        document.getElementById("total").value = total + " "+articles[i].libelle_unite;
        break;
      }
    }
    //document.getElementById("total").value = total;
  }

  //extra info on every table row
  function format ( d ) {
    // `d` is the original data object for the row
    return '<table cellpadding="5" cellspacing="0" border="0" style="padding-left:10px;">'+
    '<tr><td>Quantié: <b>'+d.quantite+'</b><td>Palettes: <b>'+d.nombre_palettes+'</b></td><td>Pieces:  <b>'+d.nombre_pieces+'</b></td><td>Longueur:  <b>'+d.longueur+'</b></td><td>Largeur:  <b>'+d.largeur+'</b></td><td>hauteur:  <b>'+d.hauteur+'</b></td></tr>'+
    '<tr><td>Créé par: <b>'+d.cree_par+'</b> le <b>'+d.cree_le+'</b></td></tr>'+
    '<tr><td>Modifié par: <b>'+d.modifie_par+'</b> le <b>'+d.modifie_le+'</b></td></tr>'+
    '<tr><td>Validé par: <b>'+d.valide_par+'</b> le <b>'+d.valide_le+'</b></td></tr>'+
    '</table>';
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
        { targets: 00, width: "1%", type: "string", visible: true, searchable: true, orderable: true},  //article
        { targets: 01, width: "", type: "string", visible: true, searchable: true, orderable: true},    //article
        { targets: 02, width: "", type: "string", visible: true, searchable: true, orderable: true},    //Zone
        { targets: 03, width: "", type: "string", visible: true, searchable: true, orderable: true},    //date
        { targets: 04, width: "", type: "string", visible: false, searchable: true, orderable: true},    //L
        { targets: 05, width: "", type: "string", visible: false, searchable: false, orderable: false},  //l
        { targets: 06, width: "", type: "string", visible: false, searchable: false, orderable: false},  //h
        { targets: 07, width: "", type: "string", visible: false, searchable: false, orderable: false},  //palette
        { targets: 08, width: "", type: "string", visible: false, searchable: false, orderable: false},  //pieces
        { targets: 09, width: "", type: "string", visible: true, searchable: false, orderable: false},  //Quantite
        { targets: 10, width: "", type: "string", visible: false, searchable: false, orderable: false},  //cree
        { targets: 11, width: "", type: "string", visible: false, searchable: false, orderable: false},  //le
        { targets: 12, width: "", type: "string", visible: false, searchable: false, orderable: false},  //modifie
        { targets: 13, width: "", type: "string", visible: false, searchable: false, orderable: false},  //le
        { targets: 14, width: "", type: "string", visible: false, searchable: false, orderable: false},  //valide
        { targets: 15, width: "", type: "string", visible: false, searchable: false, orderable: false},  //le
        { targets: 16, width: "1%", type: "string", visible: true, searchable: false, orderable: false},  //outils


      ],
      //  ajax: "",
      columns: [
        {"className":'details-control',"orderable":false,"data":null,"defaultContent": ''},
        { "data": "article" },
        { "data": "zone" },
        { "data": "date" },
        { "data": "longueur" },
        { "data": "largeur" },
        { "data": "hauteur" },
        { "data": "nombre_palettes" },
        { "data": "nombre_pieces" },
        { "data": "quantite" },
        { "data": "cree_par" }, { "data": "cree_le" },
        { "data": "modifie_par" }, { "data": "modifie_le" },
        { "data": "valide_par" }, { "data": "valide_le" },
        { "data": "outils" }
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

    // Add event listener for opening and closing details
    $('#inventairesTable tbody').on('click', 'td.details-control', function () {
      var tr = $(this).closest('tr');
      var row = table.row( tr );

      if ( row.child.isShown() ) {
        // This row is already open - close it
        row.child.hide();
        tr.removeClass('shown');
      }
      else {
        // Open this row
        row.child( format(row.data()) ).show();
        tr.addClass('shown');
      }
    } );

  });


</script>


@endsection
