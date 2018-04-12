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


  </div>

  <div class="row">
    <div class="col-lg-12">
      {{-- *********************************** Users ************************************* --}}
      <div class="card">
        <div class="card-body">
          <div class="row">
            <div class="col-lg-8">
              <h2 class="card-title">Utilisateurs</h2>
            </div>
            <div class="col-lg-2"></div>
            <div class="col-lg-2">
              <div class="btn-group">
                <button type="button" class="btn btn-light dropdown-toggle waves-effect" data-toggle="dropdown" aria-expanded="false">Options <span class="caret m-l-5"></span></button>
                <div class="dropdown-menu">
                  <span class="dropdown-header"></span>
                  <a class="dropdown-item ModelAddUser">Ajouter un utilisateur</a>
                </div>
              </div>
            </div>
          </div>
          <div class="table-responsive m-t-0">
            <table id="usersTable" class="display table table-hover table-striped table-bordered" cellspacing="0" width="100%">
              <thead>
                <tr>
                  <th>Role</th>
                  <th>Utilisateur</th>
                  <th>Login</th>
                  <th>last login</th>
                  <th>tools</th>
                </tr>
              </thead>
              <tfoot>
                <tr>
                  <th>Role</th>
                  <th>Utilisateur</th>
                  <th>Login</th>
                  <th>last login</th>
                  <th>tools</th>
                </tr>
              </tfoot>
              <tbody>
                @foreach($users as $item)
                  <tr>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->nom }} {{ $item->prenom }}</td>
                    <td>{{ $item->login }}</td>
                    <td>{{ $item->last_login }}</td>
                    <td></td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>








@endsection

@section('styles')
  <link href="css/lib/sweetalert/sweetalert.css" rel="stylesheet">
@endsection

@section('scripts')
  <!-- datatables -->
  <script src="js/lib/datatables/datatables.min.js"></script>
  <script src="js/lib/datatables/cdn.datatables.net/buttons/1.2.2/js/dataTables.buttons.min.js"></script>
  <script src="js/lib/datatables/cdn.datatables.net/buttons/1.2.2/js/buttons.flash.min.js"></script>
  <script src="js/lib/datatables/cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
  <script src="js/lib/datatables/cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/pdfmake.min.js"></script>
  <script src="js/lib/datatables/cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/vfs_fonts.js"></script>
  <script src="js/lib/datatables/cdn.datatables.net/buttons/1.2.2/js/buttons.html5.min.js"></script>
  <script src="js/lib/datatables/cdn.datatables.net/buttons/1.2.2/js/buttons.print.min.js"></script>
  <script src="js/lib/datatables/datatables-init.js"></script>

  <!-- sweetalert -->
  <script src="js/lib/sweetalert/sweetalert.min.js"></script>
  <!-- scripit init
  <script src="js/lib/sweetalert/sweetalert.init.js"></script> -->

  <script>

  document.querySelector('.ModelAddUser').onclick = function(){
    swal({
      title: "An input!",
      text: "Write something interesting:",
      type: "input",
      showCancelButton: true,
      closeOnConfirm: false,
      inputPlaceholder: "Write something"
    }, function (inputValue) {
      if (inputValue === false) return false;
      if (inputValue === "") {
        swal.showInputError("You need to write something!");
        return false
      }
      swal("Nice!", "You wrote: " + inputValue, "success");
    });
  };


  document.querySelector('.ModelAddUsers').onclick = function(){
    swal({
      title: "Sweet !!",
      button: {
        text: "OKaa",
        value: true,
        visible: true,
        className: "",
        closeModal: true,
      },
      text: `
      <div class="row">
      <div class="col-lg-12">
      <form method="POST" action="{{ route('addUser') }}">
      @csrf
      <div class="modal-dialog" role="document">
      <div class="modal-content">
      <div class="modal-header">
      <h5 class="modal-title" id="exampleModalLabel">Ajouter un Utilisateur</h5>
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
      <span aria-hidden="true">&times;</span>
      </button>
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
      </div>
      `,
      html: true,
    });
  };



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

  $(document).ready(function() {
    $('#users').DataTable( {
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
