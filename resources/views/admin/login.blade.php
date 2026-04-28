@extends('layouts.frontend', ['title' => 'Admin Login'])

@section('page-content')
<main id="page" class="admin-login-page" role="main">
    <article class="sections" id="sections">
        <section class="admin-login-section">
            <div class="admin-login-card">
                <div class="admin-login-header">
                    <div class="admin-login-icon">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    <h2>Admin Portal</h2>
                    <p>Secure access to your dashboard</p>
                </div>

                <form id="adminLoginForm" class="admin-login-form">
                    @csrf

                    <div class="admin-input-group">
                        <label for="email">
                            <i class="fas fa-envelope"></i>
                            Email Address
                        </label>
                        <div class="admin-input-wrapper">
                            <input type="email" name="email" id="email" required autocomplete="email">
                        </div>
                    </div>

                    <div class="admin-input-group">
                        <label for="password">
                            <i class="fas fa-lock"></i>
                            Password
                        </label>
                        <div class="admin-input-wrapper password-wrapper">
                            <input type="password" name="password" id="password" required autocomplete="current-password">
                            <button type="button" class="toggle-password-btn" id="togglePassword" aria-label="Toggle password visibility">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>

                    <button type="submit" class="admin-login-btn" id="loginBtn">
                        <span class="btn-text">Sign In</span>
                        <span class="btn-loader">
                            <i class="fas fa-spinner fa-spin"></i>
                        </span>
                    </button>

                    <div id="loginMessage" class="admin-login-message"></div>
                </form>

                <div class="admin-login-footer">
                    <p>Protected by <i class="fas fa-heart"></i> Priceless Beauty Touch</p>
                </div>
            </div>
        </section>
    </article>
</main>
@endsection