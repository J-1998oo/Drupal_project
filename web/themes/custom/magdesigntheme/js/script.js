var btn = document.querySelector(".navmenu");
var btnx = document.querySelector(".buton-x");
var btnsub1 = document.querySelector(".bnav1");
var btnsub2 = document.querySelector(".bnav2");
var btnst = true;
var btnsubst = false;

btn.onclick = function () {
  if (btnst == true) {
    document.querySelector(".navmenu span").classList.add("firstul-show");
    document.querySelector(".buton-x span").classList.add("firstul-show");
    document.getElementById("firstul--3").classList.add("firstul-show");
    btnst = false;
  } else if (btnst == false) {
    document.querySelector(".navmenu span").classList.remove("firstul-show");
    document.querySelector(".buton-x span").classList.remove("firstul-show");
    document.getElementById("firstul--3").classList.remove("firstul-show");
    btnst = true;
  }
};

btnx.onclick = function () {
  if (btnst == true) {
    document.querySelector(".navmenu span").classList.add("firstul-show");
    document.querySelector(".buton-x span").classList.add("firstul-show");
    document.getElementById("firstul--3").classList.add("firstul-show");
    btnst = false;
  } else if (btnst == false) {
    document.querySelector(".navmenu span").classList.remove("firstul-show");
    document.querySelector(".buton-x span").classList.remove("firstul-show");
    document.getElementById("firstul--3").classList.remove("firstul-show");
    btnst = true;
  }
};

btnsub1.onclick = function () {
  if (btnsubst == false) {
    document.querySelector(".bnav1 span").classList.add("secndul-show");
    document.getElementById("secndul--3").classList.add("secndul-show");
    btnsubst = true;
  } else if (btnsubst == true) {
    document.querySelector(".bnav1 span").classList.remove("secndul-show");
    document.getElementById("secndul--3").classList.remove("secndul-show");
    btnsubst = false;
  }
};

btnsub2.onclick = function () {
  if (btnsubst == true) {
    document.querySelector(".bnav2 span").classList.add("therdul-show");
    document.getElementById("therdul--3").classList.add("therdul-show");
    btnsubst = false;
  } else if (btnsubst == false) {
    document.querySelector(".bnav2 span").classList.remove("therdul-show");
    document.getElementById("therdul--3").classList.remove("therdul-show");
    btnsubst = true;
  }
};
