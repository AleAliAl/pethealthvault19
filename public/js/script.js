const body = document.querySelector("body"),
     modeToggle = body.querySelector(".mode-toggle");
     sidebar = body.querySelector("nav");
     sidebarToggle = body.querySelector(".sidebar-toggle");

modeToggle.addEventListener("click", () =>{
    body.classList.toggle("dark");
});

sidebarToggle.addEventListener("click", () => {
    sidebar.classList.toggle("close");
});


const profileToggle = document.getElementById('profileToggle');
  const dropdownMenu = document.getElementById('dropdownMenu');

  profileToggle.addEventListener('click', () => {
    dropdownMenu.style.display = dropdownMenu.style.display === 'block' ? 'none' : 'block';
  });

  document.addEventListener('click', (e) => {
    if (!profileToggle.contains(e.target) && !dropdownMenu.contains(e.target)) {
      dropdownMenu.style.display = 'none';
    }
  });



/* ACCORDION JS */
var acc = document.getElementsByClassName("accordion");
var i;

for(i = 0; i < acc.length; i++){
    acc[i].addEventListener("click", function(){
        this.classList.toggle("active");
        var panel = this.nextElementSibling;
        if (panel.style.maxHeight){
            panel.style.maxHeight = null;
        } else {
            panel.style.maxHeight = panel.scrollHeight + "px";
        }
    });
}



