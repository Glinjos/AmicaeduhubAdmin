@extends('authorizer/authorMaster')

@section('adminpanel')



        {{--<img src="../assets/images/dashboard.jpg" alt="dashboard"  width="1330" height="650">--}}

        <main role="main" class="main-content">
            <div class="container-fluid">
                <div class="row justify-content-center">
                    <div class="col-12">
                        <div class="row align-items-center mb-2">
                            <div class="col">
                                <h2 class="h2 page-title">Welcome  {{session('name')}}</h2>
                            </div>
                           

                        </div>


                    <div class="mb-2 align-items-center">
                        <div class="card shadow mb-4">
                            <div class="card-body">
                                <div class="row mt-1 align-items-center">
                                    {{--<img src="../assets/images/dash.jpg" alt="dashboard"  width="350" height="300">--}}

                                    <div class="col-12 col-lg-4 text-left pl-6">
                                        <img src="../assets/images/learning.png" alt="dashboard"  width="230" height="200"><br>

                                    </div>
                                    <div class="col-12 col-lg-8 text-left pl-8">
                                        <b style="font-size: 25px;color: #0a0c0d;font-family: kumbh-sans">"You can teach a student a lesson for a day, but if you can teach him to learn by creating curiosity, he will continue the learning process as long as he lives."</b>

                                    </div>
                                    {{--<div class="col-6 col-lg-2 text-center py-4 mb-2">--}}
                                        {{--<p class="mb-1 small text-muted">Goal Value</p>--}}
                                        {{--<span class="h3">$260</span><br />--}}
                                        {{--<span class="small text-muted">+6%</span>--}}
                                        {{--<span class="fe fe-arrow-up text-success fe-12"></span>--}}
                                    {{--</div>--}}
                                    {{--<div class="col-6 col-lg-2 text-center py-4">--}}
                                        {{--<p class="mb-1 small text-muted">Completions</p>--}}
                                        {{--<span class="h3">26</span><br />--}}
                                        {{--<span class="small text-muted">+20%</span>--}}
                                        {{--<span class="fe fe-arrow-up text-success fe-12"></span>--}}
                                    {{--</div>--}}
                                    {{--<div class="col-6 col-lg-2 text-center py-4">--}}
                                        {{--<p class="mb-1 small text-muted">Conversion</p>--}}
                                        {{--<span class="h3">6%</span><br />--}}
                                        {{--<span class="small text-muted">-2%</span>--}}
                                        {{--<span class="fe fe-arrow-down text-danger fe-12"></span>--}}
                                    {{--</div>--}}
                                </div >
                                    <div >
                                        {{--<img src="../assets/images/logo.png" alt="dashboard"  width="250" height="200"><br>--}}
                                        {{--<img src="../assets/images/learning.png" alt="dashboard"  width="250" height="200"><br>--}}
{{--<b style="font-size: 25px;color: #0a0c0d;font-family: sans-serif">We help you to achieve your dreams. Come lets have a journey to the success.</b>--}}
                                    </div>

                            </div> <!-- .card-body -->
                        </div> <!-- .card -->
                    </div>

                    </div>
                </div>
            </div>
        </main>


@endsection