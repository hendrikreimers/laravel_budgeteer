
require('./bootstrap');

import Chart from "chart.js";
import flatpickr from "flatpickr"
const German = require("flatpickr/dist/l10n/de.js").default.de;
flatpickr.localize(German);

/*
    <div class="chart" style="width: 400px; height: 300px;"
         data-type="bar"
         data-label="TestChart"
         data-backgroundColor='["rgba(255, 99, 132, 0.2)", "rgba(54, 162, 235, 0.2)", "rgba(255, 206, 86, 0.2)", "rgba(75, 192, 192, 0.2)", "rgba(153, 102, 255, 0.2)", "rgba(255, 159, 64, 0.2)"]'
         data-borderColor='["rgba(255,99,132,1)", "rgba(54, 162, 235, 1)", "rgba(255, 206, 86, 1)", "rgba(75, 192, 192, 1)", "rgba(153, 102, 255, 1)", "rgba(255, 159, 64, 1)"]'
         data-borderWidth="1"
         data-options='{"scales":{"yAxes":[{"ticks":{"beginAtZero":true}}]}}'
         data-values="[12, 19, 3, 5, 2, 3]"
         data-labels='["Rot", "Blau", "Gelb", "Grün", "Rosa", "Orange"]'>
        <canvas width="300" height="200"></canvas>
    </div>
 */

/**
 * Charts
 *
 */
var chartElements = document.body.querySelectorAll('.chart');
if ( chartElements.length > 0 ) {
    chartElements.forEach(function (el) {
        var dType = el.getAttribute('data-type'),
            dLabel = el.getAttribute('data-label'),
            dLabels = JSON.parse(el.getAttribute('data-labels')),
            dBackgroundColor = JSON.parse(el.getAttribute('data-backgroundColor')),
            dBorderColor = JSON.parse(el.getAttribute('data-borderColor')),
            dBorderWidth = el.getAttribute('data-borderWidth'),
            dOptions = JSON.parse(el.getAttribute('data-options')),
            dData = JSON.parse(el.getAttribute('data-values'))

        if ( (dLabels != null) && (dLabels != '') )
            dLabels = dLabels.slice(0, dData.length - 1);

        if ( (dData != null) && (dData != '') ) {
            if ( dData[0] instanceof Array ) {
                var dDatasets = [];
                dData.forEach(function(dataGroup) {
                    dDatasets.push({
                        label: dLabel,
                        data: dataGroup,
                        backgroundColor: dBackgroundColor,
                        borderColor: dBorderColor,
                        borderWidth: dBorderWidth
                    })
                });
            } else {
                dDatasets = [{
                        label: dLabel,
                        data: dData,
                        backgroundColor: dBackgroundColor,
                        borderColor: dBorderColor,
                        borderWidth: dBorderWidth
                    }]
            }

            var ctx = new Chart(el.getElementsByTagName('canvas')[0], {
                type: dType,
                data: {
                    labels: dLabels,
                    datasets: dDatasets
                },
                options: dOptions
            });
        }
    });
}

/**
 * Datepicker
 *
 */
flatpickr('.datepicker', {
    dateFormat: 'd.m.Y'
});

/**
 * Floating multi input focus
 *
 */
var sumValElement = document.body.querySelector('#sumValFocus');
if ( sumValElement ) {
    sumValElement.addEventListener("keypress", function (evt) {
        if (evt.charCode == 44) {
            document.body.querySelector('#sumValTarget').focus();
            evt.preventDefault();
            return false;
        }
    });
}
