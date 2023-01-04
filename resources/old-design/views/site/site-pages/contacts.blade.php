@extends('site.layout.main')

@section('content')
<div class="no-bottom no-top" id="content" style="background-size: cover;" bis_skin_checked="1">
    <div id="top" style="background-size: cover;" bis_skin_checked="1"></div>
    
    <!-- section begin -->
    <section id="subheader" style="background-size: cover;">

        <div class="center-y relative text-center mt-30" style="background-size: cover;" bis_skin_checked="1">
            <div class="container" style="background-size: cover;" bis_skin_checked="1">
                <div class="row" style="background-size: cover;" bis_skin_checked="1">
                    <div class="col-md-8 offset-md-2" style="background-size: cover;" bis_skin_checked="1">
                    <div class="col text-center" style="background-size: cover;" bis_skin_checked="1">
                        <div class="spacer-single" style="background-size: cover;" bis_skin_checked="1"></div>
                        <h1>{{ $page->name }}</h1>
                    </div>
                    <div class="clearfix" style="background-size: cover;" bis_skin_checked="1"></div>
                </div>
                </div>
            </div>
        </div>

    </section>
    <!-- section close -->

    <!-- section begin -->
    <section aria-label="section" style="background-size: cover;">
        <div class="container" style="background-size: cover;" bis_skin_checked="1">
            <div class="row" style="background-size: cover;" bis_skin_checked="1">
                
                <div class="col-md-3"></div>
                <div class="col-md-6">
                    @php echo nl2br(htmlspecialchars($page->content)) @endphp
                </div>

            </div>
        </div>
    </section>

</div>

@endsection