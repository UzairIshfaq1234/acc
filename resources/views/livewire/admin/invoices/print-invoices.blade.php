<div>
@if($printer == 1)
<div class="card">
        <div class="card-body">
        <div class="invoice-box table-height">
                        <table cellpadding="0" cellspacing="0"
                            class="view-table">
                            <tbody>
                                <tr class="top">
                                    <td colspan="6" class="view-td1">
                                        <table class="view-table1">
                                            <tbody>
                                                <tr>
                                                    <td
                                                        class="view-td2">
                                                        <font class="view-f1">
                                                            <font
                                                                class="view-f2">
                                                                {{$lang->data['customer_info'] ?? 'Customer Info'}}
                                                            </font>
                                                        </font><br>
                                                        <font class="view-align1">
                                                            <font
                                                                class="view-f3">
                                                                {{ $invoice->customer->name }}
                                                            </font>
                                                        </font><br>
                                                        <font class="view-align1">
                                                            <font
                                                            class="view-f3">
                                                                @if ($invoice->address)
                                                                    {{ $invoice->address }}
                                                                @else
                                                                    -
                                                                @endif
                                                            </font>
                                                        </font><br>
                                                    </td>
                                                    <td
                                                        class="view-f4">
                                                        <font class="view-f5">
                                                            <font
                                                                class="view-f6">
                                                                {{$lang->data['company_info'] ?? 'Company Info'}}</font>
                                                        </font><br>
                                                        <font class="view-align1">
                                                            <font
                                                                class="view-f3">
                                                                {{$store_name}} </font>
                                                        </font><br>
                                                        <font class="view-align1">
                                                            <font
                                                                class="view-f3">
                                                                {{$store_email}}</font>
                                                        </font><br>
                                                        <font class="view-align1">
                                                            <font
                                                                class="view-f3">
                                                                {{$store_phone}}</font>
                                                        </font><br>
                                                    </td>
                                                    <td
                                                        class="view-f7">
                                                        <font class="view-f8">
                                                            <font
                                                                class="view-f6 ">
                                                                {{$lang->data['invoice_info'] ?? 'invoice Info'}}</font>
                                                        </font><br>
                                                        <font class="view-align1">
                                                            <font
                                                                class="view-f3">
                                                                {{$lang->data['invoice_no'] ?? 'invoice No'}}: </font>
                                                        </font><br>
                                                        <font class="view-align1">
                                                            <font
                                                                class="view-f3">
                                                                {{$lang->data['date'] ?? 'Date'}}:</font>
                                                        </font><br>
                                                    </td>
                                                    <td
                                                        class="view-f9">
                                                        <font class="view-f10">
                                                            <font
                                                                class="view-f11">
                                                                &nbsp;</font>
                                                        </font><br>
                                                        <font class="view-align1">
                                                            <font
                                                                class="view-f3">
                                                                {{ $invoice->invoice_number }}@if($no!=0)-{{$no}}@endif </font>
                                                        </font><br>
                                                        <font class="view-align1">
                                                            <font
                                                                class="view-f3">
                                                                {{ $invoice->date }}</font>
                                                        </font><br>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
            <div class="row">
                <table class="table table-striped table-binvoiceed table-sm">
                    <thead class="bg-secondary-light">
                        <tr class="text-sm">
                            <th>{{$lang->data['sl'] ?? 'Sl'}}</th>
                            <th>{{$lang->data['item'] ?? 'Item'}}</th>
                            <th class="text-center">{{$lang->data['qty'] ?? 'Qty'}}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($invoice->details as $item)
                            <tr class="text-sm">
                                <td>{{ $loop->index + 1 }}</td>
                                <td>
                                    <b> {{ Str::limit($item->product->name,40) }}</b>
                                </td>
                                <td class="text-center">
                                    <span class="px-1">{{ $item->quantity }}</span>
                                </td>
                            </tr>
                        @endforeach

                        {{-- <tr class="text-sm">
                        <td>2</td>
                        <td><b> Product 1 Long Name Handilling</b> </td>
                        <td class="text-end">$200.00</td>
                        <td class="text-center">
                            <span class="px-1">2</span>
                        </td>
                        <td class="text-end">$400.00</td>
                    </tr>
                    <tr class="text-sm">
                        <td>3</td>
                        <td><b> Product 1 Long Name Handilling</b> </td>
                        <td class="text-end">$200.00</td>
                        <td class="text-center">
                            <span class="px-1">2</span>
                        </td>
                        <td class="text-end">$400.00</td>
                    </tr> --}}

                    </tbody>
                    <tfoot>
                        
                        {{-- <tr>
                            <td colspan="5" class="text-end">{{$lang->data['tax_total'] ?? 'Tax Total'}}
                                ({{ number_format($invoice->sales_tax, 2) }}%):</td>

                            <td class="text-end">{{getCurrency()}}{{ number_format($invoice->tax_amount, 2) }}</td>
                        </tr>
                        <tr>
                            <td colspan="5" class="text-end">{{$lang->data['subtotal'] ?? 'Sub Total'}}:</td>

                            <td class="text-end">{{getCurrency()}}{{ number_format($invoice->sub_total, 2) }}</td>
                        </tr>
                        <tr>
                            <td colspan="5" class="text-end">{{$lang->data['discount'] ?? 'Discount'}}
                            ({{ number_format($invoice->discount, 2) }}%):</td>

                            <td class="text-end">{{getCurrency()}}{{ number_format($invoice->discount_amount, 2) }}</td>
                        </tr> --}}
                        @php
                            $total=($invoice->total_amount/100)*$percentage;
                        @endphp
                        <tr>
                            <td colspan="2" class="text-end"><strong>{{$lang->data['bill_total'] ?? $percentage.'% Bill Amount'}}:</strong></td>

                            <td class="text-end"><strong>{{getCurrency()}}{{ number_format($total, 2) }}</strong></td>
                        </tr>

                    </tfoot>
                </table>
            </div>






        </div>
    </div>
    @endif
   <script type="text/javascript">
    "use strict";
       window.onload = function() {
           window.print();
           setTimeout(function() {
               window.close();
           }, 1);
       }
   </script>
                        </div>