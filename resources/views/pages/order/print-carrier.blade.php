<?xml version="1.0" encoding="iso-8859-1"?>
<!DOCTYPE html>
<html>
   <head>
      <title>ACS #{{ $objData->order->id }} (CC) - {{ $objData->carrier->company }}</title>
      <link rel="stylesheet" href="{{ asset('admin/css/print.css') }}" type="text/css" />
   </head>
   <body>
      <div class="header1">
         <div class="header1_c1">
            <img src="{{asset('admin/images/logo.png')}}" alt="Thrust Logo" width="59%" />
         </div>
         <div class="header1_c2">
            <h1>CARRIER CONFIRMATION</h1>
         </div>
      </div>
      <div class="r2">
         Tel (416) 293 0008 &nbsp;&nbsp;&nbsp;&nbsp;Email: ops@thrustlogistics.com &nbsp;&nbsp;&nbsp;&nbsp; Web: www.thrustlogistics.com
      </div>
      <div class="r3">
         <div class="r3_c1">
            Confirmation #: &nbsp;&nbsp;<b style="font-size:16px;">{{ $objData->order->id }}</b>
         </div>
         <div class="r3_c2">
            Dispatcher: {{ $objData->dispatch->name }}
         </div>
         <div class="r3_c3">
            Date: &nbsp;&nbsp;<b>{{ date('d M Y',strtotime($objData->order->order_datetime)) }}</b>
         </div>
      </div>
      <table class="data">
         <tr>
            <td width="20%"><b>CARRIER:</b></td>
            <td width="30%">{{ $objData->carrier->company }}</td>
            <td width="20%"><b>TEL:</b></td>
            <td width="30%">{{ $objData->carrier_phone }}</td>
         </tr>
         <tr>
            <td width="20%"><b>CONTACT:</b></td>
            <td width="30%">>{{ $objData->carrier_contact }}</td>
            <td width="20%"><b>FAX:</b></td>
            <td width="30%">{{ $objData->carrier_fax }}</td>
         </tr>
         <tr>
            <td width="20%"><b>EQUIPMENT:</b></td>
            <td width="30%">{{ $objData->carrier_equipment }}</td>
            <td width="20%"><b>AGREED RATE:</b></td>
            <td width="30%">${{ $objData->agreed_price }} {{ $objData->currency->code }}&nbsp; @if($objData->is_all_inclusive)(all&nbsp;inclusive)@endif</td>
         </tr>
      </table>
      <br />
      <table class="data">
         <tr>
            <td width="10%" class="border_1000">DATE:</td>
            <td width="40%" class="border_1100">{{ date('d M Y',strtotime($objData->order->from_date)) }} </td>
            <td width="10%" class="border_1000">DATE:</td>
            <td width="40%" class="border_1000">{{ date('d M Y',strtotime($objData->to_date)) }} </td>
         </tr>
         <tr>
            <td>COMPANY:</td>
            <td class="border_0100">{{ $objData->order->from_company }}</td>
            <td>COMPANY:</td>
            <td>{{ $objData->to_company }}</td>
         </tr>
         <tr>
            <td>ADDRESS:</td>
            <td class="border_0100">{{ $objData->order->from_address }}<br>{{ $objData->order->from_address2 }}<br>{{ $objData->order->from_city }}, {{ $objData->order->from_state }}, {{ $objData->order->from_postal }}</td>
            <td>ADDRESS:</td>
            <td>{{ $objData->to_address }}<br>{{ $objData->to_address2 }}<br>{{ $objData->to_city }}, {{ $objData->to_state }}, {{ $objData->to_postal }}</td>
         </tr>
         <tr>
            <td>TEL:</td>
            <td class="border_0100">{{ $objData->order->from_phone }}</td>
            <td>TEL:</td>
            <td>{{ $objData->to_phone }}</td>
         </tr>
         <tr>
            <td>CONTACT:</td>
            <td class="border_0100">{{ $objData->order->from_contact }}</td>
            <td>CONTACT:</td>
            <td>{{ $objData->to_contact }}</td>
         </tr>
         <tr>
            <td colspan="2" class="border_0100">&nbsp;</td>
            <td colspan="2">&nbsp;</td>
         </tr>
         <tr>
            <td colspan="2" class="border_0100" style="text-decoration : underline;">PICK-UP INSTRUCTIONS:</td>
            <td colspan="2" style="text-decoration : underline;">DELIVERY INSTRUCTIONS:</td>
         </tr>
         <tr height="150">
            <td class="border_0110" colspan="2">{{ $objData->from_instructions }}&nbsp;</td>
            <td class="border_0010" colspan="2">{{ $objData->to_instructions }}&nbsp;</td>
         </tr>
      </table>
      <br />
      <table class="data">
         <tr>
            <td width="20%"><b>CUSTOMS BROKER:</b></td>
            <td width="30%"><input name="cbroker" type="text" value="" class="inputbox_width_100" maxlength="25" /></td>
            <td width="20%"><b>TEL:</b></td>
            <td width="30%"><input name="cbroker_phone" type="text" value="" class="inputbox_width_100" maxlength="25" /></td>
         </tr>
         <tr>
            <td width="20%"><b>CONTACT:</b></td>
            <td width="30%"><input name="cbroker_contact" type="text" value="" class="inputbox_width_100" maxlength="25" /></td>
            <td width="20%"><b>FAX:</b></td>
            <td width="30%"><input name="cbroker_fax" type="text" value="" class="inputbox_width_100" maxlength="25" /></td>
         </tr>
         <tr>
            <td colspan="4" class="border_0010">&nbsp</td>
         </tr>
      </table>
      <br />
      <div class="r4">
      THRUST LOGISTICS  BOL must be signed by shipper and consignee with legible signature and submit invoice pertaining to this order with POD and Carrier Confirmation to: accounting@thrustlogistics.com for prompt payment.
      <div class="r4">Any issues or delays relating to this order, please contact our office immediately or email: ops@thrustlogistics.com </div>
      <div class="r4"> Any form of back solicitation will result in legal actions or non payment of account. You will NOT be paid if you double broker without our written consent. </div>
      <div class="r4"> Driver/Dispatch to identify as THRUST LOGISTICS  during all correspondence with shipper/consignee.
         If pick-up and/or delivery times are not met, back charges may apply.
      </div>
   </body>