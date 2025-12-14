<section class="best_seller">
    <div class="container">
        <div class="best_seller-head">
            <h2>Best Seller</h2>
            <p>
                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris et
                ultricies est. Aliquam in justo varius, sagittis neque ut, malesuada
                leo.
            </p>
        </div>
    </div>
    <div id="splide-marquee" class="splide">
        <div class="splide__track">
            <ul class="splide__list">
                @foreach ($bestSellerBooks as $book)
                    <li class="splide__slide">
                        <a href="{{tenant_route('showBook' , $book->slug)}}">
                            <img src="{{ asset($book->image) }}" alt="" />
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
    <div class="shop d-flex justify-content-center">
        <a href="{{ tenant_route('books') }}" class="main_btn shop_btn text-center">Shop now</a>
    </div>
</section>
