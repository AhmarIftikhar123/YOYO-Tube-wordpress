<?php
/**
 * Template Name: Video Upload Page
 */
get_header();
?>

<div class="container">
    <h2>Upload Your Video</h2>
    
    <form id="yoyo-video-upload-form" enctype="multipart/form-data">
        <input type="file" name="video_file" id="video_file" accept="video/*" required>
        <input type="text" name="video_title" id="video_title" placeholder="Video Title" required>
        <textarea name="video_desc" id="video_desc" placeholder="Video Description" required></textarea>
        <button type="submit">Upload Video</button>
    </form>

    <div id="upload-status"></div>
</div>

<script>

</script>

<?php get_footer(); ?>
