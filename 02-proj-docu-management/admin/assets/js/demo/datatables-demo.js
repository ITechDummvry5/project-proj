// Call the dataTables jQuery plugin
$(document).ready(function() {
  $('#dataTable').DataTable({
    "order": [[0, 'desc']] // Sort by the 5th column (index 4) which is action_date in descending order
  });
  $('#dataTable1').DataTable({
  "order": [[5, 'desc']] // Sort by the 5th column (index 4) which is action_date in descending order
  });
  $('#dataTable2').DataTable({
    "order": [[0, 'desc']] // Sort by the 5th column (index 4) which is action_date in descending order
    });
    $('#dataTable3').DataTable({
      "order": [[2, 'desc']] // Sort by the 5th column (index 4) which is action_date in descending order
      });
      $('#dataTable4').DataTable({
        "order": [[6, 'desc']] // Sort by the 5th column (index 4) which is action_date in descending order
        });
        $('#dataTable5').DataTable({
          "order": [[4, 'desc']] // Sort by the 5th column (index 4) which is action_date in descending order
          });
          $('#dataTable6').DataTable({
            "order": [[3, 'desc']] // Sort by the 5th column (index 4) which is action_date in descending order
            });
            $('#dataTable7').DataTable({
              "order": [[7, 'desc']] // Sort by the 5th column (index 4) which is action_date in descending order
              });
});
