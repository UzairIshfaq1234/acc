<div>
   
<div class="row mb-2 mb-xl-3">
    <div class="col-auto d-none d-sm-block">
        <h3><strong>{{$lang->data['app_settings'] ?? 'App Settings'}}</strong></h3>
    </div>

    <div class="col-auto ms-auto text-end mt-n1">
        <a href="{{route('admin.dashboard')}}" class="btn btn-dark">{{$lang->data['back'] ?? 'Back'}}</a>
    </div>
</div>

<div class="col-md-12">
    <div class="card">
        <div class="card-body">
            <form>
                <div class="row">
                    <div class="mb-3 col-md-3">
                        <label class="form-label">{{$lang->data['mail_transport'] ?? 'Mail Transport '}}<span class="text-danger"><strong>*</strong></span></label>
                        <input type="text" class="form-control" placeholder="{{$lang->data['enter_mail_transport'] ?? 'Enter Mail Transport'}}" wire:model='mail_transport'>
                        @error('mail_transport')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                    <div class="mb-3 col-md-3">
                        <label class="form-label">{{$lang->data['mail_host'] ?? 'Mail Host '}}<span class="text-danger"><strong>*</strong></span></label>
                        <input type="text" class="form-control" placeholder="{{$lang->data['enter_mail_host'] ?? 'Enter Mail Host'}}" wire:model='mail_host'>
                        @error('mail_host')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                    <div class="mb-3 col-md-3">
                        <label class="form-label">{{$lang->data['mail_port'] ?? 'Mail Port '}}<span class="text-danger"><strong>*</strong></span></label>
                        <input type="text" class="form-control" placeholder="{{$lang->data['enter_mail_port'] ?? 'Enter Mail Port'}}" wire:model='mail_port'>
                        @error('mail_port')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                    <div class="mb-3 col-md-3">
                        <label class="form-label">{{$lang->data['mail_username'] ?? 'Mail UserName '}}<span class="text-danger"><strong>*</strong></span></label>
                        <input type="text" class="form-control" placeholder="{{$lang->data['enter_mail_username'] ?? 'Enter Mail UserName'}}" wire:model='mail_username'>
                        @error('mail_username')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                    <div class="mb-3 col-md-3">
                        <label class="form-label">{{$lang->data['mail_password'] ?? 'Mail Password '}}<span class="text-danger"><strong>*</strong></span></label>
                        <input type="text" class="form-control" placeholder="{{$lang->data['enter_mail_password'] ?? 'Enter Mail Password'}}" wire:model='mail_password'>
                        @error('mail_password')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                    <div class="mb-3 col-md-3">
                        <label class="form-label">{{$lang->data['mail_encryption'] ?? 'Mail Encryption '}}<span class="text-danger"><strong>*</strong></span></label>
                        <input type="text" class="form-control" placeholder="{{$lang->data['enter_mail_encryption'] ?? 'Enter Mail Encryption'}}" wire:model='mail_encryption'>
                        @error('mail_encryption')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                    <div class="mb-3 col-md-3">
                        <label class="form-label">{{$lang->data['mail_from'] ?? 'Mail From '}}<span class="text-danger"><strong>*</strong></span></label>
                        <input type="text" class="form-control" placeholder="{{$lang->data['enter_mail_from'] ?? 'Enter Mail From'}}" wire:model='mail_from'>
                        @error('mail_from')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                <button type="submit" class="btn btn-primary float-end" wire:click.prevent='save'>{{$lang->data['save_changes'] ?? 'Save Changes'}}</button>
            </form>
        </div>
    </div>
</div>
</div>
