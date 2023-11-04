<div>
    <div class="row mb-2 mb-xl-3">
        <div class="col-auto d-none d-sm-block">
            <h3><strong>{{$lang->data['supplier'] ?? 'Services'}}</strong></h3>
        </div>
        <div class="col-auto ms-auto text-end mt-n1">
            @if(Auth::user()->can('add_supplier'))
            <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#ModalSupplier" wire:click="resetFields">{{$lang->data['new_supplier'] ?? 'New
                Services'}}</a>
            @endif
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card p-0">
                <div class="card-body p-0">
                    <table class="table table-striped table-bordered mb-0">
                        <thead class="bg-secondary-light">
                            <tr>
                                <th class="tw-5">{{$lang->data['sl'] ?? 'Sl'}}</th>
                                <th class="tw-20">{{$lang->data['name'] ?? 'Name'}}</th>
                                <th class="tw-10">{{$lang->data['description'] ?? 'Description'}}</th>
                                <th class="tw-10">{{$lang->data['charges'] ?? 'Charges'}}</th>
                                <th class="tw-20">{{$lang->data['actions'] ?? 'Actions'}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($services as $item)
                            <tr>
                                <td>{{$loop->index+1}}</td>
                                <td>{{$item->name}}</td>
                                <td>{{$item->description}}</td>
                                <td>{{$item->charges}}</td>
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
                    @if(count($services) == 0)
                        <x-no-data-component message="{{$lang->data['no_supplier_found'] ?? 'No supplier were found..'}}" />
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="ModalSupplier" tabindex="-1" role="dialog" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{$lang->data['add_new_supplier'] ?? 'Add New Supplier'}}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">{{$lang->data['name'] ?? 'Name'}} <span class="text-danger"><strong>*</strong></span></label>
                        <input type="text" class="form-control" placeholder="{{$lang->data['name'] ?? 'Services Name'}}" wire:model="name">
                        @error('name')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">{{$lang->data['business_name'] ?? 'Description'}} </label>
                        <input type="text" class="form-control resize-none" rows="3" placeholder="{{$lang->data['description'] ?? 'Description'}}" wire:model="description"></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">{{$lang->data['phone_no'] ?? 'Charges'}} </label>
                        <input type="number" class="form-control resize-none" rows="3" placeholder="{{$lang->data['charges'] ?? ''}}" wire:model="charges">
                    </div>
                    <div class="mb-3">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="isActive" wire:model="is_active">
                            <label class="form-check-label" for="isActive">{{$lang->data['is_active'] ?? 'isActive'}}</label>
                        </div>
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
                    <h5 class="modal-title">{{$lang->data['add_new_supplier'] ?? 'Add New Supplier'}}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="mb-3">
                    <label class="form-label">{{$lang->data['name'] ?? 'Name'}} <span class="text-danger"><strong>*</strong></span></label>
                    <input type="text" class="form-control" placeholder="{{$lang->data['name'] ?? 'Services Name'}}" wire:model="name">
                    @error('name')
                        <span class="text-danger">{{$message}}</span>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label">{{$lang->data['business_name'] ?? 'Description'}} </label>
                    <input type="text" class="form-control resize-none" rows="3" placeholder="{{$lang->data['description'] ?? 'Description'}}" wire:model="description"></textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label">{{$lang->data['phone_no'] ?? 'Charges'}} </label>
                    <input type="number" class="form-control resize-none" rows="3" placeholder="{{$lang->data['charges'] ?? ''}}" wire:model="charges">
                </div>
                    <div class="mb-3">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="isActive" wire:model="is_active">
                            <label class="form-check-label" for="isActive">{{$lang->data['is_active'] ?? 'isActive'}}</label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{$lang->data['close'] ?? 'Close'}}</button>
                    <button type="button" class="btn btn-success" wire:click="update">{{$lang->data['save'] ?? 'Save'}}</button>
                </div>
            </div>
        </div>
    </div>
</div>
