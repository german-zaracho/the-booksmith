<div class="img-slider rounded-[20px]">

    <div class="homeSlide active">
        <img src="{{ asset('assets/imgs/book1.jpg') }}" alt="">
        <div class="info">
            <h2>Looking for a Book?</h2>
            <p>Discover our curated collection of books for every kind of reader. From timeless classics to the latest releases, find your next great read in our catalog.</p>
            <button onclick="window.location='{{ route('shop') }}'" class="rounded-md {{ request()->routeIs('welcome') ? 'bg-[#f09224]' : '' }} px-3 py-2 text-sm myBtn text-white hover:bg-[#fcba50] hover:text-white">
                Go To Shop
            </button>

        </div>
    </div>

    <div class="homeSlide">
        <img src="{{ asset('assets/imgs/news.jpg') }}" alt="">
        <div class="info">
            <h2>Curious About the Literary World?</h2>
            <p>Stay updated with the latest literary news. Explore reviews, publishing highlights, and special articles for passionate readers.</p>
            <button onclick="window.location='{{ route('news') }}'" class="rounded-md {{ request()->routeIs('welcome') ? 'bg-[#f09224]' : '' }} px-3 py-2 text-sm myBtn text-white hover:bg-[#fcba50] hover:text-white">
                Go To News
            </button>

        </div>
    </div>

    <div class="homeSlide">
        <img src="{{ asset('assets/imgs/subscription.jpg') }}" alt="">
        <div class="info">
            <h2>Ready for Monthly Reads?</h2>
            <p>Join our subscription plans and receive a personalized selection of books each month. A tailored reading experience, delivered to your doorstep.</p>
            <button onclick="window.location='{{ route('subscriptions') }}'" class="rounded-md {{ request()->routeIs('welcome') ? 'bg-[#f09224]' : '' }} px-3 py-2 text-sm myBtn text-white hover:bg-[#fcba50] hover:text-white">
                Explore Subscriptions
            </button>
        </div>
    </div>

    <div class="sliderNavigation">
        <div class="homeSliderBtn active"></div>
        <div class="homeSliderBtn"></div>
        <div class="homeSliderBtn"></div>
    </div>

</div>