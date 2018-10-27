//Materialize
var elems = document.querySelectorAll('select');
var instances = M.FormSelect.init(elems);

//D3
var rawData, diameter, radius, root, node, link, color, max;
var min = 1;
var width = d3.select("#chart1").node().getBoundingClientRect().width-80;
var year = "all";
const formatNumber = d3.format(",d");

loadData();

function loadData(){
  max = getMax();
  d3.json("assets/data/flowersExp-"+year+".json").then(function(classes){
    root = d3.hierarchy(packageHierarchy(classes), (d) => d.children);
    rawData = classes;
    d3.select("#min").text(formatNumber(min));
    d3.select("#max").text(formatNumber(max));
    if(year == "all"){
      d3.select("#year-title").text("(Jan 2006 - Feb 2018)");
    }else{
      d3.select("#year-title").text("("+year+")");
    }

    drawGraphic();

    d3.select("#chart1")
      .attr("class","");
  });
}

function drawGraphic(){
  /*const scale = d3.scaleLinear()
    .domain([1,d3.max(rawData, d=> (d.qty === undefined)? 0 : parseInt(d.qty))])
    .range([1,50]);*/
  color = d3.scaleSequential(d3.interpolateViridis).domain([min, max]);

  d3.select("#chart1").html("");
  diameter = window.innerHeight < 800 ? 800 : window.innerHeight;
  radius = diameter / 2;
  var innerRadius = radius - 160;

  var cluster = d3.cluster()
    .size([360, innerRadius]);

  const line = d3.radialLine()
    .radius(function(d) { return d.y; })
    .angle(function(d) { return d.x / 180 * Math.PI; })
    .curve(d3.curveBundle.beta(0.95));

  var svg = d3.select("#chart1").append("svg")
    .attr("width", diameter)
    .attr("height", diameter)
    .append("g")
    .attr("transform", "translate(" + radius + "," + radius + ")");

  link = svg.append("g").selectAll(".link");
  node = svg.append("g").selectAll(".node");

  var links = packageExports(root.descendants());
  cluster(root);

  var nodes = root.descendants();

  link = link
    .data(links)
    .enter().append('path')
    .attr('class', 'link')
    .attr('d', d => line(d.source.path(d.target)));

  node = node
    .data(nodes.filter(function(n) { return !n.children; }))
    .enter().append("text")
    .attr("class", d=> d.data.key === d.data.parent.key? "node parent" : "node")
    .attr("dy", ".31em")
    .attr("transform", function(d) { return "rotate(" + (d.x - 90) + ")translate(" + (d.y + 8) + ",0)" + (d.x < 180 ? "" : "rotate(180)"); })
    .style("text-anchor", function(d) { return d.x < 180 ? "start" : "end"; })
    .text(function(d) { return d.data.key; })
    .on("mouseover", mouseovered)
    .on("mouseout", mouseouted);
}

function mouseovered(d) {
  node.each(function(n) { n.target = n.source = false; });

  link
    .classed("link--target", function(l) { if (l.target === d) return l.source.source = true; })
    .classed("link--source", function(l) { if (l.source === d) return l.target.target = true; })
    .filter(function(l) { return l.target === d || l.source === d; })
    .each(function() { this.parentNode.appendChild(this); })
    .style("stroke", d=> color(d.source.data.qty[d.target.data.name]));

  node
    .classed("node--target", function(n) { return n.target; })
    .classed("node--source", function(n) { return n.source; });
}

function mouseouted(d) {
  link
    .classed("link--target", false)
    .classed("link--source", false)
    .style("stroke", "grey");

  node
    .classed("node--target", false)
    .classed("node--source", false);
}

d3.select(self.frameElement).style("height", diameter + "px");

function packageHierarchy(classes) {
  var map = {};

  function find(name, data) {
    var node = map[name], i;
    if (!node) {
      node = map[name] = data || {name: name, children: []};
      if (name.length) {
        node.parent = find(name.substring(0, i = name.lastIndexOf(".")));
        node.parent.children.push(node);
        node.key = name.substring(i + 1);
      }
    }
    return node;
  }

  classes.forEach(function(d) {
      find(d.name, d);
  });

  return map[""];
}

function packageExports(nodes) {
  var map = {},
      exports = [];

  nodes.forEach(function(d) {
    map[d.data.name] = d;
  });

  // For each import, construct a link from the source to target node.
  nodes.forEach(function(d) {
    if (d.data.exports) d.data.exports.forEach(function(i) {
      exports.push({source: map[d.data.name], target: map[i]});
    });
  });

  return exports;
}

function getMax(){console.log(year);
  switch(year){
    case "2006": return 1509111660; break;
    case "2009": return 1399395291; break;
    case "2010": return 1288003444; break;
    case "2011": return 1159748675; break;
    case "2012": return 1156713324; break;
    case "2013": return 1237119765; break;
    case "2014": return 1391502539; break;
    case "2015": return 1789829050; break;
    case "2016": return 1748201794; break;
    case "2017": return 1753884675; break;
    case "2018": return 283739155; break;
    default: return 14717249373; break;
  }
}

window.onresize = function(event) {
  drawGraphic();
}

d3.select("#year")
  .on("change", function(){
    year = d3.select(this).property("value");
    loadData();
  });