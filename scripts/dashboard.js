// $(document).ready(function() {

function makeGraph(aidCount, environmentCount, healthCount, educationCount) {

  // Gotten from https://codepen.io/lisaofalltrades/pen/jZyzKo?editors=1111

  // define data
  var dataset = [
      {label: "Aid", count: aidCount},
      {label: "Environment", count: environmentCount},
      {label: "Health", count: healthCount},
      {label: "Education", count: educationCount},
    ];

  // chart dimensions
  var width = 250;
  var height = 250;

  // a circle chart needs a radius
  var radius = Math.min(width, height) / 2;

  // legend dimensions
  var legendRectSize = 25; // defines the size of the colored squares in legend
  var legendSpacing = 6; // defines spacing between squares

  // define color scale
  // var color = d3.scaleOrdinal(d3.schemeCategory20c);
  // more color scales: https://bl.ocks.org/pstuffa/3393ff2711a53975040077b7453781a9

  var svg = d3.select('#chart') // select element in the DOM with id 'chart'
    .append('svg') // append an svg element to the element we've selected
    .attr('width', width) // set the width of the svg element we just added
    .attr('height', height) // set the height of the svg element we just added
    .append('g') // append 'g' element to the svg element
    .attr('transform', 'translate(' + (width / 2) + ',' + (height / 2) + ')'); // our reference is now to the 'g' element. centerting the 'g' element to the svg element

  var arc = d3.arc()
    .innerRadius(radius/2)
    .outerRadius(radius); // size of overall chart

  var pie = d3.pie() // start and end angles of the segments
    .value(function(d) { return d.count; }) // how to extract the numerical data from each entry in our dataset
    .sort(null); // by default, data sorts in oescending value. this will mess with our animation so we set it to null

  // define tooltip
  var tooltip = d3.select('#chart') // select element in the DOM with id 'chart'
    .append('div') // append a div element to the element we've selected
    .attr('class', 'tooltip'); // add class 'tooltip' on the divs we just selected

  tooltip.append('div') // add divs to the tooltip defined above
    .attr('class', 'label'); // add class 'label' on the selection

  tooltip.append('div') // add divs to the tooltip defined above
    .attr('class', 'count'); // add class 'count' on the selection

  tooltip.append('div') // add divs to the tooltip defined above
    .attr('class', 'percent'); // add class 'percent' on the selection

  dataset.forEach(function(d) {
    d.count = +d.count; // calculate count as we iterate through the data
    d.enabled = true; // add enabled property to track which entries are checked
  });

  var color = d3.scaleOrdinal().domain(["Aid", "Environment", "Health", "Education"]).range(["#f6a585", "#ca9fe7", "#fcb43e", "#73d8dc"]);
  // creating the chart
  var path = svg.selectAll('path') // select all path elements inside the svg. specifically the 'g' element. they don't exist yet but they will be created below
    .data(pie(dataset)) //associate dataset wit he path elements we're about to create. must pass through the pie function. it magically knows how to extract values and bakes it into the pie
    .enter() //creates placeholder nodes for each of the values
    .append('path') // replace placeholders with path elements
    .attr('d', arc) // define d attribute with arc function above
    .attr('fill', function(d) { return color(d.data.label); }) // use color scale to define fill of each label in dataset
    .each(function(d) { this._current - d; }); // creates a smooth animation for each track

  // mouse event handlers are attached to path so they need to come after its definition
  path.on('mouseover', function(d) {  // when mouse enters div
   var total = d3.sum(dataset.map(function(d) { // calculate the total number of tickets in the dataset
    return (d.enabled) ? d.count : 0; // checking to see if the entry is enabled. if it isn't, we return 0 and cause other percentages to increase
    }));
   var percent = Math.round(1000 * d.data.count / total) / 10; // calculate percent
   tooltip.select('.label').html(d.data.label); // set current label
   tooltip.select('.count').html('$' + d.data.count); // set current count
   tooltip.select('.percent').html(percent + '%'); // set percent calculated above
   tooltip.style('display', 'block'); // set display
  });

  path.on('mouseout', function() { // when mouse leaves div
    tooltip.style('display', 'none'); // hide tooltip for that element
   });

  path.on('mousemove', function(d) { // when mouse moves
    tooltip.style('top', (d3.event.layerY + 10) + 'px') // always 10px below the cursor
      .style('left', (d3.event.layerX + 10) + 'px'); // always 10px to the right of the mouse
    });

  // define legend
  var legend = svg.selectAll('.legend') // selecting elements with class 'legend'
    .data(color.domain()) // refers to an array of labels from our dataset
    .enter() // creates placeholder
    .append('g') // replace placeholders with g elements
    .attr('class', 'legend') // each g is given a legend class
    .attr('transform', function(d, i) {
      var height = legendRectSize + legendSpacing; // height of element is the height of the colored square plus the spacing
      var offset =  height * color.domain().length / 2; // vertical offset of the entire legend = height of a single element & half the total number of elements
      var horz = 18 * legendRectSize; // the legend is shifted to the left to make room for the text
      var vert = i * height - offset; // the top of the element is hifted up or down from the center using the offset defiend earlier and the index of the current element 'i'
        return 'translate(' + horz + ',' + vert + ')'; //return translation
     });

  // adding colored squares to legend
  legend.append('rect') // append rectangle squares to legend
    .attr('width', legendRectSize) // width of rect size is defined above
    .attr('height', legendRectSize) // height of rect size is defined above
    .style('fill', color) // each fill is passed a color
    .style('stroke', color) // each stroke is passed a color
    .on('click', function(label) {
      var rect = d3.select(this); // this refers to the colored squared just clicked
      var enabled = true; // set enabled true to default
      var totalEnabled = d3.sum(dataset.map(function(d) { // can't disable all options
        return (d.enabled) ? 1 : 0; // return 1 for each enabled entry. and summing it up
      }));

      if (rect.attr('class') === 'disabled') { // if class is disabled
        rect.attr('class', ''); // remove class disabled
      } else { // else
        if (totalEnabled < 2) return; // if less than two labels are flagged, exit
        rect.attr('class', 'disabled'); // otherwise flag the square disabled
        enabled = false; // set enabled to false
      }

      pie.value(function(d) {
        if (d.label === label) d.enabled = enabled; // if entry label matches legend label
          return (d.enabled) ? d.count : 0; // update enabled property and return count or 0 based on the entry's status
      });

      path = path.data(pie(dataset)); // update pie with new data

      path.transition() // transition of redrawn pie
        .duration(750) //
        .attrTween('d', function(d) { // 'd' specifies the d attribute that we'll be animating
          var interpolate = d3.interpolate(this._current, d); // this = current path element
          this._current = interpolate(0); // interpolate between current value and the new value of 'd'
          return function(t) {
            return arc(interpolate(t));
          };
        });
    });

  // adding text to legend
  legend.append('text')
    .attr('x', legendRectSize + legendSpacing)
    .attr('y', legendRectSize - legendSpacing)
    .text(function(d) { return d; }); // return label

}

