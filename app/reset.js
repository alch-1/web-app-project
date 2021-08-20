function onLoad() {
    gapi.load('auth2', function() {
        gapi.auth2.init();
    });
}

function signOut() {
    var auth2 = gapi.auth2.getAuthInstance();
    auth2.signOut().then(function () {
        console.log('User signed out.');
        localStorage.clear();
        window.location.href = "/app/home.html";
    }).catch(error => {
        console.log('There was an error: ' + error.message );
    });
}

function reset() {
    document.getElementById("resetBtn").innerText = "Please wait...";
    axios.post("../backend/include/reset.php")
    .then(response => {
        console.log(response);
        signOut();
    })
    .catch(error => {
        console.log('There was an error: ' + error.message );
    });
}
