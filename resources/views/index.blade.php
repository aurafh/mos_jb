@extends('partials.login')

@section('content')
<main class="form-signin w-100 m-auto">
    <div class="card py-3 px-3" style="width: 23rem;">
        <div class="container">
          <form action="{{ route('login') }}" method="post">
            @csrf
            <img class="mb-4 mt-3" src="/assets/logo.png" alt="" width="100">
            <h1 class="h3 mb-3 fw-normal">Please sign in</h1>
        <div class="form-floating">
        <input type="text" class="form-control" id="name" placeholder="Name" name="name">
        <label for="name">Name</label>
      </div>
      <button class="btn btn-primary w-100 py-2 mt-2" type="submit">Sign in</button>
    </form>
</div>
</div>
  </main>
@endsection