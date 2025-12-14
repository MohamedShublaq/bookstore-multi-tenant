@extends('Website.Layouts.app')

@push('css')
    <link rel="stylesheet" href="{{ asset('assets/Website/css/home.css') }}" />
@endpush

@section('title', 'Home')

@section('hero_content')
    <div class="search">
        <div class="search-container">
            <div class="search_input">
                <input type="text" id="searchInput" placeholder="Search">
                <button><i class="fa fa-search"></i></button>
            </div>
        </div>
    </div>
@endsection

@section('content')

    @include('Website.__featuresSection')

    {{-- @include('Website.__bestSellerSection') --}}

    @include('Website.__recommendedSection')

    {{-- @if ($flashSaleBooks->count() > 0)
        @include('Website.__flashSaleSection')
    @endif --}}

@endsection

@push('js')
    <script src="path-to-the-script/splide-extension-auto-scroll.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@splidejs/splide@latest/dist/js/splide.min.js"></script>
    <script src="{{ asset('assets/Website/js/home.js') }}"></script>

    {{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        var bookRoute = "{{ route('showBook', ':slug') }}";
    </script>
    <script>
        // Handle input change and make the AJAX request
        $('#searchInput').on('input', function() {
            let searchTerm = $(this).val().toLowerCase();

            if (searchTerm.length > 0) {
                $('.search_input').addClass('searching');

                $.ajax({
                    url: "{{ route('search') }}",
                    method: "GET",
                    data: {
                        search: searchTerm
                    },
                    success: function(response) {
                        let resultsContainer = $('#searchResults');

                        if (resultsContainer.length === 0) {

                            resultsContainer = $('<ul class="search-results" id="searchResults"></ul>');
                            $(resultsContainer).insertAfter($('#searchInput').closest(
                                '.search_input'));

                        }

                        resultsContainer.empty();

                        if (response.length > 0) {

                            response.forEach(function(book) {
                                let resultItem = "";

                                if (book.name.toLowerCase().includes(searchTerm)) {

                                    let highlightedName = book.name.replace(new RegExp(
                                        `(${searchTerm})`, "gi"), "<strong>$1</strong>");
                                    let bookUrl = bookRoute.replace(':slug', book.slug);
                                    resultItem =
                                        `<li class="search-item"><a href="${bookUrl}">${highlightedName}</a></li>`;

                                } else if (book.description.toLowerCase().includes(
                                        searchTerm)) {

                                    let description = book.description.toLowerCase();
                                    let matchIndex = description.indexOf(searchTerm);

                                    if (matchIndex !== -1) {
                                        let start = Math.max(0, matchIndex - 30);
                                        let end = Math.min(description.length, matchIndex +
                                            searchTerm.length + 30);
                                        let snippet = book.description.substring(start, end);
                                        // Highlight the matched term
                                        snippet = snippet.replace(new RegExp(`(${searchTerm})`,
                                            "gi"), "<strong>$1</strong>");
                                        // Remove leading "..." if the search term is at the start
                                        let prefix = start > 0 ? "..." : "";
                                        let suffix = end < description.length ? "..." : "";

                                        let bookUrl = bookRoute.replace(':slug', book.slug);
                                        resultItem =
                                            `<li class="search-item"><a href="${bookUrl}">${prefix}${snippet}${suffix}</a></li>`;
                                    }
                                }

                                if (resultItem) {
                                    resultsContainer.append(resultItem);
                                }
                            });
                        } else {
                            resultsContainer.append('<li class="search-item">No books found</li>');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.log("Error:", error);
                    }
                });
            } else {
                $('.search_input').removeClass('searching');
                $('#searchResults').remove();
            }
        });
    </script> --}}
@endpush
