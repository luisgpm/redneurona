<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://cdn.jsdelivr.net/npm/@tensorflow/tfjs@2.0.0/dist/tf.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="{{asset('css/style.css')}}" rel="stylesheet" type="text/css">
    <script src="https://cdn.plot.ly/plotly-latest.min.js"></script>
    <title>Red Neuronal</title>
</head>
<body>
    <div class="card" >
        <div id="modelo"></div>
        <div id="prediccion"></div>
        <div id="notificacion"></div>
        <div id="resultado"></div>
    </div>
    <div id="myPlot" style="width:100%;max-width:700px"></div>
</body>
</html>
<script>
    window.laravel_echo_port='{{env("LARAVEL_ECHO_PORT")}}';
</script>
<script src="//{{ Request::getHost() }}:{{env('LARAVEL_ECHO_PORT')}}/socket.io/socket.io.js"></script>
<script src="{{ url('/js/laravel-echo-setup.js') }}" type="text/javascript"></script>
<script type="text/javascript">
    var i = 0;
    var modelo = null;
    (async () => {
          console.log("Cargando modelo...");
          modelo = await tf.loadLayersModel("model.json");
          console.log("Modelo cargado...");
      })();
    window.Echo.channel('user-channel')
    .listen('.UserEvent', (data) => {
        i++;
        var s = data.data;
        if (modelo != null) {
            document.getElementById("modelo").innerHTML = "El modelo se cargo";
            var tensor = tf.tensor([[parseInt(s.q1), parseInt(s.q2), parseInt(s.q3)]]);
            var prediccion = modelo.predict(tensor).dataSync();
            prediccion = Math.round(prediccion, 1);
            if (prediccion == 0) {
               document.getElementById("notificacion").innerHTML= "#"+ i+": aire limpio";
            }else{
                if (prediccion == 1) {
                    document.getElementById("notificacion").innerHTML="leche en buen estado";
                }else{
                    if (prediccion ==2 ) {
                        document.getElementById("notificacion").innerHTML = "Leche en mal estado!";
                    }else{
                        document.getElementById("notificacion").innerHTML = "Intenta de nuevo en un momento...";
                    }
                }
            }
        }
        document.getElementById("resultado").innerHTML="q1: "+s.q1+" q2: "+s.q2+" q3: "+s.q3+" resultado: "+ prediccion;
    });
</script>
<script>
var xArray = [50,60,70,80,90,100,110,120,130,140,150];
var yArray = [7,8,8,9,9,9,10,11,14,14,15];

// Define Data
var data = [{
  x:xArray,
  y:yArray,
  mode:"lines"
}];

// Define Layout
var layout = {
  xaxis: {range: [40, 160], title: "Square Meters"},
  yaxis: {range: [5, 16], title: "Price in Millions"},
  title: "House Prices vs. Size"
};

// Display using Plotly
Plotly.newPlot("myPlot", data, layout);
</script>