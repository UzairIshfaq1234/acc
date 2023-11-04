<div>
    <div class="row mb-2 mb-xl-3">
        <div class="col-auto d-none d-sm-block">
            <h3><strong>{{$lang->data['orders']??'Orders'}}</strong></h3>
        </div>
        @if(Auth::user()->can('add_order'))
        <div class="col-auto ms-auto text-end mt-n1">
            <a href="{{route('admin.pos')}}" class="btn btn-primary">{{$lang->data['new_order']??'New Order'}}</a>
        </div>
        @endif
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card p-0">
                <div class="card-header p-3">
                    <div class="row">
                        <div class="col-md-2">
                            <label>{{$lang->data['start_date'] ?? 'Start Date'}}</label>
                            <input type="date" class="form-control" wire:model="start_date">
                        </div>
                        <div class="col-md-2">
                            <label>{{$lang->data['end_date'] ?? 'End Date'}}</label>
                            <input type="date" class="form-control" wire:model="end_date">
                        </div>
                        <div class="col-md-2">
                            <label>{{$lang->data['search_customer'] ?? 'Search Customer'}}</label>
                            <input type="text" class="form-control" placeholder="{{$lang->data['all_customers'] ?? 'All Customers'}}" wire:model='search'>
                        </div>
                        <div class="col-md-2">
                            <label>{{$lang->data['search_order'] ?? 'Search Order'}}</label>
                            <input type="text" class="form-control" placeholder="{{$lang->data['all_orders'] ?? 'All Orders'}}" wire:model='search_order'>
                        </div>
                        <div class="col-md-2">
                        <br>
                            <a href="#" class="btn btn-primary" wire:click='getData'>{{$lang->data['search'] ?? 'Search'}}</a>
                        </div>
                        
                    </div>
                </div>
                <div class="card-body p-0">
                    <table class="table table-striped table-bordered mb-0">
                        <thead class="bg-secondary-light">
                            <tr>
                                <th class="tw-5">{{$lang->data['sl']??'Sl'}}</th>
                                <th class="tw-10">{{$lang->data['order_details']??'Order Details'}}</th>
                                <th class="tw-20">{{$lang->data['customer']??'Customer'}}</th>
                                <th class="tw-10">{{$lang->data['order_type']??'Order Type'}}</th>
                                <th class="tw-10">{{$lang->data['order_status']??'Order Status'}}</th>
                                <th class="tw-15">{{$lang->data['payment_details']??'Payment Details'}}</th>
                                <th class="tw-5">{{$lang->data['print']??'Print'}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($orders as $item)
                            <tr>
                                <td>{{$loop->index + 1}}</td>
                                <td class="d-none d-xl-table-cell">
                                    <strong>{{$lang->data['order_id']??'Order ID'}}: {{$item->order_number}}</strong>
                                    <div class="text-muted">
                                       {{$lang->data['order_date']??'Order Date'}}: {{\Carbon\Carbon::parse($item->date)->format('d/m/Y')}}
                                    </div>
                                </td>
                                <td>
                                    @if($item->customer_name)
                                        {{$item->customer_name}}
                                    @else
                                        {{$lang->data['walk_in_customer']??'Walk-In Customer'}}
                                    @endif
                                </td>
                                <td class="d-none d-xl-table-cell">
                                    <span class="badge {{$item->order_type_badge}}">{{$item->order_type_string}}</span>
                                    @if($item->order_type == \App\Models\Order::DINING)
                                    <div class="text-muted">
                                        {{$lang->data['table_no']??'Table No'}}: {{$item->table_no}}
                                    </div>
                                    @endif
                                </td>
                                <td><span class="badge {{$item->OrderStatusBadge('bg',$item->status)}}">{{$item->OrderStatusString($item->status)}}</span></td>
                                <td class="d-none d-xl-table-cell">
                                    <div class="text-muted">
                                        {{$lang->data['total']??'Total'}}: {{getCurrency()}}{{number_format($item->total,2)}}
                                    </div>
                                    <div class="text-muted">
                                        {{$lang->data['paid']??'Paid'}}: {{getCurrency()}}{{number_format($item->payments->sum('amount'),2)}}
                                    </div>
                                    <strong>{{$lang->data['balance']??'Balance'}}: {{getCurrency()}}{{number_format(($item->total - $item->payments->sum('amount')),2)}}</strong>
                                </td>
                                <td>
                                    <a href="{{route('admin.view_order',$item->id)}}" class="btn btn-sm w-100 btn-gray">{{$lang->data['print']??'Print'}}</a>
                                    @if($item->total - $item->payments->sum('amount') > 0)
                                    <a href="#" class="btn btn-sm btn-gray mt-2" data-bs-target="#ModalPayment" data-bs-toggle="modal" wire:click="viewPayment({{$item->id}})">{{$lang->data['add_payment']??'Add Payment'}}</a>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @if(count($orders) == 0)
                        <x-no-data-component message="{{$lang->data['no_orders_found']??'No orders were found..'}}" />
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="ModalPayment" tabindex="-1" role="dialog" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{$lang->data['add_payment'] ?? 'Add Payment'}}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @if($order)
                    <div class="mb-3">
                        <div class="d-flex justify-content-between">
                            <div class="">
                                {{$lang->data['order_no'] ?? 'Order No'}}
                            </div>
                            <div class="fw-bold">
                                {{$order->order_number}}
                            </div>
                        </div>
                        <div class="d-flex justify-content-between">
                            <div class="">
                                {{$lang->data['total'] ?? 'Total'}} 
                            </div>
                            <div class="fw-bold">
                                {{getCurrency()}}{{$order->total}}
                            </div>
                        </div>
                        <div class="d-flex justify-content-between">
                            <div class="">
                                {{$lang->data['paid'] ?? 'Paid'}} 
                            </div>
                            <div class="fw-bold">
                            {{getCurrency()}}{{$order->payments->sum('amount')}}
                            </div>
                        </div>
                        <div class="d-flex justify-content-between">
                            <div class="">
                                {{$lang->data['balance'] ?? 'Balance'}} 
                            </div>
                            <div class="fw-bold">
                                {{getCurrency()}}{{$order->total - $order->payments->sum('amount')}}
                            </div>
                        </div>
                    </div>
                    @endif
                    <div class="mb-2">
                        <label class="form-label">{{$lang->data['paid_amount'] ?? 'Paid Amount'}} <span class="text-danger"><strong>*</strong></span></label>
                        <input type="text" class="form-control" placeholder="{{$lang->data['enter_paid_amount'] ?? 'Enter Paid Amount'}}" wire:model="paid_amount">
                        @error('paid_amount')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="col text-sm-start">{{$lang->data['payment_type']??'Payment Type'}}:</label>
                        <div class="col-auto">
                            <select class="form-select "
                                wire:model="payment_type">
                                <option value="1">{{$lang->data['cash']??'Cash'}}</option>
                                <option value="2">{{$lang->data['card']??'Card'}}</option>
                                <option value="3">{{$lang->data['cheque']??'Cheque'}}</option>
                                <option value="4">{{$lang->data['bank_transfer']??'Bank Transfer'}}</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{$lang->data['close'] ?? 'Close'}}</button>
                    <button type="button" class="btn btn-success" wire:click='savePayment'>{{$lang->data['save'] ?? 'Save'}}</button>
                </div>
            </div>
        </div>
    </div>
</div>