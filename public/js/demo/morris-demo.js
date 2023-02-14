$(function() {

    

    Morris.Bar({
        element: 'morris-bar-chart',
        data: [
            { y: '11-11-2022 13:00', a: 60, b: 50 },
            { y: '11-11-2022 12:35', a: 75, b: 65 },
            { y: '11-11-2022 10:00', a: 50, b: 40 },
            { y: '11-11-2022 09:42', a: 75, b: 65 },
            { y: '11-11-2022 08:35', a: 50, b: 40 },
            { y: '10-11-2022 11:21', a: 75, b: 65 },
            { y: '10-11-2022 08:01', a: 100, b: 90 } 
        ],
        xkey: 'y',
        ykeys: ['a', 'b'],
        labels: ['Temperatura', 'Humedad'],
        hideHover: 'auto',
        resize: true,
        barColors: ['#1ab394', '#cacaca'],
    });

    

});
