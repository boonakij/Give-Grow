$(document).ready(function() {
  alert("hi");
  var output = document.getElementById("sliderAmount");
  output.innerHTML = slider.value;

  slider.onchange = function() {
    var slider = document.getElementById("slider");
    var output = document.getElementById("sliderAmount");
    output.innerHTML = this.value;
  }

  slider.onchange = function() {
    var income = document.getElementById("income");
    calculatedamt.innerHTML = income*this.value*.001/365;
  }
});
