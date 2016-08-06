/*
* Mirko Gueregat - 16/10/2015
*/

$(document).ready(function () {
  "use strict";
  function Router() {
    this.routes = {};
  }
  Router.prototype.addRoute = function (uri, route) {
    this.routes[uri] = route;
  };
  Router.prototype.getRoute = function (uri) {
    if (uri === undefined || uri === "") {
      return this.routes['/'];
    } else {
      if (this.routes[uri]) {
        return this.routes[uri];
      } else {
        return "pages/404.html";
      }
    }
  };

  var router = new Router();

  router.addRoute("/", "pages/home.html");
  router.addRoute("/home", "pages/home.html");

  $(window).on('hashchange', function (event) {
    $('#wrapper').load(router.getRoute(document.location.hash.split('#')[1]));
  });
  $(window).trigger("hashchange");
});