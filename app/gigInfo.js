// function timeDifference(current, previous) {
//     var msPerMinute = 60 * 1000;
//     var msPerHour = msPerMinute * 60;
//     var msPerDay = msPerHour * 24;
//     var msPerMonth = msPerDay * 30;
//     var msPerYear = msPerDay * 365;

//     var elapsed = current - previous;

//     if (elapsed < msPerMinute) {
//         return Math.round(elapsed / 1000) + " seconds ago";
//     } else if (elapsed < msPerHour) {
//         return Math.round(elapsed / msPerMinute) + " minutes ago";
//     } else if (elapsed < msPerDay) {
//         return Math.round(elapsed / msPerHour) + " hours ago";
//     } else if (elapsed < msPerMonth) {
//         return "approximately " + Math.round(elapsed / msPerDay) + " days ago";
//     } else if (elapsed < msPerYear) {
//         return "approximately " + Math.round(elapsed / msPerMonth) + " months ago";
//     } else {
//         return "approximately " + Math.round(elapsed / msPerYear) + " years ago";
//     }
// }

function call_api(my_gigid) {
  // Step 1
  var request = new XMLHttpRequest();
  // Step 2
  request.onreadystatechange = function () {
    // Step 5
    if (request.readyState == 4 && request.status == 200) {
      // Response is ready
      var json_obj = JSON.parse(request.responseText);
      var gigObj = json_obj.gig;
      console.log(gigObj);
      var songs = gigObj.songs. split(',')
      console.log(songs);
      ul = "<ol>"
      songs.forEach(element => {
        ul += `<li>${element}</li>`
      });
      ul += "</ol>";
      document.querySelector("#songs").innerHTML = ul;
      var datetime = gigObj.date.split(" ");
      var timeOnly = datetime[0].split("-");
      var d = new Date(timeOnly[0], timeOnly[1] - 1, timeOnly[2]);
      var time = datetime[1].split(":");
      var display_time =
        time[0] < 12
          ? `${time[0]}.${time[1]} am`
          : `${parseInt(time[0]) - 12}.${time[1]} pm`;
      var postCode = gigObj.postalCode;
      postCode = postCode.replace(/^S/, "");
      var location = `${gigObj.location}, ${postCode}`;
      if (gigObj.image != null) {
        document.querySelector("#image").src = gigObj.image;
      }
      document.querySelector("#gigDescription").textContent =
        gigObj.description;
      document.querySelector(
        "#date"
      ).textContent = `${d.toDateString()} ${display_time}`;
      // document.querySelector("#from").textContent = display_time;
      document.querySelector("#location").textContent = location;
      document.querySelector("#genre").textContent = gigObj.genre;
      document.querySelector("#musicians").textContent = gigObj.noMusicians;
      document.querySelector("#title").textContent = gigObj.title;
      document.querySelector("#pay").textContent = `$${gigObj.budget}`;
      var splitted = gigObj.duration.split(".");
      var min = 0;
      if (splitted[1] != "00") {
        min = (parseInt(splitted[1]) / 100) * 60;
      }
      var hour = splitted[0];
      document.querySelector("#duration").textContent =
        min == 0 ? ` ${hour} Hours` : `${hour} Hours ${min} Mins `;
    }else if (request.readyState == 4 && request.status == 404){
      (document.querySelector("body")).innerHTML = "<div id='redirect'><h1> Oops, you're searching for an invalid gig <br> Redirecting you now... </h1><div>";
      if (localStorage.getItem("userType") == "seeker"){
        setTimeout(function () {
          window.location = "searchMusicians.html";
        }, 3000);
      }
      else{
          setTimeout(function () {
            window.location = "searchGigs.html";
          }, 3000);
      }

    }
  };
  // Step 3
  var final_url =
    // "http://localhost/proj/gig-e/backend/api/gigs/getGig.php?gigId=" +
    // encodeURIComponent(my_gigid);
    "../backend/api/gigs/getGig.php?gigId=" + encodeURIComponent(my_gigid);
  request.open("GET", final_url, false);
  // Step 4
  request.send();
}

