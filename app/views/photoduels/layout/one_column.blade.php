<!doctype html>
<html lang="en">
	@include('photoduels.part.head')
	<body>
		<div class="container">
			<div class="header row clearfix">
				<div class="logo col-md-6 column">
					@include('photoduels.part.logo')
				</div>
				<div class="col-md-6 column" style="text-align: right;">
					@include('photoduels.part.salutation')
				</div>
			</div>
			<div class="row clearfix">
				<div class="col-md-12 column">
					@include('photoduels.part.navigation')
					@yield('content')
				</div>
			</div>
		</div>
		@include('photoduels.part.js')
    </body>
</html>