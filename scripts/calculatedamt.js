$(document).ready(function() {
  var output = document.getElementById("sliderAmount");
  output.innerHTML = slider.value;
  var income = document.getElementById("income");

  slider.oninput = function() {
    var slider = document.getElementById("slider");
    var output = document.getElementById("sliderAmount");
    output.innerHTML = this.value;
    var calculatedamt = document.getElementById("calculatedamt")
    calculatedamt.innerHTML = Math.round(income.value*this.value/365)/100;
  }

  income.oninput = function() {
    var income = document.getElementById("income");
    var calculatedamt = document.getElementById("calculatedamt")
    calculatedamt.innerHTML = Math.round(this.value*slider.value/365)/100;
  }

  annual.onclick = function() {
    var annual = document.getElementById("annual");
    var annuallabel = document.getElementById("annuallabel");
    annuallabel.classList.add("selected");
  }

  weeklylabel.onclick = function () {
    var weekly = document.getElementById("weekly");
    var weeklylabel = document.getElementById("weeklylabel");
    weekly.classList.add("selected");
  }

});
