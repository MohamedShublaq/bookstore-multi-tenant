@extends('Dashboard.Layouts.app')

@section('title', 'Show Book')

@push('style')
    <style>
        .book-details-card {
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
            overflow: hidden;
        }

        .book-cover {
            width: 100%;
            height: 380px;
            object-fit: cover;
            border-radius: 12px;
        }

        .book-meta span {
            display: inline-block;
            background: #f3f4f6;
            color: #333;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 13px;
            margin-right: 6px;
            margin-bottom: 6px;
        }

        .book-info h4 {
            font-weight: 600;
            color: #222;
        }

        .book-info p {
            color: #666;
            font-size: 15px;
        }

        .info-label {
            font-weight: 600;
            color: #555;
        }

        .divider {
            border-top: 1px solid #e4e4e4;
            margin: 15px 0;
        }
    </style>
@endpush

@section('content')
    <div class="app-content content">
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-6 col-12 mb-2">
                    <h3 class="content-header-title">Book Details</h3>
                </div>
            </div>

            <div class="content-body w-100">
                <div class="col-md-10 mx-auto">
                    <div class="card book-details-card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-5 text-center">
                                    @if ($book->image && file_exists(public_path($book->image)))
                                        <img src="{{ asset($book->image) }}" alt="{{ $book->name }}"
                                            class="book-cover mb-2">
                                    @else
                                        <div class="d-flex align-items-center justify-content-center book-cover mb-2 bg-light text-muted"
                                            style="font-size: 16px;">
                                            This book has no image
                                        </div>
                                    @endif
                                    <div class="book-meta">
                                        <span><i class="la la-layer-group"></i> {{ $book->category?->name }}</span>
                                        <span><i class="la la-language"></i> {{ $book->language?->name }}</span>
                                        <span><i class="la la-user"></i> {{ $book->author?->name }}</span>
                                        <span><i class="la la-building"></i> {{ $book->publisher?->name }}</span>
                                    </div>
                                </div>

                                <div class="col-md-7">
                                    <div class="book-info">
                                        <h4>{{ $book->name }}</h4>
                                        <p>{{ $book->description ?? 'No description available.' }}</p>

                                        <div class="divider"></div>

                                        <p><span class="info-label">Price:</span> {{ number_format($book->price, 2) }}</p>
                                        <p><span class="info-label">Pages:</span> {{ $book->pages }}</p>
                                        <p><span class="info-label">Total Stock:</span> {{ $book->total_stock }}</p>
                                        <p><span class="info-label">Quantity:</span> {{ $book->quantity }}</p>
                                        <p><span class="info-label">Publish Year:</span> {{ $book->publish_year }}</p>
                                        <p><span class="info-label">Rate:</span>
                                            ⭐ {{ $book->rate }} / 5
                                        </p>
                                        <p><span class="info-label">Availability:</span>
                                            @if ($book->is_available)
                                                <span class="badge badge-success">Available</span>
                                            @else
                                                <span class="badge badge-danger">Unavailable</span>
                                            @endif
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="divider"></div>

                            <div class="text-right">
                                <a href="{{ route('library.books.edit', $book->slug) }}" class="btn btn-primary">
                                    <i class="la la-edit"></i> Edit
                                </a>
                                <a href="{{ route('library.books.index') }}" class="btn btn-secondary">
                                    <i class="la la-arrow-left"></i> Back
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
