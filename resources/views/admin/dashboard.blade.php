@extends('admin.layouts.layout')

@section('content-head')
  <div class="col-md-5 align-self-center">
    <h3 class="text-primary">Dashboard</h3>
  </div>
  <div class="col-md-7 align-self-center">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
      <li class="breadcrumb-item active">Dashboard</li>
    </ol>
  </div>
@endsection

@section('content')

  <div class="row">
    <div class="col-md-8">
      {{-- *********************************** Users ************************************* --}}
      <div class="box">
        <header class="dark">
          <div class="icons"><i class="fa fa-check"></i></div>
          <h5>Utilisateurs <span class="badge badge-info badge-pill" title="Nomrbe d'utilisateurs"> {{ $users->count() }}</span></h5>
          <!-- .toolbar -->
          <div class="toolbar">
            <nav style="padding: 8px;">
              <a href="#" class="btn btn-info btn-xs" data-toggle="dropdown" title="Options"><i class="fa fa-bars"></i></a>
              <ul class="dropdown-menu">
                <li><a data-toggle="modal" data-original-title="Help" data-placement="bottom" class="btn btn-default btn-sm" href="#modalAddUser">Ajouter un nouvel utilisateur</a></li>
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
          <table id="usersTable" class="display table table-hover table-striped table-bordered" cellspacing="0" width="100%">
            <thead><tr><th>Rôle</th><th>Utilisateur</th><th>Login</th><th>last login</th><th>Outils</th></tr></thead>
            <tbody>
              @foreach($users as $item)
                <tr>
                  <td>{{ $item->name }}</td>
                  <td>{{ $item->nom }} {{ $item->prenom }}</td>
                  <td>{{ $item->login }}</td>
                  <td>{{ $item->last_login }}</td>
                  <td>
                    <i class="fa fa-edit" data-toggle="modal" data-target="#modalUpdateUser" onclick='updateUserFunction({{ $item->id_user }}, "{{ $item->nom }}", "{{ $item->prenom }}","{{ $item->login }}" );' title="Modifier" ></i>
                    <i class="glyphicon glyphicon-trash" onclick="deleteUserFunction({{ $item->id_user }},'{{ $item->nom }}','{{ $item->prenom }}');" data-placement="bottom" data-original-title="Supprimer" data-toggle="tooltip" ></i>
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
      {{-- *********************************** Users ************************************* --}}
    </div>

  </div>

  <hr>

  <div class="row">
    <div class="col-md-7">
      {{-- *********************************** Categories ************************************* --}}
      <div class="box">
        <header class="dark">
          <div class="icons"><i class="fa fa-check"></i></div>
          <h5>Categories <span class="badge badge-info badge-pill" title="Nomrbe de categories"> {{ $categories->count() }}</span></h5>
          <!-- .toolbar -->
          <div class="toolbar">
            <nav style="padding: 8px;">
              <a href="#" class="btn btn-info btn-xs" data-toggle="dropdown" title="Options"><i class="fa fa-bars"></i></a>
              <ul class="dropdown-menu">
                <li><a data-toggle="modal" data-original-title="Help" data-placement="bottom" class="btn btn-default btn-sm" href="#modalAddCategorie">Ajouter une nouvelle categorie</a></li>
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
          <table id="categoriesTable" class="display table table-hover table-striped table-bordered" cellspacing="0" width="100%">
            <thead><tr><th>Categorie</th><th>Famille</th><th>date de creation</th><th>Outils</th></tr></thead>
            <tbody>
              @foreach($categories as $item)
                <tr>
                  <td>{{ $item->libelle }}</td>
                  <td>{{ $item->libelle_f }}</td>
                  <td>{{ $item->created_at }}</td>
                  <td>
                    <i class="fa fa-edit" data-toggle="modal" data-target="#modalUpdateCategorie" onclick='updateCategorieFunction({{ $item->id_categorie }}, {{ $item->id_famille }}, "{{ $item->libelle }}" );' title="Modifier" ></i>
                    <i class="glyphicon glyphicon-trash" onclick="deleteCategorieFunction({{ $item->id_categorie }},'{{ $item->libelle }}');" data-placement="bottom" data-original-title="Supprimer" data-toggle="tooltip" ></i>
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
      {{-- *********************************** Categories ************************************* --}}
    </div>

    <div class="col-md-5">
      {{-- *********************************** familles ************************************* --}}
      <div class="box">
        <header class="dark">
          <div class="icons"><i class="fa fa-check"></i></div>
          <h5>Familles <span class="badge badge-info badge-pill" title="Nomrbe de familles"> {{ $familles->count() }}</span></h5>
          <!-- .toolbar -->
          <div class="toolbar">
            <nav style="padding: 8px;">
              <a href="#" class="btn btn-info btn-xs" data-toggle="dropdown" title="Options"><i class="fa fa-bars"></i></a>
              <ul class="dropdown-menu">
                <li><a data-toggle="modal" data-original-title="Help" data-placement="bottom" class="btn btn-default btn-sm" href="#modalAddFamille">Ajouter une nouvelle famille</a></li>
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
          <table id="famillesTable" class="display table table-hover table-striped table-bordered" cellspacing="0" width="100%">
            <thead><tr><th>Famille</th><th>Date de creation</th><th>Outils</th></tr></thead>
            <tbody>
              @foreach($familles as $item)
                <tr>
                  <td>{{ $item->libelle }}</td>
                  <td>{{ $item->created_at }} {{ $item->prenom }}</td>
                  <td>
                    <i class="fa fa-edit" data-toggle="modal" data-target="#modalUpdateFamille" onclick='updateFamilleFunction({{ $item->id_famille }}, "{{ $item->libelle }}" );' title="Modifier" ></i>
                    <i class="glyphicon glyphicon-trash" onclick="deleteFamilleFunction({{ $item->id_famille }},'{{ $item->libelle }}');" data-placement="bottom" data-original-title="Supprimer" data-toggle="tooltip" ></i>
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
      {{-- *********************************** familles ************************************* --}}
    </div>

  </div>

