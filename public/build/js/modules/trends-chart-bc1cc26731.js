var TrendsChart = (function ($, d3) {
    'use strict';

    var _data = [];

    var _config = {
        container: '#trends-chart'
    };

    var _settings = {
        margin: {top: 0, right: 20, bottom: 30, left: 20},
        width: 700 - 20 - 20, // 700 - margin.left - margin.right
        height: 300 - 0 - 30 // 300 - margin.top - margin.bottom
    };

    var parseDate, xScale, yScale, xAxis, yAxis, strokesLineGen, puttsLineGen, svg;

    function debouncer(func, timeout) {
        var timeoutID, timeout = timeout || 200;
        return function () {
            var scope = this, args = arguments;
            clearTimeout(timeoutID);
            timeoutID = setTimeout(function () {
                func.apply(scope, Array.prototype.slice.call(args));
            }, timeout);
        }
    }

    function resize() {
        var width = parseInt(d3.select('#trends').style('width')) - _settings.margin.left - _settings.margin.right,
            height = Math.round(width / _settings.aspect);

        d3.select('#trends').style('height', (height + _settings.margin.top + _settings.margin.bottom) + 'px');

        xScale.range([_settings.margin.left, width - _settings.margin.right]);
        yScale.range([height - _settings.margin.top, _settings.margin.bottom]);

        xAxis.ticks(Math.max(width / 150, 2));
        yAxis.ticks(Math.max(height / 50, 2));

        svg.select('.x.axis')
            .attr("transform", "translate(0," + (height) + ")")
            .call(xAxis);

        svg.select('.y.axis')
            .call(yAxis);

        svg.select('.strokes-line').attr("d", strokesLineGen(_data));
        svg.select('.putts-line').attr("d", puttsLineGen(_data));
    }

    function bindEvents() {
        d3.select(window).on('resize', debouncer(function () {
            resize();
        }));
    }

    function init(data, config) {
        _data = data;
        _config = $.extend(_config, config);

        _settings.aspect = _settings.width / _settings.height;

        parseDate = d3.time.format("%Y-%m-%d").parse;

        xScale = d3.time.scale()
            .range([_settings.margin.left, _settings.width - _settings.margin.right])
            .domain(d3.extent(_data, function (d) {
                return parseDate(d.date);
            }))
            .nice();

        yScale = d3.scale.linear()
            .range([_settings.height - _settings.margin.top, _settings.margin.bottom])
            .domain([0, d3.max(_data, function (d) {
                return Math.max(d.strokes, d.putts);
            })])
            .nice();

        xAxis = d3.svg.axis().scale(xScale).ticks(Math.max(_settings.width / 150, 2));
        yAxis = d3.svg.axis().scale(yScale).orient("left").ticks(Math.max(_settings.height / 50, 2));

        strokesLineGen = d3.svg.line()
            .x(function (d) {
                return xScale(parseDate(d.date));
            })
            .y(function (d) {
                return yScale(d.strokes);
            });

        puttsLineGen = d3.svg.line()
            .x(function (d) {
                return xScale(parseDate(d.date));
            })
            .y(function (d) {
                return yScale(d.putts);
            });

        svg = d3.select(_config.container);

        draw();

        bindEvents();
    }

    function draw() {
        svg = svg.append("svg")
            .attr("width", '100%')
            .attr("height", '100%')
            .attr("id", "trends")
            .style('display', 'block')
            .style('height', (_settings.height + _settings.margin.top + _settings.margin.bottom) + 'px')
            .append("g")
            .attr("transform", "translate(" + _settings.margin.left + "," + _settings.margin.top + ")");

        svg.append("svg:g")
            .attr("class", "axis x")
            .attr("transform", "translate(0," + (_settings.height) + ")")
            .call(xAxis);

        svg.append("svg:g")
            .attr("class", "axis y")
            .attr("transform", "translate(" + (_settings.margin.left) + ",0)")
            .call(yAxis);

        svg.append('svg:path')
            .attr('class', 'strokes-line')
            .attr('d', strokesLineGen(_data))
            .attr('stroke', 'green')
            .attr('stroke-width', 2)
            .attr('fill', 'none');

        svg.append('svg:path')
            .attr('class', 'putts-line')
            .attr('d', puttsLineGen(_data))
            .attr('stroke', 'blue')
            .attr('stroke-width', 2)
            .attr('fill', 'none');

        svg.call(resize);
    }

    return {
        init: init
    };
})(jQuery, d3);
