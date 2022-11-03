///// .js bloque l'envoi des fichier via gmail


window.addEventListener("load", function () {
   var buttons = document.querySelector(".dropdown"); 

   buttons.addEventListener("click", function () {
      this.querySelector(".dropdown-content").classList.toggle("d-none");
    });

    document.querySelector("#burger-menu").addEventListener("click", function () {
      var menu = document.querySelector("#navigation");
      if(menu.style.display == "flex"){
        menu.style.display = "none";
      }else{
        menu.style.display = "flex";
      }
    });

    document.querySelector("html").addEventListener("click", function (e) {
      var openDropdownElements = document.querySelectorAll(".dropdown-content:not(.d-none)");       
      openDropdownElements.forEach(
        function (openDropdown, currentIndex, listObj) {
          if (e.target !== openDropdown.previousElementSibling)
          {
            openDropdown.classList.add("d-none");
          };
        },
      );
    });
  });
  
  