// code for Google Maps
var map, infoWindow;

function initMap() {
  var location = document.querySelector("#location").textContent;
  // console.log(location);
  infoWindow = new google.maps.InfoWindow();
  if (navigator.geolocation) {
    map = new google.maps.Map(document.getElementById("map"), {
      center: {
        lat: 1.2983886999999998,
        lng: 103.85641989999999,
      }, //placeholder values
      zoom: 16,
    });
  } else {
    // error handling
    // Browser doesn't support Geolocation
    handleLocationError(false, infoWindow, map.getCenter());
  }

  geocoder = new google.maps.Geocoder();
  geocoder.geocode(
    {
      address: location,
    },
    function (results, status) {
      if (status == "OK") {
        map.setCenter(results[0].geometry.location);
        var marker = new google.maps.Marker({
          map: map,
          position: results[0].geometry.location,
        });
      } else {
          // alert("Geocode was not successful for the following reason: " + status);
      }
    }
  );
}


function deleteGig(gig_id) {
  // set api settings
  var formData = {
    "gigId": gig_id,
  };

  var params = new FormData();
  var name;

  // Turn the data object into an array of URL-encoded key/value pairs.
  for (name in formData) {
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
  var url = "../backend/api/gigs/deleteGig.php";
  axios
    .post(url, params, {
      headers: {
        "Content-Type": "multipart/form-data",
      },
    })
    .then((response) => {
      if (response.status == 200) {
        document.querySelector("#application-status").textContent =
          "Your Gig was Deleted!";
        document.querySelector("#exampleModalLabel").textContent =
          "Gig deletion outcome";
      } else {
        document.querySelector("#application-status").textContent =
          "Something went wrong";
      }
    })
    .catch((error) => {
      console.log("There was an error: " + error.message);
    });
}

function removeLoader() {
  $("#loadingDiv").remove(); //makes page more lightweight
}

function checkForm(gig_id, username) {
  var formData = {
    "username": username,
    "gigId": gig_id,
  };

  sendData(formData);
}

function sendData(formData){
  var params = new FormData();
  var name;

  // Turn the data object into an array of URL-encoded key/value pairs.
  for (name in formData) {
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
  var url = "../backend/api/applicants/createApplicant.php";
  axios
    .post(url, params, {
      headers: {
        "Content-Type": "multipart/form-data",
      },
    })
    .then((response) => {
        if (response.status == 200){
          (document.querySelector("#application-status").textContent ="Your Application was sent!");
          (document.querySelector("#exampleModalLabel").textContent ="Application Outcome");
        }else{
          (document.querySelector("#application-status").textContent ="Something went wrong");
        }

    })
    .catch((error) => {
      console.log("There was an error: " + error.message);
    });
}

// function sendData(formData) {
//   let urlEncodedData = "",
//     urlEncodedDataPairs = [],
//     name;
//   // console.log(formData);
//   // Turn the data object into an array of URL-encoded key/value pairs.
//   for (name in formData) {
//     urlEncodedDataPairs.push(
//       (name) + "=" + (formData[name])
//     );
//   }

//   // Combine the pairs into a single string and replace all %-encoded spaces to
//   // the '+' character; matches the behaviour of browser form submissions.
//   urlEncodedData = urlEncodedDataPairs;

//   // set api settings
//   var url = "../backend/api/applicants/createApplicant.php";
//   var request = new XMLHttpRequest();
//   request.onreadystatechange = function () {
//     if (this.readyState == 4 && this.status == 200) {
//       if (JSON.parse(this.status) == 200){
//         (document.querySelector("#application-status").textContent ="Your Application was sent!");
//         (document.querySelector("#exampleModalLabel").textContent ="Application Outcome");
//       }else{
//         (document.querySelector("#application-status").textContent ="Something went wrong");
//       }
//     }
//   };

//   request.open("POST", url, true);
//   request.setRequestHeader("Content-Type", "multipart/form-data");
//   request.send(urlEncodedData);
// }
