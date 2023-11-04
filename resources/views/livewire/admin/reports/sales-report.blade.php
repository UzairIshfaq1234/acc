<div>

    <div class="row mb-2 mb-xl-3">
        <div class="col-auto d-none d-sm-block">
            <h3><strong>{{$lang->data['sales_report'] ?? 'Sales Report'}}</strong></h3>
        </div>
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
                            <label>{{$lang->data['staff'] ?? 'Staff'}}</label>
                            <select class="form-select" wire:model="staff_id">
                                <option value="ALL">{{$lang->data['all_staff']??'All Staff'}}</option>
                                @foreach ($staff as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label>{{$lang->data['customer'] ?? 'Customer'}}</label>
                            <select class="form-select" wire:model="customer_id">
                                <option value="ALL">{{$lang->data['all_customer']??'All Customer'}}</option>
                                @foreach ($customer as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <br>
                            <a href="#" class="btn btn-primary" wire:click='getData'>{{$lang->data['search'] ?? 'Search'}}</a>
                        </div>
                        <div class="col-md-2">
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
                                <th class="tw-10">{{$lang->data['invoice_Date'] ?? 'Invoice Date'}}</th>
                                <th class="tw-10">{{$lang->data['invoice_no'] ?? 'Invoice No'}}</th>
                                <th class="tw-20">{{$lang->data['customer'] ?? 'Customer'}}</th>
                                <th class="tw-20">{{$lang->data['payment_details'] ?? 'Amount'}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($invoices as $invoice)
                                
                            <tr>
                                <td>{{$loop->index + 1}}</td>
                                <td>{{\Carbon\Carbon::parse($invoice->date)->format('d/m/Y')}}</td>
                                <td>{{$invoice->invoice_number}}</td>
                                <td>{{$invoice->customer->name}}</td>
                                <td class="d-none d-xl-table-cell">
                                    <div class="text-muted">
                                        {{$lang->data['total'] ?? 'Total'}}: {{getCurrency()}}{{number_format($invoice->total_amount,2)}}
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @if(count($invoices) == 0)
                        <x-no-data-component message="{{$lang->data['no_invoices_found'] ?? 'No invoices were found..'}}" />
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>