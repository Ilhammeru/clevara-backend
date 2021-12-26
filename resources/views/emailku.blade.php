@component('mail::message')
 <style>
        .table {
            border: 1px solid #e2e2e2;
            margin-top: 15px;
            width: 100%;
            font-size: 94%;
        }
        .table th{
             padding: 8px 5px;
        }
        .detail th{
             padding: 5px 2px;
        }
        .table td{
             padding: 1px 5px;
        }
        .divider {
            border-bottom: 1px solid #e2e2e2;
            padding-top: 10px;
            margin-bottom: 10px;
        }
 </style>
 <center>

<p style="text-align:center">
<img src="https://storage.googleapis.com/melawaitest/mail/cash.png">
<h1 style="
text-align:center;
  /*font-family: Montserrat;*/
  font-size: 24px;
  font-weight: 500;
  font-style: normal;
  line-height: 1.42;
  letter-spacing: normal;
  color: #111010;">Hi, Segera selesaikan pembayaran anda</h1>
</p>

</center>
 <p style="text-align:left!important">
  Hi <b>Clevara</b><br>
 <p style="text-align:left!important">
Terima kasih telah berbelanja di Juragan Material, segera selesaikan pembayaran anda sebelum pukul 13.00.
<br>
<br>
      <p style="text-align:left!important">
{{--<i>Anda telah mengambil langkah pertama untuk membeli kopi gourmet kami. Pastikan Anda  menyelesaikan pembayaran sesegera mungkin dalam waktu 24 jam agar dapat menikmati kopi  berkualitas tinggi dari Sky Nine, yang dengan hati-hati kami olah untuk memberikan kopi terbaik yang  Anda dapatkan. Permintaan akan kopi kami selalu tinggi jadi pastikan Anda tidak sampai  melewatkannya.</i>--}}
{{--We have received your order with order number <b>#{{$invoice->invoice_number}}</b> on <b>{{$invoice->created_at->format("D, F d, Y H:i:s")}}</b>.--}}
<div class="divider"></div>
Klik tombol berikut untuk melakukan pembayran:<br>
{{--<i>Tekan tautan di bawah ini untuk melakukan pembayaran:--}}
 </p>

<p style="text-align:center; margin:30px 0px;">
<a style="
    width: 83px;
    height: 25px;
    margin:20px;
    padding:9px 18px;
    border-radius: 15px;
    /*font-family: Montserrat;*/
    font-weight: normal;
    font-stretch: normal;
    font-style: normal;
    line-height: 1.83;
    letter-spacing: 0.21px;
    color: whitesmoke;
        text-decoration: none;
        background-color:  #0d3f57;
        " href=""> Bayar</a>
</p>
 Berikut adalah detail transaksi anda: <br>
{{--<i>Dapatkan detil order Anda sebagai berikut:--}}

{{--<table style="margin: 25px 45px">--}}

{{--<tr>--}}
{{--<td>Total payment</td>--}}
{{--<td style="text-align:right;font-weight: bold">Rp. {{number_format($invoice->grand_total,0,".",'.')}}</td>--}}
{{--</tr>--}}
{{--</table>--}}

<table class="table" style="width: 647px; text-align:left;">
<tr style="border: 4px; padding: 8px 0px;">
<th colspan="2" width="55%" style="text-align:left;">
    Pesanan anda
</th>
<th width="17%">
Harga
</th>
<th width="10%">
Qty
</th>
<th width="30%">
Total
</th>
</tr>
@foreach($orders as $product)
<tr>
<td width="10%">
    {{-- <img src="{{$product->product->image->file??asset('images/noimage.png')}}" style="width:50px"> --}}
</td>
<td>
    {{$product['name'] ?? "error"}}<br>
{{-- <small>Code: {{$product->product->code ?? '-'}}</small> --}}
</td>
<td >
Rp.     {{number_format($product['price'] ??0,0,',','.')}}
</td>
<td >
    {{$product['qty']}}
</td>
<td >
    Rp.     {{number_format($product['total'] ??0,0,',','.')}}
</td>
</tr>
@endforeach


</table>
<table class="detail" style="width: 647px; text-align:left; font-size: 92%">
<tr style="border: 4px">
<th colspan="2" width="55%" style="text-align:left;">
</th>
<th width="17%">

</th>
<th width="10%">

</th>
<th width="30%">

</th>
</tr>
<tr>
<td >
</td>
<td>
</td>
<th colspan="3">
    Detail
</th>
</tr>

<tr>
<td ></td><td></td>
<td colspan="2">
    Subtotal
</td>
<td >
    Rp.     {{number_format($total??0,0,',','.')}}
</td>
</tr>

<tr>
<td ></td><td></td>
<td colspan="2">
    Shipping cost
</td>
<td >
    Rp.     {{number_format($shipping??0,0,',','.')}}
</td>
<tr>
<td ></td><td></td>
<td colspan="3">
 <div class="divider"></div>
</td>
</tr>
<tr>
<td ></td><td></td>
<td colspan="2">
   <b> Total</b>
</td>
<td >
   <b> Rp.     {{number_format($grandTotal??0,0,',','.')}}</b>
</td>
</tr>
<tr>
<td ></td><td></td>
<td colspan="3">
    Payment Method: Mandiri
</td>
</tr>
</table>


@endcomponent
