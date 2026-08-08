@extends('frontend.layout.master')

@section('content')

<div class="container py-5 min-vh-100">
    <div class="row">

        <!-- Main Blog Section -->
        <div class="col-lg-8 col-12 mb-4">
            <div class="blog-main-content pr-lg-4">

                <!-- Breadcrumbs (Manual implementation) -->
                <nav aria-label="breadcrumb" class="mb-4">
                    <ol class="breadcrumb bg-transparent p-0" style="font-size: 14px;">
                        <li class="breadcrumb-item"><a href="/" style="color: var(--primary-color, #400e2f);">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('front.getBlog') }}" style="color: var(--primary-color, #400e2f);">Blog</a></li>
                        <li class="breadcrumb-item active text-muted" aria-current="page">{{ Str::limit($blog->title, 20) }}</li>
                    </ol>
                </nav>

                <!-- Blog Title -->
                <h1 class="mb-3 font-weight-bold" style="font-family: 'Poppins', sans-serif; color: #2c2c2c; font-size: 2.5rem; line-height: 1.2;">
                    {{ $blog->title }}
                </h1>

                <!-- Blog Meta -->
                <div class="mb-4 text-muted small d-flex align-items-center">
                    <span class="mr-3"><i class="far fa-calendar-alt mr-1"></i> {{ date('F d, Y', strtotime($blog->created_at ?? now())) }}</span>
                    <span><i class="far fa-user mr-1"></i> Admin</span>
                </div>

                <!-- Blog Image/Video -->
                <div class="mb-4 shadow-sm" style="border-radius: 15px; overflow: hidden; border: 1px solid #eee;">
                    @php
                        $extension = pathinfo($blog->blogImage, PATHINFO_EXTENSION);
                        $videoExtensions = ['mp4', 'webm', 'ogg'];
                    @endphp

                    @if(in_array($extension, $videoExtensions))
                        <video class="w-100" controls style="display: block; max-height: 450px; background: #000;">
                            <source src="{{ asset($blog->blogImage) }}" type="video/{{ $extension }}">
                            Your browser does not support the video tag.
                        </video>
                    @else
                        <img src="{{ Str::startsWith($blog->blogImage, ['http://','https://']) ? $blog->blogImage : '/' . $blog->blogImage }}"
                             onerror="this.onerror=null;this.src='/build/assets/images/person.png';"
                             class="img-fluid w-100"
                             style="cursor: pointer; max-height: 500px; object-fit: cover;"
                             onclick="openImage('{{ $blog->blogImage }}')" alt="{{ $blog->title }}">
                    @endif
                </div>

                <!-- Blog Description -->
                <div class="blog-content fs-5" style="line-height: 1.8; color: #444; font-family: 'Roboto', sans-serif;">
                    {!! $blog->description !!}
                </div>
            </div>
        </div>


        <!-- Sidebar Section -->
        <div class="col-lg-4 col-12 mt-4 mt-lg-0">

            <div class="sticky-top" style="top: 100px; z-index: 10;">
                <div class="bg-white shadow-sm border rounded p-5 mb-4" style="border-radius: 15px !important;">
                    <h4 class="mb-4 font-weight-bold position-relative pb-2" style="color: var(--primary-color, #400e2f);">
                        Explore More
                        <span style="position: absolute; bottom: 0; left: 0; width: 40px; height: 3px; background-color: var(--primary-color, #400e2f);"></span>
                    </h4>

                    @foreach ($latestBlogs as $index => $latest)
                        @php
                            $extension = pathinfo($latest->blogImage, PATHINFO_EXTENSION);
                            $videoExtensions = ['mp4', 'webm', 'ogg'];
                        @endphp

                        <div class="media mb-4 pb-3 border-bottom border-light align-items-center">
                            @if(in_array($extension, $videoExtensions))
                                <video class="rounded mr-3" width="70" height="70" style="object-fit: cover; border-radius: 10px;" muted>
                                    <source src="{{ asset($latest->blogImage) }}" type="video/{{ $extension }}">
                                </video>
                            @else
                                <img src="{{ Str::startsWith($latest->blogImage, ['http://','https://']) ? $latest->blogImage : '/' . $latest->blogImage }}"
                                     onerror="this.onerror=null;this.src='/build/assets/images/person.png';"
                                     class="rounded mr-3" width="70" height="70"
                                     style="object-fit: cover; border-radius: 10px; cursor:pointer;"
                                     onclick="openImage('{{ $latest->blogImage }}')" alt="{{ $latest->title }}">
                            @endif

                            <div class="media-body text-truncate-custom">
                                <a href="{{ route('front.getBlogDetails', $latest->slug) }}"
                                   class="font-weight-bold text-dark d-block mb-1 text-decoration-none transition-color"
                                   style="font-size: 0.95rem; line-height: 1.3;">
                                   {{ Str::limit($latest->title, 45) }}
                                </a>
                                <small class="text-muted">{{ date('M d, Y', strtotime($latest->created_at ?? now())) }}</small>
                            </div>
                        </div>
                    @endforeach

                </div>
            </div>

        </div>


    </div>
</div>

<style>
    .transition-color {
        transition: color 0.3s ease;
    }
    .transition-color:hover {
        color: var(--primary-color, #400e2f) !important;
    }
    .blog-content p {
        margin-bottom: 1.5rem;
    }
    .blog-content h2, .blog-content h3 {
        margin-top: 2rem;
        margin-bottom: 1rem;
        font-weight: 700;
        color: #2c2c2c;
    }
    .media:hover {
        background-color: #fafafa;
        transition: background-color 0.3s;
    }
    .text-truncate-custom {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-overflow: ellipsis;
        max-height: 2.6em;
    }
    @media (max-width: 576px) {
        .blog-main-content {
            padding-right: 0 !important;
        }
    }
</style>


@endsection
