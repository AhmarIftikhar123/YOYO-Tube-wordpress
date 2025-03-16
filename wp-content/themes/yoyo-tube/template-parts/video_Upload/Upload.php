<?php
/**
 * Template Name: Video Upload Page
 */
get_header();
?>

<div class="yoyo-upload-container">
    <h1 class="yoyo-upload-title">UPLOAD</h1>

    <form id="yoyo-video-upload-form" enctype="multipart/form-data">
        <!-- Drag & Drop Zone -->
        <div id="drag-drop-area" class="drag-drop-zone">
            <div class="drag-drop-content">
                <span class="dashicons dashicons-cloud-upload upload-icon"></span>
                <p>Drag and drop your video file here or <span class="browse-text">Browse</span></p>
            </div>
            <input type="file" id="yoyo-video-file" name="video_file" accept="video/mp4,video/mkv,video/avi" required
                class="file-input">
        </div>

        <!-- Form Fields -->
        <div class="form-group">
            <label for="yoyo-video-title">Title</label>
            <input type="text" id="yoyo-video-title" name="video_title" placeholder="Enter video title" required>
        </div>

        <div class="form-group">
            <label for="yoyo-video-description">Description</label>
            <textarea id="yoyo-video-description" name="video_description" placeholder="Enter video description"
                rows="4"></textarea>
        </div>

        <div class="form-fields-row">
            <div class="form-group half">
                <label for="yoyo-video-tags">Tags</label>
                <input type="text" id="yoyo-video-tags" name="video_tags"
                    placeholder="Enter At least 3 tags separated by comma">
            </div>

            <div class="form-group half">
                <label for="yoyo-video-category">Category</label>
                <input type="text" id="yoyo-video-category" name="video_category" placeholder="Enter category">
            </div>
        </div>

        <div class="form-group checkbox">
            <label class="d-flex gap-2">
                <input type="checkbox" name="is_paid" id="yoyo-video-paid">
                Make this content Paid (Default is Free)
            </label>
        </div>

        <div class="form-group" id="price-input-group" style="display: none;">
            <label for="yoyo-video-price">Price ($)</label>
            <div class="price-input-wrapper">
                <span class="dollar-sign">$</span>
                <input type="number" id="yoyo-video-price" name="video_price" min="0" step="0.01" placeholder="0.00">
            </div>
        </div>

        <input type="hidden" name="action" value="yoyo_upload_video">
        <input type="hidden" name="security" value="<?php echo wp_create_nonce('yoyo-video-upload'); ?>">

        <button type="submit" class="upload-btn btn-primary">Upload Video</button>
    </form>

    <div id="upload-progress" class="progress-bar" style="display: none;">
        <div class="progress"></div>
    </div>

    <div id="yoyo-video-message"></div>
</div>

<?php get_footer(); ?>