@extends('site.layout.main')

@section('content')

<div id="top"></div>

<section aria-label="section">
    <div class="container">
        <div class="row">
            @include('site.user.personal.part.head')

            <div class="col-md-12">
                <div class="de_tab tab_simple">

                    @include('site.user.personal.part.nav')
                    
                    <div class="de_tab_content">
                        
                        

                        <div class="mt-5">
                            {{ $products->links('site.dop.paginate') }}
                        </div>
                        
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</section>

@endsection