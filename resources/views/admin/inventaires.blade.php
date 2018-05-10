@extends('admin.layouts.layout')

@section('content-head')
  <li class="breadcrumb-item active">Inventaire</li>
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
                <div class="row">
                  <div class="col-md-3">
                    {{-- Catégorie --}}
                    <div class="form-group has-feedback">
                      <label>Catégorie</label>
                      <select class="form-control selectpicker show-tick" data-live-search="true" name="id_categorie" id="id_categorie">
                        <option value="null">Choisissez une catégorie</option>
                        @foreach ($categories as $item)
                          <option value="{{ $item->id_categorie }}">{{ $item->libelle }}</option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                  <div class="col-md-3">
                    {{-- Famille --}}
                    <div class="form-group has-feedback">
                      <label>Famille</label>
                      <select class="form-control selectpicker show-tick" data-live-search="true" name="id_famille" id="id_famille" required>

                      </select>
                    </div>
                  </div>
                  <div class="col-md-3">
                    {{-- Article --}}
                    <div class="form-group has-feedback">
                      <label>Article</label>
                      <select class="form-control selectpicker show-tick" data-live-search="true" name="id_article_site" id="id_article_site">
                      </select>
                    </div>
                  </div>
                  <div class="col-md-3">
                    {{-- Zone --}}
                    <div class="form-group has-feedback">
                      <label>Zone</label>
                      <select class="form-control selectpicker show-tick" data-live-search="true" name="id_zone" id="id_zone" required></select>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-3">
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
          <h5>Inventaire <span class="badge badge-info badge-pill" title="Nombre d'inventaires"> {{ isset($data) ? $data->count() : 0 }}</span></h5>
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

          {{-- ****************************** Filtre ******************************************* --}}
          <div class="breadcrumb">
            <h4>Filtre</h4>
            <form id="formFilterInventaires" method="POST" action="{{ route('inventaires') }}">
              @csrf
              <div class="row">
                {{-- Session --}}
                <div class="col-sm-3">
                  <div class="form-group has-feedback">
                    <select class="form-control selectpicker show-tick" data-live-search="true" name="id_session" id="filter_id_session">
                      <option value="null">Toutes les sessions</option>
                      @foreach ($sessions as $item)
                        <option value="{{ $item->id_session }}" {{ isset($selected_id_session) && $selected_id_session == $item->id_session ? 'selected' : ''  }}>{{ formatDate2($item->date_debut) }} - {{ formatDate2($item->date_fin) }}</option>
                      @endforeach
                    </select>
                  </div>
                </div>
                {{-- Site --}}
                <div class="col-sm-3">
                  <div class="form-group has-feedback">
                    <select class="form-control selectpicker show-tick" data-live-search="true" name="id_site" id="filter_id_site">
                      <option value="null">Tous les sites</option>
                      @foreach ($sites as $item)
                        <option value="{{ $item->id_site }}" {{ isset($selected_id_site) && $selected_id_site == $item->id_site ? 'selected' : ''  }}>{{ $item->libelle }}</option>
                      @endforeach
                    </select>
                  </div>
                </div>
                {{-- Zone --}}
                <div class="col-sm-3">
                  <div class="form-group has-feedback">
                    <select class="form-control selectpicker show-tick" data-live-search="true" name="id_zone" id="filter_id_zone">
                      <option value="null">Toutes les zones</option>
                      @foreach ($zones as $item)
                        <option value="{{ $item->id_zone }}" {{ isset($selected_id_zone) && $selected_id_zone == $item->id_zone ? 'selected' : ''  }}>{{ $item->libelle_zone }}</option>
                      @endforeach
                    </select>
                  </div>
                </div>
                {{-- Article --}}
                <div class="col-sm-3">
                  <div class="form-group has-feedback">
                    <select class="form-control selectpicker show-tick" data-live-search="true" name="code" id="filter_code">
                      <option value="null">Tous les articles</option>
                      @foreach ($filtreArticles as $item)
                        <option value="{{ $item->code }}" {{ isset($selected_code) && $selected_code == $item->code ? 'selected' : ''  }}>{{ $item->code }}</option>
                      @endforeach
                      {{--@foreach ($articles as $item)
                      <option value="{{ $item->id_article_site }}" {{ isset($selected_id_article_site) && $selected_id_article_site == $item->id_article_site ? 'selected' : ''  }}>{{ $item->code }} - {{ $item->designation }} ({{ $item->libelle_site }})</option>
                    @endforeach
                    --}}
                  </select>
                </div>
              </div>
              <div class="col-sm-2"></div>
              <div class="col-sm-2"><br>
                <input type="submit" class="btn btn-primary" value="Filter" name="submitFiltre">
              </div>
            </div>
          </form>
        </div>
        {{-- ***************************** /.Filtre ****************************************** --}}

        <div class="breadcrumb">
          Afficher/Masquer:
          <a class="toggle-vis" data-column="1">Article</a> -
          <a class="toggle-vis" data-column="2">Zone</a> -
          <a class="toggle-vis" data-column="3">Date</a> -
          <a class="toggle-vis" data-column="9">Quantité</a>
        </div>


        <script>
        function submitValidate(){
          document.getElementById("validateForm_filter_code").value = document.getElementById("filter_code").value;
          document.getElementById("validateForm_filter_id_zone").value = document.getElementById("filter_id_zone").value;
          document.getElementById("validateForm_filter_id_site").value = document.getElementById("filter_id_site").value;
          document.getElementById("validateForm_filter_id_session").value = document.getElementById("filter_id_session").value;
        }
        </script>


        <!-- ********************* Form / Table ******************************************* -->
        <form name="formValidateInventaires" id="formValidateInventaires" method="POST" action="{{ route('inventaires') }}">
          @csrf
          <input type="hidden" name="code" id="validateForm_filter_code">
          <input type="hidden" name="id_zone" id="validateForm_filter_id_zone">
          <input type="hidden" name="id_site" id="validateForm_filter_id_site">
          <input type="hidden" name="id_session" id="validateForm_filter_id_session">

          <table id="inventairesTable" class="table table-hover table-striped table-bordered" style="width:100%">
            <thead>
              <tr>
                <th></th><th>Article</th><th>Zone</th><th>Date</th>
                <th>Longueur</th><th>Largeur</th><th>Hauteur</th><th>palettes</th><th>Pieces</th><th>Quantité</th>
                <th>Créé par</th><th>le</th>
                <th>Modifié par</th><th>le</th>
                <th>validé par</th><th>le</th>
                <th>Valide</th>
                <th>Outils</th>
              </tr>
            </thead>
            <tfoot>
              <tr>
                <th></th><th>Article</th><th>Zone</th><th>Date</th>
                <th>Longueur</th><th>Largeur</th><th>Hauteur</th><th>palettes</th><th>Pieces</th><th>Quantité</th>
                <th>Créé par</th><th>le</th>
                <th>Modifié par</th><th>le</th>
                <th>validé par</th><th>le</th>
                <td onclick="submitValidate();" align="center"><input type="submit" class="btn btn-primary" value="Valider" name="submitValidate" form="formValidateInventaires"></td>
                <th></th>
              </tr>
            </tfoot>
            <tbody>
              @if(isset($data) && $data != NULL )
                @foreach($data as $item)

                  <tr>
                    <input type="hidden" name="id_inventaire[{{ $loop->iteration }}]" value="{{ $item->id_inventaire }}">

                    <td><img src="{{ asset('public/assets/datatables/plus.png') }}" height="20px" /></td>
                    <td>{{ $item->code }} - {{ $item->designation }}</td><td>{{ $item->libelle_zone }}</td><td>{{ formatDate2($item->date) }}</td>
                    <td>{{ $item->longueur }}</td><td>{{ $item->largeur }}</td><td>{{ $item->hauteur }}</td>
                    <td>{{ $item->nombre_palettes }} </td><td>{{ $item->nombre_pieces }} </td>
                    <td>{{ $item->longueur * $item->largeur * $item->hauteur * $item->nombre_palettes * $item->nombre_pieces }} {{ $item->libelle_unite }}</td>
                    <td>{{ $item->created_by_nom }} {{ $item->created_by_prenom }}</td><td>{{ $item->created_at }}</td>
                    <td>{{ $item->updated_by_nom }} {{ $item->updated_by_prenom }}</td><td>{{ $item->updated_at }}</td>
                    <td>{{ $item->validated_by_nom }} {{ $item->validated_by_prenom }}</td><td>{{ $item->validated_at }}</td>
                    <td align="center">
                      <label class="switch"><input type="checkbox" name="valide[{{ $item->id_inventaire }}]"
                        value="isValide" {{ $item->validated_by != null ? "checked title=Valide" : "title=non-valide" }}><span class="slider round"></span></label>
                      </td>
                      <td align="center">
                        <i class="fa fa-edit" data-placement="bottom" data-original-title="Modifier et valider" data-target="#modalUpdateInventaire" data-toggle="modal"
                        onclick='updateInventaireFuntion({{ $item->id_inventaire }},{{ $item->id_article_site }},{{ $item->id_zone }},"{{ $item->date }}",{{ $item->nombre_palettes }},{{ $item->nombre_pieces }},{{ $item->longueur }},{{ $item->largeur }},{{ $item->hauteur }} );' title="Modifier et valider" ></i>
                        {{--<i class="fa fa-edit" data-toggle="modal" data-target="#modalUpdateArticle" onclick='updateArticleFunction({{ $item->id_article }},{{ $item->id_categorie }},{{ $item->id_zone }},{{ $item->id_unite }},"{{ $item->code }}","{{ $item->designation }}" );' title="Modifier" ></i> --}}
                        <i class="glyphicon glyphicon-trash" onclick="deleteInventaireFunction({{ $item->id_inventaire }},'{{ $item->code }}','{{ $item->designation }}','{{ $item->date }}');" data-placement="bottom" data-original-title="Supprimer" data-toggle="tooltip"></i>
                      </td>
                    </tr>
                  @endforeach
                @endif
              </tbody>

            </table>
          </form>
          <!-- ********************* /.Form / Table ******************************************* -->

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
  <form id="formDeleteInventaire" method="POST" action="{{ route('deleteInventaire') }}">
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
    document.getElementById("update_id_zone").value = id_zone;
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
  <form method="POST" action="{{ route('updateInventaire') }}">
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
              {{-- Zone --}}
              <div class="form-group has-feedback">
                <label>Zone</label>
                <select class="form-control selectpicker show-tick" data-live-search="true" name="id_zone" id="update_id_zone" required>
                  @foreach ($zones as $item)
                    <option value="{{ $item->id_zone }}">{{ $item->libelle_zone }} ({{ $item->libelle_site }})</option>
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
  $('#id_categorie').on('changed.bs.select', function (e) {
    populateFamille();
  });

  $('#id_famille').on('changed.bs.select', function (e) {
    populateArticle();
    calculateTotal();
  });

  $('#id_article_site').on('changed.bs.select', function (e) {
    populateZone();
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

  //add options to familles according to the selected categorie
  function populateFamille(){
    var selected_id_categorie = document.getElementById("id_categorie").value;
    //liste des familles
    var familles = [];
    @foreach ($familles as $item)
    var famille = {
      id_famille: {{ $item->id_famille }},
      id_categorie: {{ $item->id_categorie }},
      libelle_famille: "{{ $item->libelle }}"
    };
    familles.push(famille);
    //console.log("famille");console.log(famille);
    @endforeach
    //--------------------
    var myFamilles = [];
    for(var i = 0 ; i<familles.length ; i++){
      if( familles[i].id_categorie == selected_id_categorie){
        myFamilles.push(familles[i]);
      }
    }
    var list_famille = document.getElementById("id_famille");
    list_famille.innerHTML = "";
    var newOption = document.createElement("option");
    newOption.value = "null";
    newOption.innerHTML = "Choisissez une famille";
    list_famille.options.add(newOption);
    //fill the select option list with zones
    for(var i=0;i<myFamilles.length;i++){
      var newOption = document.createElement("option");
      newOption.value = myFamilles[i].id_famille;
      newOption.innerHTML = myFamilles[i].libelle_famille;
      list_famille.options.add(newOption);
      $('.show-tick').selectpicker('refresh');
    }
    $('.show-tick').selectpicker('refresh');
  }

  //add options to articles according to the selected famille
  function populateArticle(){
    var selected_id_famille = document.getElementById("id_famille").value;
    //liste des articles
    var articles = [];
    @foreach ($articles as $item)
    var article = {
      id_article_site: {{ $item->id_article_site }},
      id_article: {{ $item->id_article }},
      id_site: {{ $item->id_site }},
      libelle_site: "{{ $item->libelle_site }}",
      id_famille: {{ $item->id_famille }},
      libelle_famille: "{{ $item->libelle_famille }}",
      id_unite: {{ $item->id_unite }},
      code: "{{ $item->code }}",
      designation: "{{ $item->designation }}"
    };
    articles.push(article);
    @endforeach
    //--------------------
    //create list of chosen articles
    var myArticles = [];
    for(var i = 0 ; i<articles.length ; i++){
      if( articles[i].id_famille == selected_id_famille){
        myArticles.push(articles[i]);
      }
    }
    //--------------------
    var list_article = document.getElementById("id_article_site");
    list_article.innerHTML = "";
    var newOption = document.createElement("option");
    newOption.value = "null";
    newOption.innerHTML = "Choisissez un article";
    list_article.options.add(newOption);
    //fill the select option list with article
    for(var i=0;i<myArticles.length;i++){
      var newOption = document.createElement("option");
      newOption.value = myArticles[i].id_article_site;
      newOption.innerHTML = myArticles[i].code+" - "+myArticles[i].designation+" ("+myArticles[i].libelle_site+")";
      list_article.options.add(newOption);
      $('.show-tick').selectpicker('refresh');
    }
    $('.show-tick').selectpicker('refresh');
    calculateTotal();
  }

  //add options to zone according to the selected article
  function populateZone(){
    var selected_id_article_site = document.getElementById("id_article_site").value;
    //liste des zones
    var zones = [];
    @foreach ($zones as $item)
    var zone = {
      id_zone: {{ $item->id_zone }},
      id_site: {{ $item->id_site }},
      libelle_zone: "{{ $item->libelle_zone }}"
    };
    zones.push(zone);
    @endforeach
    //--------------------
    //liste des articles
    var articles = [];
    @foreach ($articles as $item)
    var article = {
      id_article_site: {{ $item->id_article_site }},
      id_article: {{ $item->id_article }},
      id_site: {{ $item->id_site }}
    };
    articles.push(article);
    @endforeach
    //--------------------
    var selected_id_site = 0;
    for(var i = 0 ; i<articles.length ; i++){
      if( articles[i].id_article_site == selected_id_article_site){
        selected_id_site = articles[i].id_site;
        break;
      }
    }
    //create list of chosen zones
    var myZones = [];
    for(var i = 0 ; i<zones.length ; i++){
      if( zones[i].id_site == selected_id_site){
        myZones.push(zones[i]);
      }
    }
    //--------------------
    var list_zone = document.getElementById("id_zone");
    list_zone.innerHTML = "";
    var newOption = document.createElement("option");
    newOption.value = "null";
    newOption.innerHTML = "Choisissez une zone";
    list_zone.options.add(newOption);
    //fill the select option list with article
    for(var i=0;i<myZones.length;i++){
      var newOption = document.createElement("option");
      newOption.value = myZones[i].id_zone;
      newOption.innerHTML = myZones[i].libelle_zone;
      list_zone.options.add(newOption);
      $('.show-tick').selectpicker('refresh');
    }
    $('.show-tick').selectpicker('refresh');
  }

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
    var row1 = '<table cellpadding="5" cellspacing="0" border="0" style="padding-left:10px;">';
    var row2 = '<tr><td>Quantié: <b>'+d.quantite+'</b><td>Palettes: <b>'+d.nombre_palettes+'</b></td><td>Pieces:  <b>'+d.nombre_pieces+'</b></td><td>Longueur:  <b>'+d.longueur+'</b></td><td>Largeur:  <b>'+d.largeur+'</b></td><td>hauteur:  <b>'+d.hauteur+'</b></td></tr>';
    var row3 = '<tr><td>Créé par: <b>'+d.cree_par+'</b> le <b>'+d.cree_le+'</b></td></tr>';
    if(d.modifie_par!=null){
      row4 = '<tr><td>Modifié par: <b>'+d.modifie_par+'</b> le <b>'+d.modifie_le+'</b></td></tr>';
    }else {
      row4 = '';
    }
    if(d.valide_par!=null){
      row4 = '<tr><td>Validé par: <b>'+d.valide_par+'</b> le <b>'+d.valide_le+'</b></td></tr>';
    }else {
      row4 = '';
    }
    var row5 = '</table>';
    var data = row1+row2+row3+row4+row5;
    return data;
  }

  $(document).ready(function () {
    $('#inventairesTable tfoot th').each(function () {
      var title = $(this).text();
      if (title != "") {
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
        { targets: 05, width: "", type: "string", visible: false, searchable: true, orderable: false},  //l
        { targets: 06, width: "", type: "string", visible: false, searchable: true, orderable: false},  //h
        { targets: 07, width: "", type: "string", visible: false, searchable: true, orderable: false},  //palette
        { targets: 08, width: "", type: "string", visible: false, searchable: true, orderable: false},  //pieces
        { targets: 09, width: "", type: "string", visible: true, searchable: true, orderable: false},  //Quantite
        { targets: 10, width: "", type: "string", visible: false, searchable: true, orderable: false},  //cree
        { targets: 11, width: "", type: "string", visible: false, searchable: true, orderable: false},  //le
        { targets: 12, width: "", type: "string", visible: false, searchable: true, orderable: false},  //modifie
        { targets: 13, width: "", type: "string", visible: false, searchable: true, orderable: false},  //le
        { targets: 14, width: "", type: "string", visible: false, searchable: true, orderable: false},  //valide
        { targets: 15, width: "", type: "string", visible: false, searchable: true, orderable: false},  //le
        { targets: 16, width: "", type: "string", visible: true, searchable: true, orderable: false},  //valide
        { targets: 17, width: "1%", type: "string", visible: true, searchable: false, orderable: false},  //outils
      ],
      //  ajax: "",
      columns: [
        {"className":'details-control',"orderable":false,"defaultContent": ''},
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
        { "data": "valide" },
        { "data": "outils" }
      ],
    });

    // Handle form submission event
    $('#formValidateInventaires').on('submit', function(e){

      var form = this;

      // Encode a set of form elements from all pages as an array of names and values
      var params = table.$('input,select,textarea, checkbox').serializeArray();

      // Iterate over all form elements
      $.each(params, function(){
        // If element doesn't exist in DOM
        if(!$.contains(document, form[this.name])){
          // Create a hidden element
          $(form).append(
            $('<input>')
            .attr('type', 'hidden')
            .attr('name', this.name)
            .val(this.value)
          );
        }
      });
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
