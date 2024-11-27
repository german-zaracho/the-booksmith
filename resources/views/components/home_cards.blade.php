<div class="cardsWrapper">

    <article class="card">
        <img
            class="card__background"
            src="{{ asset('assets/imgs/books/sleepTight.jpg') }}"
            alt="Sleep Tight"
            width="1315"
            height="1500" />
        <div class="card__content | flow">
            <div class="card__content--container | flow">
                <h2 class="card__title">Sleep Tight</h2>
                <p class="card__description">
                    When the police finally found his "House of Horrors," they uncovered nineteen bodies and one survivor.
                </p>
            </div>
            <!-- <button class="card__button myBtn">See Details</button> -->
            <button
                class="card__button myBtn"
                onclick="window.location.href='{{ route('shop.detail', ['id' => 1]) }}'">
                See Details
            </button>
        </div>
    </article>

    <article class="card">
        <img
            class="card__background"
            src="{{ asset('assets/imgs/books/1984.jpg') }}"
            alt="1984"
            width="1315"
            height="1500" />
        <div class="card__content | flow">
            <div class="card__content--container | flow">
                <h2 class="card__title">1984</h2>
                <p class="card__description">
                    In 1984, London is a grim city in the totalitarian state of Oceania where Big Brother is always watching you.
                </p>
            </div>
            <!-- <button class="card__button myBtn">See Details</button> -->
            <button
                class="card__button myBtn"
                onclick="window.location.href='{{ route('shop.detail', ['id' => 3]) }}'">
                See Details
            </button>
        </div>
    </article>

    <article class="card">
        <img
            class="card__background"
            src="{{ asset('assets/imgs/books/william.jpg') }}"
            alt="William"
            width="1315"
            height="1500" />
        <div class="card__content | flow">
            <div class="card__content--container | flow">
                <h2 class="card__title">William</h2>
                <p class="card__description">
                    Henry has achieved the breakthrough of his career. He created an artificially intelligent consciousness, William.
                </p>
            </div>
            <!-- <button class="card__button myBtn">See Details</button> -->
            <button
                class="card__button myBtn"
                onclick="window.location.href='{{ route('shop.detail', ['id' => 6]) }}'">
                See Details
            </button>
        </div>
    </article>

</div>