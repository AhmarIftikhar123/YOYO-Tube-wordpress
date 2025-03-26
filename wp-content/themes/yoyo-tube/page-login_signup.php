<?php
/*
Template Name: Login/Signup Page
*/
get_header();
?>

<?php if (is_user_logged_in()): ?>
    <?php get_template_part('template-parts/redirect/redirect'); ?>

<?php else: ?>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="login-signup-container">
                    <ul class="nav ms-0 nav-tabs d-flex justify-content-between px-4" id="authTabs" role="tablist">
                        <li class="nav-item px-5" role="presentation">
                            <button class="nav-link active" id="login-tab" data-bs-toggle="tab" data-bs-target="#login"
                                type="button" role="tab" aria-controls="login" aria-selected="true">Login</button>
                        </li>
                        <li class="nav-item px-5" role="presentation">
                            <button class="nav-link" id="signup-tab" data-bs-toggle="tab" data-bs-target="#signup"
                                type="button" role="tab" aria-controls="signup" aria-selected="false">Sign Up</button>
                        </li>
                    </ul>
                    <div class="tab-content" id="authTabContent">
                        <div class="tab-pane fade show active" id="login" role="tabpanel" aria-labelledby="login-tab">
                            <form id="login-form">
                                <div class="mb-3">
                                    <label for="login-username" class="form-label">Username or Email</label>
                                    <input type="text" class="form-control" id="login-username" required>
                                </div>
                                <div class="mb-3">
                                    <label for="login-password" class="form-label">Password</label>
                                    <input type="password" class="form-control" id="login-password" required>
                                </div>
                                <div class="mb-3 form-check">
                                    <input type="checkbox" class="form-check-input" id="login-remember">
                                    <label class="form-check-label" for="login-remember">Remember me</label>
                                </div>
                                <button type="submit" class="btn btn-primary w-100">Login</button>

                                <div class="social-login-divider text-center my-2">
                                    <span>OR</span>
                                </div>

                                <div class="social-login-buttons">
                                    <a href="<?php echo esc_url(site_url('/wp-login.php?loginSocial=google')); ?>"
                                        class="btn btn-primary btn-google d-block text-center text-decoration-none d-flex gap-2 align-items-center justify-content-center" data-plugin="nsl" data-action="connect"
                                        data-redirect="current" data-provider="google" data-popupwidth="600"
                                        data-popupheight="600">
                                        <i class="fab fa-google"></i> Continue with Google
                                    </a>
                                </div>
                            </form>
                        </div>
                        <div class="tab-pane fade" id="signup" role="tabpanel" aria-labelledby="signup-tab">
                            <form id="signup-form">
                                <div class="mb-3">
                                    <label for="signup-username" class="form-label">Username</label>
                                    <input type="text" class="form-control" id="signup-username" required>
                                </div>
                                <div class="mb-3">
                                    <label for="signup-email" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="signup-email" required>
                                </div>
                                <div class="mb-3">
                                    <label for="signup-password" class="form-label">Password</label>
                                    <input type="password" class="form-control" id="signup-password" required>
                                </div>
                                <div class="mb-3">
                                    <label for="signup-confirm-password" class="form-label">Confirm Password</label>
                                    <input type="password" class="form-control" id="signup-confirm-password" required>
                                </div>
                                <div class="mb-3">
                                    <label for="signup-role" class="form-label">Role</label>
                                    <select class="form-select" id="signup-role" required>
                                        <option value="author">Author</option>
                                        <option value="subscriber">Subscriber</option>
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-primary w-100">Sign Up</button>

                                <div class="social-login-divider text-center my-2">
                                    <span>OR</span>
                                </div>

                                <div class="social-login-buttons">
                                    <a href="<?php echo esc_url(site_url('/wp-login.php?loginSocial=google')); ?>"
                                        class="btn btn-primary btn-google d-block text-center text d-flex gap-2 align-items-center justify-content-center selection:decoration-none" data-plugin="nsl" data-action="connect"
                                        data-redirect="current" data-provider="google" data-popupwidth="600"
                                        data-popupheight="600">
                                        <i class="fab fa-google"></i> Sign Up with Google
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>
<?php get_footer(); ?>