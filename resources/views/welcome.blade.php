<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" sizes="32x32" href="favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="favicon-16x16.png">
    <title>Red Neuronal</title>
    <script src="https://cdn.jsdelivr.net/npm/@tensorflow/tfjs@2.0.0/dist/tf.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <style>
      #resultado {
        font-weight:  bold;
        font-size:  1.2rem;
        text-align: center;
      }
    </style>

  </head>
  <body>

    <main>
      <div class="container mt-5">
        <div class="row">
          <div class="col-12 col-md-4 offset-md-4">
            <form >
              <div class="mb-3">
                <label for="q1" class="form-label">Estado de la leche: <span id="lbl-celsius">en buen estado</span></label>
                <input type="number" id="q1" value="0">
                <input type="number" id="q2" value="0">
                <input type="number" id="q3" value="0" onclick="cambiarCelsius();">
              </div>
              <div class="mb-3">
                <label for="q1" class="form-label">Resultado</label>
                <div id="resultado1">

                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>



    <script type="text/javascript">
      var modelo = null;
      //Cargar modelo
      (async () => {
          console.log("Cargando modelo...");
          modelo = await tf.loadLayersModel("model.json");
          console.log("Modelo cargado...");
      })();
      function cambiarCelsius() {
        var q1 = document.getElementById("q1").value;
        var q2 = document.getElementById("q2").value;
        var q3 = document.getElementById("q3").value;

        //document.getElementById("lbl-celsius").innerHTML=q1;
        if (modelo != null) {
          var tensor = tf.tensor([[parseInt(q1), parseInt(q2), parseInt(q3)]]);
          var prediccion = modelo.predict(tensor).dataSync();
          prediccion = Math.round(prediccion, 1);
          if (prediccion == 1) {
            document.getElementById("lbl-celsius").innerHTML= "leche en mal estado";
          }else{
            document.getElementById("lbl-celsius").innerHTML="leche en buen estado";
          }
          document.getElementById("resultado1").innerHTML = q1 +" "+ q2 +" "+ q3+ " "+prediccion;
        } else {
          document.getElementById("resultado1").innerHTML = "Intenta de nuevo en un momento...";
        }
      }
    </script>
  </body>
</html>