<div>
    @if($printer == 5)
   <div class="page-wrapper" style="padding:36px">
    <div class="invoice-card">
        <div class="invoice-head">
            <img src="logo.png" alt="">
            <h4>{{ $store_name }}</h4>
            <p class="my-0">{{ $address }}</p>
            <p class="my-0">{{ $store_phone }}</p><br>
            <b>{{ $store_email }}</b>
        </div>
        <div class="invoice-details" style="border-top:none;">
            <div class="invoice-list">
                <div>
                    <h4 class="text-center" >Order Invoice</h4>
                </div>
                <div class="row-data" style="border:none; margin-bottom: 1px">
                    <div class="item-info">
                        <h5 class="item-title" ><b>Order ID</b></h5>
                    </div>
                    <h5 class="my-5" ><b>{{ $order->order_number }}</b></h5>
                </div>
                <div class="row-data" style="border:none;">
                    <div class="item-info">
                        <h5 class="item-title" ><b>Order Date</b></h5>
                    </div>
                    <h5 class="my-5" >
                        <b>{{ \Carbon\Carbon::parse($order->date)->format('d/m/Y') }}</b></h5>
                </div>
                <div class="row-data">
                    <div class="item-info">
                        <h5 class="item-title" >
                            <b>
                            Customer:
                        </b>
                        </h5>
                    </div>
                    <h5 class="my-5" >{{ $order->customer_name_fn }}
                    </h5>
                </div>
                @if ($order->customer_phone)
                <div class="row-data" style="border:none;">
                    <div class="item-info">
                        <h5 class="item-title" ><b>Phone No</b></h5>
                    </div>
                    <h5 class="my-5" >
                        <b> {{ $order->customer_phone }}</b></h5>
                </div>
                @endif
                
                <div class="invoice-title" style="text-align: right">
                    <h6 class="heading1">Products</h6>
                    <h6 class="heading1 heading-child">Rate</h6>
                    <h6 class="heading1 heading-child">QTY</h6>
                    <h6 class="heading1 heading-child">Total</h6>
                </div>
            @php
                $details = App\Models\OrderDetail::where('order_id',$order->id)->get();
            @endphp
            @foreach($details as $row)
                @php
                    $item = App\Models\Product::where('id',$row->product_id)->first();
                    $total = 0;
                @endphp
                <div class="row-data"
                style="text-align: center;margin-top: 5px; padding-bottom: 8px; align-items: center">
                <div class="item-info" style="width: 82px;text-align: initial;">
                    <h5 class="item-title"><b>{{ $row->product_name }}
                        @php
                        $addons = App\Models\OrderDetailAddon::where('order_detail_id',$row->id)->get();
                        @endphp
                        @if(isset($addons) && (count($addons)>0))
                            <span class="text-xs text-uppercase fw-600 text-danger">[
                            @foreach($addons as $addon)
                            @php
                                $total = $total + $addon->addon_price;
                            @endphp
                            {{$addon->addon_name}} - {{getCurrency()}}{{$addon->addon_price}} @if(!$loop->last) , @endif
                            @endforeach
                            ]</span>
                        @endif
                        </b>
                    </h5>
                </div>
                <h5 class="my-5"><b>{{getCurrency()}}{{number_format($row->product_price,2)}}</b></h5>
                <h5 class="my-5"><b>{{$row->quantity ?? ""}}</b></h5>
                <h5 class="my-5"><b>{{getCurrency()}}{{number_format($row->item_total,2)}}</b></h5>
            </div>
            @endforeach
            </div>
            <div class="invoice-footer mb-15">
                <div class="row-data">
                    <div class="item-info">
                        <h5 class="item-title" >Sub Total:</h5>
                    </div>
                    <h5 class="my-5" >{{ getCurrency() }}
                        {{ number_format($order->subtotal, 2) }}</h5>
                </div>
                <div class="row-data">
                    <div class="item-info">
                        <h5 class="item-title" >Discount:</h5>
                    </div>
                    <h5 class="my-5" >{{ getCurrency() }}
                        {{ number_format($order->discount, 2) }}</h5>
                </div>
                <div class="row-data">
                    <div class="item-info">
                        <h5 class="item-title" >Tax
                            ({{ $order->tax_percentage }}%):</h5>
                    </div>
                    <h5 class="my-5" >{{ getCurrency() }} {{ number_format($order->tax_amount, 2) }}</h5>
                </div>
                <div class="row-data">
                    <div class="item-info">
                        <h5 class="item-title" >Gross Total:</h5>
                    </div>
                    <h5 class="my-5" >{{ getCurrency() }} {{ number_format($order->total, 2) }}
                    </h5>
                </div>
                <hr>
            </div>
            <div class="invoice_address">
                <div class="text-center">
                    <h3 class="mt-10">
                        {{ isset($site['default_thanks_message']) && !empty($site['default_thanks_message'])? $site['default_thanks_message']: '' }}
                    </h3>
                </div>
            </div>
        </div>
    </div> 
    @endif
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
                                                                {{ $order->customer_name_fn }}
                                                            </font>
                                                        </font><br>
                                                        <font class="view-align1">
                                                            <font
                                                                class="view-f3">
                                                                @if ($order->customer && $order->customer->email)
                                                                    {{ $order->customer->email }}
                                                                @else
                                                                    -
                                                                @endif
                                                            </font>
                                                        </font><br>
                                                        <font class="view-align1">
                                                            <font
                                                            class="view-f3">
                                                                @if ($order->customer_phone)
                                                                    {{ $order->customer_phone }}
                                                                @else
                                                                    -
                                                                @endif
                                                            </font>
                                                        </font><br>
                                                        <font class="view-align1">
                                                            <font
                                                            class="view-f3">
                                                                @if ($order->customer && $order->customer->address)
                                                                    {{ $order->customer->address }}
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
                                                                {{$lang->data['invoice_info'] ?? 'Invoice Info'}}</font>
                                                        </font><br>
                                                        <font class="view-align1">
                                                            <font
                                                                class="view-f3">
                                                                {{$lang->data['order_no'] ?? 'Order No'}}: </font>
                                                        </font><br>
                                                        <font class="view-align1">
                                                            <font
                                                                class="view-f3">
                                                                {{$lang->data['payment_status'] ?? 'Payment Status'}}:</font>
                                                        </font><br>
                                                        <font class="view-align1">
                                                            <font
                                                                class="view-f3">
                                                                {{$lang->data['status'] ?? 'Status'}}:</font>
                                                        </font><br>
                                                        <font class="view-align1">
                                                            <font
                                                                class="view-f3">
                                                                {{$lang->data['order_type'] ?? 'Order Type'}} / {{$lang->data['table_no'] ?? 'Table No'}}:</font>
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
                                                                {{ $order->order_number }} </font>
                                                        </font><br>
                                                        <font class="view-align1">
                                                            @if ($order->isPaid())
                                                                <font
                                                                    class="view-f3">
                                                                    {{$lang->data['paid'] ?? 'Paid'}}</font>
                                                            @else
                                                                <font
                                                                    class="text-danger">
                                                                    {{$lang->data['unpaid'] ?? 'Unpaid'}}</font>
                                                            @endif
                                                        </font><br>
                                                        <font class="view-align1">
                                                            <font
                                                                class="view-f3">
                                                                {{ $order->OrderStatusString($order->status) }}</font>
                                                        </font><br>
                                                        <font class="view-align1">
                                                            <font
                                                                class="view-f3">
                                                                {{ $order->order_type_string }}
                                                                @if ($order->order_type == \App\Models\Order::DINING)
                                                                    / {{ $order->table_no }}
                                                                @endif
                                                            </font>
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
                <table class="table table-striped table-bordered table-sm">
                    <thead class="bg-secondary-light">
                        <tr class="text-sm">
                            <th>{{$lang->data['sl'] ?? 'Sl'}}</th>
                            <th>{{$lang->data['item'] ?? 'Item'}}</th>
                            <th class="text-end">{{$lang->data['price'] ?? 'Price'}}</th>
                            <th class="text-center">{{$lang->data['qty'] ?? 'Qty'}}</th>
                            <th class="text-end">{{$lang->data['total'] ?? 'Total'}}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($order->details as $item)
                            <tr class="text-sm">
                                <td>{{ $loop->index + 1 }}</td>
                                <td>
                                    <b> {{ Str::limit($item->product_name,40) }}</b>
                                    @if ($item->addons->where('type', 1)->first())
                                        - [{{ $item->addons->where('type', 1)->first()->addon_name }}]
                                    @endif
                                    <br>
                                    @if ($item->addons->where('type', 2)->first())
                                        {{$lang->data['extra'] ?? 'extra'}}:
                                        @foreach ($item->addons->where('type', 2) as $row)
                                            {{ $row->addon_name }} : {{getCurrency()}}{{ $row->addon_price }} @if (!$loop->last)
                                                ,
                                            @endif
                                        @endforeach
                                    @endif
                                </td>
                                <td class="text-end">{{getCurrency()}}{{ number_format($item->rate, 2) }}</td>
                                <td class="text-center">
                                    <span class="px-1">{{ $item->quantity }}</span>
                                </td>
                                <td class="text-end">{{getCurrency()}}{{ number_format($item->total, 2) }}</td>
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
                        <tr>
                            <td colspan="4" class="text-end">{{$lang->data['subtotal'] ?? 'Sub Total'}}:</td>

                            <td class="text-end">{{getCurrency()}}{{ number_format($order->subtotal, 2) }}</td>
                        </tr>
                        <tr>
                            <td colspan="4" class="text-end">{{$lang->data['discount'] ?? 'Discount'}}:</td>

                            <td class="text-end">{{getCurrency()}}{{ number_format($order->discount, 2) }}</td>
                        </tr>
                        <tr>
                            <td colspan="4" class="text-end">{{$lang->data['service_charge'] ?? 'Service Charge'}}:</td>

                            <td class="text-end">{{getCurrency()}}{{ number_format($order->service_charge, 2) }}</td>
                        </tr>
                        <tr>
                            <td colspan="4" class="text-end">{{$lang->data['tax_total'] ?? 'Tax Total'}}
                                ({{ number_format($order->tax_percentage, 2) }}%):</td>

                            <td class="text-end">{{getCurrency()}}{{ number_format($order->tax_amount, 2) }}</td>
                        </tr>
                        <tr>
                            <td colspan="4" class="text-end"><strong>{{$lang->data['bill_total'] ?? 'Bill Total'}}:</strong></td>

                            <td class="text-end"><strong>{{getCurrency()}}{{ number_format($order->total, 2) }}</strong></td>
                        </tr>

                    </tfoot>
                </table>
            </div>






        </div>
    </div>
   @else
   <div class="page-wrapper" style="padding:36px;">
    <div class="invoice-card" style="border-style: dotted;border:1px solid;padding:15px;">
        <div class="invoice-head">
            <img src="logo.png" alt="">
            <h2>KOT</h2>
        </div>
        <div class="row-data" style="border:none; margin-bottom: 1px">
            <div class="item-info">
                <h5 class="item-title"><b>Order ID :</b></h5>
            </div>
            <h5 class="my-5"><b>{{ $order->order_number }}</b></h5>
        </div>
        <div class="row-data" style="margin-bottom: 1px">
            <div class="item-info">
                <h5 class="item-title"><b>Current Status :</b></h5>
            </div>
            <h5 class="my-5"><b>{{$order->OrderStatusString($order->status) }}</b></h5>
        </div>
        @if($order->order_type == 1)
        <div class="row-data" style="margin-bottom: 1px">
            <div class="item-info">
                <h5 class="item-title"><b>Table No : </b></h5>
            </div>
        
            <h5 class="my-5"><b>{{$order->table_no}}</b></h5>
        </div>
        @endif
        <div class="row-data" style="margin-bottom: 1px;;border-bottom: 2px solid black;">
            <div class="item-info">
                <h5 class="item-title"><b>Order Type :</b></h5>
            </div>
            <h5 class="my-5"><b>{{ $order->order_type_string }}</b></h5>
        </div>
        <div class="invoice-title" style="text-align: right">
            <h6 class="heading1">Products</h6>
            <h6 class="heading1 heading-child">QTY</h6>
        </div>
        @php
            $details = App\Models\OrderDetail::where('order_id',$order->id)->get();
        @endphp
        @foreach($details as $row)
            @php
                $item = App\Models\Product::where('id',$row->product_id)->first();
                $total = 0;
            @endphp
            <div class="row-data"
                style="text-align: center; align-items: center; margin-top:0px; padding-top:0px;">
                <div class="item-info" style="width: 150px;text-align: initial;">
                    <h5 class="item-title"><b>{{$loop->index+1}}. {{ $row->product_name }}
                        
                </b></h5>
                </div>
                <h5 class=""><b>{{$row->quantity ?? ""}}</b></h5>
            </div>
            @php
            $addons = App\Models\OrderDetailAddon::where('order_detail_id',$row->id)->get();
            @endphp
            @if(isset($addons) && (count($addons)>0))
                <span class="text-xs text-uppercase fw-600 text-danger" style="font-size: 12px;">[
                @foreach($addons as $addon)
                @php
                    $total = $total + $addon->addon_price;
                @endphp
                {{$addon->addon_name}} - 1 @if(!$loop->last) , @endif
                @endforeach
                ]</span> 
            @endif
        @endforeach
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
