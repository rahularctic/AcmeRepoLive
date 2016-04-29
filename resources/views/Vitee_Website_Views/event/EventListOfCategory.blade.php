@extends('Vitee_Website_Views.master')


@section('assets')

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" type="text/css" />

@endsection

@section('title')

    <title>{{$category_name[0]->EVENTTYPENAME}} -  Events List </title>

@endsection

@section('page-title')

    <div class="container clearfix">
        <h1>{{$category_name[0]->EVENTTYPENAME}} </h1>
        <span> Events List </span>
        <ol class="breadcrumb">
            <li><a href="#">Home</a></li>
            <li>Events </li>
            <li class="active">{{$category_name[0]->EVENTTYPENAME}}</li>
        </ol>
    </div>

@endsection



@section('content')



    <div class="content-wrap">

        <div class="container clearfix">

            <div class="sidebar nobottommargin clearfix">
                <div class="sidebar-widgets-wrap">

                    <div class="widget widget_links clearfix">

                        <h4>Event Categories</h4>
                        <ul>
                            @foreach($event_categories as $category)

                                <li><a href="{{$category->EVENTTYPEID}}">{{$category->EVENTTYPENAME}}</a></li>

                            @endforeach

                        </ul>

                    </div>



                    <div class="widget clearfix">

                        <h4>Instagram Feed</h4>

                        <div id="instagram-widget" class="instagram-photos masonry-thumbs" data-user="vitee.me" data-count="10" data-type="user"></div>

                    </div>

                    <div id="fb-root"></div>
                    <script>(function(d, s, id) {
                            var js, fjs = d.getElementsByTagName(s)[0];
                            if (d.getElementById(id)) return;
                            js = d.createElement(s); js.id = id;
                            js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.4&appId=752816458098907";
                            fjs.parentNode.insertBefore(js, fjs);
                        }(document, 'script', 'facebook-jssdk'));</script>


                    <div class="widget clearfix">
                        <h4>Facebook Feed</h4>
                        <div class="fb-page" data-href="https://www.facebook.com/vitee.net" data-width="250" data-height="300" data-small-header="false" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true" data-show-posts="true"></div>
                    </div>





                </div>
            </div>



            <div class="postcontent bothsidebar nobottommargin">

                <div id="posts" class="events small-thumbs">



                    @if(count($category_events) == 0)


                        <div class="style-msg" style="background-color: #EEE;">
                            <div class="sb-msg"><i class="icon-question-sign"></i>Sorry !! <strong>No event avilable </strong> in this category</div>
                        </div>

                        @else

                    @foreach($category_events as $event)



                    <div class="entry clearfix">
                        <div class="entry-image">
                            <a href="{{URL('/event/'.$event->EVENTID.'/'. str_replace(' ', '-', $event->EVENTNAME) )}}">
                                <img src="{{asset('/img/event/'.$event->EVENTID.'/header/'.$event->EVENTIMAGE)}}" alt="{{$event->EVENTNAME}}<">
                                <div class="entry-date">{{$event->DAYOFMONTH}}<span>{{$event->MONTHNAME}}</span></div>
                            </a>
                        </div>
                        <div class="entry-c">
                            <div class="entry-title">
                                <h2><a href="{{URL('/event/'.$event->EVENTID.'/'. str_replace(' ', '-', $event->EVENTNAME) )}}">{{$event->EVENTNAME}}</a></h2>
                            </div>
                            <ul class="entry-meta clearfix">
                                <li><span class="label label-warning">Private</span></li>
                                <li><i class="icon-time"></i> {{$event-> STARTTIME}} - {{$event->ENDTIME}}</li>
                                <li><i class="icon-map-marker2"></i> {{$event->EVENTLOCATION}}</li>
                            </ul>
                            <div class="entry-content">
                                <a href="{{URL('/event/'.$event->EVENTID.'/'. str_replace(' ', '-', $event->EVENTNAME) )}}" class="btn btn-info"> <Strong> More Info</Strong> </a>
                            </div>
                        </div>
                    </div>

                    @endforeach


                        @endif

                </div>

                <!-- Pagination
                ============================================= -->

                <ul class="pager nomargin">
                    {!! $category_events->render() !!}
                </ul><!-- .pager end -->

            </div>

            <div class="sidebar nobottommargin col_last clearfix">
                <div class="sidebar-widgets-wrap">

                    <div class="widget clearfix">

                        <h4>Popular Events</h4>
                        <div id="post-list-footer">

                            @foreach($popular_events as $event)

                                <div class="spost clearfix">
                                    <div class="entry-image">
                                        <a href="{{URL('/event/'.$event['EVENTID'])}}"><img src="{{asset('/img/event/'.$event['EVENTID'].'/thumbnails/'.$event->EVENTIMAGE)}}" alt="{{$event['EVENTNAME']}}"></a>
                                    </div>
                                    <div class="entry-c">
                                        <div class="entry-title">
                                            <h4><a href="{{URL('/event/'.$event['EVENTID'])}}">{{$event['EVENTNAME']}}</a></h4>
                                        </div>

                                        <ul class="entry-meta">
                                            @if($event['EVENTPAID'] == 1)
                                                <li><span class="label label-primary">Paid</span></li>
                                            @else
                                                <li><span class="label label-success">Free</span></li>
                                            @endif

                                            <li>
                                                @for ($i = 0; $i < $event['0']; $i++)
                                                    <i class="icon-star3" style="color:#f47932;"></i>
                                                @endfor
                                            </li>

                                        </ul>
                                    </div>
                                </div>

                            @endforeach


                        </div>

                    </div>



                    <div class="widget clearfix">

                        <h4>Recent Created Events</h4>
                        <div id="post-list-footer">

                            @foreach($recent_created_events as $event)

                                <div class="spost clearfix">
                                    <div class="entry-image">
                                        <a href="{{URL('/event/'.$event->EVENTID.'/'. str_replace(' ', '-', $event->EVENTNAME) )}}"><img src="{{asset('/img/event/'.$event->EVENTID.'/thumbnails/'.$event->EVENTIMAGE)}}" alt="{{$event->EVENTNAME}}<"></a>
                                    </div>
                                    <div class="entry-c">
                                        <div class="entry-title">
                                            <h4><a href="#">{{$event->EVENTNAME}}</a></h4>
                                        </div>
                                        <ul class="entry-meta">
                                            @if($event->EVENTPAID == 1)

                                                <li><span class="label label-primary">Paid</span></li>
                                            @else
                                                <li><span class="label label-success">Free</span></li>
                                            @endif

                                        </ul>
                                    </div>
                                </div>

                            @endforeach

                        </div>

                    </div>




                    </div>

                </div>
            </div>

        </div>

    </div>


 @endsection