@endsection

@section('modals')

  {{--  @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@  --}}
  {{--  @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@       Users      @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@  --}}
  <div class="CRUD User">
    <form id="formDeleteUser" method="POST" action="{{ route('deleteUser') }}">
      @csrf
      <input type="hidden" id="id_user" name="id" />
    </form>
    <script>
    function deleteUserFunction(id_user, nom, prenom){
      var go = confirm('Vos êtes sur le point d\'effacer l\'utilisateur: "'+nom+' '+prenom+'".\n voulez-vous continuer?');
      if(go){
        document.getElementById("id_user").value = id_user;
        document.getElementById("formDeleteUser").submit();
      }
    }
    function updateUserFunction(id_user, nom, prenom, login){
      document.getElementById("update_id_user").value = id_user;
      document.getElementById("update_nom_user").value = nom;
      document.getElementById("update_prenom_user").value = prenom;
      document.getElementById("update_login_user").value = login;
      //document.getElementById("update_password_equipement").value = password;
    }
    </script>

    {{-- *****************************    Add User    ********************************************** --}}
    <div class="modal fade" id="modalAddUser" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      {{-- Form add User --}}
      <form method="POST" action="{{ route('addUser') }}">
        @csrf

        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              <h4 class="modal-title">Création d'un nouvel utilisateur</h4>
            </div>
            <div class="modal-body">
              <div class="row">
                <div class="col-md-4">
                  {{-- Role --}}
                  <div class="form-group has-feedback">
                    <label>Role</label>
                    <select  class="form-control" name="slug">
                      @foreach ($roles as $item)
                        <option value="{{ $item->slug }}">{{ $item->name }}</option>
                      @endforeach
                    </select>
                  </div>
                </div>
                <div class="col-md-4">
                  {{-- Nom --}}
                  <div class="form-group has-feedback">
                    <label>Nom</label>
                    <input type="text" class="form-control" placeholder="Nom" name="nom" required>
                  </div>
                </div>
                <div class="col-md-4">
                  {{-- Prenom --}}
                  <div class="form-group has-feedback">
                    <label>Prenom</label>
                    <input type="text" class="form-control" placeholder="Prenom" name="prenom">
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-5">
                  {{-- Login --}}
                  <div class="form-group has-feedback">
                    <label>Login</label>
                    <input type="text" class="form-control" placeholder="Login" name="login" required>
                  </div>
                </div>
                <div class="col-md-6">
                  {{-- Password --}}
                  <div class="form-group has-feedback">
                    <label>Password</label>
                    <input type="text" class="form-control" placeholder="Password" name="password" required>
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

    {{-- *****************************    update User    ************************************************* --}}
    <div class="modal fade" id="modalUpdateUser" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      {{-- Form update User --}}
      <form method="POST" action="{{ route('updateUser') }}">
        @csrf
        <input type="hidden" name="id" id="update_id_user">

        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              <h4 class="modal-title">Modification de l'utilisateur</h4>
            </div>
            <div class="modal-body">
              <div class="row">
                <div class="col-md-6">
                  {{-- Nom --}}
                  <div class="form-group has-feedback">
                    <label>Nom</label>
                    <input type="text" class="form-control" placeholder="Nom" name="nom" id="update_nom_user" required>
                  </div>
                </div>
                <div class="col-md-6">
                  {{-- Prenom --}}
                  <div class="form-group has-feedback">
                    <label>Prenom</label>
                    <input type="text" class="form-control" placeholder="Prenom" name="prenom" id="update_prenom_user">
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-5">
                  {{-- Login --}}
                  <div class="form-group has-feedback">
                    <label>Login</label>
                    <input type="text" class="form-control" placeholder="Login" name="login" id="update_login_user" required>
                  </div>
                </div>
                <div class="col-md-6">
                  {{-- Password --}}
                  <div class="form-group has-feedback">
                    <label>Password</label>
                    <input type="text" class="form-control" placeholder="Password" name="password" title='Pour garder votre ancien mot de passe, laissez le champ "Password" vide.'>
                    <span>Pour garder votre ancien mot de passe, laissez le champ "Password" vide.</span>
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
  {{--  @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@       User       @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@  --}}
  {{--  @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@  --}}

  {{--  @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@  --}}
  {{--  @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@       Famille      @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@  --}}
  <div class="CRUD Familles">
    <form id="formDeleteFamille" method="POST" action="{{ route('deleteFamille') }}">
      @csrf
      <input type="hidden" id="delete_id_famille" name="id_famille" />
    </form>
    <script>
    function deleteFamilleFunction(id_famille, libelle){
      var go = confirm('Vos êtes sur le point d\'effacer la famille: "'+libelle+'".\n voulez-vous continuer?');
      if(go){
        document.getElementById("delete_id_famille").value = id_famille;
        document.getElementById("formDeleteFamille").submit();
      }
    }
    function updateFamilleFunction(id_famille, libelle){
      document.getElementById("update_id_famille").value = id_famille;
      document.getElementById("update_libelle_famille").value = libelle;
    }
    </script>

    {{-- *****************************    Add Famille    ********************************************** --}}
    <div class="modal fade" id="modalAddFamille" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      {{-- Form add User --}}
      <form method="POST" action="{{ route('addFamille') }}">
        @csrf

        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              <h4 class="modal-title">Création de nouvelle famille</h4>
            </div>
            <div class="modal-body">
              <div class="row">
                <div class="col-md-4">
                  {{-- Libelle --}}
                  <div class="form-group has-feedback">
                    <label>Nom</label>
                    <input type="text" class="form-control" placeholder="Libelle" name="libelle" required>
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

    {{-- *****************************    update Famille    ************************************************* --}}
    <div class="modal fade" id="modalUpdateFamille" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      {{-- Form update User --}}
      <form method="POST" action="{{ route('updateFamille') }}">
        @csrf
        <input type="hidden" name="id_famille" id="update_id_famille">

        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              <h4 class="modal-title">Modification de la famille</h4>
            </div>
            <div class="modal-body">
              <div class="row">
                <div class="col-md-6">
                  {{-- Nom --}}
                  <div class="form-group has-feedback">
                    <label>Nom</label>
                    <input type="text" class="form-control" placeholder="Libelle" name="libelle" id="update_libelle_famille" required>
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
  {{--  @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@       Familles       @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@  --}}
  {{--  @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@  --}}

  {{--  @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@  --}}
  {{--  @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@       Categorie      @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@  --}}
  <div class="CRUD Categories">
    <form id="formDeleteCategorie" method="POST" action="{{ route('deleteCategorie') }}">
      @csrf
      <input type="hidden" id="delete_id_categorie" name="id_categorie" />
    </form>
    <script>
    function deleteCategorieFunction(id_categorie, libelle){
      var go = confirm('Vos êtes sur le point d\'effacer la categorie: "'+libelle+'".\n voulez-vous continuer?');
      if(go){
        document.getElementById("delete_id_categorie").value = id_categorie;
        document.getElementById("formDeleteCategorie").submit();
      }
    }
    function updateCategorieFunction(id_categorie, id_famille, libelle){
      document.getElementById("update_id_categorie").value = id_categorie;
      document.getElementById("update_id_famille_categorie").value = id_famille;
      document.getElementById("update_libelle_categorie").value = libelle;
    }
    </script>

    {{-- *****************************    Add Categorie    ********************************************** --}}
    <div class="modal fade" id="modalAddCategorie" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      {{-- Form add User --}}
      <form method="POST" action="{{ route('addCategorie') }}">
        @csrf

        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              <h4 class="modal-title">Création d'une nouvelle categorie</h4>
            </div>
            <div class="modal-body">
              <div class="row">
                <div class="col-md-4">
                  {{-- Famille --}}
                  <div class="form-group has-feedback">
                    <label>Famille</label>
                    <select  class="form-control" name="id_famille">
                      @foreach ($familles as $item)
                        <option value="{{ $item->id_famille }}">{{ $item->libelle }}</option>
                      @endforeach
                    </select>
                  </div>
                </div>
                <div class="col-md-4">
                  {{-- Libelle --}}
                  <div class="form-group has-feedback">
                    <label>Nom</label>
                    <input type="text" class="form-control" placeholder="Libelle" name="libelle" required>
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

    {{-- *****************************    update Categorie    ************************************************* --}}
    <div class="modal fade" id="modalUpdateCategorie" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      {{-- Form update Categorie --}}
      <form method="POST" action="{{ route('updateCategorie') }}">
        @csrf
        <input type="hidden" name="id_categorie" id="update_id_categorie">

        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              <h4 class="modal-title">Modification de la famille</h4>
            </div>
            <div class="modal-body">
              <div class="row">
                <div class="col-md-4">
                  {{-- Famille --}}
                  <div class="form-group has-feedback">
                    <label>Famille</label>
                    <select  class="form-control" name="id_famille" id="update_id_famille_categorie">
                      @foreach ($familles as $item)
                        <option value="{{ $item->id_famille }}">{{ $item->libelle }}</option>
                      @endforeach
                    </select>
                  </div>
                </div>
                <div class="col-md-6">
                  {{-- Libelle --}}
                  <div class="form-group has-feedback">
                    <label>Nom</label>
                    <input type="text" class="form-control" placeholder="Libelle" name="libelle" id="update_libelle_categorie" required>
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
  {{--  @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@       Familles       @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@  --}}
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
  <!-- datatables
  <script src="js/lib/datatables/datatables.min.js"></script>
  <script src="js/lib/datatables/cdn.datatables.net/buttons/1.2.2/js/dataTables.buttons.min.js"></script>
  <script src="js/lib/datatables/cdn.datatables.net/buttons/1.2.2/js/buttons.flash.min.js"></script>
  <script src="js/lib/datatables/cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
  <script src="js/lib/datatables/cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/pdfmake.min.js"></script>
  <script src="js/lib/datatables/cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/vfs_fonts.js"></script>
  <script src="js/lib/datatables/cdn.datatables.net/buttons/1.2.2/js/buttons.html5.min.js"></script>
  <script src="js/lib/datatables/cdn.datatables.net/buttons/1.2.2/js/buttons.print.min.js"></script>
  <script src="js/lib/datatables/datatables-init.js"></script>
