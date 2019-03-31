<header class="mb-4">
    <nav class="navbar navbar-expand-sm navbar-dark bg-dark">
        <a class="navbar-brand" href="/">Microposts</a>
        
        <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#nav-bar">
            <span class="navbar-toggler-icon"></span>
        </button>
        
        <div class="collapse navbar-collapse" id="nav-bar">
            <ul class="navbar-nav mr-auto"></ul>
            {{-- ulを二つ書かずとも、二つ目のulにml-autoと記述すれば、一つ目のulが無くても似たように出来る --}}
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">{!! link_to_route("signup.get","Signup",[],["class" => "nav-link"]) !!}</li>
                <li class="nav-item"><a href="#" class="nav-link">Login</a></li>
            </ul>
        </div>
    </nav>
</header>