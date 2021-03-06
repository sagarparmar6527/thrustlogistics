<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Print Page</title>
</head>
<style>
 BODY {
    margin: 0px;
    padding: 5px;
    min-width:650px;
    background-color: #FFF;
}

BODY, TD, DIV {
    font-family: Arial, Helvetica, sans-serif;
    font-size: 12px;
    color: #000;
}

TABLE { border-collapse: collapse; margin: 0px; padding: 0px; border: 0px; width: 100%;}
TD {margin: 0px; padding: 0px; border: 0px; vertical-align: top;}

H1 {font-size: 16px; margin: 7px 0px;}
H2 {font-size: 14px; margin: 7px 0px;}

HR {background: #000; height:1px; border: 0px solid #000; margin-bottom: 10px;}

.main {float: left; width: 100%; display: block; text-align: left;}

.header { width: 100%; height: 120px; display: block;}
.header_1 { width: 100%; height: 100px; display: block;}
.header_11 { width: 100%; height: 135px; display: block;}
.header_c1 {float: left; width: 45%; display: block}
.header_c11 {float: left; width: 180px; display: block}
.header_c2 {float: right; width: 35%; padding-top: 15px; display: block}
.header_c21 {float: right; margin-left: 250px; padding-top: 15px; display: block}
.header_c3 {float: right; width: 35%; padding-top: 5px; display: block}

.checkbox {padding-right: 20px;}

.center {text-align: center;}

.order_id {float: left; font-size: 18px; font-weight: bold;}

.r1 { width: 100%; height: 16px; padding: 5px 0px; margin-bottom: 10px; border-top: 1px solid #000; border-bottom: 1px solid #000;}
.r1_c1 {float: left; width: 170px; font-size: 14px; font-weight: bold;}
.r1_c2 {float: left; font-size: 14px; font-weight: bold;}

table.data {border-collapse: collapse; }
table.data thead {display: table-header-group; }
table.data tbody {display: table-row-group; }
table.data th {padding: 2px 5px; font-size: 12px; font-weight: bold; text-align: left;}
table.data td {padding: 2px 5px; }
table.data tr.start_row {height: 5px;}
table.data tr.customer_row {height: 22px;}
table.data tr.customer_row td {padding: 2px 0px; }
table.data tr.total_row {font-weight: bold; height: 38px;}


div.data, div.data_address {padding-left: 20px; line-height: 16px; border-collapse: collapse; }
div.data_address {height:100px; padding-top: 10px}

div.small {padding: 5px; font-size: 10px;}

.border_1000 {border-top: 1px solid #000;}
.border_0100 {border-right: 1px solid #000;}
.border_0010 {border-bottom: 1px solid #000;}
.border_0001 {border-left: 1px solid #000;}

.border_1100 {border-top: 1px solid #000; border-right: 1px solid #000;}
.border_1110 {border-top: 1px solid #000; border-right: 1px solid #000; border-bottom: 1px solid #000;}
.border_1101 {border-top: 1px solid #000; border-right: 1px solid #000; border-left: 1px solid #000;}
.border_1011 {border-top: 1px solid #000; border-bottom: 1px solid #000; border-left: 1px solid #000;}
.border_0111 {border-right: 1px solid #000; border-bottom: 1px solid #000; border-left: 1px solid #000;}
.border_1111 {border: 1px solid #000;}
.border_1010 {border-top: 1px solid #000; border-bottom: 1px solid #000;}
.border_0101 {border-right: 1px solid #000; border-left: 1px solid #000;}
.border_0011 {border-bottom: 1px solid #000; border-left: 1px solid #000;}
.border_1001 {border-top: 1px solid #000; border-left: 1px solid #000;}
.border_0110 {border-right: 1px solid #000; border-bottom: 1px solid #000;}

table.sign td {font-weight: bold; vertical-align: bottom;}

/** Carrier Confirmation **/
.header1 { width: 100%; height: 100px; display: block;}
.header1_c1 {float: left; width: 45%; display: block}
.header1_c2 {float: right; width: 50%; padding-top: 30px; display: block}

.r2 {padding: 10px; font-size: 12px; padding: 5px 0px;}

.r3 { width: 100%; height: 16px; padding: 5px 0px; margin-bottom: 10px; border-top: 1px solid #000; border-bottom: 1px solid #000;}
.r3_c1 {float: left; width: 30%;}
.r3_c2 {float: left; width: 45%;}
.r3_c3 {float: left; width: 23%;}

.r4 {padding: 10px; font-size: 10px; padding: 5px 0px; font-weight: bold; }

.cust_name {float: left; width: 300px; font-weight: bold;}
.cust_phone {float: left; width: 150px; padding-left: 25px; background: bottom left no-repeat url(/images/icons/phone.png);}
.cust_fax {float: left; width: 150px; padding-left: 25px; background: bottom left no-repeat url(/images/icons/fax.png);}

/** Invoice **/
.header_i_1 { width: 100%; height: 100px; display: block; padding: 50px 0px 7px 0px;}
.i_addr {padding: 15px 30px 0px 0px; text-align: center;  font-size: 11px; line-height: 19px; }
.i_title {padding-top: 15px; font-size: 18px;}

.header_2 { float: left; width: 100%; height: 75px; display: block; padding-bottom: 10px;}
.header_2_1 {float: left; width: 60%; display: block; border: 1px solid #000; padding: 5px}
.header_2_1_1 {float: left; width: 50px; display: block; font-weight: bold;}
.header_2_1_2 {float: left; display: block;  padding-top: 15px;}
.header_2_2 {float: right; width: 35%; display: block; padding-top: 15px;}

.header_2_2 td {text-align: center; padding: 2px 5px; }
.header_2_2 th {text-align: center; padding: 2px 5px; font-weight: bold; font-size: 12px;}

.inputbox_width_100 {
    border : 1px solid #999;
    padding-left: 2px;
    width: 100%;
}
.drop {font-weight: bold; font-size: 14px; margin-bottom:6px;}
.drop_prompt {padding: 23px 10px 0px 0px;}
  </style>
<body>
  <div style="height:500px;">&nbsp;</div>
  <div style="width:50%;">
    <table class="data">
    <tbody><tr>
    <td width="100px"><b>Order ID:</b></td>
    <td><b>{{ $objData->id }}</b></td>
    </tr>
    <tr>
    <td>Created on:</td>
    <td>{{ $objData->order_datetime }}</td>
    </tr>
    <tr>
    <td>Customer:</td>
    <td>{{ $objData->customer->company }}</td>
    </tr>
    <tr>
    <td class="border_1001" style="font-size: 14px;"><b>Consignor:</b></td>
    <td class="border_1100" style="font-size: 14px;"><b>{{ $objData->from_company }}</b></td>
    </tr>
    <tr>
    <td class="border_0001">Address:</td>
    <td class="border_0100">{{ $objData->from_address }}</td>
    </tr>
    <tr>
    <td class="border_0001">City:</td>
    <td class="border_0100">{{ $objData->from_city }}</td>
    </tr>
    <tr>
    <td class="border_0001">Province/State:</td>
    <td class="border_0100">{{ $objData->from_state }}</td>
    </tr>
    <tr>
    <td class="border_0001">Postal/Zip Code:</td>
    <td class="border_0100">
         <table width="100%">
         <tbody><tr>
         <td width="50%" style="padding: 0px 0px;">{{ $objData->from_postal }}</td>
         <td width="50%" style="padding: 0px 0px;">
              <table width="100%">
              <tbody><tr>
              <td width="70" style="padding: 0px 0px;">Country:</td>
              <td style="padding: 0px 0px;">{{ $objData->from_country->name }}</td>
              </tr>
              </tbody></table>
    
         </td>
         </tr>
         </tbody></table>
    </td>
    </tr>
    <tr>
    <td class="border_0001">Contact:</td>
    <td class="border_0100">{{ $objData->from_contact }}</td>
    </tr>
    <tr>
    <td class="border_0011">Phone:</td>
    <td class="border_0110">{{ $objData->from_phone }}</td>
    </tr>
    
    <tr>
    <td class="border_1001" style="font-size: 14px;"><b>Consignee:</b></td>
    <td class="border_1100" style="font-size: 14px;"><b>{{ $objData->to_company }}</b></td>
    </tr>
    <tr>
    <td class="border_0001">Address:</td>
    <td class="border_0100">{{ $objData->to_address }}</td>
    </tr>
    <tr>
    <td class="border_0001">City:</td>
    <td class="border_0100">{{ $objData->to_city }}</td>
    </tr>
    <tr>
    <td class="border_0001">Province/State:</td>
    <td class="border_0100">{{ $objData->to_state }}</td>
    </tr>
    <tr>
    <td class="border_0001">Postal/Zip Code:</td>
    <td class="border_0100">
         <table width="100%">
         <tbody><tr>
         <td width="50%" style="padding: 0px 0px;">{{ $objData->to_postal }}</td>
         <td width="50%" style="padding: 0px 0px;">
              <table width="100%">
              <tbody><tr>
              <td width="70" style="padding: 0px 0px;">Country:</td>
              <td style="padding: 0px 0px;">{{ $objData->to_country->name }}</td>
              </tr>
              </tbody></table>
    
         </td>
         </tr>
         </tbody></table>
    </td>
    </tr>
    <tr>
    <td class="border_0001">Contact:</td>
    <td class="border_0100">{{ $objData->to_contact }}</td>
    </tr>
    <tr>
    <td class="border_0011">Phone:</td>
    <td class="border_0110">{{ $objData->to_phone }}</td>
    </tr>
    
    <tr>
    <td>Pieces / Weight:</td>
    <td>
         <table width="100%">
         <tbody><tr>
         <td width="50%" style="padding: 0px 0px;">{{ $objData->weight }}</td>
         <td width="50%" style="padding: 0px 0px;"></td>
         </tr>
         </tbody></table>
    </td>
    </tr>
    <tr>
    <td>Service / Content:</td>
    <td>
         <table width="100%">
         <tbody><tr>
         <td width="50%" style="padding: 0px 0px;">{{ $objData->service->name }}</td>
         <td width="50%" style="padding: 0px 0px;"></td>
         </tr>
         </tbody></table>
    </td>
    </tr>
    <tr>
    <td>Ref Number:</td>
    <td>{{ $objData->ref_number }}</td>
    </tr>
    <tr>
    <td>Comments:</td>
    <td>{{ $objData->comments }}</td>
    </tr>
    <tr>
    <td>Adjustments:</td>
    <td>{{ $objData->adjustments }}</td>
    </tr>
    </tbody></table>
    
    </div>



  
</body>
</html>