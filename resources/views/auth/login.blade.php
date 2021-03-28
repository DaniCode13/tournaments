@extends('layouts.app')

@section('content')


<div class="container">

        <div class="row justify-content-center">
            <div class="col-md-6 col-sm-8 col-lg-4">
                <div class="card">
                    <div class="row">
                        <div class="col-6">
                            <button
                                class="btn btn-block btn-primary btn-link text-white"
                            >
                                Registrarse
                            </button>
                        </div>
                        <div class="col-6">
                            <button class="btn btn-block  btn-link ">
                                Acceder
                            </button>
                        </div>
                    </div>

                    <div class="card-body">
                        <div
                            class=" d-flex bg-white justify-content-center mt-4 mb-4"
                        >
                            <img
                                src="/svg/logo.svg"
                                height="150px"
                                width="150px"
                                alt=""
                            />
                        </div>
                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            <div class="form-group ">
                                <input
                                    id="email"
                                    type="email"
                                    placeholder="Correo Electronico"
                                    class="form-control @error('email') is-invalid @enderror"
                                    name="email"
                                    value="{{ old('email') }}"
                                    required
                                    autocomplete="email"
                                    autofocus
                                />
                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <div class="form-group ">
                                <input
                                    id="password"
                                    type="password"
                                    placeholder="contraseña"
                                    class="form-control @error('password') is-invalid @enderror"
                                    name="password"
                                    required
                                    autocomplete="current-password"
                                />

                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <div class="form-group ">
                                <div class="form-check">
                                    <input class="form-check-input"
                                    type="checkbox" name="remember"
                                    id="remember"
                                    {{ old("remember") ? "checked" : "" }}>

                                    <label
                                        class="form-check-label"
                                        for="remember"
                                    >
                                        Recordarme
                                    </label>
                                </div>
                            </div>

                            <div class="form-group  mb-0">
                                <button
                                    type="submit"
                                    class="btn btn-block btn-primary"
                                >
                                    Iniciar Sesion
                                </button>

                                @if (Route::has('password.request'))
                                <a
                                    class="btn btn-link btn-block"
                                    href="{{ route('password.request') }}"
                                >
                                    ¿olvidaste tu contraseña?
                                </a>
                                @endif
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>



@endsection
