$(document).ready(function() {
  var output = document.getElementById("sliderAmount");
  output.innerHTML = slider.value;
  var income = document.getElementById("income");
  var days=365;

  slider.oninput = function() {
    var slider = document.getElementById("slider");
    output.innerHTML = this.value;
    var calculatedamt = document.getElementById("calculatedamt")
    calculatedamt.innerHTML = Math.round(income.value*this.value/days)/100;
  }

  income.oninput = function() {
    income = document.getElementById("income");
    var calculatedamt = document.getElementById("calculatedamt")
    calculatedamt.innerHTML = Math.round(this.value*slider.value/days)/100;
  }

  $("#annual").click(function(){
    $("#annuallabel").addClass("selected");
    $("#weeklylabel").removeClass("selected");
    days = 365;
  });


  $("#weekly").click(function(){
    $("#annuallabel").removeClass("selected");
    $("#weeklylabel").addClass("selected");
    days = 7;
  });

  annualy.onclick = function() {
    days = 365;
    var income = document.getElementById("income");
    var calculatedamt = document.getElementById("calculatedamt")
    calculatedamt.innerHTML = Math.round(income.value*slider.value/days)/100;
  }

  weekly.onclick = function() {
    days = 7;
    var income = document.getElementById("income");
    var calculatedamt = document.getElementById("calculatedamt")
    calculatedamt.innerHTML = Math.round(income.value*slider.value/days)/100;
  }


});
