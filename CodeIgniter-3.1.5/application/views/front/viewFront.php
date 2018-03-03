<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Prefsystems</title>
        <link href="/assets/bootstrap-3.3.7/css/bootstrap.min.css" rel="stylesheet">
        <link href="/assets/jGrowl/jquery.jgrowl.min.css" rel="stylesheet">
        <link href="/assets/css/global.css" rel="stylesheet">
        <link href="/assets/css/table.css" rel="stylesheet">
        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
                <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js" type="text/javascript"></script>
                <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js" type="text/javascript"></script>
        <![endif]-->
    </head>
    <body>
        <div class="container-fluid">

            <div id="welcome">
                <div class="text-center">
                    <img id="logo" class="img img-rounded" src="/images/logo.jpg" />
                </div>
                <h1 class="text-center">Welcome to Preferance Club!!!</h1>
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                        <button class="btn btn-success btn-block" onclick="$.php('login')">
                            Sign in
                        </button>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                        <button class="btn btn-warning btn-block" onclick="$.php('registration')">
                            Sign up
                        </button>
                    </div>
                </div>
            </div>
            
            <div id="app"></div>
        </div>
        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title" id="myModalLabel">Modal title</h4>
                    </div>
                    <div class="modal-body"></div>
                </div>
            </div>
        </div>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js" type="text/javascript"></script>
        <script src="/assets/bootstrap-3.3.7/js/bootstrap.min.js" type="text/javascript"></script>
        <script src="/assets/jquery/jquery-php.js" type="text/javascript"></script>
        <script src="/assets/jquery/jquery.backstretch.min.js" type="text/javascript"></script>
        <script src="/assets/jquery/jquery.fittext.js" type="text/javascript"></script>
        <script src="/assets/jGrowl/jquery.jgrowl.min.js" type="text/javascript"></script>
        <script src="/assets/js/front/kickstarter.js" type="text/javascript"></script>
    </body>
</html>