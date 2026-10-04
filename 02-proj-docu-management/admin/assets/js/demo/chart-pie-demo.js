// Set new default font family and font color to mimic Bootstrap's default styling
Chart.defaults.global.defaultFontColor = '#858796';

// Pie Chart Example
var ctx = document.getElementById("myPieChart");
var myPieChart = new Chart(ctx, {
  type: 'doughnut',
  data: {
    labels: ["Personal Info", "Total Document", "Account", "Activity Logs "],
    datasets: [{
      data: chartData, // Reference to the chartData variable
      backgroundColor: ['#4e73df', '#1cc88a', '#36b9cc', '#f6c23e'],
      hoverBackgroundColor: ['#2e59d9', '#17a673', '#2c9faf', '#f39c12'],
      hoverBorderColor: "rgb(219, 233, 239)",
    }],
  },
  options: {
    maintainAspectRatio: false,
    tooltips: {
      backgroundColor: "rgb(255,255,255)",
      bodyFontColor: "#4e73df", // Body text color (use a color of your choice)
      borderColor: '#dddfeb',
      borderWidth: 1,
      xPadding: 15,
      yPadding: 15,
      displayColors: false,
      caretPadding: 10,
      titleFontSize: 13, // Make the tooltip title larger
      bodyFontSize: 13,  // Make the tooltip body larger
      titleFontStyle: 'bold', // Make the tooltip title bold
      bodyFontStyle: 'bold', // Make the tooltip body bold
      titleFontFamily: 'Nunito', // You can customize the font family
      bodyFontFamily: 'Nunito', // You can customize the font family
    },
    legend: {
      display: true
    },
    cutoutPercentage: 78, // Makes it a doughnut chart
  },
});
