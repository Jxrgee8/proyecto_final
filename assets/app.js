/** Función para esconder la foto de perfil al hacer pequeña la pantalla: */
function hidePfp() {
  var pfp = document.getElementById("user-pfp");
  pfp.classList.toggle("hide");
}

/** Formularios de Login/ Registro: */
const contenedor = document.getElementById("contenedor");
const btnRegistro = document.getElementById("registro");
const btnLogin = document.getElementById("login");

btnRegistro.addEventListener("click", () => {
  contenedor.classList.add("activo");
});

btnLogin.addEventListener("click", () => {
  contenedor.classList.remove("activo");
});

const btnLoginNav = document.getElementById("btn-login");
const btnCerrar = document.getElementById("btn-cerrar");
const form = document.getElementById("contenedor-flex");

btnLoginNav.addEventListener("click", () => {
  form.classList.toggle("hide");
});

// TODO: Botón cerrar funcional:
btnCerrar.addEventListener("click", () => {
  form.classList.add("hide");
});