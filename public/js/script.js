document.addEventListener("DOMContentLoaded", function() {
    const searchBtn = document.getElementsByClassName("search__button");
    const searchBar = document.getElementsByClassName("search__bar");
    const searchInput = document.getElementById("search__input");
    const searchClose = document.getElementById("search__close");

    if (searchBtn[0]) {
        searchBtn[0].addEventListener("click", function() {
            searchBar[0].style.visibility = "visible";
            searchBar[0].classList.add("open");
            this.setAttribute("aria-expended", "true");
            searchInput.focus();
        });
    }

    if (searchClose) {
        searchClose.addEventListener("click", function() {
            searchBar[0].style.visibility = "hidden";
            searchBar[0].classList.remove("open");
            this.setAttribute("aria-expended", "false");
        });
    }
});