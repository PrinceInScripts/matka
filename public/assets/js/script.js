const menuBtn = document.getElementById("menuBtn");
const closeBtn = document.getElementById("closebtn");
const sidebar = document.getElementById("sidebar");

if (menuBtn) {
  menuBtn.addEventListener("click", () => {
    if (sidebar) sidebar.classList.add("active");
  });
}

if (closeBtn) {
  closeBtn.addEventListener("click", () => {
    if (sidebar) sidebar.classList.remove("active");
  });
}