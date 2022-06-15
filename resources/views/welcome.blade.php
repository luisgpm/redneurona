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
    <div style=" padding: 110px; width: 30%; float: left;">
        <div class="card" >
        <div id="modelo"></div>
        <div id="prediccion"></div>
        <div id="notificacion"></div>
        <div id="resultado"></div>
        </div>
    </div>
    <div style=" padding-top: 90px; padding-left: 50px; width: 70%; float: right;">
        <div id="myPlot" style="width:100%;max-width:700px"> </div>
    </div>
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
    var xArray = {{json_encode($id)}};
    var last;
    {{--var yArray = [7,8,8,9,9,9,10,11,14,14,15];--}}
    var y = {{json_encode($q1)}}
    var y2 = {{json_encode($q2)}}
    var y3 = {{json_encode($q3)}}
    // Define Data
    var datass = [
        {x:xArray, y:y, name:"Q1",  mode:"lines"},
        {x:xArray, y:y2, name:"Q2", mode:"lines"},
        {x:xArray, y:y3, name:"Q3", mode:"lines"}
    ];
    // Define Layout
    var layout = {
        xaxis: {range: [0, 160], title: "Square Meters"},
        yaxis: {range: [50, 500], title: "Price in Millions"},
        title: "House Prices vs. Size"
    };

    Plotly.newPlot("myPlot", datass, layout);

    // Display using Plotly


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

            y.push(parseInt(s.q1));
            y2.push(parseInt(s.q2));
            y3.push(parseInt(s.q3));
            last = xArray.at(-1);
            last++;
            xArray.push(last);
            Plotly.newPlot("myPlot", datass, layout);
            console.log(datass);
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
    {{--var x = {{json_encode($q1)}}--}}


</script>