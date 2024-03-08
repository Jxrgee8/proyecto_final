const icono_visto = document.getElementById("icono-visto");
const icono_por_ver = document.getElementById("icono-por-ver");
const icono_favorito = document.getElementById("icono-favorito");

icono_visto.addEventListener("click", (e) => {
  console.log("click click");
  e.preventDefault();
  icono_visto.classList.toggle("bi-eye");
  icono_visto.classList.toggle("bi-eye-fill");
});

icono_por_ver.addEventListener("click", (e) => {
  e.preventDefault();
  icono_por_ver.classList.toggle("bi-bookmark");
  icono_por_ver.classList.toggle("bi-bookmark-fill");
});

icono_favorito.addEventListener("click", (e) => {
  e.preventDefault();
  icono_favorito.classList.toggle("bi-heart");
  icono_favorito.classList.toggle("bi-heart-fill");
});