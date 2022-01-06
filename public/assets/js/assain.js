console.log("test");


  let chevron = document.querySelector("i");
  let chevron2 = document.getElementById("chevron");
  let bouton = document.getElementById("btn");
  let bouton2 = document.getElementById("btn2");
  console.log(chevron);

  
  bouton.addEventListener("mouseover", function () {
    chevron.style.visibility = "visible";
  });

  bouton.addEventListener("mouseout", function () {
    chevron.style.visibility = "hidden";
  });

  bouton2.addEventListener("mouseover", function () {
    chevron2.style.visibility = "visible";
  });

  bouton2.addEventListener("mouseout", function () {
    chevron2.style.visibility = "hidden";
  });

