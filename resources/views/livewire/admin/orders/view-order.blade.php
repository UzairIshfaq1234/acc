<div>
    <div class="row mb-2 mb-xl-3">
        <div class="col d-none d-sm-block">
            <h3><strong>{{$lang->data['order_no'] ?? 'Order No'}}: {{ $order->order_number }}</strong></h3>
        </div>
        <div class="col-auto ms-auto text-end mt-n1">
            <a href="{{ url('/admin/orders/print/'.$order->id.'/1') }}" target="__blank" class="btn btn-success">{{$lang->data['print_invoice'] ?? 'Print Invoice'}}</a>
            <a href="{{ url('/admin/orders/print/'.$order->id.'/2')  }}" target="__blank" class="btn btn-primary">{{$lang->data['print_kot'] ?? 'Print Kot'}}</a>
            <a href="{{ route('admin.orders') }}" class="btn btn-dark">{{$lang->data['back'] ?? 'Back'}}</a>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-12">
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
        </div>

    </div>
</div>
