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
										@if (session('message'))
										<div class="alert alert-success alert-dismissible">
											{{ session('message') }}
											<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
										</div>
										@endif
											<label class="form-label">{{$lang->data['email']??'Email'}}</label>
											<input class="form-control form-control-lg" type="email" name="email" placeholder="{{$lang->data['enter_email']??'Enter your email'}}" wire:model='email'/>
											@error('email')
												<span class="text-danger">{{$message}}</span>
											@enderror
											@error('error')
												<span class="text-danger">{{$message}}</span>
											@enderror
										</div>
										<div class="text-center mt-3">
											<a href="#" class="btn btn-lg btn-primary" wire:click.prevent='forget'>{{$lang->data['forget']??'Forget'}}</a>
										</div>
									</form>
									
									<br>
									<p class="mb-1">
									<a href="#" wire:click.prevent='login'>{{$lang->data['sign_in']??'Sign in'}}</a>
									</p>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</main>
</div>