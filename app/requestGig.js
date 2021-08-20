function checkForm() {

    //MANDATORY
    var username = localStorage.getItem("username"); // change this later
    var title = document.getElementById("title").value;
    var location = document.getElementById("location").value;
    var postalCode = document.getElementById("postalCode").value;
    var date = document.getElementById("date").value;

    if (title == "" || location == "" || date == "" || postalCode == "") {
        alert("Please fill in all fields!");
        return;
    }

    var userType = localStorage.getItem("userType");

    if (userType != "seeker") {
        alert("Wrong userType");
        return;
    }

    //OPTIONAL
    var genre = document.getElementById("genre").value;
    var songList = document.getElementsByClassName("songList");
    var songs = [];
    for (song of songList) {
        songs.push(song.innerText);
    }
    songs = songs.join(",");
    var budget = document.getElementById("budget").value;
    var duration = document.getElementById("duration").value;
    var noMusicians = document.getElementById("noMusicians").value;
    var description = document.getElementById("description").value;
    var image = document.getElementById("image").files;

    if (image.length == 0) {
        image = null;
    }else {
        image = image[0];
    }

    var formData = {      
        "username":username,
        "title":title,
        "location":location,
        "postalCode":postalCode,
        "genre":genre,
        "songs":songs,
        "budget":budget,
        "duration":duration,
        "date":date,
        "noMusicians":noMusicians,
        "image":image,
        "description":description
    };

    sendData(formData);
}

function sendData(formData) {
    var params = new FormData();
    var name;

    // Put loading animation
    document.getElementById("submitButton").classList.add("loader");
    // Turn the data object into an array of URL-encoded key/value pairs.
    for( name in formData ) {
        if (name == "image") {
            params.append(name, formData[name]);
        } else {
            params.append(name, formData[name]);
        }
        // console.log(name);
        // console.log(encodeURIComponent( formData[name] ));
    }
    console.log(formData);
    console.log(params);
    // // Combine the pairs into a single string and replace all %-encoded spaces to 
    // // the '+' character; matches the behaviour of browser form submissions.
    // urlEncodedData = urlEncodedDataPairs.join( '&' ).replace( /%20/g, '+' );

    // set api settings
    var url = "../backend/api/gigs/createGig.php";
    axios.post(url, params , {headers: {
        'Content-Type': 'multipart/form-data'
      }})
    .then(response => { 
        console.log(response.data);
        // to redirect to gigId (should change how i do this)
        axios.get("../backend/api/gigs/searchGigByTitle.php?title="+encodeURIComponent(formData.title))
        .then(response => {
            var gigId = response.data.gigs[0].gigId;
            window.location.href = "/app/gigInfo.html?gigId=" + gigId;
        })
        .catch(error => {
            console.log('There was an error: ' + error.message );
        });
    })
    .catch(error => {
        console.log('There was an error: ' + error.message );
    });
}

function addSong() {
    var song = document.getElementById("songs").value;
    document.getElementById("songs").value = "";
    if (song.trim() == "") {
        return;
    }

    var songList = document.getElementById("songList");

    var newSong = document.createElement("li");
    newSong.className = "list-group-item songList";
    newSong.innerText = song;

    songList.append(newSong);
}