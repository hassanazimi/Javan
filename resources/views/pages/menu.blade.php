@extends('layouts.app')
@section('title', 'Persian Food Delivery London - Javan Restaurant London')
@section('content')
	<header class="header header-filter"
	        style="background-image: url('/images/menu-background.png');">
		<main class="container">
			@include('partials.notify-alert', ['data' => 'Cart Updated'])
			<h1 class="text-warning"><i class="fa fa-cutlery fa-fw"></i> The Menu</h1>
			<p class="text-bright"><i class="fa fa-info-circle fa-fw"></i> To view PDF version of menu please
				<a class="btn-link text-bright underline" href="/images/menu/Javan-Restaurant-Menu.pdf" target="_blank"
				   title="Javan Restaurant Menu">click here</a>
			</p>
			<p class="text-warning hidden-xs"><i class="fa fa-info-circle fa-fw"></i>
				Hover your mouse on each food to see the descriptions</p>
			<p class="text-warning visible-xs"><i class="fa fa-info-circle fa-fw"></i>
				Tab on each food name to see the descriptions</p>
			<p class="text-info"><i class="fa fa-info-circle fa-fw"></i>
				We serve selections of wines and beers</p>
			<article class="col-md-8">

				{{--<div class="alert alert-warning">
					<div class="alert-icon"><i class="material-icons">warning</i></div>
					<strong>Delivery Status: </strong>
					Temporary not working. Please call us on <strong>020 8563 8553</strong> or order via
					<a class="text-twilight alert-link" target="_blank"
					   href="//eats.uber.com/stores/5e3716e3-8232-479e-a043-0fd7c10c6113">UberEATS</a>
				</div>--}}

				@if(javan_is_open())
					<div class="alert alert-success">
						<div class="alert-icon"><i class="material-icons">done</i></div>
						<strong>Delivery Status : </strong> Accepting Orders.
					</div>
				@else
					<div class="alert alert-danger">
						<div class="alert-icon"><i class="material-icons">error</i></div>
						<strong>Delivery Status : </strong> Not Accepting Orders.
						You can now schedule delivery time between
						<time datetime="12:30">12:30</time>
						&mdash;
						<time datetime="23:00">23:00</time>
					</div>
				@endif

				<div class="card card-nav-tabs card-plain">
					<div class="header header-primary">
						<div class="nav-tabs-navigation">
							<div class="nav-tabs-wrapper">
								<ul class="nav nav-tabs" data-tabs="tabs">
									<li>
										<a href="#appetizers" data-toggle="tab">
											<span class="hidden-xs">Appetizers</span>
											<small class="visible-xs">Appetizer</small>
										</a>
									</li>
									<li class="active">
										<a href="#main_courses" data-toggle="tab">
											<span class="hidden-xs">Main Courses</span>
											<small class="visible-xs">Main</small>
										</a>
									</li>
									<li>
										<a href="#extras" data-toggle="tab">
											<span class="hidden-xs">Sides & Extras</span>
											<small class="visible-xs">Side</small>
										</a>
									</li>
									<li>
										<a href="#beverages" data-toggle="tab">
											<span class="hidden-xs">Beverages</span>
											<small class="visible-xs">Beverage</small>
										</a>
									</li>
									<li>
										<a href="#juices" data-toggle="tab">
											<span class="hidden-xs">Juices</span>
											<small class="visible-xs">Juice</small>
										</a>
									</li>
									<li>
										<a href="#desserts" data-toggle="tab">
											<span class="hidden-xs">Desserts</span>
											<small class="visible-xs">Dessert</small>
										</a>
									</li>
								</ul>
							</div>
						</div>
					</div>
					<div class="content">
						<div class="tab-content text-center">
							<div class="tab-pane fade" id="appetizers">
								@foreach ($appetizers as $appetizer)
									<div class="col-sm-4 col-xs-6">
										<div class="thumbnail">
											@if ($appetizer->image_path)
												<a href="/{{ $appetizer->image_path }}" data-lity>
													<img src="/{{ $appetizer->image_path }}" class="img-responsive" alt="mirza-ghasemi">
												</a>
											@endif
											<div class="caption">
												<h4 style="cursor:help;" title="{{ $appetizer->description }}"
												    data-toggle="tooltip"
												    data-placement="top" itemprop="name">{{ $appetizer->title }}</h4>
												<span class="text-primary" itemprop="price">
														£ {{ number_format($appetizer->price / 100 , 2) }}&nbsp;&nbsp;&nbsp;</span>
												@if ($appetizer->available)
													<a data-pjax href="{{ route('add.to.cart', $appetizer) }}"
													   class="btn btn-sm btn-success btn-raised">
														<i class="fa fa-plus fa-lg"></i>
													</a>
												@else
													<span class="label label-danger">Not Available</span>
												@endif
											</div>
										</div>
									</div>
								@endforeach
							</div>
							<div class="tab-pane fade in active" id="main_courses">
								@foreach ($main_courses as $main_course)
									<div class="col-sm-4 col-xs-6">
										<div class="thumbnail">
											@if ($main_course->image_path)
												<a href="/{{ $main_course->image_path }}" data-lity>
													<img src="/{{ $main_course->image_path }}" class="img-responsive" alt="mirza-ghasemi">
												</a>
											@endif
											<div class="caption">
												<h4 style="cursor:help;" title="{{ $main_course->description }}"
												    data-toggle="tooltip"
												    data-placement="top"
												    itemprop="name">{{ $main_course->title }}</h4>
												<span class="text-primary"
												      itemprop="price">£ {{ number_format($main_course->price / 100 , 2) }}
													&nbsp;&nbsp;&nbsp;</span>
												@if ($main_course->available)
													<a data-pjax href="{{ route('add.to.cart', $main_course) }}"
													   class="btn btn-sm btn-success btn-raised">
														<i class="fa fa-plus fa-lg"></i>
													</a>
												@else
													<span class="label label-danger">Not Available</span>
												@endif
											</div>
										</div>
									</div>
								@endforeach
							</div>
							<div class="tab-pane fade" id="extras">
								@foreach ($extras as $extra)
									<div class="col-sm-4 col-xs-6">
										<div class="thumbnail">
											@if ($extra->image_path)
												<a href="/{{ $extra->image_path }}" data-lity>
													<img src="/{{ $extra->image_path }}" class="img-responsive" alt="mirza-ghasemi">
												</a>
											@endif
											<div class="caption">
												<h4 style="cursor:help;" title="{{ $extra->description }}"
												    data-toggle="tooltip"
												    data-placement="top" itemprop="name">{{ $extra->title }}</h4>
												<span class="text-primary" itemprop="price">£ {{ number_format($extra->price / 100 , 2) }}
													&nbsp;&nbsp;&nbsp;</span>
												@if ($extra->available)
													<a data-pjax href="{{ route('add.to.cart', $extra) }}"
													   class="btn btn-sm btn-success btn-raised">
														<i class="fa fa-plus fa-lg"></i>
													</a>
												@else
													<span class="label label-danger">Not Available</span>
												@endif
											</div>
										</div>
									</div>
								@endforeach
							</div>
							<div class="tab-pane fade" id="beverages">
								@foreach ($beverages as $beverage)
									<div class="col-sm-4 col-xs-6">
										<div class="thumbnail">
											@if ($beverage->image_path)
												<a href="/{{ $beverage->image_path }}" data-lity>
													<img src="/{{ $beverage->image_path }}" class="img-responsive" alt="mirza-ghasemi">
												</a>
											@endif
											<div class="caption">
												<h4 itemprop="name">{{ $beverage->title }}</h4>
												<span class="text-primary" itemprop="price">£ {{ number_format($beverage->price / 100 , 2) }}
													&nbsp;&nbsp;&nbsp;</span>
												@if ($beverage->available)
													<a data-pjax href="{{ route('add.to.cart', $beverage) }}"
													   class="btn btn-sm btn-success btn-raised">
														<i class="fa fa-plus fa-lg"></i>
													</a>
												@else
													<span class="label label-danger">Not Available</span>
												@endif
											</div>
										</div>
									</div>
								@endforeach
							</div>
							<div class="tab-pane fade" id="juices">
								@foreach ($juices as $juice)
									<div class="col-sm-4 col-xs-6">
										<div class="thumbnail">
											@if ($juice->image_path)
												<a href="/{{ $juice->image_path }}" data-lity>
													<img src="/{{ $juice->image_path }}" class="img-responsive" alt="mirza-ghasemi">
												</a>
											@endif
											<div class="caption">
												<h4 itemprop="name">{{ $juice->title }}</h4>
												<span class="text-primary" itemprop="price">£ {{ number_format($juice->price / 100 , 2) }}
													&nbsp;&nbsp;&nbsp;</span>
												@if ($juice->available)
													<a data-pjax href="{{ route('add.to.cart', $juice) }}"
													   class="btn btn-sm btn-success btn-raised">
														<i class="fa fa-plus fa-lg"></i>
													</a>
												@else
													<span class="label label-danger">Not Available</span>
												@endif
											</div>
										</div>
									</div>
								@endforeach
							</div>
							<div class="tab-pane fade" id="desserts">
								@foreach ($desserts as $dessert)
									<div class="col-sm-4 col-xs-6">
										<div class="thumbnail">
											@if ($dessert->image_path)
												<a href="/{{ $dessert->image_path }}" data-lity>
													<img src="/{{ $dessert->image_path }}" class="img-responsive" alt="mirza-ghasemi">
												</a>
											@endif
											<div class="caption">
												<h4 style="cursor:help;" title="{{ $dessert->description }}"
												    data-toggle="tooltip"
												    data-placement="top" itemprop="name">{{ $dessert->title }}</h4>
												<span class="text-primary" itemprop="price">£ {{ number_format($dessert->price / 100 , 2) }}
													&nbsp;&nbsp;&nbsp;</span>
												@if ($dessert->available)
													<a data-pjax href="{{ route('add.to.cart', $dessert) }}"
													   class="btn btn-sm btn-success btn-raised">
														<i class="fa fa-plus fa-lg"></i>
													</a>
												@else
													<span class="label label-danger">Not Available</span>
												@endif
											</div>
										</div>
									</div>
								@endforeach
							</div>
						</div>
					</div>
				</div>

			</article>
			<aside class="col-md-4">
				@include('partials.product-cart')
				@include('partials.deliverable')
				<div class="alert alert-primary">
					<p>Take away dishes don't include side salad.</p>
					<p class="bbcnassim text-right" dir="rtl">سالاد کنار غذا شامل دلیوری نمی شود.</p>
				</div>
				<div class="alert-inverse center">
					<a target="_blank" href="//eats.uber.com/stores/5e3716e3-8232-479e-a043-0fd7c10c6113">
						<img src="/images/UberEats-logo.png" alt="UberEats-logo">
					</a>
				</div><!-- /.alert -->
			</aside>
		</main>
	</header>
@stop