$(document).ready(function() {

  $("#aid-btn").click(function(){
    request = $.ajax({
      url: "offerings_collector.php",
      type: "POST",
      data: {'category_id': 1},
      success: function(html) {
        if (html) {
          $('body').css("overflow", "auto");
          $('#offerings-collection').html(html);
          $('#category-title-container').html("Aid");
          $('#offerings-money-input').val($("#aid-btn").data('money'));
          $('#dashboard-container').css("display", "none");
          $('#offerings-container').css("display", "flex");
          $('#category-title-container-inner').css("background-image", 'url("../images/aid.png");');
        }
      }
    });
  });

  $("#education-btn").click(function(){
    request = $.ajax({
      url: "offerings_collector.php",
      type: "POST",
      data: {'category_id': 4},
      success: function(html) {
        if (html) {
          $('body').css("overflow", "auto");
          $('#offerings-collection').html(html);
          $('#category-title-container').html("Education");
          $('#offerings-money-input').val($("#education-btn").data('money'));
          $('#dashboard-container').css("display", "none");
          $('#offerings-container').css("display", "flex");
          $('#category-title-container-inner').css("background-image", 'url("../images/education.png");');
        }
      }
    });
  });

  $("#environment-btn").click(function(){
    request = $.ajax({
      url: "offerings_collector.php",
      type: "POST",
      data: {'category_id': 2},
      success: function(html) {
        if (html) {
          $('body').css("overflow", "auto");
          $('#offerings-collection').html(html);
          $('#category-title-container').html("Environment");
          $('#offerings-money-input').val($("#environment-btn").data('money'));
          $('#dashboard-container').css("display", "none");
          $('#offerings-container').css("display", "flex");
          $('#category-title-container-inner').css("background-image", 'url("../images/environment.png");');
        }
      }
    });
  });

  $("#health-btn").click(function(){
    request = $.ajax({
      url: "offerings_collector.php",
      type: "POST",
      data: {'category_id': 3},
      success: function(html) {
        if (html) {
          $('body').css("overflow", "auto");
          $('#offerings-collection').html(html);
          $('#category-title-container').html("Health");
          $('#offerings-money-input').val($("#health-btn").data('money'));
          $('#dashboard-container').css("display", "none");
          $('#offerings-container').css("display", "flex");
          $('#category-title-container-inner').css("background-image", 'url("../images/health.png");');
        }
      }
    });
  });

  $("#offerings-update-btn").click(function(){
    var money = document.getElementById("offerings-money-input").value;
    var categoryIndices = {'Aid': 1, 'Environment': 2, 'Health': 3, 'Education': 4};
    var categoryId = categoryIndices[$('#category-title-container').html()];
    request = $.ajax({
      url: "offerings_collector.php",
      type: "POST",
      data: {'category_id': categoryId, 'money': money},
      success: function(html) {
        if (html) {
          $('body').css("overflow", "auto");
          $('#offerings-collection').html(html);
        }
      }
    });
  });

  $('body').on('click', '.offering-card', function() {
    var id = $(this).data("id");
    var money = $(this).data("money");
    document.getElementById('confirm-donation-modal').dataset.offeringId = id;
    document.getElementById('confirm-donation-modal').dataset.money = money;
    $('#confirm-donation-money').html(money);
    $('#confirm-donation-modal').show();
    // $("#confirm-donation-modal").data("money", id);
  });

  $('body').on('click', '.close', function() {
    $(this).closest(".modal").hide();
  });

  $('body').on('click', '#modal-donate-btn', function() {
    var money = $("#confirm-donation-modal").data("money");
    var offeringId = $("#confirm-donation-modal").data("offeringId");
    request = $.ajax({
      url: "donate-helper.php",
      type: "POST",
      data: {'offeringId': offeringId, 'money': money},
      success: function(html) {
        alert('donated');
        // if (html) {
        //   $('body').css("overflow", "auto");
        //   $('#offerings-collection').html(html);
        // }
      }
    });
  });

});
