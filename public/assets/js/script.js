const menuBtn = document.getElementById("menuBtn");
const sidebar = document.getElementById("sidebar");
// const overlay = document.getElementById("overlay");
const closebtn = document.getElementById("closebtn");

menuBtn.addEventListener("click", () => {
    sidebar.classList.toggle("active");
    // overlay.classList.toggle("active");
});

// overlay.addEventListener("click", () => {
//     sidebar.classList.remove("active");
//     overlay.classList.remove("active");
// });

closebtn.addEventListener("click", () => {
    sidebar.classList.remove("active");
    // overlay.classList.remove("active");
});
