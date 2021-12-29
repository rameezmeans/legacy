@extends('layouts.basic')

@section('meta-tags')
    @include('partials.meta-tags', array('page' => 'our_yachts'))
@stop

@section('body-class', 'our-yachts')

@section('content')
<div class="home-banner innerpage row yacht-banner" style="background-image: url({{ asset('images/yacht-sirara-banner.jpg') }});" title="Luxury Yacht Sirara in San Diego Bay">
    <div class="transparent">
        <div class="wrapper">
            <div class="banner-description">
                <div>
                    <h2>EXPERIENCE</h2>
                    <strong>THE SIRARA</strong>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="yacht-content">
    <div class="wrapper">
        <h1>TOUR THE FINEST LUXURY YACHT IN SAN DIEGO</h1>
        <div class="video-container">
            <img src="{{ asset('images/yacht-sirara-video-coming-soon.jpg') }}" width="100%" alt="Luxury Yacht Sirara - video footage coming soon">
           <!--  <div class="play-icon2"></div>
            <iframe width="560" height="315" src="https://www.youtube.com/embed/eN5RYuh6Qeg?rel=0&amp;controls=0&amp;showinfo=0" frameborder="0" allowfullscreen></iframe> -->
        </div>
        <a href="{{ url('/book-now') }}">Booking & Pricing Details</a>
        <p>When you host an event on the Sirara, you feel as though you are the owner of a magnificent vessel, built for beauty and pleasure. You have at your command an experienced captain and dedicated crew to ensure smooth sailing and fulfill your expectations for safety and comfort.</p>
        <ul>
            <li>Custom-built 65 foot luxury cruising yacht, US Coast Guard certified for up to 120 guests</li>
            <li>Totally renovated and enhanced this year to give you the feeling of a totally new boat while retaining its classic design and innovative architecture</li>
            <li>Over 1,500 square feet of entertainment space on two decks with newly-constructed upscale amenities</li>
            <li>Lower enclosed main deck, with flexible seating arrangement, open social/dance ﬂoor, two luxury restrooms and a full bar</li>
            <li>Top open deck with expansive 360 degree views of San Diego Bay along with an exclusive VIP area</li>
            <li>Fully customizable LED lighting throughout the interior and exterior of the yacht</li>
            <li>Integrated state of the art multimedia system for DJ and live music entertainment</li>
        </ul>
        <div class="photos-section">
            <ul> 
                <li><img src="{{ asset('images/gallery-small-7.jpg') }}" alt="Sirara front view" data-toggle="modal" data-target="#myModal7"></li>
                <li><img src="{{ asset('images/gallery-small-6.jpg') }}" alt="Sirara top view" data-toggle="modal" data-target="#myModal6"></li> 
                <li><img src="{{ asset('images/gallery-small-8.jpg') }}" alt="Sirara outside view" data-toggle="modal" data-target="#myModal8"></li> 
                <li><img src="{{ asset('images/gallery-small-1.jpg') }}" alt="Sirara inside view with guests" data-toggle="modal" data-target="#myModal1"></li>
                <li><img src="{{ asset('images/gallery-small-2.jpg') }}" alt="Sirara inside view" data-toggle="modal" data-target="#myModal2"></li>
                <li><img src="{{ asset('images/gallery-small-3.jpg') }}" alt="Sirara bar view with guests" data-toggle="modal" data-target="#myModal3"></li>
                <li><img src="{{ asset('images/gallery-small-4.jpg') }}" alt="Sirara bar view" data-toggle="modal" data-target="#myModal4"></li>
                <li><img src="{{ asset('images/gallery-small-5.jpg') }}" alt="Sirara inside view" data-toggle="modal" data-target="#myModal5"></li> 
            </ul>
        </div>
        <h2>Her History</h2>
        <hr>
        <p>The luxury commercial yacht Sirara was originally constructed by Potomac Riverboat Company for luxury touring in our nation’s capital prior to the Bicentennial Year and thus named the Spirit of ’76. Willem Polak, founder of the company, commissioned and funded its construction with an ingenious design and architecture inspired by the luxury boats which plied the canals of his native Holland, while employing best-in-class innovative American boat-building techniques.</p>
        <p>The yacht was designed by American architect Charles W. Wittholz and constructed by John H. Collamore III, whose Virginia-based Hulls Unlimited-East, Inc. completed the vessel in 1975. He provided Legacy with all the architectural and construction plans of the vessel, so we had every advantage in our complete overhaul and inspired renovation. </p>

        
        <!-- <a href="{{ url('/book-now') }}">Book Now</a> -->
        <br><br>
    </div>
