@extends('Vitee_Website_Views.index')




@section('slider')


    <section id="slider" class="slider-parallax" style="background: url('Vitee_Website_Assets/images/videos/explore-poster.jpg'); background-size: cover;" data-height-lg="670" data-height-md="500" data-height-sm="400" data-height-xs="250" data-height-xxs="200">
        <div class="container clearfix">
            <div class="vertical-middle center">

                <div class="heading-block nobottomborder center">
                    <h1>
                        <div class="text-rotater" data-separator="|" data-rotate="flipInX" data-speed="3500" style="color : white;">
                            We make your life <span class="t-rotate">Fun|Easy|Awesome</span>
                        </div>
                    </h1>
                </div>

            </div>
        </div>
    </section>




@endsection



@section('content')

    <div class="content-wrap">

        <div class="container clearfix">
            <div class="row clearfix">

                <div class="col-lg-5">
                    <div class="heading-block topmargin">
                        <h1>Welcome to Vitee Platform.<br></h1>
                    </div>
                    <p class="lead"> Android, iOS and even a website version, we want everyone in on the action. <strong>Vitee</strong> is easily accessible to anyone, anywhere and costs absolutely nothing!</p>
                    <p class="lead"> Eliminate tedious searches:
                        No need to spend time searching for what to do this weekend. <strong>Vitee</strong> literally has it planned and mapped out for you.
                    </p>
                </div>

                <div class="col-lg-7">

                    <div style="position: relative; margin-bottom: -60px; height: 426px;" class="ohidden" data-height-lg="426" data-height-md="567" data-height-sm="470" data-height-xs="287" data-height-xxs="183">
                        <img class="fadeInUp animated" src="{{asset('Vitee_Website_Assets/images/about/content/web.png')}}" style="position: absolute; top: 0; left: 0;" data-animate="fadeInUp" data-delay="100" alt="Chrome">
                        {{--<img class="fadeInUp animated" src="{{asset('Vitee_Website_Assets/images/services/main-fmobile.png')}}" style="position: absolute; top: 0; left: 0;" data-animate="fadeInUp" data-delay="400" alt="iPad">--}}
                    </div>

                </div>

            </div>
        </div>


        <div class="section nobottommargin">
            <div class="container clear-bottommargin clearfix">

                <div class="row topmargin-sm clearfix">

                    <div class="col-md-4 bottommargin">
                        <i class="i-plain color i-large icon-search2 inline-block" style="margin-bottom: 15px;"></i>
                        <div class="heading-block nobottomborder" style="margin-bottom: 15px;">
                            <span class="before-heading">Easily Discover Events</span>
                            <h4>Discover </h4>
                        </div>
                        <p>We are all about diversification. Discover covers multiple categories of events.  So whether you’re a foodie, Sports jock, Musician, Party animal, for some reason likes to attend conferences; Discover has something for you. </p>
                    </div>

                    <div class="col-md-4 bottommargin">
                        <i class="i-plain color i-large icon-ticket inline-block" style="margin-bottom: 15px;"></i>
                        <div class="heading-block nobottomborder" style="margin-bottom: 15px;">
                            <span class="before-heading">Support e-Tickets</span>
                            <h4>Tickets</h4>
                        </div>
                        <p>  It’s the 21st century and we’re all lazy, so, buy your tickets on Vitee; easily and definitely safely. We use Pay Tabs to ensure the safety of your transactions. Get your ticket on your phone via email, present it at the venue and your good to go.  </p>
                    </div>

                    <div class="col-md-4 bottommargin">
                        <i class="i-plain color i-large icon-rss inline-block" style="margin-bottom: 15px;"></i>
                        <div class="heading-block nobottomborder" style="margin-bottom: 15px;">
                            <span class="before-heading">Stay Updated</span>
                            <h4>Subscribe</h4>
                        </div>
                        <p> Missed out on the party at your favourite lounge? How about the pool party at your favourite resort? Brunch at your favourite restaurant? Get on Vitee and follow your favourite event organizers and you’ll never have to miss out on events again. </p>
                    </div>

                </div>

            </div>
        </div>


        <div class="container clearfix">

            <div class="col_one_third bottommargin-sm center">
                <img class="fadeInLeft animated" data-animate="fadeInLeft" src="{{asset('Vitee_Website_Assets/images/about/content/explore.png')}}" alt="explore">
            </div>



            <div class="col_two_third bottommargin-sm col_last">

                <div class="heading-block topmargin-sm">
                    <h2>Explore</h2>
                </div>

                <p>No need to drive too far, Explore supports your laziness by letting you know what’s going on nearest you, or as near as you want it to be. Adjust the radius on the map and watch events pop up on your screen</p>

                <div class="heading-block topmargin-sm">
                    <h2>Bookmark</h2>
                </div>

                <p>Too many events happening this weekend? Don’t want to have to go through every category every time? Just bookmark events you’d like to re-visit</p>


            </div>

        </div>



        <div class="section notopmargin nobottommargin">
            <div class="container clearfix">

                <div class="col_half nobottommargin topmargin-lg">

                    <img src="{{asset('Vitee_Website_Assets/images/about/content/discover.png')}}" alt="Discover" class="center-block">

                </div>

                <div class="col_half nobottommargin topmargin-lg col_last">

                    <div class="heading-block topmargin-lg">
                        <h2>Subscriptions</h2>
                        <span>Our App scales beautifully to different Devices.</span>
                    </div>

                    <p>After you’ve subscribed, Vitee personalizes your activity feed. Now you’ll know what’s going on and where, based on your interests.</p>

                    <a href="#" class="button button-border button-rounded button-large button-dark noleftmargin">Discover</a>

                </div>

            </div>
        </div>



        <div class="section dark notopmargin" style="padding-top: 60px;">
            <div class="container clearfix">



                <div class="clear"></div>



                <div class="clear"></div><div class="line"></div>

                <div class="heading-block center">
                    <h2>Looks beautiful on all displays.</h2>
                </div>

                <div style="position: relative; margin-bottom: -60px; height: 415px;" data-height-lg="415" data-height-md="342" data-height-sm="262" data-height-xs="160" data-height-xxs="102">
                    <img class="fadeInUp animated" src="{{asset('Vitee_Website_Assets/images/about/content/web.png')}}" style="position: absolute; top: 0; left: 0;" data-animate="fadeInUp" alt="Chrome">
                    {{--<img class="fadeInUp animated" src="{{asset('Vitee_Website_Assets/images/services/ipad3.png')}}" style="position: absolute; top: 0; left: 0;" data-animate="fadeInUp" data-delay="300" alt="iPad">--}}
                </div>

            </div>
        </div>


        <div class="section">
            <div class="container clearfix">

                <div class="row topmargin-sm">

                    <div class="heading-block center">
                        <h3>Meet Our Team</h3>
                    </div>

                    <div class="col-md-3 col-sm-6 bottommargin">

                        <div class="team">
                            <div class="team-image">
                                <img src="{{asset('Vitee_Website_Assets/images/about/team/siba.jpg')}}" alt="Ahmed Alsaba">
                            </div>
                            <div class="team-desc team-desc-bg">
                                <div class="team-title"><h4>Ahmed Alsaba</h4><span>CEO</span></div>
                                <a href="#" class="social-icon inline-block si-small si-light si-rounded si-facebook">
                                    <i class="icon-facebook"></i>
                                    <i class="icon-facebook"></i>
                                </a>
                                <a href="#" class="social-icon inline-block si-small si-light si-rounded si-email3">
                                    <i class="icon-email3"></i>
                                    <i class="icon-email3"></i>
                                </a>
                            </div>
                        </div>

                    </div>

                    <div class="col-md-3 col-sm-6 bottommargin">

                        <div class="team">
                            <div class="team-image">
                                <img src="{{asset('Vitee_Website_Assets/images/about/team/naz.jpg')}}" alt="Nazar Abubaker">
                            </div>
                            <div class="team-desc team-desc-bg">
                                <div class="team-title"><h4>Nazar Abubaker</h4><span>UI / UX Designer & Founder</span></div>
                                <a href="#" class="social-icon inline-block si-small si-light si-rounded si-facebook">
                                    <i class="icon-facebook"></i>
                                    <i class="icon-facebook"></i>
                                </a>
                                <a href="#" class="social-icon inline-block si-small si-light si-rounded si-email3">
                                    <i class="icon-email3"></i>
                                    <i class="icon-email3"></i>
                                </a>
                            </div>
                        </div>

                    </div>

                    <div class="col-md-3 col-sm-6 bottommargin">

                        <div class="team">
                            <div class="team-image">
                                <img src="{{asset('Vitee_Website_Assets/images/about/team/marcel.jpg')}}" alt="Marcel Mutawa">
                            </div>
                            <div class="team-desc team-desc-bg">
                                <div class="team-title"><h4>Marcel Mutawa</h4><span>Keyboard Warrior & Founder</span></div>
                                <a href="#" class="social-icon inline-block si-small si-light si-rounded si-facebook">
                                    <i class="icon-facebook"></i>
                                    <i class="icon-facebook"></i>
                                </a>
                                <a href="#" class="social-icon inline-block si-small si-light si-rounded si-email3">
                                    <i class="icon-email3"></i>
                                    <i class="icon-email3"></i>
                                </a>
                            </div>
                        </div>

                    </div>

                    <div class="col-md-3 col-sm-6 bottommargin">

                        <div class="team">
                            <div class="team-image">
                                <img src="{{asset('Vitee_Website_Assets/images/about/team/mahmood.jpg')}}" alt="Nix Maxwell">
                            </div>
                            <div class="team-desc team-desc-bg">
                                <div class="team-title"><h4>Mahmood Marzooq</h4><span>Keyboard Warrior</span></div>
                                <a href="#" class="social-icon inline-block si-small si-light si-rounded si-facebook">
                                    <i class="icon-facebook"></i>
                                    <i class="icon-facebook"></i>
                                </a>
                                <a href="#" class="social-icon inline-block si-small si-light si-rounded si-email3">
                                    <i class="icon-email3"></i>
                                    <i class="icon-email3"></i>
                                </a>
                            </div>
                        </div>

                    </div>

                    <div class="col-md-3 col-sm-6 bottommargin">

                        <div class="team">
                            <div class="team-image">
                                <img src="{{asset('Vitee_Website_Assets/images/about/team/hoomam.jpg')}}" alt="Hoomam Makarem">
                            </div>
                            <div class="team-desc team-desc-bg">
                                <div class="team-title"><h4>Hoomam Makarem</h4><span>Keyboard Warrior</span></div>
                                <a href="#" class="social-icon inline-block si-small si-light si-rounded si-facebook">
                                    <i class="icon-facebook"></i>
                                    <i class="icon-facebook"></i>
                                </a>

                                <a href="#" class="social-icon inline-block si-small si-light si-rounded si-email3">
                                    <i class="icon-email3"></i>
                                    <i class="icon-email3"></i>
                                </a>
                            </div>
                        </div>

                    </div>

                    <div class="col-md-3 col-sm-6 bottommargin">

                        <div class="team">
                            <div class="team-image">
                                <img src="{{asset('Vitee_Website_Assets/images/about/team/issam.jpg')}}" alt="Issam Ben">
                            </div>
                            <div class="team-desc team-desc-bg">
                                <div class="team-title"><h4>Issam Ben</h4><span>Keyboard Warrior</span></div>
                                <a href="#" class="social-icon inline-block si-small si-light si-rounded si-facebook">
                                    <i class="icon-facebook"></i>
                                    <i class="icon-facebook"></i>
                                </a>

                                <a href="#" class="social-icon inline-block si-small si-light si-rounded si-email3">
                                    <i class="icon-email3"></i>
                                    <i class="icon-email3"></i>
                                </a>
                            </div>
                        </div>

                    </div>

                    <div class="col-md-3 col-sm-6 bottommargin">

                        <div class="team">
                            <div class="team-image">
                                <img src="{{asset('Vitee_Website_Assets/images/about/team/sara.jpg')}}" alt="Sarah Tarada">
                            </div>
                            <div class="team-desc team-desc-bg">
                                <div class="team-title"><h4>Sarah Tarada</h4><span>Marketing Guru</span></div>
                                <a href="#" class="social-icon inline-block si-small si-light si-rounded si-facebook">
                                    <i class="icon-facebook"></i>
                                    <i class="icon-facebook"></i>
                                </a>
                                <a href="#" class="social-icon inline-block si-small si-light si-rounded si-email3">
                                    <i class="icon-email3"></i>
                                    <i class="icon-email3"></i>
                                </a>
                            </div>
                        </div>

                    </div>

                </div>

            </div>
        </div>