-->

<!-- scripit init
<script src="js/lib/sweetalert/sweetalert.init.js"></script> -->

<script>

$('#usersTable').DataTable({
  dom: '<lf<Bt>ip>',
  buttons: [
    'copy', 'csv', 'excel', 'pdf', 'print',
  ],
  lengthMenu: [
    [ 5, 10, 25, 50, -1 ],
    [ '5', '10', '25', '50', 'Tout' ]
  ],
  columnDefs: [
    { targets:-1, visible: true, orderable: true},
    { targets: 0, visible: true},
    { targets: 1, visible: true},
    { targets: 2, visible: true},
  ],
});

$('#famillesTable').DataTable({
  dom: '<lf<Bt>ip>',
  buttons: [
    'copy', 'csv', 'excel', 'pdf', 'print',
  ],
  lengthMenu: [
    [ 5, 10, 25, 50, -1 ],
    [ '5', '10', '25', '50', 'Tout' ]
  ],
  columnDefs: [
    { targets:-1, visible: true, orderable: true},
    { targets: 0, visible: true},
    { targets: 1, visible: true},
  ],
  //order: [[ 0, "asc" ]],
});

$('#categoriesTable').DataTable({
  dom: '<lf<Bt>ip>',
  buttons: [
    'copy', 'csv', 'excel', 'pdf', 'print',
  ],
  lengthMenu: [
    [ 5, 10, 25, 50, -1 ],
    [ '5', '10', '25', '50', 'Tout' ]
  ],
  columnDefs: [
    { targets:-1, visible: true, orderable: true},
    { targets: 0, visible: true},
    { targets: 1, visible: true},
  ],
  //order: [[ 0, "asc" ]],
});

$(document).ready(function() {
  $('#familleTable').DataTable({
    "order": [[ 0, "asc" ]],
    "language": {
      "lengthMenu": "Display _MENU_ records per page",
      "zeroRecords": "Nothing found - sorry",
      "info": "Showing page _PAGE_ of _PAGES_",
      "infoEmpty": "No records available",
      "infoFiltered": "(filtered from _MAX_ total records)"
    }
  } );
} );
</script>


@endsection
