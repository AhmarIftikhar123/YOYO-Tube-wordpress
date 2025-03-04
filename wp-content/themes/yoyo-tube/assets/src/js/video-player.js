jQuery(document).ready(function ($) {
  const player = $("#custom-video-player");
  const video = player.find("video")[0];
  const playPauseBtn = player.find(".play-pause-btn");
  const seekBar = player.find(".seek-bar");
  const currentTime = player.find(".current-time");
  const duration = player.find(".duration");
  const muteBtn = player.find(".mute-btn");
  const volumeBar = player.find(".volume-bar");
  const fullscreenBtn = player.find(".fullscreen-btn");

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
    const value = (100 / video.duration) * video.currentTime;
    seekBar.val(value);
    currentTime.text(formatTime(video.currentTime));
  }

  function seekVideo() {
    const time = video.duration * (seekBar.val() / 100);
    video.currentTime = time;
  }

  function formatTime(time) {
    const minutes = Math.floor(time / 60);
    const seconds = Math.floor(time % 60);
    return `${minutes}:${seconds < 10 ? "0" : ""}${seconds}`;
  }

  function toggleMute() {
    video.muted = !video.muted;
    updateVolumeIcon();
  }

  function changeVolume() {
    video.volume = volumeBar.val();
    video.muted = video.volume === 0;
    updateVolumeIcon();
  }

  function updateVolumeIcon() {
    muteBtn.html(
      video.muted || video.volume === 0
        ? '<i class="fas fa-volume-mute"></i>'
        : '<i class="fas fa-volume-up"></i>'
    );
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

  video.addEventListener("loadedmetadata", function () {
    duration.text(formatTime(video.duration));
  });

  // Hide controls when not hovering
  let timeout;
  player.on("mousemove", function () {
    clearTimeout(timeout);
    player.find(".video-controls").css("opacity", 1);
    timeout = setTimeout(function () {
      if (!video.paused) {
        player.find(".video-controls").css("opacity", 0);
      }
    }, 3000);
  });

  // Initial setup
  updateVolumeIcon();
  updatePlayPauseIcon();
});
