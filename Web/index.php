<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>SchoolSafe Admin</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
        <link rel="stylesheet" href="/css/custom.css">
    </head>
    <body>
        <nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #8C6A38;">
            <a class="navbar-brand text-light" href="#"><img src="./images/schoolsafebar.png" height="50"></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item active">
                        <a class="nav-link" href="#">메인 <span class="sr-only">(현재 페이지)</span></a>
                    </li>
                </ul>
            </div>
        </nav>
        <div class="row vertical-center-row">
            <div class="col-sm-9 card" max-width="660" height="100%">
                <div class="card-header">타임라인</div>
                <ul class="timeline">
                    <li>
                        <div class="media">
                            <i class=" mr-3 fas fa-spinner"></i>
                            <div class="media-body">
                                <h5 class="mt-0">불러오는 중...</h5>
                                데이터를 가져오는 중입니다...
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
            <div class="col-sm-3">
                <div class="card">
                    <div class="card-header">알림 보내기</div>
                        <div class="form-group">
                            <textarea id="alert-input" class="form-control" id="tts" height="300"></textarea>
                        </div>
                        <button id="alert-confirm" class="btn btn-primary"><i class="fas fa-bullhorn"></i> 보내기</button>
                </div>
                <br>
                <h3>실시간 감시</h3>
                <div class="card" id="fire">
                    <div class="card-header"><b>불꽃 센서</b></div>
                    <div class="card-body">
                        <h5 class="card-title"><i class="fas fa-spinner"></i> 데이터 없음</h5>
                        <p class="card-text">교실 내의 불 발생 여부를 감지합니다.</p>
                    </div>
                </div>
                <br>
                <div class="card" id="vive">
                    <div class="card-header"><b>진동 센서</b></div>
                    <div class="card-body">
                        <h5 class="card-title"><i class="fas fa-spinner"></i> 데이터 없음</h5>
                        <p class="card-text">교실 공간에서 진동 발생 여부를 감지합니다.<br>지진이나 큰 울림이 있을 때 감지됩니다.</p>
                    </div>
                </div>
                <br>
                <div class="card" id="sound">
                    <div class="card-header"><b>소리 센서</b></div>
                    <div class="card-body">
                        <h5 class="card-title"><i class="fas fa-spinner"></i> 데이터 없음</h5>
                        <p class="card-text">교실 공간에서 소리 발생 여부를 감지합니다.<br>아주 큰 소리가 있을 때 감지됩니다.</p>
                    </div>
                </div>
            </div>
        </div>
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
        <script>
            $(document).ready(function() {
                updateSensors();
                $('#video').on('load', function(){
                    $('#video').contents().find('img').css("width", "100%");
                    $('#video').contents().find('img').css("height", "100%");
                });
            })
            
            function updateSensors() {
                $.ajax({
                    url: "/sensors.php",
                    type: "post",
                    cache: false,
                    success: function (data) {
                        if(data == "noupdate") {
                            return;
                        }
                        var dummy = "true";
                        var res = data.split(" ");
                        if(res[0] >= 200) {
                            $('#fire').addClass("bg-success");
                            $('#fire').removeClass("bg-danger");
                            $('#fire .card-title').html("<i class=\"fas fa-check\"></i> 안전");
                        } else if(res[0] < 200) {
                            $('#vive').addClass("bg-danger");
                            $('#vive').removeClass("bg-succcess");
                            $('#vive .card-title').html("<i class=\"fas fa-times-circle\"></i> 위험");
                        } else {
                            $('#sound').removeClass("bg-danger");
                            $('#sound').removeClass("bg-succcess");
                            $('#sound .card-title').html("<i class=\"fas fa-spinner\"></i> 데이터 없음");
                        }
                        if(res[2] < 500) {
                            $('#sound').addClass("bg-success");
                            $('#sound').removeClass("bg-danger");
                            $('#sound .card-title').html("<i class=\"fas fa-check\"></i> 조용함");
                        } else if(res[2] > 500) {
                            $('#sound').addClass("bg-danger");
                            $('#sound').removeClass("bg-succcess");
                            $('#sound .card-title').html("<i class=\"fas fa-times-circle\"></i> 시끄러움");
                        } else {
                            $('#sound').removeClass("bg-danger");
                            $('#sound').removeClass("bg-succcess");
                            $('#sound .card-title').html("<i class=\"fas fa-spinner\"></i> 데이터 없음");
                        }
                        if(res[1] >= 200) {
                            $('#vive').addClass("bg-success");
                            $('#vive').removeClass("bg-danger");
                            $('#vive .card-title').html("<i class=\"fas fa-check\"></i> 안전");
                        } else if(res[1] < 200) {
                            $('#vive').addClass("bg-danger");
                            $('#vive').removeClass("bg-succcess");
                            $('#vive .card-title').html("<i class=\"fas fa-times-circle\"></i> 위험");
                        } else {
                            $('#vive').removeClass("bg-danger");
                            $('#vive').removeClass("bg-succcess");
                            $('#vive .card-title').html("<i class=\"fas fa-spinner\"></i> 데이터 없음");
                        }
                    }
                });
                $.ajax({
                    url: "/timeline.php",
                    type: "post",
                    cache: false,
                    success: function (data) {
                        $(".timeline").html(data);
                        console.log(data);
                    },
                    error: function (error) {
                        console.log(error);
                    }
                });
                setTimeout("updateSensors()", 300);
            }

            $("#alert-confirm").click(function() {
                if(!$("#alert-confirm").hasClass("disabled")) {
                    $("#alert-confirm").addClass("disabled");
                    $.ajax({
                        url: "/tts.php",
                        data: {text: $("#alert-input").val()},
                        type: "post",
                        cache: false,
                        success: function (data) {
                            console.log($("#alert-input").val());
                            console.log(data);
                            if(data == "true") {
                                $("#alert-confirm").addClass("btn-success");
                                $("#alert-confirm").removeClass("btn-primary");
                                $("#alert-confirm").removeClass("btn-warning");
                                $("#alert-confirm").removeClass("btn-danger");
                                $("#alert-confirm").html("<i class=\"fas fa-check\"></i> 전송 완료!");
                            } else {
                                $("#alert-confirm").addClass("btn-danger");
                                $("#alert-confirm").removeClass("btn-primary");
                                $("#alert-confirm").removeClass("btn-success");
                                $("#alert-confirm").removeClass("btn-warning");
                                $("#alert-confirm").html("<i class=\"fas fa-times-circle\"></i> 전송 실패!");
                            }
                            setTimeout("restoreButton()", 10000);
                        }
                    });
                }
            })

            function restoreButton() {
                $("#alert-confirm").removeClass("bg-success");
                $("#alert-confirm").removeClass("bg-warning");
                $("#alert-confirm").removeClass("disabled");
                $("#alert-confirm").addClass("bg-primary");
                $("#alert-confirm").html("<i class=\"fas fa-bullhorn\"></i> 보내기");
            }
        </script>
    </body>
</html>
