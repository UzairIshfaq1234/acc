<div>
	<main class="d-flex w-100 h-100">
		<div class="container d-flex flex-column">
			<div class="row vh-100">
				<div class="col-sm-10 col-md-8 col-lg-4 mx-auto d-table h-100">
					<div class="d-table-cell align-middle">
						<div class="card" style="background-color: black;">
							<div class="card-body">
								<div class="m-sm-4">
									<div class="text-center mb-4">
										<h1 style="color: white;">{{getStoreName()}}</h1>
									</div>
									<form>
										<div class="mb-3">
											<label class="form-label">{{$lang->data['password']??'Password'}}</label>
											<input class="form-control form-control-lg " type="password" name="password" placeholder="{{$lang->data['enter_password']??'Enter your password'}}" wire:model='password'/>
											@error('password')
												<span class="text-danger d-block">{{$message}}</span>
											@enderror
										</div>
										<div class="mb-3">
											<label class="form-label">{{$lang->data['password_confirmation']??'Confirm Password'}}</label>
											<input class="form-control form-control-lg " type="password" name="password_confirmation" placeholder="{{$lang->data['enter_password_confirmation']??'Enter your Confirm Password'}}" wire:model='password_confirmation'/>
											@error('password_confirmation')
												<span class="text-danger d-block">{{$message}}</span>
											@enderror
											@error('login_error')
												<span class="text-danger d-block">{{$message}}</span>
											@enderror
										</div>
										<div class="text-center mt-3">
											<a href="#" class="btn btn-lg btn-primary" wire:click.prevent='resetpassword'>{{$lang->data['reset']??'Reset'}}</a>
										</div>
									</form>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</main>
</div>