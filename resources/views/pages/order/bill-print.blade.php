<?xml version="1.0" encoding="iso-8859-1"?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
   <head>
      <title>ACS #75698 (BOL) - 2001 Logistics Limited</title>
      <link rel="stylesheet" href="{{ asset('admin/css/print.css') }}" type="text/css" />
   </head>
   <body>
      <div class="header">
         <div class="header_c1">
            <img src="{{asset('admin/images/logo.png')}}" alt="Logo" width="80%" />
         </div>
         <div class="header_c2">
            TEL: (416) 293 0008<br />
            Email: ops@thrustlogistics.com<br />
            Web: www.thrustlogistics.com<br />
            <div class="order_id">No: {{ $objData->id }}</div>
         </div>
      </div>
      <div class="center">
        @php 
        $is_local = ($objData->is_local) ? 'on' : 'off';
    @endphp
         <span class="checkbox"
            ><img src="{{ asset('admin/images/checkbox_'.$is_local.'.gif') }}" />&nbsp;Local</span
            >
            @php 
            $is_domestic = ($objData->is_domestic) ? 'on' : 'off';
        @endphp
            <span class="checkbox"
            ><img src="{{ asset('admin/images/checkbox_'.$is_domestic.'.gif') }}" />&nbsp;Domestic</span
            >
            @php 
            $is_international = ($objData->is_international) ? 'on' : 'off';
        @endphp
         <span class="checkbox"
            ><img src="{{ asset('admin/images/checkbox_'.$is_international.'.gif') }}" />&nbsp;International</span
            >
      </div>
      <table width="100%">
         <tr>
            <td width="90%" align="center" style="padding-left: 8%">
               <h1>STRAIGHT BILL OF LADING / CONDITIONS OF CARRIAGE</h1>
            </td>
            <td width="10%">
               <h2>24/7&nbsp;Day</h2>
            </td>
         </tr>
      </table>
      <div class="r1">
         <div class="r1_c1">BILL OF LADING</div>
         <div class="r1_c2">NOT NEGOTIABLE B/L No.</div>
      </div>
      <table class="border_1111">
         <tr>
            <td width="40%" class="border_0100">
               <table class="data">
                  <tr>
                     <td>
                        <b>Shipper agent (name & address)</b>
                        <div class="data_address">
                           {{ $objData->from_company }}<br />
                           {{ $objData->from_address }}<br />
                           {{ $objData->from_address2 }}<br />
                           {{ $objData->from_city }} , {{ $objData->from_state }}, {{ $objData->from_postal }}
                           <br />{{ $objData->from_country->name }}
                        </div>
                     </td>
                  </tr>
                  <tr>
                     <td class="border_1000">
                        <b>Consignee agent (name & address)</b>
                        <div class="data_address">
                            {{ $objData->from_company }}<br />
                            {{ $objData->from_address }}<br />
                            {{ $objData->from_address2 }}<br />
                            {{ $objData->from_city }} , {{ $objData->from_state }}, {{ $objData->from_postal }}
                            <br />{{ $objData->from_country->name }}
                        </div>
                     </td>
                  </tr>
               </table>
            </td>
            <td width="60%">
               <table class="data">
                  <tr>
                     <td with="35%"><b>Shipper's A/C #</b><br />{{ $objData->lading_shiperno }}</td>
                     <td with="30%" class="border_0101">
                        <b>Date</b><br />
                        {{ date('d M Y',strtotime($objData->from_date)) }}
                     </td>
                     <td with="35%"><b>Customer A/C #</b><br />{{ $objData->lading_customerno }}</td>
                  </tr>
                  <tr>
                     <td colspan="3" class="border_1010">
                        <b>Name of Carrier</b><br />
                        &nbsp;
                     </td>
                  </tr>
                  <tr>
                     <td colspan="3">
                        <div class="small">
                           RECEIVED, subject to the classifications and tariffs in effect
                           on the date of the receipt by the carrier of the goods
                           described in this Original Bill of Lading
                        </div>
                        <div class="small">
                           Received at the point of origin on the date specified, from
                           the consignor mentioned herein, the property herein described,
                           in apparent good order, except as noted (contents and
                           conditions of contents of package unknown) marked, consigned
                           and destined as indicated below, which the carrier agrees to
                           carry and to deliver to the consignee at the said destination,
                           if on its own authorized route or otherwise to cause to be
                           carried by another carrier on the route to said destination,
                           subject to the rates and classification in effect on the date
                           of shipment.
                        </div>
                        <div class="small">
                           It is mutually agreed, as to each carrier of all or any of the
                           goods over all or any portion of the route to destination, and
                           as to each party or any time interested in all or any of the
                           goods, that every service to be performed hereunder shall be
                           subject to all conditions not prohibited by law, whither
                           printed or written, in conditions on that hereof, which are
                           hereby agreed by the consignor and accepted for himself and
                           his assigns.
                        </div>
                     </td>
                  </tr>
               </table>
            </td>
         </tr>
      </table>
      <br />
      <table class="data">
         <tr>
            <td width="12%" class="border_1111"><b>Pieces</b></td>
            <td width="50%" class="border_1111">
               <b>Description / Special Instructions</b>
            </td>
            <td width="19%" class="border_1111"><b>Weight lbs./Kg.</b></td>
            <td width="19%" class="border_1111"><b>Dimensions</b></td>
         </tr>
         <tr height="80px">
            <td class="border_1111">{{ $objData->lading_pcs }}</td>
            <td class="border_1111">{{ $objData->lading_desc }}</td>
            <td class="border_1111">{{ $objData->lading_weight }}</td>
            <td class="border_1111">{{ $objData->lading_dim }}</td>
         </tr>
      </table>
      <br />
      <table class="data">
         <tr>
            <td width="20%" class="border_1001"><b>Customer PO#:</b></td>
            <td width="30%" class="border_1000"></td>
            <td width="50%" class="border_1111" rowspan="5">{{ $objData->lading_customerno }}&nbsp;</td>
         </tr>
         <tr>
            <td class="border_0001"><b>Order No:</b></td>
            <td>{{ $objData->lading_orderno }}</td>
         </tr>
         <tr>
            <td class="border_0001"><b>Note No:</b></td>
            <td>{{ $objData->lading_noteno }}</td>
         </tr>
         <tr>
            <td class="border_0001"><b>ACS Pro No:</b></td>
            <td>{{ $objData->lading_acsprono }}</td>
         </tr>
         <tr>
            <td class="border_0011" colspan="2">
               <b>Fragile; Please Handle With Extra Care</b>
            </td>
         </tr>
      </table>
      <br />
      <table class="data">
         <tr>
            <td width="75%" class="border_1111">
               NOTICE OF CLAIM
               <div class="small">
                  a) No carrier is liable for loss, damage or delay to any goods
                  carried under the Bill of Lading unless notice thereof setting out
                  particulars of the origin, destination and date of shipment of the
                  goods and the estimated amount claimed in respect of such loss,
                  damage or delay is given in writing to the originating carrier or
                  the delivering carrier within sixty (60) days after the delivery of
                  the goods, or, in case of failure to make delivery, within nine (9)
                  months from the date of shipment.
                  <br /><br />
                  b) The final statement of the claim must be within (9) months from
                  the date of shipment together with a copy of the paid freight bill.
               </div>
            </td>
            <td width="25%" class="border_1111">
               <div class="small">
                  Declare Valuation $<br />
                  <hr />
                  Maximum liability shall not exceed $4.41 per kilogram (2.00 per
                  pound) computed on the total weight of the loss or damaged shipment
                  unless declared valuation states otherwise.
               </div>
            </td>
         </tr>
      </table>
      <br />
      <table class="data">
         <tr>
            <td width="22%" class="border_1111">
               <table class="sign">
                  <tr>
                     <td width="30">&nbsp;</td>
                     <td>Shipper</td>
                  </tr>
                  <tr height="25">
                     <td>DATE</td>
                     <td class="border_0010">&nbsp;</td>
                  </tr>
                  <tr height="25">
                     <td>PER</td>
                     <td class="border_0010">&nbsp;</td>
                  </tr>
               </table>
            </td>
            <td width="22%" class="border_1111">
               <table class="sign">
                  <tr>
                     <td width="30">&nbsp;</td>
                     <td>Carrier</td>
                  </tr>
                  <tr height="25">
                     <td>DATE</td>
                     <td class="border_0010">&nbsp;</td>
                  </tr>
                  <tr height="25">
                     <td>PER</td>
                     <td class="border_0010">&nbsp;</td>
                  </tr>
               </table>
            </td>
            <td width="22%" class="border_1111">
               <table class="sign">
                  <tr>
                     <td width="30">&nbsp;</td>
                     <td>Consignee</td>
                  </tr>
                  <tr height="25">
                     <td>DATE</td>
                     <td class="border_0010">&nbsp;</td>
                  </tr>
                  <tr height="25">
                     <td>PER</td>
                     <td class="border_0010">&nbsp;</td>
                  </tr>
               </table>
            </td>
            <td width="18%" class="border_1010">
                @php 
                  $is_prepaid = ($objData->is_prepaid) ? 'on' : 'off';
              @endphp
               <span class="checkbox"
                  ><img src="{{ asset('admin/images/checkbox_'.$is_prepaid.'.gif') }}" />&nbsp;PREPAID</span
                  ><br />
                  @php 
                  $is_collect = ($objData->is_collect) ? 'on' : 'off';
              @endphp
               <span class="checkbox"
                  ><img src="{{ asset('admin/images/checkbox_'.$is_collect.'.gif') }}" />&nbsp;COLLECT</span
                  ><br />
                  @php 
                  $is_thirdparty = ($objData->is_thirdparty) ? 'on' : 'off';
              @endphp
               <span class="checkbox"
                  ><img src="{{ asset('admin/images/checkbox_'.$is_thirdparty.'.gif') }}" />&nbsp;THIRD&nbsp;PARTY</span
                  ><br />
                  @php 
                        $is_cod = ($objData->is_cod) ? 'on' : 'off';
                    @endphp
                  <span class="checkbox"
                  ><img src="{{ asset('admin/images/checkbox_'.$is_cod.'.gif') }}" />&nbsp;COD</span
                  ><br />
            </td>
            <td width="15%" class="border_1110">
                @php 
                    $is_ground = ($objData->is_ground) ? 'on' : 'off';
                @endphp
                <span class="checkbox"
                  ><img src="{{ asset('admin/images/checkbox_'.$is_ground.'.gif') }}" />&nbsp;GROUND</span
                  ><br />
                @php 
                    $is_air = ($objData->is_air) ? 'on' : 'off';
                @endphp
                  <span class="checkbox"
                  ><img src="{{ asset('admin/images/checkbox_'.$is_air.'.gif') }}" />&nbsp;AIR</span
                  ><br />
                @php 
                    $is_insurance = ($objData->is_insurance) ? 'on' : 'off';
                @endphp
               <span class="checkbox"
                    ><img src="{{ asset('admin/images/checkbox_'.$is_insurance.'.gif') }}" />&nbsp;INSURANCE</span
                  ><br />
               ${{ $objData->cod_amt }}<br />
               <hr />
            </td>
         </tr>
      </table>
   </body>
</html>