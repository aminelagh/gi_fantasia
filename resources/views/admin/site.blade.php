@extends('admin.layouts.layout')

@section('content-head')
  <li class="breadcrumb-item active">{{ $site->libelle }}</li>
@endsection

@section('content')

  <div class="row">
    <div class="col-md-12">
      {{-- *********************************** Article_sites ************************************* --}}
      <div class="box">
        <header class="dark">
          <div class="icons"><i class="fa fa-check"></i></div>
          <h5>Articles <span class="badge badge-info badge-pill" title="Nombre d'articles"> {{ $article_sites->count() }}</span></h5>
          <div class="toolbar">
            <nav style="padding: 8px;">
              <a href="#" class="btn btn-info btn-xs" data-toggle="dropdown" title="Options"><i class="fa fa-bars"></i></a>
              <ul class="dropdown-menu">
                <li><a data-toggle="modal" href="#modalAddArticles">Ajouter des articles</a></li>
                <li><a href="#" onclick="exportArticleSitesFunction()">Exporter</a></li>
                <!--li><a data-toggle="modal" href="#modalImportArticles">Importer</a></li-->
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

          <table id="article_sitesTable" class="display table table-hover table-striped table-bordered" cellspacing="0" width="100%">
            <thead><tr><th>Code</th><th>Famille</th><th>Designation</th><th>Unité</th><th>Outils</th></tr></thead>
            <tfoot><tr><th>Code</th><th>Famille</th><th>Designation</th><th>Unité</th><th></th></tr></tfoot>
            <tbody>
              @foreach($article_sites as $item)
                <tr>
                  <td>{{ $item->code }}</td>
                  <td>{{ $item->libelle_famille }}</td>
                  <td>{{ $item->designation }}</td>
                  <td>{{ $item->libelle_unite }}</td>
                  <td align="center">
                    <i class="glyphicon glyphicon-trash" onclick="deleteArticleSiteFunction({{ $item->id_article_site }},'{{ $item->code }}','{{ $item->designation }}');" data-placement="bottom" data-original-title="Supprimer" data-toggle="tooltip"></i>
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
      {{-- *********************************** Article_sites ************************************* --}}
    </div>
  </div>
  <hr>

@endsection

@section('modals')
  {{-- ************************** Export To Excel Forms ***************************************** --}}
  <form id="formExportArticleSites" method="POST" action="{{ route('exportArticleSites') }}" target="_blank">
    @csrf
    <input type="hidden" name="id_site" value="{{ $site->id_site }}">
  </form>

  <script>
  function exportArticleSitesFunction(){
    document.getElementById("formExportArticleSites").submit();
  }
</script>
{{-- ************************** Export To Excel Forms ***************************************** --}}

<div class="CRUD Article_site">
  <form id="formDeleteArticleSite" method="POST" action="{{ route('deleteArticleSite') }}">
    @csrf
    <input type="hidden" id="delete_id_article_site" name="id_article_site" />
  </form>
  <script>
  function deleteArticleSiteFunction(id_article_site,code,designation){
    var go = confirm('Vos êtes sur le point d\'effacer l\'element: "'+code+' - '+designation+'".\n voulez-vous continuer?');
    if(go){
      document.getElementById("delete_id_article_site").value = id_article_site;
      document.getElementById("formDeleteArticleSite").submit();
    }
  }

  </script>
</div>

