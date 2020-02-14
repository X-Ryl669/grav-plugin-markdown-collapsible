document.addEventListener("DOMContentLoaded", function(event){
  document.querySelectorAll("label.collapsible").forEach(function(el) {
    el.addEventListener("click", function(ev) { setTimeout(function(){ev.target.scrollIntoView({behavior: "smooth"})}, 100)});
    document.getElementById(el.getAttribute("for")).addEventListener("click", function(ev) {
      if (ev.target.previous) ev.target.checked = false;
      if (ev.target.checked) document.querySelectorAll("input.collapsible").forEach(function(i) { i.previous = false });
      ev.target.previous = ev.target.checked;
    });
})});
