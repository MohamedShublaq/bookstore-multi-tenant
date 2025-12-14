<section class="books-sale">
    <div class="container">
        <div class="d-flex flex-wrap justify-content-between align-items-center">
            <div class="books-sale_head">
                <h4>Flash Sale</h4>
                <p>
                    Limited-time deals on a wide selection of books! Grab your favorite reads at unbeatable discounts
                    before the offer expires. Don't miss out—shop now and save big!
                </p>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="splide d-flex p-0" aria-label="Custom Arrows Example" id="saleSlider">
                    <div class="splide__arrows">
                        <button class="splide__arrow splide__arrow--prev">
                            <i class="fa-solid fa-chevron-left"></i>
                        </button>
                        <button class="splide__arrow splide__arrow--next">
                            <i class="fa-solid fa-chevron-right"></i>
                        </button>
                    </div>

                    <div class="splide__track w-100 p-0">
                        <ul class="splide__list w-100">
                            @foreach ($flashSaleBooks as $book)
                                <li class="splide__slide splide__slide-sale">
                                    <div class="books-sale_card w-100 p-4">
                                        <div class="books-sale_card__image w-50">
                                            <a href="{{ tenant_route('showBook', $book->slug) }}">
                                                <img src="{{ asset($book->image) }}" alt="book_image" />
                                            </a>
                                        </div>
                                        <div class="d-flex flex-column w-100 gap-2">
                                            <div class="recommended_card__content">
                                                <div class="d-flex justify-content-between">
                                                    <a href="{{ tenant_route('showBook', $book->slug) }}">
                                                        <h3 class="text-light">{{ $book->name }}</h3>
                                                    </a>
                                                    @if (\Carbon\Carbon::now() >= $book->discountable->date)
                                                        @php
                                                            $endTime = \Carbon\Carbon::parse(
                                                                $book->discountable->date,
                                                            )->addHours($book->discountable->time);
                                                            $remainingTime = now()->diffForHumans($endTime, [
                                                                'parts' => 3,
                                                                'short' => true,
                                                            ]);
                                                        @endphp
                                                        <p class="text-warning">End In:
                                                            {{ $remainingTime }}</p>
                                                    @endif
                                                </div>
                                                <p class="recommended_author text-light">
                                                    <span class="text-secondary">Author:</span>
                                                    {{ $book->author->name }}
                                                </p>
                                            </div>
                                            <div
                                                class="recommended_card__rate d-flex flex-wrap justify-content-between align-items-center">
                                                <div>
                                                    <div class="stars d-flex gap-1">
                                                        <div>
                                                            <i class="fa-solid fa-star"></i>
                                                            <i class="fa-solid fa-star"></i>
                                                            <i class="fa-solid fa-star"></i>
                                                            <i class="fa-solid fa-star"></i>
                                                            <i class="fa-solid fa-star text-secondary"></i>
                                                        </div>
                                                        <p class="review text-light">({{ $book->num_of_viewers }}
                                                            Review)</p>
                                                    </div>
                                                    <p class="rate text-light">
                                                        <span class="text-secondary"> Rate : </span>
                                                        {{ $book->rate }}
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="d-flex align-items-center gap-2">
                                                <p class="sale_price text-decoration-line-through">
                                                    ${{ number_format($book->price, 2) }}
                                                </p>
                                                @php
                                                    $discountAmount =
                                                        ($book->price * $book->discountable->percentage) / 100;
                                                    $priceAfterDiscount = $book->price - $discountAmount;
                                                @endphp
                                                <p class="main_price">${{ number_format($priceAfterDiscount, 2) }}</p>
                                            </div>
                                            <div class="range-container">
                                                <input type="range" class="progress-bar" min="0"
                                                    max="100"
                                                    value="{{ ($book->quantity / $book->total_stock) * 100 }}"
                                                    readonly />
                                                <p class="mt-2 text-secondary">{{ $book->quantity }} books left</p>
                                            </div>

                                            @if (!$book->quantity)
                                                <div class="d-flex flex-wrap justify-content-end mt-auto">
                                                    <button class="add_to_cart">
                                                        Sold Out
                                                    </button>
                                                </div>
                                            @else
                                                @if ($book->discountable->date > \Carbon\Carbon::now())
                                                    <div class="d-flex flex-wrap justify-content-end mt-auto">
                                                        <button class="add_to_cart">
                                                            Starts in
                                                            {{ \Carbon\Carbon::now()->diffForHumans($book->discountable->date, ['parts' => 3, 'short' => true]) }}
                                                        </button>
                                                    </div>
                                                @else

                                                    @livewire('add_to_cart_from_flash_sale_section', ['book' => $book], key('add-to-cart-' . $book->id))

                                                @endif
                                            @endif
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
