<div>
    <div class="row mb-2 mb-xl-3">
        <div class="col-auto d-none d-sm-block">
            <h3><strong>{{$lang->data['supplier'] ?? 'Brand'}}</strong></h3>
        </div>
        <div class="col-auto ms-auto text-end mt-n1">
            @if(Auth::user()->can('add_supplier'))
            <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#ModalSupplier" wire:click="resetFields">{{$lang->data['new_supplier'] ?? 'New
                Brand'}}</a>
            @endif
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card p-0">
                <div class="card-body p-0">
                    <table id="table" class="table table-striped table-bordered table-responsive mb-0">
                        <thead class="bg-secondary-light">
                            <tr>
                                <th class="tw-5">{{$lang->data['sl'] ?? 'Sl'}}</th>
                                <th class="tw-20">{{$lang->data['name'] ?? 'Brand Name'}}</th>
                                <th class="tw-10">{{$lang->data['business_name'] ?? 'Business Name'}}</th>
                                <th class="tw-20">{{$lang->data['actions'] ?? 'Actions'}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($suppliers as $item)
                            <tr>
                                <td>{{$loop->index+1}}</td>
                                <td>{{$item->name}}</td>
                                <td>{{$item->business_name}}</td>
                                <td>
                                    @if(Auth::user()->can('edit_supplier'))
                                    <a href="#" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#EditModalSupplier" wire:click='edit({{$item}})'>{{$lang->data['edit'] ?? 'Edit'}}</a>
                                    @endif

                                    @if(Auth::user()->can('delete_supplier'))
                                    <a href="#" class="btn btn-sm btn-danger" wire:click="delete({{$item}})">{{$lang->data['delete'] ?? 'Delete'}}</a>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @if(count($suppliers) == 0)
                        <x-no-data-component message="{{$lang->data['no_supplier_found'] ?? 'No brand were found..'}}" />
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="ModalSupplier" tabindex="-1" role="dialog" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{$lang->data['add_new_supplier'] ?? 'Add New Brand'}}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">{{$lang->data['name'] ?? 'Name'}} <span class="text-danger"><strong>*</strong></span></label>
                        <input type="text" class="form-control" placeholder="{{$lang->data['name'] ?? 'Name'}}" wire:model="name">
                        @error('name')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">{{$lang->data['business_name'] ?? 'Business Name'}} </label>
                        <textarea class="form-control resize-none" rows="3" placeholder="{{$lang->data['business_name'] ?? 'Business Name'}}" wire:model="business_name"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{$lang->data['close'] ?? 'Close'}}</button>
                    <button type="button" class="btn btn-success" wire:click='create'>{{$lang->data['save'] ?? 'Save'}}</button>
                </div>
            </div>
        </div>
    </div>

    
    <div class="modal fade" id="EditModalSupplier" tabindex="-1" role="dialog" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{$lang->data['add_new_supplier'] ?? 'Add New Brand'}}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">{{$lang->data['name'] ?? 'Brand Name'}} <span class="text-danger"><strong>*</strong></span></label>
                        <input type="text" class="form-control" placeholder="{{$lang->data['name'] ?? 'Name'}}" wire:model="name">
                        @error('name')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">{{$lang->data['business_name'] ?? 'Business Name'}} </label>
                        <input class="form-control" placeholder="{{$lang->data['business_name'] ?? 'Business Name'}}" wire:model="business_name"></input>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{$lang->data['close'] ?? 'Close'}}</button>
                    <button type="button" class="btn btn-success" wire:click="update">{{$lang->data['update'] ?? 'Update'}}</button>
                </div>
            </div>
        </div>
    </div>
</div>
