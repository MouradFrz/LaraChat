/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!************************************!*\
  !*** ./resources/js/userSearch.js ***!
  \************************************/
var inputField = $("#user-search");
var displayDiv = $("#floating-users");
displayDiv.hide();
inputField.on("keydown", function () {
  if (inputField.val().length > 1) {
    axios.get("/search-user?keyword=".concat(inputField.val())).then(function (res) {
      return res.data;
    }).then(function (res) {
      displayDiv.empty();

      if (res.length) {
        res.forEach(function (element) {
          displayDiv.append("<a href=\"new-convo/".concat(element.id, "\">").concat(element.email, "</a>"));
        });
      } else {
        displayDiv.append("<p>No results found!</p>");
      }
    });
    displayDiv.show();
  } else {
    displayDiv.hide();
  }
});
inputField.on("blur", function () {
  if (inputField.val() === "") {
    displayDiv.hide();
  }
});
/******/ })()
;