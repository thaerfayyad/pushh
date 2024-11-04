@extends('front.parent')
@section('content')
<section class="section-news mt-5 mb-5 ml-lg-5">
    <div class="row justify-content-center">
        <div class="col-lg-8 mb-2 text-center">
            <div class="main_title">
                {{--  <p class="top_title" style="color: #8D5BF9;">International Cybersecurity   </p>  --}}
                <h2 style="color: #8D5BF9;"> INTERNATIONAL CYBERSECURITY  </h2>

                <h5>Cybersecurity standards are collections of best practices created by experts to protect organizations from cyber threats and help improve their cybersecurity posture. And the Cybersecurity frameworks are generally applicable to all organizations, regardless of their size, industry, or sector.
                    This page listing most of the common international cyber security standards that form a strong basis for any cybersecurity strategy
                     .</h5>
            </div>



        </div>
    </div>
</section>
<section class="section-news mt-5 mb-5">

    <div class="row justify-content-center">
        <div class="col-lg-8 mb-5 text-center">
            <div class="main_title">

                {{--  <h2 style="color: #8D5BF9;"> INTERNATIONAL CYBERSECURITY  </h2>  --}}
            </div>



        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="">
                    @forelse ($items as $item )
                        <div class="new1 row">
                            <div class="col-md-10 left-div">
                            <a  href="https://{{ $item->link }}" target="_blank"><h3>{{ $item->title }}</h3></a>
                            <p>{{ $item->description }} </p>
                            </div>
                            <div class="col-md-2">

                                <img src="{{ $item->image_path }}" width="100"  alt="">
                            </div>
                        </div>
                    @empty
                            <h3 style="text-align: center"> NO Data Found</h3>
                    @endforelse
                </div>
            </div>

        </div>
    </div>
</section>

@endsection
