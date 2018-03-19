<!DOCTYPE html>
<html lang="en">
    <head>
        @include('includes.sartre_head')
        @stack('styles')
    </head>

    <body>
        <div class="wrapper reveal-side-navigation">
            <div class="wrapper-inner">
                @include('includes.sartre_header')
                
                <!-- Content -->
                <div class="content clearfix">

                    <!-- Intro Title Section 2 -->
                    <div class="section-block intro-title-2 intro-title-2-4">
                        <div class="row">
                            <div class="column width-12">
                                <div class="title-container">
                                    <div class="title-container-inner center">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Intro Title Section 2 End -->

                    <div class="section-block clearfix no-padding-bottom">
                        <div class="row">

                            <!-- Content Inner -->
                            <div class="column width-10 offset-1 content-inner blog-regular center">
                                <article class="post">
                                    @yield('content')
                                </article>
                            </div>
                            <!-- Content Inner End -->

                        </div>
                    </div>
                    
                </div>
                <!-- Content End -->

                @include('includes.sartre_footer')
            </div>
        </div>

        @stack('scripts')
        @include('includes.sartre_before_body')
    </body>
</html>