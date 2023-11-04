<div>
    <div class="wrapper">
        <div class="main">
            <livewire:components.header />
            <main class="content p-0">
                <div class="container-fluid p-0">
                    <div class="row box-height">
                        <div class="col-md-8 p-0">
                            <div class="card mb-0 rounded-0 shadow-none">
                                <div class="card-header border-b-1">
                                    <div class="row">
                                        <div class="col-md-8">
                                            <input type="text" class="form-control" placeholder="{{$lang->data['search_product_or_barcode'] ?? 'Search Product Or BarCode'}}"
                                                wire:model="search">
                                        </div>
                                        <div class="col-md-4">
                                            <select class="form-select" wire:model="selected_category">
                                                <option value="all">{{$lang->data['all_category']??'All Category'}}</option>
                                                @foreach ($categories as $item)
                                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="card-scrollbar card-scroll-y">
                                        <div class="row">
                                            @foreach ($products as $item)
                                            <div class="col-lg-2 col-6">
                                                <div class="card item-card shadow">
                                                    <div class="card-body p-0" wire:click="incrementProduct({{ $item->id }})">
                                                        <img src="{{ $item->photo() }}" class="img-fluid" alt="">
                                                        <div class="info">
                                                            <h5 class="name">{{ $item->name }}</h5>
                                                            <h6 class="mb-0 price">
                                                                <img class="@if ($item->is_veg != 1) nonveg @endif"
                                                                    src="{{ asset('assets/img/icons/veg.png') }}"
                                                                    alt="">
                                                                {{ getCurrency() }}{{ $item->price }} <span style="color: green;">{{$lang->data['available']??'Available'}}</span>:{{ $item->quantity }}
                                                            </h6>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            @endforeach
                                            @if (count($products) == 0)
                                                <x-no-data-component message="{{$lang->data['no_items_found']??'No Items Were Found'}}" />
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 p-0 border-l">
                            <div class="card mb-0 rounded-0 shadow-none">
                                <div class="card-body pb-0">
                                    <div class="row mb-1">
                                        <div class="col d-relative">
                                            <input type="text" class="form-control"
                                                placeholder="@if ($selected_customer) {{ $selected_customer->name }}(Loyalty Points:{{ $selected_customer->loyalty_points }}) @else {{$lang->data['walk_in_customer'] ?? 'Walk-In Customer'}} @endif"
                                                wire:model="customer_search">
                                            @if ($customers && count($customers) > 0)
                                                <div class="dropdown show">
                                                    <ul class="dropdown-menu show searchdropdown-custom">
                                                        @foreach ($customers as $item)
                                                            <li><a class="dropdown-item" href="#"
                                                                    wire:click="selectCustomer({{ $item }})">{{ $item->name }}</a>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            @endif
                                        </div>
                                        @if(Auth::user()->can('add_customer'))
                                        <div class="col-auto">
                                            <button type="button" class="btn btn-success mb-0 float-end"
                                                data-bs-toggle="modal" data-bs-target="#ModalCustomer"
                                                wire:click="resetCustomerFields">{{$lang->data['add']??'Add'}}</button>
                                        </div>
                                        @endif
                                    </div>
                                    <div class="row">
                                        <div class="col-8">
                                            <label class="form-label text-sm">{{$lang->data['order_type']??'Order Type'}} <span
                                                    class="text-danger">*</span></label>
                                            <div class="col-12">
                                                <button
                                                    class="btn @if ($order_type == \App\Models\Order::DINING) btn-secondary @else btn-light @endif btn-sm"
                                                    wire:click="changeOrderType({{ \App\Models\Order::DINING }})">{{$lang->data['dining']??'Dinning'}}</button>
                                                <button
                                                    class="btn @if ($order_type == \App\Models\Order::TAKEAWAY) btn-secondary @else btn-light @endif  btn-sm"
                                                    wire:click="changeOrderType({{ \App\Models\Order::TAKEAWAY }})">{{$lang->data['takeaway']??'Takeaway'}}</button>
                                                <button
                                                    class="btn @if ($order_type == \App\Models\Order::DELIVERY) btn-secondary @else btn-light @endif  btn-sm"
                                                    wire:click="changeOrderType({{ \App\Models\Order::DELIVERY }})">{{$lang->data['delivery']??'Delivery'}}</button>
                                            </div>
                                        </div>
                                        @if ($order_type == \App\Models\Order::DINING)
                                            <div class="col-4">
                                                <div class="row">
                                                    <label class="col text-sm-start">{{$lang->data['select_table']??'Select Table'}}:</label>
                                                    <div class="col-auto">
                                                        <select class="form-select form-select-sm"
                                                            wire:model="selected_table">
                                                            <option value="">{{$lang->data['choose_table']??'Choose Table'}}</option>
                                                            @foreach ($tables as $item)
                                                                <option value="{{ $item->id }}">
                                                                    {{ $item->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="col-12 mt-2">
                                        <div class="bill-scrollbar bill-scroll-y">
                                            <table class="table table-striped table-bordered table-sm">
                                                <thead class="bg-secondary-light">
                                                    <tr class="text-sm">
                                                        <th>{{$lang->data['sl']??'Sl'}}</th>
                                                        <th>{{$lang->data['item']??'Item'}}</th>
                                                        <th class="text-end">{{$lang->data['price']??'Price'}}</th>
                                                        <th class="text-center">{{$lang->data['qty']??'Qty'}}</th>
                                                        <th class="text-end">{{$lang->data['total']??'Total'}}</th>
                                                        <th></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($cart as $key => $item)
                                                        @php
                                                            $inlineprice = $item['product']['price'];
                                                            if ($item['variant'] != null) {
                                                                $inlineprice = $item['variant']['price'];
                                                            }
                                                            $extraprice = 0;
                                                            if ($item['extras'] != null) {
                                                                foreach ($item['extras'] as $extra) {
                                                                    $extraprice += $extra['price'];
                                                                }
                                                            }
                                                            $inlinetotal = $inlineprice * $item['quantity'] + $extraprice;
                                                            $inlineprice += $extraprice;
                                                        @endphp
                                                        <tr class="text-sm">
                                                            <td>{{ $loop->index + 1 }}</td>
                                                            <td>
                                                                <b> {{ $item['product']['name'] }}</b>
                                                                @if ($item['variant'] != null)
                                                                    - [{{ $item['variant']['name'] }}]
                                                                @endif
                                                                @if ($item['extras'] != null)
                                                                    <br>
                                                                    extra:
                                                                    @foreach ($item['extras'] as $extra)
                                                                        {{ $extra['name'] }}:
                                                                        {{ getCurrency() }}{{ $extra['price'] }}
                                                                        @if (!$loop->last)
                                                                            ,
                                                                        @endif
                                                                    @endforeach
                                                                @endif
                                                            </td>
                                                            <td class="text-end">
                                                                {{ getCurrency() }}{{ $inlineprice }}</td>
                                                            <td class="text-center">
                                                                <span class="px-1">{{ $item['quantity'] }}</span>
                                                            </td>
                                                            <td class="text-end">
                                                                {{ getCurrency() }}{{ $inlinetotal }}</td>
                                                            <td class="text-end">
                                                                <a class="action-icon"
                                                                    wire:click="removeFromCart({{ $key }})">
                                                                    <i class="fas fa-fw fa-trash-alt text-danger"></i></a>
                                                            </td>
                                                        </tr>
                                                        <tr class="text-sm">
                                                            <td colspan="6">
                                                                <div class="row">
                                                                    <div class="col-6 text-start">
                                                                        <span>Add</span>
                                                                    </div>
                                                                    <div class="col-6 text-end">
                                                                        <div class="btn-group" role="group">
                                                                            <button wire:click="decrementProduct({{ $item['product']['id'] }})"
                                                                                    class="btn btn-danger btn-sm">
                                                                                <i class="fas fa-minus"></i>
                                                                            </button>
                                                                            <span>&nbsp;&nbsp;</span>
                                                                            <button wire:click="incrementProduct({{ $item['product']['id'] }})"
                                                                                    class="btn btn-success btn-sm">
                                                                                <i class="fas fa-plus"></i>
                                                                            </button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                            @if (count($cart) == 0)
                                                <x-no-data-component message="{{$lang->data['add_something_to_cart']??'Add something to the cart!'}}" />
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 border-t fixed-bottom">
                            <div class="row box-height">
                                <div class="col-md-8 p-0">
                                    <div class="card rounded-0 shadow-none padding-l mb-0 px-4 pt-2 py-3">
                                        <div class="row">
                                            <div class="col-md-2">
                                                <p class="text-sm mb-0"><strong>{{$lang->data['subtotal']??'Sub Total'}}</strong></p>
                                                <p class="text-sm text-primary fw-bolder mb-0">
                                                    {{ getCurrency() }}{{ number_format($subtotal, 2) }}</p>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="row">
                                                    <label class="col text-sm-start">{{$lang->data['discount']??'Discount'}}:</label>
                                                    <div class="col-auto">
                                                        <input type="number" class="form-control form-control-sm"
                                                            placeholder="{{$lang->data['enter_discount']??'Enter Discount'}}" wire:model="discount">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="row">
                                                    <label class="col text-sm-start">{{$lang->data['service_charge']??'Service Charge'}}:</label>
                                                    <div class="col-auto">
                                                        <input type="number" class="form-control form-control-sm"
                                                            placeholder="{{$lang->data['enter_service_charge']??'Enter Service Charge'}}"
                                                            wire:model="service_charge">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <p class="text-sm mb-0"><strong>{{$lang->data['tax_amount']??'Tax Amount'}}
                                                        ({{ $taxpercentage }}%)</strong></p>
                                                <p class="text-sm text-dark fw-bolder mb-0">
                                                    {{ getCurrency() }}{{ number_format($tax_amount, 2) }}</p>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="row">
                                                    <label class="col text-sm-start">{{$lang->data['paid_amount']??'Paid Amount'}}:</label>
                                                    <div class="col-auto">
                                                        <input type="number" class="form-control form-control-sm"
                                                            placeholder="{{$lang->data['enter_payment'] ?? 'Enter Payment'}}" wire:model="paid_amount">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="row">
                                                    <label class="col text-sm-start">{{$lang->data['payment_type']??'Payment Type'}}:</label>
                                                    <div class="col-auto">
                                                        <select class="form-select form-select-sm"
                                                            wire:model="payment_type">
                                                            <option value="1">{{$lang->data['cash']??'Cash'}}</option>
                                                            <option value="2">{{$lang->data['card']??'Card'}}</option>
                                                            <option value="3">{{$lang->data['cheque']??'Cheque'}}</option>
                                                            <option value="4">{{$lang->data['bank_transfer']??'Bank Transfer'}}</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 p-0 border-l">
                                    <div class="card rounded-0 shadow-none mb-0 px-4 pt-2">
                                        <div class="row align-items-center px-2">
                                            <div class="col">
                                                <p class="text-sm mb-0"><strong>{{$lang->data['bill_total']??'Bill Total'}}</strong></p>
                                                <p class="text-sm text-dark fw-bolder mb-0">
                                                    {{ getCurrency() }}{{ number_format($total, 2) }}</p>
                                            </div>
                                            <div class="col-auto">
                                                <button type="button" wire:click="$emit('reloadpage')"
                                                    class="btn btn-danger me-2 mb-0">{{$lang->data['clear_all']??'Clear All'}}</button>
                                                <button type="button" class="btn btn-primary mb-0"
                                                    wire:click="placeOrder">{{$lang->data['place_order']??'Place
                                                    Order'}}</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
    <div class="modal fade" id="ModalCustomer" tabindex="-1" role="dialog" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{$lang->data['add_new_customer']??'Add New Customer'}}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="mb-3 col-md-6">
                            <label class="form-label">{{$lang->data['name']??'Name'}} <span class="text-danger"><strong>*</strong></span></label>
                            <input type="text" class="form-control" id="inputEmail4" placeholder="{{$lang->data['name']??'Name'}}" wire:model="name">
                            @error('name')
                                <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                        <div class="mb-3 col-md-6">
                            <label class="form-label">{{$lang->data['phone_number']??'Phone Number'}}<span
                                    class="text-danger"><strong>*</strong></span></label>
                            <input type="text" class="form-control" placeholder="{{$lang->data['phone']??'Phone'}}" wire:model="phone">
                            @error('phone')
                                <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">{{$lang->data['email']??'Email'}}</label>
                        <input type="text" class="form-control" placeholder="{{$lang->data['email']??'Email'}}" wire:model="email">
                        @error('email')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">{{$lang->data['address']??'Address'}}</label>
                        <textarea class="form-control resize-none" placeholder="{{$lang->data['address']??'Address'}}" wire:model="address"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{$lang->data['close']??'Close'}}</button>
                    <button type="button" class="btn btn-success" wire:click="createCustomer">{{$lang->data['save']??'Save'}}</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Product Modal -->
    <div class="modal fade" id="ModalProduct" tabindex="-1" role="dialog" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered" role="document">
            @if ($product && $addons)
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">
                            {{ $product->name }}
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        @if ($addons->where('type', 1)->count() > 0)
                            <div class="mb-2">
                                <label class="form-label">{{$lang->data['variant']??'Variant'}} <span
                                        class="text-danger"><strong>*</strong></span></label><br>
                                <small class="form-text text-muted">{{$lang->data['variant_info']??'If a variant is selected, the variant price is used
                                    instead
                                    of the product price.'}}</small><br>
                                @foreach ($addons->where('type', 1) as $item)
                                    <button
                                        class="btn mb-2 @if ($selected_variant == $item->id) bg-primary text-white @else btn-outline-primary @endif"
                                        wire:click='selectVariant({{ $item->id }})'>{{ $item->name }} (
                                        {{ getCurrency() }}{{ $item->price }})</button>
                                @endforeach
                            </div>
                        @endif
                        @if ($addons->where('type', 2)->count() > 0)
                            <div class="mb-3">
                                <label class="form-label">Extra</label><br>
                                <div>
                                    @foreach ($addons->where('type', 2) as $item)
                                        <label class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox"
                                                value="{{ $item->id }}" id="check{{ $item->id }}"
                                                wire:model="selected_extras">
                                            <span class="form-check-label">
                                                {{ $item->name }} ( {{ getCurrency() }}{{ $item->price }} )
                                            </span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{$lang->data['close']??'Close'}}</button>
                        <button type="button" class="btn btn-info"
                            wire:click="completeAddonSelection()">{{$lang->data['add']??'Add'}}</button>
                    </div>
                </div>
            @endif
        </div>
    </div>
    <!-- Cooking Status Modal -->
    <div class="modal fade" id="ModalCooking" tabindex="-1" class="md-none" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{$lang->data['today_prepration_status']??'Today Prepration Status'}}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        @foreach ($todaycooking as $order)
                        <div class="col-md-6">
                            <div class="card mb-3 bg-s-{{$order->order_status_background}} cursor-grab border">
                                <div class="card-body p-2">

                                    <div class="d-flex justify-content-between mb-2">
                                        <div>
                                            <span class="fw-bolder ms-2">{{$order->customer_name_fn}}</span>
                                            <div class="ms-2 mb-0 mt-2">
                                                <span class="text-xs">{{$lang->data['order_type']??'Order Type'}}:</span>
                                                <span class="fw-bolder text-uppercase">{{$order->order_type_string}}</span>

                                            </div>
                                            @if ($order->order_type == \App\Models\Order::DINING)
                                            <div class="ms-2 mb-0 mt-2">
                                                <span class="text-xs">{{$lang->data['table_no']??'Table No'}}:</span>
                                                <span class="fw-bolder text-uppercase">{{$order->table_no}}</span>
                                            </div>
                                            @else
                                            <div class="ms-2 mb-0 mt-2">
                                               -
                                            </div>
                                            @endif
                                        </div>
                                        <div>
                                            <span class="fw-600 text-sm ms-2">{{$lang->data['order_no']??'Order No'}}: {{$order->order_number}} </span>
                                            <div class="ms-2 mb-0 mt-2">
                                                <span class="text-xs">{{$lang->data['bill_amount']??'Bill Amount'}}: {{getCurrency()}}{{number_format($order->total,2)}}</span>
                                            </div>
                                            <div class="ms-2 mb-0 mt-2">
                                                <span class="text-xs">{{$lang->data['status']??'Status'}}: <strong>{{$order->OrderStatusString($order->status)}}</strong></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                        @if (count($todaycooking) == 0)
                            <x-no-data-component message="{{$lang->data['no_cooking_items']??'No cooking items..'}}" />
                        @endif
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{$lang->data['close']??'Close'}}</button>
                </div>
            </div>
        </div>
    </div>
</div>
