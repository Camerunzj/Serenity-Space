// Contact Me

function validateForm() {
  const email = document.getElementById("email").value;
  const emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;

  if (!emailPattern.test(email)) {
    alert("Por favor, ingrese un correo electrónico válido.");
    return false;
  }

  return true;
}
