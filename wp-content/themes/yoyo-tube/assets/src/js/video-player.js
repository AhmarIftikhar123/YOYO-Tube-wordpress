import "./comment/comment-form.js";
import jQuery from "jquery";

jQuery(document).ready(($) => {
  const player = $("#custom-video-player");
  const video = player.find("video")[0];
  const playPauseBtn = player.find(".play-pause-btn");
  const seekBar = player.find(".seek-bar");
  const currentTime = player.find(".current-time");
  const duration = player.find(".duration");
  const muteBtn = player.find(".mute-btn");
  const volumeBar = player.find(".volume-bar");
  const fullscreenBtn = player.find(".fullscreen-btn");

  // Add loading spinner
  player.append('<div class="video-loading"><div class="spinner"></div></div>');
  const loadingSpinner = player.find(".video-loading");

  // Wrap controls in a container for better alignment
  const controls = player.find(".video-controls");
  controls.wrapInner('<div class="controls-container"></div>');

  // Add a progress indicator for the seek bar
  seekBar.before('<div class="seek-bar-progress"></div>');
  const seekBarProgress = player.find(".seek-bar-progress");

  // Add a progress indicator for the volume bar
  volumeBar.before('<div class="volume-bar-progress"></div>');
  const volumeBarProgress = player.find(".volume-bar-progress");

  function togglePlayPause() {
    if (video.paused) {
      video.play();
      updatePlayPauseIcon();
    } else {
      video.pause();
      updatePlayPauseIcon();
    }
  }

  function updatePlayPauseIcon() {
    playPauseBtn.html(
      video.paused
        ? '<i class="fas fa-play"></i>'
        : '<i class="fas fa-pause"></i>'
    );
  }

  function updateSeekBar() {
    if (!video.duration) return;

    const value = (100 / video.duration) * video.currentTime;
    seekBar.val(value);

    // Update the progress indicator width
    seekBarProgress.css("width", value + "%");

    currentTime.text(formatTime(video.currentTime));
  }

  function seekVideo() {
    const value = seekBar.val();
    const time = video.duration * (value / 100);
    video.currentTime = time;

    // Update the progress indicator width
    seekBarProgress.css("width", value + "%");
  }

  function formatTime(time) {
    const minutes = Math.floor(time / 60);
    const seconds = Math.floor(time % 60);
    return `${minutes}:${seconds < 10 ? "0" : ""}${seconds}`;
  }

  function toggleMute() {
    video.muted = !video.muted;
    updateVolumeIcon();
    updateVolumeBar();
  }

  function changeVolume() {
    const value = volumeBar.val();
    video.volume = value;
    video.muted = video.volume === 0;
    updateVolumeIcon();
    updateVolumeProgress();
  }

  function updateVolumeBar() {
    const value = video.muted ? 0 : video.volume;
    volumeBar.val(value);
    updateVolumeProgress();
  }

  function updateVolumeProgress() {
    const value = video.muted ? 0 : video.volume;
    volumeBarProgress.css("width", value * 100 + "%");
  }

  function updateVolumeIcon() {
    if (video.muted || video.volume === 0) {
      muteBtn.html('<i class="fas fa-volume-mute"></i>');
    } else if (video.volume < 0.5) {
      muteBtn.html('<i class="fas fa-volume-down"></i>');
    } else {
      muteBtn.html('<i class="fas fa-volume-up"></i>');
    }
  }

  function toggleFullscreen() {
    if (!document.fullscreenElement) {
      if (player[0].requestFullscreen) {
        player[0].requestFullscreen();
      } else if (player[0].mozRequestFullScreen) {
        player[0].mozRequestFullScreen();
      } else if (player[0].webkitRequestFullscreen) {
        player[0].webkitRequestFullscreen();
      } else if (player[0].msRequestFullscreen) {
        player[0].msRequestFullscreen();
      }
      fullscreenBtn.html('<i class="fas fa-compress"></i>');
    } else {
      if (document.exitFullscreen) {
        document.exitFullscreen();
      } else if (document.mozCancelFullScreen) {
        document.mozCancelFullScreen();
      } else if (document.webkitExitFullscreen) {
        document.webkitExitFullscreen();
      } else if (document.msExitFullscreen) {
        document.msExitFullscreen();
      }
      fullscreenBtn.html('<i class="fas fa-expand"></i>');
    }
  }

  function resetPlayer() {
    video.currentTime = 0;
    seekBar.val(0);
    seekBarProgress.css("width", "0%");
    updateSeekBar();
    updatePlayPauseIcon();
  }

  // Event listeners
  playPauseBtn.on("click", togglePlayPause);
  video.addEventListener("timeupdate", updateSeekBar);
  video.addEventListener("ended", resetPlayer);
  seekBar.on("input", seekVideo);
  muteBtn.on("click", toggleMute);
  volumeBar.on("input", changeVolume);
  fullscreenBtn.on("click", toggleFullscreen);

  // Video can also be toggled by clicking on it
  $(video).on("click", togglePlayPause);

  // Hide loading spinner when video is ready
  video.addEventListener("canplay", () => {
    loadingSpinner.fadeOut();
  });

  video.addEventListener("loadedmetadata", () => {
    duration.text(formatTime(video.duration));
    // Initialize volume bar position
    updateVolumeBar();
  });

  // Hide controls when not hovering
  let timeout;
  player.on("mousemove", () => {
    clearTimeout(timeout);
    player.find(".video-controls").css({
      opacity: 1,
      transform: "translateY(0)",
    });

    timeout = setTimeout(() => {
      if (!video.paused) {
        player.find(".video-controls").css({
          opacity: 0,
          transform: "translateY(10px)",
        });
      }
    }, 3000);
  });

  // Initial setup
  updateVolumeIcon();
  updatePlayPauseIcon();
  updateVolumeProgress(); // Initialize volume progress

  // Show controls when video is paused
  video.addEventListener("pause", () => {
    player.find(".video-controls").css({
      opacity: 1,
      transform: "translateY(0)",
    });
  });

  // Handle fullscreen change events
  document.addEventListener("fullscreenchange", adjustFullscreenVideo);
  document.addEventListener("webkitfullscreenchange", adjustFullscreenVideo);
  document.addEventListener("mozfullscreenchange", adjustFullscreenVideo);
  document.addEventListener("MSFullscreenChange", adjustFullscreenVideo);

  function adjustFullscreenVideo() {
    if (document.fullscreenElement) {
      // In fullscreen mode
      $(video).css({
        width: "100%",
        height: "100%",
        "max-height": "100vh",
      });
    } else {
      // Exit fullscreen mode
      $(video).css({
        width: "100%",
        height: "auto",
        "max-height": "80vh",
      });
    }
  }

  // Add keyboard shortcuts
  $(document).on("keydown", (e) => {
    // Only if the video player is in viewport
    if (player.is(":visible")) {
      switch (e.which) {
        case 32: // Space bar
          togglePlayPause();
          e.preventDefault();
          break;
        case 77: // M key
          toggleMute();
          e.preventDefault();
          break;
        case 70: // F key
          toggleFullscreen();
          e.preventDefault();
          break;
        case 37: // Left arrow
          video.currentTime = Math.max(0, video.currentTime - 5);
          e.preventDefault();
          break;
        case 39: // Right arrow
          video.currentTime = Math.min(video.duration, video.currentTime + 5);
          e.preventDefault();
          break;
      }
    }
  });
});
