/**
 * Script to handle comment form and ensure video_id is included
 */
jQuery(document).ready(($) => {
          // Get video_id from URL or data attribute
          let videoId = ""
        
          // Try to get from data container
          const videoIdContainer = $("#yoyo-video-id-container")
          if (videoIdContainer.length) {
            videoId = videoIdContainer.data("video-id")
          }
        
          // If not found, try to get from URL
          if (!videoId) {
            const urlParams = new URLSearchParams(window.location.search)
            videoId = urlParams.get("video_id")
          }
        
          // If we have a video_id, ensure it's in the comment form
          if (videoId) {
            console.log("Found video ID:", videoId)
        
            // Function to add the hidden field
            function addVideoIdField() {
              // Check if the hidden field already exists
              if ($('#commentform input[name="yoyo_video_id"]').length === 0) {
                console.log("Adding video_id field to form")
                // Add hidden field to comment form
                $("#commentform").append('<input type="hidden" name="yoyo_video_id" value="' + videoId + '">')
              }
            }
        
            // Add field immediately
            addVideoIdField()
        
            // Also add when form is modified (for reply forms)
            $(document).on("click", ".comment-reply-link", () => {
              // Wait for the form to be moved
              setTimeout(addVideoIdField, 100)
            })
        
            // Add field when cancel reply is clicked (form moves back)
            $(document).on("click", "#cancel-comment-reply-link", () => {
              // Wait for the form to be moved back
              setTimeout(addVideoIdField, 100)
            })
        
            // Monitor DOM changes to catch dynamically loaded forms
            if (typeof MutationObserver !== "undefined") {
              const observer = new MutationObserver((mutations) => {
                mutations.forEach((mutation) => {
                  if (mutation.type === "childList" && mutation.addedNodes.length) {
                    // Check if the comment form was added or modified
                    if ($("#commentform").length) {
                      addVideoIdField()
                    }
                  }
                })
              })
        
              // Start observing the document body for changes
              observer.observe(document.body, { childList: true, subtree: true })
            }
          }
        })
        
        