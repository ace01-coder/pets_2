
  // Set the session timeout to 30 minutes
  var timeout = 1 * 60 * 1000; // 30 minutes in milliseconds

  // Set a timer to check for inactivity
  setInterval(function() {
      // Check if the user is still active
      if (new Date().getTime() - lastActivity > timeout) {
          // User is inactive, log out
          window.location.href = "index.php";
      }
  }, 1000); // Check every second

  // Update the last activity time
  var lastActivity = new Date().getTime();

  // Update the last activity time on user activity
  document.addEventListener("mousemove", function() {
      lastActivity = new Date().getTime();
  });

  document.addEventListener("keydown", function() {
      lastActivity = new Date().getTime();
  });


// Function to display notification
function displayNotification() {
    // Create a notification box
    var notificationBox = document.createElement("div");
    notificationBox.innerHTML = "You have been inactive for 30 minutes. You will be logged out in 1 minute.";
    notificationBox.style.position = "fixed";
    notificationBox.style.top = "50%";
    notificationBox.style.left = "50%";
    notificationBox.style.transform = "translate(-50%, -50%)";
    notificationBox.style.background = "white";
    notificationBox.style.padding = "20px";
    notificationBox.style.border = "1px solid black";
    notificationBox.style.borderRadius = "10px";
    notificationBox.style.boxShadow = "0 0 10px rgba(0, 0, 0, 0.5)";
    notificationBox.style.zIndex = "1000";

    // Create a logout button
    var logoutButton = document.createElement("button");
    logoutButton.innerHTML = "Log out";
    logoutButton.style.background = "red";
    logoutButton.style.color = "white";
    logoutButton.style.padding = "10px 20px";
    logoutButton.style.border = "none";
    logoutButton.style.borderRadius = "10px";
    logoutButton.style.cursor = "pointer";

    // Add event listener to logout button
    logoutButton.addEventListener("click", function() {
        window.location.href = "login.php";
    });

    // Add notification box and logout button to the page
    document.body.appendChild(notificationBox);
    notificationBox.appendChild(logoutButton);

    // Set a timer to log out the user after 1 minute
    setTimeout(function() {
        window.location.href = "login.php";
    }, 60000); // 1 minute in milliseconds
}