</div>

<!-- <div class="testimonial">
    <div class="wrapper">

        <div class="ph-icon">
            <img src="{{ asset('images/icon1.png') }}" alt="">
        </div>

        <h1>TESTIMONIALS</h1>
        <ul>
            <li>
                <p><strong>''</strong> This was our first cruise and we were impressed by every crew member's attitude and eagerness to serve. Would be hard to top SeaDream. You have set the bar very high! <strong>''</strong></p>
                <h2>Mr & Mrs Arthur Swanson</h2>
                <h3>Oklahoma City, OK</h3>
            </li>
            <li>
                <p><strong>''</strong> The pedicures my husband and I had on deck as we sailed out of Civitavecchia to begin the voyage were fantastic <strong>''</strong></p>
                <h2>Mrs Betsy Brown</h2>
                <h3>Falmounth, Maime</h3>
            </li>
        </ul>
    </div>
</div>  -->

<!-- Modal -->
<div id="myModal1" class="modal fade photo-model" role="dialog">
    <div class="modal-dialog">  
        <div class="modal-content">  
            <img src="{{ asset('images/gallery-big-1.jpg') }}" alt="Sirara front view">
             <button type="button" class="closebtn" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
            </button>
        </div>
    </div>
</div>
<div id="myModal2" class="modal fade photo-model" role="dialog">
    <div class="modal-dialog">  
        <div class="modal-content">  
            <img src="{{ asset('images/gallery-big-2.jpg') }}" alt="Sirara top view">
             <button type="button" class="closebtn" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
            </button>
        </div>
    </div>
</div>
<div id="myModal3" class="modal fade photo-model" role="dialog">
    <div class="modal-dialog">  
        <div class="modal-content">  
            <img src="{{ asset('images/gallery-big-3.jpg') }}" alt="Sirara outside view">
             <button type="button" class="closebtn" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
            </button>
        </div>
    </div>
</div>
<div id="myModal4" class="modal fade photo-model" role="dialog">
    <div class="modal-dialog">  
        <div class="modal-content">  
            <img src="{{ asset('images/gallery-big-4.jpg') }}" alt="Sirara inside view with guests">
             <button type="button" class="closebtn" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
            </button>
        </div>
    </div>
</div>
<div id="myModal5" class="modal fade photo-model" role="dialog">
    <div class="modal-dialog">  
        <div class="modal-content"> 
            <img src="{{ asset('images/gallery-big-5.jpg') }}" alt="Sirara inside view">
             <button type="button" class="closebtn" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
            </button>
        </div>
    </div>
</div> 
<div id="myModal6" class="modal fade photo-model" role="dialog">
    <div class="modal-dialog">  
        <div class="modal-content"> 
            <img src="{{ asset('images/gallery-big-6.jpg') }}" alt="Sirara bar view with guests">
             <button type="button" class="closebtn" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
            </button>
        </div>
    </div>
</div> 
<div id="myModal7" class="modal fade photo-model" role="dialog">
    <div class="modal-dialog">  
        <div class="modal-content"> 
            <img src="{{ asset('images/gallery-big-7.jpg') }}" alt="Sirara bar view">
             <button type="button" class="closebtn" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
            </button>
        </div>
    </div>
</div> 
<div id="myModal8" class="modal fade photo-model" role="dialog">
    <div class="modal-dialog">  
        <div class="modal-content"> 
            <img src="{{ asset('images/gallery-big-8.jpg') }}" alt="Sirara inside view">
             <button type="button" class="closebtn" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
            </button>
        </div>
    </div>
</div> 
@endsection
