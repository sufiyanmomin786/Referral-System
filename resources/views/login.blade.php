<h1>Login</h1>


<form action="{{ route('login') }}" method="POST">
    @csrf

    <input type="email" placeholder="Enter email" name="email">
    @error('error')
        <span style="color:red; ">{{ $message }}</span>
    @enderror
    <br><br>

    <input type="password" placeholder="Enter password" name="password">
    @error('password')
        <span style="color:red; ">{{ $message }}</span>
    @enderror
    <br><br>

    <input type="submit" value="Login">

</form>

@if (Session::has('success'))
    <p style="color-green">{{ Session::get('success') }}</p>
@endif

@if (Session::has('error'))
    <p style="color-red">{{ Session::get('error') }}</p>
@endif
