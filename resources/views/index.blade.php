@extends('partials.login')

@section('content')
<main class="form-signin w-100 m-auto">
    <div class="card py-3 px-3" style="width: 23rem;">
        <div class="container">
          {{-- <form id="login-form" method="POST">
            @csrf  --}}
           <img class="mb-4 mt-3" src="/assets/logo.png" alt="" width="100">
            <h1 class="h4 mb-3 fw-normal">Please Sign in</h1>
          <div class="form-floating">
          <input type="text" class="form-control" id="name" placeholder="Name" name="name">
          <label for="name">Name</label>
          </div>
          <button class="btn btn-primary w-100 py-2 mt-2 signIn-btn" type="submit">Sign in</button>
          {{-- </form> --}}
      </div>
    </div>
</main>
@endsection

@section('script')
<script>
        $(document).ready(function () {
        $('.signIn-btn').on('click', function (e) {
            e.preventDefault();
            const name = $('#name').val();

            $.ajax({
                type: 'POST',
                url: '/', // Sesuaikan dengan URL Anda
                data: { 
                name: name, 
                _token: '{{ csrf_token() }}' 
                },
                dataType: 'json',
                success: function (response) {
                        if (response.role === 'superadmin') {
                            Swal.fire({
                                icon: 'success',
                                title: 'Login Success',
                                text: 'Welcome, ' +name+ '!'
                            }).then(function () {
                            window.location.href = '/inventory';
                        });
                        } else if (response.role === 'sales') {
                            Swal.fire({
                                icon: 'success',
                                title: 'Login Success',
                                text: 'Welcome, ' +name+ '!'
                            }).then(function () {
                            window.location.href = 'sales';
                        });
                        } else if (response.role === 'purchase') {
                            Swal.fire({
                                icon: 'success',
                                title: 'Login Success',
                                text: 'Welcome, ' +name+ '!'
                            }).then(function () {
                            window.location.href = '/purchase';
                        });
                        } else if (response.role === 'manager') {
                            Swal.fire({
                                icon: 'success',
                                title: 'Login Success',
                                text: 'Welcome, ' +name+ '!'
                            }).then(function () {
                            window.location.href = '/sales';
                        });
                      }
                    },
                    error: function () {
                        Swal.fire({
                            icon: 'error',
                            title: 'Login Failed',
                            text: 'An error occurred.'
                        });
                  }
            });
        });

});
    </script>
@endsection