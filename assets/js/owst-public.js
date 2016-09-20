/* eslint-env browser */
/* global cinemaLocations, ipLatitude, ipLongitude */
/* eslint no-cond-assign: 0 */

if (document.loaded) {
  owstInit()
} else {
  if (window.addEventListener) {
    window.addEventListener('load', owstInit(), false);
  } else {
    window.attachEvent('onload', owstInit());
  }
}

function owstInit () {
  owstDateSelector()
  findShowtimesForm()
  printShowtimes()

  var my_theatre = null;

  if (typeof(Storage) !== "undefined" && !isInternetExplorer()) {
    my_theatre = localStorage.getItem('my_theatre');
  } else {
    my_theatre = getCookie('my_theatre');
  }

  var sel = document.getElementById('select-a-theatre');

  if (my_theatre) {
    if (sel) {
      var opts = sel.options;

      for (var opt, j = 0; opt = opts[j]; j++) {
        if (opt.dataset.code == my_theatre) {
          sel.selectedIndex = j;
          findShowtimesForm.action = 'theatres/' + opt.value;
          break;
        }
      }
    }
  } else {
    window.onload = getLocation;
  }

  function degToRad(degrees) {
    var radians = (degrees * Math.PI) / 180;

    return radians;
  }

  function getLocation() {
    if (navigator.geolocation) {
      navigator.geolocation.getCurrentPosition(displayMyLocation, displayError);
    } else {
      var position = {
        coords: {
          latitude: ipLatitude,
          longitude: ipLongitude
        }
      };
      displayMyLocation(position);
    }
  }

  function computeDistance(startCoords, destCoords) {
    var startLatRads = degToRad(startCoords.latitude);
    var startLongRads = degToRad(startCoords.longitude);
    var destLatRads = degToRad(destCoords.latitude);
    var destLongRads = degToRad(destCoords.longitude);
    var Radius = 6371;

    var distance = Math.acos(Math.sin(startLatRads) * Math.sin(destLatRads) +
      Math.cos(startLatRads) * Math.cos(destLatRads) *
      Math.cos(startLongRads - destLongRads)) * Radius;

    return distance;
  }

  function displayMyLocation(position) {
    var distances = [];

    cinemaLocations.forEach(function(value) {
      var distance = computeDistance(position.coords, value);
      var roundedDistance = Math.round(distance);

      distances.push(roundedDistance);
    });

    var closestTheatre = indexOfSmallest(distances);

    var myTheatre = cinemaLocations[closestTheatre].code;

    if (typeof(Storage) !== "undefined" && !isInternetExplorer()) {
      localStorage.setItem('my_theatre', myTheatre);
    } else {
      setCookie('my_theatre', myTheatre);
    }

    var val = cinemaLocations[closestTheatre].code;
    var sel = document.getElementById('select-a-theatre');
    if (sel) {
      var opts = sel.options;
      for (var opt, j = 0; opt = opts[j]; j++) {
        if (opt.dataset.code == val) {
          sel.selectedIndex = j;
          findShowtimesForm.action = 'theatres/' + opt.dataset.slug;
          break;
        }
      }
    }
  }

  function displayError(error) {
    var errorTypes = {
      0: 'Unknown error',
      1: 'Permission denied by user',
      2: 'Position is not available',
      3: 'Request timed out'
    };

    var errorMessage = errorTypes[error.code];

    if (error.code === 1) {
      var position = {
        coords: {
          latitude: ipLatitude,
          longitude: ipLongitude
        }
      };

      displayMyLocation(position);
    }

    if (error.code == 0 || error.code == 2) {
      errorMessage = errorMessage + ' ' + error.message;
    }

    var div = document.createElement('div');
    var msg = document.createTextNode(errorMessage);

    div.appendChild(msg);
    div.classList.add('error-message')
    div.style.display = 'none';
    document.body.appendChild(div);
  }

  function indexOfSmallest(a) {
    return a.indexOf(Math.min.apply(Math, a));
  }

  function setCookie(key, value) {
    var d = new Date();
    d.setTime(d.getTime() + (14 * 24 * 60 * 60 * 1000));
    var expires = "expires=" + d.toUTCString();
    document.cookie = key + "=" + value + "; " + expires;
  }

  function getCookie(cname) {
    var name = cname + "=";
    var ca = document.cookie.split(';');
    for (var i = 0; i < ca.length; i++) {
      var c = ca[i];
      while (c.charAt(0) == ' ') {
        c = c.substring(1);
      }
      if (c.indexOf(name) == 0) {
        return c.substring(name.length, c.length);
      }
    }
    return "";
  }

  function owstDateSelector () {
    var dateSelector = document.getElementById('owst-date-selector')

    if (dateSelector) {
      var form = dateSelector.querySelector('form')
      var dates = dateSelector.querySelector('select')

      dates.addEventListener('change', function () {
        form.submit();
      });
    }
  }

  function findShowtimesForm () {
    var form = document.getElementById('find-showtimes');
    var theatreSelection = document.getElementById('select-a-theatre');

    if (form) {
      form.addEventListener('submit', function(e) {
        e.preventDefault();
        var theatre = theatreSelection.options[theatreSelection.selectedIndex].value;
        form.action = 'theatres/' + theatre;
        form.submit();
      });
    }
  }

  function printShowtimes () {
    var button = document.querySelector('.os-print-showtimes');

    if (button) {
      button.addEventListener('click', function(e) {
        e.preventDefault();

        window.open(
          '?print',
          'print_window',
          'titlebar=no,toolbar=no,location=no,status=no,menubar=no,width=700,height=500'
        );
      });
    }
  }

  function isInternetExplorer () {
    var ua = window.navigator.userAgent;
    var msie = ua.indexOf("MSIE ");

    if (msie > 0 || !!navigator.userAgent.match(/Trident.*rv\:11\./)) {
      return true;
    } else {
      return false;
    }
  }
}
