<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>簡易翻譯機</title>
    <meta name="description" content="A stream video player on MEGA.">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css"
          integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">
</head>
<body>
<ul class="nav nav-pills justify-content-center align-items-center" style="height:200px;">
    <li class="nav-item">
        <a class="nav-link h-100 d-inline-block" href="{{route('dict:shanbay:ce')}}">英中</a>
    </li>
    <li class="nav-item">
        <a class="nav-link active h-100 d-inline-block" href="{{route('dict:tianhuo:cj')}}">中日/日中</a>
    </li>
</ul>
<div class="container">

    <div class="row">
        <div class="col-8">
            <form method="get" action="{{route('dict:tianhuo:cj')}}">
                <label for="input_url">
                    快快樂樂學日文 ^____^
                </label>
                <input id="q" class="form-control" type="text" name="q" value="{{$req->q}}" placeholder="word" required>
                <p class="mt-3">
                    <button class="btn btn-primary" type="submit">Search!</button>
                </p>
            </form>
            <hr>

            <div class="jumbotron jumbotron-fluid">
                <div class="container">
                    <h1 class="display-5">
                        {{$req->q}}
                    </h1>
                    <h1 class="display-5">
                        @foreach($resp as $row)
                            <a href="{{route('dict:tianhuo:cj')}}?q={{$row}}">{{$row}}</a>
                        @endforeach
                    </h1>
                    <p class="lead"></p>
                </div>
            </div>

        </div>

        {{--歷史查詢 START--}}
        <div class="col-4">
            <div class="list-group">
                <button type="button" class="list-group-item list-group-item-action active">
                    歷史查詢
                </button>
                @if(count($qHistory) > 0)
                    @foreach($qHistory as $q => $times)
                        <a href="{{route('dict:tianhuo:cj')}}?q={{$q}}" class="list-group-item d-flex justify-content-between align-items-center">
                            {{$q}}
                            <span class="badge badge-primary badge-pill">{{$times}}</span>
                        </a>
                    @endforeach
                @else
                    <li class="list-group-item">請先查詢單字喔 ^___^</li>
                @endif
            </div>
        </div>
        {{--歷史查詢 END--}}

    </div>
</div>


<!--Footer-->
<footer class="page-footer font-small stylish-color-dark pt-4 mt-4">

    <!--Footer Links-->
    <div class="container text-center text-md-left">

        <!-- Footer links -->
        <div class="row text-center text-md-left mt-3 pb-3">

        </div>
        <!-- Footer links -->

        <hr>

        <div class="row py-3 d-flex align-items-center">

            <!--Grid column-->
            <div class="col-md-8 col-lg-8">

                <!--Copyright-->
                <p class="text-center text-md-left grey-text">© 2018 Copyright: <a href="#"><strong>CJ</strong></a></p>
                <!--/.Copyright-->

            </div>
            <!--Grid column-->

            <!--Grid column-->
            <div class="col-md-4 col-lg-4 ml-lg-0">

                <!--Social buttons-->
                <div class="text-center text-md-right">
                    <ul class="list-unstyled list-inline">
                        <li class="list-inline-item"><a class="btn-floating btn-sm rgba-white-slight mx-1"><i class="fa fa-facebook"></i></a></li>
                        <li class="list-inline-item"><a class="btn-floating btn-sm rgba-white-slight mx-1"><i class="fa fa-twitter"></i></a></li>
                        <li class="list-inline-item"><a class="btn-floating btn-sm rgba-white-slight mx-1"><i class="fa fa-google-plus"></i></a></li>
                        <li class="list-inline-item"><a class="btn-floating btn-sm rgba-white-slight mx-1"><i class="fa fa-linkedin"></i></a></li>
                    </ul>
                </div>
                <!--/.Social buttons-->

            </div>
            <!--Grid column-->

        </div>

    </div>

</footer>
<!--/.Footer-->

<script>
    document.getElementById("q").select();
</script>
</body>
</html>