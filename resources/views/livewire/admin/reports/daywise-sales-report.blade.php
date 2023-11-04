<div>
   
<div class="row mb-2 mb-xl-3">
    <div class="col-auto d-none d-sm-block">
        <h3><strong>{{$lang->data['day_wise_report'] ?? 'Day Wise Sales Report'}}</strong></h3>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card p-0">
            <div class="card-header p-3">
                <div class="row">
                    <div class="col-md-3">
                        <label>{{$lang->data['start_date'] ?? 'Start Date'}}</label>
                        <input type="date" class="form-control" wire:model="start_date">
                    </div>
                    <div class="col-md-3">
                        <label>{{$lang->data['end_date'] ?? 'End Date'}}</label>
                        <input type="date" class="form-control" wire:model="end_date">
                    </div>
                    <div class="col-md-3">
                       <br>
                        <a href="#" class="btn btn-primary" wire:click='getData'>{{$lang->data['search'] ?? 'Search'}}</a>
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
                            <th class="tw-10">{{$lang->data['date'] ?? 'Date'}}</th>
                            <th class="tw-10">{{$lang->data['no_of_orders'] ?? 'No of Orders'}}</th>
                            <th class="tw-20">{{$lang->data['sales_total'] ?? 'Sales Total'}}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $item)
                            
                        <tr>
                            <td>{{$loop->index + 1}}</td>
                            <td>{{Carbon\Carbon::parse($item['date'])->format('d/m/Y')}}</td>
                            <td>{{$item['count']}}</td>
                            <td>{{getCurrency()}}{{$item['total']}}</td>
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
