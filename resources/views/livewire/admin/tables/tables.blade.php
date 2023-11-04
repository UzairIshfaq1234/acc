<div>
    <div class="row mb-2 mb-xl-3">
        <div class="col-auto d-none d-sm-block">
            <h3><strong>{{$lang->data['tables'] ?? 'Tables'}}</strong></h3>
        </div>
        @if(Auth::user()->can('add_table'))
        <div class="col-auto ms-auto text-end mt-n1">
            <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#ModalCategory" wire:click="resetFields">{{$lang->data['new_table'] ?? 'New Table'}}</a>
        </div>
        @endif
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card p-0">
                <div class="card-body p-0">
                    <table class="table table-striped table-bordered mb-0">
                        <thead class="bg-secondary-light">
                            <tr>
                                <th class="tw-5">{{$lang->data['sl'] ?? 'Sl'}}</th>
                                <th class="tw-30">{{$lang->data['name'] ?? 'Name'}}</th>
                                <th class="tw-10">{{$lang->data['capacity'] ?? 'Capacity'}}</th>
                                <th class="tw-20">{{$lang->data['layout'] ?? 'Layout'}}</th>
                                <th class="tw-10">{{$lang->data['status'] ?? 'Status'}}</th>
                                <th class="tw-20">{{$lang->data['actions'] ?? 'Actions'}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($tables as $item)
                            <tr>
                                <td>{{$loop->index+1}}</td>
                                <td>{{$item->name}}</td>
                                <td>{{$item->capacity}}</td>
                                <td>{{$item->layout}}</td>
                                <td><span class="badge {{$item->is_active == 1 ? 'bg-success' : 'bg-secondary'}}">{{$item->is_active == 1 ? ($lang->data['active'] ?? 'Active') : ($lang->data['inactive'] ?? 'Inactive')}}</span></td>
                                <td>
                                    @if(Auth::user()->can('edit_table'))
                                    <a href="#" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#EditModalCategory" wire:click='edit({{$item}})'>{{$lang->data['edit'] ?? 'Edit'}}</a>
                                    @endif
                                    @if(Auth::user()->can('delete_table'))
                                    <a href="#" class="btn btn-sm btn-danger" wire:click="delete({{$item}})">{{$lang->data['delete'] ?? 'Delete'}}</a>
                                    @endif

                                </td>
                            </tr>
                            @endforeach


                        </tbody>
                    </table>
                    @if(count($tables) == 0)
                        <x-no-data-component message="{{$lang->data['no_tables_found'] ?? 'No tables were found..'}}" />
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="ModalCategory" tabindex="-1" role="dialog" aria-hidden="true"  wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{$lang->data['add_new_table'] ?? 'Add New Table'}}</h5>
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
                        <label class="form-label">{{$lang->data['capacity'] ?? 'Capacity'}} <span class="text-danger"><strong>*</strong></span></label>
                        <input type="text" class="form-control" placeholder="{{$lang->data['capacity'] ?? 'Capacity'}}" wire:model="capacity">
                        @error('capacity')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">{{$lang->data['layout'] ?? 'Layout'}} <span class="text-danger"><strong>*</strong></span></label>
                        <input type="text" class="form-control" placeholder="{{$lang->data['layout'] ?? 'Layout'}}" wire:model="layout">
                        @error('layout')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
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

    <div class="modal fade" id="EditModalCategory" tabindex="-1" role="dialog" aria-hidden="true"  wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{$lang->data['edit_table'] ?? 'Edit Table'}}</h5>
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
                        <label class="form-label">{{$lang->data['capacity'] ?? 'Capacity'}} <span class="text-danger"><strong>*</strong></span></label>
                        <input type="text" class="form-control" placeholder="{{$lang->data['capacity'] ?? 'Capacity'}}" wire:model="capacity">
                        @error('capacity')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">{{$lang->data['layout'] ?? 'Layout'}} <span class="text-danger"><strong>*</strong></span></label>
                        <input type="text" class="form-control" placeholder="{{$lang->data['layout'] ?? 'Layout'}}" wire:model="layout">
                        @error('layout')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
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
                    <button type="button" class="btn btn-success" wire:click='update'>{{$lang->data['save'] ?? 'Save'}}</button>
                </div>
            </div>
        </div>
    </div>

</div>
