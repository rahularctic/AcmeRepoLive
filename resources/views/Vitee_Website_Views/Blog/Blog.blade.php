@extends('Vitee_Website_Views.master')


@section('title')

    <title>Vitee Blog </title>

@endsection


@section('page-title')

    <div class="container clearfix">
        <h1>Blog </h1>
        <span> Posts</span>
        <ol class="breadcrumb">
            <li><a href="#">Home</a></li>
            <li class="active">Blog</li>
        </ol>
    </div>

@endsection


@section('nav-bar')



    <ul>
        <li><a href="{{URL('/')}}"><div>Home</div></a>

        </li>
        <li><a href="#"><div>Events</div></a>

            <ul>
                <li><a href="#"><div>Popular Events</div></a></li>
                <li><a href="#"><div>Latest Events</div></a></li>
                <li><a href="#"><div>Featured Events</div></a></li>
            </ul>

        </li>
        <li class="mega-menu"><a href="{{URL('/about')}}"><div>About</div></a></li>
        <li class=" current mega-menu"><a href="{{URL('/blog')}}"><div>Blog</div></a></li>
        <li class="mega-menu"><a href="{{URL('/contact')}}"><div>Contact us</div></a>

        </li>

    </ul>




@endsection



@section('content')

    <div class="content-wrap">

        <div class="container clearfix">

            <!-- Post Content
            ============================================= -->
            <div class="postcontent nobottommargin clearfix">

                <!-- Posts
                ============================================= -->
                <div id="posts" class="post-grid grid-2 clearfix">

                    <div class="entry clearfix">
                        <div class="entry-image">
                            <a href="" data-lightbox="image"><img style="opacity: 1;" class="image_fade" src="{{asset('Vitee_Website_Assets/images/blog/1.jpg')}}" alt="Standard Post with Image"></a>
                        </div>
                        <div class="entry-title">
                            <h2><a href="blog-single.html">Events in Bahrain with Vitee</a></h2>
                        </div>
                        <ul class="entry-meta clearfix">
                            <li><i class="icon-calendar3"></i> 10th Feb 2014</li>
                            <li><a href="blog-single.html#comments"><i class="icon-comments"></i> 13</a></li>
                            <li><a href="#"><i class="icon-camera-retro"></i></a></li>
                        </ul>
                        <div class="entry-content">
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ratione, voluptatem, dolorem animi nisi autem blanditiis enim culpa reiciendis et explicabo tenetur!</p>
                            <a href="blog-single.html" class="more-link">Read More</a>
                        </div>
                    </div>



                    <div class="entry clearfix">
                        <div class="entry-image">
                            <a href="" data-lightbox="image"><img style="opacity: 1;" class="image_fade" src="{{asset('Vitee_Website_Assets/images/blog/2.jpg')}}" alt="Standard Post with Image"></a>
                        </div>
                        <div class="entry-title">
                            <h2><a href="blog-single.html">Vitee’s Top Event Picks</a></h2>
                        </div>
                        <ul class="entry-meta clearfix">
                            <li><i class="icon-calendar3"></i> 10th Feb 2014</li>
                            <li><a href="blog-single.html#comments"><i class="icon-comments"></i> 13</a></li>
                            <li><a href="#"><i class="icon-camera-retro"></i></a></li>
                        </ul>
                        <div class="entry-content">
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ratione, voluptatem, dolorem animi nisi autem blanditiis enim culpa reiciendis et explicabo tenetur!</p>
                            <a href="blog-single.html" class="more-link">Read More</a>
                        </div>
                    </div>



                    <div class="entry clearfix">
                        <div class="entry-image">
                            <a href="" data-lightbox="image"><img style="opacity: 1;" class="image_fade" src="{{asset('Vitee_Website_Assets/images/blog/3.jpg')}}" alt="Standard Post with Image"></a>
                        </div>
                        <div class="entry-title">
                            <h2><a href="blog-single.html">Vitee…. It’s here.</a></h2>
                        </div>
                        <ul class="entry-meta clearfix">
                            <li><i class="icon-calendar3"></i> 10th Feb 2014</li>
                            <li><a href="blog-single.html#comments"><i class="icon-comments"></i> 13</a></li>
                            <li><a href="#"><i class="icon-camera-retro"></i></a></li>
                        </ul>
                        <div class="entry-content">
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ratione, voluptatem, dolorem animi nisi autem blanditiis enim culpa reiciendis et explicabo tenetur!</p>
                            <a href="blog-single.html" class="more-link">Read More</a>
                        </div>
                    </div>



                    <div class="entry clearfix">
                        <div class="entry-image">
                            <a href="" data-lightbox="image"><img style="opacity: 1;" class="image_fade" src="{{asset('Vitee_Website_Assets/images/blog/4.jpg')}}" alt="Standard Post with Image"></a>
                        </div>
                        <div class="entry-title">
                            <h2><a href="blog-single.html">Where are we now?</a></h2>
                        </div>
                        <ul class="entry-meta clearfix">
                            <li><i class="icon-calendar3"></i> 10th Feb 2014</li>
                            <li><a href="blog-single.html#comments"><i class="icon-comments"></i> 13</a></li>
                            <li><a href="#"><i class="icon-camera-retro"></i></a></li>
                        </ul>
                        <div class="entry-content">
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ratione, voluptatem, dolorem animi nisi autem blanditiis enim culpa reiciendis et explicabo tenetur!</p>
                            <a href="blog-single.html" class="more-link">Read More</a>
                        </div>
                    </div>





                    <div class="entry clearfix">
                        <div class="entry-image">
                            <a href="" data-lightbox="image"><img style="opacity: 1;" class="image_fade" src="{{asset('Vitee_Website_Assets/images/blog/5.jpg')}}" alt="Standard Post with Image"></a>
                        </div>
                        <div class="entry-title">
                            <h2><a href="blog-single.html">In the beginning</a></h2>
                        </div>
                        <ul class="entry-meta clearfix">
                            <li><i class="icon-calendar3"></i> 10th Feb 2014</li>
                            <li><a href="blog-single.html#comments"><i class="icon-comments"></i> 13</a></li>
                            <li><a href="#"><i class="icon-camera-retro"></i></a></li>
                        </ul>
                        <div class="entry-content">
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ratione, voluptatem, dolorem animi nisi autem blanditiis enim culpa reiciendis et explicabo tenetur!</p>
                            <a href="blog-single.html" class="more-link">Read More</a>
                        </div>
                    </div>







                </div><!-- #posts end -->

                <!-- Pagination
                ============================================= -->
                <ul class="pager nomargin">
                    <li class="previous"><a href="#">← Older</a></li>
                    <li class="next"><a href="#">Newer →</a></li>
                </ul><!-- .pager end -->

            </div><!-- .postcontent end -->

            <!-- Sidebar
            ============================================= -->
            <div class="sidebar nobottommargin col_last clearfix">
                <div class="sidebar-widgets-wrap">

                    <div class="widget widget-twitter-feed clearfix">

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

                        <h4>Facebook Posts</h4>
                        <div class="fb-page" data-href="https://www.facebook.com/vitee.net" data-width="250" data-height="300" data-small-header="false" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true" data-show-posts="true"></div>


                    </div>



                    <div class="widget clearfix">

                        <div class="tabs nobottommargin clearfix ui-tabs ui-widget ui-widget-content ui-corner-all" id="sidebar-tabs">

                            <ul role="tablist" class="tab-nav clearfix ui-tabs-nav ui-helper-reset ui-helper-clearfix ui-widget-header ui-corner-all">
                                <li aria-selected="true" aria-labelledby="ui-id-1" aria-controls="tabs-1" tabindex="0" role="tab" class="ui-state-default ui-corner-top ui-tabs-active ui-state-active"><a id="ui-id-1" tabindex="-1" role="presentation" class="ui-tabs-anchor" href="#tabs-1">Popular</a></li>
                                <li aria-selected="false" aria-labelledby="ui-id-2" aria-controls="tabs-2" tabindex="-1" role="tab" class="ui-state-default ui-corner-top"><a id="ui-id-2" tabindex="-1" role="presentation" class="ui-tabs-anchor" href="#tabs-2">Recent</a></li>
                                <li aria-selected="false" aria-labelledby="ui-id-3" aria-controls="tabs-3" tabindex="-1" role="tab" class="ui-state-default ui-corner-top"><a id="ui-id-3" tabindex="-1" role="presentation" class="ui-tabs-anchor" href="#tabs-3"><i class="icon-comments-alt norightmargin"></i></a></li>
                            </ul>

                            <div class="tab-container">

                                <div aria-hidden="false" aria-expanded="true" role="tabpanel" aria-labelledby="ui-id-1" class="tab-content clearfix ui-tabs-panel ui-widget-content ui-corner-bottom" id="tabs-1">
                                    <div id="popular-post-list-sidebar">

                                        <div class="spost clearfix">
                                            <div class="entry-image">
                                                <a href="#" class="nobg"><img class="img-circle" src="images/magazine/small/3.jpg" alt=""></a>
                                            </div>
                                            <div class="entry-c">
                                                <div class="entry-title">
                                                    <h4><a href="#">Debitis nihil placeat, illum est nisi</a></h4>
                                                </div>
                                                <ul class="entry-meta">
                                                    <li><i class="icon-comments-alt"></i> 35 Comments</li>
                                                </ul>
                                            </div>
                                        </div>

                                        <div class="spost clearfix">
                                            <div class="entry-image">
                                                <a href="#" class="nobg"><img class="img-circle" src="images/magazine/small/2.jpg" alt=""></a>
                                            </div>
                                            <div class="entry-c">
                                                <div class="entry-title">
                                                    <h4><a href="#">Elit Assumenda vel amet dolorum quasi</a></h4>
                                                </div>
                                                <ul class="entry-meta">
                                                    <li><i class="icon-comments-alt"></i> 24 Comments</li>
                                                </ul>
                                            </div>
                                        </div>

                                        <div class="spost clearfix">
                                            <div class="entry-image">
                                                <a href="#" class="nobg"><img class="img-circle" src="images/magazine/small/1.jpg" alt=""></a>
                                            </div>
                                            <div class="entry-c">
                                                <div class="entry-title">
                                                    <h4><a href="#">Lorem ipsum dolor sit amet, consectetur</a></h4>
                                                </div>
                                                <ul class="entry-meta">
                                                    <li><i class="icon-comments-alt"></i> 19 Comments</li>
                                                </ul>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <div aria-hidden="true" aria-expanded="false" style="display: none;" role="tabpanel" aria-labelledby="ui-id-2" class="tab-content clearfix ui-tabs-panel ui-widget-content ui-corner-bottom" id="tabs-2">
                                    <div id="recent-post-list-sidebar">

                                        <div class="spost clearfix">
                                            <div class="entry-image">
                                                <a href="#" class="nobg"><img class="img-circle" src="images/magazine/small/1.jpg" alt=""></a>
                                            </div>
                                            <div class="entry-c">
                                                <div class="entry-title">
                                                    <h4><a href="#">Lorem ipsum dolor sit amet, consectetur</a></h4>
                                                </div>
                                                <ul class="entry-meta">
                                                    <li>10th July 2014</li>
                                                </ul>
                                            </div>
                                        </div>

                                        <div class="spost clearfix">
                                            <div class="entry-image">
                                                <a href="#" class="nobg"><img class="img-circle" src="images/magazine/small/2.jpg" alt=""></a>
                                            </div>
                                            <div class="entry-c">
                                                <div class="entry-title">
                                                    <h4><a href="#">Elit Assumenda vel amet dolorum quasi</a></h4>
                                                </div>
                                                <ul class="entry-meta">
                                                    <li>10th July 2014</li>
                                                </ul>
                                            </div>
                                        </div>

                                        <div class="spost clearfix">
                                            <div class="entry-image">
                                                <a href="#" class="nobg"><img class="img-circle" src="images/magazine/small/3.jpg" alt=""></a>
                                            </div>
                                            <div class="entry-c">
                                                <div class="entry-title">
                                                    <h4><a href="#">Debitis nihil placeat, illum est nisi</a></h4>
                                                </div>
                                                <ul class="entry-meta">
                                                    <li>10th July 2014</li>
                                                </ul>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <div aria-hidden="true" aria-expanded="false" style="display: none;" role="tabpanel" aria-labelledby="ui-id-3" class="tab-content clearfix ui-tabs-panel ui-widget-content ui-corner-bottom" id="tabs-3">
                                    <div id="recent-post-list-sidebar">

                                        <div class="spost clearfix">
                                            <div class="entry-image">
                                                <a href="#" class="nobg"><img class="img-circle" src="images/icons/avatar.jpg" alt=""></a>
                                            </div>
                                            <div class="entry-c">
                                                <strong>John Doe:</strong> Veritatis recusandae sunt repellat distinctio...
                                            </div>
                                        </div>

                                        <div class="spost clearfix">
                                            <div class="entry-image">
                                                <a href="#" class="nobg"><img class="img-circle" src="images/icons/avatar.jpg" alt=""></a>
                                            </div>
                                            <div class="entry-c">
                                                <strong>Mary Jane:</strong> Possimus libero, earum officia architecto maiores....
                                            </div>
                                        </div>

                                        <div class="spost clearfix">
                                            <div class="entry-image">
                                                <a href="#" class="nobg"><img class="img-circle" src="images/icons/avatar.jpg" alt=""></a>
                                            </div>
                                            <div class="entry-c">
                                                <strong>Site Admin:</strong> Deleniti magni labore laboriosam odio...
                                            </div>
                                        </div>

                                    </div>
                                </div>

                            </div>

                        </div>

                    </div>




                </div>

            </div><!-- .sidebar end -->

        </div>

    </div>


@endsection


@section('assets-footer')


    <script>

        $(document).ready(function(){

            if (!$('#primary-menu').hasClass("current")) {
                $("li.current").removeClass("current");
                $('#primary-menu').find('li.blog').addClass("current");
            }
        });

    </script>

@endsection