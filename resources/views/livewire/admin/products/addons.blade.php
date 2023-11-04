<div>
   
<div class="row mb-2 mb-xl-3">
    <div class="col-auto d-none d-sm-block">
        <h3><strong>{{$product->name}}- ({{$lang->data['add_addons'] ?? 'Add Addons'}})</strong></h3>
    </div>

    <div class="col-auto ms-auto text-end mt-n1">
        <a href="{{route('admin.view_products')}}" class="btn btn-dark">{{$lang->data['back'] ?? 'Back'}}</a>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header border-b-1">
                <div class="row">
                    <div class="col-auto d-none d-sm-block">
                    <h5 class="card-title mb-0">{{$lang->data['variants'] ?? 'Variants'}}</h5>
                    </div>

                    <div class="col-auto ms-auto text-end">
                        <a href="#" class="btn btn-sm btn-dark" data-bs-toggle="modal" data-bs-target="#ModalAdd" wire:click='resetField(1)'>{{$lang->data['add_variant'] ?? 'Add Variant'}}</a>
                    </div>
                </div>
              
            </div>
            <div class="card-body p-0">
            <table class="table table-striped table-bordered mb-0">
                    <thead class="bg-secondary-light">
                        <tr>
                            <th class="tw-10">{{$lang->data['sl'] ?? 'Sl'}}</th>
                            <th class="tw-20">{{$lang->data['price'] ?? 'Price'}}</th>
                            <th class="tw-50">{{$lang->data['name'] ?? 'Name'}}</th>
                            <th class="text-end tw-20">{{$lang->data['actions'] ?? 'Actions'}}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($variants as $item)
                        <tr>
                            <td>{{$loop->index + 1}}</td>
                            <td>{{getCurrency()}}{{$item->price}}</td>
                            <td>{{$item->name}}</td>
                            <td class="text-end">
                                @if(Auth::user()->can('edit_addon'))
                                <a href="#" class="btn btn-sm btn-primary"  data-bs-toggle="modal" data-bs-target="#ModalEdit" wire:click="edit({{$item}})">{{$lang->data['edit'] ?? 'Edit'}}</a>
                                @endif
                                @if(Auth::user()->can('delete_addon'))
                                <a href="#" class="btn btn-sm btn-danger" wire:click="delete({{$item}})">{{$lang->data['delete'] ?? 'Delete'}}</a>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @if(count($variants) == 0)
                    <x-no-data-component message="{{$lang->data['no_variant_addons_found'] ?? 'No variant addons were found..'}}" />
                @endif
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card">
            <div class="card-header border-b-1">
                <div class="row">
                    <div class="col-auto d-none d-sm-block">
                    <h5 class="card-title mb-0">{{$lang->data['extras'] ?? 'Extras'}}</h5>
                    </div>

                    <div class="col-auto ms-auto text-end">
                        <a href="#" class="btn btn-sm btn-dark" data-bs-toggle="modal" data-bs-target="#ModalAdd" wire:click='resetField(2)'>{{$lang->data['add_extra'] ?? 'Add Extra'}}</a>
                    </div>
                </div>
              
            </div>
            <div class="card-body p-0">
            <table class="table table-striped table-bordered mb-0">
                    <thead class="bg-secondary-light">
                        <tr>
                            <th class="tw-10">{{$lang->data['sl'] ?? 'Sl'}}</th>
                            <th class="tw-20">{{$lang->data['price'] ?? 'Price'}}</th>
                            <th class="tw-50">{{$lang->data['name'] ?? 'Name'}}</th>
                            <th class="text-end tw-20">{{$lang->data['actions'] ?? 'Actions'}}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($extras as $item)
                        <tr>
                            <td>{{$loop->index + 1}}</td>
                            <td>{{getCurrency()}}{{$item->price}}</td>
                            <td>{{$item->name}}</td>
                            <td class="text-end">
                                @if(Auth::user()->can('edit_addon'))
                                <a href="#" class="btn btn-sm btn-primary"  data-bs-toggle="modal" data-bs-target="#ModalEdit" wire:click="edit({{$item}})">{{$lang->data['edit'] ?? 'Edit'}}</a>
                                @endif
                                @if(Auth::user()->can('delete_addon'))
                                <a href="#" class="btn btn-sm btn-danger" wire:click="delete({{$item}})">{{$lang->data['delete'] ?? 'Delete'}}</a>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @if(count($extras) == 0)
                    <x-no-data-component message="{{$lang->data['no_extra_addons_found'] ?? 'No extra addons were found..'}}" />
                @endif
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="ModalAdd" tabindex="-1" role="dialog" aria-hidden="true" wire:ignore.self>
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{$lang->data['add_new'] ?? 'Add New'}} {{$item_type == 1 ? ($lang->data['variant'] ?? 'Variant') : ($lang->data['extra'] ?? 'Extra')}}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">{{$lang->data['name'] ?? 'Name '}}<span
                        class="text-danger"><strong>*</strong></span></label>
                    <input type="text" class="form-control" placeholder="{{$lang->data['name'] ?? 'Name'}}" wire:model="name">
                    @error('name')
                        <span class="text-danger">{{$message}}</span>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label">{{$lang->data['price'] ?? 'Price'}} <span
                        class="text-danger"><strong>*</strong></span></label>
                    <input type="number" class="form-control" placeholder="{{$lang->data['price'] ?? 'Price'}}" wire:model="price">
                    @error('price')
                        <span class="text-danger">{{$message}}</span>
                    @enderror
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{$lang->data['close'] ?? 'Close'}}</button>
                <button type="button" class="btn btn-success" wire:click.prevent="create">{{$lang->data['save'] ?? 'Save'}}</button>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="ModalEdit" tabindex="-1" role="dialog" aria-hidden="true" wire:ignore.self>
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{$lang->data['edit'] ?? 'Edit'}} {{$item_type == 1 ? ($lang->data['variant'] ?? 'Variant') : ($lang->data['extra'] ?? 'Extra')}}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">{{$lang->data['name'] ?? 'Name '}}<span
                        class="text-danger"><strong>*</strong></span></label>
                    <input type="text" class="form-control" placeholder="{{$lang->data['name'] ?? 'Name'}}" wire:model="name">
                    @error('name')
                        <span class="text-danger">{{$message}}</span>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label">{{$lang->data['price'] ?? 'Price'}} <span
                        class="text-danger"><strong>*</strong></span></label>
                    <input type="number" class="form-control" placeholder="{{$lang->data['price'] ?? 'Price'}}" wire:model="price">
                    @error('price')
                        <span class="text-danger">{{$message}}</span>
                    @enderror
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{$lang->data['close'] ?? 'Close'}}</button>
                <button type="button" class="btn btn-success" wire:click.prevent="update">{{$lang->data['save'] ?? 'Save'}}</button>
            </div>
        </div>
    </div>
</div>

</div>
