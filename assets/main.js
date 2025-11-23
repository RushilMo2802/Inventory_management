// REGEX VALIDATION FILE
function validateRegisterForm() {
  const username = document.getElementById("username").value.trim();
  const email = document.getElementById("email").value.trim();
  const password = document.getElementById("password").value.trim();

  const usernameRegex = /^[A-Za-z0-9_]{3,15}$/;
  const emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[A-Za-z]{2,}$/;
  const passwordRegex = /^(?=.*[A-Z])(?=.*[a-z])(?=.*\d).{6,}$/;

  if (!usernameRegex.test(username)) {
    alert("Username must be 3–15 characters (letters, numbers, underscore).");
    return false;
  }

  if (!emailRegex.test(email)) {
    alert("Enter a valid email address.");
    return false;
  }

  if (!passwordRegex.test(password)) {
    alert("Password must have at least 6 chars, one uppercase, one lowercase, and one number.");
    return false;
  }

  return true;
}

function validateLoginForm() {
  const email = document.getElementById("loginEmail").value.trim();
  const password = document.getElementById("loginPassword").value.trim();

  const emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[A-Za-z]{2,}$/;
  const passwordRegex = /^.{6,}$/;

  if (!emailRegex.test(email)) {
    alert("Enter a valid email address.");
    return false;
  }

  if (!passwordRegex.test(password)) {
    alert("Password must be at least 6 characters.");
    return false;
  }

  return true;
}
