
var Round = (function($) {

    var $tableCreateRound = $('.table-create-round');
    var $tableRoundTotals = $('#table-round-totals');
    var $cellTotalPutts = $tableRoundTotals.find('#cell-total-putts');
    var $cellTotalStrokes = $tableRoundTotals.find('#cell-total-strokes');
    var $scoresInputs = $tableCreateRound.find('.scores-input');
    var $puttsInputs = $tableCreateRound.find('.putts-input');

    function validate() {
        for (var i = 0; i < 18; i++) {
            var $scoresInput = $scoresInputs.eq(i);
            var $puttsInput = $puttsInputs.eq(i);

            validateStrokes($scoresInput, $puttsInput);
            validatePutts($puttsInput, $scoresInput);
        }
    }

    function validateStrokes(inputScore, inputPutts) {
        var score = parseInt(inputScore.val(), 10);
        var putts = parseInt(inputPutts.val(), 10);

        var error = isNaN(inputScore.val()) ||
            (score < 1 && inputScore.val().length > 0) ||
            (putts >= score && inputScore.val().length > 0 && inputPutts.val().length > 0);

        inputScore.parent().toggleClass('has-error', error);

        return error;
    }

    function validatePutts(inputPutts, inputScore) {
        var score = parseInt(inputScore.val(), 10);
        var putts = parseInt(inputPutts.val(), 10);

        var error = isNaN(inputPutts.val()) ||
            (putts < 0 && inputPutts.val().length > 0) ||
            (putts >= score && inputScore.val().length > 0 && inputPutts.val().length > 0);

        inputPutts.parent().toggleClass('has-error', error);

        return error;
    }

    function updateTotalStrokes() {
        var totalStrokes = 0;

        $scoresInputs.each(function() {
            var strokes = $(this).val();

            if (!isNaN(strokes) && strokes.length !== 0) {
                totalStrokes += parseInt(strokes, 10);
            }
        });

        $cellTotalStrokes.text(totalStrokes);
    }

    function updateTotalPutts() {
        var totalPutts = 0;

        $puttsInputs.each(function() {
            var putts = $(this).val();

            if (!isNaN(putts) && putts.length !== 0) {
                totalPutts += parseInt(putts, 10);
            }
        });

        $cellTotalPutts.text(totalPutts);
    }

    function updateTotals() {
        updateTotalPutts();
        updateTotalStrokes();
    }

    function bindEvents() {
        $tableCreateRound.on('keyup', function(e) {
            validate();
            updateTotals();
        });
    }

    function init() {
        bindEvents();

        // trigger validation and totals calculation on page load
        $tableCreateRound.trigger('keyup');

        $tableRoundTotals.show();
    }

    return {
        init: init
    }

})(jQuery);

Round.init();
