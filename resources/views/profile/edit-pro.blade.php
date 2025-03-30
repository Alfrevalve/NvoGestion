@extends('layouts.sb-admin-pro')

@section('title', 'Perfil - GesVitalPro')

@section('header-icon')
    <i class="fas fa-user"></i>
@endsection

@section('header-title', 'Perfil')

@section('header-subtitle', 'Administre su información personal')

@section('content')
<div class="row">
    <div class="col-xl-4">
        <!-- Profile picture card -->
        <div class="card mb-4 mb-xl-0">
            <div class="card-header">Foto de Perfil</div>
            <div class="card-body text-center">
                <!-- Profile picture image -->
                <img class="img-account-profile rounded-circle mb-2" src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=0061f2&color=fff&size=150" alt="{{ $user->name }}" />
                <!-- Profile picture help block -->
                <div class="small font-italic text-muted mb-4">JPG o PNG no mayor a 5MB</div>
                <!-- Profile picture upload button -->
                <button class="btn btn-primary" type="button">Subir nueva imagen</button>
            </div>
        </div>
    </div>
    <div class="col-xl-8">
        <!-- Account details card -->
        <div class="card mb-4">
            <div class="card-header">Información de Perfil</div>
            <div class="card-body">
                <form method="post" action="{{ route('profile.update') }}">
                    @csrf
                    @method('patch')
                    
                    <!-- Form Group (name) -->
                    <div class="mb-3">
                        <label class="small mb-1" for="name">Nombre</label>
                        <input class="form-control @error('name') is-invalid @enderror" id="name" name="name" type="text" value="{{ old('name', $user->name) }}" required autofocus autocomplete="name" />
                        @error('name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    
                    <!-- Form Group (email address) -->
                    <div class="mb-3">
                        <label class="small mb-1" for="email">Correo electrónico</label>
                        <input class="form-control @error('email') is-invalid @enderror" id="email" name="email" type="email" value="{{ old('email', $user->email) }}" required autocomplete="username" />
                        @error('email')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                        
                        @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                            <div class="mt-2">
                                <p class="small text-muted">
                                    Su correo electrónico no está verificado.
                                    
                                    <form id="send-verification" method="post" action="{{ route('verification.send') }}" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-link p-0 m-0 align-baseline small">
                                            Haga clic aquí para reenviar el correo de verificación.
                                        </button>
                                    </form>
                                </p>
                                
                                @if (session('status') === 'verification-link-sent')
                                    <p class="mt-2 small text-success">
                                        Se ha enviado un nuevo enlace de verificación a su dirección de correo electrónico.
                                    </p>
                                @endif
                            </div>
                        @endif
                    </div>
                    
                    <!-- Save changes button -->
                    <button class="btn btn-primary" type="submit">Guardar cambios</button>
                    
                    @if (session('status') === 'profile-updated')
                        <div class="alert alert-success mt-3" role="alert">
                            Perfil actualizado correctamente.
                        </div>
                    @endif
                </form>
            </div>
        </div>
        
        <!-- Change password card -->
        <div class="card mb-4">
            <div class="card-header">Cambiar Contraseña</div>
            <div class="card-body">
                <form method="post" action="{{ route('password.update') }}">
                    @csrf
                    @method('put')
                    
                    <!-- Form Group (current password) -->
                    <div class="mb-3">
                        <label class="small mb-1" for="current_password">Contraseña actual</label>
                        <input class="form-control @error('current_password') is-invalid @enderror" id="current_password" name="current_password" type="password" required autocomplete="current-password" />
                        @error('current_password')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    
                    <!-- Form Group (new password) -->
                    <div class="mb-3">
                        <label class="small mb-1" for="password">Nueva contraseña</label>
                        <input class="form-control @error('password') is-invalid @enderror" id="password" name="password" type="password" required autocomplete="new-password" />
                        @error('password')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    
                    <!-- Form Group (confirm password) -->
                    <div class="mb-3">
                        <label class="small mb-1" for="password_confirmation">Confirmar nueva contraseña</label>
                        <input class="form-control @error('password_confirmation') is-invalid @enderror" id="password_confirmation" name="password_confirmation" type="password" required autocomplete="new-password" />
                        @error('password_confirmation')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    
                    <!-- Save changes button -->
                    <button class="btn btn-primary" type="submit">Actualizar contraseña</button>
                    
                    @if (session('status') === 'password-updated')
                        <div class="alert alert-success mt-3" role="alert">
                            Contraseña actualizada correctamente.
                        </div>
                    @endif
                </form>
            </div>
        </div>
        
        <!-- Delete account card -->
        <div class="card mb-4">
            <div class="card-header bg-danger text-white">Eliminar Cuenta</div>
            <div class="card-body">
                <p class="mb-3">Una vez que se elimine su cuenta, todos sus recursos y datos se borrarán permanentemente. Antes de eliminar su cuenta, descargue cualquier dato o información que desee conservar.</p>
                
                <button class="btn btn-danger" type="button" data-bs-toggle="modal" data-bs-target="#deleteAccountModal">
                    Eliminar Cuenta
                </button>
                
                <!-- Delete Account Modal -->
                <div class="modal fade" id="deleteAccountModal" tabindex="-1" aria-labelledby="deleteAccountModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="deleteAccountModalLabel">¿Está seguro de que desea eliminar su cuenta?</h5>
                                <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <p>Una vez que se elimine su cuenta, todos sus recursos y datos se borrarán permanentemente. Ingrese su contraseña para confirmar que desea eliminar permanentemente su cuenta.</p>
                                
                                <form method="post" action="{{ route('profile.destroy') }}">
                                    @csrf
                                    @method('delete')
                                    
                                    <div class="mb-3">
                                        <label class="small mb-1" for="delete-password">Contraseña</label>
                                        <input class="form-control" id="delete-password" name="password" type="password" placeholder="Ingrese su contraseña" required />
                                    </div>
                                    
                                    <div class="d-flex justify-content-end">
                                        <button class="btn btn-secondary me-2" type="button" data-bs-dismiss="modal">Cancelar</button>
                                        <button class="btn btn-danger" type="submit">Eliminar Cuenta</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection