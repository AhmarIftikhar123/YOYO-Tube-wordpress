<?php
/**
 * Template Name: Contact Us
 *
 * @package YOYO-Tube
 */

get_header();
?>

<div class="contact-page-container">
    <div class="contact-header">
        <h1 class="contact-title">Contact Us</h1>
        <div class="contact-subtitle">We'd love to hear from you</div>
    </div>

    <div class="contact-content">
        <div class="contact-info-container">
            <div class="platform-info">
                <h2>About YOYO-Tube</h2>
                <p>YOYO-Tube is a cutting-edge video sharing platform designed for creators who want complete control over their content. Our platform offers seamless video uploads, monetization options, and an engaging community experience.</p>
                
                <p>Built with the latest web technologies, YOYO-Tube provides a secure, fast, and user-friendly environment for both content creators and viewers. Whether you're sharing educational content, entertainment, or professional videos, our platform is designed to showcase your work in the best possible way.</p>
                
                <div class="platform-features">
                    <div class="feature">
                        <i class="fas fa-upload"></i>
                        <h3>Easy Uploads</h3>
                        <p>Simple drag-and-drop interface for quick video uploads</p>
                    </div>
                    <div class="feature">
                        <i class="fas fa-dollar-sign"></i>
                        <h3>Monetization</h3>
                        <p>Multiple options to earn from your content</p>
                    </div>
                    <div class="feature">
                        <i class="fas fa-shield-alt"></i>
                        <h3>Content Protection</h3>
                        <p>Advanced security to protect your intellectual property</p>
                    </div>
                </div>
            </div>
            
            <div class="creator-info">
                <h2>Meet the Creator</h2>
                <div class="creator-profile">
                    <div class="creator-image">
                        <?php 
                        // If you have a profile image, use this
                        // echo '<img src="' . esc_url(get_template_directory_uri() . '/assets/images/ahmar-profile.jpg') . '" alt="Ahmar Iftikhar Butt">';
                        // Otherwise use a placeholder with initials
                        echo '<div class="creator-initials">AIB</div>';
                        ?>
                    </div>
                    <div class="creator-details">
                        <h3>Ahmar Iftikhar Butt</h3>
                        <p class="creator-title">Founder & Lead Developer</p>
                        <p class="creator-bio">I'm a passionate web developer and entrepreneur with a vision to create a better video sharing experience. With over 10 years of experience in web development and digital media, I founded YOYO-Tube to provide creators with a platform that truly values their work.</p>
                        <p class="creator-bio">My background in full-stack development, UX design, and digital marketing has helped shape YOYO-Tube into a platform that balances technical excellence with user-friendly design.</p>
                        
                        <div class="creator-social">
                            <a href="#" class="social-link"><i class="fab fa-linkedin"></i></a>
                            <a href="#" class="social-link"><i class="fab fa-twitter"></i></a>
                            <a href="#" class="social-link"><i class="fab fa-github"></i></a>
                            <a href="#" class="social-link"><i class="fab fa-instagram"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="contact-form-container">
            <h2>Get In Touch</h2>
            <p class="contact-intro">Have questions, suggestions, or feedback? Fill out the form below and we'll get back to you as soon as possible.</p>
            
            <form id="contact-form" class="contact-form">
                <?php wp_nonce_field('contact_form_submit', 'contact_nonce'); ?>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="contact-name">Your Name <span class="required">*</span></label>
                        <input type="text" id="contact-name" name="contact_name" class="form-control" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="contact-email">Email Address <span class="required">*</span></label>
                        <input type="email" id="contact-email" name="contact_email" class="form-control" required>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="contact-subject">Subject <span class="required">*</span></label>
                    <input type="text" id="contact-subject" name="contact_subject" class="form-control" required>
                </div>
                
                <div class="form-group">
                    <label for="contact-message">Message <span class="required">*</span></label>
                    <textarea id="contact-message" name="contact_message" class="form-control" rows="6" required></textarea>
                </div>
                
                <div class="form-group form-checkbox">
                    <input type="checkbox" id="contact-consent" name="contact_consent" required>
                    <label for="contact-consent">I consent to having this website store my submitted information so they can respond to my inquiry.</label>
                </div>
                
                <div class="form-submit">
                    <button type="submit" class="submit-button">
                        <span class="button-text">Send Message</span>
                        <i class="fas fa-paper-plane"></i>
                    </button>
                </div>
                
                <div id="form-response" class="form-response"></div>
            </form>
        </div>
    </div>
    
    <div class="contact-additional">
        <div class="contact-methods">
            <div class="contact-method">
                <div class="method-icon">
                    <i class="fas fa-envelope"></i>
                </div>
                <h3>Email Us</h3>
                <p><a href="mailto:contact@yoyotube.com">contact@yoyotube.com</a></p>
            </div>
            
            <div class="contact-method">
                <div class="method-icon">
                    <i class="fas fa-phone-alt"></i>
                </div>
                <h3>Call Us</h3>
                <p><a href="tel:+1234567890">+1 (234) 567-890</a></p>
            </div>
            
            <div class="contact-method">
                <div class="method-icon">
                    <i class="fas fa-map-marker-alt"></i>
                </div>
                <h3>Visit Us</h3>
                <p>123 Tech Street, Digital City<br>Innovation State, 54321</p>
            </div>
        </div>
        
        <div class="contact-map">
            <!-- You can replace this with an actual Google Maps embed -->
            <div class="map-placeholder">
                <i class="fas fa-map"></i>
                <p>Interactive Map Coming Soon</p>
            </div>
        </div>
    </div>
    
    <div class="contact-faq">
        <h2>Frequently Asked Questions</h2>
        <div class="faq-container">
            <div class="faq-item">
                <div class="faq-question">
                    <h3>How do I upload videos to YOYO-Tube?</h3>
                    <i class="fas fa-chevron-down"></i>
                </div>
                <div class="faq-answer">
                    <p>Uploading videos is simple! Just log in to your account, click on the "Upload" button in the navigation bar, and follow the prompts. You can drag and drop your video file or select it from your device.</p>
                </div>
            </div>
            
            <div class="faq-item">
                <div class="faq-question">
                    <h3>How can I monetize my content?</h3>
                    <i class="fas fa-chevron-down"></i>
                </div>
                <div class="faq-answer">
                    <p>YOYO-Tube offers several monetization options including premium content (pay-per-view), channel subscriptions, and ad revenue sharing. To enable monetization, go to your account settings and select "Monetization Options".</p>
                </div>
            </div>
            
            <div class="faq-item">
                <div class="faq-question">
                    <h3>What video formats are supported?</h3>
                    <i class="fas fa-chevron-down"></i>
                </div>
                <div class="faq-answer">
                    <p>YOYO-Tube supports most popular video formats including MP4, MOV, AVI, and WebM. For optimal performance, we recommend uploading MP4 files with H.264 encoding.</p>
                </div>
            </div>
            
            <div class="faq-item">
                <div class="faq-question">
                    <h3>How do I report inappropriate content?</h3>
                    <i class="fas fa-chevron-down"></i>
                </div>
                <div class="faq-answer">
                    <p>If you encounter content that violates our community guidelines, click the "Report" button below the video. Our moderation team will review the report and take appropriate action.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<?php get_footer(); ?>

