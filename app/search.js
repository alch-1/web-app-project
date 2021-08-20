var search = new Vue({
  el: "#app",
  data: {
    gigs: getGig(this),
    bands: getBand(this),
  },
  methods: {
    getGig: function (title) {
      var http = new XMLHttpRequest();
      var url =
        "../backend/api/gigs/searchGigByTitle.php?title=" +
        encodeURIComponent(title);
      http.open("GET", url);
      http.send();

      http.onreadystatechange = function () {
        if (http.readyState === 4 && http.status === 200) {
          var obj = JSON.parse(http.responseText);
          console.log(obj);
          return;

          // budget: "100.20"
          // confirmedApplicant: null
          // date: "2020-10-28"
          // description: "Help me find people for my first gig!"
          // duration: "2.00"
          // genre: "Pop"
          // gigId: "1"
          // image: "gig.jpg"
          // location: "My home"
          // noMusicians: "1"
          // songs: "All of them"
          // status: "pending"
          // title: "My first gig"
          // username: "seeker1"
        }
      };
    },
    getBand: function (bandName) {
      var http = new XMLHttpRequest();
      var url =
        "../backend/api/band/searchBandsByName.php?bandName=" +
        encodeURIComponent(bandName);
      http.open("GET", url);
      http.send();

      http.onreadystatechange = function () {
        if (http.readyState === 4 && http.status === 200) {
          var obj = JSON.parse(http.responseText);
          console.log(obj);
          return;

          // "username": "musician3",
          // "bandName": "Justin Timberpool",
          // "genre": "Pop",
          // "bandType": "solo",
          // "website": "http://www.google.com/",
          // "summary": "Voluptatem et est impedit aliquid. Veniam deleniti sunt laborum non est nisi sit. Non fugiat nam quia necessitatibus et aut."
        }
      };
    },
  },
});

var asd = new Vue({
  el: "#app2",
  data: {
    bands: getAllBands(),
    gigs: getAllGigs(),
    test: "This is working",
  },
  methods: {
    getAllBands: function () {
      const http = new XMLHttpRequest();
      const url = "../backend/api/band/getAllBands.php";
      http.open("GET", url);
      http.send();

      http.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
          var obj = JSON.parse(http.responseText);
          console.log(obj);
          return;
        }
      };
    },
    getAllGigs: function () {
      const http = new XMLHttpRequest();
      const url = "../backend/api/gigs/getAllGigs.php";
      http.open("GET", url);
      http.send();

      http.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
          var obj = JSON.parse(http.responseText);
          console.log(obj);
          return;
        }
      };
    },
  },
});
