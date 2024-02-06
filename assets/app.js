function hidePfp() {
    var pfp = document.getElementById("user-pfp");
    pfp.classList.toggle("hide");
  }
  
  /*const opciones_menu = document.querySelectorAll(".nav-link");
  opciones_menu.forEach((btn) =>
    btn.addEventListener("click", (e) => {
      e.preventDefault();
      document.querySelector(".nav-link.activo").classList.remove("activo");
      btn.classList.add("activo");
    })
  );*/