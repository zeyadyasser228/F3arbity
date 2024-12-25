// let search = document.querySelector(".search-box");
// document.querySelector("#search-icon").onclick = () => {
//   search.classList.toggle("active");
//   menu.classList.remove("active");
// };

// let menu = document.querySelector(".navbar");
// document.querySelector("#menu-icon").onclick = () => {
//   menu.classList.toggle("active");
//   search.classList.remove("active");
// };

//hide manu and search bar when click on scroll
window.onscroll = () => {
  search.classList.remove("active");
  menu.classList.remove("active");
};

const userMenu = document.querySelector(".user-menu img");
const dropdown = document.querySelector(".dropdown");
const hamburger = document.querySelector(".hamburger");
const menu = document.querySelector(".menu");

userMenu.addEventListener("click", () => {
  console.log("clicked");
  dropdown.classList.toggle("active");
});

hamburger.addEventListener("click", () => {
  menu.classList.toggle("active");
});

const carBtn = document.querySelector("button#cart-btn");
console.log(carBtn);
const cartmenu = document.querySelector(".cart-dropdown");

carBtn.addEventListener("click", () => {
  console.log("clicked");
  cartmenu.classList.toggle("active");
});
/// phone number
document.getElementById("phone").addEventListener("input", function (e) {
  var phone = e.target.value;
  // Remove any non-digit characters
  phone = phone.replace(/\D/g, "");
  e.target.value = phone;
});

function showToast(message, color) {
  const toastContainer = document.getElementById("toast-container");

  // Create the toast element
  const toast = document.createElement("div");
  toast.classList.add("toast");
  toast.style.backgroundColor = color;
  toast.innerText = message;

  // Add the toast to the container
  toastContainer.appendChild(toast);

  // Show the toast
  setTimeout(() => {
    toast.classList.add("show");
  }, 100);

  // Remove the toast after 3 seconds
  setTimeout(() => {
    toast.classList.remove("show");
    setTimeout(() => {
      toast.remove();
    }, 400); // Wait for the fade-out transition to complete
  }, 3000);
}
