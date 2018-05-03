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
    <div class="col-md-4">
      {{-- *********************************** Societes ************************************* --}}
      <div class="box">
        <header class="dark">
          <div class="icons"><i class="fa fa-check"></i></div>
          <h5>Sociétés <span class="badge badge-info badge-pill" title="Nombre de sociétés"> {{ $societes->count() }}</span></h5>
          <!-- .toolbar -->
          <div class="toolbar">
            <nav style="padding: 8px;">
              <a href="#" class="btn btn-info btn-xs" data-toggle="dropdown" title="Options"><i class="fa fa-bars"></i></a>
              <ul class="dropdown-menu">
                <li><a data-toggle="modal" data-original-title="Help" data-placement="bottom" class="btn btn-default btn-sm" href="#modalAddSociete">Ajouter une nouvelle société</a></li>
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
          <table id="societesTable" class="display table table-hover table-striped table-bordered" cellspacing="0" width="100%">
            <thead><tr><th>Societe</th><th>Date de création</th><th>Outils</th></tr></thead>
            <tbody>
              @foreach($societes as $item)
                <tr>
                  <td>{{ $item->libelle }}</td>
                  <td>{{ formatDateTime($item->created_at) }}</td>
                  <td>
                    <i class="fa fa-edit" data-toggle="modal" data-target="#modalUpdateSociete" onclick='updateSocieteFunction({{ $item->id_societe }}, "{{ $item->libelle }}" );' title="Modifier" ></i>
                    <i class="glyphicon glyphicon-trash" onclick="deleteSocieteFunction({{ $item->id_societe }},'{{ $item->libelle }}');" data-placement="bottom" data-original-title="Supprimer" data-toggle="tooltip" ></i>
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
      {{-- *********************************** Societes ************************************* --}}
    </div>
    <div class="col-md-4">
      {{-- *********************************** Sites ************************************* --}}
      <div class="box">
        <header class="dark">
          <div class="icons"><i class="fa fa-check"></i></div>
          <h5>Sites <span class="badge badge-info badge-pill" title="Nombre de sites"> {{ $sites->count() }}</span></h5>
          <!-- .toolbar -->
          <div class="toolbar">
            <nav style="padding: 8px;">
              <a href="#" class="btn btn-info btn-xs" data-toggle="dropdown" title="Options"><i class="fa fa-bars"></i></a>
              <ul class="dropdown-menu">
                <li><a data-toggle="modal" data-original-title="Help" data-placement="bottom" class="btn btn-default btn-sm" href="#modalAddSite">Ajouter un nouveau site</a></li>
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
          <table id="sitesTable" class="display table table-hover table-striped table-bordered" cellspacing="0" width="100%">
            <thead><tr><th>Site</th><th>Societe</th><th>Date de creation</th><th>Outils</th></tr></thead>
            <tbody>
              @foreach($sites as $item)
                <tr>
                  <td>{{ $item->libelle }}</td>
                  <td>{{ $item->libelle_so }}</td>
                  <td>{{ formatDateTime($item->created_at) }}</td>
                  <td>
                    <i class="fa fa-edit" data-toggle="modal" data-target="#modalUpdateSite" onclick='updateSiteFunction({{ $item->id_site }},{{ $item->id_societe }}, "{{ $item->libelle }}" );' title="Modifier" ></i>
                    <i class="glyphicon glyphicon-trash" onclick="deleteSiteFunction({{ $item->id_site }},'{{ $item->libelle }}');" data-placement="bottom" data-original-title="Supprimer" data-toggle="tooltip" ></i>
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
      {{-- *********************************** Sites ************************************* --}}
    </div>
    <div class="col-md-4">
      {{-- *********************************** Zones ************************************* --}}
      <div class="box">
        <header class="dark">
          <div class="icons"><i class="fa fa-check"></i></div>
          <h5>Zones <span class="badge badge-info badge-pill" title="Nombre de zones"> {{ $zones->count() }}</span></h5>
          <!-- .toolbar -->
          <div class="toolbar">
            <nav style="padding: 8px;">
              <a href="#" class="btn btn-info btn-xs" data-toggle="dropdown" title="Options"><i class="fa fa-bars"></i></a>
              <ul class="dropdown-menu">
                <li><a data-toggle="modal" data-original-title="Help" data-placement="bottom" class="btn btn-default btn-sm" href="#modalAddZone">Ajouter une nouvelle zone</a></li>
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
          <table id="zonesTable" class="display table table-hover table-striped table-bordered" cellspacing="0" width="100%">
            <thead><tr><th>Zone</th><th>Site</th><th>Date de creation</th><th>Outils</th></tr></thead>
            <tbody>
              @foreach($zones as $item)
                <tr>
                  <td>{{ $item->libelle }}</td>
                  <td>{{ $item->libelle_s }}</td>
                  <td>{{ formatDateTime($item->created_at) }}</td>
                  <td>
                    <i class="fa fa-edit" data-toggle="modal" data-target="#modalUpdateZone" onclick='updateZoneFunction({{ $item->id_zone }},{{ $item->id_site }}, "{{ $item->libelle }}" );' title="Modifier" ></i>
                    <i class="glyphicon glyphicon-trash" onclick="deleteZoneFunction({{ $item->id_zone }},'{{ $item->libelle }}');" data-placement="bottom" data-original-title="Supprimer" data-toggle="tooltip" ></i>
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
      {{-- *********************************** Zones ************************************* --}}
    </div>
  </div>

  <hr>

  <div class="row">
    <div class="col-md-8">
      {{-- *********************************** Users ************************************* --}}
      <div class="box">
        <header class="dark">
          <div class="icons"><i class="fa fa-check"></i></div>
          <h5>Utilisateurs <span class="badge badge-info badge-pill" title="Nombre d'utilisateurs"> {{ $users->count() }}</span></h5>
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
                  <td>{{ formatDateTime($item->last_login) }}</td>
                  <td>
                    <i class="fa fa-edit" data-toggle="modal" data-target="#modalUpdateUser"
                    onclick='updateUserFunction({{ $item->id_user }}, "{{ $item->nom }}", "{{ $item->prenom }}","{{ $item->login }}","{{ $item->slug }}", {{ $item->id_societe == null ? 0 : $item->id_societe }},{{ $item->id_zone == null ? 0: $item->id_zone }} );' title="Modifier" ></i>
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
    <div class="col-md-4">
      {{-- *********************************** Unites ************************************* --}}
      <div class="box">
        <header class="dark">
          <div class="icons"><i class="fa fa-check"></i></div>
          <h5>Unités <span class="badge badge-info badge-pill" title="Nombre d'unités"> {{ $unites->count() }}</span></h5>
          <div class="toolbar">
            <nav style="padding: 8px;">
              <a href="#" class="btn btn-info btn-xs" data-toggle="dropdown" title="Options"><i class="fa fa-bars"></i></a>
              <ul class="dropdown-menu">
                <li><a data-toggle="modal" data-original-title="Help" data-placement="bottom" class="btn btn-default btn-sm" href="#modalAddUnite">Ajouter une nouvelle Unité</a></li>
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
          <table id="unitesTable" class="display table table-hover table-striped table-bordered" cellspacing="0" width="100%">
            <thead><tr><th>Unité</th><th>Date de création</th><th>Outils</th></tr></thead>
            <tbody>
              @foreach($unites as $item)
                <tr>
                  <td>{{ $item->libelle }}</td>
                  <td>{{ $item->created_at }}</td>
                  <td>
                    <i class="fa fa-edit" data-toggle="modal" data-target="#modalUpdateUnite" onclick='updateUniteFunction({{ $item->id_unite }}, "{{ $item->libelle }}" );' title="Modifier" ></i>
                    <i class="glyphicon glyphicon-trash" onclick="deleteUniteFunction({{ $item->id_unite }},'{{ $item->libelle }}');" data-placement="bottom" data-original-title="Supprimer" data-toggle="tooltip" ></i>
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
      {{-- *********************************** Unites ************************************* --}}
    </div>
  </div>

  <hr>

  <div class="row">
    <div class="col-md-7">

      {{-- *********************************** familles ************************************* --}}
      <div class="box">
        <header class="dark">
          <div class="icons"><i class="fa fa-check"></i></div>
          <h5>Familles <span class="badge badge-info badge-pill" title="Nombre de familles"> {{ $familles->count() }}</span></h5>
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
            <thead><tr><th>Famille</th><th>Catégorie</th><th>Date de creation</th><th>Outils</th></tr></thead>
            <tbody>
              @foreach($familles as $item)
                <tr>
                  <td>{{ $item->libelle }}</td>
                  <td>{{ $item->libelle_categorie }}</td>
                  <td>{{ $item->created_at }}</td>
                  <td>
                    <i class="fa fa-edit" data-toggle="modal" data-target="#modalUpdateFamille" onclick='updateFamilleFunction({{ $item->id_famille }},{{ $item->id_categorie }}, "{{ $item->libelle }}" );' title="Modifier" ></i>
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

    <div class="col-md-5">
      {{-- *********************************** Categories ************************************* --}}
      <div class="box">
        <header class="dark">
          <div class="icons"><i class="fa fa-check"></i></div>
          <h5>Categories <span class="badge badge-info badge-pill" title="Nombre de categories"> {{ $categories->count() }}</span></h5>
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
            <thead><tr><th>Categorie</th><th>date de creation</th><th>Outils</th></tr></thead>
            <tbody>
              @foreach($categories as $item)
                <tr>
                  <td>{{ $item->libelle }}</td>
                  <td>{{ $item->created_at }}</td>
                  <td>
                    <i class="fa fa-edit" data-toggle="modal" data-target="#modalUpdateCategorie" onclick='updateCategorieFunction({{ $item->id_categorie }},"{{ $item->libelle }}" );' title="Modifier" ></i>
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
    function updateUserFunction(id_user, nom, prenom, login, role, id_societe, id_zone){
      if(role == "admin"){
        document.getElementById("update_form_societe").style.visibility = "hidden";
        document.getElementById("update_form_zone").style.visibility = "hidden";
        document.getElementById("update_id_societe_user").value = 0;
        document.getElementById("update_id_zone_user").value = 0;
      }
      if(role == "ouvrier"){
        document.getElementById("update_form_societe").style.visibility = "hidden";
        document.getElementById("update_form_zone").style.visibility = "visible";
        document.getElementById("update_id_societe_user").value = 0;
        document.getElementById("update_id_zone_user").value = id_zone;
      }
      else if(role == "controleur"){
        document.getElementById("update_form_societe").style.visibility = "visible";
        document.getElementById("update_form_zone").style.visibility = "hidden";
        document.getElementById("update_id_societe_user").value = id_societe;
        document.getElementById("update_id_zone_user").value = 0;
      }
      document.getElementById("update_id_user").value = id_user;
      document.getElementById("update_nom_user").value = nom;
      document.getElementById("update_prenom_user").value = prenom;
      document.getElementById("update_login_user").value = login;

    }

    function onSelectedRoleUser(){
      var role = document.getElementById("id_role").value;
      if(role == "admin"){
        document.getElementById("form_societe").style.visibility = "hidden";
        document.getElementById("form_zone").style.visibility = "hidden";
      }
      if(role == "ouvrier"){
        document.getElementById("form_societe").style.visibility = "hidden";
        document.getElementById("form_zone").style.visibility = "visible";
      }
      else if(role == "controleur"){
        document.getElementById("form_societe").style.visibility = "visible";
        document.getElementById("form_zone").style.visibility = "hidden";
      }
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
                    <select  class="form-control" name="slug" onchange="onSelectedRoleUser();" id="id_role">
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
              <div class="row">
                <div class="col-md-5" id="form_zone" style="visibility: hidden">
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
                <div class="col-md-5" id="form_societe" style="visibility: hidden">
                  {{-- Société --}}
                  <div class="form-group has-feedback">
                    <label>Société</label>
                    <select  class="form-control" name="id_societe" id="id_societe">
                      @foreach ($societes as $item)
                        <option value="{{ $item->id_societe }}">{{ $item->libelle }}</option>
                      @endforeach
                    </select>
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
              <div class="row">
                <div class="col-md-5" id="update_form_zone" style="visibility: hidden">
                  {{-- Zone --}}
                  <div class="form-group has-feedback">
                    <label>Zone</label>
                    <select  class="form-control" name="id_zone" id="update_id_zone_user">
                      @foreach ($zones as $item)
                        <option value="{{ $item->id_zone }}">{{ $item->libelle }}</option>
                      @endforeach
                    </select>
                  </div>
                </div>
                <div class="col-md-5" id="update_form_societe" style="visibility: hidden">
                  {{-- Société --}}
                  <div class="form-group has-feedback">
                    <label>Société</label>
                    <select  class="form-control" name="id_societe" id="update_id_societe_user">
                      @foreach ($societes as $item)
                        <option value="{{ $item->id_societe }}">{{ $item->libelle }}</option>
                      @endforeach
                    </select>
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
  {{--  @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@       Users       @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@  --}}

  {{--  @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@       Familles      @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@  --}}
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
    function updateFamilleFunction(id_famille, id_categorie, libelle){
      document.getElementById("update_id_famille").value = id_famille;
      document.getElementById("update_id_categorie_famille").value = id_categorie;
      document.getElementById("update_libelle_famille").value = libelle;
    }
    </script>

    {{-- *****************************    Add Famille    ********************************************** --}}
    <div class="modal fade" id="modalAddFamille" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      {{-- Form add Famille --}}
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
                  {{-- Catégorie --}}
                  <div class="form-group has-feedback">
                    <label>Catégorie</label>
                    <select  class="form-control" name="id_categorie">
                      @foreach ($categories as $item)
                        <option value="{{ $item->id_categorie }}">{{ $item->libelle }}</option>
                      @endforeach
                    </select>
                  </div>
                </div>
                <div class="col-md-6">
                  {{-- Famille --}}
                  <div class="form-group has-feedback">
                    <label>Famille</label>
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
      {{-- Form update Famille --}}
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
                <div class="col-md-4">
                  {{-- Categorie --}}
                  <div class="form-group has-feedback">
                    <label>Catégorie</label>
                    <select  class="form-control" name="id_categorie" id="update_id_categorie_famille">
                      @foreach ($categories as $item)
                        <option value="{{ $item->id_categorie }}">{{ $item->libelle }}</option>
                      @endforeach
                    </select>
                  </div>
                </div>
                <div class="col-md-6">
                  {{-- Famille --}}
                  <div class="form-group has-feedback">
                    <label>Famille</label>
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
  {{--  @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@       Familles      @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@  --}}

  {{--  @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@       Categories      @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@  --}}
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
                <div class="col-md-6">
                  {{-- Libelle --}}
                  <div class="form-group has-feedback">
                    <label>Catégorie</label>
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
  {{--  @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@       Categories       @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@  --}}

  {{--  @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@       Societes      @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@  --}}
  <div class="CRUD Societes">
    <form id="formDeleteSociete" method="POST" action="{{ route('deleteSociete') }}">
      @csrf
      <input type="hidden" id="delete_id_societe" name="id_societe" />
    </form>
    <script>
    function deleteSocieteFunction(id_societe, libelle){
      var go = confirm('Vos êtes sur le point d\'effacer la société: "'+libelle+'".\n voulez-vous continuer?');
      if(go){
        document.getElementById("delete_id_societe").value = id_societe;
        document.getElementById("formDeleteSociete").submit();
      }
    }
    function updateSocieteFunction(id_societe, libelle){
      document.getElementById("update_id_societe").value = id_societe;
      document.getElementById("update_libelle_societe").value = libelle;
    }
    </script>

    {{-- *****************************    Add Societe    ********************************************** --}}
    <div class="modal fade" id="modalAddSociete" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      {{-- Form add Societe --}}
      <form method="POST" action="{{ route('addSociete') }}">
        @csrf
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              <h4 class="modal-title">Création d'une nouvelle société</h4>
            </div>
            <div class="modal-body">
              <div class="row">
                <div class="col-md-7">
                  {{-- Libelle --}}
                  <div class="form-group has-feedback">
                    <label>Société</label>
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

    {{-- *****************************    update Societe    ************************************************* --}}
    <div class="modal fade" id="modalUpdateSociete" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      {{-- Form update Categorie --}}
      <form method="POST" action="{{ route('updateSociete') }}">
        @csrf
        <input type="hidden" name="id_societe" id="update_id_societe">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              <h4 class="modal-title">Modification de la société</h4>
            </div>
            <div class="modal-body">
              <div class="row">
                <div class="col-md-7">
                  {{-- Libelle --}}
                  <div class="form-group has-feedback">
                    <label>Société</label>
                    <input type="text" class="form-control" placeholder="Libelle" name="libelle" id="update_libelle_societe" required>
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
  {{--  @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@       Societes      @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@  --}}

  {{--  @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@       Sites      @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@  --}}
  <div class="CRUD Sites">
    <form id="formDeleteSite" method="POST" action="{{ route('deleteSite') }}">
      @csrf
      <input type="hidden" id="delete_id_site" name="id_site" />
    </form>
    <script>
    function deleteSiteFunction(id_site, libelle){
      var go = confirm('Vos êtes sur le point d\'effacer le site: "'+libelle+'".\n voulez-vous continuer?');
      if(go){
        document.getElementById("delete_id_site").value = id_site;
        document.getElementById("formDeleteSite").submit();
      }
    }
    function updateSiteFunction(id_site,id_societe, libelle){
      document.getElementById("update_id_site").value = id_site;
      document.getElementById("update_id_societe_site").value = id_societe;
      document.getElementById("update_libelle_site").value = libelle;
    }
    </script>

    {{-- *****************************    Add Site    ********************************************** --}}
    <div class="modal fade" id="modalAddSite" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      {{-- Form add Site --}}
      <form method="POST" action="{{ route('addSite') }}">
        @csrf
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              <h4 class="modal-title">Création d'un nouveau site</h4>
            </div>
            <div class="modal-body">
              <div class="row">
                <div class="col-md-4">
                  {{-- Societe --}}
                  <div class="form-group has-feedback">
                    <label>Société</label>
                    <select  class="form-control" name="id_societe">
                      @foreach ($societes as $item)
                        <option value="{{ $item->id_societe }}">{{ $item->libelle }}</option>
                      @endforeach
                    </select>
                  </div>
                </div>
                <div class="col-md-8">
                  {{-- Libelle --}}
                  <div class="form-group has-feedback">
                    <label>Site</label>
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

    {{-- *****************************    update Site    ************************************************* --}}
    <div class="modal fade" id="modalUpdateSite" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      {{-- Form update Site --}}
      <form method="POST" action="{{ route('updateSite') }}">
        @csrf
        <input type="hidden" name="id_site" id="update_id_site">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              <h4 class="modal-title">Modification du site</h4>
            </div>
            <div class="modal-body">
              <div class="row">
                <div class="col-md-4">
                  {{-- Societe --}}
                  <div class="form-group has-feedback">
                    <label>Société</label>
                    <select  class="form-control" name="id_societe" id="update_id_societe_site">
                      @foreach ($societes as $item)
                        <option value="{{ $item->id_societe }}">{{ $item->libelle }}</option>
                      @endforeach
                    </select>
                  </div>
                </div>
                <div class="col-md-8">
                  {{-- Libelle --}}
                  <div class="form-group has-feedback">
                    <label>Site</label>
                    <input type="text" class="form-control" placeholder="Libelle" name="libelle" id="update_libelle_site" required>
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
  {{--  @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@       Sites      @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@  --}}

  {{--  @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@       Zones      @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@  --}}
  <div class="CRUD Zones">
    <form id="formDeleteZone" method="POST" action="{{ route('deleteZone') }}">
      @csrf
      <input type="hidden" id="delete_id_zone" name="id_zone" />
    </form>
    <script>
    function deleteZoneFunction(id_zone, libelle){
      var go = confirm('Vos êtes sur le point d\'effacer la zone: "'+libelle+'".\n voulez-vous continuer?');
      if(go){
        document.getElementById("delete_id_zone").value = id_zone;
        document.getElementById("formDeleteZone").submit();
      }
    }
    function updateZoneFunction(id_zone,id_site, libelle){
      document.getElementById("update_id_zone").value = id_zone;
      document.getElementById("update_id_site_zone").value = id_site;
      document.getElementById("update_libelle_zone").value = libelle;
    }
    </script>

    {{-- *****************************    Add Zone    ********************************************** --}}
    <div class="modal fade" id="modalAddZone" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      {{-- Form add Zone --}}
      <form method="POST" action="{{ route('addZone') }}">
        @csrf
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              <h4 class="modal-title">Création d'une nouvelle zone</h4>
            </div>
            <div class="modal-body">
              <div class="row">
                <div class="col-md-4">
                  {{-- Site --}}
                  <div class="form-group has-feedback">
                    <label>Site</label>
                    <select  class="form-control" name="id_site">
                      @foreach ($sites as $item)
                        <option value="{{ $item->id_site }}">{{ $item->libelle }}</option>
                      @endforeach
                    </select>
                  </div>
                </div>
                <div class="col-md-8">
                  {{-- Libelle --}}
                  <div class="form-group has-feedback">
                    <label>Zone</label>
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

    {{-- *****************************    update Zone    ************************************************* --}}
    <div class="modal fade" id="modalUpdateZone" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      {{-- Form update Zone --}}
      <form method="POST" action="{{ route('updateZone') }}">
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
                      @foreach ($sites as $item)
                        <option value="{{ $item->id_site }}">{{ $item->libelle }}</option>
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
  {{--  @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@       Zones      @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@  --}}

  {{--  @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@       Unites      @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@  --}}
  <div class="CRUD Unites">
    <form id="formDeleteUnite" method="POST" action="{{ route('deleteUnite') }}">
      @csrf
      <input type="hidden" id="delete_id_unite" name="id_unite" />
    </form>
    <script>
    function deleteUniteFunction(id_unite, libelle){
      var go = confirm('Vos êtes sur le point d\'effacer l\'unité: "'+libelle+'".\n voulez-vous continuer?');
      if(go){
        document.getElementById("delete_id_unite").value = id_unite;
        document.getElementById("formDeleteUnite").submit();
      }
    }
    function updateUniteFunction(id_unite, libelle){
      document.getElementById("update_id_unite").value = id_unite;
      document.getElementById("update_libelle_unite").value = libelle;
    }
    </script>

    {{-- *****************************    Add Unite    ********************************************** --}}
    <div class="modal fade" id="modalAddUnite" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      {{-- Form add Unite --}}
      <form method="POST" action="{{ route('addUnite') }}">
        @csrf
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              <h4 class="modal-title">Création d'une nouvelle Unité</h4>
            </div>
            <div class="modal-body">
              <div class="row">
                <div class="col-md-7">
                  {{-- Libelle --}}
                  <div class="form-group has-feedback">
                    <label>Unité</label>
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

    {{-- *****************************    update Unite    ************************************************* --}}
    <div class="modal fade" id="modalUpdateUnite" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      {{-- Form update Unite --}}
      <form method="POST" action="{{ route('updateUnite') }}">
        @csrf
        <input type="hidden" name="id_unite" id="update_id_unite">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              <h4 class="modal-title">Modification de l'unité</h4>
            </div>
            <div class="modal-body">
              <div class="row">
                <div class="col-md-7">
                  {{-- Libelle --}}
                  <div class="form-group has-feedback">
                    <label>Unité</label>
                    <input type="text" class="form-control" placeholder="Libelle" name="libelle" id="update_libelle_unite" required>
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
  {{--  @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@       Unites      @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@  --}}

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
    { targets:-1, visible: true, orderable: true, searchable: false},
    { targets: 0, visible: true, type: "string"},
    { targets: 1, visible: true},
  ],
  //order: [[ 0, "asc" ]],
});

$('#societesTable').DataTable({
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

$('#sitesTable').DataTable({
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

$('#zonesTable').DataTable({
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