{{--  @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@       modalAddArticles      @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@  --}}
<div class="modal fade lg" id="modalAddArticles" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">

  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">Ajout des articles au site: <b>{{ $site->libelle }}</b></h4>
      </div>

      <div class="modal-body">

        <!-- ********************* Form / Table ******************************************* -->
        <form name="formAddArticles" id="formAddArticlesToSite" method="POST" action="{{ route('site',[$site->id_site]) }}">
          @csrf
          <input type="hidden" name="id_site" id="{{ $site->id_site }}">

          <table id="articlesTable" class="table table-hover table-striped table-bordered" style="width:100%">
            <thead>
              <tr>
                <th>code</th><th>Designation</th>
                <th>Famille</th><th>Unité</th>
                <th></th>
              </tr>
            </thead>
            <tfoot>
              <tr>
                <th>code</th><th>Designation</th>
                <th>Famille</th><th>Unité</th>
                <td align="center"><input type="submit" class="btn btn-primary" value="Ajouter" name="submitAddArticlesToSite" form="formAddArticlesToSite"></td>

              </tr>
            </tfoot>
            <tbody>
              @if(isset($articles) && $articles != NULL )
                @foreach($articles as $item)
                  <tr>
                    {{--<input type="hidden" name="id_article[{{ $loop->iteration }}]" value="{{ $item->id_article }}"> --}}

                    <td>{{ $item->code }}</td><td>{{ $item->designation }}</td>
                    <td>{{ $item->libelle_famille }}</td>
                    <td>{{ $item->libelle_unite }}</td>
                    <td align="center">
                      <label class="switch"><input type="checkbox" name="articles[]" value="{{ $item->id_article }}"><span class="slider round"></span></label>
                    </td>
                  </tr>
                @endforeach
              @endif
            </tbody>

          </table>
        </form>
        <!-- ********************* /.Form / Table ******************************************* -->



      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>

</div>
{{--  @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@       addArticles      @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@  --}}

@endsection


@section('styles')
  <link rel="stylesheet" href="{{ asset('public/assets/datatables/datatables.min.css') }}">
  <link rel="stylesheet" href="{{ asset('public/assets/datatables/dataTables/css/dataTables.bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{ asset('public/assets/datatables/dataTables/css/dataTables.jqueryui.min.css') }}">
  <link rel="stylesheet" href="{{ asset('public/assets/datatables/Buttons/css/buttons.bootstrap.min.css') }}">
@endsection

@section('scripts')
  <script src="{{ asset('public/assets/datatables/datatables.min.js') }}"></script>
  <script src="{{ asset('public/assets/datatables/dataTables/js/jquery.dataTables.min.js') }}"></script>
  <script src="{{ asset('public/assets/datatables/dataTables/js/dataTables.bootstrap.min.js') }}"></script>
  <script src="{{ asset('public/assets/datatables/dataTables/js/dataTables.jqueryui.min.js') }}"></script>
  <script src="{{ asset('public/assets/datatables/dataTables/js/dataTables.semanticui.min.js') }}"></script>

  <script>

  $(document).ready(function () {
    // Setup - add a text input to each footer cell
    $('#article_sitesTable tfoot th').each(function () {
      var title = $(this).text();
      if (title != "") {
        $(this).html('<input type="text" class="form-control input-sm" placeholder="' + title + '" title="Rechercher par ' + title + '" onfocus="this.placeholder= \'\';" />');
      }
    });

    var table = $('#article_sitesTable').DataTable({
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
      order: [[ 0, "asc" ]],
      //ordering: true,
      columnDefs: [
        { targets: 0, width: "", type: "string", visible: true, searchable: true, orderable: true},
        { targets: 1, width: "", type: "string", visible: true, searchable: true, orderable: true},
        { targets: 2, width: "", type: "string", visible: true, searchable: true, orderable: true},
        { targets: 3, /*width: "10%",*/ type: "string", visible: true, searchable: true, orderable: true},
        { targets: 4, width: "05%", type: "string", visible: true, searchable: false, orderable: false},
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

  $(document).ready(function () {
    // Setup - add a text input to each footer cell
    $('#articlesTable tfoot th').each(function () {
      var title = $(this).text();
      if (title != "") {
        $(this).html('<input type="text" class="form-control input-sm" placeholder="' + title + '" title="Rechercher par ' + title + '" onfocus="this.placeholder= \'\';" />');
      }
    });

    var table = $('#articlesTable').DataTable({
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
        { targets: 0, width: "", type: "string", visible: true, searchable: true, orderable: true},
        { targets: 1, width: "", type: "string", visible: true, searchable: true, orderable: true},
        { targets: 2, width: "", type: "string", visible: true, searchable: true, orderable: true},
        { targets: 3, /*width: "10%",*/ type: "string", visible: true, searchable: true, orderable: true},
        { targets: 4, width: "05%", type: "string", visible: true, searchable: false, orderable: false},
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
  </script>


@endsection
