@extends('front.parent')
@section('content')

<section class="section-news mt-5 mb-2 ml-lg-5">
    <div class="row justify-content-center">
        <div class="col-lg-8 mb-5 text-center">
            <div class="main_title">
                <h2 class="top_title" style="color: #8D5BF9;">Cybersecurity </h2>
                <h5>This page provides the information to describe the cybersecurity basics, and why cybersecurity is important for organizations, how cybersecurity provides values, goals, and objectives of cybersecurity. The lesson will be provided in different
                    levels divided into Cybersecurity Level One, Two, and Three to let the user understand the concept.</h5>
            </div>



        </div>
    </div>
</section>
<section class="blog_area">

    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <div class="blog_left_sidebar">


                    @forelse ($items as $item)
                    <article class="row blog_item">
                      <div class="col-md-3">

                      </div>
                       <div class="col-md-9">
                            <br><br>
                            <h2>
                                @switch($item->pages)
                                @case(1)
                                    {{ "level one" }}
                                    @break
                            @case(2)
                                {{ "level two" }}
                                @break
                            @case(3)
                                {{ "level three" }}
                                @break

                                @default

                            @endswitch
                            </h2>


                            <br><br>
                           <div class="blog_post">

                              <a href=""><img src="{{ $item->image_path }}" style="width: 600px"  class="img-thumbnail" alt="">


                          </a>
                          {{-- <h1>{{ $item->title }}</h1> --}}
                          @php
                              $count = \App\Models\Rating::where('user_id', auth()->id())->where('cybersecurity_id', $item->id)->latest()->first();
                          @endphp

                          @if ($count == null)

                              @for ($i = 1; $i < 6; $i++)

                                <span class="fa fa-star" data-count="{{ $i }}" data-id="{{ $item->id }}" data-user-id="{{ auth()->id() }}"></span>

                              @endfor

                          @else

                              @for ($i = 1; $i < 6; $i++)

                                <span class="fa fa-star {{ $count->count >= $i ? 'checked' : '' }}" data-count="{{ $i }}" data-id="{{ $item->id }}" data-user-id="{{ auth()->id() }}"></span>

                              @endfor

                          @endif

                           <div class="my-rating"></div>
                                   <a href="{{ route('cyberDetails',$item->id) }}"><h2>{{ $item->title }}</h2></a>
                                   {{-- @for ($i = 0; $i < $item->rating; $i++)
                                       <i class="fa fa-star"></i>
                                   @endfor --}}
                                   <p>{{ \Illuminate\Support\Str::limit(strip_tags($item->description),50) }}</p>
                               </div>
                           </div>
                       </div>
                   </article>
                      @empty
                      <h3 style="text-align: center">No Data Found</h3>
                  @endforelse

                    <nav class="blog-pagination justify-content-center d-flex">
                        <ul class="pagination">
                            <li class="page-item">


                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
            <div class="col-lg-4">

            </div>
        </div>
    </div>
</section>
@endsection
