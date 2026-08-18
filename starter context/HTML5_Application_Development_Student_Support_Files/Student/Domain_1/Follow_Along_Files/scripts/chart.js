google.charts.load('current', {packages: ['corechart', 'bar']});
google.charts.setOnLoadCallback(drawChart);

function drawChart() {
    var data = google.visualization.arrayToDataTable([
        ['Year', 'Memberships', { role: 'style' }],
        ['2020', 154, '#FC8A17'],            
        ['2021', 243, '#FC8A17'],
        ['2022', 365, '#FC8A17'],
        ['2023', 542, '#FC8A17'],
        ['2024', 745, '#FC8A17'], 
    ]);
    var options = {
        title: 'We are growing!',
        titleTextStyle: {fontSize: 24, bold: true},
        titlePosition: 'none',
        legend: 'none',
        backgroundColor: { fill:'transparent' },
        hAxis: {
          viewWindow: {
            min: [7, 30, 0],
            max: [17, 30, 0]
          }
        },
        vAxis: {
          title: 'Total Memberships'
        }
      };

      var chart = new google.visualization.ColumnChart(
        document.getElementById('chart_div'));

      chart.draw(data, options);
}
