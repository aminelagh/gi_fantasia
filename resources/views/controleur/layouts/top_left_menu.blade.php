<div class="collapse navbar-collapse navbar-ex1-collapse">
  <ul class="nav navbar-nav">
    <li><a href="{{ route('controleur') }}">Accueil</a></li>
    <li><a href="{{ route('c.inventairesValide') }}">Inventaires valide</a></li>
    <li><a href="{{ route('c.articles') }}">Articles</a></li>
    <li class='dropdown'>
      <a href="#" class="dropdown-toggle" data-toggle="dropdown"> Menu <b class="caret"></b></a>
      <ul class="dropdown-menu">
        <li><a href="#">Option 1</a></li>
        <li><a href="#">Option 2</a></li>
      </ul>
    </li>
  </ul>
</div>
