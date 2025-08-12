<section class="partners-section">
    <div class="container">

        <!-- Desktop Grid -->
        <div class="row d-none d-md-flex align-items-center">
            <!-- Left 6 logos -->
            <div class="col-md-5">
                <div class="row row-cols-3 g-3">
                    @foreach ($customers->take(6) as $customer)
                        <div class="col text-center">
                            <img src="{{ asset($customer->image) }}" class="partner-logo" alt="{{ $customer->name }}">
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Center box -->
            <div class="col-md-2 d-flex justify-content-center">
                <div class="partner-count-box">
                    <div class="partner-count-number">300+</div>
                    <div class="partner-count-text">đối tác</div>
                </div>
            </div>

            <!-- Right 6 logos -->
            <div class="col-md-5">
                <div class="row row-cols-3 g-3">
                    @foreach ($customers->skip(6)->take(6) as $customer)
                        <div class="col text-center">
                            <img src="{{ asset($customer->image) }}" class="partner-logo" alt="{{ $customer->name }}">
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Mobile Grid -->
        <div class="row d-md-none mobile-grid text-center">
            <!-- Center box first -->
            <div class="col-12">
                <div class="partner-count-box">
                    <div class="partner-count-number">{{ $customers->count() }}+</div>
                    <div class="partner-count-text">đối tác</div>
                </div>
            </div>

            <!-- Logos in mobile -->
            @foreach ($customers as $customer)
                <div class="col-4 mb-3">
                    <img src="{{ asset($customer->image) }}" class="partner-logo" alt="{{ $customer->name }}">
                </div>
            @endforeach
        </div>

    </div>
</section>
