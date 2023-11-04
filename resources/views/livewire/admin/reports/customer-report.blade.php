<div>

    <div class="row mb-2 mb-xl-3">
        <div class="col-auto d-none d-sm-block">
            <h3><strong>{{$lang->data['customer_report'] ?? 'Customer Report'}}</strong></h3>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card p-0">
                <div class="card-header p-3">
                    <div class="row">
                        <div class="col-md-3">
                            <label>{{$lang->data['search_customer'] ?? 'Search Customer'}}</label>
                            <input type="text" class="form-control" placeholder="{{$lang->data['all_customers'] ?? 'All Customers'}}" wire:model='search'>
                        </div>
                        <div class="col-md-3">
                            <br>
                            <a href="#" class="btn btn-primary" wire:click='getData'>{{$lang->data['search'] ?? 'Search'}}</a>
                        </div>
                        <div class="col-md-3">
                        </div>
                        <div class="col-md-3">
                            <br>
                            <a href="#" class="btn btn-primary" wire:click="exportToExcel">{{$lang->data['excel'] ?? 'Excel'}}</a>
                            <a href="#" class="btn btn-primary" wire:click="exportToPDF">{{$lang->data['pdf'] ?? 'PDF'}}</a>
                        </div>
                    </div>
                </div>

                <div class="card-body p-0">
                    <table class="table table-striped table-sm table-bordered mb-0">
                        <thead class="bg-secondary-light">
                            <tr>
                                <th class="tw-2">{{$lang->data['sl'] ?? 'Sl'}}</th>
                                <th class="tw-10">{{$lang->data['customer_name'] ?? 'Customer Name'}}</th>
                                <th class="tw-10">{{$lang->data['sales_total'] ?? 'Sales Total'}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $customer)
                                
                            <tr>
                                <td>{{$loop->index + 1}}</td>
                                <td>{{$customer['name']}}</td>
                                <td>{{getCurrency()}}{{number_format($customer['invoices_sum_total_amount'],2)}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @if(count($data) == 0)
                        <x-no-data-component message="{{$lang->data['no_data_found'] ?? 'No data was found..'}}" />
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>