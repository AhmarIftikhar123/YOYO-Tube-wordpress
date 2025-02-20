// Self-invoking anonymous function
(function () {
  // Create a class of clock
  class Clock {
    constructor() {
      // Initialize the clock
      this.initializeClock();
    }

    initializeClock() {
      // Set interval to update the clock every second
      setInterval(this.time.bind(this), 1000);
    }

    time() {
      // Get the current date and time
      var date = new Date();
      var hours = date.getHours();
      var minutes = date.getMinutes();
      var seconds = date.getSeconds();
      var ampm = hours >= 12 ? "PM" : "AM";

      // Update the time and AM/PM indicator
      var timeString = hours + ":" + minutes + ":" + seconds;

      // Get the emoji element
      var emojiElement = document.getElementById("time-emoji");

      // Update the emoji based on the time of day
      if (hours >= 5 && hours <= 17) {
        emojiElement.textContent = "☀️";
      } else {
        emojiElement.textContent = "🌕";
      }

      // Update the time and AM/PM indicator
      document.getElementById("time").textContent = timeString;
      document.getElementById("ampm").textContent = ampm;
    }
  }

  // Create a new instance of the Clock class
  new Clock();
})();
