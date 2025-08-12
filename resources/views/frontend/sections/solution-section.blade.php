<section>
    <div class="container sgo-section">
        <div class="row">
            <div class="col-md-7">
                <h4><strong>{{ $journey->title }}</strong></h4>

                @foreach ($journey->content as $index => $step)
                    <div class="d-flex mb-4">
                        <div class="me-3">
                            <div class="step-number">{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</div>
                        </div>
                        <div>
                            <div class="step-title">{{ $step['name'] }}</div>
                            <div class="step-desc">
                                {{ $step['content'] }}
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="col-md-5 d-flex align-items-center justify-content-center">
                <img src="{{ asset('storage/' . $journey->banner) }}" alt="SGO illustration" class="sgo-image">
            </div>
        </div>
    </div>
</section>



<div class="text-center">
    <button class="action-button" data-bs-toggle="modal" data-bs-target="#sgoModal">
        <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
            stroke-linejoin="round" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
            <rect width="20" height="16" x="2" y="4" rx="2" />
            <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7" />
        </svg>
        Tư vấn 1:1 miễn phí cùng SGO
    </button>
</div>
