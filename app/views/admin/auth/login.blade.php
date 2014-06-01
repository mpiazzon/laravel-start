<!DOCTYPE html>
<!--[if lt IE 7]> <html class="ie lt-ie9 lt-ie8 lt-ie7 app"> <![endif]-->
<!--[if IE 7]>    <html class="ie lt-ie9 lt-ie8 app"> <![endif]-->
<!--[if IE 8]>    <html class="ie lt-ie9 app"> <![endif]-->
<!--[if gt IE 8]> <html class="app"> <![endif]-->
<!--[if !IE]><!--><html class="app"><!-- <![endif]-->
<head>
  <title>Login</title>
  
  <!-- Meta -->
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0">
  <meta name="apple-mobile-web-app-capable" content="yes">
  <meta name="apple-mobile-web-app-status-bar-style" content="black">
  <meta http-equiv="X-UA-Compatible" content="IE=9; IE=8; IE=7; IE=EDGE" />

</head>
    
<h4>Ingreso al Sistema</h4>

    {{ Form::open(array('class' => 'panel-body')) }}
            
              <div class="form-group">
                <label for="">Email</label>
                <div class="widget-body">
                  <div class="input-group">
                    
                    <input id="email" name="email" class="form-control" placeholder="" type="text">
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label for="">Contraseña</label
                <div class="widget-body">
                  <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                    <input id="password" name="password" class="form-control" placeholder="" type="password">
                  </div>
                </div>
              
              <button type="submit" class="btn btn-inverse btn-block"> ENTRAR <i class="fa fa-sign-in"> </i> </button>
           
          
     {{ Form::close() }} 
            
</body>
</html>

