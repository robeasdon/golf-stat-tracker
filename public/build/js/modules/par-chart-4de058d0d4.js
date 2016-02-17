var ParChart = (function (d3) {
    'use strict';

    var _data = [];

    var _config = {
        container: '#par-chart'
    };

    var width = 210;
    var height = 210;
    var radius = Math.min(width, height) / 2;
    var donutWidth = 50;

    var color = d3.scale.category20b();

    function draw() {
        var svg = d3.select(_config.container)
            .append('svg')
            .attr("width", '100%')
            .attr("height", '100%')
            .style('display', 'block')
            .style('height', (height) + 'px')
            .append('g')
            .attr('transform', 'translate(' + (width / 2) +
            ',' + (height / 2) + ')');

        var tooltip = d3.select(_config.container)
            .append('div')
            .attr('class', 'chart-tooltip');

        tooltip.append('div')
            .attr('class', 'tooltip-label');

        tooltip.append('div')
            .attr('class', 'tooltip-count');

        var arc = d3.svg.arc()
            .innerRadius(radius - donutWidth)
            .outerRadius(radius);

        var pie = d3.layout.pie()
            .value(function (d) {
                return d.count;
            })
            .sort(null);

        var path = svg.selectAll('path')
            .data(pie(_data))
            .enter()
            .append('path')
            .attr('d', arc)
            .attr('fill', function (d, i) {
                return color(d.data.label);
            });

        path.on('mouseover', function(d) {
            tooltip.select('.tooltip-label').html(d.data.label);
            tooltip.select('.tooltip-count').html(d.data.count);
            tooltip.style('display', 'block');
        });

        path.on('mouseout', function(d) {
            tooltip.style('display', 'none');
        });

    }

    function init(data, config) {
        _data = data;
        _config = $.extend(_config, config);

        draw();
    }

    return {
        init: init
    };
})(d3);