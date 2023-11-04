<div>
    
<div class="row mb-2 mb-xl-3">
    <div class="col-auto d-none d-sm-block">
        <h3><strong>{{$lang->data['stock_report'] ?? 'Stock Report'}}</strong></h3>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card p-0">
            <div class="card-header p-3">
                <div class="row">
                    <div class="col-md-2">
                        <label>{{$lang->data['select_product'] ?? 'Select Product'}}</label>
                        <select class="form-select" wire:model="product_id">
                            <option value="ALL">{{$lang->data['all_products']??'All Products'}}</option>
                            @foreach ($product as $item)
                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                       <br>
                        <a href="#" class="btn btn-primary" wire:click='getData'>{{$lang->data['search'] ?? 'Search'}}</a>
                    </div>
                    <div class="col-md-2">
                    </div>
                    <div class="col-md-2">
                    </div>
                    <div class="col-md-2">
                    </div>
                    <div class="col-md-2">
                        <br>
                        <a href="#" class="btn btn-primary" wire:click="exportToExcel">{{$lang->data['excel'] ?? 'Excel'}}</a>
                        <a href="#" class="btn btn-primary" wire:click="exportToPDF">{{$lang->data['pdf'] ?? 'PDF'}}</a>
                    </div>
                    
                </div>
            </div>

            <div class="card-body p-0">
                <div class="table-responsive">
                <table id="table" class="table table-striped table-sm table-bordered mb-0">
                    <thead class="bg-secondary-light">
                        <tr>
                            <th class="tw-2">{{$lang->data['sl'] ?? 'Sl'}}</th>
                            <th class="tw-25">{{$lang->data['name'] ?? 'Product Name'}}</th>
                            <th class="tw-10">{{$lang->data['quantity'] ?? 'Quantity'}}</th>
                            <th class="tw-10">{{$lang->data['quantity'] ?? 'Date'}}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $item)
                        <tr>
                            <td>{{$loop->index + 1}}</td>
                            <td>{{$item->product->name}}</td>
                            <td>{{$item->quantity}}/{{$item->product->unit}}</td>
                            <td>{{$item->created_at}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @if(count($data) == 0)
                    <x-no-data-component message="{{$lang->data['no_data_found'] ?? 'No data found..'}}" />
                @endif
            </div>
        </div>
    </div>
</div>

</div>
</div>