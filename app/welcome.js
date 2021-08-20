function onSignIn(googleUser) {
  // Useful data for your client-side scripts:
  var profile = googleUser.getBasicProfile();
  // console.log("ID: " + profile.getId()); // Don't send this directly to your server!
  // console.log('Full Name: ' + profile.getName());
  // console.log('Given Name: ' + profile.getGivenName());
  // console.log('Family Name: ' + profile.getFamilyName());
  // console.log("Image URL: " + profile.getImageUrl());
  // console.log("Email: " + profile.getEmail());
  checkRegistered(profile.getEmail(), profile);
};

function checkRegistered(username, profile) {
  var url = "../backend/api/users/getUserByUsername.php?username=" + username;
  var request = new XMLHttpRequest();

  request.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      var registered = JSON.parse(this.responseText);
      if (localStorage.getItem('username') == null) {
        redirectUser(registered, profile);
      }
    }
  };

  request.open("GET", url, true);
  request.send();
};

function redirectUser(registered, profile) {
  if (registered.users.length != 0) {
    localStorage.setItem('username', profile.getEmail());
    localStorage.setItem('userType', registered.users[0].type);
    //console.log(registered);
    window.location.href = "/app/viewMyGigs.html";
  }else {
    localStorage.setItem('username', profile.getEmail());
    window.location.href = "/app/register.html";
  }
}

function onLoad() {
  gapi.load('auth2', function() {
    gapi.auth2.init();
  });
}

function signOut() {
  var auth2 = gapi.auth2.getAuthInstance();
  auth2.signOut().then(function () {
      console.log('User signed out.');
  });
  localStorage.clear();
  location.reload();
};