{{--
        <div class="section notopmargin notopborder">
            <div class="container clearfix">
                <div class="heading-block center nomargin">
                    <h3>Latest from the Blog</h3>
                </div>
            </div>
        </div>

        <div class="container clear-bottommargin clearfix">
            <div class="row">

                <div class="col-md-3 col-sm-6 bottommargin">
                    <div class="ipost clearfix">
                        <div class="entry-image">
                            <a href="#"><img style="opacity: 1;" class="image_fade" src="images/magazine/thumb/1.jpg" alt="Image"></a>
                        </div>
                        <div class="entry-title">
                            <h3><a href="blog-single.html">Bloomberg smart cities; change-makers economic security</a></h3>
                        </div>
                        <ul class="entry-meta clearfix">
                            <li><i class="icon-calendar3"></i> 13th Jun 2014</li>
                            <li><a href="blog-single.html#comments"><i class="icon-comments"></i> 53</a></li>
                        </ul>
                        <div class="entry-content">
                            <p>Prevention effect, advocate dialogue rural development lifting people up community civil society. Catalyst, grantees leverage.</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-3 col-sm-6 bottommargin">
                    <div class="ipost clearfix">
                        <div class="entry-image">
                            <a href="#"><img style="opacity: 1;" class="image_fade" src="images/magazine/thumb/2.jpg" alt="Image"></a>
                        </div>
                        <div class="entry-title">
                            <h3><a href="blog-single.html">Medicine new approaches communities, outcomes partnership</a></h3>
                        </div>
                        <ul class="entry-meta clearfix">
                            <li><i class="icon-calendar3"></i> 24th Feb 2014</li>
                            <li><a href="blog-single.html#comments"><i class="icon-comments"></i> 17</a></li>
                        </ul>
                        <div class="entry-content">
                            <p>Cross-agency coordination clean water rural, promising development turmoil inclusive education transformative community.</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-3 col-sm-6 bottommargin">
                    <div class="ipost clearfix">
                        <div class="entry-image">
                            <a href="#"><img style="opacity: 1;" class="image_fade" src="images/magazine/thumb/3.jpg" alt="Image"></a>
                        </div>
                        <div class="entry-title">
                            <h3><a href="blog-single.html">Significant altruism planned giving insurmountable challenges liberal</a></h3>
                        </div>
                        <ul class="entry-meta clearfix">
                            <li><i class="icon-calendar3"></i> 30th Dec 2014</li>
                            <li><a href="blog-single.html#comments"><i class="icon-comments"></i> 13</a></li>
                        </ul>
                        <div class="entry-content">
                            <p>Micro-finance; vaccines peaceful contribution citizens of change generosity. Measures design thinking accelerate progress medical initiative.</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-3 col-sm-6 bottommargin">
                    <div class="ipost clearfix">
                        <div class="entry-image">
                            <a href="#"><img style="opacity: 1;" class="image_fade" src="images/magazine/thumb/4.jpg" alt="Image"></a>
                        </div>
                        <div class="entry-title">
                            <h3><a href="blog-single.html">Compassion conflict resolution, progressive; tackle</a></h3>
                        </div>
                        <ul class="entry-meta clearfix">
                            <li><i class="icon-calendar3"></i> 15th Jan 2014</li>
                            <li><a href="blog-single.html#comments"><i class="icon-comments"></i> 54</a></li>
                        </ul>
                        <div class="entry-content">
                            <p>Community health workers best practices, effectiveness meaningful work The Elders fairness. Our ambitions local solutions globalization.</p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
--}}



    </div>


@endsection


@section('assets-footer')


    <script>

        $(document).ready(function(){



            if (!$('#primary-menu').hasClass("current")) {
                $("li.current").removeClass("current");
                $('#primary-menu').find('li.about-us').addClass("current");
            }
        });



    </script>

    @endsection
