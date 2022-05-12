function myFunction() {
  let count = 0;
  // Declare variables
  var input, filter, table, tr, td, i, txtValue;
  input = document.getElementById("myInput");
  filter = input.value.toUpperCase();
  table = document.getElementById("myTable");
  tr = table.getElementsByTagName("tr");

  // Loop through all table rows, and hide those who don't match the search query
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[1];
    if (td) {
      txtValue = td.textContent || td.innerText;
      if (txtValue.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
        count+=1;
      } else {
        tr[i].style.display = "none";
      }
    }
  }

  document.getElementById('drugCount').innerText = count + ' drugs';
}
function myFunction1() {
  let count = 0;
  // Declare variables
  var input, filter, table, tr, td, i, txtValue;
  input = document.getElementById("myInput1");
  filter = input.value.toUpperCase();
  table = document.getElementById("myTable1");
  tr = table.getElementsByTagName("tr");

  // Loop through all table rows, and hide those who don't match the search query
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[1];
    if (td) {
      txtValue = td.textContent || td.innerText;
      if (txtValue.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
        count+=1;
      } else {
        tr[i].style.display = "none";
      }
    }
  }

  document.getElementById('drugCount1').innerText = count + ' drugs';
}
function filterRows() {
  let count = 0;
  var from = $('#datefilterfrom').val();
  var to = $('#datefilterto').val();

  if (!from && !to) { // no value for from and to
    return;
  }

  from = from || '1970-01-01'; // default from to a old date if it is not set
  to = to || '2999-12-31';

  var dateFrom = moment(from);
  var dateTo = moment(to);

  $('#myTable tbody tr').each(function(i, tr) {
    var val = $(tr).find("td:nth-child(3)").text();
    var dateVal = moment(val, "DD.MM.YYYY", true);
    var visible = (dateVal.isBetween(dateFrom, dateTo, null, [])) ? "" : "none"; // [] for inclusive
    $(tr).css('display', visible);
    if (visible==""){
      count+=1;
    }
  });

  document.getElementById('drugCount').innerText = count + ' drugs';
}

$('#datefilterfrom').on("change", filterRows);
$('#datefilterto').on("change", filterRows);

function filterRows1() {
  let count = 0;
  var from = $('#datefilterfrom1').val();
  var to = $('#datefilterto1').val();

  if (!from && !to) { // no value for from and to
    return;
  }

  from = from || '1970-01-01'; // default from to a old date if it is not set
  to = to || '2999-12-31';

  var dateFrom = moment(from);
  var dateTo = moment(to);

  $('#myTable1 tbody tr').each(function(i, tr) {
    var val = $(tr).find("td:nth-child(3)").text();
    var dateVal = moment(val, "DD.MM.YYYY", true);
    var visible = (dateVal.isBetween(dateFrom, dateTo, null, [])) ? "" : "none"; // [] for inclusive
    $(tr).css('display', visible);
    if (visible==""){
      count+=1;
    }
  });

  document.getElementById('drugCount1').innerText = count + ' drugs';
}

$('#datefilterfrom1').on("change", filterRows1);
$('#datefilterto1').on("change", filterRows1);