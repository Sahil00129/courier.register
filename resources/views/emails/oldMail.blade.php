<!DOCTYPE html>
<html>
<head>
<style>
table {
  font-family: arial, sans-serif;
  border-collapse: collapse;
  width: 500px;
  margin: auto;
  font-size: 14px;
}
.heading {
background: #005453;
width: 150px;
font-weight: 500;
color: #fff;
}

td, th {
v-align: middle;
  border: 1px solid #dddddd;
  text-align: left;
  padding: 8px;
}
td p{
margin: 0;
max-width: 300px;
}

</style>
</head>
<body>

<table>
<tr>
<td>
<h2>HTML Table</h2>
</td>
</tr>
<tr>
<td>
    <table role="presentation" border="0" cellpadding="0" cellspacing="0" class="body">

  <tr>
    <td class="heading">Alfreds Futterkiste</td>
    <td valign="center"><p>dsfdsfdsfdsf</p></td>
  </tr>
  <tr>
    <td class="heading">Alfreds Futterkiste</td>
    <td valign="center"><p>dsfdsfdsfdsf</p></td>
  </tr>
  <tr>
    <td class="heading">Alfreds Futterkiste</td>
    <td valign="center"><p>dsfdsfdsfdsf</p></td>
  </tr>
  <tr>
    <td class="heading">Alfreds Futterkiste</td>
    <td valign="center"><p>dsfdsfdsfdsf</p></td>
  </tr>
  <tr>
    <td class="heading">Alfreds Futterkiste</td>
    <td valign="center"><p>dsfdsfdsfdsf</p></td>
  </tr>
  <tr>
    <td class="heading">Alfreds Futterkiste</td>
    <td valign="center"><p>dsfdsfdsfdsf</p></td>
  </tr>
</table>
</td>
</tr>
</table>

</body>
</html>






<!DOCTYPE html>
<html>
<head>
<style>
table {
  font-family: arial, sans-serif;
  border-collapse: collapse;
  width: 500px;
  margin: auto;
  font-size: 14px;
}
.heading {
background: #005453;
width: 150px;
font-weight: 500;
color: #fff;
}

td, th {
  border: 1px solid #dddddd;
  text-align: left;
  padding: 8px;
  word-wrap: break-word;
}

</style>
</head>
<body>

Dear Sir,

Below is the report generated from DP Portal for the UNIDs exceeding their pre-set TAT and required<br/> 
immediate attention. 

<table>
<tr>
<td>
<!-- <h2>HTML Table</h2> -->
</td>
</tr>
<tr>
<td>
    <table role="presentation" border="0" cellpadding="0" cellspacing="0" class="body">
  
  <tr>
    <td class="heading">Received </td>
    <td>{{$terMailData['received']}}</td>
  </tr>
  <tr>
    <td class="heading">Handover</td>
    <td>{{$terMailData['handover']}}</td>
  </tr>
  <tr>
    <td class="heading">Finfect</td>
    <td>{{$terMailData['finfect']}}</td>
  </tr>
  <tr>
    <td class="heading">Unknown</td>
    <td>{{$terMailData['unknown']}}</td>
  </tr>
  <tr>
    <td class="heading">Rejected</td>
    <td>{{$terMailData['rejected']}}</td>

  </tr>
  <tr>
    <td class="heading">Failed</td>
    <td>{{$terMailData['failed']}}</td>
  </tr>
  <tr>
    <td class="heading">Pay Later</td>
    <td>{{$terMailData['paylater']}}</td>
  </tr>
  <tr>
    <td class="heading">Full & Final</td>
    <td>{{$terMailData['full_n_final']}}</td>
  </tr>
</table>
</td>
</tr>
</table>

</body>
</html>
