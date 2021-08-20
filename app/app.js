Vue.component("navbar-container", {
  props: {
    userName: String,
    bizOwner: Boolean,
    currentPage: String,
    url: String,
  },
  //`check for seeker, profile redirect`
  template: `
  <nav class="navbar navbar-expand-lg fixed-top mb-4">
    <a v-if="bizOwner" class="navbar-brand" href="./viewMyGigs.html">
      <img
        src="./images/icon.png"
        width="30"
        height="30"
        class="d-inline-block align-top"
        alt=""
      />
      Gig-E
    </a>
    <a v-else class="navbar-brand" :href="url">
      <img
        src="./images/icon.png"
        width="30"
        height="30"
        class="d-inline-block align-top"
        alt=""
      />
      Gig-E
    </a>

    <button
      class="navbar-toggler"
      type="button"
      data-toggle="collapse"
      data-target="#navbarSupportedContent"
      aria-controls="navbarSupportedContent"
      aria-expanded="false"
      aria-label="Toggle navigation"
    >
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav mr-auto">
        <li  class="nav-item" :class="[currentPage==='searchGig' ? 'active' : '']">
          <a v-if="bizOwner" class="nav-link" href="./searchMusicians.html" >Search Musicians</a>
          <a v-else class="nav-link" href="./searchGigs.html">Search Gigs</a>
        </li>
        <li
          class="nav-item"
          :class="[currentPage==='myGigs' ? 'active' : '']"
        >
          <a class="nav-link" href="./viewMyGigs.html">My Gigs</a>
        </li>
        <li
          class="nav-item"
          v-show="bizOwner"
          :class="[currentPage==='requestGig' ? 'active' : '']"
        >
          <a class="nav-link" href="./requestGig.html">Request Gigs</a>
        </li>
      </ul>

      
      <a v-if="bizOwner" class="navbar-brand" href="./viewMyGigs.html">
        Welcome, {{userName}}
        <img
          src="./images/usr.png"
          width="30"
          height="30"
          class="d-inline-block align-top"
          alt=""
        />
      </a>

      <a v-else class="navbar-brand" :href="url">
        Welcome, {{userName}}
        <img
          src="./images/usr.png"
          width="30"
          height="30"
          class="d-inline-block align-top"
          alt=""
        />
      </a>
      <a href="./logout.html">
        <button  class="btn btn-primary my-2 my-sm-0" type="submit">
          Logout
        </button>
      </a>
    </div>
  </nav>`
  // data() {
  //   return {
  //     url: "./profile.html?bandName=" + localStorage.getItem("bandName"),
  //   };
  // },
});
